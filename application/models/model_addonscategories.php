<?php
class Model_addonscategories extends CI_Model
{
	
	function getAllAddonsCategories() 
	{
		$this->db->order_by('category_title', 'ASC');
		$query = $this->db->get('estate_add_ons_category');
		
		if( $query->num_rows() > 0 ){
			$tmp_addonscategories = $query->result_array();
			$addonscategories = array();
			foreach( $tmp_addonscategories as $key => $addonscategory ){
				$addonscategories[$key]['add_ons_category_id'] = $addonscategory['category_id'];
				$addonscategories[$key]['add_ons_category_title'] = $addonscategory['category_title'];
				$addonscategories[$key]['add_ons_category_description'] = $addonscategory['category_description'];
				$addonscategories[$key]['add_ons_category_image'] = $addonscategory['category_image'];
				$addonscategories[$key]['add_ons_is_multiple'] = $addonscategory['is_multiple'];
			}
			
			return $addonscategories;
		}else{
			return array();
		}
	}
	
	function getAddonsCategory($add_ons_category_id)
	{
		$this->db->where('category_id', $add_ons_category_id);
		$query = $this->db->get('estate_add_ons_category');
		
		if( $query->num_rows() > 0 ){
			$tmp_addonscategory_details = $query->row_array();
			$addonscategory_details = array();
			$addonscategory_details['add_ons_category_id'] = $tmp_addonscategory_details['category_id'];
			$addonscategory_details['add_ons_category_title'] = $tmp_addonscategory_details['category_title'];
			$addonscategory_details['add_ons_category_description'] = $tmp_addonscategory_details['category_description'];
			$addonscategory_details['add_ons_category_image'] = $tmp_addonscategory_details['category_image'];
			$addonscategory_details['add_ons_is_multiple'] = $tmp_addonscategory_details['is_multiple'];
			
			return $addonscategory_details;
		}else{
			return array();
		}
	}
	
	function getAddonsCategories($property_id=null, $user_type, $order_by, $order, $limit, $limit_by = 50, $filter_arr = array()) 
	{
		$additional_query = "";
		if ($filter_arr) {
			if( isset($filter_arr['letter']) && $filter_arr['letter'] != '' ){
				$additional_query .= " WHERE estate_add_ons_category.category_title LIKE '" . $filter_arr['letter'] . "%'";
			}
		}
		if ($order_by && $order)	{ $additional_query .= " ORDER BY $order_by $order"; }
		if ($limit_by != 'all') 	{ $additional_query .= " LIMIT $limit, $limit_by"; }
	
		$query = $this->db->query("	SELECT 	SQL_CALC_FOUND_ROWS *,
											estate_add_ons_category.category_id AS add_ons_category_id,
											estate_add_ons_category.category_title AS add_ons_category_title,
											estate_add_ons_category.category_description AS add_ons_category_description,
											estate_add_ons_category.category_image AS add_ons_category_image, 
											estate_add_ons_category.is_multiple AS add_ons_is_multiple 
									FROM estate_add_ons_category " . $additional_query);
		$data = $query->result_array();
		$query = $this->db->query("	SELECT FOUND_ROWS() AS 'count'");
		$data["total_count"] = $query->row()->count;
		return $data;
	}
	
	function addAddonsCategory($data)
	{
		$this->db->insert('estate_add_ons_category', $data);
		return;
	}
	
	function updateAddonsCategory($data, $add_ons_category_id)
	{
		$this->db->where('category_id', $add_ons_category_id);
		$this->db->update('estate_add_ons_category', $data); 
		return;
	}
	
	function getAddonsCategoryDetails($addonscategory_id)
	{
		$this->db->where('category_id', $addonscategory_id);
		$query = $this->db->get('estate_add_ons_category');
		
		if( $query->num_rows() > 0 ){
			return $query->row_array();
		}else{
			return array();
		}
	}
	
	function deleteAddonsCategory($add_ons_category_id){
		$addonscategory_details = $this->getAddonsCategoryDetails($add_ons_category_id);
		
		$this->db->where('category_id', $add_ons_category_id);
		$this->db->delete('estate_add_ons_category'); 
		return $addonscategory_details;
	}
	
	function deleteAddonsCategoryAddons($add_ons_category_id){
		$this->db->where('category_id', $add_ons_category_id);
		$query = $this->db->get('estate_add_ons');
		
		if( $query->num_rows() > 0 ){
			$this->db->where('category_id', $add_ons_category_id);
			$this->db->delete('estate_add_ons');;
			
			return $query->result_array();
		}else{
			return array();
		}
	}
}
?>