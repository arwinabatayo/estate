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
		$this->_data->show_breadcrumbs    =  false;
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
		

		
		
	}
	
	public function plan_summary()
	{	
		$this->_data->page  = 'payment_plan_summary';
		
		$this->_data->cartItems = $this->cart->contents();
		//~ print_r($this->_data->cartItems);
		//~ die();
		$this->load->view($this->_data->tpl_view, $this->_data);
	}
	
	public function delivery_pickup()
	{	
		$this->_data->page  = 'payment_delivery_pickup';
		
		$this->load->view($this->_data->tpl_view, $this->_data);
	}
	
	public function shipping_address()
	{
		
		$this->_data->page  = 'payment_shipping_address';
		$this->_data->billing_address = $this->accounts_model->get_account_address($this->_data->account_id,'billing',FALSE);

		$this->load->view($this->_data->tpl_view, $this->_data);
	}
	
	//TODO - pls refer to old template(globe-estate) as implemented by Stephen
	public function pickup_store()
	{
		
		$this->_data->page  = 'payment_pickup_store';

		$account_id = $this->_data->account_id;
		
		$this->_data->billing_address = $this->accounts_model->get_account_address($account_id,'billing',FALSE);
		
		$this->_data->account_info = $this->accounts_model->get_account_address($account_id);
	
		$this->_data->cartItems = $this->cart->contents();
                
                $this->load->model('model_pickup');
                $params = array(
                    'postal_code' => $this->_data->billing_address->postal_code,
                    'city'  => $this->_data->billing_address->city
                );
                $this->load->model('model_pickup');
                $params['on_top']='0';
                $stores = $this->model_pickup->list_stores_nearby($params);
                $this->_data->stores =  $stores;
                
                $params['on_top']='1';
                $this->_data->stores_on_top = $this->model_pickup->list_stores_nearby($params);

                $stores_all = $this->model_pickup->list_stores_nearby(array('on_top'=>'0'));
                unset($stores_all['total_count']);
                $this->_data->stores_all = $stores_all;
                
                

                unset($params['on_top']);
                $stores = $this->model_pickup->list_stores_nearby($params);
                $store_properties = array();
                foreach($stores as $k=>$v) {
                    $properties = $this->model_pickup->get_store_properties($v['id'],'date_of_operation', 'DESC', NULL, 'all', '1', TRUE);
                    unset($properties['total_count']);
                    $store_properties[$v['id']] = $properties;  
                }

                $this->_data->store_properties = $store_properties;
        
        
		$this->load->view($this->_data->tpl_view, $this->_data);

	}
	
	public function confirm_order()
	{
		
		$this->_data->page  = 'payment_confirm_order';
		$this->_data->cartItems = $this->cart->contents();
		$this->load->view($this->_data->tpl_view, $this->_data);
	}
	
	public function payment_method()
	{
		
		$this->_data->page  = 'payment_method';
		
		$this->load->view($this->_data->tpl_view, $this->_data);
	}
	
	public function payment_form()
	{
		
		$this->_data->page  = 'payment_form';

		$this->load->view($this->_data->tpl_view, $this->_data);
	}
	
	/**
	 * Update By Robert 10.01
	 */
	//Note/TODO: Thank you survey - Pls. make it ajax display after answering the survey
	public function survey() {	
		$this->load->model('estate/survey_model');
		
		$this->_data->survey_list = $this->survey_model->get_all_survey();
		$this->_data->page  = 'survey';
		$this->_data->show_breadcrumbs    =  false;
		
		$this->load->view($this->_data->tpl_view, $this->_data);
	}
	public function save_survey() {
		$ret = "yes";
		$account_info = (object) $this->session->userdata('subscriber_info');
		$order_config = (object) $this->session->userdata('order_config');
		
		
		$post = $this->input->post();
		$str = implode("|", $post['survey']);
		
		if(!empty($str)) {
			$selected_survey_ids = str_pad($str,strlen($str)+2,"|",STR_PAD_BOTH);
			
			$this->load->model('estate/survey_model');
			$data['order_number'] = $order_config->order_number;
			$data['account_id'] = $account_info->account_id;
			$data['selected_offers'] = $selected_survey_ids;
			
			$this->survey_model->save_survey($data);
		}
		echo "yes";
	}
	
	//Thank you for... / Check Eligibilty
	public function thankyou()
	{	
		$this->_data->page  = 'thankyou_check_eligibility';
		$this->_data->page_title          = 'Thank you for your order';
		$this->_data->show_breadcrumbs    =  false;
		
		$this->_data->eligible_numbers    = 0;
		$this->_data->eligible_numbers    = $this->accounts_model->get_eligible_numbers($this->_data->account_id); 
		
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
		$data['temp'] = $this->load->view('globe-estate-blue/sections/pages/partials/ajax_payment_delivery_pickup', $_data, TRUE);
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
		$data['temp'] = $this->load->view('globe-estate-blue/sections/pages/partials/ajax_payment_delivery_pickup', $_data, TRUE);
		echo json_encode($data);
	}

	function settle_payment()
	{
		$d = (object) $this->input->post();
		$error_msg = '';

		// validate form
		if ($d->payment_channels) {
			if( !(preg_match("/^[a-zA-Z'-]/", $d->payment_channels)) ) {
				$error_msg .= 'Payment channel is invalid.<br/>'; 
			}
		} else {
			$error_msg .= 'Payment channel is required.<br/>';
		}

        if (!(trim($d->reference_number))) {            
            $error_msg .= 'Reference number is required.<br/>';
        }

        if (!$error_msg) {
            $this->load->model('model_overduepayments');

            $user_info = $this->session->userdata('subscriber_info');
            $account_id = $user_info['account_id'];

            $payment_data = array (
                    'account_id'            => $account_id,
                    'payment_channel'       => $d->payment_channels,
                    'payment_channel_medium'=> $d->payment_medium_name,
                    'reference_number'      => $d->reference_number,
                    'receipt_number'        => $d->or_num
                );

            $insert_id = $this->model_overduepayments->addOverduePayment($payment_data);

            if ($insert_id) {
                $data['status'] = 'success';
                $data['msg'] = 'We will get back to you in xhours or xdays, once we confirmed your payment.';
            } else {
                $data['success'] = 'error';
                $data['msg'] = "An error occurred. Please try again later.";
            }
        } else {
            // send error msg to view
            $data['status'] = 'error';
            $data['msg'] = $error_msg;
        }

        echo json_encode($data); exit;
	}	

}
?>
