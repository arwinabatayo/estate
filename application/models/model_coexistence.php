<?php
class Model_coexistence extends CI_Model
{
	
	function getCoExistenceDetails($CoExistence_id)
	{
		$this->db->where('id', $CoExistence_id);
		$query = $this->db->get('estate_CoExistence');
		
		if( $query->num_rows() > 0 ){
			$tmp_CoExistence_details = $query->row_array();
			$CoExistence_details = array();
			$CoExistence_details['CoExistence_id'] = $tmp_CoExistence_details['id'];
			$CoExistence_details['CoExistence_title'] = $tmp_CoExistence_details['title'];
			$CoExistence_details['CoExistence_cid'] = $tmp_CoExistence_details['cid'];
			$CoExistence_details['CoExistence_description'] = $tmp_CoExistence_details['description'];
			$CoExistence_details['CoExistence_amount'] = $tmp_CoExistence_details['amount'];
			$CoExistence_details['CoExistence_status'] = $tmp_CoExistence_details['status'];
			$CoExistence_details['CoExistence_quantity'] = $tmp_CoExistence_details['quantity'];
			$CoExistence_details['CoExistence_image'] = $tmp_CoExistence_details['image'];
			$CoExistence_details['CoExistence_peso_value'] = $tmp_CoExistence_details['peso_value'];
			
			return $CoExistence_details;
		}else{
			return array();
		}
	}

	function getCoExistence($property_id=null, $user_type, $order_by, $order, $limit, $limit_by = 50, $filter) {
		
		$array_coexist = array();
		
		$additional_query = " WHERE pb.is_active='1' AND coex.corb_type = '{$filter}'";
	
   		$query = $this->db->query("	SELECT * FROM estate_coexistence AS coex 
				 					INNER JOIN  
	   								estate_plan_bundle as pb 
									ON coex.corb_id_2 = pb.id" . $additional_query);
		
		
		$data = $query->result_array();
		foreach ($data as $k => $v) {
			$corb1 = $v['corb_id_1']; // heading
			$corb2 = $v['corb_id_2'];
			
			$query2 = $this->db->query("SELECT * FROM estate_plan_bundle WHERE id=" . $corb1 . " LIMIT 1");
			$data2 = $query2->row();
			
			$headingValue[$data2->id] = $data2->name;

			$array_coexist[$v['id']]['name'] = $v['name'];
			$array_coexist[$v['id']]['coex'][$data2->id]['coexid']= $v['coex_id'];
			$array_coexist[$v['id']]['coex'][$data2->id]['name']= $data2->name;
			$array_coexist[$v['id']]['coex'][$data2->id]['is_acceptable'] = $v['is_acceptable'];
			
		}
		
		$array_coexist['headers'] = $headingValue;
		
// 		print_r($array_coexist);
		$query = $this->db->query("	SELECT FOUND_ROWS() AS 'count'");
		$array_coexist["total_count"] = $query->row()->count;
		return $array_coexist;
	}
	function addCoExistence($data)
	{
		$this->db->insert('estate_coexistence', $data);
		return;
	}
	
	function updateCoExistence($data, $CoExistence_id)
	{
		$this->db->where('id', $CoExistence_id);
		$this->db->update('estate_coexistence', $data); 
		return;
	}
	/**
	 * JEditable API
	 * @param unknown $coexist
	 * @param unknown $id
	 */
	function updateCoExistenceEditable($dataVal, $CoExistence_id) {

		$data = array('is_acceptable'=>$dataVal);
		
		$this->db->where('coex_id', $CoExistence_id);
		
		$sql = $this->db->update('estate_coexistence', $data);
		
		switch ($dataVal) {
			case "0" : $sRet = "NO"; break;
			case "1" : $sRet = "YES"; break;
		}
		
		return $sRet;
	}
	
	function deleteCoExistence($CoExistence_id){
		$CoExistence_details = $this->getCoExistenceDetails($CoExistence_id);
		
		$this->db->where('id', $CoExistence_id);
		$this->db->delete('estate_CoExistence'); 
		return $CoExistence_details;
	}
	
	
}
?>