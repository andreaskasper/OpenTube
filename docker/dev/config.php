<?php
//$config["mysql"]["connection"] = "mysql://opentube:opentube@localhost/opentube";
//$config["db"]["connection"] = "sqlite:".dirname($_ENV["basepath"])."/opentube.db";
$config["db"]["connection"] = "mysql:mysql:host=localhost;dbname=opentube_dev";
$config["db"]["user"] = "opentube";
$config["db"]["password"] = "opentube";

define("debug", true);
