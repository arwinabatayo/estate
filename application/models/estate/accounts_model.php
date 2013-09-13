<?php

class Accounts_model extends CI_Model
{

	/**
	 * Get the Account Information by id.
	 *
	 * @param  string  mobile_number(required) - mobile number from globe or msisdn
	 * @param  string  return_array (optional)  - TRUE (return in array format) : FALSE (return in object format)
	 * @param  string  what (optional) - specify the fields needed
	 * @return mixed 
	 */
	function get_account_info_by_id($mobile_number, $return_array = TRUE, $what = '*')
	{
		$this->db->trans_start();
		$query = $this->db->select($what)
						 ->from('estate_accounts')
						 ->where('mobile_number', $mobile_number)
						 ->get();
                $result = ($return_array === TRUE) ? $query->row_array() : $query->row();
		//$query->free_result();
		if(count($result) == 0) return FALSE;
		return $result;
	}
	
	/**
	 * Get the account address by account_id and address_type.
	 *
	 * @param  string  $account_id(required)
	 * @param  string  $address_type(optional) - (billing or shipping)
	 * @param  string  what (optional) - specify the fields needed
	 * @return mixed 
	 */
	function get_account_address($account_id, $address_type='billing', $return_array = TRUE, $what = '*')
	{
		$query = $this->db->select($what)
						 ->from('estate_account_addresses')
						 ->where('address_type', $address_type)
						 ->where('account_id', $account_id)
						 ->get();
                $result = ($return_array === TRUE) ? $query->row_array() : $query->row();
		if(count($result) == 0) return FALSE;
		return $result;
	}
	
	function save_account_address($data)
	{
		if( $this->db->insert('estate_account_addresses',$data) ){
			return TRUE;
		}else{
			return $this->db->_error_message(); 
		}
		
	}
	
	function save_personal_info($data)
	{
		if( $this->db->insert('estate_account_personal_information',$data) ){
			return TRUE;
		}else{
			return $this->db->_error_message(); 
		}
		
	}
	
	

	
}

?>
