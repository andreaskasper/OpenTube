<?php

class Video {

    private $_id = null;

    public function __construct($type, $value) {
        switch (strtolower($type)) {
            case "id":
                $this->_id = $value;
                return $this;
        }
        throw new Exception("Ungültiger Konstruktor ".$type);
    }

    public function __get($name) {
        switch (strtolower($name)) {
            case "id": return $this->_id;
            case "exist":
            case "exists":
                return true;
            case "title": return "Lorem Ipsum";
            case "description": return "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.\n\nAt vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.";
            case "url_mp4_1080": return "/media/1.mp4?v=1";
            case "url_mp4_720": return "http://www.bokowsky.net/de/knowledge-base/video/videos/big_buck_bunny_720p.mp4";
            case "url_mp4_480": return "http://www.bokowsky.net/de/knowledge-base/video/videos/big_buck_bunny_480p.mp4";
            case "url_mp4_240": return "http://www.bokowsky.net/de/knowledge-base/video/videos/big_buck_bunny_240p.mp4";
            case "url_webm_1080":  return "/media/1.webm?v=1";
            case "url_webm_720": return "http://www.bokowsky.net/de/knowledge-base/video/videos/big_buck_bunny_720p.webm";
            case "url_webm_480": return "http://www.bokowsky.net/de/knowledge-base/video/videos/big_buck_bunny_480p.webm";
            case "url_webm_240": return "http://www.bokowsky.net/de/knowledge-base/video/videos/big_buck_bunny_240p.webm";
        }
        trigger_error("Ungültige Variable ".$name, E_USER_WARNING);
        return null;
    }


    public function canViewedByUser(User $user) {
        if ($user->is_allaccess) return true;
    }



}