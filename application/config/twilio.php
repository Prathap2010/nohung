<?php 
 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
$config['mode'] = 'sandbox';
 
/**
* Account SID
**/
$config['account_sid'] = TWILIO_ACCOUNT_SID;
 
/**
* Auth Token
**/
$config['auth_token'] = TWILIO_AUTH_TOKEN;
 
/**
* API Version
**/
$config['api_version'] = '2010-04-01';
 
/**
* Twilio Phone Number
**/
$config['number'] = TWILIOPHONENUMBER;
 
/* End of file twilio.php */
?>