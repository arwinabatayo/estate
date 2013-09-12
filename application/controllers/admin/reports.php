<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends MY_Controller 
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
		$this->load->model('model_properties');
		$this->load->model('model_clients');
	
		$company_id = $this->session->userdata('company_id');
		$user_type = $this->session->userdata('user_type');	
		
		if ($user_type == ROLE_SUPER_ADMIN) { $summary = $this->getSummary(); } 
		else { $summary = $this->getGeneralSummary(); }
		
		// retrieve client details
		$client_details = $this->model_clients->getClientDetails($company_id);
		$client_details['disk_space_text'] = $this->formatSize($client_details['disk_space']);
		$client_details['percentage'] = ($summary['properties_disk']['num'] / $client_details['disk_space']) * 100;
		
		// retrieve properties
		$property_arr = $this->model_properties->getProperties($company_id, $user_type, "properties.title", "asc", 0, "all", null);
		unset($property_arr['total_count']);
		$property_arr = $this->addIdAsCode($property_arr, "template_id", 5);
		$property_arr = $this->getAvatarPath($property_arr);
		
		// retrieve size of each property folder
		$counter = 0;
		if ($property_arr) {
		foreach ($property_arr as $property => $p) {
			$property_arr[$counter]['folder_size'] = $this->getFolderSize($this->config->item('base_property_path').$p['folder_name']."/");
			$property_arr[$counter]['folder_size_text'] = $this->formatSize($property_arr[$counter]['folder_size']);	
			$property_arr[$counter]['percentage'] = round((($property_arr[$counter]['folder_size'] / $client_details['disk_space']) * 100), 2) . "%";
			$counter++;
		}
		}
		$property_arr = $this->arraySort($property_arr, 'percentage', SORT_DESC); // sort array

		/*
		// retrieve properties
		$property_arr = $this->model_properties->getProperties($company_id, $user_type, "properties.title", "asc", 0, "all", null);
		unset($property_arr['total_count']);
		
		// retrieve size of each property folder
		$counter = 0;
		$highest_val = 0;
		if ($property_arr) {
		foreach ($property_arr as $property => $p) {
			$property_arr[$counter]['folder_size'] = $this->getFolderSize($this->config->item('base_property_path').$p['folder_name']."/");
			$property_arr[$counter]['folder_size_text'] = $this->formatSize($property_arr[$counter]['folder_size']);	
			if ($highest_val < $property_arr[$counter]['folder_size']) {
				$highest_val = $property_arr[$counter]['folder_size'];
			}
			$counter++;
		}
		}
		
		// retrieve ratio
		$counter = 0;
		if ($property_arr) {
		foreach ($property_arr as $property => $p) {
			$property_arr[$counter]['percent'] = ($property_arr[$counter]['folder_size'] / $highest_val) * 100;
			$counter++; 
		}
		}
		*/

		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "reports";
		$_data['summary'] = $summary;
		$_data['client_details'] = $client_details;
		$_data['properties'] = $property_arr;
		$_data['content'] = $this->load->view('admin/view_reports', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
}
?>