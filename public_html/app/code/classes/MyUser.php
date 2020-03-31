<?php

/*
 * Informations about the current User
 * 
 */
class MyUser {

    public static function is_loggedin() {
        return false;
    }

    public static function is_admin() {
        return false;
    }

    public static function login_emailpassword(string $email, string $password) : int {
        $db = new DB(0);
        $db->cmdrow('SELECT * FROM users WHERE email = "{0}" LIMIT 0,1', array($email));
        return 2;
    }

    public static function logout() : bool {
        unset($_SESSION["myuser"]);
        return true;
    }

}