<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller/Handler for:
 *  -- showing status of order
 *
 ***/

class Order extends MY_Controller
{
	var $_data = null;

	function __construct()
	{
		parent::__construct();

        //global data
		$this->_data->tpl_view    = $this->config->item('globe_estate_template_path');
		$this->_data->assets_path = $assets_path = $this->config->item('globe_estate_assets');
		$this->_data->assets_url  = base_url().$assets_path;
		$this->_data->current_method      = $this->router->method;
		$this->_data->current_controller  = strtolower( $this->router->class );
		$this->_data->show_breadcrumbs    =  true;
		$this->_data->current_step        =  5;
		$this->_data->page                = 'order';
		$this->_data->page_title          = 'Status';

		$this->load->model('estate/orderitem_model');
		$this->load->model('estate/order_model');
		
		//global object of subcriber info, init from sms verification -mark
		$this->_data->account_info  = $account_info = (object) $this->session->userdata('subscriber_info');
		
		$this->_data->account_id = 2147483647; // to make it safe =)
		//TODO - add restriction or redirect if account info object is empty -mark
		if($account_info->account_id){
			$this->_data->current_plan    = $this->accounts_model->get_account_current_plan($account_info->account_id);
			$this->_data->account_id      = $account_info->account_id;
		}
		
	}

	public function index()
	{
		// get refnum / ordernum from url
		$refnum = $this->input->get('refnum', TRUE);

		// send order detals to view
		$order = $this->order_model->get_order_by_refnum($refnum);
		$this->_data->order = $order;

		// send order item details to view
		$this->_data->order_items = $this->orderitem_model->get_orderitems_by_orderid($refnum);

		// get gadget data
		$gadget_item = $this->orderitem_model->get_orderitem_by_type($refnum, 'gadget');
		$this->_data->gadget_item = unserialize($gadget_item['product_info']);

		$plan_item = $this->orderitem_model->get_orderitem_by_type($refnum, 'plan');
		$this->_data->plan_item = unserialize($plan_item['product_info']);

		//TODO - move to session after authentication

		$this->_data->account = $this->accounts_model->get_account_info_by_id('09173858958', false);

		$this->_data->delivery_info = $this->getdeliveryinfo($order['tracking_id'], $order['shipping_courier']);


		$this->load->view($this->_data->tpl_view, $this->_data);
	}

	// cart to order - mark
	function save_order(){

		$cart_contents = $this->cart->contents();
		$account_id    = $this->_data->account_id; //TODO get subs id from
		$order_config  = $this->cart_model->get_order_config();
		$order_type = ($this->input->post('order_type')) ? $this->input->post('order_type') : 1;
		$status = ($this->input->post('status')) ? $this->input->post('status') : 1;
		$industry_id = ($this->input->post('industry_id')) ? $this->input->post('industry_id') : "";
		$total_line = ($this->input->post('total_line')) ? $this->input->post('total_line') : "";

		$d = array();

		//if( count($cart_contents) > 0 ){

			$d['account_id']   = $account_id;
			$d['status']       = $status;
			$d['subtotal']     = $this->cart->total();
			$d['total']        = $this->cart_model->total();
			$d['date_ordered'] = date('Y-m-d h:i:s');
			$d['order_type']   = $order_type; //renew,newline,reset: todo get the actual id
			$d['peso_value']   = ($this->cart_model->total_pv > 0 ) ? $this->cart_model->total_pv : 0; // todo
			$d['shipping_address_id']   = @$order_config['shipping_address_id'];  //if empty set the billing id
			//$d['shipping_address_id']   = @$order_config['billing_address_id']; <<- TODO - get default billing id
			$d['delivery_type']   = @$order_config['delivery_mode'];
			$d['items']           = $cart_contents;
			$d['industry_id'] = $industry_id;
			$d['total_line'] = $total_line;

			$order_number = $this->order_model->save_order($d);

			

			if($order_number){

				//destroy cart here
				$this->cart->destroy();

				return $order_number;

			}else{

				return FALSE;

			}


		//}else{

			//return FALSE;
		//}



	}

	public function save_address()
	{
		$post = (object) $this->input->post();
		$account_id = $this->_data->account_id; //TODO get subs id from

		//* * * * TODO - validate $post here

		$out = array(
			'status' => 'failed',
			'msg'    => 'Some error occured or the system is busy. Please try again later'
		);
		
		$is_valid = $this->validate_address_info($post);
		
		if($_POST && $is_valid['result']==true){

			$data = array(
				'account_id'   => $account_id,
				'address_type' => 'shipping',
				'unit' 	       => $post->unit,
				'street' 	   => $post->street,
				'subdivision'  => $post->barangay,
				'barangay' 	   => $post->barangay,
				'municipality' => $post->town,
				'city' 	       => $post->city,
				'postal_code'  => $post->postal,
			);

			$insert_id = $this->accounts_model->save_account_address($data);

			if( $insert_id ){
				//store shipping_address_id
				$this->cart_model->set_order_config( array('shipping_address_id'=>$insert_id) );
				$this->_save_contact_info($post);
				$out['status'] = 'success';

			}else{
				$out['msg'] = $result;
			}

		}else{
			
			$out['msg'] = $is_valid['msg'];
		
		}

		echo json_encode($out);


	}

	private function _save_contact_info($post)
	{
		$account_id = 1; //TODO get subs id from

		//* * * * TODO - validate $post here

		$data = array(
			'account_id'      => $account_id,
			'area_code'       => $post->access_code,
			'mobile_number'   => $post->mobile_number,
			'landline'        => $post->landline,
			'network_carrier' => $post->network_carrier,

		);

		return $this->accounts_model->save_personal_info($data);
	}

	//hardcode validation. TODO - use ci form validation - mark
	function validate_address_info($post){

		$isValid = true;
		$msg = '';
		$post = (array)$post;
		
		if(empty($post['unit'])){
			$msg .= 'Room / Floor / House Number field is required.<br />';
			$isValid = false;
		}
		if(empty($post['street'])){
			$msg .= 'Building Name / Street field is required.<br />';
			$isValid = false;
		}
		if(empty($post['barangay'])){
			$msg .= 'Subdivision / Barangay field is required.<br />';
			$isValid = false;
		}
		if(empty($post['town'])){
			$msg .= 'Municipality/Town field is required.<br />';
			$isValid = false;
		}
		if(empty($post['city'])){
			$msg .= 'City/Province field is required.<br />';
			$isValid = false;
		}
		if(empty($post['postal'])){
			$msg .= 'Postal Code/Zip Code field is required.<br />';
			$isValid = false;
		}
		
		return array('msg'=>$msg,'result'=>$isValid);
		
	}
	
	function save_payment_shipping_config(){

		$cfg = $this->input->post();

		$this->cart_model->set_order_config( $cfg );

		echo json_encode( array('status'=>'success') );

	}

	function get_order_config(){
		print_r( $this->session->userdata('order_config') );
	}

	function test(){

		echo unserialize('a:13:{s:5:"rowid";s:32:"79c27193a308b7b5a2a5dc35d0eed389";s:2:"id";s:8:"gadget_1";s:3:"qty";s:1:"1";s:10:"combos_qty";i:0;s:5:"price";s:5:"12500";s:13:"this_pv_value";i:0;s:15:"price_formatted";s:13:"Php 12,500.00";s:4:"name";s:15:"Nokia Lumia 610";s:10:"product_id";s:1:"1";s:8:"discount";N;s:12:"product_type";s:6:"gadget";s:7:"options";a:2:{s:8:"capacity";s:2:"32";s:5:"color";s:5:"black";}s:8:"subtotal";i:12500;}');

	}

	function download_form()
	{
		$var = (object) $this->input->post();

		$this->load->helper('download');

		switch($var->form_type) {
			case 'msa' :
				$d['file_url'] = base_url() . "_assets/estate/msa-form.pdf";
			break;
			case 'qr' :
				$this->load->library('phpqrcode');
				$status_url = $_SERVER['HTTP_REFERER'];

        		$filename = $this->phpqrcode->getQrcodePng($status_url, 'status-url-qrcode' . md5($status_url) . '.png');
				$d['file_url'] = $filename;
			break;
			case 'receipt' :
				$d['order_details'] = $this->order_model->get_order_by_refnum($var->refnum);
				$d['order_item_details'] = $this->orderitem_model->get_orderitems_by_orderid($d['order_details']['id']);
				$d['account_details'] = $this->accounts_model->get_account_by_account_id($d['order_details']['account_id']);
				$d['billing_details'] = $this->accounts_model->get_account_address($d['order_details']['account_id']);
				$order_item_details_arr = array();
				
				//$d['order_item_details'] = json_decode($d['order_item_details']);
				
				for($ctr = 0; $ctr < count($d['order_item_details']); $ctr++){
					$order_item_details = (array)$d['order_item_details'][$ctr];
					
					//var_dump($d['order_item_details'][$ctr]);
					if($order_item_details['product_info']){
						$order_item_details['product_info'] = unserialize($order_item_details['product_info']);
					}
					
					array_push($order_item_details_arr, $order_item_details);
				}
				$d['new_order_item_details'] = $order_item_details_arr;
				//$order_details = get_order_by_refnum();
			// TODO : integrate the receipt to be done by sir mark
			break;
		}

		echo json_encode($d);
	}

	private function getdeliveryinfo($tracking_id, $courier)
	{
		// TODO : use track id to get delivery info
		// $courier = 'air21'
		// $delivery_info = $this->delivery_info($tracking_id, $courier);
		$delivery_info = array (

			);

		/*

	Array
	(
	    [airwaybill] => 1683929327938
	    [reference] => 1683929327938
	    [0] => Array
	        (
	            [post_date] => July 05, 2013
	            [post_time] => 09:42:00 PM
	            [post_location] => CARGOHAUS
	            [status] => Shipment returned on 07/05/2013 21:42.
	            [code] => RUD
	        )

	    [1] => Array
	        (
	            [post_date] => July 04, 2013
	            [post_time] => 11:28:00 AM
	            [post_location] => LUCENA CITY
	            [status] => Shipment is on Air 21 vehicle for delivery.
	            [code] => VAN
	        )

	    [2] => Array
	        (
	            [post_date] => July 04, 2013
	            [post_time] => 10:22:00 AM
	            [post_location] => LUCENA CITY
	            [status] => Shipment arrived at the Air 21 station on 07/04/2013 10:22.
	            [code] => SIP
	        )

	    [3] => Array
	        (
	            [post_date] => July 04, 2013
	            [post_time] => 12:52:00 AM
	            [post_location] => MERVILLE WAREHOUSE
	            [status] => Shipment departed our hub.
	            [code] => ROP
	        )

	    [4] => Array
	        (
	            [post_date] => July 03, 2013
	            [post_time] => 01:58:00 PM
	            [post_location] => MANILA BULK
	            [status] => Shipment departed the Air 21 station.
	            [code] => SOP
	        )

	    [5] => Array
	        (
	            [post_date] => July 03, 2013
	            [post_time] => 01:57:00 PM
	            [post_location] => MANILA BULK
	            [status] => Shipment has been manifested.
	            [code] => MDE
	        )

		)
		
		*/

		$_shp_date = "09/18/2013";
		$_est_delivery_date = "09/20/2013";

		$data = array(
			'tracking_id'		=> $tracking_id,
			// 'short_summary'		=> 'On Schedule',
			'delivery_status_id'=> 'In-transit',
			'delivery_dest'		=> 'Quezon City, Metro Manila',
			'shipment_date'		=> $_shp_date,
			'est_delivery_date'	=> $_est_delivery_date,
			'shipment_dest'		=> 'San Jose Village, Paseo de Sta. Rosa',
			'status'			=> 'success'
		);

		return $data;
	}
}
?>
