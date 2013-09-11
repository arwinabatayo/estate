<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Configurations extends MY_Controller 
{

	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata['logged_in']) { redirect(site_url('admin/logout')); } // logged in?
	}
	
	public function index(){
		redirect(site_url('admin/properties'));
	}
	
	public function property($property_id=null)
	{
		if ($property_id==null) { redirect(site_url('admin/properties')); } // has property_id?
		
		$this->load->model('model_configurations');
		
		$user_type = $this->session->userdata('user_type');	
		
		$filter_arr = array();
		$filter_arr['property_id'] = $property_id;
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve configurations
		$pagination_limit = 5;
		$current_page = 1;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$configuration_arr = $this->model_configurations->getConfigurations($property_id, 
																			$user_type, 
																			"configurations.label", 
																			"asc", 
																			$limit,
																			$pagination_limit,
																			$filter_arr);
		$configuration_total_count = $configuration_arr['total_count'];
		unset($configuration_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['configurations'] == $configuration_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'property_id' => $property_id,
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'configurations',
								'filter_arr' => $filter_arr,
								'item_count' => $configuration_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "configurations";
		$_data['item_count'] = $item_count;
		$_data['property_id'] = $property_id;
		$_data['configurations'] = $configuration_arr;
		$_data['legend'] = $this->load->view('admin/view_configurations_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_configurations_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$_data['content'] = $this->load->view('admin/view_configurations', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function add($property_id=null)
	{
		if ($property_id==null) { redirect(site_url('admin/properties')); } // has property_id?
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "configurations";
		$_data['property_id'] = $property_id;
		$_data['content'] = $this->load->view('admin/view_configurations_add', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function process_add()
	{
		$this->load->model('model_configurations');
		
		$property_id = "";
		if ($this->input->post('property_id')) { $property_id = $this->input->post('property_id'); }
		
		//add configurations
		$configuration_label = $this->input->post('label');
		if( !$this->input->post('status') 
			|| $this->input->post('status') == '' 
			|| $this->input->post('status') == '0' 
			|| $this->input->post('status') == 0 )
		{ 
			$configuration_status = 0;
		}else{
			$configuration_status = $this->input->post('status');
		}
		$this->model_configurations->addConfiguration($property_id, $this->cleanStringForDB($configuration_label), $configuration_status);
		
		$configuration_details = $this->model_configurations->getConfigurationDetails($configuration_id);
		
		// log changes
		$log = "Added configuration " . $configuration_details['property_title'];
		$this->model_main->addLog($log, "Add configuration", $timestamp);
		
		//
		$company_id = $this->session->userdata('company_id');
		$user_type = $this->session->userdata('user_type');	
	
		$filter_arr = array();
		$filter_arr['property_id'] = $property_id;
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve configurations
		$pagination_limit = 5;
		$current_page = 1;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$configuration_arr = $this->model_configurations->getConfigurations($property_id, 
																		$user_type, 
																		"configurations.label", 
																		"asc", 
																		$limit,
																		$pagination_limit,
																		$filter_arr);
		$configuration_total_count = $configuration_arr['total_count'];
		unset($configuration_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['configurations'] == $configuration_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'configurations',
								'filter_arr' => $filter_arr,
								'item_count' => $configuration_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "configurations";
		$_data['item_count'] = $item_count;
		$_data['property_id'] = $property_id;
		$_data['configurations'] = $configuration_arr;
		$_data['legend'] = $this->load->view('admin/view_configurations_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_configurations_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$this->load->view('admin/view_configurations', $_data);
		return;
	}
	
	public function edit($configuration_id=null)
	{
		$this->load->model('model_configurations');
		
		if ($configuration_id==null) { redirect(site_url('admin/properties')); } // has configuration_id?
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "configurations";
		$configuration_details = $this->model_configurations->getConfigurationDetails($configuration_id);
		
		if( empty($configuration_details) ){
			redirect(site_url('admin/properties'));
		}
		
		$_data['configuration_details'] = $configuration_details;
		$_data['configuration_id'] = $configuration_id;
		$_data['content'] = $this->load->view('admin/view_configurations_edit', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function process_edit()
	{
		$this->load->model('model_configurations');
		
		$configuration_id = "";
		if ($this->input->post('configuration_id')) { $configuration_id = $this->input->post('configuration_id'); }
		if ($this->input->post('property_id')) { $property_id = $this->input->post('property_id'); }
		
		//add configurations
		$configuration_label = $this->input->post('label');
		if( !$this->input->post('status') 
			|| $this->input->post('status') == '' 
			|| $this->input->post('status') == '0' 
			|| $this->input->post('status') == 0 )
		{ 
			$configuration_status = 0;
		}else{
			$configuration_status = $this->input->post('status');
		}
		
		$this->model_configurations->editConfiguration($configuration_id, $this->cleanStringForDB($configuration_label), $configuration_status);
		
		// log changes
		$log = "Edited configuration " . $this->cleanStringForDB($configuration_label);
		$this->model_main->addLog($log, "Edit configuration", $timestamp);
		
		//
		$company_id = $this->session->userdata('company_id');
		$user_type = $this->session->userdata('user_type');	
	
		$filter_arr = array();
		$filter_arr['property_id'] = $property_id;
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve configurations
		$pagination_limit = 5;
		$current_page = 1;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$configuration_arr = $this->model_configurations->getConfigurations($property_id, 
																		$user_type, 
																		"configurations.label", 
																		"asc", 
																		$limit,
																		$pagination_limit,
																		$filter_arr);
		$configuration_total_count = $configuration_arr['total_count'];
		unset($configuration_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['configurations'] == $configuration_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'configurations',
								'filter_arr' => $filter_arr,
								'item_count' => $configuration_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "configurations";
		$_data['item_count'] = $item_count;
		$_data['property_id'] = $property_id;
		$_data['configurations'] = $configuration_arr;
		$_data['legend'] = $this->load->view('admin/view_configurations_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_configurations_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$this->load->view('admin/view_configurations', $_data);
		return;
	}
	
	public function process_items()
	{	
		$this->load->model('model_configurations');
		
		$user_type = $this->session->userdata('user_type');	
		
		if ($this->input->post('property_id')) {
			$property_id = $this->input->post('property_id');	
		}else{
			$property_id = 0;
		}
		$filter_arr = array();
		$filter_arr['property_id'] = $property_id;
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve configurations
		$pagination_limit = 5;
		$current_page = $this->input->post('current_page');
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$configuration_arr = $this->model_configurations->getConfigurations($property_id, 
																			$user_type, 
																			"configurations.label", 
																			"asc", 
																			$limit,
																			$pagination_limit,
																			$filter_arr);
		$configuration_total_count = $configuration_arr['total_count'];
		unset($configuration_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['configurations'] == $configuration_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'property_id' => $property_id,
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'configurations',
								'filter_arr' => $filter_arr,
								'item_count' => $configuration_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "configurations";
		$_data['item_count'] = $item_count;
		$_data['property_id'] = $property_id;
		$_data['configurations'] = $configuration_arr;
		$_data['legend'] = $this->load->view('admin/view_configurations_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_configurations_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$this->load->view('admin/view_configurations', $_data);
		return;
	}
	
	public function process_delete()
	{
		$this->load->model('model_configurations');
		
		$user_type = $this->session->userdata('user_type');
		
		if ($this->input->post('property_id')) {
			$property_id = $this->input->post('property_id');	
		}else{
			$property_id = 0;
		}
		$filter_arr = array();
		$filter_arr['property_id'] = $property_id;
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
		
		$configuration_id = $this->input->post('configuration_id');
		$current_page = $this->input->post('current_page');
		$timestamp = date("Y-m-d H:i:s", now());
		
		$configuration_details = $this->model_configurations->getConfigurationDetails($configuration_id);
		
		// delete configuration
		$this->model_configurations->deleteConfiguration($configuration_id);
		
		// log changes
		$log = "Deleted configuration " . $property_details['property_title'];
		$this->model_main->addLog($log, "Delete configuration", $timestamp);
		
		// just get the number of configurations for this instance
		$configuration_arr = $this->model_configurations->getConfigurations(	$property_id, 
																				$user_type, 
																				"configurations.label", 
																				'asc', 
																				1,
																				1,
																				$filter_arr);
		
		// determine if current page still has contents
		$pagination_limit = 5;
		$item_count = $configuration_arr['total_count'];
		if (($current_page * $pagination_limit) >= $item_count) {
			$current_page = ceil($item_count / $pagination_limit);
		}
		
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		if ($limit < 0) { $limit = 0; $current_page = 1; }
		$configuration_arr = $this->model_configurations->getConfigurations(	$property_id, 
																				$user_type, 
																				"configurations.label", 
																				'asc', 
																				$limit,
																				$pagination_limit,
																				$filter_arr);
		$configuration_total_count = $configuration_arr['total_count'];
		unset($configuration_arr['total_count']);
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'property_id' => $property_id,
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'configurations',
								'filter_arr' => $filter_arr,
								'item_count' => $configuration_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "configurations";
		$_data['item_count'] = $item_count;
		$_data['property_id'] = $property_id;
		$_data['configurations'] = $configuration_arr;
		$_data['legend'] = $this->load->view('admin/view_configurations_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_configurations_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$this->load->view('admin/view_configurations', $_data);
	}
}
?>