<?php

namespace web;

if (!\TSUser::is_logged_in()) {
  header("Location: /".$_ENV["lang"]."/login");
  exit;
}

$v = new \TSVideo("id", $params["id"]+0);
if (!$v->exists) die("404");

if (!\TSUser::is_allaccess() AND !$v->user_has_access(\TSUser::id()) AND !\TSUser::is_admin()) die("403 Das Video ist nicht für Dich freigeschaltet...");

$db = new \SQL(1);
$info = $db->cmdrow('SELECT * FROM videoscorona WHERE id = "{0}" LIMIT 0,1', array($params["id"]));

if (!empty($_POST["act"]) AND $_POST["act"] == "sendquestion") {
  mail("investmentinformatiker@gmail.com", "Frage zu Vintage Corona Video ".$v->id."_".\TSUser::id(), var_export($_POST,true)."User:".\TSUser::id().PHP_EOL."Video:".$v->id);
  //mail("Info@hepcatclub.com", "Frage zu TS Corona Video ".$v->id."_".\TSUser::id(), var_export($_POST,true)."User:".\TSUser::id().PHP_EOL."Video:".$v->id);
  $msg1_success = "Deine Frage wurde gesendet...";
}


$until = round((time()+7200)/3600)*3600;

PageEngine::html("ts_vintageclub/header");
?>
<link href="https://vjs.zencdn.net/7.6.6/video-js.css" rel="stylesheet" />
<script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>


<main>
  <script>
$(document).ready(function(){
   $('#my-video').bind('contextmenu',function() { return false; });
});
</script>
    <section style="background:#000;">
        <div class="container">
        <div class="embed-responsive embed-responsive-16by9">
            <div id="player" class="embed-responsive-item">
            <video
    id="my-video"
    class="video-js"
    controls
    preload="auto"
    poster="/media/<?=$info["id"]; ?>.jpg"
    data-setup='{ "playbackRates": [0.25, 0.5,  1.0, 1.5, 2.0]}'

    style="width:100%; height:100%;"
  >

  <?php
  if (file_exists($v->file_local_mp4)) echo('<source src="/media/'.$info["id"].'.mp4?token='.substr(md5($info["id"]."mp4".$until),0,20).'&until='.$until.'" type="video/mp4" />');
  if (file_exists($v->file_local_webm)) echo('<source src="/media/'.$info["id"].'.webm?token='.substr(md5($info["id"]."webm".$until),0,20).'&until='.$until.'" type="video/webm" />');

  ?>
    <p class="vjs-no-js">
      To view this video please enable JavaScript, and consider upgrading to a
      web browser that
      <a href="https://videojs.com/html5-video-support/" target="_blank"
        >supports HTML5 video</a
      >
    </p>
  </video>
  <style>
      .video-js .vjs-big-play-button { position: absolute; left: 45%; top:45%; }
    </style>



            </div>
            </div>
        </div>
    </section>

    <section class="mt-4" style="margin-bottom: 10rem;">
        <div class="container">
            <h1 style="font-size:2rem; font-weight: normal; "><?=html($v->title); ?></h1>
            <p><?=nl2br(html($v->description ?? "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.\nAt vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.")); ?></p>

            <h2 class="mt-2" style="font-size:1.5rem; font-weight: normal; ">Fragen & Antworten:</h2>
<?php
if (!empty($msg1_success)) echo('<div class="alert alert-success">'.html($msg1_success).'</div>');
?>

            <button class="btn btn-outline-secondary my-2" data-toggle="modal" data-target="#ModalQA">Frage zum Video stellen</button>

            <h2 class="mt-2" style="font-size:1.5rem; font-weight: normal; ">Nächste Videos:</h2>
            <span class="text-muted">Wenn Du jetzt direkt mehr tanzen möchtest, dann geht es hier weiter:</span>


        </div>
    </section>

<form method="POST"><INPUT type="hidden" name="act" value="sendquestion"/>
<div id="ModalQA" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Frage zum Video stellen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <TEXTAREA name="msg" style="width:100%; height: 10rem;" REQUIRED PLACEHOLDER="Was beschäftigt Dich?"></TEXTAREA>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Frage senden</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
      </div>
    </div>
  </div>
</div>
</form>

</main>


<script src="https://vjs.zencdn.net/7.6.6/video.js"></script>
<?php
PageEngine::html("ts_vintageclub/footer");