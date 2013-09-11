<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Error extends MY_Controller 
{

	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata['logged_in']) { redirect(site_url('logout')); } // logged in?
	}
	
	public function index()
	{
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "error";
		$_data['content'] = $this->load->view('view_error_denied', $_data, TRUE);
		$this->load->view('view_main', $_data);
	}
	
}
?>