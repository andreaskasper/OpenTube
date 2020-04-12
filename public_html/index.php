<?php
/*
 * Hier startet die gesamte Webseite
 *
 */

header("Cache-Control: no-cache, no-store, must-revalidate");
define("asi_allowed_entrypoint", true);
$_ENV["basepath"] = __DIR__;

ini_set("error_reporting", E_ALL | E_STRICT);
if(function_exists('xdebug_enable')) { xdebug_enable(); }

if (file_exists(__DIR__."/config.php")) require_once(__DIR__."/config.php");
else { //config fehlt, Installation muss gemacht werden
	require_once(__DIR__."/app/code/classes/PageEngine.php");
	PageEngine::html("install/page_install");
    exit;
}

if (defined("debug")) {
	ini_set("error_reporting", E_ALL | E_STRICT);
	if(function_exists('xdebug_enable')) { xdebug_enable(); }
} else {
    if(function_exists('xdebug_disable')) { xdebug_disable(); }
}





/*
 * Mit dieser Funktion werden Klassen anhand ihres Namens automatisch geladen. Das Ergebnis spiegelt den Erfolg der Ausführung
 * @param string $class_name Name der Klasse, die geladen werden muss
 * @return boolean
 */
spl_autoload_register(function($class_name) {
	$prio = array();
	$prio[] = __DIR__."/app/code/classes/".str_replace(chr(92), "/", $class_name).".php";

	foreach ($prio as $file) {
		if (file_exists($file)) {
			require($file);
			return true;
		}
	}
	if (defined("debug")) throw new Exception("Klasse ".$class_name." kann nicht gefunden werden!");
	return false;
});
//require_once(__DIR__."/app/code/vendor/autoload.php");



date_default_timezone_set($config["timezone"] ?? "Europe/Berlin");

DB::init(0, $config["db"]["connection"], $config["db"]["user"], $config["db"]["password"]);
config::init();

session_start();

Routing::start();