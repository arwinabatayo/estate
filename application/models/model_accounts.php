<?php
class Model_accounts extends CI_Model
{
	
	function getAllAccounts() 
	{
		/*
		$query = $this->db->get('estate_accounts');
		
		if( $query->num_rows() > 0 ){
			return $query->result_array();
		}else{
			return array();
		}
		*/
		
		return array();
	}
	
	function getAllAccounTypes()
	{
		/*
		$query = $this->db->get('estate_account_types');
		
		if( $query->num_rows() > 0 ){
			return $query->result_array();
		}else{
			return array();
		}
		*/
		
		return array();
	}
}
?>