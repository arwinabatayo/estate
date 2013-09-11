<?php
class Model_products extends CI_Model
{
	
	function getAllProducts() 
	{
		$query = $this->db->get('estate_product');
		
		if( $query->num_rows() > 0 ){
			return $query->result_array();
		}else{
			return array();
		}
	}
	
	function getProductDetails($product_id)
	{
		$this->db->where('product_id', $product_id);
		$query = $this->db->get('estate_product');
		
		if( $query->num_rows() > 0 ){
			return $query->row_array();
		}else{
			return array();
		}
	}
	
	function getProducts($property_id=null, $user_type, $order_by, $order, $limit, $limit_by = 50, $filter_arr = array()) 
	{
		$additional_query = "";
		if ($filter_arr) {
			$additional_query .= " WHERE estate_product.product_name LIKE '" . $filter_arr['letter'] . "%'";
		}
		if ($order_by && $order)	{ $additional_query .= " ORDER BY $order_by $order"; }
		if ($limit_by != 'all') 	{ $additional_query .= " LIMIT $limit, $limit_by"; }
	
		$query = $this->db->query("	SELECT 	SQL_CALC_FOUND_ROWS *,
											estate_product.product_id AS product_id,
											estate_product.product_name AS product_name,
											estate_product.product_description AS product_description,
											estate_product.product_size AS product_size,
											estate_product.product_color AS product_color,
											estate_product.product_color_hex AS product_color_hex,
											estate_product.product_data_capacity AS product_data_capacity,
											estate_product.product_network_connectivity AS product_network_connectivity,
											estate_product.product_amount AS product_amount,
											estate_product.product_discount AS product_discount,
											estate_product.product_peso_value AS product_peso_value,
											estate_product.product_date_added AS product_date_added,
											estate_product.product_quantity AS product_quantity,
											estate_product.product_status_flag AS product_status_flag 
									FROM estate_product " . $additional_query);
		$data = $query->result_array();
		$query = $this->db->query("	SELECT FOUND_ROWS() AS 'count'");
		$data["total_count"] = $query->row()->count;
		return $data;
	}
	
	function addProduct($data){
		$this->db->insert('estate_product', $data);
		return;
	}
	
	function updateProduct($data, $product_id){
		$this->db->where('product_id', $product_id);
		$this->db->update('estate_product', $data); 
		return;
	}
	
	function deleteProduct($product_id){
		$product_details = $this->getProductDetails($product_id);
		
		$this->db->where('product_id', $product_id);
		$this->db->delete('estate_product'); 
		return $product_details;
	}
	
}
?>