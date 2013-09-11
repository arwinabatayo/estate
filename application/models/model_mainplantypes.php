<?php
class Model_mainplantypes extends CI_Model
{
	
	function getAllMainPlanTypes() 
	{
		$this->db->order_by('f_type', 'ASC');
		$query = $this->db->get('estate_main_plan_type');
		
		if( $query->num_rows() > 0 ){
			$tmp_mainplantypes = $query->result_array();
			$mainplantypes = array();
			foreach( $tmp_mainplantypes as $key => $mainplantype ){
				$mainplantypes[$key]['main_plan_type_id'] = $mainplantype['f_main_plan_type_id'];
				$mainplantypes[$key]['type'] = $mainplantype['f_type'];
				$mainplantypes[$key]['type_description'] = $mainplantype['f_type_description'];
				$mainplantypes[$key]['type_image'] = $mainplantype['f_type_image'];
				$mainplantypes[$key]['main_plan_type_status'] = $mainplantype['f_main_plan_type_status'];
			}
			
			return $mainplantypes;
		}else{
			return array();
		}
	}
	
	function getMainPlanTypeDetails($main_type_plan_id)
	{
		$this->db->where('f_main_plan_type_id', $main_type_plan_id);
		$query = $this->db->get('estate_main_plan_type');
		
		if( $query->num_rows() > 0 ){
			$tmp_mainplantype_details = $query->row_array();
			$mainplantype_details = array();
			$mainplantype_details['main_plan_type_id'] = $tmp_mainplantype_details['f_main_plan_type_id'];
			$mainplantype_details['type'] = $tmp_mainplantype_details['f_type'];
			$mainplantype_details['type_description'] = $tmp_mainplantype_details['f_type_description'];
			$mainplantype_details['type_image'] = $tmp_mainplantype_details['f_type_image'];
			$mainplantype_details['main_plan_type_status'] = $tmp_mainplantype_details['f_main_plan_type_status'];
			
			return $mainplantype_details;
		}else{
			return array();
		}
	}
	
	function getMainPlanTypes($property_id=null, $user_type, $order_by, $order, $limit, $limit_by = 50, $filter_arr = array()) 
	{
		$additional_query = "";
		if ($filter_arr) {
			$additional_query .= " WHERE estate_main_plan_type.f_type LIKE '" . $filter_arr['letter'] . "%'";
		}
		if ($order_by && $order)	{ $additional_query .= " ORDER BY $order_by $order"; }
		if ($limit_by != 'all') 	{ $additional_query .= " LIMIT $limit, $limit_by"; }
	
		$query = $this->db->query("	SELECT 	SQL_CALC_FOUND_ROWS *,
											estate_main_plan_type.f_main_plan_type_id AS main_plan_type_id,
											estate_main_plan_type.f_type AS type,
											estate_main_plan_type.f_type_description AS type_description,
											estate_main_plan_type.f_type_image AS type_image,
											estate_main_plan_type.f_main_plan_type_status AS main_plan_type_status 
									FROM estate_main_plan_type " . $additional_query);
		$data = $query->result_array();
		$query = $this->db->query("	SELECT FOUND_ROWS() AS 'count'");
		$data["total_count"] = $query->row()->count;
		return $data;
	}
	
	function addMainPlanType($data)
	{
		$this->db->insert('estate_main_plan_type', $data);
		return;
	}
	
	function updateMainPlanType($data, $main_plan_type_id)
	{
		$this->db->where('f_main_plan_type_id', $main_plan_type_id);
		$this->db->update('estate_main_plan_type', $data); 
		return;
	}
	
	function deleteMainPlanType($main_plan_type_id){
		$mainplantype_details = $this->getMainPlanTypeDetails($main_plan_type_id);
		
		$this->db->where('f_main_plan_type_id', $main_plan_type_id);
		$this->db->delete('estate_main_plan_type'); 
		return $mainplantype_details;
	}
}
?>