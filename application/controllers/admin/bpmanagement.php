<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bpmanagement extends MY_Controller 
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
			// allow functions
		}else{
			// is ecommerce users
			// dont allow access
			redirect(site_url('admin/accountmanagement')); 
		}
	}

	public function index()
	{
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "bpmanagement";
		$_data['processes'] = $this->model_bpmanagement->getAllProcess();
		$_data['content'] = $this->load->view('admin/view_bpmanagement', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}

	function updateProcessStatus()
	{
		// get variables from view
		$d = (object) $this->input->post();
		// update status and get current one
		$curr_status = $this->model_bpmanagement->updateProcessByCode($d->process_code);
		// convert status to word
		if ($curr_status == 1) { $curr_status = "Enable"; } else { $curr_status = "Disable"; }
		// send data to view
		echo json_encode(array('status' => 'success', 'curr_status' => $curr_status));
	}
}

?>