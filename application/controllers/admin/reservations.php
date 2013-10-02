<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reservations extends MY_Controller 
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
			// allow access
		}else{
			// is ecommerce users
			// dont allow access
			redirect(site_url('admin/accountmanagement')); 
		}
	}
	
	public function index()
	{
		$this->load->model('model_reservation');
		
		$user_type = $this->session->userdata('user_type');	
		
		$filter_arr = array();
/*		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}*/
	
		// retrieve accessories
		$pagination_limit = 5;
		$current_page = 1;

		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$order_by = array(
				'field'		=> 'reserved_datetime',
				'direction'	=> 'desc'
			);
		$reservation_arr = $this->model_reservation->getAllReservations($limit, $pagination_limit, $order_by);
		// var_dump($reservation_arr);exit;
		$reservation_total_count = $reservation_arr['total_count'];
		unset($reservation_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['reservations'] == $reservation_total_count;
		
		// populate response
		/*$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		*/
		$_pagination = array(	'page' => 'reservations',
								'filter_arr' => $filter_arr,
								'item_count' => $reservation_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "reservations";
		$_data['item_count'] = $item_count;
		$_data['reservations'] = $reservation_arr;
		// $_data['legend'] = $this->load->view('admin/view_accessories_legend', NULL, TRUE);
		// $_data['filter'] = $this->load->view('admin/view_accessories_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$_data['content'] = $this->load->view('admin/view_reservations', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function process_items()
	{
		$this->load->model('model_reservation');
	
		$user_type = $this->session->userdata('user_type');	
		
		$filter_arr = array();
/*		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}*/
	
		// retrieve accessories
		$pagination_limit = 5;
		$current_page = $this->input->post('current_page');
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$order_by = array(
				'field'		=> 'reserved_datetime',
				'direction'	=> 'desc'
			);
		$reservation_arr = $this->model_reservation->getAllReservations($limit, $pagination_limit, $order_by);

		$reservation_total_count = $reservation_arr['total_count'];
		unset($reservation_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['reservations'] == $reservation_total_count;
		
		// populate response
		/*$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);*/
		$_pagination = array(	'page' => 'reservations',
								'filter_arr' => $filter_arr,
								'item_count' => $reservation_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "reservations";
		$_data['item_count'] = $item_count;
		$_data['reservations'] = $reservation_arr;
		// $_data['legend'] = $this->load->view('admin/view_accessories_legend', NULL, TRUE);
		// $_data['filter'] = $this->load->view('admin/view_accessories_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$this->load->view('admin/view_reservations', $_data);
		return;
	}

	function updateReserveStatus()
	{	 
		// get variables from view
		$d = (object) $this->input->post();
 		// echo $d->reserve_id; exit;
		// update status and get current one
		$this->load->model('model_reservation');
		$informed_flag = $this->model_reservation->updateReservationById($d->reserve_id);
		// convert status to word
		if ($informed_flag == 'y') { $informed_flag = "Mark as not informed"; } else { $informed_flag = "Mark as informed"; }
		// send data to view
		echo json_encode(array('status' => 'success', 'curr_status' => $informed_flag));
	}
}
?>