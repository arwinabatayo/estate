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
			if( isset($filter_arr['bundle_type_id']) && $filter_arr['bundle_type_id'] != '' ){
				$additional_query .= " WHERE estate_plan_bundle.bundle_type_id=".$filter_arr['bundle_type_id'];
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
	
}
?>