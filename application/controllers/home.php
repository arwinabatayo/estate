<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Home extends MY_Controller 
{
	var $_data = null;
	var $reserve_enabled = 0;
	
	function __construct()
	{
		parent::__construct();
		
        //global data
        
		$this->_data->tpl_view            = $this->config->item('globe_estate_template_path');
		$this->_data->assets_path         = $assets_path = $this->config->item('globe_estate_assets');
		$this->_data->assets_url          = base_url().$assets_path;
		$this->_data->current_method      = $this->router->method;
		$this->_data->current_controller  = strtolower( $this->router->class );
		$this->_data->show_breadcrumbs    =  true;
		$this->_data->current_step        =  1;
		$this->_data->page_title          =  'Add Device';
		$this->_data->site_config         = $this->getPropertyDataXML(1);
		$this->reserve_enabled 			  = $this->model_bpmanagement->getProcessStatusByCode('RESERVE');
		$this->prepaid_kit_overdue_enabled = $this->model_bpmanagement->getProcessStatusByCode('PREPAID_KIT_OVERDUE');
		//print_r($this->_data->site_config);
		//flag for testing
		define('IS_GLOBE_API_ENV', TRUE);
		define('DEV_ENV', false);
	}
	
	public function index()
	{	
		$this->_data->show_breadcrumbs    =  false;
		$this->_data->page = 'landing';
		$this->_data->process_button_text = "Buy Now!";
		
		//- - - - CLEAR ALL PREVIOUS TRANSACTION -  ES-66
			$this->cart->destroy();
			$this->session->unset_userdata('order_config');
			$this->session->unset_userdata('subscriber_info');
		//- - - - 
		
		if ($this->reserve_enabled) {
			$this->cart_model->set_order_config(array('order_type'=>'reserve'));
			$this->_data->process_button_text = "Reserve";
		}else{
			$this->cart_model->set_order_config(array('order_type'=>''));
		}
		
		$this->load->view($this->_data->tpl_view, $this->_data);
	}
	
	//temp force login
	public function login() {
		if($this->_initSubscriberInfo('9151178863')){
			redirect('plan');
		}
		
	}
		
	public function sku_configuration() {	
		
		//- - - - re-INIT Cart
			$this->cart->destroy();
		//- - - -	
		
		$arrDeviceAttr = array();
		
		$this->load->model('estate/home_model');
		
		if(isset($_GET['device']) && !empty($_GET['device'])) {
			
			$devices = $this->home_model->getDevices($_GET['device']);
			
			if(isset($_GET['type'])) {
				$arrKey = explode("_",$_GET['type']);
				$selectedKey = $arrKey[1];
			} else {
				reset($devices);
				$first_key = $devices[0]['id']; // set the first item default
				$selectedKey = $first_key;
			}
			
			$availableColor = $this->home_model->getAvailableColors($selectedKey);
			
			$colorCount = $availableColor['count'];
			unset($availableColor['count']);
			foreach($availableColor as $availColor) {
				$colors['clid'] = $availColor['clid'];
				$colors['clname'] = $availColor['clname'];
				$colors['climg'] = $availColor['climg'];
				$colors['gadgetimg'] = $availColor['gadgetimg'];
					
				$colorsAttr[$availColor['clid']] = $colors;
			}
			
			reset($colorsAttr);
			$first_keyColor = key($colorsAttr); // set the first item default
			
			
			$availableCapacity = $this->home_model->getCapacity($selectedKey, $first_keyColor);
			
			$capacityCount = $availableCapacity['count'];
			unset($availableCapacity['count']);
			foreach($availableCapacity as $capacities) {
				$capacity['dcid'] = $capacities['dcid'];
				$capacity['dcname'] = $capacities['dcname'];
				$capacity['dcimg'] = $capacities['dcimg'];
				$capacityAttr[$capacities['dcid']] = $capacity;
			}
			
			reset($capacityAttr);
			$first_keyCapacity = key($capacityAttr); // set the first item default
		}
		
		$this->_data->deviceAttrs = $arrDeviceAttr;
		$this->_data->devices = $devices;
		$this->_data->colors = $colorsAttr;
		$this->_data->initialColorId = $first_keyColor;
		$this->_data->capacity = $capacityAttr;
		$this->_data->initialCapacityId = $first_keyCapacity;
		
		$this->_data->page = 'home';
		$this->_data->is_reserve = $this->reserve_enabled;
		
		
		$this->load->view($this->_data->tpl_view, $this->_data);
	}
	public function changeAttrCapacity() {
		$sRet = "";
		$this->load->model('estate/home_model');
		
		$d = (object) $this->input->post();
		
		$availableCapacity = $this->home_model->getCapacity($d->device, $d->color);
			
		$capacityCount = $availableCapacity['count'];
		unset($availableCapacity['count']);
		$x = 1;
		foreach($availableCapacity as $capacities) {
			$selected = "";
			if($x == 1) { $selected = ' checked="checked"'; }
			$sRet .= '<li><img src="'.base_url().'_assets/uploads/'.$capacities['dcimg'].'" />
				<span>
					<input id="'.strtolower(str_replace(" ", "",$capacities['dcname'])).'" type="radio" name="gadget_capacity" 
							value="'.$capacities['dcid'].'"'.$selected.'>
					<label for="'.strtolower(str_replace(" ", "",$capacities['dcname'])).'">'.$capacities['dcname'].'</label>
				</span></li>';
			$x++;
		}
		echo $sRet;
	}
	public function test()
	{	
		$this->_data->show_breadcrumbs    =  false;
		$this->_data->page = 'test';
		
		//$acc_info = $this->accounts_model->get_account_info_by_id('9151178863');	
		$acc_info = $this->_validate_number('asd');	
		
		//$this->_initSubscriberInfo('9151178863');
		//$acc_info  = $this->accounts_model->is_msisdn_exist('9151178863');
		
		//print_r($acc_info);
						  
		echo var_dump( $acc_info );  
		//print_r( $this->accounts_model->get_account_info() );
		//$this->load->view($this->_data->tpl_view, $this->_data);
	}
	
	public function sms_verification()
	{	

		$this->_data->page = 'home';
		$this->_data->page_title = 'SMS Verification';
		$this->_data->is_reserve = $this->reserve_enabled;
		$this->_data->prepaid_kit_overdue_enabled = $this->prepaid_kit_overdue_enabled;

		$this->load->view($this->_data->tpl_view, $this->_data);
	}
	
	
	function send_sms_verification($msisdn=null)
	{
		$mobile_number = $this->input->post('msisdn', TRUE);
		
		if($msisdn){
			$mobile_number = $msisdn;
		}
		
		$_debugMsg = '';
		
		$data = array(
		  'status' => "success",
		  'msg'  => "",
		  'non_globe'  => 0,
		);


		$validation_result = $this->_validate_number($mobile_number);
		

		if( $validation_result['result'] == true ){
		
			//echo 'validation TRUE<br />';
			$_debugMsg .= 'validation_result - PASS<br />';
				
			if( $this->_check_if_globe_number($mobile_number)) {
				
								
				//-- -- GLOBE POST PAID
				if( $this->_globeApi_GetSubscriberByMSISDN($mobile_number) == true ){

						$_debugMsg .= '_globeApi_GetSubscriberByMSISDN() - PASS<br />';
						$data['non_globe'] = 0;
						
						$this->session->set_userdata('msisdn',$mobile_number);
					
                        $this->load->library('GlobeWebService','','api_globe');
                        $verification_code = random_string('alnum', 6);
                        $message = "Please use this code ".$verification_code." to verify your account.";
                        
                        if(!DEV_ENV){
							$sms_status = $this->api_globe->api_send_sms($mobile_number, $message, "Project Esate");
						}else{
							$sms_status = TRUE;
						}
  
                        //--SMS SENT
                        if($sms_status == TRUE) {
                            
                            $_debugMsg .= 'api_globe->api_send_sms() - PASS<br />';
                            
                            $this->load->model('estate/networks_model');
                            $this->networks_model->insert_sms_verification($mobile_number, $verification_code);
                            $this->session->unset_userdata('current_subscriber_mobileno');
                            $this->session->set_userdata('current_subscriber_mobileno', $mobile_number);
							
							$data['status'] = 'success';
							$data['msg']    = "SMS successfully sent to you mobile number";
                            

							/* Temporary Code For SAT and UAT Purposes */
							$email = $this->session->userdata('current_subscriber_email');
							$this->load->library('GlobeWebService','','api_globe');
							
							if(!DEV_ENV){
								$email_status = $this->api_globe->SendEmail($email, "Project Estate SMS Verification Code", $verification_code);
							}else{
								$email_status = TRUE;
							}
							
							if($email_status){
								$_debugMsg .= 'api_globe->SendEmail() - PASS<br />';
							}else{
								$_debugMsg .= 'api_globe->SendEmail() - FAILED<br />';
							}
							
                        } else {
                            $_debugMsg .= 'api_globe->api_send_sms() - FAILED<br />';
                            $data['status'] = 'error';
							$data['msg']     = "Failed sending sms. Please try again.";
                        }
                     
				}else{
					
					
					//-- -- GLOBE PREPAID	
					$data['status'] = "success";
					$data['non_globe'] = 1;
					$_debugMsg .= '_globeApi_GetSubscriberByMSISDN() - FAILED<br />';
				}

			}else{
				$_debugMsg .= '_check_if_globe_number() - FAILED<br />';
				
				//- - - - - NON-GLOBE. eg: smart,tnt
				
				$data['status'] = "success";
				$data['non_globe'] = 1;
					
				$order_cfg = $this->session->userdata('order_config');
				
				if ( $order_cfg['order_type'] == 'reserve' ) {
					$_debugMsg .= 'order_type - RESERVE<br />';
					$data['status'] = "success";
					$data['non_globe_reserve'] = 1;

					$data['mobile_number'] = $mobile_number;
					$data['email'] = $this->session->userdata('current_subscriber_email');

					// save mobile number on session
					$this->session->unset_userdata('current_subscriber_mobileno');
					$this->session->set_userdata('current_subscriber_mobileno', $mobile_number);
				}
				
				
			}
		
		}else{
			$_debugMsg .= '_validate_number - FAILED<br />';
			$data['status'] = "error";
			$data['msg']    = $validation_result['msg'];
		
		}
		
		//echo $_debugMsg;
		
		echo json_encode($data);
	}
	
	
	function check_verification_code()
	{
		$verification_code = $this->input->post('sms_verification_code', TRUE);
		
		$data = array(
		  "status"               => "success",
		  "msg"                  => "",
		  "token"                => "",
		  "order_type"           => "",
		  "next_page"            => ""
		);

		$data['mobile_number'] = $this->session->userdata('current_subscriber_mobileno');
		$this->load->model('estate/networks_model');                
		$mobile =  $this->session->userdata('current_subscriber_mobileno');
		$verification_info  = $this->networks_model->get_sms_verification($mobile);

		$hasError = false;
		
		//tries counter
		$try = $this->session->userdata('vcode_tries');
		
		if(!$try)
			$try = 0;
		
		if (DEV_ENV) {
			$verification_info['code'] = "test";
		}

		if($verification_code) {

			if($verification_code == $verification_info['code']) {
			// if (true) {
				
				//init/save subscriber info here
                $is_user_exist = $this->_initSubscriberInfo($mobile);
				
				if ($is_user_exist) {
					$data['status'] = "success";
					$data['msg'] = "Successfully Verified. Page is redirecting please wait...";
					$token =  md5('Globe0917'.'$4Lt*G'); //generate token/session here to access nextpage
	                $this->networks_model->delete_sms_verification($mobile);
                        
                        
                                        //Lawrence Alfonso 09262013
                                        //Check if account type (estate_account_category)
                                        //
                                        $result=$this->processCategory();
                                        $data['status'] = 'success';
                                        if($result=='endsequence')
                                        {
                                            $data['status'] = 'end';
                                            $data['msg']  = "An email has been successfully sent to your Relational Manager for your application's approval. <br>";
                                            //$data['msg'] .= "Kindly check your email for the link back to this site. Use the reference number we sent to check the status of your application.";
                                        }
                                        //================================================
                                        
                                        
				} else {
					
					$data['status'] = "error";
					$data['msg'] = "Subscriber info not found.";	
					
				}

			} else {
				$data['status'] = "error";
				$data['msg'] = "You must enter a valid verification code";
				$hasError = true;
			}
		} else {
			$data['status'] = "error";
			$data['msg'] = "Verification code is required.";
			$hasError = true;
		}
		
		if($hasError){
			$try++;
			$this->session->set_userdata('vcode_tries',$try);
		}
		$data['tries'] = $try;

		
		if($try > 2){
			$this->networks_model->delete_sms_verification($mobile);
			$this->session->unset_userdata('vcode_tries');
			$this->session->set_userdata('showcaptcha',true);
			$data['status'] = "error";
			$data['next_page'] = 'sms-verification?showcaptcha=true';
			
		}else{
			
			$this->session->unset_userdata('showcaptcha');
			$data['next_page'] = 'plan?token='.$token;
			
			$_cfg = $this->cart_model->get_order_config();
			
			// return flag to show overdue balance popup
			// check if user has overdue balance
			$account_info = $this->session->userdata('subscriber_info');
			$outstanding_balance = $account_info['outstanding_balance'];
			$due_date = $account_info['due_date'];
			$date_now = date("Y-m-d");

			if ($outstanding_balance !== 0) {
				if (strtotime($due_date) <= strtotime($date_now)) {
					$data['overdue_flag'] = true;
					$data['outstanding_balance'] = number_format($outstanding_balance, 2);
					$data['next_page'] = '';
				}
			}

			// -- reservation flow
			if(isset($_cfg['order_type']) && $_cfg['order_type'] == 'reserve'){
				$data['order_type'] = $_cfg['order_type'];
				// $data['next_page'] = 'home?showtymsg=true';
				
				// only add reservation from this point for globe subscribers ONLY
				// if all user verification passed
				// get reserve_specs from session
				$reserved_specs = $this->session->userdata('reserved_item_specs');

				$this->load->model('model_reservation');
				$reserve_data = array(
						// TODO : change to $data['mobile_number'] if API already works
						'mobile_number'	=> $data['mobile_number'],
						'specs'	=> $reserved_specs
					);
				// add reservation
				$this->model_reservation->addReservation($reserve_data);

				// set next page url
				$data['next_page'] = 'home';
			}
		
		}

		echo json_encode($data);
		exit;
	}	
	
	function verify($code='') 
	{

		$email = $this->input->get('e',true);
		$mobile = $this->input->get('m',true);
		
		$hash = $this->_create_hash($email);

		if($code == $hash){
		// if(true){
			// 'MATCH';
			
			/* Temporary Code For SAT and UAT Purposes */
			$this->session->unset_userdata('current_subscriber_email');
			$this->session->set_userdata('current_subscriber_email', $email);
			
			redirect( base_url().'sms-verification?token='.$hash);
			
		}else{
			echo 'Invalid verification code..'; //TODO - ilagay sa template
			exit;
		}

	}
	
	function send_email_activation() 
	{
		$email = $this->input->post('email', TRUE);
		$this->load->helper('email');
				
		$data = array(
		  "status" => "success",
		  "msg"  => "Your email was succesfully sent",
		);
	
		if($email){
			if (valid_email($email)) {
				$is_sent = $this->_sendMail($email, 'verify_account');
				// $is_sent = true;
				if($is_sent === false) {
					$data['status'] = "error";
					$data['msg'] = "Your email was not successfully sent";
				} else {
					$data['msg'] = "Your email was succesfully sent";
					
					//remove reset verification
					$this->session->unset_userdata('showcaptcha');
				}
			} else {
				$data['status'] = "error";
				$data['msg'] = "Email address is not valid";
			}
		} else {
			$data['status'] = "error";
			$data['msg'] = "Email address is required";
		}
		
		
		echo json_encode($data);
		exit;
	}
	
	function subscriber_info() 
	{
		$this->_data->page = 'subscriber';
		$this->_data->page_title          =  'Subscriber Info';
		$this->load->view($this->_data->tpl_view, $this->_data);
	}

	private function _sendMail($email_to, $flow_type)
    {
       
        $this->load->library('email');

        switch($flow_type) {
            case 'verify_account' :
                $sender = "no-reply@project-estate.com";
                $subject = "Globe Estate - Account Verification";
                $email_tpl = 'view_activation';
            
                $verification_code = $this->_create_hash($email_to);

                $msg = array(
                    'name'              => $email_to,
                    'verification_code' => $verification_code,
                    'verification_url'  => base_url().'home/verify/'.$verification_code.'?e='.$email_to,
                );

            break;
            case 'saved_transaction' :
                $uncomp_trans_lnk = "http://test.com"; // TODO : link to correct transaction page
                $sender = "no-reply@project-estate.com";
                $subject = "myGlobe - Saved Transaction Link";
                $email_tpl = 'view_transactionlink';

                $msg = array(
                        'name'  => $email_to,
                        'link'  => $uncomp_trans_lnk
                    );
            break;
            case 'forgot_refnum' :
            	// get order number by user email
            	$this->load->model('estate/order_model'); 
            	$order = $this->order_model->get_recent_order_by_email($email_to);

                $refnum = $order['order_number'];
                $sender = "no-reply@project-estate.com";
                $subject = "myGlobe - Reference Number";
                $email_tpl = 'view_refnum';

                $msg = array(
                        'name'  => $email_to,
                        'refnum'=> $refnum
                    );
            break;
            
        }

        if (DEV_ENV) {
        	return true;
        } else {
        	return $this->email->send_email_api($email_to, $subject, $email_tpl, $msg, $sender ); 
        }     
    }
    
    //move this function to helper -- SOON
    private function _create_hash($key=''){
		$secret_key = 'gL0b3-E$sT4te'.date('m-d-y');
		return md5($key.$secret_key);
	}
    
	private function _check_if_globe_number($mobile_number)
	{
		$this->load->model('estate/networks_model', 'networks');
		$globe_prefixes = $this->networks->check_number_prefix('Globe');
		
		$prefixes = '';
		foreach($globe_prefixes as $v) {
		   $prefixes[] = $v['number_prefix'];
		}
		$mobile_number_prefix = substr($mobile_number, 0, 4);
		if(in_array($mobile_number_prefix, $prefixes)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	private function _globeApi_GetSubscriberByMSISDN($mobile_number)
	{
		$this->load->library('GlobeWebService','','api_globe');
		
		$subscriber_info = $this->api_globe->GetSubscriberAndAssignedProductByMsisdn($msisdn);
		
		if(!empty($subscriber_info['SubscriberSearchResultInfo'])) {
			$subscriber_outstanding = $this->api_globe->GetOutstandingBalanceByMsisdn($msisdn);
			$subscriber_lockin = $this->api_globe->GetProductQueryFiltered($msisdn);

			$array_values = array(
				'account_id' => $subscriber_info['PayChannelHeader']['PayChannelNumberInfo']['AccountNo'],
				'full_name' => $subscriber_info['SubscriberSearchResultInfo']['NameLine1'],
				'email' => $subscriber_info['BillingArrangmentHeader']['AddressInfo']['AddressElement4'],
				'mobile_number' => $subscriber_info['SubscriberSearchResultInfo']['PrimaryResourceValue'],
				'address' => $subscriber_info['AccountHeader']['AddressInfo']['AddressElement7'].' '.$subscriber_info['AccountHeader']['AddressInfo']['AddressElement9'].' '.$subscriber_info['AccountHeader']['AddressInfo']['AddressElement10'],
				'zip' => $subscriber_info['AccountHeader']['AddressInfo']['AddressElement3'],
				'street' => $subscriber_info['AccountHeader']['AddressInfo']['AddressElement7'],
				'municipality' => $subscriber_info['AccountHeader']['AddressInfo']['AddressElement9'],
				'city' => $subscriber_info['AccountHeader']['AddressInfo']['AddressElement10'],
				'country' => $subscriber_info['AccountHeader']['AddressInfo']['AddressElement11'],
				'billing_address' => $subscriber_info['AccountHeader']['AddressInfo']['AddressElement7'].' '.$subscriber_info['AccountHeader']['AddressInfo']['AddressElement9'].' '.$subscriber_info['AccountHeader']['AddressInfo']['AddressElement10'],
				'lockin_duration' => $subscriber_lockin['APList']['AP']['7']['IAPList']['IAP']['APDetails']['AttrList']['Attr']['0']['Value'],
				'outstanding_balance' => $subscriber_outstanding['AccountBalanceDt']['ArBalance'],
				'overdue' => $subscriber_outstanding['OverDueBalance'],
				'due_date' => date('Y-m-d', strtotime($subscriber_outstanding['DocInfo']['DueDate'])),
				'credit_limit' => $subscriber_info['AccountHeader']['AccountingManagementInfo']['L9CreditLimit'],
				'category_id' => $this->parse_customer_type($subscriber_info['SubscriberSearchResultInfo']['PrimaryResourceType']),
				'current_plan' => $subscriber_info['AssignedProducts']['AssignedProduct']['0']['OfferName']['LocalizedValue'],
				'status' => '1'
			);
			$result = true;
		} else {
			$result = false;
		}		
		//SAVE data to accounts_model
		return $result;
	}
	
	private function _validate_number($mobile_number)
	{
		$out = array(
			'result' => true,
			'msg'    => '',
		);
		
		if( is_numeric($mobile_number) ){
			if( strlen($mobile_number) == 11 ){
				$out['result'] = true;
			}else{
				$out['msg'] = "You must enter a valid Mobile Number";
				$out['result'] = false;	
			}
		}else{
			$out['msg'] = "Mobile number is required or should be numeric";
			$out['result'] = false;
		}
		return $out;
	}

    // validate ref number - gellie
    function validate_reference_number()
    {
        // get reference number
        $refnum = $this->input->post('refnum', TRUE);

        $data = array();

        // retrieve order using reference number
        if ($refnum) {
            // sanitize reference number
            $refnum = trim($refnum);

            // if order exists -- redirect to status page
            $this->load->model('estate/order_model');
            $valid_refnum = $this->order_model->get_order_by_refnum($refnum);

            if ($valid_refnum) {
                $data['status'] = "success";
                $data['msg'] = "Successfully Verified. Page is redirecting please wait...";
                $data['status_page_url'] = base_url().'order?refnum=' . $refnum;
            } else {
                $data['status'] = "error";
                $data['msg'] = "Reference number you entered is incorrect. Please retype it again.";
            }
        } else {
            $data['status'] = "error";
            $data['msg'] = "Reference number is required";
        }

        echo json_encode($data);
        exit;

    }

    function verify_email_captcha()
    {
    	$d = (object) $this->input->post();
		$captcha_code = $this->session->userdata('captcha_code');
		$flow_type = $d->flow_type;
		$email = $d->email;

		$this->load->helper('email');
		$email_isvalid = valid_email($d->email);

		$data['status'] = "success";

		// check if captcha matches and email is valid
		// TODO : check if email needs to be registered first with globe
		if ($d->code == $captcha_code) {
			if ($email_isvalid) {
				
				if (DEV_ENV) {
					$is_sent = true;
				} else {
					$is_sent = $this->_sendMail($email, $flow_type);
				}
				                
                if ($flow_type == 'saved_transaction') {
                    $success_msg = "We have sent an email to " . $email . ". Click on the link to resume previously saved transaction. ";
                } else if ($flow_type == 'forgot_refnum') {
                    $success_msg = "We have sent an email to " . $email . " with your reference number to check the status of your application. ";        
                }

				if ($is_sent) {
					$data['msg'] = $success_msg;
				} else {
					$data['status'] = "error";
					$data['msg'] = "Email is not sent. System error";
				}
			} else {
				$data['status'] = "error";
				$data['msg'] = "Email is invalid";
			}
		} else {
			$data['status'] = "error";
			$data['msg'] = "Characters did not match";
            // $data['msg'] .= $d->code . " - " . $captcha_code;
		}

		echo json_encode($data); exit;

    }
    
	private function _initSubscriberInfo($msisdn)
    {
		
		$mobile_number = ltrim($msisdn,0);
		
		$acc_info = (array) $this->accounts_model->get_account_info_by_id($mobile_number,false);	
		
		$acc_type = array();
		
		if($acc_info->category_id){
			
			$acc_type = (array) $this->accounts_model->get_account_category($acc_info->category_id);
		
		}
		if($acc_info){
			
			$user_info = array_merge($acc_info,$acc_type);
			
			$this->session->set_userdata('subscriber_info',$user_info);
				
			return TRUE;
		}
		
		return FALSE;
	}

    function sendpaymentchannel()
    {
    	$d = (object) $this->input->post();

    	// store or send to email the settlement made
    	$pch = $d->payment_channel;
    	$refnum = $d->ref_num;
    	$ornum = $d->ref_num;
    	// store on overdue_payments
    	$is_sent = true;

    	if ($is_sent) {
    		// show ty popup
    		$data['status'] = 'success';
    	} else {
    		$data['status'] = 'error';
    		$data['msg'] = 'An error occurred. Please try again later.';
    	}

    	echo json_encode($data); exit;
    }
	
	/*
         * Lawrence Alfonso
         * Check if Platinum/Business, Then create Order, Emails
         * function ProcessCategory
         * param:
         *      mobiles number
         */
	function processCategory()
        {
                $this->load->model('estate/accounts_model','accounts');
                $client=$this->session->userdata('subscriber_info');
                
                $account_id=$client['account_id'];
                switch ($client[category_id])
                {
                    case 1:;//Platinum 
                        
                        if($client['rel_mngr_id'])
                        {
                            $this->load->model('estate/managers_model','managers');
                            $rel_manager=$this->managers->get_manager_info($client['rel_mngr_id'],false);
                            $ret='continue';
                            if($rel_manager->user_type==12)
                            {
                                $cart = $this->cart->contents();
                                $cart=current($cart);
                                $this->load->model('estate/order_model','order');


                                $d['account_id']   = $account_id;
                                $d['status']       = 2;
                                $d['subtotal']     = $cart[subtotal];
                                $d['total']        = $cart[price];
                                $d['date_ordered'] = date('Y-m-d h:i:s');
                                $d['order_type']   = 0; //phone only
                                $d['peso_value']   = $cart[price];

                                $i['product_id']   = $cart[product_id];
                                $i['qty']          = $cart[qty];
                                $i['product_type'] = $cart[product_type];//todo
                                $i['product_info'] = $cart[name];//todo
                                $refnum=$this->order->save_application($d,$i);
                                
                                $this->_sendBizMail($rel_manager->username, "notify_rm_for_platinum_client",$refnum);                                
                                $this->_sendBizMail($client[email], "notification_platinum_client",$refnum);
                                $ret='endsequence';
                                $cart = $this->cart->destroy();
                            }
                        }
                        break;
                    case 2:;//Business
                        break;
                    case 3:;//Personal
                        break;
                    case 4:;//SMB
                        break;
                    case 5:;//Enterprise Corporation
                        break;
                    case 6:;//Enterprise Individual
                        break;
                }
            return $ret;
        }
        private function _sendBizMail($email_to, $flow_type,$refnum=0)
        {

            $this->load->library('email');

            switch($flow_type) {
                case 'notify_rm_for_platinum_client' :
                    $refnum = $refnum;
                    $sender = "no-reply@project-estate.com";
                    $subject = "Platinum Application";
                    $email_tpl = 'view_rm_platinum_client_app';

                    $msg = array(
                            'name'  => $email_to,
                            'refnum'=> $refnum
                        );
                break;
                case 'notification_platinum_client' :
                    $refnum = $refnum;
                    $sender = "no-reply@project-estate.com";
                    $subject = "Platinum Application";
                    $email_tpl = 'view_platinum_client_app';

                    $msg = array(
                            'name'  => $email_to,
                            'refnum'=> $refnum
                        );
                break;
            }

            return $this->email->send_email_api($email_to, $subject, $email_tpl, $msg, $sender ); 
        }
        //==================================================================
		
		
	public function test_api($msisdn)
	{
		$this->load->library('GlobeWebService','','api_globe');
		$msisdn = '9175235250';
		
		$subscriber_info = $this->api_globe->GetSubscriberAndAssignedProductByMsisdn($msisdn);
		
		if(!empty($subscriber_info['SubscriberSearchResultInfo'])) {
			$subscriber_outstanding = $this->api_globe->GetOutstandingBalanceByMsisdn($msisdn);
			$subscriber_lockin = $this->api_globe->GetProductQueryFiltered($msisdn);

			$array_values = array(
				'account_id' => $subscriber_info['PayChannelHeader']['PayChannelNumberInfo']['AccountNo'],
				'full_name' => $subscriber_info['SubscriberSearchResultInfo']['NameLine1'],
				'email' => $subscriber_info['BillingArrangmentHeader']['AddressInfo']['AddressElement4'],
				'mobile_number' => $subscriber_info['SubscriberSearchResultInfo']['PrimaryResourceValue'],
				'address' => $subscriber_info['AccountHeader']['AddressInfo']['AddressElement7'].' '.$subscriber_info['AccountHeader']['AddressInfo']['AddressElement9'].' '.$subscriber_info['AccountHeader']['AddressInfo']['AddressElement10'],
				'zip' => $subscriber_info['AccountHeader']['AddressInfo']['AddressElement3'],
				'street' => $subscriber_info['AccountHeader']['AddressInfo']['AddressElement7'],
				'municipality' => $subscriber_info['AccountHeader']['AddressInfo']['AddressElement9'],
				'city' => $subscriber_info['AccountHeader']['AddressInfo']['AddressElement10'],
				'country' => $subscriber_info['AccountHeader']['AddressInfo']['AddressElement11'],
				'billing_address' => $subscriber_info['AccountHeader']['AddressInfo']['AddressElement7'].' '.$subscriber_info['AccountHeader']['AddressInfo']['AddressElement9'].' '.$subscriber_info['AccountHeader']['AddressInfo']['AddressElement10'],
				'lockin_duration' => $subscriber_lockin['APList']['AP']['7']['IAPList']['IAP']['APDetails']['AttrList']['Attr']['0']['Value'],
				'outstanding_balance' => $subscriber_outstanding['AccountBalanceDt']['ArBalance'],
				'overdue' => $subscriber_outstanding['OverDueBalance'],
				'due_date' => date('Y-m-d', strtotime($subscriber_outstanding['DocInfo']['DueDate'])),
				'credit_limit' => $subscriber_info['AccountHeader']['AccountingManagementInfo']['L9CreditLimit'],
				'category_id' => $this->parse_customer_type($subscriber_info['SubscriberSearchResultInfo']['PrimaryResourceType']),
				'current_plan' => $subscriber_info['AssignedProducts']['AssignedProduct']['0']['OfferName']['LocalizedValue'],
				'status' => '1'
			);
			print_r($array_values);
			$result = true;
		} else {
			$result = false;
		}		
		//SAVE data to accounts_model
		return $result;
	}

}


