<?php

class PageEngine {

	private static $_layout_type = "frontend";
	public static $_skinpriolist = array(10 => "default");
	public static $messages = array();
	public static $_debuglog = array();
	public static $_runtime_start = 0;

	public static function html(string $key, array $params = array(), $cacheID = null, $cachetime = -1) {
		if ($cacheID != null) {
			if ($cacheID == -1) $cacheID = md5($key.serialize($params));
			$a = fcache::read($cacheID, $cachetime);
			if ($a != null) { echo($a); return; }
			ob_start();
		}
		$file  = self::html_find($key);
		if ($file != null) {
			if (defined("debug")) self::$_debuglog["html"][] = array("page" => $key, "file" => $file, "timestamp" => microtime(true));
			include($file); 
			if ($cacheID != null) fcache::write( $cacheID, ob_get_flush());
			return;
		}
		if (defined("debug")) trigger_error("Seite ".$key." kann nicht gefunden werden.", E_USER_WARNING);
	}

	public static function htmlOC(string $key, array $params = array(), int $ttl_browser = 0, $ttl_cloudflare = null, $ttl_stale = null, string $pragma = "public", bool $ignore_query = false) {
		$db = new \SQL(0);
		$cacheID = md5($_SERVER["REQUEST_URI"])."@".$_SERVER["HTTP_HOST"];
		$row = $db->cmdrow('SELECT * FROM main.cache_jet WHERE id = "'.$cacheID.'" LIMIT 0,1');
		if (isset($row["dt_lastcheck"]) AND time() < $row["dt_lastcheck"]+$ttl_browser) { //Können wir Cache ausliefern?
			if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) AND strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) >= $row["dt_modified"]) { //Gibt es die Möglichkeit für 304
				header('HTTP/1.0 304 Not Modified');
				header_remove("Cache-Control"); 
				header("Cache-Control: public, max-age=".$ttl_browser.", s-maxage=".$ttl_cloudflare.", stale-while-revalidate=".$ttl_stale.", stale-if-error=".$ttl_stale);
				exit;
			}
			header_remove("Cache-Control"); 
			header("Cache-Control: public, max-age=".$ttl_browser.", s-maxage=".$ttl_cloudflare.", stale-while-revalidate=".$ttl_stale.", stale-if-error=".$ttl_stale);
            header('Last-Modified: '.gmdate('D, d M Y H:i:s', $row["dt_modified"]).' GMT', true, 200);
            header('Content-Length: '.strlen($row["html"]));
            echo($row["html"]);
            exit;
		}
		try {
			ob_start();
			self::html($key, $params);
			$content = ob_get_clean();
			if (!isset($row["html"]) OR $row["html"] != $content) {
            	$w = array("id" => $cacheID, "html" => $content, "dt_modified" => time(), "dt_lastcheck" => time());
            	$db->CreateUpdate("main.cache_jet", $w);
           	} else {
				$db->cmd('UPDATE LOW_PRIORITY IGNORE main.cache_jet SET dt_lastcheck = "'.time().'" WHERE id ="'.$cacheID.'" LIMIT 1');
				if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) AND strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) >= $row["dt_modified"]) { //Gibt es die Möglichkeit für 304
					header('HTTP/1.0 304 Not Modified2');
					header_remove("Cache-Control"); 
					header("Cache-Control: public, max-age=".$ttl_browser.", s-maxage=".$ttl_cloudflare.", stale-while-revalidate=".$ttl_stale.", stale-if-error=".$ttl_stale);
					exit;
				}
        	}
		} catch (Exception $ex) {
			//print_r($ex);
			//exit;
		}
		//Ausgabe wenn alles okay ist
		header_remove("Cache-Control"); 
		header("Cache-Control: public, max-age=".$ttl_browser.", s-maxage=".$ttl_cloudflare.", stale-while-revalidate=".$ttl_stale.", stale-if-error=".$ttl_stale);
        header('Last-Modified: '.gmdate('D, d M Y H:i:s', time()).' GMT', true, 200);
        header('Content-Length: '.strlen($content));
        echo($content);
	}
	
	
	public static function html_find($key, $extension = ".php") {
		foreach (self::$_skinpriolist as $skin) {
			$local = $_ENV["basepath"]."/app/design/".$skin."/".$key.$extension;
			if (file_exists($local)) return $local;
		}
		return null;
	}
	
	
	public static function runController($key, $params = array()) {
		foreach (self::$_skinpriolist as $skin) {
			$local = $_ENV["basepath"]."/app/code/controller/".$skin."/".self::$_layout_type."/".$key.".php";
			if (file_exists($local)) { include($local); return; }
		}
	}
	
	public static function AddMessage($id, $message, $key = null) {
		if ($key == null) self::$messages[$id][] = $message;
		else self::$messages[$id][$key] = $message;
	}
	
	public static function AddErrorMessage($id, $message, $key = null) {
		if ($key == null) self::$messages[$id]["error"][] = $message;
		else self::$messages[$id]["error"][$key] = $message;
	}
	
	public static function AddSuccessMessage($id, $message, $key = null) {
		if ($key == null) self::$messages[$id]["success"][] = $message;
		else self::$messages[$id]["success"][$key] = $message;
	}
	
	public static function hasErrorMessage($id) {
		return isset(self::$messages[$id]["error"]);
	}
	
	public static function AddSkin($skinname, $priority = 10) {
		self::$_skinpriolist[$priority] = $skinname;
	}
	
	public static function runtime() {
		return (microtime(true)-self::$_runtime_start);
	}
}

PageEngine::$_runtime_start = microtime(true);