<?php
require_once('function/pdohelper.php');
require_once('function/pdowrapper.php');
require_once('function/pdowrapper-child.php');
require_once('function/function.php');

date_default_timezone_set('Asia/Kolkata');

define('SITE_URL', 'https://' . $_SERVER["SERVER_NAME"] . '/');
define('DIR_URL', $_SERVER["DOCUMENT_ROOT"] . '/');
define("SITE_UPD", SITE_URL . "assets/uploaded/");
define("DIR_UPD", DIR_URL . "assets/uploaded/");

define("PROFILE", SITE_URL . "assets/image/userprofile/");
define("PROFILE_PATH", DIR_URL . "assets/image/userprofile/");
define("NOPROFILEIMAGE", SITE_URL . "assets/image/userprofile/noimage.png");

define("API_TOKEN","123456789");

if(!defined('TWILIO_SID')){
    define('TWILIO_SID', 'ACbec4fd7ba49935f93889e76cd039f734');
	//define('TWILIO_SID', 'AC22c30e1636450345d3e90183b227f485'); //Live
}

if(!defined('TWILIO_TOKEN')){
    define('TWILIO_TOKEN', 'de54ac850609837f8579120f1d47100d');
    // define('TWILIO_TOKEN', '034116ffcc3d6499e327332290624347'); //Live
}

if(!defined('TWILIO_PHONE_NO')){
    define("TWILIO_PHONE_NO", "+15089526191");
    // define('TWILIO_PHONE_NO', '+19285634731'); //Live
}

$dbConfig = array("host" => "localhost" , "dbname" => "nohungki_nohungkitchen" , "username" => "nohungki_nohungkitchen", "password" => "1zh=caiPA*,$");
$db = new PdoWrapper($dbConfig);

$helper = new PDOHelper();






