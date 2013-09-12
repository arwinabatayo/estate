<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MY_Controller 
{

	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata['logged_in']) { // logged in?
			if( $this->session->userdata('user_type') && $this->session->userdata('user_type') < 10 ){ 
				// is non-ecommerce users
				redirect(site_url('admin/dashboard')); 
			}elseif( $this->session->userdata('user_type') == 10 ){
				// is superadmin
				redirect(site_url('admin/dashboard')); 
			}else{
				// is ecommerce users
				redirect(site_url('admin/accountmanagement')); 
			}
		}
		
		
	}
	
	public function index()
	{
		$_data = array();
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "login";
		$this->load->view('admin/view_login', $_data);
		return;
	}
	
}
?>