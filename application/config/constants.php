<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

define('ROLE_ONLINE_SALES', 16);
define('ROLE_GLOBE_BUSINESS_SALES_SUPPORT_TEAM', 15);
define('ROLE_PLATINUM_QUEUE', 14);
define('ROLE_ACCOUNT_MANAGER', 13);
define('ROLE_RELATIONSHIP_MANAGER', 12);
define('ROLE_AGENT_ACCESS', 11);
define('ROLE_SUPER_ADMIN', 10);
define('ROLE_AGENCY_ADMIN', 5);
define('ROLE_COMPANY_ADMIN', 4);
define('ROLE_COMPANY_USER', 3);
define('ROLE_AGENT', 2);

//ACCOUNT CATEGORY
define('ACCOUNT_CATEGORY_PLATINUM',  1);
define('ACCOUNT_CATEGORY_BUSINESS',  2);
define('ACCOUNT_CATEGORY_PERSONAL',  3);

//ORDER STATUS
define('ORDERSTATUS_FOR_PROCESSING', 1);
define('ORDERSTATUS_FOR_APPROVAL', 2);
define('ORDERSTATUS_DONE', 3);
define('ORDERSTATUS_APPROVED', 4);
define('ORDERSTATUS_FOR_DISAPPROVED', 5);
define('ORDERSTATUS_FOR_NEEDS_ADDITIONAL_DOC', 6);


define('SUPPORT_EMAIL', 'support@sitemee.com');
define('SUPPORT_NAME', 'Jeri Ilao');

/* End of file constants.php */
/* Location: ./application/config/constants.php */