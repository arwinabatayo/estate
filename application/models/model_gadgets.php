<?php
/**
 * 9.18.2013
* Ultima Logic
* robert hughes
*/

class Model_gadgets extends CI_Model
{
	
	function getGadgets($property_id=null, $user_type, $order_by, $order, $limit, $limit_by = 50, $filter_arr = array()) 
	{
		
		$additional_query = "";
		if ($filter_arr) {
			if( isset($filter_arr['letter']) && $filter_arr['letter'] != '' ){
				$additional_query .= " WHERE estate_gadgets.name LIKE '" . $filter_arr['letter'] . "%'";
			}
			if( isset($filter_arr['gadget_id']) && $filter_arr['gadget_id'] != '' ) {
				if(!empty($additional_query)) {
					$additional_query .= " AND estate_gadgets.gadget_id=".$filter_arr['gadget_id'];
				} else {
					$additional_query .= " WHERE estate_gadgets.gadget_id=".$filter_arr['gadget_id'];
				}
			}
		}
		if ($order_by && $order)	{ $additional_query .= " ORDER BY $order_by $order"; }
		if ($limit_by != 'all') 	{ $additional_query .= " LIMIT $limit, $limit_by"; }
	
		$query = $this->db->query("	SELECT 	SQL_CALC_FOUND_ROWS *
									FROM estate_gadgets " . $additional_query);
		$data = $query->result_array();
		$query = $this->db->query("	SELECT FOUND_ROWS() AS 'count'");
		$data["total_count"] = $query->row()->count;
		
		return $data;
	}
	
	function getAllGadgetsByStatus($status=null){
		if( in_array($status, array(0=>0, 1=>1)) ){
			$this->db->where('is_active', $status);
			$query = $this->db->get('estate_gadgets');
			return $query->result_array();
		}else{
			$query = $this->db->get('estate_gadgets');
			return $query->result_array();
		}
	}
	
	function getGadgetDetails($bundle_id, $gadget_id = 0) {
		
		$this->db->where('id', $bundle_id);
// 		$this->db->where('gadget_id', $gadget_id);
		
		$query = $this->db->get('estate_gadgets');
	
		if( $query->num_rows() > 0 ){
			$tmp_combos_details = $query->row_array();
			$combos_details = array();
			
			$combos_details['_id'] 			= $tmp_combos_details['id'];
			$combos_details['_cid'] 		= $tmp_combos_details['cid'];
			$combos_details['_name'] 		= $tmp_combos_details['name'];
			$combos_details['_description'] = $tmp_combos_details['description'];
			$combos_details['_long_desc'] 	= $tmp_combos_details['long_description'];
			$combos_details['_amount'] 		= $tmp_combos_details['amount'];
			$combos_details['_max_peso_value'] 	= $tmp_combos_details['max_peso_value'];
			$combos_details['_peso_value'] 	= $tmp_combos_details['peso_value'];
			$combos_details['_status'] 		= $tmp_combos_details['is_active'];
			
			return $combos_details;
		}else{
			return array();
		}
	}
	
	function addBundle($data) {

		$this->db->insert('estate_gadgets', $data);
		return;
	}
	
	function updateBundle($data, $id)
	{
		
		$this->db->where('id', $id);
		$this->db->update('estate_gadgets', $data);
		
		
		return;
	}
	
	function deleteBundle($id){
		$combos_details = $this->getBundleDetails($id);
	
		$this->db->where('id', $id);
		$this->db->delete('estate_gadgets');
		return $combos_details;
	}
}
?>