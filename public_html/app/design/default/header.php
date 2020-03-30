<?php

namespace web;

i18n::init(__FILE__);

?><!doctype html>
<html lang="<?=$_ENV["lang"]; ?>">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Andreas Kasper <info@goo1.de>">
    <meta name="referrer" content="same-origin">

    <title><?= (isset($params["title"])?$params["title"]:'VintageClub Videos'); ?></title>
	
<?php
  if (isset($params["head_meta"])) echo($params["head_meta"]);
  if (isset($params["amp"]) AND $params["amp"] == true) echo('<link rel="amphtml" href="https://'.$_SERVER["HTTP_HOST"].'/'.$_ENV["lang"].'/amp/'.substr($_SERVER["REQUEST_URI"],4,999).'">');
?>

	<link rel="icon" href="//5678.video/favicon.ico">
    <link href="/skins/corona/css/main.css?v=3" rel="stylesheet">
	<link rel="search" href="https://5678.video/skins/default/opensearchdescription.xml" type="application/opensearchdescription+xml" title="5678.video" />
	<meta name="google-site-verification" content="KphdYelZTuenpNxcZEvWXpR_3xvrtUD7Hwr-xMRG2xA" />
<?php
if (isset($params["og:url"])) echo('<meta property="og:url" content="'.$params["og:url"].'" />'.PHP_EOL);
echo ('<meta property="og:type" content="'.(isset($params["og:type"])?$params["og:type"]:'article').'" />'.PHP_EOL);
echo ('<meta property="og:title" content="'.(isset($params["og:title"])?$params["og:title"]:(isset($params["title"])?$params["title"]:'DanceTube - Best Dancing Videos')).'" />'.PHP_EOL);
echo ('<meta property="og:description" content="'.(isset($params["og:description"])?$params["og:description"]:(isset($params["title"])?$params["title"]:'DanceTube - Best Dancing Videos')).'" />'.PHP_EOL);
echo ('<meta property="og:image" content="'.(isset($params["og:image"])?$params["og:image"]:'https://i.ytimg.com/vi/oc5bfb_gtWc/hqdefault.jpg').'" />'.PHP_EOL);

if (isset($params["video"])) {
	$v = $params["video"];
	echo('<meta name="twitter:card" content="player">');
    echo('<meta name="twitter:site" content="@5678vid">');
    echo('<meta name="twitter:title" content="'.$v->title.'">');
    echo('<meta name="twitter:description" content="'.$v->title.'">');
    echo('<meta name="twitter:image" content="'.$v->url_thumbnail.'">');
    echo('<meta name="twitter:player" content="https://5678.video/embed/player/'.$v->id.'">');
    echo('<meta name="twitter:player:width" content="1280">');
    echo('<meta name="twitter:player:height" content="720">');
    echo('<meta name="twitter:site" content="@5678vid">');
} else {
echo ('<meta property="twitter:card" content="'.(isset($params["twitter:card"])?$params["twitter:card"]:(isset($params["title"])?$params["title"]:'DanceTube - Best Dancing Videos')).'" />'.PHP_EOL);
echo ('<meta property="twitter:site" content="'.(isset($params["twitter:site"])?$params["twitter:site"]:'@5678vid').'" />'.PHP_EOL);
echo ('<meta property="twitter:creator" content="'.(isset($params["twitter:creator"])?$params["twitter:creator"]:'@5678vid').'" />'.PHP_EOL);
}

	
?>	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="/skins/default/js/jquery.min.js"><\/script>')</script>
  </head>

  <body>
  
	<h1 class="hidden"><?=html(isset($params["title"])?$params["title"]:'VintageClub Videos') ?></h1>
	<p class="hidden"><?=(isset($params["description"])?html($params["description"]):''); ?></p>
  
    <header class="border-bottom box-shadow bg-light">
		<div class="container">
            <div class="row">
                <div class="col-auto my-auto"><a href="/<?=$_ENV["lang"]; ?>/"><img src="/skins/corona/img/logos/ts0003.png" style="opacity:0.9; height: 2rem;"/></a></div>
                <div class="col">
                    <form ACTION="/<?=$_ENV["lang"]; ?>/" class="form-inline my-2">
            <div class="input-group w-100">
              <input type="search" class="form-control" name="q" placeholder="<?=__("Suche nach Videos"); ?>" value="<?=(!empty($params["search"])?htmlattr($params["search"]):''); ?>" aria-label="Suchen"/>
              <div class="input-group-append">
                <button class="btn btn-outline-success" type="submit"><i class="fas fa-search"></i></button>
              </div>
            </div>

            <!--<input class="form-control mr-sm-2" type="text" name="q" placeholder="<?=__("Search"); ?>" value="<?=(!empty($params["search"])?htmlattr($params["search"]):''); ?>" aria-label="Suchen">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><?=__("Search"); ?></button>-->
          </form>
          </div>
                <div class="col-auto my-auto"><img src="/skins/default/img/flags/de.png" style="height: 2rem; opacity: 0.25;"/></div>
                <div class="col-auto my-auto">
<?php
if (\TSUser::is_logged_in()) {
echo('<div class="dropdown">
<i class="fal fa-user-circle fa-2x" data-toggle="dropdown"></i>
<div class="dropdown-menu dropdown-menu-right">
<a class="dropdown-item" href="/'.$_ENV["lang"].'/account/"><i class="far fa-address-card"></i> Mein Account</a>');
if (\TSUser::is_admin()) echo('
<a class="dropdown-item" href="/'.$_ENV["lang"].'/admin/users"><i class="far fa-users"></i> Benutzer</a>
<a class="dropdown-item" href="/'.$_ENV["lang"].'/admin/videos"><i class="far fa-photo-video"></i> Videos</a>
');
echo('<a class="dropdown-item" href="/'.$_ENV["lang"].'/logout"><i class="far fa-sign-out-alt"></i> abmelden</a>
</div>
</div>');
} else {
}
?>
                </div>
            </div>
        </div>
    </header>
