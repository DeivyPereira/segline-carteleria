<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'Welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;


//Token Request
$route['token']['get'] = 'token/index';
$route['token']['post'] = 'token/index';
$route['token/(:num)']['get'] = 'token/find/$1';
$route['token']['put'] = 'token/index';
$route['token/(:num)']['delete'] = 'token/index/$1';

//Routes Login
$route['login/logo']['get'] = 'public/login/logo';
$route['login']['post'] = 'public/login/index'; // Admin
$route['login']['get'] = 'public/login/index'; // Admin
$route['authenticate']['get'] = 'public/login/check'; // Admin
$route['logout']['post'] = 'public/login/logout'; // Admin
$route['login/super-admin']['post'] = 'public/login/admin';

// Routes User
$route['user']['post'] = 'private/user/index';
$route['user']['get'] = 'private/user/index';
$route['user/(:any)']['put'] = 'private/user/index/$1';
$route['user/(:any)']['delete'] = 'private/user/index/$1';

// Routes Tv
$route['tv']['post'] = 'private/tv/index';
$route['tv']['get'] = 'private/tv/index';
$route['tv/(:any)']['put'] = 'private/tv/index/$1';
$route['tv/(:any)']['delete'] = 'private/tv/index/$1';
$route['tv/by-sede/(:num)']['get'] = 'private/tv/by_sede/$1';

// Routes Multimedia
$route['multimedia']['get'] = 'private/multimedia/index';
$route['multimedia']['post'] = 'private/multimedia/index';
$route['multimedia/(:any)']['delete'] = 'private/multimedia/index/$1';

// Routes Render
$route['render/demo/(:any)'] = 'public/render/demo/$1';
$route['public/(:any)'] = 'public/render/render_public/$1';
$route['check-public'] = 'public/render/check_public';


// Routes render_private
$route['render']['get'] = 'private/render_private/index';
$route['render/(:any)']['get'] = 'private/render_private/find/$1';
$route['render/(:any)']['put'] = 'private/render_private/index/$1';
$route['render']['post'] = 'private/render_private/index';
$route['render/(:any)']['delete'] = 'private/render_private/index/$1';
$route['render/all-tvs']['post'] = 'private/render_private/save_all';

// Demo Saves
$route['render/demo-save']['post'] = 'private/render_private/save_demo';

// Routes Calendar
$route['calendar']['get'] = 'private/calendar/index';
$route['calendar/(:any)']['put'] = 'private/calendar/index/$1';

// Routes Schedules
$route['schedule']['get'] = 'private/schedules/index';
$route['schedule']['post'] = 'private/schedules/index';
$route['schedule/(:any)']['put'] = 'private/schedules/index/$1';
$route['schedule/(:any)']['delete'] = 'private/schedules/index/$1';





//Multimedia S3 o Externa
$route['multimedia/attach']['post'] = 'public/multimedia/attached';

