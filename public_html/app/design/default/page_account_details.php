<?php
$db = new DB(0);

if (!MyUser::is_loggedin()) {
    PageEngine::html("goto", array("url" => "/login"));
    exit;
}

$user = MyUser::user();

if (!empty($_POST["act"]) AND $_POST["act"] == "changepassword") {
  $info = $db->cmdrow('SELECT * FROM users WHERE id = "{0}" LIMIT 0,1', array(\TSUser::id()));
  if ($_POST["pwd2"] != $_POST["pwd3"]) $msg1_error = "Passwortwiederholung stimmt nicht."; 
  elseif(md5("DanceTube".$info["id"].$_POST["pwd1"]) != $info["password"]) $msg1_error = "bisheriges PAsswort stimmt nicht"; 
  else {
    $db->cmd('UPDATE users SET password="{1}" WHERE id ="{0}" LIMIT 1', array(\TSUser::id(),md5("DanceTube".$info["id"].trim($_POST["pwd2"]))));
  $msg1_success = "Passwort geändert...";
  }
}

if (!$user->exists) { PageEngine::html("page_404"); exit; }

PageEngine::html("header");
?>

<main>
  <div class="container pt-4">
    <h1 style="font-size: 2.5rem; font-weight:normal;"><i class="far fa-user"></i> <?=html($info["prename"]." ".$info["lastname"]); ?></h1>

    <div class="my-4">
      <b>Lizenzen:</b><br/>
      <?php
if ($info["ts2_allaccess"] == 1) echo('<div class="text-success">All-Access: <i class="far fa-check"></i> ja</div>'); else echo('<div class="text-muted">All-Access: <i class="far fa-times"></i> nein</div>');
      ?>
    </div>


    <form method="POST">
    <INPUT type="hidden" name="act" value="changepassword"/>
    <div class="card my-4">
      <div class="card-header" style="font-size:1.5rem;">Passwort ändern</div>
      <div class="card-body">

<?php
if (!empty($msg1_success)) echo('<div class="alert alert-success">'.html($msg1_success).'</div>');
if (!empty($msg1_error)) echo('<div class="alert alert-danger">'.html($msg1_error).'</div>');
?>

        <div class="form-group row">
          <label for="inputEmail1" class="col-sm-2 col-form-label">bisher:</label>
          <div class="col-sm-10">
            <input type="password" class="form-control" name="pwd1" id="inputEmail1" REQUIRED placeholder="bisheriges Passwort">
          </div>
        </div>

        <div class="form-group row">
          <label for="inputEmail2" class="col-sm-2 col-form-label">neu:</label>
          <div class="col-sm-10">
            <input type="password" class="form-control" name="pwd2" id="inputEmail2" REQUIRED placeholder="neues Passwort">
          </div>
        </div>

        <div class="form-group row">
          <label for="inputEmail3" class="col-sm-2 col-form-label">Wiederholung:</label>
          <div class="col-sm-10">
            <input type="password" class="form-control" name="pwd3" id="inputEmail3" REQUIRED placeholder="neues Passwort">
          </div>
        </div>

      </div>
      <div class="card-footer"><button class="btn btn-primary">Passwort ändern</button></div>
    </div>
    </form>




  </div>
</main>



<?php
PageEngine::html("footer");