<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports_clients extends MY_Controller 
{

	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata['logged_in']) { redirect(site_url('admin/logout')); } // logged in?
		
		if( $this->session->userdata('user_type') && $this->session->userdata('user_type') < 10 ){ 
			// is non-ecommerce users
			// allow access
		}elseif( $this->session->userdata('user_type') == 10 ){
			// is superadmin
			// allow access
		}else{
			// is ecommerce users
			// dont allow access
			redirect(site_url('admin/accountmanagement')); 
		}
	}
	
	public function index()
	{
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "reports";
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$_data['content'] = $this->load->view('admin/view_reports_clients', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
}
?>