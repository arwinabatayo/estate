<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ordershipping extends MY_Controller 
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
			redirect(site_url('admin/ordershipping')); 
		}
	}
	
	public function index()
	{
		// $this->load->model('model_accountmanagement');
		$this->load->model('model_ordermanagement');
		$this->load->model('model_accountmanagement');
		$user_type = $this->session->userdata('user_type');	
		
		$filter_arr = array();
		
		$pagination_limit = 5;
		$current_page = 1;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$accounts_arr = $this->model_ordermanagement->getOrders($user_type,
																'estate_orders.date_ordered', 
																'ASC', 
																$limit, 
																$pagination_limit, 
																$filter_arr);
		$account_total_count = $accounts_arr['total_count'];
		unset($accounts_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['accounts'] == $account_total_count;
		
		$_pagination = array(	'page' => 'ordershipping',
								'filter_arr' => $filter_arr,
								'item_count' => $account_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "ordershipping";
		$_data['item_count'] = $item_count;
		// $_data['lock_in_periods'] = $this->model_plans->getAllLockInPeriods();
		$_data['order_statuses'] = $this->model_accountmanagement->getOrderStatuses();
		$_data['order_types'] = $this->model_accountmanagement->getOrderTypes();
		// $_data['account_categories'] = $this->model_accountmanagement->getAccountCategoriesByUserType($user_type);
		$_data['accounts'] = $accounts_arr;
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$_data['content'] = $this->load->view('admin/view_ordershipping', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}

	public function editorder($account_id = null, $order_number = null)
	{		
		if ($account_id==null) { redirect(site_url('admin/accountmanagment')); } // account_id?
		if ($order_number==null) { redirect(site_url('admin/accountmanagment')); } // account_id?
		
		$this->load->model('model_ordermanagement');
		$this->load->model('model_accountmanagement');
		$this->load->model('model_couriers');
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "ordershipping";
		$_data['account_id'] = $account_id;
		$_data['order_number'] = $order_number;
		$_data['couriers'] = $this->model_couriers->getAllCouriers();
		$_data['account_details'] = $this->model_accountmanagement->getAccountDetails($account_id, $order_number);
		$_data['order_details'] = $this->model_ordermanagement->getOrderDetails($account_id, $order_number);
		$_data['content'] = $this->load->view('admin/view_ordershipping_editorder', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function update_order()
	{
		$d = (object) $this->input->post();

		$data = array (
				'tracking_id'		=> $d->tracking_id,
				'shipping_courier'	=> $d->shipping_courier,
				'IMEI'				=> $d->imei,
				'sim_serial'		=> $d->sim_serial
			);		
		
		$this->load->model('model_accountmanagement');
		$this->load->model('model_ordermanagement');
		$this->model_ordermanagement->updateShippingDetails($d->account_id, $d->order_number, $data);

		$filter_arr = array();
		$pagination_limit = 5;
		$current_page = 1;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;

		$accounts_arr = $this->model_ordermanagement->getOrders($user_type,
																'estate_orders.date_ordered', 
																'ASC', 
																$limit, 
																$pagination_limit, 
																$filter_arr);
		$account_total_count = $accounts_arr['total_count'];
		unset($accounts_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['accounts'] == $account_total_count;
		
		$_pagination = array(	'page' => 'ordershipping',
								'filter_arr' => $filter_arr,
								'item_count' => $account_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "ordershipping";
		$_data['item_count'] = $item_count;
		// $_data['plans'] = $this->model_plans->getAllPlans();
		// $_data['lock_in_periods'] = $this->model_plans->getAllLockInPeriods();
		$_data['order_statuses'] = $this->model_accountmanagement->getOrderStatuses();
		$_data['order_types'] = $this->model_accountmanagement->getOrderTypes();
		// $_data['account_categories'] = $this->model_accountmanagement->getAccountCategoriesByUserType($user_type);
		$_data['accounts'] = $accounts_arr;
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$_data['content'] = $this->load->view('admin/view_ordershipping', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}

	public function process_items()
	{
		$this->load->model('model_plans');
		$this->load->model('model_accountmanagement');
		$this->load->model('model_ordermanagement');
		
		$user_type = $this->session->userdata('user_type');	
		
		$filter_arr = array();
/*		if ($this->input->post('filter')) {
			if( $this->input->post('order_reference_number') && $this->input->post('order_reference_number') != '' ){
				$filter_arr['order_number'] = $this->input->post('order_reference_number');
			}
			if( $this->input->post('order_type') && $this->input->post('order_type') != '' ){
				$filter_arr['order_type'] = $this->input->post('order_type');
			}
			if( $this->input->post('date_ordered') && $this->input->post('date_ordered') != '' ){
				$filter_arr['date_ordered'] = $this->input->post('date_ordered');
			}
			if( $this->input->post('date_shipped') && $this->input->post('date_shipped') != '' ){
				$filter_arr['date_shipped'] = $this->input->post('date_shipped');
			}
			if( $this->input->post('order_status') && $this->input->post('order_status') != '' ){
				$filter_arr['order_status'] = $this->input->post('order_status');
			}
			if( $this->input->post('delivery_type') && $this->input->post('delivery_type') != '' ){
				$filter_arr['delivery_type'] = strtolower($this->input->post('delivery_type'));
			}
		}*/
		
		$pagination_limit = 5;
		$current_page = $this->input->post('current_page');
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$accounts_arr = $this->model_ordermanagement->getOrders($user_type,
																'estate_orders.date_ordered', 
																'ASC', 
																$limit, 
																$pagination_limit, 
																$filter_arr);
		$account_total_count = $accounts_arr['total_count'];
		unset($accounts_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['accounts'] == $account_total_count;
		
		$_pagination = array(	'page' => 'ordershipping',
								'filter_arr' => $filter_arr,
								'item_count' => $account_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "ordershipping";
		$_data['item_count'] = $item_count;
		// $_data['plans'] = $this->model_plans->getAllPlans();
		// $_data['lock_in_periods'] = $this->model_plans->getAllLockInPeriods();
		$_data['order_statuses'] = $this->model_accountmanagement->getOrderStatuses();
		$_data['order_types'] = $this->model_accountmanagement->getOrderTypes();
		// $_data['account_categories'] = $this->model_accountmanagement->getAccountCategoriesByUserType($user_type);
		$_data['accounts'] = $accounts_arr;
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$this->load->view('admin/view_ordershipping', $_data);
		return;
	}
}

?>