<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller 
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
		$this->load->model('model_templates');
		$this->load->model('model_properties');
	
		$company_id = $this->session->userdata('company_id');
		$user_type = $this->session->userdata('user_type');
		
		if ($user_type >= ROLE_AGENCY_ADMIN) { $summary = $this->getSummary(); } 
		else { $summary = $this->getGeneralSummary(); }
		
		// retrieve client details
		$client_details = $this->model_clients->getClientDetails($company_id);
		$client_details['disk_space_text'] = $this->formatSize($client_details['disk_space']);
		$client_details['percentage'] = ($summary['properties_disk']['num'] / $client_details['disk_space']) * 100;
		
		$user_arr = $this->model_users->getUsers($company_id, $user_type, 'member_since', 'desc', 0, 6);
		unset($user_arr['total_count']);
		$user_arr = $this->getAvatarPath($user_arr);
		
		$template_arr = $this->model_templates->getTemplates($company_id, $user_type, 'last_edit', 'desc', 0, 6);
		unset($template_arr['total_count']);
		
		$property_arr = $this->model_properties->getProperties($company_id, $user_type, 'properties.last_edit', 'desc', 0, 6);
		unset($property_arr['total_count']);
		$property_arr = $this->addIdAsCode($property_arr, "template_id", 5);
		$property_arr = $this->getAvatarPath($property_arr);
		
		$log = $this->model_main->getLog($company_id, $user_type, "date", "desc", 0);
		unset($log['total_count']);
		$log = $this->getAvatarPath($log);
	
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "dashboard";
		$_data['summary'] = $summary;
		$_data['client_details'] = $client_details;
		$_data['datastatistics_arr'] = $this->populateSummary($company_id, $user_type);
		$_data['user_arr'] = $user_arr;
		$_data['template_arr'] = $template_arr;
		$_data['property_arr'] = $property_arr;
		$_data['log'] = $log;
		$_data['content'] = $this->load->view('admin/view_dashboard', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
}
?>