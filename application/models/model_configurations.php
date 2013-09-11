<?php
class Model_configurations extends CI_Model
{
	
	function getConfigurations($property_id, $user_type, $order_by, $order, $limit, $limit_by = 50, $filter_arr = array()) 
	{
		$additional_query = "";
		$additional_query .= " WHERE configurations.property_id = $property_id";
		
		if ($filter_arr) {
			if ($filter_arr['letter']) 			{ $additional_query .= " AND configurations.label LIKE '" . $filter_arr['letter'] . "%'"; }
		}
		if ($order_by && $order)	{ $additional_query .= " ORDER BY $order_by $order"; }
		if ($limit_by != 'all') 	{ $additional_query .= " LIMIT $limit, $limit_by"; }
	
		$query = $this->db->query("	SELECT 	SQL_CALC_FOUND_ROWS *,
											configurations.configuration_id AS configuration_id,
											configurations.property_id AS configuration_property_id,
											configurations.label AS configuration_label,
											configurations.status AS configuration_status 
									FROM configurations " . $additional_query);
		$data = $query->result_array();
		$query = $this->db->query("	SELECT FOUND_ROWS() AS 'count'");
		$data["total_count"] = $query->row()->count;
		return $data;
	}
	
	function addConfiguration($property_id, $configuration_label, $configuration_status)
	{
		$data = array(
		   'property_id' 	=> $property_id,
		   'label' 			=> $configuration_label,
		   'status' 		=> $configuration_status
		);

		$this->db->insert('configurations', $data); 
		return;
	}
	
	function editConfiguration($configuration_id, $configuration_label, $configuration_status)
	{
		$data = array(
		   'label' 			=> $configuration_label,
		   'status' 		=> $configuration_status
		);

		$this->db->where('configuration_id', $configuration_id);
		$this->db->update('configurations', $data); 
		return;
	}
	
	function getConfigurationDetails($configuration_id)
	{
		$this->db->where('configuration_id', $configuration_id);
		$query = $this->db->get('configurations');
		
		if( $query->num_rows() > 0 ){
			return $query->row_array();
		}else{
			return array();
		}
	}
	
	function deleteConfiguration($configuration_id){
		$this->db->where('configuration_id', $configuration_id);
		$this->db->delete('configurations'); 
		return;
	}
}
?>
	