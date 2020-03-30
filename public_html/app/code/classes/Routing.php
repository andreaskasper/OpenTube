<?php

class Routing {

    public static function start() {
        $url = parse_url("https://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
        print_r($url);

    }


}