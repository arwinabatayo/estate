<?php 
/**
 * 9.16.2013
 * Ultima Logic
 * robert hughes
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class plans extends MY_Controller 
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata['logged_in']) { redirect(site_url('admin/logout')); } // logged in?
		
		if( $this->session->userdata('user_type') && $this->session->userdata('user_type') < 10 ){ 
			// is non-ecommerce users
			// dont allow access
			redirect(site_url('admin/dashboard')); 
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
		$this->load->model('model_plans');
		
		$user_type = $this->session->userdata('user_type');	
		
		$filter_arr = array();
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve plans
		$pagination_limit = 5;
		$current_page = 1;
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$plans_arr = $this->model_plans->getPlans(	$property_id, 
															$user_type, 
															"", 
															"asc", 
															$limit,
															$pagination_limit,
															$filter_arr);
		$plans_total_count = $plans_arr['total_count'];
		unset($plans_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['plans'] == $plans_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'plans',
								'filter_arr' => $filter_arr,
								'item_count' => $plans_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "plans";
		$_data['item_count'] = $item_count;
		$_data['plans'] = $plans_arr;
		$_data['legend'] = $this->load->view('admin/view_plans_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_plans_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$_data['content'] = $this->load->view('admin/view_plans', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function add()
	{
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "plans";
		$_data['content'] = $this->load->view('admin/view_plans_add', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function process_add()
	{
		$this->load->model('model_plans');
		
		$data					= array();
		$data['title'] 			= $this->cleanStringForDB($this->input->post('title'));
		$data['plan_cid'] 			= $this->cleanStringForDB($this->input->post('cid'));
		$data['description'] 	= $this->cleanStringForDB($this->input->post('description'));
		$data['long_desc'] 	= $this->cleanStringForDB($this->input->post('long_desc'));
		$data['amount'] 		= $this->cleanStringForDB($this->input->post('amount'));
		$data['max_gadget_pv'] = $this->cleanStringForDB($this->input->post('max_peso_value'));
		$data['total_pv'] 	= $this->cleanStringForDB($this->input->post('peso_value'));
		
		if( !$this->input->post('status') 
			|| $this->input->post('status') == '' 
			|| $this->input->post('status') == 'disabled' )
		{ 
			$data['is_active'] 									= 0;
		}elseif( $this->input->post('status') == 'enabled' ){
			$data['is_active'] 									= 1;
		}else{
			$data['is_active'] 									= 0;
		}
		
		//add plan
		$this->model_plans->addPlan($data);
		
		// log changes
		$plan = trim($this->input->post('plans_title'));
		$log = "Added plan " . $plan;
		$timestamp = date("Y-m-d H:i:s");
		$this->model_main->addLog($log, "Add plan", $timestamp);
		
		$user_type = $this->session->userdata('user_type');	
		
		$filter_arr = array();
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve plans
		$pagination_limit = 5;
		$current_page = 1;
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$plans_arr = $this->model_plans->getplans(	$property_id, 
																		$user_type, 
																		"", 
																		"asc", 
																		$limit,
																		$pagination_limit,
																		$filter_arr);
		$plan_total_count = $plans_arr['total_count'];
		unset($plans_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['plans'] == $plan_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'plans',
								'filter_arr' => $filter_arr,
								'item_count' => $plan_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "plans";
		$_data['item_count'] = $item_count;
		$_data['plans'] = $plans_arr;
		$_data['legend'] = $this->load->view('admin/view_plans_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_plans_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$this->load->view('admin/view_plans', $_data);
		return;
	}
	
	public function process_items()
	{
		$this->load->model('model_plans');
	
		$user_type = $this->session->userdata('user_type');	
		
		$filter_arr = array();
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve plans
		$pagination_limit = 5;
		$current_page = $this->input->post('current_page');
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$plans_arr = $this->model_plans->getplans(	$property_id, 
															$user_type, 
															"", 
															"asc", 
															$limit,
															$pagination_limit,
															$filter_arr);
		$plans_total_count = $plans_arr['total_count'];
		unset($plans_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['plans'] == $plans_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'plans',
								'filter_arr' => $filter_arr,
								'item_count' => $plans_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "plans";
		$_data['item_count'] = $item_count;
		$_data['plans'] = $plans_arr;
		$_data['legend'] = $this->load->view('admin/view_plans_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_plans_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$this->load->view('admin/view_plans', $_data);
		return;
	}
	
	
	
	public function edit($plans_id=null)
	{
		$this->load->model('model_plans');
		$this->load->model('model_properties');
		
		if ($plans_id == null) { redirect(site_url('admin/plans')); } // plans_id?
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "plans";
		
		$_data['properties'] = $this->model_properties->getPropertiesByUserId($this->session->userdata('user_id'), "properties.last_edit", "desc", 0, 100);
		$_data['plan_id'] = $plans_id;
		$_data['plans_details'] = $this->model_plans->getPlanDetails($plans_id);
		$_data['content'] = $this->load->view('admin/view_plans_edit', $_data, TRUE);
		
		
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function process_edit()
	{
		$this->load->model('model_plans');
		
		$data					= array();
		$tmp_data_attr			= array();
		$data['title'] 			= $this->cleanStringForDB($this->input->post('title'));
		$data['plan_cid'] 		= $this->cleanStringForDB($this->input->post('cid'));
		$data['description'] 	= $this->cleanStringForDB($this->input->post('description'));
		$data['long_desc'] 		= $this->cleanStringForDB($this->input->post('long_desc'));
		$data['amount'] 		= $this->cleanStringForDB($this->input->post('amount'));
		$data['max_gadget_pv'] 	= $this->cleanStringForDB($this->input->post('max_peso_value'));
		$data['total_pv'] 		= $this->cleanStringForDB($this->input->post('peso_value'));
		
		
		if( !$this->input->post('status') 
			|| $this->input->post('status') == '' 
			|| $this->input->post('status') == 'disabled' )
		{ 
			$data['is_active'] 									= 0;
		}elseif( $this->input->post('status') == 'enabled' ){
			$data['is_active'] 									= 1;
		}else{
			$data['is_active'] 									= 0;
		}
		
		
		
		//get plans id
		$plan_id = $this->input->post('plan_id');
		
		
		
		//update plans
		$this->model_plans->updatePlan($data, $plan_id);
		
		// log changes
		$plans_name = trim($this->input->post('name'));
		$log = "Updated plans " . $plans_name;
		$timestamp = date("Y-m-d H:i:s");
		$this->model_main->addLog($log, "Update plans", $timestamp);
		
		if( trim($old_image) != trim($image_file) ){
			if( file_exists( $this->config->item('base_plans_path') . $old_image ) ){
				//delete old image
				@unlink($this->config->item('base_plans_path') . $old_image);
			}
		}
		
		$user_type = $this->session->userdata('user_type');	
		
		$filter_arr = array();
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve plans
		$pagination_limit = 5;
		$current_page = 1;
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$plans_arr = $this->model_plans->getplans(	$property_id, 
															$user_type, 
															"", 
															"asc", 
															$limit,
															$pagination_limit,
															$filter_arr);
		$plans_total_count = $plans_arr['total_count'];
		unset($plans_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['plans'] == $plans_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'plans',
								'filter_arr' => $filter_arr,
								'item_count' => $plans_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "plans";
		$_data['item_count'] = $item_count;
		$_data['plans'] = $plans_arr;
		$_data['legend'] = $this->load->view('admin/view_plans_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_plans_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$this->load->view('admin/view_plans', $_data);
		return;
	}
	
	public function process_delete(){
		$this->load->model('model_plans');
		
		if( $this->input->post('gadget_id') ){
			$plans_id = $this->input->post('gadget_id');
		}else{
			$plans_id = 0;
		}
		
		//delete plans
		$plans_details = $this->model_plans->deleteplans($plans_id);
		
		//delete plans image
		if( isset($plans_details['image']) ){
			if( file_exists( $this->config->item('base_plans_path') . $plans_details['image'] ) ){
				@unlink($this->config->item('base_plans_path') . $plans_details['image']);
			}
		}
		
		// log changes
		$plans_name = trim($plans_details['name']);
		$log = "Deleted plans " . $plans_name;
		$timestamp = date("Y-m-d H:i:s");
		$this->model_main->addLog($log, "Delete plans", $timestamp);
		
		$user_type = $this->session->userdata('user_type');	
		
		$filter_arr = array();
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve plans
		$pagination_limit = 5;
		$current_page = 1;
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$plans_arr = $this->model_plans->getplans(	$property_id, 
															$user_type, 
															"", 
															"asc", 
															$limit,
															$pagination_limit,
															$filter_arr);
		$plans_total_count = $plans_arr['total_count'];
		unset($plans_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['plans'] == $plans_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'plans',
								'filter_arr' => $filter_arr,
								'item_count' => $plans_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "plans";
		$_data['item_count'] = $item_count;
		$_data['plans'] = $plans_arr;
		$_data['legend'] = $this->load->view('admin/view_plans_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_plans_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$this->load->view('admin/view_plans', $_data);
		return;
	}
}
?>