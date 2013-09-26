<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Addons extends MY_Controller 
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
		$this->_data->current_step        =  3;
		$this->_data->accordionIndex      =  3;
		$this->_data->page_title          =  'Add-ons';
		
		$this->load->model('estate/products_model','products');
	}
	
	public function index()
	{	
		$_data = array();
		$_data['sess_user'] = $this->session->userdata;
		$this->_data->page = 'addons';
		
		
		
		$this->_data->gadget_care = $this->products->get_add_ons_by_category(1);
		$this->_data->freebies = $this->products->get_add_ons_by_category(2);
		$this->_data->offers = $this->products->get_add_ons_by_category(3);
		
		$this->_data->accessories = $items = $this->products->get_accessories();
		
		$this->_data->cart_contents = $this->cart->contents();


		$this->load->view($this->_data->tpl_view, $this->_data);
	}
	
	
	public function accessories()
	{
		
	//	redirect('addons');
		
		$this->_data->accordionIndex      =  4;
		$this->_data->page_title          =  'Accessories';
		$this->_data->page = 'addons_accessories';
		
		$this->load->model('estate/accounts_model');
		
		$this->_data->accessories = $items = $this->products->get_accessories();
		
		//print_r($items);
		
		$this->load->view($this->_data->tpl_view, $this->_data);
	}

}
?>
