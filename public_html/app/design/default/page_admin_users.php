<?php
namespace web;

if (!\TSUser::is_logged_in()) {
    die("not logged in");
    exit;
}

if (!\TSUser::is_admin()) {
    die("not allowed");
}

$db = new \SQL(1);
$rows = $db->cmdrows('SELECT id, name FROM ts_user_groups_details WHERE 1', array());
$groups = array();
foreach ($rows as $row) $groups[$row["id"]] = $row["name"];

if (!empty($_REQUEST["ajax"]) AND $_REQUEST["ajax"] == "edit") {
    $row = $db->cmdrow('SELECT * FROM users WHERE id = "{0}" LIMIT 0,1', array($_REQUEST["id"]));
    echo('<INPUT type="hidden" name="act" value="save"/>');
    echo('<INPUT type="hidden" name="id" value="'.$row["id"].'"/>');
    echo('<div>Vorname:</div><div><INPUT type="text" class="form-control" name="prename" value="'.htmlattr($row["prename"]).'" autocomplete="off"/></div>');
    echo('<div>Nachname:</div><div><INPUT type="text" class="form-control" name="lastname" value="'.htmlattr($row["lastname"]).'" autocomplete="off"/></div>');
    echo('<div>E-Mail:</div><div><INPUT type="email" class="form-control" name="email" value="'.htmlattr($row["email"]).'" autocomplete="off"/></div>');
    echo('<div>Passwort:</div><div><INPUT type="password" class="form-control" name="password" value="" PLACEHOLDER="Passwort ändern" autocomplete="off"/></div>');
    echo('<hr/>');
    echo('<table>');
    echo('<tr><td>gültig bis</td><td></td><td><INPUT type="text" name="ts2_active_until" placeholder="Ablaufdatum"/></td></tr>');
    echo('<tr><td>AllAccess</td><td><INPUT type="checkbox" name="ts2_allaccess" value="1"/></td><td></td></tr>');
    foreach ($groups as $k => $v) {
        echo('<tr><td>'.$v.'</td><td><INPUT type="checkbox" name="group'.$k.'" value="1"/></td><td><INPUT type="text" name="group'.$k.'_until" value="" PLACEHOLDER="gültig bis"/></td></tr>');
    }
    echo('</table>');
    exit;
}

if (!empty($_REQUEST["act"]) AND $_REQUEST["act"] == "save") {
    $w = array();
    $w["id"] = $_POST["id"];
    $w["prename"] = $_POST["prename"];
    $w["lastname"] = $_POST["lastname"];
    $w["email"] = $_POST["email"];
    if (!empty($_POST["password"])) $w["password"] = md5("DanceTube".$w["id"].$_POST["password"]);
    $db->Update("users", $w, "id");
    if (!$db->success) die("Fehler beim speichern (users)...");
}

if (!empty($_REQUEST["act"]) AND $_REQUEST["act"] == "adduser") {
    $w = array();
    $w["email"] = $_REQUEST["email"];
    $w["prename"] = $_REQUEST["prename"];
    $w["lastname"] = $_REQUEST["lastname"];
    $w["password"] = "start123";
    $w["ts2_allaccess"] = (($_REQUEST["allaccess"] ?? "") == "1"?'1':'0');
    $db->Create("users", $w);
    $id = $db->lastid;

    if ($id > 0) {
        $db->cmd('UPDATE users SET `password` = MD5(CONCAT("DanceTube",{0},"start123")) WHERE id = "{0}" LIMIT 1', array($id));
        if (!empty($_REQUEST["group1"]) AND $_REQUEST["group1"] == 1) {
            $db->Create("ts_user_groups", array("user_id" => $id, "ts_id" => 2, "group_id" => 1));
        }
        if (!empty($_REQUEST["group2"]) AND $_REQUEST["group2"] == 1) {
            $db->Create("ts_user_groups", array("user_id" => $id, "ts_id" => 2, "group_id" => 2));
        }
    } else die("kein User angelegt");
    $msg1_success = "User angelegt...";

}

PageEngine::html("ts_vintageclub/header");
?>

<main>
<h1 class="mt-4" style="font-size:2rem; font-weight:normal;">Benutzerverwaltung</h1>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>

<table id="list01" class="table table-striped">
<thead><tr>
<th></th>
<th>Vorname</th>
<th>Nachname</th>
<th>AllAccess</th>
<th>Gruppen</th>
<th></th>
<th></th>
</tr></thead>
<tbody>
<?php


$rows = $db->cmdrows('SELECT *, (SELECT GROUP_CONCAT(group_id SEPARATOR ",") FROM ts_user_groups WHERE user_id=users.id) as groups FROM users WHERE 1');
foreach ($rows as $row) {
    echo('<tr>');
    echo('<td><span class="d-none">'.$row["id"].'</span></td>');
    echo('<td>'.$row["prename"].'</td>');
    echo('<td>'.$row["lastname"].'</td>');
    if ($row["ts2_allaccess"] == 1) echo('<td class="text-center2"><i class="fas fa-check text-success fa-2x"></i></td>'); else echo('<td class="text-center2"><i class="fas fa-times text-danger fa-2x"></i></td>');
    echo('<td>');
    if (!empty($row["groups"])) {
    $g = explode(",", $row["groups"]);
    foreach ($g as $a) echo('<span class="badge badge-info mr-1 mb-1">'.(!empty($groups[$a])?html($groups[$a]):'Gruppe'.$a).'</span>');
    }
    echo('</td>');
    echo('<td data-value="'.$row["dt_lastlogin"].'">'.$row["dt_lastlogin"].'</td>');
    
    echo('<td><button class="btn btn-outline-secondary" type="button" data-action="edit" data-id="'.$row["id"].'"><i class="far fa-edit"></i></button></</td>');
    echo('</tr>');
}
?>
</tbody>
</table>

<script>
$(document).ready(function() {
    $('#list01').DataTable({
        /*"order": [[ 3, "desc" ]],*/
        "pageLength": 25
    });

    $(document).on("click", "[data-action='edit']",function() {
      $("#ModalEdit").modal("show");
      $("#ModalEdit .modal-body").html('<div class="text-center"><i class="fas fa-spin fa-spinner text-muted"></i></div>');
      $.post("?ajax=edit", { id: $(this).data("id") }, function(html) {
        $("#ModalEdit .modal-body").html(html);
      });
    });
});

</script>

<div class="container">
<form method="POST"><INPUT type="hidden" name="act" value="adduser"/>
<div class="card">
<div class="card-header">Neuen User anlegen:</div>
<div class="card-body">
<?php
if (!empty($msg1_success)) echo('<div class="alert alert-success">'.html($msg1_success).'</div>');
if (!empty($msg1_error)) echo('<div class="alert alert-danger">'.html($msg1_error).'</div>');
?>
<INPUT type="email" class="form-control" name="email" placeholder="test@test.de" autocomplete="off"/>

<INPUT type="text" class="form-control" name="prename" placeholder="prename" autocomplete="off"/>
<INPUT type="text" class="form-control" name="lastname" placeholder="lastname" autocomplete="off"/>
<div>Passwort: start123</div>

<hr/>
<div><label><INPUT type="checkbox" name="allaccess" value="1"/> All Access</label></div>

<?php
foreach ($groups as $k => $v) echo('<div><label><INPUT type="checkbox" name="group'.$k.'" value="1"/> '.html($v).' (Gruppe '.$k.')</label></div>');
?>


</div>
<div class="card-footer"><button class="btn btn-primary">anlegen</button></div>
</div></form>
</div>

</main>


<form method="POST">
<div id="ModalEdit" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Benutzer editieren</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">speichern</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
      </div>
    </div>
  </div>
</div>
</form>


<?php
PageEngine::html("ts_vintageclub/footer");