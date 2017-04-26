<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['default_controller'] = 'main';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['quotes'] = 'quotes';
$route['add_to_fav/(:any)'] = 'quotes/add_to_fav/$1';
$route['remove/(:any)'] = 'quotes/remove_fav/$1';
$route['users/(:any)'] = 'quotes/show_user/$1';
