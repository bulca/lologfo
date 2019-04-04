<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

// the guest routes

$route['login'] = "guest/login";
$route['register'] = "guest/register";

// the user routes

$route['home'] = "user/home";
$route['logout'] = "user/logout";
$route['shop/tos'] = "shop/tos";
$route['buy'] = "shop/buy";
$route['shop/(:any)'] = "shop/forType/$1";

// $route['shop'] = "user/shop";
// $route['shop/(:any)'] = "user/shopFor/$1";

$route['add-funds'] = "user/addFunds";
$route['my-stuff'] = "user/myStuff";
$route['my-stuff/(:any)'] = "user/myStuff/$1";
$route['support'] = "user/support";
$route['support/(:num)'] = "user/viewTicket/$1";
$route['ticket-manager'] = "user/ticketManager";
$route['ticket-manager/(:num)'] = "user/manageTicket/$1";
$route['settings'] = "user/settings";

$route['seller/shop/(:any)'] = "seller/index/$1";

$route['default_controller'] = "guest/login";
$route['404_override'] = 'guest/login';


/* End of file routes.php */
/* Location: ./application/config/routes.php */