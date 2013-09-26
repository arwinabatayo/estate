<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Store extends MY_Controller 
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
		$this->load->model('model_pickup');
		
		$user_type = $this->session->userdata('user_type');	
                		
		$filter_arr = array();
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve accessories
		$pagination_limit = 50;
		$current_page = 1;
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$pickup = $this->model_pickup->get_stores(	
                                                            $property_id, 
                                                            "estate_store.name", 
                                                            "asc", 
                                                            $limit,
                                                            $pagination_limit,
                                                            $filter_arr);
		$pickup_total_count = $pickup['total_count'];
		unset($pickup['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['pickup'] = $pickup_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'store',
								'filter_arr' => $filter_arr,
								'item_count' => $pickup_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "store";
		$_data['item_count'] = $item_count;
		$_data['pickup'] = $pickup;
		$_data['filter'] = $this->load->view('admin/view_store_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$_data['content'] = $this->load->view('admin/view_store', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function add()
	{
            $_data['sess_user'] = $this->session->userdata;
            $_data['page'] = "store";
            $_data['content'] = $this->load->view('admin/view_store_add', $_data, TRUE);
            $this->load->view('admin/view_main_back', $_data);
            return;
	}
        
        public function properties_add($store_id)
	{
            $_data['sess_user'] = $this->session->userdata;
            $_data['page'] = "store";
            $this->load->model('model_pickup');
            $_data['store'] = $this->model_pickup->get_stores($store_id);
            $_data['content'] = $this->load->view('admin/view_store_add_properties', $_data, TRUE);
            $this->load->view('admin/view_main_back', $_data);
            return;
	}
	
	public function process_add()
	{
		$this->load->model('model_pickup');
                
		$data					= array();
		$data['name'] 				= $this->cleanStringForDB($this->input->post('store_name'));
		$data['postal_code'] 			= $this->cleanStringForDB($this->input->post('postal_code'));
                $data['province'] 			= $this->cleanStringForDB($this->input->post('province'));
                $data['city'] 			= $this->cleanStringForDB($this->input->post('city'));
                $data['municipality'] 			= $this->cleanStringForDB($this->input->post('municipality'));
                $data['barangay'] 			= $this->cleanStringForDB($this->input->post('barangay'));
                $data['street'] 			= $this->cleanStringForDB($this->input->post('street'));
                $data['subdivision'] 			= $this->cleanStringForDB($this->input->post('subdivision'));
                $data['status'] 			= $this->cleanStringForDB($this->input->post('status'));

		$this->model_pickup->add_store($data);
		
		// log changes
		$log = "Added store " . trim($data['store_name']);
		$timestamp = date("Y-m-d H:i:s");
		$this->model_main->addLog($log, "Add store", $timestamp);
		
		$filter_arr = array();
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve accessories
		$pagination_limit = 50;
		$current_page = 1;
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;

		$pickup = $this->model_pickup->get_stores(	
                                                            $property_id, 
                                                            "estate_store.name", 
                                                            "asc", 
                                                            $limit,
                                                            $pagination_limit,
                                                            $filter_arr);
		$pickup_total_count = $pickup['total_count'];
		unset($pickup['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['pickup'] = $pickup_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'store',
								'filter_arr' => $filter_arr,
								'item_count' => $pickup_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "store";
		$_data['item_count'] = $item_count;
		$_data['pickup'] = $pickup;
                
		$_data['filter'] = $this->load->view('admin/view_store_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$_data['content'] = $this->load->view('admin/view_store', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
        
        public function process_add_properties()
	{
		$this->load->model('model_pickup');
                
		$data					= array();
                $data['store_id'] 				= $this->cleanStringForDB($this->input->post('store_id'));
		$data['slots_available'] 				= $this->cleanStringForDB($this->input->post('slots_available'));
		$data['date_of_operation'] 			= $this->cleanStringForDB($this->input->post('date_of_operation'));
                $data['time_of_operation_from'] 			= $this->cleanStringForDB($this->input->post('time_of_operation_from'));
                $data['time_of_operation_to'] 			= $this->cleanStringForDB($this->input->post('time_of_operation_to'));
                $data['status'] 			= $this->cleanStringForDB($this->input->post('property_status'));

		$this->model_pickup->add_store_properties($data);
		
		// log changes
                $store = $this->model_pickup->get_stores($store_id);
		$log = "Added store properties" . trim($store[0]['name']);
		$timestamp = date("Y-m-d H:i:s");
		$this->model_main->addLog($log, "Add store properties", $timestamp);
		
		$filter_arr = array();
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve accessories
		$pagination_limit = 50;
		$current_page = 1;
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;

		$pickup = $this->model_pickup->get_stores(	
                                                            $property_id, 
                                                            "estate_store.name", 
                                                            "asc", 
                                                            $limit,
                                                            $pagination_limit,
                                                            $filter_arr);
		$pickup_total_count = $pickup['total_count'];
		unset($pickup['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['pickup'] = $pickup_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'store',
								'filter_arr' => $filter_arr,
								'item_count' => $pickup_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "store";
		$_data['item_count'] = $item_count;
		$_data['pickup'] = $pickup;
                
		$_data['filter'] = $this->load->view('admin/view_store_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$_data['content'] = $this->load->view('admin/view_store', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function edit($store_id=null)
	{
		$this->load->model('model_pickup');
		
		if ($store_id == null) { redirect(site_url('admin/pickup')); }
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "store";
		$_data['store_details'] = $this->model_pickup->get_store_details($store_id);
		$_data['content'] = $this->load->view('admin/view_store_edit', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
        
        public function edit_properties($store_id=null, $property_id = NULL)
	{
		$this->load->model('model_pickup');
		
		if ($store_id == null) { redirect(site_url('admin/pickup')); }
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "store";
		$_data['property_details'] = $this->model_pickup->get_property_details($store_id, $property_id);
		$_data['content'] = $this->load->view('admin/view_store_edit_properties', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function process_edit()
        {
        	$this->load->model('model_pickup');

		$data			= array();
                $store_id		= $this->cleanStringForDB($this->input->post('store_id'));
		$data['name'] 		= $this->cleanStringForDB($this->input->post('store_name'));
		$data['postal_code'] 			= $this->cleanStringForDB($this->input->post('postal_code'));
                $data['province'] 			= $this->cleanStringForDB($this->input->post('province'));
                $data['city'] 			= $this->cleanStringForDB($this->input->post('city'));
                $data['municipality'] 			= $this->cleanStringForDB($this->input->post('municipality'));
                $data['barangay'] 			= $this->cleanStringForDB($this->input->post('barangay'));
                $data['street'] 			= $this->cleanStringForDB($this->input->post('street'));
                $data['subdivision'] 			= $this->cleanStringForDB($this->input->post('subdivision'));
                $data['status'] 			= $this->cleanStringForDB($this->input->post('status'));

		$this->model_pickup->update_store($store_id, $data);
		
		// log changes
		$log = "Added accessory " . trim($data['store_name']);
		$timestamp = date("Y-m-d H:i:s");
		$this->model_main->addLog($log, "Add accessory", $timestamp);
		
		$filter_arr = array();
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve accessories
		$pagination_limit = 50;
		$current_page = 1;
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;

		$pickup = $this->model_pickup->get_stores(	
                                                            $property_id, 
                                                            "estate_store.name", 
                                                            "asc", 
                                                            $limit,
                                                            $pagination_limit,
                                                            $filter_arr);
		$pickup_total_count = $pickup['total_count'];
		unset($pickup['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['pickup'] = $pickup_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'store',
								'filter_arr' => $filter_arr,
								'item_count' => $pickup_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "store";
		$_data['item_count'] = $item_count;
		$_data['pickup'] = $pickup;
                
		$_data['filter'] = $this->load->view('admin/view_store_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$_data['content'] = $this->load->view('admin/view_store', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
        
        
        public function process_edit_property()
        {
        	$this->load->model('model_pickup');

		$data			= array();
                $property_id		= $this->cleanStringForDB($this->input->post('property_id'));
                $store_id 				= $this->cleanStringForDB($this->input->post('store_id'));
		$data['slots_available'] 				= $this->cleanStringForDB($this->input->post('slots_available'));
		$data['date_of_operation'] 			= $this->cleanStringForDB($this->input->post('date_of_operation'));
                $data['time_of_operation_from'] 			= $this->cleanStringForDB($this->input->post('time_of_operation_from'));
                $data['time_of_operation_to'] 			= $this->cleanStringForDB($this->input->post('time_of_operation_to'));
                $data['status'] 			= $this->cleanStringForDB($this->input->post('property_status'));

		$this->model_pickup->update_property($property_id, $data);
		
		$log = "Update property";
		$timestamp = date("Y-m-d H:i:s");
		$this->model_main->addLog($log, "Update property", $timestamp);
		
		$filter_arr = array();
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve accessories
		$pagination_limit = 50;
                $current_page = $this->input->post('current_page');
                if($current_page != FALSE) {
                    $current_page = $this->input->post('current_page');
                } else {
                    $current_page = 1;
                }
		$property_id = $store_id;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$store_properties = $this->model_pickup->get_store_properties(	
                                                            $property_id, 
                                                            "estate_gadget_store.store_id", 
                                                            "asc", 
                                                            $limit,
                                                            $pagination_limit,
                                                            $filter_arr);
		$store_properties_count = $store_properties['total_count'];
		unset($store_properties['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['store_properties'] = $store_properties_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'store/preview/'.$store_id,
								'filter_arr' => $filter_arr,
								'item_count' => $store_properties_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "store/preview/".$store_id;
		$_data['item_count'] = $item_count;
		$_data['store_properties'] = $store_properties;
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$_data['content'] = $this->load->view('admin/view_store_properties', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
        
	
	public function process_delete(){
		$this->load->model('model_pickup');
		
		if( $this->input->post('store_id') ){
			$store_id = $this->input->post('store_id');
		}else{
			$store_id = 0;
		}
		
		$store_details = $this->model_pickup->delete_store($store_id);
		
		// log changes
		$store = trim($store_details['name']);
		$log = "Deleted store " . $store;
		$timestamp = date("Y-m-d H:i:s");
		$this->model_main->addLog($log, "Delete store ", $timestamp);
		
		$user_type = $this->session->userdata('user_type');	
		
		$filter_arr = array();
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve accessories
		$pagination_limit = 50;
		$current_page = 1;
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;

		$pickup = $this->model_pickup->get_stores(	
                                                            $property_id, 
                                                            "estate_store.name", 
                                                            "asc", 
                                                            $limit,
                                                            $pagination_limit,
                                                            $filter_arr);
		$pickup_total_count = $pickup['total_count'];
		unset($pickup['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['pickup'] = $pickup_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'store',
								'filter_arr' => $filter_arr,
								'item_count' => $pickup_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "store";
		$_data['item_count'] = $item_count;
		$_data['pickup'] = $pickup;
                
		$_data['filter'] = $this->load->view('admin/view_store_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$_data['content'] = $this->load->view('admin/view_store', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
        
        public function process_items()
	{
		$this->load->model('model_pickup');
	
		$user_type = $this->session->userdata('user_type');	
		
		$filter_arr = array();
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		$pagination_limit = 50;
		$current_page = $this->input->post('current_page');
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$property_id = null;
		$pickup = $this->model_pickup->get_stores(	
                                                            $property_id, 
                                                            "estate_store.name", 
                                                            "asc", 
                                                            $limit,
                                                            $pagination_limit,
                                                            $filter_arr);
		$pickup_total_count = $pickup['total_count'];
		unset($pickup['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['pickup'] = $pickup_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'store',
								'filter_arr' => $filter_arr,
								'item_count' => $pickup_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "store";
		$_data['item_count'] = $item_count;
		$_data['pickup'] = $pickup;
		$_data['filter'] = $this->load->view('admin/view_store_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$_data['content'] = $this->load->view('admin/view_store', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
        
        
        public function preview($store_id)
	{
		$this->load->model('model_pickup');
		
		$user_type = $this->session->userdata('user_type');	
                		
		$filter_arr = array();
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve accessories
		$pagination_limit = 50;
                $current_page = $this->input->post('current_page');
                if($current_page != FALSE) {
                    $current_page = $this->input->post('current_page');
                } else {
                    $current_page = 1;
                }
		$property_id = $store_id;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$store_properties = $this->model_pickup->get_store_properties(	
                                                            $property_id, 
                                                            "estate_gadget_store.store_id", 
                                                            "asc", 
                                                            $limit,
                                                            $pagination_limit,
                                                            $filter_arr);
		$store_properties_count = $store_properties['total_count'];
		unset($store_properties['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['store_properties'] = $store_properties_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'store/preview/'.$property_id,
								'filter_arr' => $filter_arr,
								'item_count' => $store_properties_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
                $pagination_limit = 50;
		$current_page = 1;
		$property_id = $store_id;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;

		$store = $this->model_pickup->get_stores(	
                                                            $store_id, 
                                                            "estate_store.name", 
                                                            "asc", 
                                                            $limit,
                                                            $pagination_limit,
                                                            $filter_arr);

		// load response
                $_data['store'] = $store;
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "store";
		$_data['item_count'] = $item_count;
		$_data['store_properties'] = $store_properties;
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$_data['content'] = $this->load->view('admin/view_store_properties', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
        
        public function process_delete_properties(){
		$this->load->model('model_pickup');
		
		if( $this->input->post('property_id') ){
			$property_id = $this->input->post('property_id');
		}else{
			$property_id = 0;
		}
                
                $store_id = $this->input->post('store_id');
		
		$store_details = $this->model_pickup->delete_store_property($store_id, $property_id);

		// log changes
		$log = "Deleted store property";
		$timestamp = date("Y-m-d H:i:s");
		$this->model_main->addLog($log, "Delete store property", $timestamp);
		
		$user_type = $this->session->userdata('user_type');	
		
		$filter_arr = array();
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve accessories
		$pagination_limit = 50;
                $current_page = $this->input->post('current_page');
                if($current_page != FALSE) {
                    $current_page = $this->input->post('current_page');
                } else {
                    $current_page = 1;
                }
		$property_id = $store_id;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$store_properties = $this->model_pickup->get_store_properties(	
                                                            $property_id, 
                                                            "estate_gadget_store.store_id", 
                                                            "asc", 
                                                            $limit,
                                                            $pagination_limit,
                                                            $filter_arr);
		$store_properties_count = $store_properties['total_count'];
		unset($store_properties['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['store_properties'] = $store_properties_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'store/preview/'.$store_id,
								'filter_arr' => $filter_arr,
								'item_count' => $store_properties_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
                $pagination_limit = 50;
		$current_page = 1;
		$property_id = $store_id;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;

		$store = $this->model_pickup->get_stores(	
                                                            $store_id, 
                                                            "estate_store.name", 
                                                            "asc", 
                                                            $limit,
                                                            $pagination_limit,
                                                            $filter_arr);

		// load response
                $_data['store'] = $store;
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "store/preview".$store_id;
		$_data['item_count'] = $item_count;
		$_data['store_properties'] = $store_properties;
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$_data['content'] = $this->load->view('admin/view_store_properties', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
}
?>