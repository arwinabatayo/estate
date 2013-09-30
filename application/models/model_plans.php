<?php
/**
 * 9.16.2013
 * Ultima Logic
 * robert hughes
 */
class Model_plans extends CI_Model
{
	
	function getAllPlans($is_active=2)
	{
		$this->db->order_by('disp_order', 'ASC');
		
		if( $is_active == 0 ){
			$this->db->where('is_active', 0);
			$query = $this->db->get('estate_plans');
		}elseif( $is_active == 1 ){
			$this->db->where('is_active', 1);
			$query = $this->db->get('estate_plans');
		}else{
			$query = $this->db->get('estate_plans');
		}
		
		
		if( $query->num_rows() > 0 ){
			return $query->result_array();
		}else{
			return array();
		}
	}
	
	function getPlanDetails($plan_id)
	{
		$this->db->where('id', $plan_id);
		$query = $this->db->get('estate_plans');
		
		if( $query->num_rows() > 0 ){
			$tmp_plan_details = $query->row_array();
			$plan_details = array();
			$plan_details['_id'] = $tmp_plan_details['id'];
			$plan_details['_title'] = $tmp_plan_details['title'];
			$plan_details['_cid'] = $tmp_plan_details['plan_cid'];
			$plan_details['_description'] = $tmp_plan_details['description'];
			$plan_details['_longdesc'] = $tmp_plan_details['long_desc'];
			$plan_details['_amount'] = $tmp_plan_details['amount'];
			$plan_details['_status'] = $tmp_plan_details['is_active'];
			$plan_details['_max_peso_value'] = $tmp_plan_details['max_gadget_pv'];
			$plan_details['_peso_value'] = $tmp_plan_details['total_pv'];
			
			return $plan_details; 
		}else{
			return array();
		}
	}

	function getPlans($property_id=null, $user_type, $order_by='disp_order', $order, $limit, $limit_by = 50, $filter_arr = array()) 
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
											estate_plans.id AS _id,
											estate_plans.title AS _title,
											estate_plans.description AS _description,
											estate_plans.long_desc AS _longdesc,
											estate_plans.plan_cid AS _cid,
											estate_plans.total_pv AS _pesovalue,
											estate_plans.max_gadget_pv AS _max_gadget_pv,
											estate_plans.amount AS _amount,
											estate_plans.is_active AS _status
									FROM estate_plans " . $additional_query);
		$data = $query->result_array();
		$query = $this->db->query("	SELECT FOUND_ROWS() AS 'count'");
		$data["total_count"] = $query->row()->count;
		return $data;
	}
	
	function addPlan($data)
	{
		$this->db->insert('estate_plans', $data);
		return;
	}
	
	function updatePlan($data, $plan_id)
	{
		$this->db->where('id', $plan_id);
		$this->db->update('estate_plans', $data); 
		return;
	}
	
	function deletePlans($plan_id){
		$plan_details = $this->getplanDetails($plan_id);
		
		$this->db->where('id', $plan_id);
		$this->db->delete('estate_plans'); 
		return $plan_details;
	}
	function getAllLockInPeriods()
	{
		$query = $this->db->get('estate_lockup_period');
		
		if( $query->num_rows() > 0 ){
			return $query->result_array();
		}else{
			return array();
		}
	}

	
}
?>