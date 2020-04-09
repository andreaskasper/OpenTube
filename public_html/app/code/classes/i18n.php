<?php

class i18n {
	private static $_data = array();
	private static $loadeddb = false;
	private static $page_id = null;
	private static $project_id = 1;
	
	public static function init($file = null) {
		$f = substr($file,0,strlen($file)-3)."i18n";
		if (!file_exists($f)) self::$_data = array();
		else {
			$str = file_get_contents($f);
			self::$_data = array_merge(self::$_data, json_decode($str, true));
			if (self::$_data == null OR self::$_data == array()) echo("Ungültige i18n-Datei");
		}
		
	}
	
	public static function adds(Array $data) {
		foreach ($data as $k => $v) {
			self::$_data[$k] = $v;
		}
	
	}
	
	
	public static function read($key, $amount, Array $params = array()) {
		if (!isset(self::$_data[$key])) return $key;
		//if (isset(self::$_data[$key][$_GET["lang"]]) AND is_string(self::$_data[$key][$_GET["lang"]])) return self::$_data[$key][$_GET["lang"]];
		if (isset(self::$_data[$key][$_ENV["lang"]]) AND is_string(self::$_data[$key][$_ENV["lang"]])) return self::$_data[$key][$_ENV["lang"]];
		if (isset(self::$_data[$key]["eng"]) AND is_string(self::$_data[$key]["eng"])) return self::$_data[$key]["eng"];
		$m = array_keys(self::$_data[$key]);
		if (isset(self::$_data[$key][$m[0]]) AND is_string(self::$_data[$key][$m[0]])) return self::$_data[$key][$m[0]];
		return $key;
	}
}


function __($key, $amount = 1, Array $params = array()) {
	return i18n::read($key,$amount, $params);
	
}