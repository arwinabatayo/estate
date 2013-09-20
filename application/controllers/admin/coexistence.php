<?php 
/**
 * 9.16.2013
 * Ultima Logic
 * robert hughes
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class coexistence extends MY_Controller 
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
	
	public function index() {
		$filter = "b2b";
		
		$this->load->model('model_coexistence');
		
		$user_type = $this->session->userdata('user_type');	
		
		if ($this->input->post('filter')) {
			$filter = $this->input->post('letter');
		}
	
		
		// retrieve coexistence
		$pagination_limit = 5;
		$current_page = 1;
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$coexistence_arr = $this->model_coexistence->getCoExistence(	$property_id, 
															$user_type, 
															"", 
															"asc", 
															$limit,
															$pagination_limit,
															$filter);
		
		$coexistence_total_count = $coexistence_arr['total_count'];
		unset($coexistence_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['coexistence'] == $coexistence_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter);
		$_pagination = array(	'page' => 'coexistence',
								'filter_arr' => $filter,
								'item_count' => $coexistence_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "coexistence";
		$_data['item_count'] = $item_count;
		$_data['coexist_name'] = "Booster / Booster";
		$_data['coexistence'] = $coexistence_arr;
		$_data['legend'] = $this->load->view('admin/view_coexistence_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_coexistence_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$_data['content'] = $this->load->view('admin/view_coexistence', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function add()
	{
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "coexistence";
		$_data['content'] = $this->load->view('admin/view_coexistence_add', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function process_add() {
		$filter_arr = array();
		$filter_arr['bundle_type_id'] = 2; // combo id
		$this->load->model('model_coexistence');
		
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
		$this->model_coexistence->addBundle($data);
		
		// log changes
		$plan = trim($this->input->post('coexistence_title'));
		$log = "Added plan " . $plan;
		$timestamp = date("Y-m-d H:i:s");
		$this->model_main->addLog($log, "Add plan", $timestamp);
		
		$user_type = $this->session->userdata('user_type');	
		
		
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve coexistence
		$pagination_limit = 5;
		$current_page = 1;
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$coexistence_arr = $this->model_coexistence->getCoExistence(	$property_id, 
															$user_type, 
															"", 
															"asc", 
															$limit,
															$pagination_limit,
															$filter_arr);
		$plan_total_count = $coexistence_arr['total_count'];
		unset($coexistence_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['coexistence'] == $plan_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'coexistence',
								'filter_arr' => $filter_arr,
								'item_count' => $plan_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "coexistence";
		$_data['item_count'] = $item_count;
		$_data['coexistence'] = $coexistence_arr;
		$_data['legend'] = $this->load->view('admin/view_coexistence_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_coexistence_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$this->load->view('admin/view_coexistence', $_data);
		return;
	}
	
	public function process_items() {
		$filter = "c2b";
		$this->load->model('model_coexistence');
	
		$user_type = $this->session->userdata('user_type');	
		
		
		if ($this->input->post('coextype')) {
			$filter = $this->input->post('coextype');
			switch ($filter) {
				case "b2b" : $coexistname = "Boosters / Boosters"; break;
				case "c2b" : $coexistname = "Boosters / Combos"; break;
				case "c2c" : $coexistname = "Combos / Combos"; break;
			}
		}
	
		// retrieve coexistence
		$pagination_limit = 5;
		$current_page = $this->input->post('current_page');
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$coexistence_arr = $this->model_coexistence->getCoExistence($property_id, 
															$user_type, 
															"", 
															"asc", 
															$limit,
															$pagination_limit,
															$filter);
		
		$coexistence_total_count = $coexistence_arr['total_count'];
		unset($coexistence_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['coexistence'] == $coexistence_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter);
		
		$_pagination = array(	'page' => 'coexistence',
								'filter_arr' => $filter,
								'item_count' => $coexistence_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['coexist_name'] = $coexistname;
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "coexistence";
		$_data['item_count'] = $item_count;
		$_data['coexistence'] = $coexistence_arr;
		$_data['legend'] = $this->load->view('admin/view_coexistence_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_coexistence_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$this->load->view('admin/view_coexistence', $_data);
		return;
	}
	
	
	
	public function edit($coexistence_id=null)
	{
		
		$this->load->model('model_coexistence');
		$this->load->model('model_properties');
		
		if ($coexistence_id == null) { redirect(site_url('admin/coexistence')); } // coexistence_id?
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "coexistence";
		
		$_data['properties'] = $this->model_properties->getPropertiesByUserId($this->session->userdata('user_id'), "properties.last_edit", "desc", 0, 100);
		$_data['coexistence_id'] = $coexistence_id;
		$_data['coexistence_details'] = $this->model_coexistence->getBundleDetails($coexistence_id, 2);
		$_data['content'] = $this->load->view('admin/view_coexistence_edit', $_data, TRUE);
		
		
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function process_edit() {
		$filter_arr = array();
		$filter_arr['bundle_type_id'] = 2; // combo id
		$this->load->model('model_coexistence');
		
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
		
		//update coexistence
		$this->model_coexistence->updateBundle($data, $id);
		
		// log changes
		$coexistence_name = trim($this->input->post('name'));
		$log = "Updated coexistence " . addslashes($coexistence_name);
		$timestamp = date("Y-m-d H:i:s");
		$this->model_main->addLog($log, "Update coexistence", $timestamp);
		
		$user_type = $this->session->userdata('user_type');	
		
		
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve coexistence
		$pagination_limit = 5;
		$current_page = 1;
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$coexistence_arr = $this->model_coexistence->getCoExistence(	$property_id, 
															$user_type, 
															"", 
															"asc", 
															$limit,
															$pagination_limit,
															$filter_arr);
		$coexistence_total_count = $coexistence_arr['total_count'];
		unset($coexistence_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['coexistence'] == $coexistence_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		
		$_pagination = array(	'page' => 'coexistence',
								'filter_arr' => $filter_arr,
								'item_count' => $coexistence_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "coexistence";
		$_data['item_count'] = $item_count;
		$_data['coexistence'] = $coexistence_arr;
		$_data['legend'] = $this->load->view('admin/view_coexistence_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_coexistence_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$this->load->view('admin/view_coexistence', $_data);
		return;
	}
	
	public function process_delete() {
		$filter_arr = array();
		$filter_arr['bundle_type_id'] = 2; // combo id
		$this->load->model('model_coexistence');
		
		$id = $this->input->post('id');
		
		//delete coexistence
		$details = $this->model_coexistence->deleteBundle($id);
		
		// log changes
		$coexistence_name = trim($coexistence_details['name']);
		$log = "Deleted coexistence " . $coexistence_name;
		$timestamp = date("Y-m-d H:i:s");
		$this->model_main->addLog($log, "Delete coexistence", $timestamp);
		
		$user_type = $this->session->userdata('user_type');	
		
		
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve coexistence
		$pagination_limit = 5;
		$current_page = 1;
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$coexistence_arr = $this->model_coexistence->getCoExistence(	$property_id, 
															$user_type, 
															"", 
															"asc", 
															$limit,
															$pagination_limit,
															$filter_arr);
		$coexistence_total_count = $coexistence_arr['total_count'];
		unset($coexistence_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['coexistence'] == $coexistence_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		
		$_pagination = array(	'page' => 'coexistence',
								'filter_arr' => $filter_arr,
								'item_count' => $coexistence_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "coexistence";
		$_data['item_count'] = $item_count;
		$_data['coexistence'] = $coexistence_arr;
		$_data['legend'] = $this->load->view('admin/view_coexistence_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_coexistence_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		
		$this->load->view('admin/view_coexistence', $_data);
		return;
	}
	
	public function process_editable_save() {
		$this->load->model('model_coexistence');
		
		$value = $this->input->post('value');
		
		echo $this->model_coexistence->updateCoExistenceEditable($value, $this->input->post('id'));
	}
}
?>