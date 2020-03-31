<?php

class DB {
    private static $_cache = array();
    private $_connection_id = null;
    private $conn = null;
    
   

    public static function init(int $id, string $connectionstring) {
        self::$_cache[$id]["connectionstring"] = $connectionstring;
    }

    public function __construct(int $id) {
        $this->_connection_id = $id;
        $this->conn = new PDO(self::$_cache[$id]["connectionstring"]);
    }

    public function __get($name) {
        switch(strtolower($name)) {
            case "scheme": $g = explode(":", self::$_cache[$id]["connectionstring"]); return $g[0];
        }
        trigger_error("Variable not found ".$name, E_USER_WARNING);
    }

    public function cmdrow(string $sql, Array $values = array()) {
        $sth = $this->conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute($values);
        $row = $sth->fetch(PDO::FETCH_BOTH);
        print_r($row);
        return $row;
    }



}

