<?php
class Model_plans extends CI_Model
{
	
	function getAllPlans() 
	{
		/*
		$query = $this->db->get('estate_plan_bundle');
		
		if( $query->num_rows() > 0 ){
			return $query->result_array();
		}else{
			return array();
		}
		*/
		
		return array();
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