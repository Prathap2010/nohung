<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
|  Google API Configuration
| -------------------------------------------------------------------
| 
| To get API details you have to create a Google Project
| at Google API Console (https://console.developers.google.com)
| 
|  client_id         string   Your Google API Client ID.
|  client_secret     string   Your Google API Client secret.
|  redirect_uri      string   URL to redirect back to after login.
|  application_name  string   Your Google application name.
|  api_key           string   Developer key.
|  scopes            string   Specify scopes
*/
$config['google']['client_id']        = GOOGLE_CLIENT_ID;
$config['google']['client_secret']    = GOOGLE_CLIENT_SECRET;
$config['google']['redirect_uri']     = FRONT_URL."login";
$config['google']['application_name'] = 'Login to '.SITE_NAME;
$config['google']['api_key']          = '';
$config['google']['scopes']           = array();