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
		$this->db->where('status >',0);
		$query = $this->db->get('estate_main_plan');
		$plans = $query->result();
		
		$this->_data->plans = $plans;
		
		$query = $this->db->query('SELECT * FROM estate_plans WHERE is_active="1"');
		$this->_data->plans_options = $query->result();
		
		$this->_data->account_m = $this->accounts_model;
        //temporary token = d25c1265aee883d97ffeec28b7e852cb        
        
		$this->_data->combos_datas = $this->products_model->get_bundles(2);
		$this->_data->boosters_datas = $this->products_model->get_bundles(1);
		
		//echo "<pre>"; var_dump($this->_data); exit;
		$this->load->view($this->_data->tpl_view, $this->_data);
		//$this->load->view("section/plan", $this->_data);
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

	public function sendMail()
	{
		$email = $this->input->post('email');
		$this->load->helper('email');
		
				

		if (valid_email($email)) {
			
			return $this->_sendMail($email);
		
		} 
			
		
	}

	private function _sendMail($email_to)
    {
       
        $this->load->library('email');
        
        $verification_code = $this->_create_hash($email_to);
        
        $message = array(
         'name'              => $email_to,
         'verification_code' => $verification_code,
         'verification_url'  => base_url().'home/verify/'.$verification_code.'?e='.$email_to,
        );
        
        return $this->email->send_email($email_to,'no-reply@project-estate.com','Globe Estate - Account Verification',$message,'view_activation');
        //$mail_status = $this->email->send_email_api($email_to, 'Globe Estate - Account Verification', 'view_activation', $message);
    }
    
    //move this function to helper -- SOON
    private function _create_hash($key=''){
		$secret_key = 'gL0b3-E$sT4te'.date('m-d-y');
		return md5($key.$secret_key);
	}


}
?>
