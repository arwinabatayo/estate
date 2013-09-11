<?php
class Model_mainplans extends CI_Model
{
	
	function getAllMainPlans() 
	{
		$query = $this->db->get('estate_main_plan');
		
		if( $query->num_rows() > 0 ){
			return $query->result_array();
		}else{
			return array();
		}
	}
	
	function getMainPlanDetails($main_plan_id)
	{
		$this->db->where('f_main_plan_id', $main_plan_id);
		$query = $this->db->get('estate_main_plan');
		
		if( $query->num_rows() > 0 ){
			$tmp_mainplan_details = $query->row_array();
			$mainplan_details = array();
			$mainplan_details['main_plan_id'] = $tmp_mainplan_details['f_main_plan_id'];
			$mainplan_details['main_plan_type_id'] = $tmp_mainplan_details['f_main_plan_type_id'];
			$mainplan_details['main_plan_title'] = $tmp_mainplan_details['f_main_plan_title'];
			$mainplan_details['main_plan_description'] = $tmp_mainplan_details['f_main_plan_description'];
			$mainplan_details['main_plan_image'] = $tmp_mainplan_details['f_main_plan_image'];
			$mainplan_details['main_plan_status'] = $tmp_mainplan_details['f_main_plan_status'];
			
			return $mainplan_details;
		}else{
			return array();
		}
	}
	
	function getMainPlans($main_plan_type_id=null, $user_type, $order_by, $order, $limit, $limit_by = 50, $filter_arr = array()) 
	{
		$additional_query = "";
		$additional_query .= " WHERE estate_main_plan.f_main_plan_type_id = " . $main_plan_type_id;
		if ($filter_arr) {
			if( isset($filter_arr['letter']) ){ $additional_query .= " AND estate_main_plan.f_main_plan_title LIKE '" . $filter_arr['letter'] . "%'"; }
		}
		if ($order_by && $order)	{ $additional_query .= " ORDER BY $order_by $order"; }
		if ($limit_by != 'all') 	{ $additional_query .= " LIMIT $limit, $limit_by"; }
	
		$query = $this->db->query("	SELECT 	SQL_CALC_FOUND_ROWS *,
											estate_main_plan.f_main_plan_id AS main_plan_id,
											estate_main_plan.f_main_plan_type_id AS main_plan_type_id,
											estate_main_plan.f_main_plan_title AS main_plan_title,
											estate_main_plan.f_main_plan_description AS main_plan_description,
											estate_main_plan.f_main_plan_image AS main_plan_image,
											estate_main_plan.f_main_plan_status AS main_plan_status 
									FROM estate_main_plan " . $additional_query);
		$data = $query->result_array();
		$query = $this->db->query("	SELECT FOUND_ROWS() AS 'count'");
		$data["total_count"] = $query->row()->count;
		return $data;
	}
	
	function addMainPlan($data)
	{
		$this->db->insert('estate_main_plan', $data);
		return;
	}
	
	function updateMainPlan($data, $main_plan_id)
	{
		$this->db->where('f_main_plan_id', $main_plan_id);
		$this->db->update('estate_main_plan', $data); 
		return;
	}
	
	function deleteMainPlan($main_plan_id){
		$mainplan_details = $this->getMainPlanDetails($main_plan_id);
		
		$this->db->where('f_main_plan_id', $main_plan_id);
		$this->db->delete('estate_main_plan'); 
		return $mainplan_details;
	}
}
?>