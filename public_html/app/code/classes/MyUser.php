<?php

/*
 * Informations about the current User
 * 
 */
class MyUser {

    public static function is_loggedin() {
        return !empty($_SESSION["myuser"]["id"]);
    }

    public static function is_admin() {
        return self::user()->is_admin;
    }

    public static function login_emailpassword(string $email, string $password) : int {
        $db = new DB(0);
        $row = $db->cmdrow('SELECT T1.id,T2.value FROM users as T1 LEFT JOIN users_logins as T2 ON T1.id=T2.user_id AND T2.provider = "ep" WHERE email = ? LIMIT 0,1', array($email));
        if (empty($row["id"])) return -1;
        if ($row["value"] != md5(config::blowfish_secret().$row["id"].$password)) return -2;
        $_SESSION["myuser"]["id"] = $row["id"];
        return 1;
    }

    public static function logout() : bool {
        unset($_SESSION["myuser"]);
        return true;
    }

    public static function user() {
        if (!self::is_loggedin()) return null;
        return new User("id", $_SESSION["myuser"]["id"]);
    }

}