<?php
/*
 * Informations about a User
 *
 */
class User {

    private static $cache = array();
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
            case "is_admin": $this->load1(); return (($this->_id == 1) OR in_array("admin", self::$cache[$this->_id][1]));
        }
        trigger_error("Unknown Variable ".$name, E_USER_WARNING);
        return null;
    }

    private function load0() {
        if (!isset(self::$cache[$this->_id][0])) {
            $db = new DB(0);
            self::$cache[$this->_id][0] = $db->cmdrow('SELECT * FROM users WHERE id = "?" LIMIT 0,1', array($this->_id));
        }
        return self::$cache[$this->_id][0];
    }

    private function load1() {
        if (!isset(self::$cache[$this->_id][1])) {
            $db = new DB(0);
            self::$cache[$this->_id][1] = array();
            $rows = $db->cmdrows('SELECT * FROM users_rights WHERE user_id = "?"', array($this->_id));
            foreach ($rows as $row) self::$cache[$this->_id][1][] = $row["right"];
        }
        return self::$cache[$this->_id][1];
    }


}