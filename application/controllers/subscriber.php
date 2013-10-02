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
		
		//global object of subcriber info, init from sms verification -mark
		$this->_data->account_info  = $account_info = (object) $this->session->userdata('subscriber_info');
		
		$this->_data->account_id = 2147483647; // to make it safe =)
		//TODO - add restriction or redirect if account info object is empty -mark
		if($account_info->account_id){
			$this->_data->account_id      = $account_info->account_id;
		}
		define('FACEBOOK_ON', TRUE);
		
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
		$this->load->model('estate/subscriber_model');

		$this->_data->page = "company_personal_info";

		$this->_data->get_city_province = $this->subscriber_model->get_city_province();

		$this->_data->industry = $this->plans_model->getIndustry();

		$this->load->view($this->_data->tpl_view, $this->_data);
		//$this->load->view();
	}

	public function saveCompanyPersonalInfo()
	{
		//echo $_FILES['file_data']['tmp_name']; exit;

		$this->load->model('estate/subscriber_model');
		$this->load->model('estate/blob_model');
		
		$info_type = $this->input->get("info_type");
		

		$data = array();

		if($info_type == "company"){
			$file = addslashes(file_get_contents($_FILES['file_data']['tmp_name']));
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
			$data['bir_certificate'] = $file;


			$this->subscriber_model->save_company($data);

			header("location: " . $this->input->post('from_page'));
		}else if($info_type == "personal"){
			$data['fname'] = $this->input->post('fname');
			$data['lname'] = $this->input->post('lname');
			$data['mname'] = $this->input->post('mname');
			$data['gender'] = $this->input->post('gender');
			$data['bday'] = $this->input->post('bday');
			$data['civil_status'] = $this->input->post('civil_status');
			$data['mfname'] = $this->input->post('mfname');
			$data['mlname'] = $this->input->post('mlname');
			$data['mmname'] = $this->input->post('mmname');
			$data['citizenship'] = $this->input->post('citizenship');
			$data['government_id'] = $this->input->post('government_id');
			$data['government_id_type'] = $this->input->post('government_id_type');
			//$data['email'] = $this->input->post('email');
			//$data['phone'] = $this->input->post('phone');
			$data['network_carrier'] = $this->input->post('network_carrier');
			$data['sns_username'] = $this->input->post('sns_username');
			$data['sns_type'] = $this->input->post('sns_type');

			$this->subscriber_model->save_personal($data);
		}
	}

	public function getCitizenship()
	{

	}

	public function saveBillingInfo($info_type)
	{
		$this->load->model('estate/subscriber_model');
		
		$info_type = $this->input->get("info_type");

		$data = array();

		if($info_type == "company"){

			$data['detailed_billing_type'] = $this->input->post('detailed_billing_type');
			$data['detailed_billing_email'] = $this->input->post('detailed_billing_email');
			$data['fname'] = $this->input->post('fname');
			$data['lname'] = $this->input->post('lname');
			$data['department'] = $this->input->post('department');
			$data['address'] = $this->input->post('address');
			$data['barangay'] = $this->input->post('barangay');
			$data['municipality'] = $this->input->post('municipality');
			$data['city'] = $this->input->post('city');
			$data['postal'] = $this->input->post('postal');
			$data['bill_summary_flag'] = $this->input->post('bill_summary_flag');
			$data['bill_summary_type'] = $this->input->post('bill_summary_type');
			$data['bill_email'] = $this->input->post('bill_email');
			$data['bfname'] = $this->input->post('bfname');
			$data['blname'] = $this->input->post('blname');
			$data['bdepartment'] = $this->input->post('bdepartment');
			$data['baddress'] = $this->input->post('baddress');
			$data['bbarangay'] = $this->input->post('bbarangay');
			$data['bmunicipality'] = $this->input->post('bmunicipality');
			$data['bcity'] = $this->input->post('bcity');
			$data['bpostal'] = $this->input->post('bpostal');

			$this->subscriber_model->save_company_billing($data);

		}else if($info_type == "personal"){
			$data['house_no'] = $this->input->post('house_no');
			$data['street'] = $this->input->post('street');
			$data['barangay'] = $this->input->post('barangay');
			$data['municipality'] = $this->input->post('municipality');
			$data['province'] = $this->input->post('province');
			$data['postal_code'] = $this->input->post('postal_code');
			$data['mobile_number'] = $this->input->post('mobile_number');
			$data['landline_number'] = $this->input->post('landline_number');

			$this->subscriber_model->save_personal_billing($data);
		}
	}
	
	public function fb()
	{
            parse_str( $_SERVER['QUERY_STRING'], $_REQUEST );
            $this->config->load("facebook",TRUE);
            $config = $this->config->item('facebook');
            $this->load->library('Facebook', $config);
            $userId = $this->facebook->getUser();

            if($userId == 0){
                $this->session->set_userdata('fb_success', FALSE );
                $data['status'] = 'redirect';
                $data['url'] = $this->facebook->getLoginUrl(array('scope'=>'publish_stream')); 
            } else {
                    $data['status'] = 'success';
                    $data['url'] = $user;
                    $this->session->set_userdata('fb_success', TRUE );
                    redirect('payment/plan_summary', 'refresh');
                    exit;                    
            }
            echo json_encode($data);
	}
	

	function validate_address_info($post){

		$isValid = true;
		$msg = '';
		$post = (array)$post;
		
		if(empty($post['unit'])){
			$msg .= 'Room / Floor / House Number field is required.<br />';
			$isValid = false;
		}
		if(empty($post['street'])){
			$msg .= 'Building Name / Street field is required.<br />';
			$isValid = false;
		}
		if(empty($post['barangay'])){
			$msg .= 'Subdivision / Barangay field is required.<br />';
			$isValid = false;
		}
		if(empty($post['town'])){
			$msg .= 'Municipality/Town field is required.<br />';
			$isValid = false;
		}
		if(empty($post['city'])){
			$msg .= 'City/Province field is required.<br />';
			$isValid = false;
		}
		if(empty($post['postal'])){
			$msg .= 'Postal Code/Zip Code field is required.<br />';
			$isValid = false;
		}
		
		return array('msg'=>$msg,'result'=>$isValid);
		
	}

}
?>
