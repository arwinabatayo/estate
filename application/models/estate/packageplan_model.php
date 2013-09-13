<?php
class Packageplan_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function get_package_plan_combos($plan_id)
	{
	
		//$query = $this->db->get('estate_package_plan_combos');

		$query = $this->db->query(" SELECT 
										estate_combos.combo_name, 
										estate_combos.combo_desc, 
										estate_combos.required_pv,
										estate_combos.combo_type 
									 FROM 
										 estate_package_plan_combos
									 LEFT JOIN
										 estate_combos
									 ON
										 estate_combos.combo_id = estate_package_plan_combos.combo_id
									 WHERE
										 estate_combos.is_active = '1'
									 AND
										 estate_package_plan_combos.plan_id = " . $plan_id
								 );



        $result = $query->result_array();

        //echo $this->db->_error_message();
        if(count($result) == 0) return FALSE;
        return $result;
	}
}