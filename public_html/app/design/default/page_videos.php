<?php
if (!MyUser::is_loggedin()) {
  header("Location: /".$_ENV["lang"]."/login");
  exit;
}

$db = new \DB(0);
$sql = 'SELECT * FROM videos WHERE 1';
//if (!MyUser::user()->is_allaccess) $sql .= ' AND (SELECT 1 FROM videos_groups WHERE video_id = id AND group_id IN (SELECT group_id FROM ts_user_groups WHERE user_id = "'.(MyUser::user()->id).'")) ';
$sql .= ' AND (NOW() BETWEEN IFNULL(enabled_from, "1900-01-01") AND IFNULL(enabled_to, "3000-01-01")) LIMIT 0,100';



$rows = $db->cmdrows($sql);

$filter_dances = array();
$filter_level = array();
$filter_blocks = array();
foreach ($rows as $row) {
  if (!empty($row["dance"])) $filter_dances[$row["dance"]] = $row["dance"];
  if (!empty($row["level"])) $filter_level[$row["level"]] = $row["level"];
  if (!empty($row["block"])) $filter_blocks[$row["block"]] = $row["block"];
}

sort($filter_level);

$is_filter_active = (!empty($_GET["dance"]));

$sql = 'SELECT videos.*,COALESCE(T2.title,T3.title) as title, COALESCE(T2.description,T3.description) as description FROM videos 
  LEFT JOIN videos_texts as T2 ON T2.video_id=videos.id AND T2.lang = "de"
  LEFT JOIN videos_texts as T3 ON T3.video_id=videos.id AND T3.lang = "en"
   WHERE 1';
//if (!MyUser::user()->is_allaccess) $sql .= ' AND (SELECT 1 FROM videos_groups WHERE video_id = id AND group_id IN (SELECT group_id FROM ts_user_groups WHERE user_id = "'.(MyUser::user()->id).'")) ';
$sql .= ' AND (NOW() BETWEEN IFNULL(enabled_from, "1900-01-01") AND IFNULL(enabled_to, "3000-01-01")) ';
if (!empty($_GET["dance"])) $sql .= ' AND dance = "'.$db->convtxt($_GET["dance"]).'" ';
if (!empty($_GET["level"])) $sql .= ' AND level = "'.$db->convtxt($_GET["level"]).'" ';
if (!empty($_GET["block"])) $sql .= ' AND block = "'.$db->convtxt($_GET["block"]).'" ';
if (!empty($_GET["q"])) $sql .= ' AND (MATCH (title_de) AGAINST ("'.$db->convtxt($_GET["q"]).'") OR title_de LIKE "%'.$db->convtxt($_GET["q"]).'%")';

switch ($_GET["sort"] ?? "newest") {
  case "az": $sql .= ' ORDER BY title_de ASC'; break;
  case "za": $sql .= ' ORDER BY title_de DESC'; break;
  case "oldest": $sql .= ' ORDER BY id ASC'; break;
  case "favs": $sql .= ' ORDER BY RAND()'; break;
  case "viewed": $sql .= ' ORDER BY RAND()'; break;
  case "comments": $sql .= ' ORDER BY RAND()'; break;
  case "longest": $sql .= ' ORDER BY duration_sec DESC'; break;
  
  default:
  case "newest": $sql .= ' ORDER BY id DESC'; break;
}


$rows = $db->cmdrows($sql);


PageEngine::html("header", array("search" => $_GET["q"] ?? ""));
?>
<main>
<div class="container">
<div class="row">
<div class="col-12">
<div class="bg-light mt-4 py-1 px-2 border">
<table class="table-striped">
<?php
if (count($filter_dances) > 1) {
  echo('<tr class="align-top"><th>Tanz:</th><td>');
  foreach ($filter_dances as $row) echo('<a class="btn btn-sm '.(($_GET["dance"]??"")==$row?'btn-warning':"btn-outline-secondary").' mb-2 mr-1" href="'.URL2::addVar(array("dance" => $row)).'">'.html($row).'</a>');
  echo('</td></tr>');
}
if (count($filter_level) > 1) {
  echo('<tr class="align-top"><th>Level:</th><td>');
  foreach ($filter_level as $row) echo('<a class="btn btn-sm '.(($_GET["level"]??"")==$row?'btn-warning':"btn-outline-secondary").' mb-2 mr-1" href="'.URL2::addVar(array("level" => $row)).'">Level '.html($row).'</a>');
  echo('</td></tr>');
}
if (count($filter_level) > 1) {
  echo('<tr class="align-top"><th>Block:</th><td>');
  foreach ($filter_blocks as $row) echo('<a class="btn btn-sm '.(($_GET["block"]??"")==$row?'btn-warning':"btn-outline-secondary").' mb-2 mr-1" href="'.URL2::addVar(array("block" => $row)).'">Level '.html($row).'</a>');
  echo('</td></tr>');
}

$sort = $_GET["sort"] ?? "newest";
?>
  <tr><th>Sortierung:</th><td>
    <a class="btn btn-sm <?=($sort == "newest"?'btn-warning':"btn-outline-secondary"); ?> mb-2 mr-1" href="<?=URL2::AddVar(array("sort" => "newest")); ?>">Neueste Videos</a>
    <a class="btn btn-sm <?=($sort == "oldest"?'btn-warning':"btn-outline-secondary"); ?> mb-2 mr-1" href="<?=URL2::AddVar(array("sort" => "oldest")); ?>">Älteste Videos</a>
    <a class="btn btn-sm <?=($sort == "az"?'btn-warning':"btn-outline-secondary"); ?> mb-2 mr-1" href="<?=URL2::AddVar(array("sort" => "az")); ?>">A-Z</a>
    <a class="btn btn-sm <?=($sort == "za"?'btn-warning':"btn-outline-secondary"); ?> mb-2 mr-1" href="<?=URL2::AddVar(array("sort" => "za")); ?>">Z-A</a>
    <!--<a class="btn btn-sm btn-outline-secondary mb-2 mr-1" href="<?=URL2::AddVar(array("sort" => "favs")); ?>">Beliebteste Videos</a>
    <a class="btn btn-sm btn-outline-secondary mb-2 mr-1" href="<?=URL2::AddVar(array("sort" => "viewed")); ?>">Meist geschaute Videos</a>
    <a class="btn btn-sm btn-outline-secondary mb-2 mr-1" href="<?=URL2::AddVar(array("sort" => "comments")); ?>">Meist kommentierte Videos</a>-->
    <a class="btn btn-sm btn-outline-secondary mb-2 mr-1" href="<?=URL2::AddVar(array("sort" => "longest")); ?>">Längste Videos</a>
  </td></tr>





</table>

 
</span>


</div>

<section class="mt-2 mb-4">
    <div class="row">

<?php

if (count($rows) == 0) {
echo('<div class="col py-4 text-center text-muted"><div><i class="fad fa-empty-set fa-3x"></i></div><i>Du hast keine freigeschalteten Videos.<div><small>Wenn Du denkst, dass dies ein Fehler ist, dann wende Dich bitte and den VintageClub oder ändere Deine Filter.</small></div></i></div>');
}

foreach ($rows as $row) {
    echo('<div class="VideoItem col-12 col-sm-6 col-md-4 mb-4">
	<div class="head text-ellipsis d-none">
<!--<span class="badge badge-info" style="background: #E65100;">Turnier</span>-->
<b title="'.htmlattr($row["title"]).'">'.html($row["title"]).'</b></div>
        <a href="/'.$_ENV["lang"].'/videos/'.$row["id"].'_video" class="thumb"><div style="border: 1px solid #ddd; box-shadow: 0 1px 2px rgba(0,0,0,0.075); padding: 4px; border-radius: 4px;"><div style="position: relative; width: 100%; height: 0px; padding-bottom: 56.25%;">
        <img src="/media/'.$row["id"].'.jpg?w=600" srcset="/media/'.$row["id"].'.jpg?w=300 300w, /media/'.$row["id"].'.jpg?w=450 450w, /media/'.$row["id"].'.jpg?w=600 600w" style="position: absolute; display: block; left: 0; top:0; width:100%; height:100%; object-fit: cover;"/>
            <span class="PlayButton" style=""></span>');
if (!empty($row["duration_sec"])) echo('<span class="play_duration">'.floor($row["duration_sec"]/60).':'.str_pad($row["duration_sec"] % 60,2,"0",STR_PAD_LEFT).'</span>');
			
        echo('</div></div></a>
        <div class="foot" text-ellipsis>
        <b title="'.htmlattr($row["title"]).'">'.html($row["title"]).'</b>
        </div>
		<div class="foot text-ellipsis d-none"><button onclick="alert(\'not implemented yet\');" class="btn btn-success btn-sm disabled d-none" style="float:right"><i class="fas fa-plus-circle"></i> Sammlung</button>
<a href="/de/dancer/205-Emeline_Rochefeuille/">Emeline Rochefeuille</a>, <a href="/de/dancer/516-Christian_Kaller/">Christian Kaller</a>		</div>
</div>');
}
?>
    



    </div>
</section>

</div>
    <div class="d-none col-12 col-sm-3">
    <div class="card mt-4">
    <div class="card-header">Playlisten</div>
    <div class="card-body">
<?php    
$raws = $db->cmdrows('SELECT * FROM playlistscorona WHERE 1');
foreach ($raws as $row) {
  echo('<div class="mb-2"><a href="#">'.html($row["name"]).'</a></div>');
}

    
?>
    </div>
    </div>
    </div>
    </div>

</div>
</main>
<?php
PageEngine::html("footer");