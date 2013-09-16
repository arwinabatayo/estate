<?php
class Packageplan_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->session->set_userdata(array("gadget_id" => 1, "lockup_id" => 1));
	}

	function get_package_plan_combos($plan_id)
	{


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
									 	 estate_combos.combo_name IS NOT NULL
									 AND
										 estate_package_plan_combos.plan_id = " . $plan_id
								 );


        $result = $query->result_array();


        if(count($result) == 0) return FALSE;
        echo json_encode($result);
        
	}

	function get_package_plan_gadget_cashout($plan_id)
	{
		$lockup_id = $this->session->userdata('lockup_id');
		$gadget_id = $this->session->userdata('gadget_id');

		$query = $this->db->query(" SELECT
										cashout_val
									FROM
										estate_gadget_cash_out
									WHERE
										plan_id = " . $plan_id . "
									AND
										lockup_id = " . $lockup_id . "
									AND
										gadget_id = " . $gadget_id . "
								");

		$result = $query->result_array();

        if(count($result) == 0) return FALSE;
        echo json_encode($result);
	}
}