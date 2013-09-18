<?php
class Model_planbundles extends CI_Model
{
	
	function getPlanBundles($property_id=null, $user_type, $order_by, $order, $limit, $limit_by = 50, $filter_arr = array()) 
	{
		
		$additional_query = "";
		if ($filter_arr) {
			if( isset($filter_arr['letter']) && $filter_arr['letter'] != '' ){
				$additional_query .= " WHERE estate_plan_bundle.name LIKE '" . $filter_arr['letter'] . "%'";
			}
			if( isset($filter_arr['bundle_type_id']) && $filter_arr['bundle_type_id'] != '' ) {
				if(!empty($additional_query)) {
					$additional_query .= " AND estate_plan_bundle.bundle_type_id=".$filter_arr['bundle_type_id'];
				} else {
					$additional_query .= " WHERE estate_plan_bundle.bundle_type_id=".$filter_arr['bundle_type_id'];
				}
			}
		}
		if ($order_by && $order)	{ $additional_query .= " ORDER BY $order_by $order"; }
		if ($limit_by != 'all') 	{ $additional_query .= " LIMIT $limit, $limit_by"; }
	
		$query = $this->db->query("	SELECT 	SQL_CALC_FOUND_ROWS *
									FROM estate_plan_bundle " . $additional_query);
		$data = $query->result_array();
		$query = $this->db->query("	SELECT FOUND_ROWS() AS 'count'");
		$data["total_count"] = $query->row()->count;
		
		return $data;
	}
	
	function getBundleDetails($bundle_id, $bundle_type_id = 0) {
		
		$this->db->where('id', $bundle_id);
// 		$this->db->where('bundle_type_id', $bundle_type_id);
		
		$query = $this->db->get('estate_plan_bundle');
	
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

		$this->db->insert('estate_plan_bundle', $data);
		return;
	}
	
	function updateBundle($data, $id)
	{
		
		$this->db->where('id', $id);
		$this->db->update('estate_plan_bundle', $data);
		
		
		return;
	}
	
	function deleteBundle($id){
		$combos_details = $this->getBundleDetails($id);
	
		$this->db->where('id', $id);
		$this->db->delete('estate_plan_bundle');
		return $combos_details;
	}
}
?>