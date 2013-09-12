<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports_log extends MY_Controller 
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
		$this->load->model('model_users');
		
		$company_id = $this->session->userdata('company_id');
		$user_type = $this->session->userdata('user_type');
	
		if ($this->input->post('filter')) {
			$filter_arr = array('client_id' => $this->input->post('client_id'),
								'user_id' => $this->input->post('user_id'));
		}
	
		$pagination_limit = 100;
		$current_page = 1;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$log = $this->model_main->getLog(	$company_id, 
											$user_type, 
											"date", 
											"desc", 
											$limit, 
											$pagination_limit, 
											$filter_arr);
		$log_total_count = $log['total_count'];
		unset($log['total_count']);
		$log = $this->getAvatarPath($log);
		
		// get list of users for filtering
		$user_arr = $this->model_users->getUsers($company_id, $user_type, 'username', 'asc', 0, 'all');
		unset($user_arr['total_count']);
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'has_filter' => $this->input->post('filter'),
								'clients' => $this->populateClients(),
								'filter_arr' => $filter_arr,
								'users' => $user_arr);
		$_pagination = array(	'page' => 'reports_log',
								'filter_arr' => $filter_arr,
								'item_count' => $log_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "reports";
		$_data['log'] = $log;
		$_data['filter'] = $this->load->view('admin/view_reports_log_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$_data['content'] = $this->load->view('admin/view_reports_log', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	function process_items()
	{
		$this->load->model('model_users');
		
		$company_id = $this->session->userdata('company_id');
		$user_type = $this->session->userdata('user_type');
	
		if ($this->input->post('filter')) {
			$filter_arr = array('client_id' => $this->input->post('client_id'),
								'user_id' => $this->input->post('user_id'));
		}
		
		$pagination_limit = 100;
		$current_page = $this->input->post('current_page');
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$log = $this->model_main->getLog(	$company_id, 
											$user_type, 
											"date", 
											"desc", 
											$limit, 
											$pagination_limit, 
											$filter_arr);
		$log_total_count = $log['total_count'];
		unset($log['total_count']);
		$log = $this->getAvatarPath($log);
		
		// get list of users for filtering
		$user_arr = $this->model_users->getUsers($company_id, $user_type, 'last_name', 'asc', 0, 'all');
		unset($user_arr['total_count']);
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'has_filter' => $this->input->post('filter'),
								'current_page' => $current_page,
								'clients' => $this->populateClients(),
								'filter_arr' => $filter_arr,
								'users' => $user_arr);
		$_pagination = array(	'page' => 'reports_log',
								'filter_arr' => $filter_arr,
								'item_count' => $log_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['log'] = $log;
		$_data['filter'] = $this->load->view('admin/view_reports_log_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$this->load->view('admin/view_reports_log', $_data);
		return;
	}
	
}
?>