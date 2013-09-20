<?php
class Model_packageplans extends CI_Model
{

	function getPackagePlans($plan_id = NULL)
	{
		$where = "";
		if(!empty($plan_id)){
			$where = " WHERE id = " . $plan_id;
		}

		$query = $this->db->query(" SELECT
								*
							FROM
								estate_package_plans
							" . $where
							);

		$result = $query->result_array();
		if(!empty($plan_id)){
			$result["total_count"] = $query->row()->count;
		}

		if(count($result) == 0) return array();

		return $result;
	}


	function getFilterPlans($property_id=null, $user_type, $order_by='disp_order', $order, $limit, $limit_by = 50, $filter_arr = array()) 
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
											estate_package_plans.id AS _id,
											estate_package_plans.title AS _title,
											estate_package_plans.description AS _description,
											estate_package_plans.long_desc AS _longdesc,
											estate_package_plans.plan_cid AS _cid,
											estate_package_plans.total_pv AS _pesovalue,
											estate_package_plans.max_gadget_pv AS _max_gadget_pv,
											estate_package_plans.amount AS _amount,
											estate_package_plans.is_active AS _status
									FROM estate_plans " . $additional_query);
		$data = $query->result_array();
		$query = $this->db->query("	SELECT FOUND_ROWS() AS 'count'");
		$data["total_count"] = $query->row()->count;
		return $data;
	}


	function getCombos()
	{
		$query = $this->db->query(" SELECT
								*
							FROM
								estate_package_plan_bundle
							WHERE
								bundle_type_id = 2
							"
							);

		$result = $query->result_array();

		if(count($result) == 0) return array();

		return $result;
	}

	function getPackagePlanDetails($plan_id = NULL)
	{
		if(empty($plan_id)) return FALSE;

		$query = $this->db->query(" SELECT 
										* 
									FROM
										estate_package_plan_combos
									JOIN
										estate_package_plan_bundle
									ON
										estate_package_plan_combos.combo_id = estate_package_plan_bundle.id
									WHERE
										estate_package_plan_combos.plan_id = " . $plan_id . "
									AND
										estate_package_plan_combos.is_active = 1"
							);

		$result = $query->result_array();

		if(count($result) == 0) return array();

		return $result;
	}

	function updatePackagePlans($data)
	{


		$query = $this->db->query(" SELECT
										*
									FROM
										estate_package_plan_combos
									WHERE
										plan_id = " . $data['plan_id']
				);


		$result = $query->result_array();

		//echo "<pre>";var_dump($result); exit;
		foreach($data['combo_ids'] as $key_result => $value_result){

			$sql = $this->db->query(" SELECT
											*
									  FROM
											estate_package_plan_combos
									  WHERE
											plan_id = " . $data['plan_id'] . "
										AND
											combo_id = " . $data['combo_ids'][$key_result]
				);

			$res = $sql->result_array();

			

			if(count($res) != 0){
				$package_data = array("is_active" => 1);
				$where = "plan_id = " . $data['plan_id'] . " AND combo_id = " . $data['combo_ids'][$key_result];

				$this->db->update('estate_package_plan_combos', $package_data, $where);
			}else{

				$data_combo = array('plan_id' => $data['plan_id'], 'combo_id' => $data['combo_ids'][$key_result], 'is_active' => 1);

				$this->db->insert('estate_package_plan_combos', $data_combo);
			}
		}

		foreach ($result as $key => $value) {
			if(!in_array($result[$key]['combo_id'], $data['combo_ids'])){
				$package_data = array("is_active" => 0);
				$update_data = "combo_id = " . $result[$key]['combo_id'] . " AND plan_id = " . $result[$key]['plan_id'];
				
				$this->db->update('estate_package_plan_combos', $package_data, $update_data);
			}
		}


		//update package plan
		if($data['status'] == "enabled"){
			$package_status = array("is_active" => 1);
		}else if($data['status'] == "disabled"){
			$package_status = array("is_active" => 0);
		}
		$this->db->update('estate_package_plans', $package_status, "id = " . $data['plan_id']);

	}


	function deletePackagePlan($package_id){
		$package_details = $this->getPackagePlanDetails($package_id);
		
		$this->db->where('id', $package_id);
		$this->db->delete('estate_package_plans');

		$this->db->where('plan_id', $package_id);
		$this->db->delete('estate_package_plan_combos'); 

		return $package_details;
	}

}
