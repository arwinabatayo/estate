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
								estate_plans
							" . $where
							);

		$result = $query->result_array();
		$result["total_count"] = $query->row()->count;

		if(count($result) == 0) return array();

		return $result;
	}

	function getCombos()
	{
		$query = $this->db->query(" SELECT
								*
							FROM
								estate_plan_bundle
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
										estate_plan_bundle
									ON
										estate_package_plan_combos.combo_id = estate_plan_bundle.id
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


	}
}