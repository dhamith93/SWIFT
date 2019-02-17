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
$route['default_controller'] = 'welcome';
$route['login'] = 'login/view';
$route['login/go'] = 'login/userLogin';
$route['logout'] = 'login/userLogout';
$route['admin'] = 'admin/view';
$route['admin/add-employee'] = 'admin/addEmployee';
$route['admin/get-employee'] = 'admin/getEmployeeInfo';
$route['admin/delete-employee'] = 'admin/deleteEmployee';
$route['admin/change-info'] = 'admin/changeCompanyInfo';
$route['admin/(:any)'] = 'admin/view/$1';
$route['article/add/(:any)'] = 'article/add/$1';
$route['article/edit/(:any)'] = 'article/edit/$1';
$route['employee'] = 'employee/view';
$route['employee/(:any)'] = 'employee/view/$1';
$route['employee/settings/change_pw'] = 'employee/changePassword';
$route['reports'] = 'report/view';
$route['incident/add'] = 'incident/add';
$route['incident/mark-complete/(:any)'] = 'incident/markComplete/$1';
$route['incident/search'] = 'incident/getIncidentInfo';
$route['incident/add-location/(:any)'] = 'incident/addLocation/$1';
$route['incident/add-evacuations/(:any)'] = 'incident/addEvacuations/$1';
$route['incident/update-casualties/(:any)'] = 'incident/updateCasualties/$1';
$route['incident/update-evacuations/(:any)'] = 'incident/updateEvacuations/$1';
$route['incident/upload-image/(:any)'] = 'incident/uploadImage/$1';
$route['incident/upload-video/(:any)'] = 'incident/uploadVideo/$1';
$route['incident/(:any)/(:any)'] = 'incident/view/$1/$2';
$route['incident/(:any)'] = 'incident/view/$1';
$route['organization/add'] = 'organization/add';
$route['organization/add-responder'] = 'organization/addResponder';
$route['organization/get-responders'] = 'organization/getResponderInfo';
$route['organization/delete-responder'] = 'organization/deleteResponder';
$route['organization/change-info'] = 'organization/changeInfo';
$route['organization/make-admin'] = 'organization/makeAdmin';
$route['organization/assign-task'] = 'organization/assignTask';
$route['organization/search'] = 'organization/getOrganizationInfo';
$route['organization/incident/(:any)/(:any)'] = 'organization/incidentView/$1/$2';
$route['organization/incident/(:any)'] = 'organization/incidentView/$1';
$route['organization/mark-task-complete/(:any)'] = 'organization/markTaskCompleted/$1';
$route['organization'] = 'organization/view';
$route['organization/(:any)'] = 'organization/view/$1';
$route['org/(:any)'] = 'organization/singleOrganizationView/$1';
$route['responder'] = 'responder/view';
$route['responder/(:any)'] = 'responder/view/$1';
$route['responder/incident/(:any)/(:any)'] = 'responder/incidentView/$1/$2';
$route['responder/incident/(:any)'] = 'responder/incidentView/$1';
$route['responder/mark-task-complete/(:any)/(:any)'] = 'responder/markTaskCompleted/$1/$2';
$route['responder/mark-task-complete/(:any)'] = 'responder/markTaskCompleted/$1';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
