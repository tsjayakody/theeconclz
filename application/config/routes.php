<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
*/
$route['default_controller'] = 'Login_controller';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['login'] = 'Login_controller';
$route['forgot_password'] = 'Login_controller/view_forgot_password';
$route['register'] = 'Login_controller/view_register';
$route['dashboard'] = 'Course_controller/my_courses';
$route['logout'] = 'Login_controller/logout_student';
$route['content/(:any)'] = 'Course_controller/content/$1';
$route['download/(:any)'] = 'Course_controller/download_resources/$1';
$route['courses'] = 'Course_controller';
$route['myaccount'] = 'Myaccount_controller';
$route['mysubscriptions'] = 'Myaccount_controller/my_subscriptions';
$route['my_special_requests'] = 'Myaccount_controller/my_special_requests';

