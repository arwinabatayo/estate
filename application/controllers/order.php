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

		$this->_data->delivery_info = $this->getdeliveryinfo($order['tracking_id']);


		$this->load->view($this->_data->tpl_view, $this->_data);
	}

	// cart to order - mark
	function save_order(){

		$cart_contents = $this->cart->contents();
		$account_id    = 1; //TODO get subs id from
		$order_config  = $this->cart_model->get_order_config();

		$d = array();

		if( count($cart_contents) > 0 ){

			$d['account_id']   = $account_id;
			$d['status']       = 2;
			$d['subtotal']     = $this->cart->total();
			$d['total']        = $this->cart_model->total();
			$d['date_ordered'] = date('Y-m-d h:i:s');
			$d['order_type']   = 1; //renew,newline,reset: todo get the actual id
			$d['peso_value']   = ($this->cart_model->total_pv > 0 ) ? $this->cart_model->total_pv : 0; // todo
			$d['shipping_address_id']   = @$order_config['shipping_address_id'];  //if empty set the billing id
			//$d['shipping_address_id']   = @$order_config['billing_address_id']; <<- TODO - get default billing id
			$d['delivery_type']   = @$order_config['delivery_mode'];
			$d['items']           = $cart_contents;

			$order_number = $this->order_model->save_order($d);

			if($order_number){

				//destroy cart here
				$this->cart->destroy();

				return $order_number;

			}else{

				return FALSE;

			}


		}else{

			return FALSE;
		}



	}

	public function save_address()
	{
		$post = (object) $this->input->post();
		$account_id = 1; //TODO get subs id from

		//* * * * TODO - validate $post here

		$out = array(
			'status' => 'failed',
			'msg'    => 'Some error occured or the system is busy. Please try again later'
		);

		if($_POST){

			$data = array(
				'account_id'   => $account_id,
				'address_type' => 'shipping',
				'unit' 	       => $post->unit,
				'street' 	   => $post->street,
				'subdivision'  => '',
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

				$d['order_item_details'] = $this->orderitem_model->get_orderitems_by_orderid($order_details['id']);
				
				//$order_details = get_order_by_refnum();
			// TODO : integrate the receipt to be done by sir mark
			break;
		}

		echo json_encode($d); exit;
	}

	private function getdeliveryinfo($tracking_id)
	{
		// TODO use track id to get delivery info
		$_shp_date = "09/18/2013";
		$_est_delivery_date = "09/20/2013";

		$data = array(
			'tracking_id'		=> $tracking_id,
			'short_summary'		=> 'On Schedule',
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
