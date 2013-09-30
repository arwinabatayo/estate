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

	public function companyPersonalInfo()
	{
		$this->load->model('estate/plans_model');

		$this->_data->page = "company_personal_info";
		$this->_data->industry = $this->plans_model->getIndustry();
		$this->load->view($this->_data->tpl_view, $this->_data);
		//$this->load->view();
	}

	public function saveCompanyPersonalInfo()
	{
		$this->load->model('estate/subscriber_model');
		

		$data = array();

		$data['company_name'] = $this->input->post('name');
		$data['unit_floor'] = $this->input->post('unit');
		$data['building_name_street_no'] = $this->input->post('building_name');
		$data['street_name'] = $this->input->post('street');
		$data['barangay'] = $this->input->post('barangay');
		$data['municipality_town'] = $this->input->post('municipality');
		$data['city_province'] = $this->input->post('city');
		$data['postal_code'] = $this->input->post('postal');
		$data['industry_id'] = $this->input->post('industry');
		$data['position_1'] = $this->input->post('position_1');
		$data['email_address_1'] = $this->input->post('email_1');
		$data['contact_number_1'] = $this->input->post('contact_1');
		$data['authorized_corporate_1'] = $this->input->post('authorized_1');
		$data['position_2'] = $this->input->post('position_2');
		$data['email_address_2'] = $this->input->post('email_2');
		$data['contact_number_2'] = $this->input->post('contact_2');
		$data['vat_exemption_flag'] = $this->input->post('vat');
		$data['oct_flag'] = $this->input->post('oct');


		$this->subscriber_model->save_company($data);

	}
	

}
?>
