<?php
class Products_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get Add-ons by type.
	 *
	 * @param  int category_id (required) - Add on category. Ex ( 1 = Gadget Care, 2 = Freebies, 3 = Special Offer,  )
         * @param  int status (optional) - Add on status
         * @param  string what (optional) - specify the fields needed
	 * @return array
	 */
	function get_add_ons_by_category($category_id = NULL, $status = 1, $what = '*')
	{
            if($category_id == NULL) return FALSE;
            $query = $this->db->select($what)
                               ->from('estate_add_ons')
                               ->where('category_id', $category_id)
                               ->where('status', $status)
                               ->get();
            $result = $query->result_array();
            if(count($result) == 0) return FALSE;
            return $result;
	}
        
        /**
	 * Get Accessories.
	 *
         * @param  int status (optional) - Add on status
         * @param  string what (optional) - specify the fields needed
	 * @return array
	 */
	function get_accessories($status = 1, $what = '*')
	{
            $query = $this->db->select($what)
                               ->from('estate_accessories')
                               ->where('status', $status)
                               ->get();
            $result = $query->result_array();
            if(count($result) == 0) return FALSE;
            return $result;
	}
	
	//@return mix 
	function get_product_fields($type='', $id=0){
		
			$out = array(
				'amount' => 0,
				'title'  => '',
			);
			
			if( $type == 'addon' ){
				
				$this->db->where('id', $id);
				$query = $this->db->get('estate_add_ons');
				$row = $query->row();
				$out['title']  = $row->title;
				$out['amount'] = $row->amount;

			}else if( $type == 'accessories' ) {
				
				$this->db->where('id', $id);
				$query = $this->db->get('estate_accessories');
				$row = $query->row();
				$out['title']  = $row->title;
				$out['amount'] = $row->amount;
			
			}else if( $type == 'plan' ){
				
				$this->db->where('id', $id);
				$this->db->where('is_active', '1');
				
				$query = $this->db->get('estate_plans');
				$row = $query->row();
				$out['title']  = $row->title;
				$out['amount'] = $row->amount;
				$out['plan_total_pv'] = $row->total_pv;
				
			}else if( $type == 'gadget' ){

				$out['title']  = 'iPhone 5';
				$out['amount'] = 12500;	
			}else if($type == 'combos') {
				
				$this->db->where('combo_id', $id);
				$query = $this->db->get('estate_combos');
				$row = $query->row();
				
				$out['title']  = $row->combo_name;
				$out['amount'] = 1; // hack
				$out['req_pv'] = $row->required_pv;
			}
			// combo and booster adding to cart
			return $out;
			
	}
	function get_plan_pv($plan_id) {
	
		$this->db->where('id', $plan_id);
	
		$query = $this->db->get('estate_plans');
		$row = $query->row();
		
		return $row->total_pv;
	}
	function get_gadget_cash_out($plan_id,$gadget_id) {
	
		$this->db->where('plan_id', $plan_id);
		$this->db->where('gadget_id', $gadget_id);
		
		$query = $this->db->get('estate_gadget_cash_out');
		$row = $query->row();
		return $row->cashout_val;
	}
	
	function compute_cashout($current_cashout, $planpv, $combopv){
		/** 
		 * Get Remaining Peso Value (PV)
		 * If remaining pv is negative, result add to current cashout
		 * If remaining pv is positive, deduct to Plan Peso Value 
		 **/
		$remainingPV = $planpv - $combopv;
		
		if($remainingPV < 0) { // Negative
			$current_cashout += abs($remainingPV);
			$planpv = 0;
		} else { // Positive
			$planpv = $remainingPV;
		}
		$out['upd_cashout'] = $current_cashout;
		$out['upd_planpv'] = $planpv;
		
		return $out;
	}
	
	function get_combos() {
		
		$this->db->where('is_active', '1');
		
		$query = $this->db->get('estate_combos');
		$row = $query->result();
		
		return $row;
	}
	
	function get_boosters() {
	
		$this->db->where('is_active', '1');
	
		$query = $this->db->get('estate_boosters');
		$row = $query->result();
	
		return $row;
	}
	function coexist_not_acceptable($corb_id) {
		
		$this->db->where('corb_id_1', $corb1);
		$this->db->where('is_acceptable', '0');
		
		$query = $this->db->get('estate_coexistence');
		$row = $query->result();
		
		// From here get the corbid2 and set not acceptable
		return $row;
	}
	
	
	
}
