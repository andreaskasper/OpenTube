<?php

class DB {
    private static $_cache = array();
    private $_connection_id = null;
    private $conn = null;
    
   

    public static function init(int $id, string $connectionstring) {
        self::$_cache[$id]["connectionstring"] = $connectionstring;

        print_r(PDO::getAvailableDrivers());
    }

    public function __construct(int $id) {
        $this->_connection_id = $id;
        $this->conn = new PDO(self::$_cache[$id]["connectionstring"]);
    }

    public function cmdrow(string $sql, Array $values = array()) : Array {
        $rows = $this->conn->query($sql);
        print_r($rows);
        return array();
    }



}

