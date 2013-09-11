<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Error_404 extends MY_Controller 
{

	function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "error";
		
		// show blank for missing files ONLY
		$ext = substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '.')+0);
		$ext_arr = array(".jpg", ".jpeg", ".png", ".gif", ".JPG", ".JPEG", ".PNG", ".GIF"); 
		if (!in_array($ext, $ext_arr)) {
			$_data['content'] = $this->load->view('error/view_error_404', $_data, TRUE);
			$this->load->view('admin/view_main_back', $_data);
		}
		
		return;
	}
	
}
?>