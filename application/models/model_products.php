<?php
class Model_products extends CI_Model
{
	
	function getAllProducts() 
	{
		$query = $this->db->get('estate_gadgets');
		
		if( $query->num_rows() > 0 ){
			return $query->result_array();
		}else{
			return array();
		}
	}
	
	function getProductDetails($gadget_id)
	{
		$this->db->where('gadget_id', $gadget_id);
		$query = $this->db->get('estate_gadgets');
		
		if( $query->num_rows() > 0 ){
			//get attributes
			$product_details = $query->row_array();
			
			$this->db->where('gadget_id', $gadget_id);
			$query = $this->db->get('estate_gadget_attribute');
			
			if( $query->num_rows() > 0 ){
				foreach( $query->result_array() as $r ){
					$type = $r['type'];
					$value = $r['value'];
					
					$product_details[$type] = $value;
				}
			}
			
			return $product_details;
		}else{
			return array();
		}
	}
	
	function getProducts($property_id=null, $user_type, $order_by, $order, $limit, $limit_by = 50, $filter_arr = array()) 
	{
		$additional_query = "";
		if ($filter_arr) {
			if( isset($filter_arr['letter']) && $filter_arr['letter'] != '' ){
				$additional_query .= " WHERE estate_gadgets.name LIKE '" . $filter_arr['letter'] . "%'";
			}
		}
		if ($order_by && $order)	{ $additional_query .= " ORDER BY $order_by $order"; }
		if ($limit_by != 'all') 	{ $additional_query .= " LIMIT $limit, $limit_by"; }
	
		$query = $this->db->query("	SELECT 	SQL_CALC_FOUND_ROWS *,
											estate_gadgets.gadget_id AS gadget_id,
											estate_gadgets.name AS name,
											estate_gadgets.description AS description,
											estate_gadgets.required_pv AS required_pv,
											estate_gadgets.cid AS cid,
											estate_gadgets.data_capacity AS data_capacity,
											estate_gadgets.network_connectivity AS network_connectivity,
											estate_gadgets.amount AS amount,
											estate_gadgets.discount AS discount,
											estate_gadgets.peso_value AS peso_value,
											estate_gadgets.date_added AS date_added,
											estate_gadgets.quantity AS quantity,
											estate_gadgets.image AS image,
											estate_gadgets.is_active AS is_active,
											estate_gadgets.date_modified AS date_modified 
									FROM estate_gadgets " . $additional_query);
		$data = $query->result_array();
		$query = $this->db->query("	SELECT FOUND_ROWS() AS 'count'");
		$data["total_count"] = $query->row()->count;
		return $data;
	}
	
	function addProduct($data, $tmp_data_attr){
		$this->db->insert('estate_gadgets', $data);
		
		$gadget_id = $this->db->insert_id();
		
		if( isset($tmp_data_attr['color']) && $tmp_data_attr['color'] != '' ){
			$data_attr = array();
			$data_attr['gadget_id'] = $gadget_id;
			$data_attr['type'] = 'color';
			$data_attr['value'] = $tmp_data_attr['color'];
			
			$this->db->insert('estate_gadget_attribute', $data_attr);
		}
		
		if( isset($tmp_data_attr['size']) && $tmp_data_attr['size'] != '' ){
			$data_attr = array();
			$data_attr['gadget_id'] = $gadget_id;
			$data_attr['type'] = 'size';
			$data_attr['value'] = $tmp_data_attr['size'];
			
			$this->db->insert('estate_gadget_attribute', $data_attr);
		}
		
		return;
	}
	
	function updateProduct($data, $tmp_data_attr, $gadget_id){
		$this->db->where('gadget_id', $gadget_id);
		$this->db->update('estate_gadgets', $data); 
		
		if( isset($tmp_data_attr['color']) && $tmp_data_attr['color'] != '' ){
			$data_attr = array();
			$data_attr['type'] = 'color';
			$data_attr['value'] = $tmp_data_attr['color'];
			
			$this->db->where('gadget_id', $gadget_id);
			$this->db->where('type', 'color');
			$this->db->update('estate_gadget_attribute', $data_attr);
		}else{
			$this->db->where('gadget_id', $gadget_id);
			$this->db->where('type', 'color');
			$this->db->delete('estate_gadget_attribute');
		}
		
		if( isset($tmp_data_attr['size']) && $tmp_data_attr['size'] != '' ){
			$data_attr = array();
			$data_attr['type'] = 'size';
			$data_attr['value'] = $tmp_data_attr['size'];
			
			$this->db->where('gadget_id', $gadget_id);
			$this->db->where('type', 'size');
			$this->db->update('estate_gadget_attribute', $data_attr);
		}else{
			$this->db->where('gadget_id', $gadget_id);
			$this->db->where('type', 'size');
			$this->db->delete('estate_gadget_attribute');
		}
		
		return;
	}
	
	function deleteProduct($gadget_id){
		$product_details = $this->getProductDetails($gadget_id);
		
		$this->db->where('gadget_id', $gadget_id);
		$this->db->delete('estate_gadgets'); 
		
		//delete product attributes
		$this->db->where('gadget_id', $gadget_id);
		$this->db->delete('estate_gadget_attribute'); 
		return $product_details;
	}
	
}
?>