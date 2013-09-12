<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends MY_Controller 
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
		$this->load->model('model_properties');
		$this->load->model('model_clients');
	
		// get user details
		$user_id = $this->session->userdata('user_id');
		$user_details = $this->model_users->getUserDetailsByUserId($user_id);
		$user_details = $this->getAvatarPath($user_details);
		
		// get company package
		$feature_arr = $this->model_clients->getClientFeatures($user_details['company_id']);
		
		// get properties done by the user
		$properties = $this->model_properties->getPropertiesByUserId($user_id, "properties.last_edit", "desc", 0, 10);
		$property_total_count = $properties['total_count'];
		unset($properties['total_count']);
		$properties = $this->addIdAsCode($properties, "template_id", 5);
		
		// get activity log
		$log = $this->model_main->getLogByUserId($user_id, 'date', 'desc', 0, 10);
		$log_total_count = $log['total_count'];
		unset($log['total_count']);
		
		// get item count for widgets
		$item_count['properties'] = $property_total_count;
		$item_count['log'] = $log_total_count;;
		
		// load response
		$_data['sess_user'] 	= $this->session->userdata;
		$_data['page'] 			= "account";
		$_data['user_details']	= $user_details;
		$_data['features'] 		= $feature_arr;
		$_data['properties'] 	= $properties;
		$_data['log'] 			= $log;
		$_data['item_count'] 	= $item_count;
		$_data['content'] 		= $this->load->view('admin/view_account_view', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function edit()
	{
		$this->load->model('model_users');
	
		// get user details
		$user_id 		= $this->session->userdata('user_id');
		$user_details 	= $this->model_users->getUserDetailsByUserId($user_id);
		$user_details 	= $this->getAvatarPath($user_details);
		$folder_name 	= $this->padDigit($user_id, 5);
		$folder_path 	= $this->config->item("base_user_path") . $folder_name;
		$avatar_url 	= base_url() . "admin/account/avatar";
		$profile_url 	= base_url() . "admin/account/profile";
		
		// load response
		$_data['sess_user'] 	= $this->session->userdata;
		$_data['page'] 			= "account";
		$_data['user_roles'] 	= $this->populateUserRoles();
		$_data['user_details'] 	= $user_details;
		$_data['folder_path'] 	= $folder_path;
		$_data['avatar_url'] 	= $avatar_url;
		$_data['profile_url'] 	= $profile_url;
		$_data['content'] 		= $this->load->view('admin/view_account_edit', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function avatar($user_id = 0)
	{
		$this->load->model('model_users');
	
		if ($user_id == 0) { $user_id = $this->session->userdata('user_id'); }
		$avatar_path = base_url() . "_users/" . $this->padDigit($user_id, 5) . "/avatar.png";
	
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['user_avatar'] = $avatar_path;
		$this->load->view('admin/view_avatar', $_data);
		return;
	}
	
	public function process_edit()
	{
		$this->load->model('model_users');
		
		$user_id = $this->input->post('user_id');
		$username = $this->cleanStringForDB($this->input->post('username'));
		$first_name = $this->cleanStringForDB($this->input->post('first_name'));
		$last_name = $this->cleanStringForDB($this->input->post('last_name'));
		if ($this->input->post('change_password')) { $new_password = md5($this->input->post('new_password')); }
		$avatar_url = base_url() . "admin/account/avatar";
		$profile_url = base_url() . "admin/account/profile";
		$timestamp = date("Y-m-d H:i:s", now());
		
		$folder_name = $this->padDigit($user_id, 5);
		$folder_path = $this->config->item("base_user_path") . $folder_name;
		
		// perform operation
		$this->model_users->editAccount($user_id, $first_name, $last_name, $new_password);
		
		// log changes
		$log = "Edited account";
		$this->model_main->addLog($log, "Edit account", $timestamp);
		
		// set new session variables as well
		$newdata = array(
			'first_name' => $first_name,
			'last_name'	=> $last_name
		);
		$this->session->set_userdata($newdata);
		
		$user_details = $this->model_users->getUserDetailsByUserId($user_id);
		$user_details = $this->getAvatarPath($user_details);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['user_roles'] = $this->populateUserRoles();
		$_data['user_details'] = $user_details;
		$_data['folder_path'] = $folder_path;
		$_data['user_avatar'] = base_url() . "_users/" . $this->padDigit($user_id, 5) . "/avatar.png?" . time();
		$_data['avatar_url'] = $avatar_url;
		$_data['profile_url'] = $profile_url;
		$this->load->view('admin/view_account_edit', $_data);
		return;
	}
	
}
?>