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
		$this->_data->order = $this->order_model->get_order_by_refnum($refnum);

		// send order item details to view
		$this->_data->order_items = $this->orderitem_model->get_orderitems_by_orderid($refnum);

		//TODO - move to session after authentication

		$this->_data->account = $this->accounts_model->get_account_info_by_id('09173858958', false);

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

}
?>
