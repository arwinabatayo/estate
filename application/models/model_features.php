<?php
class Model_features extends CI_Model
{

	function getFeatures() 
	{
		$query = $this->db->query("	SELECT * 
									FROM front_features");
		return $query->result_array();
	}
	
	function getBenefits() 
	{
		$query = $this->db->query("	SELECT * 
									FROM front_benefits");
		return $query->result_array();
	}
	
}
?>