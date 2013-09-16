<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accountmanagement extends MY_Controller 
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
		$this->load->model('model_plans');
		$this->load->model('model_accountmanagement');
		
		$user_type = $this->session->userdata('user_type');	
		
		$filter_arr = array();
		if ($this->input->post('filter')) {
			if( $this->input->post('account_number') ){
				$filter_arr['account_id'] = $this->input->post('account_number');
			}
		}
		
		$pagination_limit = 5;
		$current_page = 1;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$accounts = $this->model_accountmanagement->getAccounts($user_type,
																'estate_accounts.name', 
																'ASC', 
																$limit, 
																$pagination_limit, 
																$filter_arr);
		$account_total_count = $accounts_arr['total_count'];
		unset($accounts['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['accounts'] == $account_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'addons',
								'filter_arr' => $filter_arr,
								'item_count' => $account_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "accountmanagement";
		$_data['plan_bundles'] = $this->model_plans->getAllPlans();
		$_data['lock_in_periods'] = $this->model_plans->getAllLockInPeriods();
		$_data['order_statuses'] = $this->model_accountmanagement->getOrderStatuses();
		$_data['order_types'] = $this->model_accountmanagement->getOrderTypes();
		$_data['account_categories'] = $this->model_accountmanagement->getAllAccountCategories();
		$_data['accounts'] = $accounts;
		$_data['content'] = $this->load->view('admin/view_accountmanagement', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function viewaccount($account_id = null, $order_number = null)
	{
		if ($account_id==null) { redirect(site_url('admin/accountmanagment')); } // account_id?
		if ($order_number==null) { redirect(site_url('admin/accountmanagment')); } // account_id?
		
		$this->load->model('model_accountmanagement');
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "accountmanagement";
		$_data['account_id'] = $account_id;
		$_data['order_number'] = $order_number;
		$_data['relationship_managers'] = $this->model_accountmanagement->getRelationshipManagers(1);
		$_data['account_details'] = $this->model_accountmanagement->getAccountDetails($account_id, $order_number);
		$_data['content'] = $this->load->view('admin/view_accountmanagement_viewaccount', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function viewdocuments($account_id, $order_number)
	{
		if ($account_id==null) { redirect(site_url('admin/accountmanagment')); } // account_id?
		if ($order_number==null) { redirect(site_url('admin/accountmanagment')); } // account_id?
		
		$this->load->model('model_accountmanagement');
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "accountmanagement";
		$_data['account_id'] = $account_id;
		$_data['order_number'] = $order_number;
		$_data['order_statuses'] = $this->model_accountmanagement->getOrderStatuses();
		$_data['account_details'] = $this->model_accountmanagement->getAccountDetails($account_id, $order_number);
		$_data['content'] = $this->load->view('admin/view_accountmanagement_viewdocuments', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	function assign_relationship_value(){
		$account_id = $this->input->post('rm_account_id');
		$relationship_manager_id = $this->input->post('rm_relationship_manager_id');
		
		$this->load->model('model_plans');
		$this->load->model('model_accountmanagement');
		
		$this->model_accountmanagement->updateAccountRelationshipManager($account_id, $relationship_manager_id);
		
		$user_type = $this->session->userdata('user_type');	
		
		$filter_arr = array();
		if ($this->input->post('filter')) {
			if( $this->input->post('account_number') ){
				$filter_arr['account_id'] = $this->input->post('account_number');
			}
		}
		
		$pagination_limit = 5;
		$current_page = 1;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$accounts = $this->model_accountmanagement->getAccounts($user_type,
																'estate_accounts.name', 
																'ASC', 
																$limit, 
																$pagination_limit, 
																$filter_arr);
		$account_total_count = $accounts_arr['total_count'];
		unset($accounts['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['accounts'] == $account_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'addons',
								'filter_arr' => $filter_arr,
								'item_count' => $account_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "accountmanagement";
		$_data['plan_bundles'] = $this->model_plans->getAllPlans();
		$_data['lock_in_periods'] = $this->model_plans->getAllLockInPeriods();
		$_data['order_statuses'] = $this->model_accountmanagement->getOrderStatuses();
		$_data['order_types'] = $this->model_accountmanagement->getOrderTypes();
		$_data['account_categories'] = $this->model_accountmanagement->getAllAccountCategories();
		$_data['accounts'] = $accounts;
		$this->load->view('admin/view_accountmanagement', $_data);
		return;
	}
	
	function updateOrderStatus()
	{
		$comments = $this->input->post('comments');
		$status = $this->input->post('status');
		$order_number = $this->input->post('order_number');
		
		$this->load->model('model_plans');
		$this->load->model('model_accountmanagement');
		
		$this->model_accountmanagement->updateOrderStatus($order_number, $status, $comments);
		
		$user_type = $this->session->userdata('user_type');	
		
		$filter_arr = array();
		if ($this->input->post('filter')) {
			if( $this->input->post('account_number') ){
				$filter_arr['account_id'] = $this->input->post('account_number');
			}
		}
		
		$pagination_limit = 5;
		$current_page = 1;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$accounts = $this->model_accountmanagement->getAccounts($user_type,
																'estate_accounts.name', 
																'ASC', 
																$limit, 
																$pagination_limit, 
																$filter_arr);
		$account_total_count = $accounts_arr['total_count'];
		unset($accounts['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['accounts'] == $account_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'addons',
								'filter_arr' => $filter_arr,
								'item_count' => $account_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "accountmanagement";
		$_data['plan_bundles'] = $this->model_plans->getAllPlans();
		$_data['lock_in_periods'] = $this->model_plans->getAllLockInPeriods();
		$_data['order_statuses'] = $this->model_accountmanagement->getOrderStatuses();
		$_data['order_types'] = $this->model_accountmanagement->getOrderTypes();
		$_data['account_categories'] = $this->model_accountmanagement->getAllAccountCategories();
		$_data['accounts'] = $accounts;
		$this->load->view('admin/view_accountmanagement', $_data);
		return;
	}
}

?>