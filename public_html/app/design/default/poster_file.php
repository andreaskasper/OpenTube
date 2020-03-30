<?php
    $db = new \SQL(1);
    $row = $db->cmdrow('SELECT file_pre FROM videoscorona WHERE id = "{0}" LIMIT 0,1', array($params["id"]));
    if (empty($row["file_pre"])) {
        header("Access-Control-Allow-Origin: *");
        header("Cache-Control: public, max-age=60, s-maxage=60, stale-while-revalidate=3600, stale-if-error=3600");
        header("Location: https://placehold.it/1920x1080?text=404a");
        exit;
    }

    $local = $_ENV["basepath"]."/data/videos_corona/ts3/".$row["file_pre"].".".$params["format"];
    if (!file_exists($local)) {
        header("Access-Control-Allow-Origin: *");
        header("Cache-Control: public, max-age=60, s-maxage=60, stale-while-revalidate=3600, stale-if-error=3600");
        header("Location: https://placehold.it/1920x1080?text=404b");
        exit;
    }

    if (!empty($_GET["w"])) {
        $im = ImageCreateFromJpeg($local);
        $im2 = ImageCreateTrueColor($_GET["w"], $_GET["w"]*imagesy($im)/imagesx($im));
        imagecopyresized($im2,$im,0,0,0,0,imagesx($im2), imagesy($im2),imagesx($im), imagesy($im));

        header("Access-Control-Allow-Origin: *");
        header("Cache-Control: public, max-age=3600, s-maxage=3600, stale-while-revalidate=3600, stale-if-error=3600");
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s T', filemtime($local)));

        switch ($params["format"]) {
            case "webp":
                header("Content-Type: image/webp");
                imagewebp($im2,null,90);
                exit;
            case "jpg":
            case "jpeg":
            default:
            header("Content-Type: image/jpeg");
            imagejpeg($im2,null,90);
            exit;  
        }
        exit;
    }



    header("X-Sendfile: ".$local);
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: ".mime_content_type($local));
    header("Cache-Control: public, max-age=3600, s-maxage=3600, stale-while-revalidate=3600, stale-if-error=3600");
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s T', filemtime($local)));
    exit(0);
?>