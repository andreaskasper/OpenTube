<?php

class URL2 {

    public static function addVar(Array $arr) : string {
        return "?".http_build_query(array_merge($_GET, $arr));
    }



}