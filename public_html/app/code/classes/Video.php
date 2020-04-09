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
        }
        trigger_error("Ungültige Variable ".$name, E_USER_WARNING);
        return null;
    }


    public function canViewedByUser(User $user) {
        if ($user->is_allaccess) return true;
    }



}