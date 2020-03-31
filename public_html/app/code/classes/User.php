<?php
/*
 * Informations about a User
 *
 */
class User {

    private $_id = null;

    public function __construct($type, $value) {
        switch (strtolower($type)) {
            case "id":
                $this->_id = $value;
                return $this;
        }
    }

    public function __get($name) {
        switch (strtolower($name)) {
            case "id": return $this->_id;
            case "is_allaccess": return true;
            case "is_admin": return true;

        }
        trigger_error("Unknown Variable ".$name, E_USER_WARNING);
        return null;
    }


}