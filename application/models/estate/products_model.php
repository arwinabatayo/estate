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
                               ->where('f_add_ons_category_id', $category_id)
                               ->where('f_add_on_status', $status)
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
                               ->where('f_accessories_status', $status)
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
				
				$this->db->where('f_add_on_id', $id);
				$query = $this->db->get('estate_add_ons');
				$row = $query->row();
				$out['title']  = $row->f_add_on_title;
				$out['amount'] = $row->f_add_on_amount;

			}else if( $type == 'accessories' ) {
				
				$this->db->where('f_accessories_id', $id);
				$query = $this->db->get('estate_accessories');
				$row = $query->row();
				$out['title']  = $row->f_accessories_title;
				$out['amount'] = $row->f_accessories_amount;
			
			}else if( $type == 'plan' ){
				
				$this->db->where('f_plan_id', $id);
				$query = $this->db->get('estate_plan');
				$row = $query->row();
				$out['title']  = $row->f_plan_title;
				$out['amount'] = $row->f_plan_amount;
				
			}else if( $type == 'gadget' ){

				$out['title']  = 'iPhone 5';
				$out['amount'] = 12500;	
			}
			
			return $out;
			
	}
	
	
	
}
