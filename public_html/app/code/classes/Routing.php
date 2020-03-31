<?php

class Routing {

    public static function start() {
        $url = parse_url("https://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
        
        if (preg_match ("@^\/api\/(?P<namespace>[A-Za-z0-9]+)(\.|\/)(?P<method>[A-Za-z0-9]+)(\.|\/)(?P<format>[a-z]+)@", $url["path"], $m)) {
			\API::run($m["namespace"], $m["method"], $m["format"], $_REQUEST);
			exit(1);
        }
        
        $url["path2"] = self::part_language($url["path"]);

        switch ($url["path2"]) {
            case "":
            case "/":
                if (MyUser::is_loggedin()) { PageEngine::html("page_videos"); exit; }
                PageEngine::html("page_index"); exit;
            case "/login":
                PageEngine::html("page_login"); exit;
            case "/logout":
                PageEngine::html("page_logout"); exit;
        }

        PageEngine::html("page_404"); exit;
    }

    public static function part_language($path) : string {
        if (preg_match("@^/(?P<lang>de)(?P<url>/.*)$@", $path, $m)) {
            $_ENV["lang"] = $m["lang"];
            return $m["url"];
		} else {
            $lang = substr(strtolower(trim($_SERVER["HTTP_ACCEPT_LANGUAGE"])),0,2);
			/* Wenn keine Sprache gewählt wurde */
			switch ($lang) {
                default:
                case "de":
					PageEngine::html("goto", array("url" => "/de".$path)); exit(1);
			}
		}

    }


}