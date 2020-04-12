<?php

class config {

    private static $cache1 = null;
    private static $cache2 = null;

    public static function init() {
        if (!is_null(self::$cache1)) return;
        $db = new DB(0);
        self::$cache1 = $db->cmdrow('SELECT * FROM config WHERE site_id = 1 LIMIT 0,1');
        self::$cache2 = json_decode(self::$cache1["data_json"],true);
    }

    public static function sitename() {
        return self::$cache1["title"] ?? "";
    }

    public static function blowfish_secret() {
        return self::$cache1["blowfish_secret"] ?? null;
    }






}