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
		$this->db->where('id', $addon_id);
		$query = $this->db->get('estate_add_ons');
		
		if( $query->num_rows() > 0 ){
			$tmp_addon_details = $query->row_array();
			$addon_details = array();
			$addon_details['add_on_id'] 				= $tmp_addon_details['id'];
			$addon_details['add_on_title'] 				= $tmp_addon_details['title'];
			$addon_details['add_on_cid'] 				= $tmp_addon_details['cid'];
			$addon_details['add_on_description'] 		= $tmp_addon_details['description'];
			$addon_details['add_on_amount'] 			= $tmp_addon_details['amount'];
			$addon_details['add_on_status'] 			= $tmp_addon_details['status'];
			$addon_details['add_ons_category_id'] 		= $tmp_addon_details['category_id'];
			$addon_details['add_ons_quantity'] 			= $tmp_addon_details['quantity'];
			$addon_details['add_on_image'] 				= $tmp_addon_details['image'];
			$addon_details['add_ons_peso_value']	 	= $tmp_addon_details['peso_value'];
			
			return $addon_details;
		}else{
			return array();
		}
	}
	
	function getAddons($addonscategory_id=null, $user_type, $order_by, $order, $limit, $limit_by = 50, $filter_arr = array()) 
	{
		$additional_query = "";
		$additional_query .= " WHERE estate_add_ons.category_id = " . $addonscategory_id;
		if ($filter_arr) {
			if( isset($filter_arr['letter']) && $filter_arr['letter'] != '' ){
				$additional_query .= " AND estate_add_ons.title LIKE '" . $filter_arr['letter'] . "%'"; 
			}
		}
		if ($order_by && $order)	{ $additional_query .= " ORDER BY $order_by $order"; }
		if ($limit_by != 'all') 	{ $additional_query .= " LIMIT $limit, $limit_by"; }
	
		$query = $this->db->query("	SELECT 	SQL_CALC_FOUND_ROWS *,
											estate_add_ons.id AS add_on_id,
											estate_add_ons.title AS add_on_title,
											estate_add_ons.cid AS add_on_cid,
											estate_add_ons.description AS add_on_description,
											estate_add_ons.amount AS add_on_amount,
											estate_add_ons.status AS add_on_status,
											estate_add_ons.category_id AS add_ons_category_id,
											estate_add_ons.peso_value AS add_ons_peso_value 
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
		$this->db->where('id', $main_plan_id);
		$this->db->update('estate_add_ons', $data); 
		return;
	}
	
	function deleteAddon($addon_id){
		$addon_details = $this->getAddonDetails($addon_id);
		
		$this->db->where('id', $addon_id);
		$this->db->delete('estate_add_ons'); 
		return $addon_details;
	}
}
?>