<?php
class Model_addons extends CI_Model
{
	
	function getAllAddons() 
	{
		$query = $this->db->get('estate_add_ons');
		
		if( $query->num_rows() > 0 ){
			return $query->result_array();
		}else{
			return array();
		}
	}
	
	function getAddonDetails($addon_id)
	{
		$this->db->where('f_add_on_id', $addon_id);
		$query = $this->db->get('estate_add_ons');
		
		if( $query->num_rows() > 0 ){
			$tmp_addon_details = $query->row_array();
			$addon_details = array();
			$addon_details['add_on_id'] 				= $tmp_addon_details['f_add_on_id'];
			$addon_details['add_on_title'] 				= $tmp_addon_details['f_add_on_title'];
			$addon_details['add_on_description'] 		= $tmp_addon_details['f_add_on_description'];
			$addon_details['add_on_amount'] 			= $tmp_addon_details['f_add_on_amount'];
			$addon_details['add_on_status'] 			= $tmp_addon_details['f_add_on_status'];
			$addon_details['add_ons_category_id'] 		= $tmp_addon_details['f_add_ons_category_id'];
			$addon_details['add_ons_quantity'] 			= $tmp_addon_details['f_add_ons_quantity'];
			$addon_details['add_on_image'] 				= $tmp_addon_details['f_add_on_image'];
			$addon_details['add_ons_peso_value']	 	= $tmp_addon_details['f_add_ons_peso_value'];
			
			return $addon_details;
		}else{
			return array();
		}
	}
	
	function getAddons($addonscategory_id=null, $user_type, $order_by, $order, $limit, $limit_by = 50, $filter_arr = array()) 
	{
		$additional_query = "";
		$additional_query .= " WHERE estate_add_ons.f_add_ons_category_id = " . $addonscategory_id;
		if ($filter_arr) {
			if( isset($filter_arr['letter']) ){ $additional_query .= " AND estate_add_ons.f_add_on_title LIKE '" . $filter_arr['letter'] . "%'"; }
		}
		if ($order_by && $order)	{ $additional_query .= " ORDER BY $order_by $order"; }
		if ($limit_by != 'all') 	{ $additional_query .= " LIMIT $limit, $limit_by"; }
	
		$query = $this->db->query("	SELECT 	SQL_CALC_FOUND_ROWS *,
											estate_add_ons.f_add_on_id AS add_on_id,
											estate_add_ons.f_add_on_title AS add_on_title,
											estate_add_ons.f_add_on_description AS add_on_description,
											estate_add_ons.f_add_on_amount AS add_on_amount,
											estate_add_ons.f_add_on_status AS add_on_status,
											estate_add_ons.f_add_ons_category_id AS add_ons_category_id,
											estate_add_ons.f_add_ons_peso_value AS add_ons_peso_value 
									FROM estate_add_ons " . $additional_query);
		$data = $query->result_array();
		$query = $this->db->query("	SELECT FOUND_ROWS() AS 'count'");
		$data["total_count"] = $query->row()->count;
		return $data;
	}
	
	function addAddon($data)
	{
		$this->db->insert('estate_add_ons', $data);
		return;
	}
	
	function updateAddon($data, $main_plan_id)
	{
		$this->db->where('f_add_on_id', $main_plan_id);
		$this->db->update('estate_add_ons', $data); 
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