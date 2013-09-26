<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller/Handler for: 
 *  --Shopping Cart Page
 *  --Delivery/Pickup 
 *  --Confirm Order
 * 
 ***/

class Payment extends MY_Controller 
{
	var $_data = null;
	
	function __construct()
	{
		parent::__construct();
		
        //global data
		$this->_data->tpl_view    = $this->config->item('globe_estate_template_path');
		$this->_data->assets_path = $assets_path = $this->config->item('globe_estate_assets');
		$this->_data->assets_url  = base_url().$assets_path;
		$this->_data->current_method      = $this->router->method;
		$this->_data->current_controller  = strtolower( $this->router->class );
		$this->_data->show_breadcrumbs    =  true;
		$this->_data->current_step        =  5;
		$this->_data->page                = 'payment';
		$this->_data->page_title          = 'Payment';
		
		
		//global object of subcriber info, init from sms verification -mark
		$this->_data->account_info  = $account_info = (object) $this->session->userdata('subscriber_info');
		
		$this->_data->account_id = 2147483647; // to make it safe =)
		//TODO - add restriction or redirect if account info object is empty -mark
		if($account_info->account_id){
			$this->_data->account_id      = $account_info->account_id;
		}
		

	}
	
	public function index()
	{	
		
		$account_id = $this->_data->account_id; //TODO get subs id
		
		$this->_data->billing_address = $this->accounts_model->get_account_address($account_id,'billing',FALSE);
		
		$this->_data->account_info = $this->accounts_model->get_account_address($account_id);
		
		
		$this->_data->cartItems = $this->cart->contents();
                
                $this->load->model('model_pickup');
                $params = array(
                    'postal_code' => '4023',
                    'province'  => 'Laguna',
                    'city'  => 'San Pedro',
                    'municipality'  => 'San Pedro',
                );
                $this->load->model('model_pickup');
                $stores = $this->model_pickup->list_stores_nearby($params);
                $stores_all = $this->model_pickup->get_stores(NULL, NULL, NULL, NULL, 'all', NULL, 1 );
                unset($stores_all['total_count']);
                $this->_data->stores_all = $stores_all;
                $this->_data->stores =  $stores;

                $store_properties = array();
                foreach($stores as $k=>$v) {
                    $properties = $this->model_pickup->get_store_properties($v['id'],'date_of_operation', 'DESC', NULL, 'all', '1', TRUE);
                    unset($properties['total_count']);
                    $store_properties[$v['id']] = $properties;  
                }
                $this->_data->store_properties = $store_properties;
        
		$this->load->view($this->_data->tpl_view, $this->_data);
	}
	
	public function plan_summary()
	{	
		$this->_data->page  = 'plan_summary';
		$this->_data->show_breadcrumbs    =  false;
		
		$this->load->view($this->_data->tpl_view, $this->_data);
	}
	
	public function thankyou()
	{	
		$this->_data->page  = 'thankyou';
		$this->_data->page_title          = 'Thank you for your order';
		$this->_data->show_breadcrumbs    =  false;
		
		$this->load->view($this->_data->tpl_view, $this->_data);
	}
	
	public function gateway()
	{	
		$this->_data->page  = 'gateway';
		$this->_data->page_title          = 'Secure Credit Card Payment';
		$this->_data->show_breadcrumbs    =  false;
		
		$this->load->view($this->_data->tpl_view, $this->_data);
	}
	
	public function survey_result()
	{	
		$this->_data->page  = 'survey_result';
		$this->_data->page_title          = 'Thank You';
		$this->_data->show_breadcrumbs    =  false;
		
		$this->load->view($this->_data->tpl_view, $this->_data);
	}
	
	public function payorder()
	{
		$cc = $this->input->post('cc');
		$year = $this->input->post('year');
		$month = $this->input->post('month');
		$cvc = $this->input->post('cvc');
		
		$this->_data->page  = 'process_payment';
		$this->_data->page_title          = 'Processing...';
		$this->_data->show_breadcrumbs    =  false;
		
		$this->load->view("globe-estate/sections/pages/page_process_payment", $this->_data);
		
	}
        
        public function search_store()
        {
            $store_name = $this->input->post('store_name');
            $this->load->model('model_pickup');
            $stores = $this->model_pickup->search_store($store_name);
            $_data['stores'] = $stores;
            
            $store_properties = array();
            foreach($stores as $k=>$v) {
                $properties = $this->model_pickup->get_store_properties($v['id'],'date_of_operation', 'DESC', NULL, 'all', '1', TRUE);
                unset($properties['total_count']);
                $store_properties[$v['id']] = $properties;  
            }
            $_data['store_properties'] = $store_properties;
            $data['temp'] = $this->load->view('globe-estate/sections/pages/partials/ajax_payment_delivery_pickup', $_data, TRUE);
            echo json_encode($data);
        }
        
        public function search_nearest_stores()
        {
            $keyword = $this->input->post('keyword');
            $default_search_values = array('postal_code', 'province', 'city', 'municipality', 'barangay');
            $this->load->model('model_pickup');
            
            $stores = array();
            foreach($default_search_values as $v) {
                if(empty($stores)) {
                    $stores = $this->model_pickup->search_store($keyword, $v, TRUE);
                }
            }
            $_data['stores'] = $stores;
            
            $store_properties = array();
            foreach($stores as $k=>$v) {
                $properties = $this->model_pickup->get_store_properties($v['id'],'date_of_operation', 'DESC', NULL, 'all', '1', TRUE);
                unset($properties['total_count']);
                $store_properties[$v['id']] = $properties;  
            }
            $_data['store_properties'] = $store_properties;
            $data['temp'] = $this->load->view('globe-estate/sections/pages/partials/ajax_payment_delivery_pickup', $_data, TRUE);
            echo json_encode($data);
        }
	

}
?>
