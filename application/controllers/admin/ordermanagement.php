<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ordermanagement extends MY_Controller 
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata['logged_in']) { redirect(site_url('admin/logout')); } // logged in?
		
		if( $this->session->userdata('user_type') && $this->session->userdata('user_type') < 10 ){ 
			// is non-ecommerce users
			// dont allow access
			redirect(site_url('admin/dashboard')); 
		}elseif( $this->session->userdata('user_type') == 10 ){
			// is superadmin
			// dont allow access
			redirect(site_url('admin/dashboard')); 
		}else{
			// is ecommerce users
			// allow access
		}
	}
	
	public function index()
	{
		$this->load->model('model_ordermanagement');
		
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "ordermanagement";
		$_data['content'] = $this->load->view('admin/view_ordermanagement', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
}

?>