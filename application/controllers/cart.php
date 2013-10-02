<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cart extends CI_Controller {

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
		$this->_data->current_step        =  3;
		$this->_data->page_title          =  'Add-ons';
		
		//global object of subcriber info, init from sms verification -mark
		$this->_data->account_info  = $account_info = (object) $this->session->userdata('subscriber_info');
		
		$this->_data->account_id = 2147483647; // to make it safe =)
		//TODO - add restriction or redirect if account info object is empty -mark
		if($account_info->account_id){
			$this->_data->account_id      = $account_info->account_id;
		}
		
    }

    public function index()
    {
      //  $this->load->view('cart/index');
      
      print_r($this->_data->account_info);
    }

    public function get_cart()
    {
        $cart_contents = $this->cart->contents();

        //unset($cart_contents['df09e86c48f8745446e0f0c224b64bbf']);
        print_r($cart_contents);


        //echo json_encode($cart_contents);
    }

    public function update_cart($key, $qty)
    {
        $account_id = $this->_data->account_id;
        //$key = "96e59dd45c5cff38ba94e169202ccd41";

        /* cart */
        $_data = array(
            'rowid' => $key,
            'qty'   => $qty
        );
        $data['status'] = $this->cart->update($_data);

        /* db */
        $cart_contents = $this->cart->contents();

        foreach($cart_contents as $k=> $v){
           if($k == $key) {
               foreach($_data as $kk => $vv) {
                 $cart_contents[$k][$kk] = $vv;
               }
           }
        }

       	$info = $this->_parse_contents();

        $this->cart_model->update_cart_info($account_id, $info);
        echo json_encode($data);
    }
   

    public function delete_cart()
    {
        $account_id = $this->_data->account_id;
        $key = "5eacd98e0995bcb12ed069a936f16eec";

        /* cart */
        $item_exist = FALSE;
        $cart_contents = $this->cart->contents();

        if(!empty($cart_contents)) {
            foreach($cart_contents as $k=>$v) {
            if($k == $key)
                $item_exist = TRUE;
                unset($cart_contents[$key]);
            }
        }
        $this->cart->destroy();
        $data['status'] = $this->cart->insert($cart_contents);

        /* db */
        if(count($cart_contents) == 0 && $item_exist == TRUE) {
            $this->cart_model->delete_cart($account_id, TRUE);
        } else {
            $info = $this->_parse_contents();
            $this->cart_model->insert_previous_info($account_id, $info);
        }
       echo json_encode($data);
    }

    public function destroy()
    {
        $account_id = 1;

        $this->cart->destroy();
        $this->cart_model->delete_cart($account_id, TRUE);
        echo json_encode(array('status'=>'true'));
    }

    private function _parse_contents()
    {
        $cart_contents = $this->cart->contents();
        $info = '';
        foreach($cart_contents as $kkk=>$vvv) {
           unset($vvv['subtotal']);
           unset($vvv['rowid']);
           $info[] = $vvv;
        }
        return $info;
    }

    public function view_cart_summary()
    {
        $this->_data->cart_contents = $this->cart->contents();

        $this->_data->page = 'summary';

        $this->load->view($this->_data->tpl_view, $this->_data);

    }

    function test(){

		//$d=array('alpha'=>'','beta'=>'2','charlie'=>'8');

	//	$o = $this->set_order_config($d);
		//$o = $this->get_order_config();
		//print_r($o);
		//$v = $this->cart->has_options('dfd10bb28b3de6ed50c48294da85c8b2');
		$v = $this->cart_model->remove_gadget();
		//echo var_dump($v);

	}


    function addtocart() {
		$this->load->model('estate/products_model');

		$d = (object) $this->input->post();

		$account_id = $this->_data->account_id; 
		$options = array();
		$title  = '';
		$amount = '0.00';
		$plan_pv = 0;
		$pvcashout = 0;
		$comboqty = 0;
		$pv = 0;
		$qty = 1;
		$package_plan_combos = '';

		$in_coexist['coexist'] = TRUE;
		$boosterInCart = FALSE;
		$cart_contents = $this->cart->contents();
		$out = array(
			'status' => 'failed',
			'msg'    => 'Some error occured or the system is busy. Please try again later'
		);

		if( $d->product_id ) {
			 $_fields = $this->products_model->get_product_fields($d->product_type,$d->product_id);


			 $title  = $_fields['title'];
			 $amount = $_fields['amount'];

			 // robert :: replace cart item
			 if($d->tag == "replace_cart_item") {

			 	foreach($cart_contents as $k=>$v) {
			 		unset($cart_contents[$d->remove_keyid]);
			 	}
			 	$this->cart->destroy();

			 	if(!$is_gadget){ //flashout all data if you delete the gadget
			 		$this->cart->insert($cart_contents);
			 	}

			 	/* db */
			 	if(count($cart_contents) == 0 && $item_exist == TRUE) {

			 		if( !$this->cart_model->delete_cart($account_id, TRUE) ) {
			 			$out = array(
			 					'status' => 'failed',
			 					'msg'    => 'Some error occured or the system is busy. Please try again later'
			 			);
			 		}

			 	} else {
			 		$info = $this->_parse_contents();
			 		$this->cart_model->insert_previous_info($account_id, $info);
			 	}
			 }


			 if( $d->product_type == 'gadget' ){

				//TODO:
				$options=array(
					'capacity' => $d->gadget_capacity,
					'color'    => $d->gadget_color
				);
				
				$d->product_id = $_fields['id']; 
				
				$amount = $this->home_model->getGadgetAmount($d->product_id,$d->gadget_color,$d->gadget_capacity); // get from gadget attribute table
				
				// remove existing gadget
				$this->cart_model->remove_gadget_or_plan("gadget");
			 }

			 //TODO:
			 //peso value, ultima rules
			 if( $d->product_type == 'plan' ) {

				$plan_pv = $this->products_model->get_plan_pv($d->plan);
// 				 $amount = number_format($this->products_model->get_gadget_cash_out($d->plan, $d->device),2);
				if($d->plan_cashout == 0) {
					$amount = "0.00";
				} else {
				 	$amount = $d->plan_cashout;
				}
				 // remove existing plan
				 $this->cart_model->remove_gadget_or_plan("plan");
				 $out['plan_pv'] = $cart_input['plan_pv'] = $plan_pv;


				 $this_pv_value = $plan_pv;
			 }

			 if( $d->product_type == 'combos' ) {
			 	$comboqty = $this->checkProductIfExist($d->product_type, "combos_qty", $d->product_id, "add");

			 	foreach($cart_contents as $k => $v) {
					if(trim($cart_contents[$k]['product_type']) == 'plan') {
 						$plan_pv = intval($cart_contents[$k]['this_pv_value']);
 					 }
				}

			 	$out['status'] = 'success';
			 	$in_coexist = $this->products_model->get_coexist($d->product_id);


			 	$out['combopv'] = $d->combopv;
			 	$out['combo_qty'] =  $comboqty;
			 	$this_pv_value = $d->combopv;


			 	// Total PV

			 	$remainingPV = $plan_pv - ($comboqty * $this_pv_value);

			 	if($remainingPV < 0) { // Negative
			 		$amount = abs($remainingPV); // to be added to cashout
			 		$remainingpv = 0;
			 	} else {
			 		$remainingpv = abs($remainingPV);
			 		$amount = "0.00";
			 	}
// 			 	print_r($in_coexist);
			 }
			 
			 if( $d->product_type == 'boosters' ) {
			 	$qty = $this->checkProductIfExist($d->product_type, "qty", $d->product_id, "add");

			 	foreach($cart_contents as $k => $v) {
					if(trim($cart_contents[$k]['product_type']) == 'plan') {
 						$plan_pv = intval($cart_contents[$k]['this_pv_value']);
 					 }
				}
				foreach($cart_contents as $k => $v) {
					if(trim($cart_contents[$k]['product_type']) == 'boosters') {
						if($cart_contents[$k]['product_id'] == $d->product_id) { // already exist :: Do not add
							$boosterInCart = TRUE;
						}
					}
				}
			 	$out['status'] = 'success';
			 	$in_coexist = $this->products_model->get_coexist($d->product_id);
			 	
			 	$amount = number_format($qty * $amount,2);
			 	
			 }

			 if( $d->product_type == 'package_plan' ) {

				 $plan_pv = $this->products_model->get_package_plan_pv($d->plan);
				 $amount = number_format($this->get_package_plan_gadget_amount($d->plan, $d->device),2);
				 echo $amount;

				 // check if package plan amount is still within credit limit
				 // get user credit limit
				 $this->load->model('estate/accounts_model');

				 $package_plan_combos = $this->get_package_plan_combos($d->plan);

				 if ($plan_pv > $this->_data->account_info->credit_limit) {
				 	// show popup info that plan exceeds limit
				 	$credit_exceeded = true;
				 } else {
					 // remove existing plan
					 $this->cart_model->remove_gadget_or_plan("package_plan");
					 $out['package_plan_pv'] = $cart_input['package_plan_pv'] = $plan_pv;

					 $this_pv_value = $plan_pv;
				}
			 }

			 if( $d->product_type == 'prepaid_kit' ) {

				 $plan_pv = $this->products_model->get_package_plan_pv($d->plan);
				 //$amount = number_format($this->get_package_plan_gadget_amount($d->plan, $d->device),2);

				 //echo $amount; exit;
				 // remove existing plan
				 $this->cart_model->remove_gadget_or_plan("package_plan");
				 $out['package_plan_pv'] = $cart_input['package_plan_pv'] = $plan_pv;


				 $this_pv_value = $plan_pv;
			 }
						
			
			$cart_input = array(
				'id'              => $d->product_type.'_'.$d->product_id,
				'qty'             => $qty,
				'combos_qty'	  => $comboqty, // robert
				'price'           => $amount,
				'this_pv_value'	  => intval($this_pv_value), // robert
				'price_formatted' => 'Php '.number_format($amount,2),
				'name'            => $title,
				'product_id'      => $d->product_id,
				'discount'        => $d->product_discount,
				'product_type'    => $d->product_type,
				'options'         => $options,
				'package_plan_combos'	=> $package_plan_combos,
			);

			// if kit type is prepaid, only retain gadget
			$out['status'] = 'success';
			// send a different flag when credit limit is exceeded
			if ($credit_exceeded) {
				$out['status'] = 'exceeds_limit';
				$out['msg'] = 'credit_exceeded ';
			}

			
			/* cart */
			if($in_coexist['coexist'] == "no") { // not in cart
				//print_r($cart_input); exit;
				if($boosterInCart == false) {
					$out['rowid']  = $rowid = $this->cart->insert($cart_input);
					$out['total']  = $this->cart_model->total(true);
	
			       	$out = array_merge($cart_input,$out);
	
			       	/* db */
			       	if($rowid){
						$this->_data->cartItem  = $info = $this->_parse_contents();
						$this->cart_model->insert_previous_info($account_id, $info);
				   	} else {
						$out['status'] = 'failed';
					}
	
					$out['total_remaining_pv'] = $this->cart_model->remaining_pv(false);
				} else {
					$out['msg'] = "duplicateentry";
				}

			} else {

				$out['status'] = 'coexist';
				$out['product_name'] = $in_coexist['product_name'];
				$out['rowid'] = $in_coexist['rowid'];
				$out['product_id'] = $in_coexist['product_id'];
				$out['coex_product_type'] = $in_coexist['coex_product_type'];

			}
			
			
			
			
		}else{
			$out['msg'] = 'Product not found.';
		}

		echo json_encode($out);
	}
	// Robert Hughes
	// Delete function for Combos&Boosters Qty
	public function update_qty_of_cart() {
		$this->load->model('estate/products_model');

		$d = (object) $this->input->post();
		$account_id = $this->_data->account_id; 
		$options = array();
		$title  = '';
		$amount = 0.00;
		$plan_pv = 0;
		$pvcashout = 0;
		$pv = 0;
		$qty = 1;
		$remainingpv = 0;
		$comboqty = 0;

		$out = array(
				'status' => 'failed',
				'msg'    => 'Some error occured or the system is busy. Please try again later'
		);

		if( $d->product_id ){

			$_fields = $this->products_model->get_product_fields($d->product_type,$d->product_id);

			$title  = $_fields['title'];
			$amount = $_fields['amount'];

			if( $d->product_type == 'combos' ) {
				$out['is_display'] = "yes";

				$comboqty = $this->checkProductIfExist($d->product_type, "combos_qty", $d->product_id, "minus");

// 				foreach($cart_contents as $k => $v) {
// 					if(trim($cart_contents[$k]['product_type']) == 'plan') {
// 						$plan_pv = intval($cart_contents[$k]['this_pv_value']);
// 					}
// 				}
				$plan_pv = $d->plan_pv;
				$this_pv_value = $d->product_pv;

				$thisTotalPV = $comboqty * $this_pv_value;
				
				if($thisTotalPV > $plan_pv) {
					$remainingPV = $thisTotalPV - $plan_pv; 
					$amount = abs($remainingPV); // to be added to cashout
				} else {
					$remainingPV = $plan_pv - $thisTotalPV;
					$amount = "0.00";
				}
				
// 				echo $remainingPV = $plan_pv + ($comboqty * $this_pv_value);

// 				if($remainingPV < 0) { // Negative
// 					$amount = abs($remainingPV - $this_pv_value); // to be added to cashout
// 					$remainingpv = 0;
// 				} else {
// 					$remainingpv = abs($remainingPV);
// 					$amount = "0.00";
// 				}
			}

			if( $d->product_type == 'boosters' ) {
			$out['is_display'] = "yes";

				$comboqty = $this->checkProductIfExist($d->product_type, "qty", $d->product_id, "minus");

				foreach($cart_contents as $k => $v) {
					if(trim($cart_contents[$k]['product_type']) == 'plan') {
						$plan_pv = intval($cart_contents[$k]['this_pv_value']);
					}
				}

				$amount = number_format($qty * $amount,2);
			}


			$out['status'] = 'success';
			if($comboqty == 0) {
				$qty = 0;
				$deleteStatus = json_decode($this->delete('array'));
				$remainingpv = $this->cart_model->remaining_pv();
				$out['total_remaining_pv'] = $this->cart_model->remaining_pv(false);
			} else {
				$current_rem_pv = $this->cart_model->remaining_pv();
				$remainingpv = abs($current_rem_pv + $d->combopv);
			}

			$cart_input = array(
					'id'              => $d->product_type.'_'.$d->product_id,
					'qty'             => $qty,
					'combos_qty'	  => $comboqty, // robert
					'price'           => number_format($amount,2),
					'this_pv_value'	  => intval($this_pv_value), // robert
					'price_formatted' => 'Php '.number_format($amount,2),
					'name'            => $title,
					'product_id'      => $d->product_id,
					'discount'        => $d->product_discount,
					'product_type'    => $d->product_type,
					'options'         => $options,
			);


			/* cart */
			$out['status'] = 'success';
			$out['rowid']  = $rowid = $this->cart->insert($cart_input);
			$out['total']  = "P ".number_format($this->cart_model->total(false),2);

			$out = array_merge($cart_input,$out);

			/* db */
			if($rowid){
				$this->_data->cartItem  = $info = $this->_parse_contents();
				$this->cart_model->insert_previous_info($account_id, $info);

				$out['total_remaining_pv'] = $this->cart_model->remaining_pv(false);
			}else{
				$out['status'] = 'failed';
			}


		}

		echo json_encode($out);
	}
	// Robert
	// Get CashOut
	function createplan() {
		$this->load->model('estate/products_model');

		$d = (object) $this->input->post();

		$_fields = $this->products_model->get_gadget_cash_out($d->plan, $d->device);
		//$_fields = $this->products_model->get_gadget_cash_out(3, 1);
		//print_r($_fields);
		echo json_encode($_fields);
	}
	// Compute CashOut
	// Robert
	function compute_cashout() {
		$this->load->model('estate/products_model');

		$d = (object) $this->input->post();

		$_fields = $this->products_model->compute_cashout($d->current_cashout, $d->planpv, $d->combopv);

		echo json_encode($_fields);
	}
	/**
	 * Check cart contents, if $product_id exist
	 * then; add or minus the Quantity
	 * @param String $product_type
	 * @param Int $product_id
	 * @param String $addminus
	 *
	 * @return int Quantity
	 *
	 * @name Robert Hughes
	 */
	function checkProductIfExist($product_type, $qtyfield='qty', $product_id, $addminus="add") {
		$qty = 1;
		$cart_contents = $this->cart->contents();

		foreach($cart_contents as $k=>$v) {

			if(trim($cart_contents[$k]['product_type']) == trim($product_type)) {
				if( $cart_contents[$k]['product_id'] == $product_id) {
					if($addminus == "add") {
						$qty = $cart_contents[$k][$qtyfield] + 1;
					} else {
						$qty = $cart_contents[$k][$qtyfield] - 1;
					}
				}
			}
		}
		return $qty;
	}

    public function delete($returnType='json')
    {
		$d = (object) $this->input->post();
		$account_id = $this->_data->account_id;  

		$key = $d->keyid;

		$out = array(
			'status' => 'success'
		);

        /* cart */
        $item_exist = FALSE;
        $is_gadget = FALSE; // if this is a gadget then destroy all items!
        $cart_contents = $this->cart->contents();

        if($key){

	        if(!empty($cart_contents)) {

	            foreach($cart_contents as $k=>$v) {
					if($k == $key)
						$item_exist = TRUE;
						unset($cart_contents[$key]);
	            }

	            if( $v['product_type'] == 'gadget' ){
					$is_gadget = TRUE;
				}
	        }

	        $this->cart->destroy();

			if(!$is_gadget){ //flashout all data if you delete the gadget
				$this->cart->insert($cart_contents);
			}

	        /* db */
	        if(count($cart_contents) == 0 && $item_exist == TRUE) {

	            if( !$this->cart_model->delete_cart($account_id, TRUE) ){
					$out = array(
						'status' => 'failed',
						'msg'    => 'Some error occured or the system is busy. Please try again later'
					);
				}

	        } else {
	            $info = $this->_parse_contents();
	            $this->cart_model->insert_previous_info($account_id, $info);
	        }

			$out['total']  = $this->cart_model->total(true);

		}

		if($returnType == 'array') {
			return $out;
		} else {
			echo json_encode($out);
		}

    }



	// store any variable need for cart/order session
	// Order type, Selected Plan type, etc
	// @param array - keypair value ie. key=>value / config_name => value
	// @return array - merged data from previous config,
	//
	function set_order_config( $d=array() ){

		$_current_config = $this->get_order_config();

		if($_current_config){
			$new_config = array_merge($_current_config,$d);
		}else{
			$new_config = $d;
		}

		$this->session->set_userdata('order_config',$new_config);

		return $new_config;
	}

	function dump_order_config(){
		echo '<pre>';
		print_r( $this->session->userdata('order_config') );
		echo '</pre>';
	}
	function get_order_config(){
		return $this->session->userdata('order_config');
	}

	// retain gadget on cart
	function addprepaidtocart() {
		// get cart items
		$items = $this->cart->contents();
		$this->load->model('estate/cart_model');
		// unset session of non gadget
		foreach ($items as $item) {
			if ($item['product_type'] != 'gadget') {
				// echo $item['rowid'];
				unset($items[$item['rowid']]);
			}
		}
		$this->cart->destroy();
		$this->cart->insert($items);

		// update estate_cart table
		$info = $this->_parse_contents();

		$user_info = $this->session->userdata('subscriber_info');

		$account_id = $user_info['account_id'];
		$status = $this->cart_model->update_cart_info($account_id, $info);

		if ($status) {
			$data['status'] = 'success';
			$data['cart_url'] = '/estate/plan-summary';
		} else {
			$data['status'] = 'error';
			$data['msg'] = 'Error occurred.';
		}

		echo json_encode($data);
		// redirect customer to cart page
	}

	public function get_package_plan_gadget_amount($package_plan_id, $gadget_id){
		$this->load->model('estate/products_model');
		$amount = $this->products_model->get_gadget_cash_out_package_plan(intval($package_plan_id), intval($gadget_id));

		return $amount;
	}

	public	function get_package_plan_combos($plan_id)
	{
		$this->load->model('estate/packageplan_model');

		$package_plans_combos = $this->packageplan_model->get_package_plan_combos($plan_id, true);

		return $package_plans_combos;
	}

	// stores gadget specs on session in serialized form
	// stores reserved item (gadget) on database for non globe users
	function reserveitem()
	{
		$d = (object) $this->input->post();
		$this->load->model('model_reservation');

		// store gadget data on session in serialized form
		// if user is not yet going through the form
		if (!isset($d->from_reserve_form)) {
			// temporarily save on session
			// item data
			$item_data = array(
				'item_type'			=> $d->product_type,
				'product_capacity'	=> $d->gadget_capacity,
				'product_id'		=> $d->product_id,
				'product_name'		=> $d->product_name,
				'product_price'		=> $d->product_price		
			);

			if ($this->session->userdata('reserved_item_specs')) {
				$this->session->unset_userdata('reserved_item_specs');
			}

			$this->session->set_userdata('reserved_item_specs', json_encode($item_data));
			$data['status'] = 'success';
		} else {
			// get serialized spec from session
			$item_data = $this->session->userdata('reserved_item_specs');
			$error_msg = '';
			
			if ($d->first_name) {
				// check format of name
				if( !(preg_match("/^[a-zA-Z'-]/", $d->first_name)) ) {
					$error_msg .= 'First name is invalid.<br/>'; 
				}
			} else {
				$error_msg .= 'First name is required.<br/>'; 
			}

			if ($d->last_name) {
				// check format of name
				if( !(preg_match("/^[a-zA-Z'-]/", $d->last_name)) ) {
					$error_msg .= 'Last name is invalid.<br/>'; 
				}
			} else {
				$error_msg .= 'Last name is required.<br/>'; 
			}

			if ($d->middle_name) {
				// check format of name
				if( !(preg_match("/^[a-zA-Z'-]/", $d->middle_name)) ) {
					$error_msg .= 'Middle name is invalid.<br/>'; 
				}
			} else {
				$error_msg .= 'Middle name is required.<br/>'; 
			}

			if (!$d->sn_uid) {
				$error_msg .= 'Social network ID is required.<br/>'; 
			}

			if ($d->phone) {
				if( !(preg_match("/^[0-9]{11}$/", $d->phone))) {
					$error_msg .= 'Phone number is invalid.<br/>'; 
				}
			}

			if (!$d->phone && !$this->session->userdata('current_subscriber_mobileno')) {
				$error_msg .= 'Phone number is required.<br/>';
			}

			if (!$item_data) {
				$error_msg .= 'Item not found on session. Please try again later.<br/>';
			}

			if (!$error_msg) {

				// get user data from reserve form
				$reserve_data = array (
					'account_id'				=> '',
					'first_name'				=> $d->first_name,
					'last_name'					=> $d->last_name,
					'middle_name'				=> $d->middle_name,
					'email'						=> $d->email ? $d->email : $this->session->userdata('current_subscriber_email'),
					'msisdn'					=> $d->phone ? trim($d->phone) : $this->session->userdata('current_subscriber_mobileno'),
					// 'network_carrier'			=> $d->network_carrier,
					'social_network_sitename' 	=> $d->sns_id,
					'social_network_user_id'	=> $d->sn_uid,
					'reserved_item_specs' 		=> $item_data,
					'reserved_datetime'			=> date("Y-m-d H:i:s") // datetime now
				);
				
				// add to estate_reservation table
				$insert_id = $this->model_reservation->addReservation($reserve_data);

				if ($insert_id) {
					$data['status'] = 'success';
					$data['nxt_page'] = 'home';
				} else {
					$data['status'] = 'error';
					$data['msg'] = 'An error occurred. Please try again later.';
				}
			} else {
				$data['status'] = 'error';
				$data['msg'] = $error_msg;
			}
		}

		echo json_encode($data); exit;
		// TODO : get account details from reserve from for non globe and store on estate accounts
	}
	
	function check_credit_limit(){
		
		$amount = $this->cart_model->total(false);
		
		$data['status'] = 'false';
		
		$this->session->unset_userdata('credit_limit');
		
		if($amount > $this->_data->account_info->credit_limit){
			$this->session->set_userdata('credit_limit',true);
			$data['status'] = 'true';
		}
		
		echo json_encode($data); exit;
		
	}
	public function update_gadget_attrs() {
		$this->load->model('estate/products_model');
	
		$d = (object) $this->input->post();

		$account_id = $this->_data->account_id; 
		$options = array();
		$title  = '';
		$amount = '0.00';
		$plan_pv = 0;
		$pvcashout = 0;
		$comboqty = 0;
		$pv = 0;
		$qty = 1;
		$package_plan_combos = '';

		$in_coexist['coexist'] = TRUE;
		$boosterInCart = FALSE;
		$cart_contents = $this->cart->contents();
		$out = array(
			'status' => 'failed',
			'msg'    => 'Some error occured or the system is busy. Please try again later'
		);
	
		$_fields = $this->products_model->get_product_fields($d->product_type,$d->product_id);

		$title  = $_fields['title'];
		$amount = $_fields['amount'];
		//TODO:
		$options=array(
				'capacity' => $d->gadget_capacity,
				'color'    => $d->gadget_color
		);
		
		$d->product_id = $_fields['id'];
		
		$amount = $this->home_model->getGadgetAmount($d->product_id,$d->gadget_color,$d->gadget_capacity); // get from gadget attribute table
		
		// remove existing gadget
		$this->cart_model->remove_gadget_or_plan("gadget");
			
		$cart_input = array(
				'id'              => $d->product_type.'_'.$d->product_id,
				'qty'             => $qty,
				'price'           => $amount,
				'this_pv_value'	  => intval($this_pv_value), // robert
				'price_formatted' => 'Php '.number_format($amount,2),
				'name'            => $title,
				'product_id'      => $d->product_id,
				'discount'        => $d->product_discount,
				'product_type'    => $d->product_type,
				'options'         => $options,
		);
		
		// if kit type is prepaid, only retain gadget
		$out['status'] = 'success';
		// send a different flag when credit limit is exceeded
		if ($credit_exceeded) {
			$out['status'] = 'exceeds_limit';
			$out['msg'] = 'credit_exceeded ';
		}
		
		/* cart */
		$out['status'] = 'success';
		$out['rowid']  = $rowid = $this->cart->insert($cart_input);
		$out['total']  = "P ".number_format($this->cart_model->total(false),2);

		$out = array_merge($cart_input,$out);

		/* db */
		if($rowid){
			$this->_data->cartItem  = $info = $this->_parse_contents();
			$this->cart_model->insert_previous_info($account_id, $info);

			$out['total_remaining_pv'] = $this->cart_model->remaining_pv(false);
			
			if($d->tochange == "color") {
				$availableCapacity = $this->home_model->getCapacity($d->product_id, $d->gadget_color);
					
				$capacityCount = $availableCapacity['count'];
				unset($availableCapacity['count']);
				$x = 1;
				$sRet = '<span>Data Capacity</span>';
				foreach($availableCapacity as $capacities) {
					$selected = "";
					if($d->gadget_capacity == $capacities['dcid']) {
						$selected = " checked";
					}
					$sRet .= '<input id="'.strtolower(str_replace(" ", "",$capacities['dcname'])).'" type="radio" name="capacity"
								value="'.$capacities['dcid'].'"'.$selected.'>
						<label for="'.strtolower(str_replace(" ", "",$capacities['dcname'])).'">'.$capacities['dcname'].'</label>';
				}
				$out['out'] = $sRet;
			}
		}else{
			$out['status'] = 'failed';
		}
		
		
			
		echo json_encode($out);
	}
	public function changeAttrCapacitySideBar() {
		$sRet = "";
		$this->load->model('estate/home_model');
	
		$d = (object) $this->input->post();
	
		$availableCapacity = $this->home_model->getCapacity($d->device, $d->color);
			
		$capacityCount = $availableCapacity['count'];
		unset($availableCapacity['count']);
		$x = 1;
		$sRet = '<span>Data Capacity</span>';
		foreach($availableCapacity as $capacities) {
			$selected = "";
			if($x == 1) { $selected = ' checked="checked"'; }
			$sRet .= '<input id="'.strtolower(str_replace(" ", "",$capacities['dcname'])).'" type="radio" name="capacity"
							value="'.$capacities['dcid'].'"'.$selected.'>
					<label for="'.strtolower(str_replace(" ", "",$capacities['dcname'])).'">'.$capacities['dcname'].'</label>';
			$x++;
		}
		echo $sRet;
	}
}
