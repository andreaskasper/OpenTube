<?php

class DB {
    private static $_cache = array();
    private $_connection_id = null;
    private $conn = null;
    private $_lastcmd = null;
    private $_lastresult = null;
    
   

    public static function init(int $id, string $connectionstring, $user, $password) {
        self::$_cache[$id]["connectionstring"] = $connectionstring;
        self::$_cache[$id]["user"] = $user;
        self::$_cache[$id]["password"] = $password;
    }

    public function __construct(int $id) {
        $this->_connection_id = $id;
        $this->conn = new PDO(self::$_cache[$id]["connectionstring"],self::$_cache[$id]["user"],self::$_cache[$id]["password"]);
    }

    public function __get($name) {
        switch(strtolower($name)) {
            case "drivername": return $this->conn->getAttribute(PDO::ATTR_DRIVER_NAME);
        }
        trigger_error("Variable not found ".$name, E_USER_WARNING);
    }

    public function cmd(string $sql, Array $values = array()) {
        $sth = $this->conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        if (!$sth->execute($values)) trigger_error("Fehler beim ausführen von DB-Befehl (".$sql.")");
        $this->_lastresult = $sth;
        print_r($sth);
        return $sth;
    }

    public function cmdrow(string $sql, Array $values = array()) {
        $sth = $this->cmd($sql, $values);
        $row = $sth->fetch(PDO::FETCH_BOTH);
        print_r($row);
        return $row;
    }

    public function cmdrows(string $sql, Array $values = array(), $key = null) {
        $sth = $this->cmd($sql, $values);
        $rows = $sth->fetchAll(PDO::FETCH_BOTH);
        print_r($rows);
        return $rows;
    }



}

