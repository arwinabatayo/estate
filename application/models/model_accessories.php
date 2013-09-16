<?php
class Model_accessories extends CI_Model
{
	
	function getAccessoryDetails($accessory_id)
	{
		$this->db->where('id', $accessory_id);
		$query = $this->db->get('estate_accessories');
		
		if( $query->num_rows() > 0 ){
			$tmp_accessory_details = $query->row_array();
			$accessory_details = array();
			$accessory_details['accessories_id'] = $tmp_accessory_details['id'];
			$accessory_details['accessories_title'] = $tmp_accessory_details['title'];
			$accessory_details['accessories_cid'] = $tmp_accessory_details['cid'];
			$accessory_details['accessories_description'] = $tmp_accessory_details['description'];
			$accessory_details['accessories_amount'] = $tmp_accessory_details['amount'];
			$accessory_details['accessories_status'] = $tmp_accessory_details['status'];
			$accessory_details['accessories_quantity'] = $tmp_accessory_details['quantity'];
			$accessory_details['accessories_image'] = $tmp_accessory_details['image'];
			$accessory_details['accessories_peso_value'] = $tmp_accessory_details['peso_value'];
			
			return $accessory_details;
		}else{
			return array();
		}
	}

	function getAccessories($property_id=null, $user_type, $order_by, $order, $limit, $limit_by = 50, $filter_arr = array()) 
	{
		$additional_query = "";
		if ($filter_arr) {
			if( isset($filter_arr['letter']) && $filter_arr['letter'] != '' ){
				$additional_query .= " WHERE estate_accessories.title LIKE '" . $filter_arr['letter'] . "%'";
			}
		}
		if ($order_by && $order)	{ $additional_query .= " ORDER BY $order_by $order"; }
		if ($limit_by != 'all') 	{ $additional_query .= " LIMIT $limit, $limit_by"; }
	
		$query = $this->db->query("	SELECT 	SQL_CALC_FOUND_ROWS *,
											estate_accessories.id AS accessories_id,
											estate_accessories.cid AS accessories_cid,
											estate_accessories.title AS accessories_title,
											estate_accessories.description AS accessories_description,
											estate_accessories.amount AS accessories_amount,
											estate_accessories.status AS accessories_status,
											estate_accessories.quantity AS accessories_quantity,
											estate_accessories.image AS accessories_image,
											estate_accessories.peso_value AS accessories_peso_value 
									FROM estate_accessories " . $additional_query);
		$data = $query->result_array();
		$query = $this->db->query("	SELECT FOUND_ROWS() AS 'count'");
		$data["total_count"] = $query->row()->count;
		return $data;
	}
	
	function addAccessory($data)
	{
		$this->db->insert('estate_accessories', $data);
		return;
	}
	
	function updateAccessory($data, $accessory_id)
	{
		$this->db->where('id', $accessory_id);
		$this->db->update('estate_accessories', $data); 
		return;
	}
	
	function deleteAccessory($accessory_id){
		$accessory_details = $this->getAccessoryDetails($accessory_id);
		
		$this->db->where('id', $accessory_id);
		$this->db->delete('estate_accessories'); 
		return $accessory_details;
	}
}
?>