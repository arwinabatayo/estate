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
		$this->load->model('estate/accounts_model');
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
			
			$result = $this->accounts_model->save_account_address($data);
			
			if( $result == TRUE ){
				
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

}
?>
