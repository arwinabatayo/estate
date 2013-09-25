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

	}
	
	public function index()
	{	
		
		$account_id = 1; //TODO get subs id
		
		$this->_data->billing_address = $this->accounts_model->get_account_address($account_id,'billing',FALSE);
		
		$this->_data->account_info = $this->accounts_model->get_account_address($account_id);
		
		
		$this->_data->cartItems = $this->cart->contents();
        
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
	

}
?>
