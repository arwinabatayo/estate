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

    }

    public function index()
    {
      //  $this->load->view('cart/index');
    }
    
    public function get_cart()
    {
        $cart_contents = $this->cart->contents();
        
        print_r($cart_contents);
        
        //echo json_encode($cart_contents);
    }
    
    public function update_cart($key, $qty)
    {
        $account_id = "1";
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
        $account_id = "1212";
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
		echo var_dump($v);
		
	}
	
	
    function addtocart() {
		$this->load->model('estate/products_model');
		
		$d = (object) $this->input->post();
		$account_id = 1; //TODO get subs id
		$options = array();
		$title  = '';
		$amount = '0.00';
		$plan_pv = 0;
		$pvcashout = 0;
		$comboqty = 0;
		$pv = 0;
		$qty = 1;
			 
		$in_coexist['coexist'] = TRUE;
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
			 		echo $this->cart_model->delete_cart($account_id, TRUE);	exit;
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
				 
				// remove existing gadget
				$this->cart_model->remove_gadget_or_plan("gadget");
			 }
			
			 //TODO:
			 //peso value, ultima rules
			 if( $d->product_type == 'plan' ) {
				 
				 $plan_pv = $this->products_model->get_plan_pv($d->plan);
				 $amount = number_format($this->products_model->get_gadget_cash_out($d->plan, $d->device),2);
				 
				 
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
			 }
			 if( $d->product_type == 'boosters' ) {
			 	$qty = $this->checkProductIfExist($d->product_type, "qty", $d->product_id, "add");
			 		
			 	foreach($cart_contents as $k => $v) {
					if(trim($cart_contents[$k]['product_type']) == 'plan') {
 						$plan_pv = intval($cart_contents[$k]['this_pv_value']);
 					 }
				}

			 	$out['status'] = 'success';
			 	$in_coexist = $this->products_model->get_coexist($d->product_id);
// 			 	print_r($in_coexist);
			 	$amount = number_format($qty * $amount,2);
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
			);
		
			$out['status'] = 'success';
			
			/* cart */
			if($in_coexist['coexist'] == TRUE) {
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
				
				$out['status'] = 'coexist';
				$out['product_name'] = $in_coexist['product_name'];
				$out['rowid'] = $in_coexist['rowid'];
				$out['product_id'] = $in_coexist['product_id'];
				$out['coex_product_type'] = $in_coexist['coex_product_type'];

			}
		}
    
		echo json_encode($out);
	}
	// Robert Hughes
	// Delete function for Combos&Boosters Qty
	public function update_qty_of_cart() {
		$this->load->model('estate/products_model');
		
		$d = (object) $this->input->post();
		$account_id = 1; //TODO get subs id
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
				
				foreach($cart_contents as $k => $v) {
					if(trim($cart_contents[$k]['product_type']) == 'plan') {
						$plan_pv = intval($cart_contents[$k]['this_pv_value']);
					}
				}
				
				$this_pv_value = $d->combopv;
				
				$remainingPV = $plan_pv + ($comboqty * $this_pv_value);
				
				if($remainingPV < 0) { // Negative
					$amount = abs($remainingPV - $this_pv_value); // to be added to cashout
					$remainingpv = 0;
				} else {
					$remainingpv = abs($remainingPV);
					$amount = "0.00";
				}
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
			$out['total']  = $this->cart_model->total(true);
		
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
		$account_id = 1; //TODO get subs id
		
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
	
	function get_order_config(){
		return $this->session->userdata('order_config');
	}

	function get_gadget_oncart() {
		$items = $this->_parse_contents();
		var_dump($items);
		foreach($items as $item){
			if ($item['product_type'] == 'gadget') {
				$this->_data = array(
						'name' 	=> $item['name'],
						'price'	=> $item['price_formatted']
					);
			}
		}
	}
    
}
