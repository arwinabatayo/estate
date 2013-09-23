<?php
class Packageplan_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->session->set_userdata(array("gadget_id" => 1, "lockup_id" => 1));
	}

	function get_package_plan_combos($plan_id, $from_cart = false)
	{


		$query = $this->db->query(" SELECT 
										estate_package_plan_bundle.name, 
										estate_package_plan_bundle.description, 
										estate_package_plan_bundle.peso_value,
										estate_package_plan_bundle.category 
									 FROM 
										 estate_package_plan_combos
									 LEFT JOIN
										 estate_package_plan_bundle
									 ON
										 estate_package_plan_bundle.id = estate_package_plan_combos.combo_id
									 WHERE
										 estate_package_plan_bundle.is_active = '1'
									 AND
									 	 estate_package_plan_bundle.bundle_type_id = 2
									 AND
										 estate_package_plan_combos.plan_id = " . $plan_id
								 );


        $result = $query->result_array();




        if(count($result) == 0) return FALSE;

        if(!$from_cart){
        	echo json_encode($result);
        }else{
        	return $result;
        }
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