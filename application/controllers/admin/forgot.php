<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forgot extends MY_Controller 
{
	
	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata['logged_in']) { redirect(site_url('admin/dashboard')); } // logged in?
	}
	
	public function index($token = 0)
	{	
		$this->load->model('model_users');
	
		if ($token) 
		{
			$user_details = $this->model_users->getUserDetailsByToken($token);
			
			if ($user_details) 
			{
				$expired = 0; 
				$this->model_users->updateToken($user_details['user_id'], "");
				
				$user_fullname = $user_details['first_name'] . " " . $user_details['last_name'];
				
				// reset password
				$new_password = $this->generateRandomPassword();
				$encrypted_password = md5($new_password);
				$this->model_users->resetPassword($user_details['user_id'], $encrypted_password);
				
				// send the email
				$_data['new_password'] = $new_password;
				$_data['user_fullname'] = $user_fullname;
				$message = $this->load->view('email/view_resetpassword', $_data, true);
					
				$config['mailtype'] = 'html';
				
				$this->load->library('email');
				$this->email->initialize($config);
				$this->email->from('no-reply@sitemee.com', 'Sitemee');
				$this->email->reply_to(SUPPORT_EMAIL, SUPPORT_NAME);
				$this->email->to($user_details['username']); 
				$this->email->subject('Sitemee Password Reset');
				$this->email->message($message);	
				$this->email->send();
				
				// echo $this->email->print_debugger();
			} 
			else 
			{ 
				$expired = 1; 
			}
		
			$_data = array();
			$_data['page'] = "forgot";
			$_data['expired'] = $expired;
			$_data['content'] = $this->load->view('view_forgot', $_data, TRUE);
			$this->load->view('view_main_front', $_data);
		}
		else
		{
			$_data = array();
			$_data['page'] = "forgot";
			$_data['no_token'] = 1;
			$_data['content'] = $this->load->view('view_forgot', $_data, TRUE);
			$this->load->view('view_main_front', $_data);
		}
		
		return;
	}
	
}
?>