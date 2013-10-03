<?php

class Managers_model extends CI_Model
{
	function get_manager_info($user_id, $return_array = TRUE, $what = '*')
	{
		$this->db->trans_start();
		$query = $this->db->select($what)
						 ->from('users')
						 ->where('user_id', $user_id)
						 ->get();
                $result = ($return_array === TRUE) ? $query->row_array() : $query->row();
		
		if(count($result) == 0) return FALSE;
		return $result;
	}	
	function get_manager_email_receivers($category_id, $return_array = TRUE, $what = '*')
	{
		$this->db->trans_start();
		$query = $this->db->select($what)
						 ->from('users')
						 ->where('category_id', $category_id)
						 ->where('mail_receiver', 1)
						 ->get();
                $result = ($return_array === TRUE) ? $query->row_array() : $query->row();
		
		if(count($result) == 0) return FALSE;
		return $result;
	}	
}

?>
