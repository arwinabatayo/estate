<?php
class Cart_model extends CI_Model
{
    var $tbl_name = 'estate_cart';
    var $shipping_fee = 250; //TODO: load it from model
    
    function __construct()
    {
            parent::__construct();
            
    }

    /**
     * Get cart Previous Information by Account id.
     *
     * @param  string  account_id(required) - account id or subscribers account number
     * @param  string  what (optional) - specify the fields needed
     * @return array
     */
    function get_account_previous_info_by_id($account_id = NULL, $what= "*")
    {
            if($account_id == NULL) return FALSE;

            $query = $this->db->select($what)
                              ->from($this->tbl_name)
                              ->where('account_id', $account_id)
                              ->get();
            $result = $query->row_array();
            $query->free_result();
            if(count($result) == 0) return FALSE;
            return $result;
    }

    /**
     * Insert Previous Information .
     *
     * @param  string  info(required) - account id or subscribers account number
     * @param  string  account_id (required) - specify the fields needed
     * @return array
     */
    function insert_previous_info($account_id = '', $info = array())
    {
        if(empty($info) || empty($account_id)) return FALSE;
        if(!is_array($info)) return FALSE;            

        $check_iexists = $this->_check($account_id, $info);

        if($check_iexists === FALSE) {
            $this->delete_cart($account_id);
            $this->db->set('previous_selected', json_encode($info))
                     ->set('account_id', $account_id)
                     ->insert($this->tbl_name);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Update Cart Information .
     *
     * @param  string  account_id (required) - account id or subscribers account number
     * @param  string  info(required) - specify the fields needed
     * @return array
     */
    function update_cart_info($account_id = '', $info = array())
    {
        if(empty($info) || empty($account_id)) return FALSE;
        if(!is_array($info)) return FALSE;            

        $this->db->set('previous_selected', json_encode($info))
                 ->where('account_id', $account_id)
                 ->update($this->tbl_name);
        return TRUE;
    }

    function _check($account_id, $info, $check_both = TRUE)
    {
        $query = $this->db->select('*')
                          ->from($this->tbl_name);

        if($check_both === TRUE) {
            $this->db->where('account_id', $account_id);
            $this->db->where('previous_selected', json_encode($info));
        } else {
            $this->db->where('account_id', $account_id);
        }
        $result = $this->db->get();

        $rowcount = $result->num_rows();
        if($rowcount == 0) return FALSE;
        return TRUE;
    }

    /**
     * Delete Cart Information .
     *
     * @param  string  account_id (required) - account id or subscribers account number
     * @param  boolean all(optional) - TRUE - force to delete all, FALSE - delete per item
     * @return array
     */
    function delete_cart($account_id, $all = FALSE)
    {
        if($all === FALSE) { 
            if($this->_check($account_id, NULL, FALSE) === FALSE) return false;
            $this->db->delete($this->tbl_name, array('account_id' => $account_id));
        } else {
            $this->db->delete($this->tbl_name, array('account_id' => $account_id));
        }
        return TRUE;
    }
    
    function parse_contents() 
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
    
    // @return string - gadget,addon,accesory,etc..
    function get_product_type($rowid='') 
    {
        $cart_contents = $this->cart->contents();
		if( array_key_exists($rowid,$cart_contents) ){
			return $cart_contents[$rowid]['product_type'];
		}else{
			return FALSE;
		}
    }  
    
    
    // we must only have 1 gadget on the cart
    // unset existing then insert new sku configuration
    
    function remove_gadget_or_plan($type="gadget")
    {
    
    	$account_id = 1; //TODO get subs id
    
    	$cart_contents = $this->cart->contents();
    
    	if(!empty($cart_contents)) {
    			
    		foreach($cart_contents as $k=>$v) {
    			if($type == "gadget") {
    				if( $cart_contents[$k]['product_type'] == 'gadget') {
    					$item_exist = TRUE;
    					unset($cart_contents[$k]);
    				}
    			} elseif ($type == "plan") {
    				if( $cart_contents[$k]['product_type'] == 'plan') {
    					$item_exist = TRUE;
    					unset($cart_contents[$k]);
    				}
    			} elseif ($type == "package_plan") { //jez added package plan
                    if( $cart_contents[$k]['product_type'] == 'package_plan') {
                        $item_exist = TRUE;
                        unset($cart_contents[$k]);
                    }
                }
    
    		}
    	}
    
    	$this->cart->destroy();
    
    	$this->cart->insert($cart_contents);
    
    	/* DB */
    	if(count($cart_contents) == 0 && $item_exist == TRUE) {
    
    		if( !$this->cart_model->delete_cart($account_id, TRUE) ){
    			die('db error : remove_gadget() ');
    			return FALSE;
    		}
    
    	} else {
    			
    		$info = array();
    		 
    		foreach($cart_contents as $kkk=>$vvv) {
    			unset($vvv['subtotal']);
    			unset($vvv['rowid']);
    			$info[] = $vvv;
    		}
    		 
    		$this->insert_previous_info($account_id, $info);
    
    	}
    
    	return TRUE;
    		
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
    
    //*- - - A M O U N T  &  C O S T I N G
    
    function get_items_subtotal($formated=false) 
    {
		$cart_subtotal = $this->cart->subtotal();
		$subtotal = ($cart_subtotal) ? $cart_subtotal : 0;
		return ($formated) ? $this->_format_price($subtotal) : $n;
	}
	
    function get_shipping_fee($formated=false) 
    {
		$n = $this->shipping_fee;
		
		return ($formated) ? $this->_format_price($n) : $n;
	}
	
    function total($formated=false) 
    {
		$cart_total = $this->cart->total();
		
		//addiotional cost/discount here: Shipping, General Discount 
		if( $shipping_fee = $this->get_shipping_fee() ){
			$cart_total = $cart_total + $shipping_fee;
		}
		
		if($this->remaining_pv() < 0) {
			$cart_total += abs($this->remaining_pv());
		}
		return ($formated) ? $this->_format_price($cart_total) : $cart_total;
	}
	
	private function _format_price($price,$show_currency=true)
	{
		$currency = 'Php'; //TODO: place on config/global
		return ($show_currency) ? $currency.' '.number_format($price,2) : $price;
	}
	
	
	function get_plan_pv() {
		$cart_contents = $this->cart->contents();
		
		foreach($cart_contents as $k=>$v) {
			
			if(trim($cart_contents[$k]['product_type']) == "plan") {
				$qty = $cart_contents[$k]['qty'] + 1;
				
			}
		}
	}
	
	function total_pv($formated=false) {
		$cart_contents = $this->cart->contents();
		
		foreach($cart_contents as $k => $val) {
			if ( ! is_array($val) OR ! isset($val['this_pv_value'])) continue;
			
			if(isset($val['this_pv_value'])) 				
				$total_pv += ($val['this_pv_value'] * $val['combos_qty']);
		}
		return ($formated) ? $this->_format_price($total_pv) : $total_pv;
	
	}
    function remaining_pv($display_negative=false) {
    	$cart_contents = $this->cart->contents();
    	
    	$totalPV = $this->total_pv();
    	foreach($cart_contents as $k => $v) {
    		if(trim($cart_contents[$k]['product_type']) == 'plan') {
    			$plan_pv = intval($cart_contents[$k]['this_pv_value']);
    		}
    	}
    	$retPV = $plan_pv - $totalPV;
    	if($display_negative == false) {
    		return ($retPV<0) ? 0 : $retPV;
    	}
    	return $retPV;
    	
    }
}
