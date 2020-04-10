<?php
    if ($params["id"] == 1) {
        switch ($params["format"]) {
            case "mp4":
                $local = "/tmp/bbb.mp4";
                if (!file_exists($local)) {
                    copy("http://www.bokowsky.net/de/knowledge-base/video/videos/big_buck_bunny_1080p.mp4", $local);
                }
                header("X-Sendfile: ".$local);
                header("Access-Control-Allow-Origin: *");
                header("Content-Type: ".mime_content_type($local));
                header("Cache-Control: public, max-age=3600, s-maxage=3600, stale-while-revalidate=3600, stale-if-error=3600");
                header('Last-Modified: ' . gmdate('D, d M Y H:i:s T', filemtime($local)));
                exit;
            case "webm":
                $local = "/tmp/bbb.webm";
                if (!file_exists($local)) {
                    copy("http://www.bokowsky.net/de/knowledge-base/video/videos/big_buck_bunny_720p.webm", $local);
                }
                header("X-Sendfile: ".$local);
                header("Access-Control-Allow-Origin: *");
                header("Content-Type: ".mime_content_type($local));
                header("Cache-Control: public, max-age=3600, s-maxage=3600, stale-while-revalidate=3600, stale-if-error=3600");
                header('Last-Modified: ' . gmdate('D, d M Y H:i:s T', filemtime($local)));
                exit;
        }
    }


    if (!\TSUser::is_logged_in()) die("token2");
    if (empty($_GET["until"]) OR time() > $_GET["until"]) die("too late");

    if (empty($_SERVER["HTTP_REFERER"])) die("no referer");
    else {
        $a = parse_url($_SERVER["HTTP_REFERER"]);
        if ($a["host"] != "vintageclub.5678.video") die("wrong url");
    }

    $token = substr(md5($params["id"].$params["format"].$_GET["until"]),0,20);

    if (empty($_GET["token"]) OR $_GET["token"] != $token) die("token");

    $db = new \SQL(1);
    $row = $db->cmdrow('SELECT file_pre FROM videoscorona WHERE id = "{0}" LIMIT 0,1', array($params["id"]));
    if (empty($row["file_pre"])) {
        die("404");
    }

    $local = $_ENV["basepath"]."/data/videos_corona/ts3/".$row["file_pre"].".".$params["format"];
    if (!file_exists($local)) die("404");

    header("X-Sendfile: ".$local);
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: ".mime_content_type($local));
    header("Cache-Control: public, max-age=3600, s-maxage=3600, stale-while-revalidate=3600, stale-if-error=3600");
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s T', filemtime($local)));
    exit(0);
?>