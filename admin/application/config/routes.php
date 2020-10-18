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
$route['default_controller'] = 'login_controller';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['login'] = 'login_controller';
$route['forgot_password'] = 'user_controller/forgot_password';
$route['dashbord'] = 'view_controller/dashbord';
$route['view_controller'] = 'view_controller/dashbord';
$route['manage_system_users'] = 'view_controller/manage_system_users';
$route['set_user_permissions'] = 'view_controller/set_user_permissions';
$route['logout'] = 'user_controller/logout';
$route['add_course'] = 'view_controller/add_course';
$route['update_course'] = 'view_controller/update_course';
$route['add_update_contents'] = 'view_controller/add_update_contents';
$route['special_requests'] = 'view_controller/special_requests';
$route['active_subs'] = 'view_controller/active_subs';
$route['student_data_report'] = 'view_controller/student_data_report';
$route['change_student_details'] = 'view_controller/change_student_details';
$route['course_categories'] = 'view_controller/course_categories';
$route['course_subscription_report'] = 'view_controller/course_subscription_report';
$route['special_request_report'] = 'view_controller/special_request_report';
