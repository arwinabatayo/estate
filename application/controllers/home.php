<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Home extends MY_Controller 
{
	var $_data = null;
	
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
		
		
		//print_r($this->_data->site_config);
		//flag for testing
		define('IS_GLOBE_API_ENV',TRUE);
	}
	
	public function index()
	{	
		$this->_data->show_breadcrumbs    =  false;
		$this->_data->page = 'landing';
		$this->_data->show_reserve_button = false;
		
		
		if(isset($_GET['reserve'])){
			$this->cart_model->set_order_config(array('order_type'=>'reserve'));
			$this->_data->show_reserve_button = true;
		}else{
			$this->cart_model->set_order_config(array('order_type'=>''));
		}
		
		$this->load->view($this->_data->tpl_view, $this->_data);
	}
	
	//temp force login
	public function login() {
		if($this->_initSubscriberInfo('09151178863')){
			redirect('plan');
		}
		
	}
		
	public function sku_configuration() {	
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
		if (isset($_GET['reserve']) && $_GET['reserve']) {
			$this->_data->is_reserve = 1;
		}
		
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
							value="'.strtolower(str_replace(" ", "",$capacities['dcname'])).'"'.$selected.'>
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
		
		//$this->_initSubscriberInfo('9151178863');
		$acc_info  = $this->accounts_model->is_msisdn_exist('09151178863');
		
		//print_r($acc_info);
						  
		echo var_dump( $acc_info );  
		//print_r( $this->accounts_model->get_account_info() );
		//$this->load->view($this->_data->tpl_view, $this->_data);
	}
	
	public function sms_verification()
	{	

		$this->_data->page = 'home';
		$this->_data->page_title =  'SMS Verification';
		$this->_data->is_reserve = $this->session->userdata('reserved_item_specs');
		$this->load->view($this->_data->tpl_view, $this->_data);
	}
	
	
	function send_sms_verification($msisdn=null)
	{
		$mobile_number = $this->input->post('msisdn', TRUE);
		
		if($msisdn){
			$mobile_number = $msisdn;
		}
		
		$data = array(
		  "status" => "success",
		  "msg"  => ""
		);
		
		
		if($mobile_number) {
			
			if(!is_numeric($mobile_number)) {
				
				$data['status'] = "error";
				$data['msg'] = "Mobile number should all be numeric";
				
			} else {
                     
                     $is_user_exist = $this->accounts_model->is_msisdn_exist($mobile_number);
                            
                     //NO need to check if using a globe mobile num, all data in estate_account is current globe subscriber       
					//if( $this->_check_if_globe_number($mobile_number) == TRUE && strlen($mobile_number) == 11) {	
					if( $is_user_exist && strlen($mobile_number) == 11) {
							
							$data['status'] = 'success';
							$data['msg']    = "SMS successfully sent to you mobile number";
							$this->session->set_userdata('msisdn',$mobile_number);
						
                            $this->load->library('GlobeWebService','','api_globe');
                            $verification_code = random_string('alnum', 6);
                            $message = "Please use this code ".$verification_code." to verify your account.";
                            
                            if(IS_GLOBE_API_ENV){
								$sms_status = $this->api_globe->api_send_sms($mobile_number, $message, "Project Esate");
							}else{
								$sms_status = TRUE;
							}
                           
                            
                            if($sms_status == TRUE) {
                                $this->load->model('estate/networks_model');
                                $this->networks_model->insert_sms_verification($mobile_number, $verification_code);
                                $this->session->unset_userdata('current_subscriber_mobileno');
                                $this->session->set_userdata('current_subscriber_mobileno', $mobile_number);
                                $data['status'] = 'success';
                                

								/* Temporary Code For SAT and UAT Purposes */
								$email = $this->session->userdata('current_subscriber_email');
								$this->load->library('GlobeWebService','','api_globe');
								$email_status = $this->api_globe->SendEmail($email, "Project Estate SMS Verification Code", $verification_code);
                            } else {
                                $data['status'] = "error";
								$data['msg'] = "Failed sending sms. Please try again.";
                            }
						
					} else {
						$data['status'] = "error";
						//$v = var_dump($is_user_exist);
						$data['msg'] = "You must enter a valid Globe Mobile Number or an existing Globe Subscriber ".$mobile_number;
					}            
                            

            }
            			
		} else {
			$data['status'] = "error";
			$data['msg'] = "Mobile number is required.";
		}
		
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

		$data['is_globe_subscriber'] = false;
		$data['mobile_number'] = $this->session->userdata('current_subscriber_mobileno');
		$this->load->model('estate/networks_model');                
		$mobile =  $this->session->userdata('current_subscriber_mobileno');
		$verification_info  = $this->networks_model->get_sms_verification($mobile);

		$hasError = false;
		
		//tries counter
		$try = $this->session->userdata('vcode_tries');
		
		if(!$try)
			$try = 0;
		
		if($verification_code) {

			if($verification_code == $verification_info['code']) {
			//if (true) {
				
				//init/save subscriber info here
                $is_user_exist = $this->_initSubscriberInfo($mobile);
				
				if($is_user_exist){
					$data['status'] = "success";
					$data['msg'] = "Successfully Verified. Page is redirecting please wait...";
					$token =  md5('Globe0917'.'$4Lt*G'); //generate token/session here to access nextpage
	                $this->networks_model->delete_sms_verification($mobile);
	                
				}else{
					
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
			
			if(isset($_cfg['order_type']) && $_cfg['order_type'] == 'reserve'){
				$data['order_type'] = $_cfg['order_type'];
				// $data['next_page'] = 'home?showtymsg=true';
				
				// only add reservation from this point for globe subscribers ONLY
				if ($data['is_globe_subscriber']) {
					// get reserve_specs from session
					$reserved_specs = $this->session->userdata('reserved_item_specs');

					$this->load->model('model_reservation');
					$reserve_data = array(
							'mobile_number'	=> '09173858958', //$data['mobile_number'],
							'specs'	=> $reserved_specs
						);
					$this->model_reservation->addReservation($reserve_data);
				}
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
			// 'MATCH';
			
			/* Temporary Code For SAT and UAT Purposes */
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
				//$is_sent = true;
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
                $refnum = "1234"; // TODO : value for correct refnumber
                $sender = "no-reply@project-estate.com";
                $subject = "myGlobe - Reference Number";
                $email_tpl = 'view_refnum';

                $msg = array(
                        'name'  => $email_to,
                        'refnum'=> $refnum
                    );
            break;
        }

        return $this->email->send_email_api($email_to, $subject, $email_tpl, $msg, $sender ); 
        
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
		   $prefixes[] = $v['f_number_prefix'];
		}
		$mobile_number_prefix = substr($mobile_number, 0, 4);
		if(in_array($mobile_number_prefix, $prefixes)) {
			return TRUE;
		} else {
			return FALSE;
		}
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
				
				$is_sent = $this->_sendMail($email, $flow_type);
				
				//$is_sent=true;
                
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


}


