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
						 ->from('t_accounts')
						 ->where('f_mobile_number', $mobile_number)
						 ->get();
                $result = ($return_array === TRUE) ? $query->row_array() : $query->row();
		//$query->free_result();
		if(count($result) == 0) return FALSE;
		return $result;
	}
	
	function foo(){
		echo 'BAR';
	}

	
}

?>
