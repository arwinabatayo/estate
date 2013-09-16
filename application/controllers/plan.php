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
		
		$this->load->model('estate/products_model');
		
		//TODO: move to model
		$query = $this->db->get('estate_main_plan');
		$plans = $query->result();
		
		$this->_data->plans = $plans;
		
		$query = $this->db->get('estate_plans');
		$this->_data->plans_options = $query->result();
		
		$this->_data->account_m = $this->accounts_model;
        //temporary token = d25c1265aee883d97ffeec28b7e852cb        
        
		$this->_data->combos_datas = $this->products_model->get_bundles(2);
		$this->_data->boosters_datas = $this->products_model->get_bundles(1);
		
		
		$this->load->view($this->_data->tpl_view, $this->_data);
	}
	


	public function getpackageplancombos()
	{
		$this->load->model('estate/packageplan_model');

		$plan_id = $this->input->post('plan_id');

		$this->_data->package_plans_combos = $this->packageplan_model->get_package_plan_combos($plan_id);
		//$this->_data->package_plan_gadget_cashout = $this->packageplan_model->get_package_plan_gadget_cashout($plan_id);


		return $this->_data->package_plans_combos;
	}

	public function getpackageplangadgetcashout()
	{
		$this->load->model('estate/packageplan_model');

		$plan_id = $this->input->post('plan_id');

		$this->_data->package_plan_gadget_cashout = $this->packageplan_model->get_package_plan_gadget_cashout($plan_id);

		//var_dump($this->_data->package_plan_gadget_cashout);
		return $this->_data->package_plan_gadget_cashout;
	}

}
?>
