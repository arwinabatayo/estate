<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['base_url']	= '';
$config['index_page'] = '';
$config['uri_protocol']	= 'AUTO';
$config['url_suffix'] = '';
$config['language']	= 'english';
$config['charset'] = 'UTF-8';
$config['enable_hooks'] = FALSE;
$config['subclass_prefix'] = 'MY_';
$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-';
$config['allow_get_array']		= TRUE;
$config['enable_query_strings'] = FALSE;
$config['controller_trigger']	= 'c';
$config['function_trigger']		= 'm';
$config['directory_trigger']	= 'd'; // experimental not currently in use
$config['log_threshold'] = 0;
$config['log_path'] = '';
$config['log_date_format'] = 'Y-m-d H:i:s';
$config['cache_path'] = '';
$config['encryption_key'] = 'exodus1421!';
$config['sess_cookie_name']		= 'cisession';
$config['sess_expiration']		= 72000;
$config['sess_expire_on_close']	= FALSE;
$config['sess_encrypt_cookie']	= FALSE;
$config['sess_use_database']	= TRUE;
$config['sess_table_name']		= 'ci_sessions';
$config['sess_match_ip']		= TRUE;
$config['sess_match_useragent']	= TRUE;
$config['sess_time_to_update']	= 300;
$config['cookie_prefix']	= "";
$config['cookie_domain']	= "";
$config['cookie_path']		= "/";
$config['cookie_secure']	= FALSE;
$config['global_xss_filtering'] = FALSE;
$config['csrf_protection'] = FALSE;
$config['csrf_token_name'] = 'csrf_test_name';
$config['csrf_cookie_name'] = 'csrf_cookie_name';
$config['csrf_expire'] = 7200;
$config['compress_output'] = FALSE;
$config['time_reference'] = 'local';
$config['rewrite_short_tags'] = FALSE;
$config['proxy_ips'] = '';

$config['base_path'] = $_SERVER['DOCUMENT_ROOT'] . '/globe-estate/';
$config['base_user_path'] = $_SERVER['DOCUMENT_ROOT']."/globe-estate/_users/";
$config['base_property_path'] = $_SERVER['DOCUMENT_ROOT']."/globe-estate/_properties/";
$config['base_template_path'] = $_SERVER['DOCUMENT_ROOT']."/globe-estate/_templates/";
$config['base_asset_path'] = $_SERVER['DOCUMENT_ROOT']."/globe-estate/_assets/";
$config['base_client_path'] = $_SERVER['DOCUMENT_ROOT']."/globe-estate/_clients/";
$config['base_product_path'] = $_SERVER['DOCUMENT_ROOT']."/globe-estate/_products/";
$config['base_property_url'] = "/globe-estate/_properties/";
$config['base_asset_url'] = "/globe-estate/_assets/";
$config['base_product_url'] = "/globe-estate/_products/";

//GLOBE ESTATE CONFIG
$config['globe_estate_template_path'] = "globe-estate/index"; //default template view
$config['globe_estate_assets'] = "_assets/estate/";


