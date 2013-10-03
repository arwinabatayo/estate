<?php

class Switch_model extends CI_Model
{
	function get_switch($code, $return_array = TRUE, $what = '*')
	{
		$this->db->trans_start();
		$query = $this->db->select($what)
						 ->from('estate_toggle_offered_switches')
						 ->where('code', $code)
						 ->get();
                $result = ($return_array === TRUE) ? $query->row_array() : $query->row();
		
		if(count($result) == 0) return FALSE;
		return $result;
	}	
}

?>
