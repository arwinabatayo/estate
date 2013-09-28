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

$route['default_controller'] = "home";
$route['admin'] = 'admin/login';
$route['404_override'] = 'error_404';

$route['admin/reports/log'] = 'admin/reports_log';
$route['admin/reports/clients'] = 'admin/reports_clients';

$route['forgot/(:any)'] = 'forgot/index/$1';
$route['preview/(:any)'] = 'preview/index/$1/$2';

$route['sms-verification']  = 'home/sms_verification';
$route['sku-configuration'] = 'home/sku_configuration';
$route['subscriber-info']   = 'subscriber/index';
$route['plan-summary']      = 'payment/plan_summary';
$route['delivery-pickup']   = 'payment/delivery_pickup';
$route['shipping-address']  = 'payment/shipping_address';
$route['pickup-store']      = 'payment/pickup_store';
$route['confirm-order']     = 'payment/confirm_order';
$route['payment-method']    = 'payment/payment_method';
$route['payment-checkout']  = 'payment/payment_form';
$route['survey']            = 'payment/survey';
$route['thankyou']          = 'payment/thankyou';

/* End of file routes.php */
/* Location: ./application/config/routes.php */

