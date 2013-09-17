<?php
class Model_combos extends CI_Model
{
	
	function getCombosDetails($Combos_id)
	{
		$this->db->where('id', $Combos_id);
		$query = $this->db->get('estate_Combos');
		
		if( $query->num_rows() > 0 ){
			$tmp_Combos_details = $query->row_array();
			$Combos_details = array();
			$Combos_details['Combos_id'] = $tmp_Combos_details['id'];
			$Combos_details['Combos_title'] = $tmp_Combos_details['title'];
			$Combos_details['Combos_cid'] = $tmp_Combos_details['cid'];
			$Combos_details['Combos_description'] = $tmp_Combos_details['description'];
			$Combos_details['Combos_amount'] = $tmp_Combos_details['amount'];
			$Combos_details['Combos_status'] = $tmp_Combos_details['status'];
			$Combos_details['Combos_quantity'] = $tmp_Combos_details['quantity'];
			$Combos_details['Combos_image'] = $tmp_Combos_details['image'];
			$Combos_details['Combos_peso_value'] = $tmp_Combos_details['peso_value'];
			
			return $Combos_details;
		}else{
			return array();
		}
	}

	function getCombos($property_id=null, $user_type, $order_by, $order, $limit, $limit_by = 50, $filter_arr = array()) 
	{
		$additional_query = "";
		if ($filter_arr) {
			if( isset($filter_arr['letter']) && $filter_arr['letter'] != '' ){
				$additional_query .= " WHERE estate_plan_bundle.name LIKE '" . $filter_arr['letter'] . "%'";
			}
		}
		if ($order_by && $order)	{ $additional_query .= " ORDER BY $order_by $order"; }
		if ($limit_by != 'all') 	{ $additional_query .= " LIMIT $limit, $limit_by"; }
	
		$query = $this->db->query("	SELECT 	SQL_CALC_FOUND_ROWS *,
											id AS _id,
											cid AS _cid,
											name AS _name,
											description AS _description,
											long_description AS _longdesc,
											amount AS _status,
											peso_value AS _pv,
											is_active AS _status 
									FROM estate_plan_bundle " . $additional_query);
		$data = $query->result_array();
		$query = $this->db->query("	SELECT FOUND_ROWS() AS 'count'");
		$data["total_count"] = $query->row()->count;
		return $data;
	}
	
	function addCombos($data)
	{
		$this->db->insert('estate_Combos', $data);
		return;
	}
	
	function updateCombos($data, $Combos_id)
	{
		$this->db->where('id', $Combos_id);
		$this->db->update('estate_Combos', $data); 
		return;
	}
	
	function deleteCombos($Combos_id){
		$Combos_details = $this->getCombosDetails($Combos_id);
		
		$this->db->where('id', $Combos_id);
		$this->db->delete('estate_Combos'); 
		return $Combos_details;
	}
	
	
}
?>