<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MY_Controller 
{

	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata['logged_in']) { redirect(site_url('admin/dashboard')); } // logged in?
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