<?php
namespace web;

if (!\TSUser::is_logged_in()) {
    die("not logged in");
    exit;
}

if (!\TSUser::is_admin()) {
    die("not allowed");
}

PageEngine::html("ts_vintageclub/header");
?>

<main>
<h1 class="mt-4" style="font-size:2rem; font-weight:normal;">Videomanagement</h1>

<table class="table table-striped">
<thead><tr>
<th>id</th>
<th></th>
<th>Titel</th>
<th>Settings</th>
<th></th>
</tr></thead>
<tbody>
<?php
$db = new \SQL(1);
$rows = $db->cmdrows('SELECT * FROM videoscorona WHERE ts_id = 2');
foreach ($rows as $row) {
    echo('<tr>');
    echo('<td>'.$row["id"].'</td>');
    echo('<td><img src="/media/'.$row["id"].'.jpg?w=100" style="height: 2rem;"/></td>');
    echo('<td class="text-ellipsis"><a href="/de/videos/'.$row["id"].'_video" TARGET="_blank"><b>'.html($row["title_de"]).'</b></a></td>');
    echo('<td>');
    echo('<span class="badge badge-info">member</span>');
    echo('</td>');
    echo('<td><button class="btn btn-outline-secondary" type="button"><i class="far fa-edit"></i></button></</td>');
    echo('</tr>');
}
?>
</tbody>
</table>

</main>
<?php
PageEngine::html("ts_vintageclub/footer");