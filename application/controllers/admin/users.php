<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends MY_Controller 
{

	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata['logged_in']) { redirect(site_url('admin/logout')); } // logged in?
		
		if( $this->session->userdata('user_type') && $this->session->userdata('user_type') < 10 ){ 
			// is non-ecommerce users
			// allow access
		}elseif( $this->session->userdata('user_type') == 10 ){
			// is superadmin
			// allow access
		}else{
			// is ecommerce users
			// dont allow access
			redirect(site_url('admin/accountmanagement')); 
		}
	}
	
	public function index()
	{
		$this->load->model('model_users');
	
		$company_id = $this->session->userdata('company_id');
		$user_type = $this->session->userdata('user_type');	

		if ($this->input->post('filter')) {
			$filter_arr = array('last_name' => $this->input->post('last_name'),
								'first_name' => $this->input->post('first_name'),
								'username' => $this->input->post('username'),
								'client_id' => $this->input->post('client_id'),
								'user_type_id' => $this->input->post('user_type_id'),
								'status' => $account_status);
		}		
		
		// get list of users
		$pagination_limit = 50;
		$current_page = 1;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$user_arr = $this->model_users->getUsers(	$company_id, 
													$user_type, 
													"last_name", 
													"asc", 
													$limit,
													$pagination_limit, 
													$filter_arr);
		$user_total_count = $user_arr['total_count'];
		unset($user_arr['total_count']);
		$user_arr = $this->getAvatarPath($user_arr);
		
		// populate reponse
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'has_filter' => $this->input->post('filter'),
								'letters' => $this->getAlphabet(),
								'clients' => $this->populateClients(),
								'filter_arr' => $filter_arr,  
								'user_types' => $this->populateUserRoles());
		//check if capable of ecommerce
		$templates_allowed = $this->session->userdata('templates_allowed');
		if( isset($templates_allowed) && count($templates_allowed) > 0 ){
			if( in_array(6, $templates_allowed) && $this->session->userdata('user_type') == ROLE_SUPER_ADMIN ){
				$_filter['ecommerce_user_types'] = $this->populateEcommerceUserRoles();
			}
		}
		$_pagination = array(	'page' => 'users',
								'filter_arr' => $filter_arr,
								'item_count' => $user_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "users";
		$_data['users'] = $user_arr;
		$_data['legend'] = $this->load->view('admin/view_users_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_users_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$_data['content'] = $this->load->view('admin/view_users', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
		
	public function add()
	{
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "users";
		$_data['user_types'] = $this->populateUserRoles();
		$_data['clients'] = $this->populateClients();
		$_data['content'] = $this->load->view('admin/view_users_add', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function view($user_id)
	{
		$this->load->model('model_users');
		$this->load->model('model_properties');
		
		$item_count = array();
		
		// get user details
		$user_details = $this->model_users->getUserDetailsByUserId($user_id);
		$user_details = $this->getAvatarPath($user_details);
		
		// get properties done by the user
		$properties = $this->model_properties->getPropertiesByUserId($user_id, "properties.last_edit", "desc", 0, 10);
		$item_count['properties'] = $properties['total_count'];
		unset($properties['total_count']);
		$properties = $this->addIdAsCode($properties, "template_id", 5);
		
		// get activity log of user
		$log = $this->model_main->getLogByUserId($user_id, 'date', 'desc', 0, 10);
		$item_count['log'] = $log['total_count'];
		unset($log['total_count']);

		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "users";
		$_data['user_details'] = $user_details;
		$_data['properties'] = $properties;
		$_data['item_count'] = $item_count;
		$_data['log'] = $log;
		$_data['content'] = $this->load->view('admin/view_users_view', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function edit($user_id)
	{
		$this->load->model('model_users');
		
		$user_type = $this->session->userdata('user_type');
		
		// get user details
		$user_details = $this->model_users->getUserDetailsByUserId($user_id);
		$user_details = $this->getAvatarPath($user_details);
		$folder_name = $this->padDigit($user_id, 5);
		$folder_path = $this->config->item("base_user_path") . $folder_name;
		$avatar_url = base_url() . "admin/account/avatar/" . $user_id;
		
		// determine if permission denied
		if ($user_type < $user_details['user_type_id'] && $user_details['user_type_id'] < ROLE_SUPER_ADMIN) {
			$_data['sess_user'] = $this->session->userdata;
			$_data['page'] = "error"; 
			$_data['content'] = $this->load->view('error/view_error_denied', $_data, TRUE);
			$this->load->view('admin/view_main_back', $_data);
			return;
		}
	
		// load response
		//check if capable of ecommerce
		$templates_allowed = $this->session->userdata('templates_allowed');
		if( isset($templates_allowed) && count($templates_allowed) > 0 ){
			if( in_array(6, $templates_allowed) && $this->session->userdata('user_type') == ROLE_SUPER_ADMIN ){
				$_data['ecommerce_user_types'] = $this->populateEcommerceUserRoles();
			}
		}
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "users"; 
		$_data['user_types'] = $this->populateUserRoles();
		$_data['user_details'] = $user_details;
		$_data['folder_path'] = $folder_path;
		$_data['avatar_url'] = $avatar_url;
		$_data['content'] = $this->load->view('admin/view_users_edit', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function process_add()
	{
		$this->load->model('model_users');
	
		$company_id = $this->session->userdata('company_id');
		$user_type = $this->session->userdata('user_type');
	
		$user_type_post = $this->input->post('user_type');
		$first_name = $this->cleanStringForDB($this->input->post('first_name'));
		$last_name = $this->cleanStringForDB($this->input->post('last_name'));
		$username = $this->cleanStringForDB($this->input->post('username'));
		$password = md5($this->input->post('password'));
		$client_id = $this->input->post('client_id');
		$timestamp = date("Y-m-d H:i:s", now());
		$member_since = date("Y-m-d H:i:s", now());
		
		// insert record
		$new_user_id = $this->model_users->addUser(	$username, 
													$timestamp, 
													$member_since, 
													$user_type_post, 
													$first_name, 
													$last_name, 
													$client_id);
		
		// log changes
		$log = "Added user ".$username;
		$this->model_main->addLog($log, "Add user", $timestamp);
		
		// create a folder inside the _users folder as well
		$new_user_folder = $this->config->item("base_user_path").$this->padDigit($new_user_id, 5);
		$default_user_folder = $this->config->item("base_user_path")."_default";
		@mkdir($new_user_folder);
		@chmod($new_user_folder, 0755);
		
		// get path of avatar and user arr
		$current_page = 1;
		$pagination_limit = 50;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$user_arr = $this->model_users->getUsers($company_id, $user_type, "last_name", "asc", $limit);
		$user_total_count = $user_arr['total_count'];
		unset($user_arr['total_count']);
		$user_arr = $this->getAvatarPath($user_arr);
		
		// get user details
		$user_id = $new_user_id;
		$user_details = $this->model_users->getUserDetailsByUserId($user_id);
		$user_username = $user_details['username'];
		$user_fullname = $user_details['first_name'] . " " . $user_details['last_name'];
		
		// get admin details
		$admin_id = $this->session->userdata('user_id');
		$admin_details = $this->model_users->getUserDetailsByUserId($admin_id);
		$admin_username = $admin_details['username'];
		$admin_fullname = $admin_details['first_name'] . " " . $admin_details['last_name'];
		
		// reset password
		$new_password = $this->generateRandomPassword();
		$encrypted_password = md5($new_password);
		$this->model_users->resetPassword($user_id, $encrypted_password);
		
		// send the email
		$_data['new_password'] = $new_password;
		$_data['user_fullname'] = $user_fullname;
		$message = $this->load->view('email/view_usercreated', $_data, true);
			
		$config['mailtype'] = 'html';
		
		$this->load->library('email');
		$this->email->initialize($config);
		$this->email->from('no-reply@sitemee.com', 'Sitemee');
		$this->email->reply_to($admin_username, $admin_fullname);
		$this->email->to($user_username); 
		$this->email->subject('Sitemee New User');
		$this->email->message($message);	
		$this->email->send();
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => 1,
								'has_filter' => 1,
								'letters' => $this->getAlphabet(),
								'clients' => $this->populateClients(),
								'filter_arr' => $filter_arr,  
								'user_types' => $this->populateUserRoles());
		$_pagination = array(	'page' => 'users',
								'item_count' => $user_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['users'] = $user_arr;
		$_data['filter'] = $this->load->view('admin/view_users_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$this->load->view('admin/view_users', $_data);
		return;
	}
	
	public function process_edit()
	{
		$this->load->model('model_users');
	
		$user_id = $this->input->post('user_id');
		$user_type = $this->input->post('user_type');
		$first_name = $this->cleanStringForDB($this->input->post('first_name'));
		$last_name = $this->cleanStringForDB($this->input->post('last_name'));
		$username = $this->cleanStringForDB($this->input->post('username'));
		$timestamp = date("Y-m-d H:i:s", now());
		$status = $this->input->post('status');
		if ($status == "active") { $status = 1; } else { $status = 0; }
		
		// perform operation
		$this->model_users->editUser($user_id, $user_type, $first_name, $last_name, $username, $status);
		
		// log changes
		$log = "Edited user ".$username;
		$this->model_main->addLog($log, "Edit user", $timestamp);
		
		// get user details
		$user_details = $this->model_users->getUserDetailsByUserId($user_id);
		$user_details = $this->getAvatarPath($user_details);
		$folder_name = $this->padDigit($user_id, 5);
		$folder_path = $this->config->item("base_user_path") . $folder_name;
		$avatar_path = base_url() . "_users/" . $folder_name . "/avatar.png";
		$avatar_url = base_url() . "admin/account/avatar/" . $user_id;
	
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['user_types'] = $this->populateUserRoles();
		$_data['user_details'] = $user_details;
		$_data['folder_path'] = $folder_path;
		$_data['user_avatar'] = $avatar_path;
		$_data['avatar_url'] = $avatar_url;
		$this->load->view('admin/view_users_edit', $_data);
		return;
	}
	
	public function process_deactivate()
	{	
		$this->load->model('model_users');
	
		$company_id = $this->session->userdata('company_id');
		$user_type = $this->session->userdata('user_type');
		
		if ($this->input->post('filter')) {
			$filter_arr = array('last_name' => $this->input->post('last_name'),
								'first_name' => $this->input->post('first_name'),
								'username' => $this->input->post('username'),
								'client_id' => $this->input->post('client_id'),
								'user_type_id' => $this->input->post('user_type_id'),
								'status' => $this->input->post('status'));
		}	
		
		$user_id = $this->input->post('user_id');
		$current_page = $this->input->post('current_page');
		$timestamp = date("Y-m-d H:i:s", now());
		
		// get user details
		$user_details = $this->model_users->getUserDetailsByUserId($user_id);
		$username = $user_details['username'];
		
		// deactivate user
		$this->model_users->deactivateUser($user_id);
		
		// log changes
		$log = "Deleted user ".$username;
		$this->model_main->addLog($log, "Delete user", $timestamp);
		
			// just get the number of clients for this instance
		$user_arr = $this->model_users->getUsers(	$company_id, 
													$user_type, 
													"users.last_name", 
													"asc", 
													1,
													1,
													$filter_arr);
		// determine if current page still has contents
		$pagination_limit = 50;
		$item_count = $user_arr['total_count'];
		if (($current_page * $pagination_limit) >= $item_count) {
			$current_page = ceil($item_count / $pagination_limit);
		}
		
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		if ($limit < 0) { $limit = 0; $current_page = 1; }
		$user_arr = $this->model_users->getUsers(	$company_id, 
													$user_type, 
													"users.last_name", 
													"asc", 
													$limit,
													$pagination_limit,
													$filter_arr);
		$user_total_count = $user_arr['total_count'];
		unset($user_arr['total_count']);
		$user_arr = $this->getAvatarPath($user_arr);
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'has_filter' => $this->input->post('filter'),
								'letters' => $this->getAlphabet(),
								'clients' => $this->populateClients(),
								'filter_arr' => $filter_arr,  
								'user_types' => $this->populateUserRoles());
		$_pagination = array(	'page' => 'users',
								'filter_arr' => $filter_arr,
								'item_count' => $user_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['users'] = $user_arr;
		$_data['filter'] = $this->load->view('admin/view_users_filter', $_filter, TRUE);		
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);		
		$this->load->view('admin/view_users', $_data);
		return;
	}
	
	public function process_items()
	{
		$this->load->model('model_users');
	
		$company_id = $this->session->userdata('company_id');
		$user_type = $this->session->userdata('user_type');		
		
		if ($this->input->post('filter')) {
			$filter_arr = array('last_name' => $this->input->post('last_name'),
								'first_name' => $this->input->post('first_name'),
								'username' => $this->input->post('username'),
								'client_id' => $this->input->post('client_id'),
								'user_type_id' => $this->input->post('user_type_id'),
								'status' => $this->input->post('status'));
		}
		
		// get path of avatar
		$pagination_limit = 50;
		$current_page = $this->input->post('current_page');
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$user_arr = $this->model_users->getUsers(	$company_id, 
													$user_type, 
													"last_name", 
													"asc", 
													$limit, 
													$pagination_limit, 
													$filter_arr);
		$user_total_count = $user_arr['total_count'];
		unset($user_arr['total_count']);
		$user_arr = $this->getAvatarPath($user_arr);
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata, 
								'current_page' => $current_page,
								'has_filter' => $this->input->post('filter'),
								'letters' => $this->getAlphabet(),
								'clients' => $this->populateClients(),
								'filter_arr' => $filter_arr,  
								'user_types' => $this->populateUserRoles());
		$_pagination = array(	'page' => 'users',
								'filter_arr' => $filter_arr,
								'item_count' => $user_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data = array();
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "users";
		$_data['users'] = $user_arr;
		$_data['filter'] = $this->load->view('admin/view_users_filter', $_filter, true);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, true);
		$this->load->view('admin/view_users', $_data);
		return;
	}
	
	public function reset_password()
	{
		$this->load->model('model_users');
		
		// get user details
		$user_id = $this->input->post('user_id');
		$user_details = $this->model_users->getUserDetailsByUserId($user_id);
		$user_username = $user_details['username'];
		$user_fullname = $user_details['first_name'] . " " . $user_details['last_name'];
		
		// get admin details
		$admin_id = $this->session->userdata('user_id');
		$admin_details = $this->model_users->getUserDetailsByUserId($admin_id);
		$admin_username = $admin_details['username'];
		$admin_fullname = $admin_details['first_name'] . " " . $admin_details['last_name'];
		
		// reset password
		$new_password = $this->generateRandomPassword();
		$encrypted_password = md5($new_password);
		$this->model_users->resetPassword($user_id, $encrypted_password);
		
		// send the email
		$_data['new_password'] = $new_password;
		$_data['user_fullname'] = $user_fullname;
		$message = $this->load->view('email/view_resetpassword', $_data, true);
			
		$config['mailtype'] = 'html';
		
		$this->load->library('email');
		$this->email->initialize($config);
		$this->email->from('no-reply@sitemee.com', 'Sitemee');
		$this->email->reply_to($admin_username, $admin_fullname);
		$this->email->to($user_username); 
		$this->email->subject('Sitemee Password Reset');
		$this->email->message($message);	
		$this->email->send();
		
		echo $this->email->print_debugger();
		return;
	}
	
	public function check_dependencies()
	{
		$this->load->model('model_users');
		$this->load->model('model_properties');
		
		$user_id = $this->input->post('user_id');
		$properties = $this->model_properties->getPropertiesByUserId($user_id, "properties.last_edit", "desc", 0, 10);
		unset($properties['total_count']);
		
		if ($properties) 
		{ 
			echo "0"; 
		} 
		else 
		{
			// perform delete here if no properties linked to users
			$this->model_users->deleteUser($user_id);
	
			$company_id = $this->session->userdata('company_id');
			$user_type = $this->session->userdata('user_type');	
			
			// get list of users
			$pagination_limit = 50;
			$current_page = 1;
			$limit = ($current_page * $pagination_limit) - $pagination_limit;
			$user_arr = $this->model_users->getUsers(	$company_id, 
														$user_type, 
														"last_name", 
														"asc", 
														$limit,
														$pagination_limit, 
														$filter_arr);
			$user_total_count = $user_arr['total_count'];
			unset($user_arr['total_count']);
			$user_arr = $this->getAvatarPath($user_arr);
			
			// populate reponse
			$_filter = array(		'sess_user' => $this->session->userdata,
									'current_page' => $current_page,
									'has_filter' => $this->input->post('filter'),
									'letters' => $this->getAlphabet(),
									'clients' => $this->populateClients(),
									'filter_arr' => $filter_arr,  
									'user_types' => $this->populateUserRoles());
			$_pagination = array(	'page' => 'users',
									'filter_arr' => $filter_arr,
									'item_count' => $user_total_count,
									'pagination_limit' => $pagination_limit,
									'current_page' => $current_page);
			
			// load response
			$_data['sess_user'] = $this->session->userdata;
			$_data['page'] = "users";
			$_data['users'] = $user_arr;
			$_data['filter'] = $this->load->view('admin/view_users_filter', $_filter, TRUE);
			$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
			$_data['content'] = $this->load->view('admin/view_users', $_data, TRUE);
			$this->load->view('admin/view_main_back', $_data);
		}
	
		return;
	}
	
	public function get_company_user_types()
	{
		$company_id = $this->input->post('company_id');
		$this->load->model('model_clients');
		$company_details = $this->model_clients->getClientDetails($company_id);
		
		$user_types = $this->populateUserRoles();
		
		// if the company is not an agency, remove the agency level admin option
		if ($company_details['agency_id'] != 0) {
			$counter = 0;
			if ($user_types) {
			foreach ($user_types as $user_type => $ut) {
				if ($ut['user_type_id']	== ROLE_AGENCY_ADMIN) { unset($user_types[$counter]); }
				$counter++;
			}
			}
		}
		
		$_data['user_types'] = $user_types;
		//check if capable of ecommerce
		$templates_allowed = $this->session->userdata('templates_allowed');
		if( isset($templates_allowed) && count($templates_allowed) > 0 ){
			if( in_array(6, $templates_allowed) && $this->session->userdata('user_type') == ROLE_SUPER_ADMIN ){
				$_data['ecommerce_user_types'] = $this->populateEcommerceUserRoles();
			}
		}
		$_data['sess_user'] = $this->session->userdata;
		$this->load->view('admin/view_users_add_usertypes', $_data);
		return;
	}
	
}
?>