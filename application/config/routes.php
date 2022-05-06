<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] 	= 'home';
$route['admin'] 			= "admin/login";
$route['kitchen'] 			= "kitchen/home";
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;

$route[KITCHENFOLDER.'reset-password/update-password'] = KITCHENFOLDER . "Reset_password/update_password/$1";
$route[KITCHENFOLDER . 'reset-password/(:any)'] = KITCHENFOLDER . "Reset_password/index/$1";

$route['otp/verify-otp'] = "Otp/Verify_otp/$1";
$route['otp/(:any)'] = "Otp/index/$1";
$route['manage-content/(:any)'] = "Manage_content/index/$1";

$route['kitchen-detail/load-trial-meal'] = "Kitchen_detail/load_trial_meal/$1";
$route['kitchen-detail/load-package'] = "Kitchen_detail/load_package/$1";
$route['kitchen-detail/get-reviews'] = "Kitchen_detail/get_reviews/$1";
$route['kitchen-detail/add-review'] = "Kitchen_detail/add_review/$1";
$route['kitchen-detail/get-package-detail'] = "Kitchen_detail/get_package_detail/$1";
$route['kitchen-detail/addtocart'] = "Kitchen_detail/addtocart/$1";
$route['kitchen-detail/addtocart-package'] = "Kitchen_detail/addtocart_package/$1";
$route['kitchen-detail/editcart'] = "Kitchen_detail/editcart/$1";
$route['kitchen-detail/remove-cart-items'] = "Kitchen_detail/remove_cart_items/$1";
$route['kitchen-detail/addfavoritekitchen'] = "Kitchen_detail/addfavoritekitchen/$1";
$route['kitchen-detail/removefavoritekitchen'] = "Kitchen_detail/removefavoritekitchen/$1";
$route['kitchen-detail/addextraitem'] = "Kitchen_detail/addextraitem/$1";
$route['kitchen-detail/(:any)'] = "Kitchen_detail/index/$1";

$route['search/loadkitchendata'] = "Search/loadkitchendata/$1";
$route['search/(:any)'] = "Search/index/$1";

$route['^(?!kitchen|home|login|register|checkout|kitchen-detail|my-account|payment|search|search-kitchen|logout)(:any)'] = "Manage_content/index/$1";