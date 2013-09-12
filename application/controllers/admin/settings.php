<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends MY_Controller 
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
		$this->load->model('model_clients');
		
		$company_id = $this->session->userdata('company_id');
		$user_type = $this->session->userdata('user_type');	
		
		// determine if permission denied
		if ($user_type < ROLE_AGENCY_ADMIN) {
			$_data['sess_user'] = $this->session->userdata;
			$_data['page'] = "error"; 
			$_data['content'] = $this->load->view('error/view_error_denied', $_data, TRUE);
			$this->load->view('admin/view_main_back', $_data);
			return;
		}
		
		$user_details = $this->model_users->getUserDetailsByUserId($this->session->userdata('user_id'));
		
		$company_details = $this->model_clients->getClientDetails($company_id);
		if (file_exists($this->config->item('base_client_path').$company_details['folder']."/logo.png")) {
			$company_details['logo'] = base_url() . "_clients/" . $company_details['folder'] . "/logo.png"; 
		} else {
			$company_details['logo'] = base_url() . "_assets/images/no_logo.png"; 
		}
		
		$logo_url = base_url() . "admin/settings/logo/" . $company_details['client_id'];
		$folder_path = $this->config->item("base_client_path") . $company_details['folder'];
	
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "settings";
		$_data['user_details'] = $user_details;
		$_data['company_details'] = $company_details;
		$_data['folder_path'] = $folder_path;
		$_data['logo_url'] = $logo_url;
		// $_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$_data['content'] = $this->load->view('admin/view_settings_edit', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function logo($client_id = 0)
	{
		$this->load->model('model_clients');
	
		if ($client_id == 0) { $client_id = $this->session->userdata('company_id'); }
		
		$company_details = $this->model_clients->getClientDetails($client_id);

		// determine if company logo exists
		$company_logo = "";
		if (file_exists($this->config->item('base_client_path').$company_details['folder']."/logo.png")) {
			$logo_path = base_url() . "_clients/" . $company_details['folder'] . "/logo.png"; 
		}
	
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['logo_path'] = $logo_path;
		$this->load->view('admin/view_logo', $_data);
		return;
	}
	
}
?>