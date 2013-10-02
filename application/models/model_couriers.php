<?php
/**
 * 9.16.2013
 * Ultima Logic
 * robert hughes
 */
class Model_couriers extends CI_Model
{
	
	function getAllCouriers()
	{

		$this->db->where('delete_flag', 'n');
		$query = $this->db->get('estate_shipping_couriers');
	
		if( $query->num_rows() > 0 ) {
			return $query->result_array();
		} else {
			return array();
		}
	}

}
?>