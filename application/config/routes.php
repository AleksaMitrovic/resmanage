<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$route['regist'] = 'User/regist';
$route['logout'] = 'User/logout';
$route['login'] = 'User/login';
$route['update/(:any)'] = 'User/update/$1';
$route['dailyrep/index'] = 'Dailyrep/index';
$route['project/index'] = 'Project/index';


$route['pinfo/create'] = 'Pinfo/create';
$route['pinfo/update'] = 'Pinfo/update';
$route['dailyrep/create'] = 'Dailyrep/create';
$route['dailyrep/update'] = 'Dailyrep/update';
$route['dailyrep/entire/(:any)'] = 'Dailyrep/entire/$1';
$route['project/create'] = 'Project/create';
$route['project/update'] = 'Project/update';
$route['project/update_project'] = 'Project/update';
$route['project/moveTopending'] = 'Project/moveTopending';
$route['project/tax_award'] = 'Project/tax_award';
$route['project/regist_pro_change'] = 'Project/regist_pro_change';
$route['project/entire'] = 'Project/entire';
$route['pinfo/(:any)'] = 'Pinfo/view/$1';


$route['pinfo'] = 'Pinfo/index';
$route['dailyrep'] = 'Dailyrep/index';
$route['project'] = 'Project/index';
$route['default_controller'] = 'Pages/view';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['(:any)'] = 'pages/view/$1';