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
				'amount' => 0.00,
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
			
			}else if( $type == 'plan' || $type == 'package_plan'){ //added package  plan
				
				$this->db->where('id', $id);
				$this->db->where('is_active', '1');
				
				$query = $this->db->get('estate_plans');
				$row = $query->row();
				$out['title']  = $row->title;
				$out['amount'] = $row->amount;
				$out['plan_total_pv'] = $row->total_pv;
				
			}else if( $type == 'gadget' ){
				$ids = explode("_", $id);
				
				$this->db->where('id', $ids[1]);
				$this->db->where('is_active', '1');
				
				$query = $this->db->get('estate_gadgets');
				$row = $query->row();
				
				$out['id']  = $row->id;
				$out['title']  = $row->name;
				$out['amount'] = '0.00';
				
			}else if($type == 'combos') {
				
				$this->db->where('id', $id);
				$query = $this->db->get('estate_plan_bundle');
				$row = $query->row();
				
				$out['title']  = $row->name;
				$out['req_pv'] = $row->peso_vlue;
			}else if($type == 'boosters') {
				
				$this->db->where('id', $id);
				$query = $this->db->get('estate_plan_bundle');
				$row = $query->row();
				
				$out['title']  = $row->name;
				$out['amount'] = $row->amount;
			}else if($type == 'prepaid_kit') {
				$this->db->where('gadget_id', $id);

				$query = $this->db->get("estate_gadgets");

				$row = $query->row();

				//print_r($row);
				$out['title'] = $row->name;
				$out['amount'] = $row->amount;
			}
			// combo and booster adding to cart
			
			return $out;
			
	}
	/**
	 * Get Plan Peso Value
	 * @param unknown $plan_id(required)
	 * 
	 * Robert
	 */
	function get_plan_pv($plan_id) {
	
		$this->db->where('id', $plan_id);
	
		$query = $this->db->get('estate_plans');
		$row = $query->row();
		
		return $row->total_pv;
	}
	/**
	 * Get Gadget and Plan Cash out Value
	 * @param unknown $plan_id(required)
	 * @param unknown $gadget_id(required)
	 * 
	 * Robert
	 */
	function get_gadget_cash_out($plan_id, $gadget_id, $attr_id, $lockup_period_id=1) {
		$cashout = 0;
		if(!empty($plan_id)) {
			$query = $this->db->query("SELECT * FROM estate_gadget_cash_out 
								WHERE plan_id='{$plan_id}'
								AND gadget_id='{$gadget_id}'
								AND attr_id='{$attr_id}'
								AND lockup_id='{$lockup_period_id}'");
			$row = $query->row();
			$cashout = $row->cashout_val;
		} else {
			$cashout = 0;
		}
		

		return $cashout;
	}
	
	/**
	 * 
	 * @param string $product_id(required)
	 */
function get_coexist($product_id, $is_acceptable="0") {
		$product_type = array('combos'=>'combos','boosters'=>'boosters');
		
		$out = array();
		$coexist = "no";
		$cart_contents = $this->cart->contents();

		$query = $this->db->query("SELECT * FROM estate_coexistence WHERE corb_id_2='{$product_id}' 
									AND is_acceptable='{$is_acceptable}'");
		$row = $query->result_array();
		
		if(!empty($row)) {
			foreach($row as $key => $value) {
				$notValid[$value['corb_id_1']] = $value['corb_type'];
			}
			foreach($cart_contents as $k => $v) {
				if(array_key_exists(trim($cart_contents[$k]['product_type']), $product_type)) {
					if(!array_key_exists($cart_contents[$k]['product_id'], $notValid)) {
						// if not in array, product id is available
						$coexist = "no";
					} else {
						// else if in array, product id is coexist
						$coexist = "yes";
						$out['product_name'] = $cart_contents[$k]['name'];
						$out['rowid'] = $cart_contents[$k]['rowid'];
						$out['product_id'] = $cart_contents[$k]['product_id'];
						$out['coex_product_type'] = $cart_contents[$k]['product_type'];
						$out['corb_type'] = $notValid[$cart_contents[$k]['product_id']];
						break;
					}
				}
			}
		}
		$out['coexist'] = $coexist;
		return $out;
	}
	/**
	 * Get Booster or Combos
	 * @param number $bundle_id "REQUIRED"
	 * @return array
	 */
	function get_bundles($bundle_id=2) {
		$this->db->where('is_active', '1');
		$this->db->where('bundle_type_id', $bundle_id);
	
		$query = $this->db->get('estate_plan_bundle');
		$row = $query->result();
	
		return $row;
	}
	
	function get_combos() {
		
		$this->db->where('is_active', '1');
		$this->db->where('is_active', '2');
		
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


	function get_package_plan($cust_type=0) {//$cust_type=0  Lawrence 10-02-2013
		$this->db->where('is_active', 1);
                
                //Lawrence 10-02-2013
                if($cust_type)
		  $this->db->where('customer_type',$cust_type );
                //==========================================
                
		$query = $this->db->get('estate_package_plans');
		$row = $query->result();

		return $row;
	}

	function get_package_plan_bundle() {
		$this->db->where('is_active', '1');
		$this->db->where('bundle_type_id', 2);
	
		$query = $this->db->get('estate_package_plan_bundle');
		$row = $query->result();
	
		return $row;
	}
	
	function get_package_plan_pv($plan_id) {
	
		$this->db->where('id', $plan_id);
	
		$query = $this->db->get('estate_package_plans');
		$row = $query->row();
		
		return $row->total_pv;
	}


	function get_gadget_cash_out_package_plan($package_plan_id, $gadget_id) {
		
		
		//var_dump($plan_id_where); exit;
		$this->db->where('package_plan_id', $package_plan_id);
		$this->db->where('gadget_id', $gadget_id);
		
		$query = $this->db->get('estate_gadget_cash_out');

		$row = $query->row();

		
		
		return $row->cashout_val;
	}
	

	/**
	 * Robert functions for ULTIMA
	 */
	function get_plans($gadget_id, $attr_id, $is_active=1) {	
		if(!empty($gadget_id) || !empty($attr_id)) {
			$query = $this->db->query("	SELECT 
										esplan.id,
										esplan.title,
										esplan.description,
										esplan.long_desc,
										esplan.plan_cid,
										esplan.total_pv,
										esplan.max_gadget_pv,
										esgadcahout.cashout_val, 
										esgadcahout.cashout_val
										FROM estate_plans esplan 
										INNER JOIN estate_gadget_cash_out esgadcahout
										ON esplan.id = esgadcahout.plan_id
										WHERE esgadcahout.gadget_id = {$gadget_id} 
										AND esgadcahout.attr_id = {$attr_id} GROUP BY esplan.id");
	
			$data = $query->result();
			$query = $this->db->query("	SELECT FOUND_ROWS() AS 'count'");
		}
		return $data;
	}
// 	function get_plans_bundles($sBundle) {
// 		if(!empty($sBundle)) {
// 			$this->db->where('name', strtolower(trim($sBundle)));
// 			$query = $this->db->get('estate_plan_bundle_type');
// 			$row = $query->row();
// 			$bundleId = $row->id;
			
// 			$query = $this->db->query("SELECT * FROM estate_{$sBundle} WHERE id = {$bundleId}");
// 			$data = $query->result();
			
// 			return $data;
// 		}
		
// 	}
}
