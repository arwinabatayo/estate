<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Userfunctions extends MY_Controller 
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
	
	public function index(){
		$this->load->model('model_userfunctions');
		
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "userfunctions";
		$_data['user_functions'] = $this->model_userfunctions->getUserFunctions();
		$_data['ecommerce_user_roles'] = $this->populateEcommerceUserRoles();
		$_data['content'] = $this->load->view('admin/view_userfunctions', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	//update status of user function VS ecommerce user role
	public function update_userfunction_vs_ecommerceuserrole(){
		if( $this->input->post('function_id') && $this->input->post('user_type_id') ){
			$function_id = $this->input->post('function_id');
			$user_type_id = $this->input->post('user_type_id');
			$is_checked = 0;
			if( $this->input->post('is_checked') ){
				$is_checked = 1;
			}
			
			$this->load->model('model_userfunctions');
			
			$this->model_userfunctions->update_userfunction_vs_ecommerceuserrole($function_id, $user_type_id, $is_checked);
		}
	}
}

?>