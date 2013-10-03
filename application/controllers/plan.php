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
		
		
		//global object of subcriber info, init from sms verification -mark
		$this->_data->account_info  = $account_info = (object) $this->session->userdata('subscriber_info');
		
		$this->_data->account_id = 2147483647; // to make it safe =)
		//TODO - add restriction or redirect if account info object is empty -mark
		if($account_info->account_id){
			$this->_data->current_plan    = $this->accounts_model->get_account_current_plan($account_info->account_id);
			$this->_data->account_id      = $account_info->account_id;
		}
		
	}
	
	public function index()
	{		
		$this->load->model('estate/products_model');
		
		$this->load->model('estate/cart_model');

		$this->load->model('estate/plans_model');

		//TODO: move to model
		$this->db->where('status >',0);
		$query = $this->db->get('estate_main_plan');
		$plans = $query->result();
		
		$this->_data->plans = $plans;


		/**  Robert for ultima **/
		$cart_gadget_details = $this->cart_model->get_gadget_oncart();
		
		$this->_data->plan_options = $this->products_model->get_plans($cart_gadget_details['id'],$cart_gadget_details['device_attr_id']); // gadget id is need to get all details
		$this->_data->active_plan = $this->cart_model->get_active_plan();
// 		$query = $this->db->query('SELECT * FROM estate_plans WHERE is_active="1"');
// 		$this->_data->plans_options = $query->result();
		
		$this->_data->account_m = $this->accounts_model;
        //temporary token = d25c1265aee883d97ffeec28b7e852cb   
       
                
                //Lawrence 2013-10-02
        	$user_info=$this->session->userdata('subscriber_info');
                //===================     
        
		$this->_data->combos_datas = $this->products_model->get_bundles(2);
		$this->_data->boosters_datas = $this->products_model->get_bundles(1);
		$this->_data->gadget_data = $this->cart_model->get_gadget_oncart();
                
                //Lawrence 2013-10-02
		//$this->_data->package_plan_options = $this->products_model->get_package_plan();
		$this->_data->package_plan_options = $this->products_model->get_package_plan($user_info[category_id]==1?3:$user_info[category_id]);
                //==========================
                
		$this->_data->package_plan_bundle = $this->products_model->get_package_plan_bundle();
		$this->_data->cart_contents = $this->cart->contents();
		$this->_data->s_industry = $this->plans_model->getIndustry('s');
		$this->_data->e_industry = $this->plans_model->getIndustry('e');
		
		if($this->input->get("get_new_line")){
			$this->_data->new_line_flag = true;
		}
                
                
                //Lawrence Alfonso 09272013                
                //==================================================                
		$this->load->model('estate/switch_model','switch');
                $SMBLI=$this->switch->get_switch("SMBLI",false);
                $ENTIN=$this->switch->get_switch("ENTIN",false);
                $SMBRE=$this->switch->get_switch("SMBRE",false);
		if($this->session->userdata('current_category')==2||
                   $this->session->userdata('current_category')==4||
                   $this->session->userdata('current_category')==5)
                      $this->_data->biz_line_flag = true;
                
                      $this->_data->SMBLI_switch  = $SMBLI->switch;
                      $this->_data->ENTIN_switch  = $ENTIN->switch;
                      $this->_data->SMBRE_switch  = $SMBRE->switch;
                      $this->_data->user_category = $this->session->userdata('current_category');
                //==================================================
		
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
		//echo "<pre>";var_dump($this->_data->package_plans_combos); exit;
		
		return $this->_data->package_plans_combos;
	}

	public function getpackageplangadgetcashout()
	{
		$this->load->model('estate/packageplan_model');

		$plan_id = $this->input->post('plan_id');
		$gadget_id = $this->input->post('gadget_id');

		$this->_data->package_plan_gadget_cashout = $this->packageplan_model->get_package_plan_gadget_cashout($plan_id, $gadget_id);

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
	
	function send_newline_request() 
	{
		$data['status'] = "error";
		$this->load->library('email');
		$account_info = $this->_data->account_info;
		
		$refnum = "1234"; // TODO : value for correct refnumber
		$sender = "no-reply@project-estate.com";
		$subject = "myGlobe - Get A New Line - Customer Copy"; //TODO- send to actual OM email then create a cc for customer
		$email_tpl = 'view_getnewline';

		$msg = array(
				'name'  => $account_info->name,
				'refnum'=> strtoupper( random_string('alnum', 6) ),
				'link'  => base_url(),
			);
       
		if( $this->email->send_email_api('mhaark29@gmail.com', $subject, $email_tpl, $msg, $sender) ){
			$data['status'] = "success";
			
		}
		//echo $this->email->print_debugger();
		
		echo json_encode($data); exit;
	}

        
    //Lawrence 10-02-2013
    function bizNewLine()
    {
            $client=$this->session->userdata('subscriber_info');                      
            $this->load->model('estate/managers_model','managers');
            
            $clienttmplate='view_notify_addline_client';            
            
            if($client['category_id']==2)//SMB
            {
                $tmplate='view_notify_tm_for_addline_client';
                //Teritory Manager  18
                $type="TM";  
                $managers=$this->managers->get_manager_email_receivers(18);
                if($managers){
                    foreach($managers as $manager)
                    {
                        $tmp[]=$manager->username;
                    }    
                    $mails=implode(",", $tmp);                
                }
            }
            elseif($client['category_id']==4||$client['category_id']==5)//Enterprise
            {
                $tmplate='view_notify_am_for_addline_client';
                //Account Manager  13
                $type="AM";
                $managers=$this->managers->get_manager_email_receivers(13);
                if($managers){
                    foreach($managers as $manager)
                    {
                        $tmp[]=$manager->username;
                    }    
                    $mails=implode(",", $tmp);                
                }
            }
            
            
	    $lineqty = $this->input->post('lineqty');
            $cart = $this->cart->contents();
            $cart=current($cart);
            $this->load->model('estate/order_model','order');

            $d['account_id']   = $client['account_id'];
            $d['status']       = 2;
            $d['subtotal']     = $cart[subtotal];
            $d['total']        = $cart[price];
            $d['date_ordered'] = date('Y-m-d h:i:s');
            $d['order_type']   = 2; //Additional Line
            $d['peso_value']   = $cart[price];

            $i['product_id']   = $cart[product_id];
            $i['qty']          = $lineqty;
            $i['product_type'] = $cart[product_type];
            $i['product_info'] = $cart[name];
            $refnum=$this->order->save_application($d,$i);

            
            $cart = $this->cart->destroy();
            
            

            $data['status'] ="success";
            $data['msg'] = "An email has been sent to $type for your application approval.";

           

            $sender = "no-reply@project-estate.com";
            $subject = "Globe Estate - New Line Request";


            if($client['email'])
                if (valid_email($client['email'])) {
                    $msg = array(
                        'name'              => $client['name'],
                        'email'             => $client['email'],
                        'refnum'            => $refnum
                    );
                    $this->email->send_email_api($client['email'], $subject, $clienttmplate, $msg, $sender );
                }  
            if($mails)                       
                if (valid_email($_manager->username)) {
                    $msg = array(
                        'name'              => $client['name'],
                        'email'             => $client['email'],
                        'refnum'            => $refnum
                    );
                    $this->email->send_email_api($mails, $subject, $tmplate, $msg, $sender ); 
                }
            
            
            echo json_encode($data);
    }        
    function RecordAddLinesQty()
    {
        $this->session->set_userdata('subscriber_addline',$this->input->post('lineqty'));

        $data['status'] ="success";  
        $data['msg'] = "Testing by Law";                   
        echo json_encode($data);
    }
    function BizRecontractingApplication()
    {
            $client=$this->session->userdata('subscriber_info');                      
            $this->load->model('estate/managers_model','managers');
            
            $clienttmplate='view_notify_recon_client';
            if($client['category_id']==2)//Business SMB
            {
                $tmplate='view_notify_gboc_for_recon_smb';
                //GBOC   19
                $type="GBOC";
                $managers=$this->managers->get_manager_email_receivers(19);
                if($managers){
                    foreach($managers as $manager)
                    {
                        $tmp[]=$manager->username;
                    }    
                    $mails=implode(",", $tmp);                
                }
            }
            elseif($client['category_id']==4)//Business Enterprise Corporation
            {
                $tmplate='view_notify_am_for_recon_bizcorp';
                //Account Manager  13
                $type="AM";
                $managers=$this->managers->get_manager_email_receivers(13);
                if($managers){
                    foreach($managers as $manager)
                    {
                        $tmp[]=$manager->username;
                    }    
                    $mails=implode(",", $tmp);                
                }
            }
            elseif($client['category_id']==5)//Business Enterprise Individual
            {
                $tmplate='view_notify_am_for_recon_bizind';
                //Account Manager   13
                $type="AM";
                $managers=$this->managers->get_manager_email_receivers(13);
                if($managers){
                    foreach($managers as $manager)
                    {
                        $tmp[]=$manager->username;
                    }    
                    $mails=implode(",", $tmp);                
                }
            }
            
            $cart = $this->cart->contents();
            $cart=current($cart);
            $this->load->model('estate/order_model','order');

            $d['account_id']   = $client['account_id'];
            $d['status']       = 2;
            $d['subtotal']     = $cart[subtotal];
            $d['total']        = $cart[price];
            $d['date_ordered'] = date('Y-m-d h:i:s');
            $d['order_type']   = 1; //Recontracting
            $d['peso_value']   = $cart[price];

            $i['product_id']   = $cart[product_id];
            $i['qty']          = 1;
            $i['product_type'] = $cart[product_type];
            $i['product_info'] = $cart[name];
            $refnum=$this->order->save_application($d,$i);

            
            $cart = $this->cart->destroy();
            
            

            $data['status'] ="success";
            $data['msg'] = "An email has been sent to $type for your application approval.";

           

            $sender = "no-reply@project-estate.com";
            $subject = "Globe Estate - New Line Request";


            if($client['email'])
                if (valid_email($client['email'])) {
                    $msg = array(
                        'name'              => $client[name],
                        'email'             => $client[email],
                        'refnum'            => $refnum
                    );
                    $this->email->send_email_api($client['email'], $subject, $clienttmplate, $msg, $sender );
                }  
            if($mails)                       
                if (valid_email($_manager->username)) {
                    $msg = array(
                        'name'              => $client->name,
                        'email'             => $client->email,
                        'refnum'            => $refnum
                    );
                    $this->email->send_email_api($mails, $subject, $tmplate, $msg, $sender ); 
                }
            
            
            echo json_encode($data);
    }


}
?>
