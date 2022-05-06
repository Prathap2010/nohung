<?php
require_once('function/pdohelper.php');
require_once('function/pdowrapper.php');
require_once('function/pdowrapper-child.php');
require_once('function/function.php');

define('SITE_URL', 'https://' . $_SERVER["SERVER_NAME"] . '/');
define('DIR_URL', $_SERVER["DOCUMENT_ROOT"] . '/nohungkitchen/');
define("SITE_UPD", SITE_URL . "assets/uploaded/");
define("DIR_UPD", DIR_URL . "assets/uploaded/");

define("API_TOKEN","123456789");

$dbConfig = array("host" => "localhost" , "dbname" => "nohungkitchen" , "username" => "root", "password" => "");
$db = new PdoWrapper($dbConfig);

$helper = new PDOHelper();






