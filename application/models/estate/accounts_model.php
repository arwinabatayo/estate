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
		$mobile_number = ltrim($mobile_number,0);
		
		$query = $this->db->select('a.*, c.name as account_type_name')
						 ->from('estate_accounts as a')
						 ->join('estate_account_category as c','a.category_id = c.category_id')
						 ->where('a.mobile_number', $mobile_number)
						 //lets try if leading with zero, TODO - create standard format of msisdn on table, with/without leading ZERO? -mark
						 ->or_where('a.mobile_number', '0'.$mobile_number) 
						 ->get();
						 
        $result = ($return_array === TRUE) ? $query->row_array() : $query->row();
		//$query->free_result();
		if(count($result) == 0) return FALSE;
		return $result;
	}
	
	//@int subtype_id
	function get_account_category($subtype_id)
	{

		$query = $this->db->select('*')
						 ->from('estate_account_category_subtype')
						 ->where('subtype_id', $subtype_id)
						 ->get();			 
        $result = $query->row();
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
	
	function get_account_current_plan($account_id)
	{
		$query = $this->db->select($what)
						 ->from('estate_account_current_plan')
						 ->where('account_id', $account_id)
						 ->get();
						$result = $query->row();
		if(count($result) == 0) return FALSE;
		return $result;
	}
	
	function get_eligible_numbers($account_id)
	{
		$query = $this->db->select($what)
						 ->from('estate_account_eligibility_numbers')
						 ->where('account_id', $account_id)
						 ->where('is_eligible','y')
						 ->get();
						$result = $query->result();
		if(count($result) == 0) return FALSE;
		return $result;
	}
	
	function save_account_address($data)
	{
		if( $this->db->insert('estate_account_addresses',$data) ){
			return $this->db->insert_id();
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

	function get_account_by_account_id($account_id, $what = "*")
	{
		$query = $this->db->select($what)
						  ->from("estate_accounts")
						  ->where("account_id", $account_id)
						  ->get();

		$result = $query->row_array();


		if(count($result) == 0) return FALSE;

		return $result;

	}
	
	//check mobile number if exist
	function is_msisdn_exist($msisdn)
	{
		$msisdn = ltrim($msisdn,0);
		
		$query = $this->db->select('*')
						  ->from('estate_accounts')
						  ->where('mobile_number', $msisdn)
						  ->or_where('mobile_number', '0'.$msisdn);
						  
		return $this->db->count_all_results() > 0 ? TRUE : FALSE;
	}
	
	//Get subscriber info from session
	function get_account_info()
	{
		return $this->session->userdata('subscriber_info');
	}
	
	function add_account($data)
	{
		$this->db->insert('estate_accounts', $data);
	}

	function add_account_current_plan($data)
	{
		$this->db->insert('estate_account_current_plan', $data);
	}
	
	

	
}

?>
