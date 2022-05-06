<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/* * ***************************************************************
 *  DEFINE CONSTANTS FOR SITE CONFIG
 * *************************************************************** */

define('_PATH', substr(dirname(__FILE__), 0, -19));
define('_URL', substr($_SERVER['PHP_SELF'], 0, -(strlen($_SERVER['SCRIPT_FILENAME']) - strlen(_PATH))));

define('SITE_PATH', _PATH . "/");

define("ADMINFOLDER", "admin/");
define("KITCHENFOLDER", "kitchen/");

define('DOMAIN_URL', 'https://' . $_SERVER['HTTP_HOST'].'/');

/* DEFINE CONSTANTS FOR ADMIN */
define('ADMIN_URL', DOMAIN_URL .ADMINFOLDER);
define('CSS_ADMIN_URL', "admin/css/");
define('ADMIN_CSS_URL', DOMAIN_URL .'assets/'. CSS_ADMIN_URL);
define('JS_ADMIN_URL', "admin/js/");
define('ADMIN_JS_URL', DOMAIN_URL .'assets/'. JS_ADMIN_URL);
define('PLUGIN_ADMIN_URL',"admin/plugins/");
define('ADMIN_PLUGIN_URL', DOMAIN_URL .'assets/'. PLUGIN_ADMIN_URL);

/* DEFINE CONSTANTS FOR FRONT */
define('FRONT_URL', DOMAIN_URL);
define('CSS_FRONT_URL', "css/");
define('FRONT_CSS_URL', DOMAIN_URL .'assets/'. CSS_FRONT_URL);
define('JS_FRONT_URL', "js/");
define('FRONT_JS_URL', DOMAIN_URL .'assets/'. JS_FRONT_URL);
define('PLUGIN_FRONT_URL',"plugins/");
define('FRONT_PLUGIN_URL', DOMAIN_URL .'assets/'. PLUGIN_FRONT_URL);
define('IMAGES_FRONT_URL', "images/");
define('FRONT_IMAGES_URL', DOMAIN_URL . 'assets/' . IMAGES_FRONT_URL);

/* DEFINE CONSTANTS FOR KITCHEN */
define('KITCHEN_URL', DOMAIN_URL . KITCHENFOLDER);
define('CSS_KITCHEN_URL', "kitchen/css/");
define('KITCHEN_CSS_URL', DOMAIN_URL .'assets/'. CSS_KITCHEN_URL);
define('JS_KITCHEN_URL', "kitchen/js/");
define('KITCHEN_JS_URL', DOMAIN_URL .'assets/'. JS_KITCHEN_URL);
define('PLUGIN_KITCHEN_URL', "kitchen/plugins/");
define('KITCHEN_PLUGIN_URL', DOMAIN_URL .'assets/'. PLUGIN_KITCHEN_URL);
define('KITCHEN_IMAGES_URL', DOMAIN_URL . 'assets/' . KITCHENFOLDER . 'images/');

define("MAIN_LOGO_IMAGE_URL", DOMAIN_URL."assets/uploaded/setting/");
define("SETTING", DOMAIN_URL ."assets/uploaded/setting/");
define("SETTING_PATH", SITE_PATH ."assets/uploaded/setting/");

define("PROFILE", DOMAIN_URL ."assets/image/userprofile/");
define("PROFILE_PATH", SITE_PATH ."assets/image/userprofile/");

define("USER_PROFILE", DOMAIN_URL ."assets/uploaded/profile/");
define("USER_PROFILE_PATH", SITE_PATH ."assets/uploaded/profile/");

define("DOCUMENT", DOMAIN_URL ."assets/uploaded/documents/");
define("DOCUMENT_PATH", SITE_PATH ."assets/uploaded/documents/");

define("MENU", DOMAIN_URL ."assets/uploaded/menu/");
define("MENU_PATH", SITE_PATH ."assets/uploaded/menu/");

define("PACKAGE", DOMAIN_URL ."assets/uploaded/menu/");
define("PACKAGE_PATH", SITE_PATH ."assets/uploaded/menu/");

define("CUSTOMER", DOMAIN_URL ."assets/uploaded/customer/");
define("CUSTOMER_PATH", SITE_PATH ."assets/uploaded/customer/");

define("CARD", DOMAIN_URL ."assets/uploaded/cards/");
define("CARD_PATH", SITE_PATH ."assets/uploaded/cards/");

define("NOIMAGE", DOMAIN_URL ."assets/image/noimage.jpg");
define("NOPROFILEIMAGE", DOMAIN_URL ."assets/image/userprofile/noimage.png");

//ADD BUTTON CONSTANTS
define("addbtn_text", "<i class='fa fa-plus'></i> ADD");
define("addbtn_class", "btn btn-primary btn-raised btn-label");
define("addbtn_title", "ADD");

//DELETE BUTTON CONSTANTS
define("deletebtn_text", "<i class='fa fa-trash-o'></i> DELETE");
define("deletebtn_class", "btn btn-danger btn-raised btn-label");
define("deletebtn_title", "DELETE");

//Enable Disable constants
define("disable_text", "<i class=\'fa fa-ban\' aria-hidden=\'true\'></i>");
define("enable_text", "<i class=\'fa fa-check\' aria-hidden=\'true\'></i>");
define("disable_class", "btn btn-danger btn-raised btn-sm");
define("enable_class", "btn btn-success btn-raised btn-sm");
define("enable_title", "Enable");
define("disable_title", "Disable");

//Delete constants
define("delete_text", "<i class='fa fa-trash-o'></i>");
define("delete_class", "btn btn-danger btn-raised btn-sm");
define("delete_title", "DELETE");

//Edit constants
define("edit_text", "<i class='fa fa-pencil'></i>");
define("edit_class", "btn btn-success btn-raised btn-sm");
define("edit_title", "EDIT");

//Edit Button constants
define("editbtn_text", "<i class='fa fa-edit'></i> Edit");
define("editbtn_class", "btn btn-success btn-raised btn-label");
define("editbtn_title", "EDIT");

//view constants
define("view_text", "<i class='fa fa-eye'></i>");
define("view_class", "btn btn-info btn-raised btn-sm");
define("view_title", "View");

//Cancel constants
define("cancel_text", "<i class='fa fa-times'></i>");
define("cancel_class", "btn btn-danger btn-raised btn-sm");
define("cancel_title", "Cancel");

//Cancel constants
define("cancellink_text", "Cancel");
define("cancellink_class", "btn btn-danger btn-raised");
define("cancellink_title", "Cancel");

//View Files
define("viewbtn_text", "<i class='fa fa-download'></i>");
define("viewbtn_class", "btn btn-warning btn-sm btn-raised btn-sm");
define("viewbtn_title", "View");

define("ORDER_PREFIX", "ORD_");
	
define("PER_PAGE_OFFER", "9");
define("PER_PAGE_PACKAGE", "9");
define("PER_PAGE_FEEDBACK", "6");

define("PER_PAGE_KITCHEN", "6");
define("PER_PAGE_TRANSACTION", "6");
define("PER_PAGE_ORDER", "6");
define("PER_PAGE_ADDRESS", "6");

define("TWILIOPHONENUMBER", "+15089526191");
define("TWILIO_ACCOUNT_SID", "ACbec4fd7ba49935f93889e76cd039f734");
define("TWILIO_AUTH_TOKEN", "de54ac850609837f8579120f1d47100d");

define('PAYU_MERCHANT_KEY', '5Uf4D5Z2'); // For Test Mode
define('PAYU_MERCHANT_SALT', '0jDMABcmMm'); // For Test Mode
define('PAYU_URL', 'https://test.payu.in');  // For Test Mode

// define('PAYU_MERCHANT_KEY', 'tyliG3'); // For Production Mode
// define('PAYU_MERCHANT_SALT', 'GC0imkVt'); // For Production Mode
// define('PAYU_URL', 'https://secure.payu.in');  // For Production Mode

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code
