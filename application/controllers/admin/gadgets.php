<?php 
/**
 * 9.18.2013
 * Ultima Logic
 * robert hughes
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class gadgets extends MY_Controller 
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
		
		$data					= array();
		$post = $this->input->post();
		
		foreach($post as $fields => $values) {
			if($fields == "id") {
				$id = $values; // get id
				continue;
			}
			$data[$fields] = addslashes($this->cleanStringForDB($values));
		}
		$data["bundle_type_id"] = $filter_arr['bundle_type_id'];

		//add plan
		$this->model_gadgets->addBundle($data);
		
		// log changes
		$plan = trim($this->input->post('gadgets_title'));
		$log = "Added plan " . $plan;
		$timestamp = date("Y-m-d H:i:s");
		$this->model_main->addLog($log, "Add plan", $timestamp);
		
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
															"is_active, date_modified", 
															"asc", 
															$limit,
															$pagination_limit,
															$filter_arr);
		$plan_total_count = $gadgets_arr['total_count'];
		unset($gadgets_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['gadgets'] == $plan_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'gadgets',
								'filter_arr' => $filter_arr,
								'item_count' => $plan_total_count,
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
}
?>