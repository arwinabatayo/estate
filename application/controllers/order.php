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

}
?>
