<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'Basecontroller';
$route['dashboard'] = 'Basecontroller/dashboard';

$route['home'] = 'Basecontroller/newsource';
$route['newsource'] = 'Basecontroller/newsource';

$route['signout'] = 'Basecontroller/signout';
$route['tito_monitoring/(:any)'] = 'Tito_controller/tito_monitoring/$1';
$route['tito_monitoring/4/(:any)'] = 'Tito_controller/agent_refinement/$1';
$route['tito_monitoring/6/(:any)'] = 'Tito_controller/agent_rework/$1';
$route['content_analysis'] = 'Tito_controller/content_analysis';
$route['masterlist'] = 'Masterlist_controller/masterlist';
$route['masterlist/download'] = 'Masterlist_controller/masterlist_download';
$route['register/(:any)'] = 'Register_controller/register/$1';


$route['allocation'] = 'Allocation_controller/allocation';
$route['downloadtemplate/(:any)'] = 'Register_controller/downloadtemplate/$1';


$route['published'] = 'Published_controller/published';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

