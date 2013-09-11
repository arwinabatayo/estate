<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Plan extends MY_Controller 
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
		$this->_data->current_step        =  2;
		$this->_data->page = 'plan';
		$this->_data->page_title          =  'Choose your Plan';
	}
	
	public function index()
	{	
		$this->load->model('estate/accounts_model');
		
		//TODO: move to model
		$query = $this->db->get('estate_main_plan');
		$plans = $query->result();
		
		$this->_data->plans = $plans;
		
		$query = $this->db->get('estate_plan');
		$this->_data->plans_options = $query->result();
		
		$this->_data->account_m = $this->accounts_model;
        //temporary token = d25c1265aee883d97ffeec28b7e852cb        
        
        //$this->products_model->;
        
		$this->load->view($this->_data->tpl_view, $this->_data);
	}
	


}
?>
