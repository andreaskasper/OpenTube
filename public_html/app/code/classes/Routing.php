<?php

class Routing {

    public static function start() {
        $url = parse_url("https://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
        
        if (preg_match ("@^\/api\/(?P<namespace>[A-Za-z0-9]+)(\.|\/)(?P<method>[A-Za-z0-9]+)(\.|\/)(?P<format>[a-z]+)@", $url["path"], $m)) {
			\API::run($m["namespace"], $m["method"], $m["format"], $_REQUEST);
			exit(1);
        }

        if (preg_match("@^/media/(?P<id>[0-9]+)\.(?P<format>mp4|webm)@", $url["path"], $m)) {
			PageEngine::html("video_file", array("id" => $m["id"], "format" => $m["format"])); exit;
		}

		if (preg_match("@^/media/(?P<id>[0-9]+)\.(?P<format>jpg)@", $url["path"], $m)) {
			PageEngine::html("poster_file", array("id" => $m["id"], "format" => $m["format"])); exit;
		}
        
        $url["path2"] = self::part_language($url["path"]);

        switch ($url["path2"]) {
            case "":
            case "/":
            case "/videos/":
                if (MyUser::is_loggedin()) { PageEngine::html("page_videos"); exit; }
                PageEngine::html("page_index"); exit;
            case "/login":
                PageEngine::html("page_login"); exit;
            case "/logout":
                PageEngine::html("page_logout"); exit;
            case "/account/":
                PageEngine::html("page_account_details"); exit;
            case "/admin/git":
                PageEngine::html("page_admin_git"); exit;
            case "/admin/teachers":
                PageEngine::html("page_admin_teachers"); exit;
            case "/admin/users":
                PageEngine::html("page_admin_users"); exit;
            case "/admin/videos":
                PageEngine::html("page_admin_videos"); exit;
        }

        if (preg_match("@^/videos/(?P<id>[0-9]+)[^0-9]*@", $url["path2"], $m)) {
			PageEngine::html("page_video", array("id" => $m["id"]));
			exit;
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