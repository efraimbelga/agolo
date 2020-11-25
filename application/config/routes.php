<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'Basecontroller';
$route['dashboard'] = 'Basecontroller/dashboard';

$route['home'] = 'Basecontroller/home';
$route['tito_monitoring/(:any)'] = 'Tito_controller/tito_monitoring/$1';



$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

