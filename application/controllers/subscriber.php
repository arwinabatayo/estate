<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subscriber extends MY_Controller 
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
		$this->_data->current_step        =  4;
		$this->_data->page                = 'subscriber';
		$this->_data->page_title          =  'Subscriber Info';
	}
	
	public function index()
	{	
		//$this->load->model('estate/accounts_model');
		
		//$this->_data->account_m = $this->accounts_model;
      
        
		$this->load->view($this->_data->tpl_view, $this->_data);
	}
	

}
?>
