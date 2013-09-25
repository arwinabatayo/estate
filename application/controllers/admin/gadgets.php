<?php 
/**
 * 9.18.2013
 * Ultima Logic
 * robert hughes
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class gadgets extends MY_Controller {
	function __construct() {
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
		$filter_arr = array();
		
		$this->load->model('model_gadgets');
		
		$user_type = $this->session->userdata('user_type');	
		
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
			$filter_arr['bundle_type_id'] = 2;
		}
	
		
		// retrieve gadgets
		$pagination_limit = 5;
		$current_page = 1;
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$gadgets_arr = $this->model_gadgets->getGadgets(	$property_id, 
															$user_type, 
															"is_active", 
															"desc", 
															$limit,
															$pagination_limit,
															$filter_arr);
		
		$gadgets_total_count = $gadgets_arr['total_count'];
		unset($gadgets_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['gadgets'] == $gadgets_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'gadgets',
								'filter_arr' => $filter_arr,
								'item_count' => $gadgets_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "gadgets";
		$_data['item_count'] = $item_count;
		$_data['gadgets'] = $gadgets_arr;
		$_data['legend'] = $this->load->view('admin/view_gadgets_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_gadgets_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$_data['content'] = $this->load->view('admin/view_gadgets', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function add()
	{
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "gadgets";
		$_data['content'] = $this->load->view('admin/view_gadgets_add', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	public function process_add() {
		
		$filter_arr = array();
		$filter_arr['bundle_type_id'] = 2; // combo id
		$this->load->model('model_gadgets');
		
		$data = array();
		$post = $this->input->post();
		
		$gadgetName = $post['name'];
		$status = $post['is_active'];
		
		$data['estate_gadgets']['name'] =  $gadgetName;
		$data['estate_gadgets']['is_active'] =  $status;
		
		foreach($post['details'] as $details) {
			$contents['cid'] 					= $details['cid'];
			$contents['colorid'] 				= $details['color'];
			$contents['data_capacity_id'] 		= $details['data_capacity'];
			$contents['net_connectivity_id'] 	= $details['net_connectivity'];
			$contents['image'] 					= $details['img'];
			$contents['stock_qty'] 				= $details['qty'];
			$contents['discount'] 				= $details['discount'];
			$contents['amount'] 				= $details['amount'];
			$contents['required_pv'] 			= $details['peso_value'];
			$contents['is_active']				= $details['is_active'];
			
			$data['estate_gadget_attributes'][] = $contents;
		}
		$this->model_gadgets->addGadget($data);
		
// 		// log changes
// 		$plan = trim($this->input->post('gadgets_title'));
// 		$log = "Added plan " . $plan;
// 		$timestamp = date("Y-m-d H:i:s");
// 		$this->model_main->addLog($log, "Add plan", $timestamp);
		
// 		$user_type = $this->session->userdata('user_type');	
		
		
// 		if ($this->input->post('filter')) {
// 			$filter_arr['letter'] = $this->input->post('letter');
// 		}
	
// 		// retrieve gadgets
// 		$pagination_limit = 5;
// 		$current_page = 1;
// 		$property_id = null;
// 		$limit = ($current_page * $pagination_limit) - $pagination_limit;
// 		$gadgets_arr = $this->model_gadgets->getGadgets(	$property_id, 
// 															$user_type, 
// 															"is_active, date_modified", 
// 															"asc", 
// 															$limit,
// 															$pagination_limit,
// 															$filter_arr);
// 		$plan_total_count = $gadgets_arr['total_count'];
// 		unset($gadgets_arr['total_count']);
		
// 		// get list of items count
// 		$item_count = array();
// 		$item_count['gadgets'] == $plan_total_count;
		
// 		// populate response
// 		$_filter = array(		'sess_user' => $this->session->userdata,
// 								'current_page' => $current_page,
// 								'filter' => $this->input->post('filter'),
// 								'labels' => $this->getAlphabet(),
// 								'filter_arr' => $filter_arr);
// 		$_pagination = array(	'page' => 'gadgets',
// 								'filter_arr' => $filter_arr,
// 								'item_count' => $plan_total_count,
// 								'pagination_limit' => $pagination_limit,
// 								'current_page' => $current_page);
		
// 		// load response
// 		$_data['sess_user'] = $this->session->userdata;
// 		$_data['page'] = "gadgets";
// 		$_data['item_count'] = $item_count;
// 		$_data['gadgets'] = $gadgets_arr;
// 		$_data['legend'] = $this->load->view('admin/view_gadgets_legend', NULL, TRUE);
// 		$_data['filter'] = $this->load->view('admin/view_gadgets_filter', $_filter, TRUE);
// 		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
// 		$this->load->view('admin/view_gadgets', $_data);
		return;
	}
	
	public function process_items()
	{
		$filter_arr = array();
		$filter_arr['bundle_type_id'] = 2; // combo id
		$this->load->model('model_gadgets');
	
		$user_type = $this->session->userdata('user_type');	
		
		
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve gadgets
		$pagination_limit = 5;
		$current_page = $this->input->post('current_page');
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$gadgets_arr = $this->model_gadgets->getGadgets(	$property_id, 
															$user_type, 
															"", 
															"asc", 
															$limit,
															$pagination_limit,
															$filter_arr);
		$gadgets_total_count = $gadgets_arr['total_count'];
		unset($gadgets_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['gadgets'] == $gadgets_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'gadgets',
								'filter_arr' => $filter_arr,
								'item_count' => $gadgets_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "gadgets";
		$_data['item_count'] = $item_count;
		$_data['gadgets'] = $gadgets_arr;
		$_data['legend'] = $this->load->view('admin/view_gadgets_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_gadgets_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$this->load->view('admin/view_gadgets', $_data);
		return;
	}
	
	
	
	public function edit($gadgets_id=null)
	{
		
		$this->load->model('model_gadgets');
		$this->load->model('model_properties');
		
		if ($gadgets_id == null) { redirect(site_url('admin/gadgets')); } // gadgets_id?
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "gadgets";
		
		$_data['properties'] = $this->model_properties->getPropertiesByUserId($this->session->userdata('user_id'), "properties.last_edit", "desc", 0, 100);
		$_data['gadgets_id'] = $gadgets_id;
		$_data['gadgets_details'] = $this->model_gadgets->getGadgetDetails($gadgets_id, 2);
		$_data['content'] = $this->load->view('admin/view_gadgets_edit', $_data, TRUE);
		
		
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function process_edit() {
		$filter_arr = array();
		$filter_arr['bundle_type_id'] = 2; // combo id
		$this->load->model('model_gadgets');
		
		$data					= array();
		$tmp_data_attr			= array();
		
		$post = $this->input->post();
		
		foreach($post as $fields => $values) {
			if($fields == "id") {
				$id = $values; // get id
				continue;
			}
			$data[$fields] = addslashes($this->cleanStringForDB($values));
		}
		
		//update gadgets
		$this->model_gadgets->updateBundle($data, $id);
		
		// log changes
		$gadgets_name = trim($this->input->post('name'));
		$log = "Updated gadgets " . addslashes($gadgets_name);
		$timestamp = date("Y-m-d H:i:s");
		$this->model_main->addLog($log, "Update gadgets", $timestamp);
		
		$user_type = $this->session->userdata('user_type');	
		
		
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve gadgets
		$pagination_limit = 5;
		$current_page = 1;
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$gadgets_arr = $this->model_gadgets->getGadgets(	$property_id, 
															$user_type, 
															"", 
															"asc", 
															$limit,
															$pagination_limit,
															$filter_arr);
		$gadgets_total_count = $gadgets_arr['total_count'];
		unset($gadgets_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['gadgets'] == $gadgets_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		
		$_pagination = array(	'page' => 'gadgets',
								'filter_arr' => $filter_arr,
								'item_count' => $gadgets_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "gadgets";
		$_data['item_count'] = $item_count;
		$_data['gadgets'] = $gadgets_arr;
		$_data['legend'] = $this->load->view('admin/view_gadgets_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_gadgets_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$this->load->view('admin/view_gadgets', $_data);
		return;
	}
	
	public function process_delete() {
		$filter_arr = array();
		$filter_arr['bundle_type_id'] = 2; // combo id
		$this->load->model('model_gadgets');
		
		$id = $this->input->post('id');
		
		//delete gadgets
		$details = $this->model_gadgets->deleteBundle($id);
		
		// log changes
		$gadgets_name = trim($gadgets_details['name']);
		$log = "Deleted gadgets " . $gadgets_name;
		$timestamp = date("Y-m-d H:i:s");
		$this->model_main->addLog($log, "Delete gadgets", $timestamp);
		
		$user_type = $this->session->userdata('user_type');	
		
		
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve gadgets
		$pagination_limit = 5;
		$current_page = 1;
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$gadgets_arr = $this->model_gadgets->getGadgets(	$property_id, 
															$user_type, 
															"", 
															"asc", 
															$limit,
															$pagination_limit,
															$filter_arr);
		$gadgets_total_count = $gadgets_arr['total_count'];
		unset($gadgets_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['gadgets'] == $gadgets_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		
		$_pagination = array(	'page' => 'gadgets',
								'filter_arr' => $filter_arr,
								'item_count' => $gadgets_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "gadgets";
		$_data['item_count'] = $item_count;
		$_data['gadgets'] = $gadgets_arr;
		$_data['legend'] = $this->load->view('admin/view_gadgets_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_gadgets_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		
		$this->load->view('admin/view_gadgets', $_data);
		return;
	}
	
	/**
	 * Colors Page
	 */
	public function colors() {
		$this->load->model('model_gadgets');
	
		$user_type = $this->session->userdata('user_type');
	
		// retrieve gadgets
		$pagination_limit = 5;
		$current_page = 1;
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$arr = $this->model_gadgets->getColors();
	
	
		$total_count = $arr['total_count'];
		unset($arr['total_count']);
	
		// get list of items count
		$item_count = array();
		$item_count['colors'] == $total_count;
	
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
				'current_page' => $current_page,
				'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'colors',
				'filter_arr' => $filter_arr,
				'item_count' => $gadgets_total_count,
				'pagination_limit' => $pagination_limit,
				'current_page' => $current_page);
	
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "colors";
		$_data['item_count'] = $item_count;
		$_data['colors'] = $arr;
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$_data['content'] = $this->load->view('admin/view_gadgets_colors', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	
	public function process_add_colors() {
		$this->load->model('model_gadgets');
		
		$data	= array();
		$post	= $this->input->post();
		
		foreach($post as $fields => $values) {
			if($fields == "id") {
				$id = $values; // get id
				continue;
			}
			$data[$fields] = addslashes($this->cleanStringForDB($values));
		}
		print_r($data);
		//add plan
		$this->model_gadgets->addColors($data);
		
		// log changes
		$name = trim($this->input->post('name'));
		$log = "Added color " . $name;
		$timestamp = date("Y-m-d H:i:s");
		$this->model_main->addLog($log, "Add color", $timestamp);
		
		$user_type = $this->session->userdata('user_type');
		
		// retrieve gadgets
		$pagination_limit = 5;
		$current_page = 1;
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$arr = $this->model_gadgets->getColors();
		
		
		$total_count = $arr['total_count'];
		unset($arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['colors'] == $total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
				'current_page' => $current_page,
				'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'colors',
				'filter_arr' => $filter_arr,
				'item_count' => $gadgets_total_count,
				'pagination_limit' => $pagination_limit,
				'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "colors";
		$_data['item_count'] = $item_count;
		$_data['colors'] = $arr;
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$_data['content'] = $this->load->view('admin/view_gadgets_colors', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		
		return;
	}

	
	/** DATA CAPACITY **/
	public function data_capacity() {
		$this->load->model('model_gadgets');
	
		$user_type = $this->session->userdata('user_type');
	
		// retrieve gadgets
		$pagination_limit = 5;
		$current_page = 1;
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$arr = $this->model_gadgets->getDataCapacity();
	
	
		$total_count = $arr['total_count'];
		unset($arr['total_count']);
	
		// get list of items count
		$item_count = array();
		$item_count['colors'] == $total_count;
	
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
				'current_page' => $current_page,
				'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'colors',
				'filter_arr' => $filter_arr,
				'item_count' => $gadgets_total_count,
				'pagination_limit' => $pagination_limit,
				'current_page' => $current_page);
	
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "data capacity";
		$_data['item_count'] = $item_count;
		$_data['data_capacity'] = $arr;
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$_data['content'] = $this->load->view('admin/view_gadgets_data_capacity', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function process_add_data_capacity() {
		$this->load->model('model_gadgets');
	
		$data	= array();
		$post	= $this->input->post();
	
		foreach($post as $fields => $values) {
			if($fields == "id") {
				$id = $values; // get id
				continue;
			}
			$data[$fields] = addslashes($this->cleanStringForDB($values));
		}
		print_r($data);
		//add plan
		$this->model_gadgets->addDataCapacity($data);
	
		// log changes
		$name = trim($this->input->post('name'));
		$log = "Added data capacity " . $name;
		$timestamp = date("Y-m-d H:i:s");
		$this->model_main->addLog($log, "Add data capacity", $timestamp);
	
		$user_type = $this->session->userdata('user_type');
	
		// retrieve gadgets
		$pagination_limit = 5;
		$current_page = 1;
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$arr = $this->model_gadgets->getDataCapacity();
	
	
		$total_count = $arr['total_count'];
		unset($arr['total_count']);
	
		// get list of items count
		$item_count = array();
		$item_count['colors'] == $total_count;
	
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
				'current_page' => $current_page,
				'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'colors',
				'filter_arr' => $filter_arr,
				'item_count' => $gadgets_total_count,
				'pagination_limit' => $pagination_limit,
				'current_page' => $current_page);
	
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "data capacity";
		$_data['item_count'] = $item_count;
		$_data['data_capacity'] = $arr;
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$_data['content'] = $this->load->view('admin/view_gadgets_data_capacity', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
	
		return;
	}
	
	
	/** NETWORK CONNECTIVITY **/
	public function net_connectivity() {
		$this->load->model('model_gadgets');
	
		$user_type = $this->session->userdata('user_type');
	
		// retrieve gadgets
		$pagination_limit = 5;
		$current_page = 1;
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$arr = $this->model_gadgets->getNetConnectivity();
	
	
		$total_count = $arr['total_count'];
		unset($arr['total_count']);
	
		// get list of items count
		$item_count = array();
		$item_count['colors'] == $total_count;
	
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
				'current_page' => $current_page,
				'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'colors',
				'filter_arr' => $filter_arr,
				'item_count' => $gadgets_total_count,
				'pagination_limit' => $pagination_limit,
				'current_page' => $current_page);
	
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "network connectivity";
		$_data['item_count'] = $item_count;
		$_data['net_connectivity'] = $arr;
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$_data['content'] = $this->load->view('admin/view_gadgets_net_connectivity', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}

	public function process_add_net_connectivity() {
		$this->load->model('model_gadgets');
	
		$data	= array();
		$post	= $this->input->post();
	
		foreach($post as $fields => $values) {
			if($fields == "id") {
				$id = $values; // get id
				continue;
			}
			$data[$fields] = addslashes($this->cleanStringForDB($values));
		}
		//add plan
		$this->model_gadgets->addNetConnectivity($data);
	
		// log changes
		$name = trim($this->input->post('name'));
		$log = "Added network connectivity " . $name;
		$timestamp = date("Y-m-d H:i:s");
		$this->model_main->addLog($log, "Add network connectivity", $timestamp);
	
		$user_type = $this->session->userdata('user_type');
	
		// retrieve gadgets
		$pagination_limit = 5;
		$current_page = 1;
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$arr = $this->model_gadgets->getNetConnectivity();
	
	
		$total_count = $arr['total_count'];
		unset($arr['total_count']);
	
		// get list of items count
		$item_count = array();
		$item_count['colors'] == $total_count;
	
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
				'current_page' => $current_page,
				'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'colors',
				'filter_arr' => $filter_arr,
				'item_count' => $gadgets_total_count,
				'pagination_limit' => $pagination_limit,
				'current_page' => $current_page);
	
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "network connectivity";
		$_data['item_count'] = $item_count;
		$_data['net_connectivity'] = $arr;
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$_data['content'] = $this->load->view('admin/view_gadgets_net_connectivity', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
	
		return;
	}
	
	
	
	public function upload_gadget_image() {
		error_reporting(E_ALL | E_STRICT);
		require('UploadHandler.php');

		$upload_handler = new UploadHandler();
	}
	
	public function addAttr() {
		$this->load->model('model_gadgets');
		
		$arrPost = $this->input->post();
		print_r($arrPost);
		$lastid = $arrPost['datas'][0];
		
		$arrLastId = explode("-",$lastid);
		
		if(!empty($arrLastId[2]) || $arrLastId[2] != 0) {
			$_data['item_count'] = $arrLastId[2] + 1;
		} else {
			$_data['item_count'] = 1;
		}
		
		$colors = $this->model_gadgets->getColors();
		$net_connectivity = $this->model_gadgets->getNetConnectivity();
		$data_capacity = $this->model_gadgets->getDataCapacity();
		
		unset($colors['total_count']);
		unset($net_connectivity['total_count']);
		unset($data_capacity['total_count']);
		unset($arrPost['datas'][0]);
		
		$_data['imgs'] = $arrPost;
		$_data['colors'] = $colors;
		$_data['net_connectivity'] = $net_connectivity;
		$_data['data_capacity'] = $data_capacity;
		
		$this->load->view('admin/view_gadgets_attr', $_data);
		return;
	}
	
	public function view($gadgets_id=null)
	{
	
		$this->load->model('model_gadgets');
		$this->load->model('model_properties');
	
		if ($gadgets_id == null) { redirect(site_url('admin/gadgets')); } // gadgets_id?
	
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "gadgets";
	
		$_data['properties'] = $this->model_properties->getPropertiesByUserId($this->session->userdata('user_id'), "properties.last_edit", "desc", 0, 100);
		$_data['gadgets_id'] = $gadgets_id;
		$_data['gadgets_details'] = $this->model_gadgets->getGadgetDetails($gadgets_id);
		$_data['content'] = $this->load->view('admin/view_gadgets_view', $_data, TRUE);
	
	
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
}
?>