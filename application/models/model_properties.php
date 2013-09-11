<?php
class Model_properties extends CI_Model
{
	
	function getProperties($company_id, $user_type, $order_by, $order, $limit, $limit_by = 50, $filter_arr = array()) 
	{
		$additional_query = "";
		if ($user_type == ROLE_AGENCY_ADMIN) { $additional_query .= " WHERE (properties.client_id = $company_id OR clients.agency_id = $company_id)"; }
		else if ($user_type != ROLE_SUPER_ADMIN) { $additional_query .= " WHERE properties.client_id = $company_id"; }
		
		if ($filter_arr) {
			if ($filter_arr['client_id']) 		{ $additional_query .= " AND clients.client_id = " . $filter_arr['client_id']; }
			if ($filter_arr['letter']) 			{ $additional_query .= " AND properties.title LIKE '" . $filter_arr['letter'] . "%'"; }
			if ($filter_arr['template_id']) 	{ $additional_query .= " AND templates.template_id = " . $filter_arr['template_id']; }
			if ($filter_arr['template_type']) 	{ $additional_query .= " AND template_type.template_type_id = " . $filter_arr['template_type']; }
			if ($filter_arr['user_id']) 		{ $additional_query .= " AND properties.user_id = " . $filter_arr['user_id']; }
		}
		if ($order_by && $order)	{ $additional_query .= " ORDER BY $order_by $order"; }
		if ($limit_by != 'all') 	{ $additional_query .= " LIMIT $limit, $limit_by"; }
	
		$query = $this->db->query("	SELECT 	SQL_CALC_FOUND_ROWS *, 	
											clients.title AS client_title, 
											clients.title_short AS client_title_short, 
											properties.title AS property_title,
											templates.title AS template_title,
											properties.last_edit AS property_last_edit 
									FROM properties 
									INNER JOIN users 
									ON properties.user_id = users.user_id
									INNER JOIN clients
									ON properties.client_id = clients.client_id
									INNER JOIN templates
									ON properties.template_id = templates.template_id
									INNER JOIN template_type 
									ON templates.template_type_id = template_type.template_type_id" . $additional_query);
		$data = $query->result_array();
		$query = $this->db->query("	SELECT FOUND_ROWS() AS 'count'");
		$data["total_count"] = $query->row()->count;
		return $data;
	}
	
	function getPropertiesByUserId($user_id, $order_by, $order, $limit, $limit_by = 50) 
	{
		$query = $this->db->query("	SELECT SQL_CALC_FOUND_ROWS *, 	
											clients.title AS client_title, 
											clients.title_short AS client_title_short, 
											properties.title AS property_title,
											templates.title AS template_title,
											properties.last_edit AS property_last_edit 
									FROM properties 
									INNER JOIN users 
									ON properties.user_id = users.user_id
									INNER JOIN clients
									ON properties.client_id = clients.client_id
									INNER JOIN templates
									ON properties.template_id = templates.template_id
									INNER JOIN template_type 
									ON templates.template_type_id = template_type.template_type_id
									WHERE properties.user_id = $user_id
									ORDER BY $order_by $order
									LIMIT $limit, $limit_by"); 
		$data = $query->result_array();
		$query = $this->db->query("	SELECT FOUND_ROWS() AS 'count'");
		$data["total_count"] = $query->row()->count;
		return $data;
	}
	
	function getPropertyDetails($property_id)
	{
		$query = $this->db->query("	SELECT *, 	clients.title AS client_title, 
												properties.title AS property_title,
												properties.description AS property_description,
												templates.title AS template_title,
												properties.last_edit AS property_last_edit 
									FROM properties 
									INNER JOIN users 
									ON properties.user_id = users.user_id
									INNER JOIN clients
									ON properties.client_id = clients.client_id
									INNER JOIN templates
									ON properties.template_id = templates.template_id
									INNER JOIN template_type 
									ON templates.template_type_id = template_type.template_type_id
									WHERE property_id = $property_id");
		$property_details = $query->result_array();
		return $property_details[0];
	}
	
	function addProperty(	$client_id, 
							$template_id, 
							$title, 
							$folder_name, 
							$user_id, 
							$last_edit, 
							$description)
	{
		$query = $this->db->query("	INSERT INTO properties (client_id, template_id, title, folder_name, user_id, last_edit, description) 
									VALUES ($client_id, $template_id, '$title', '$folder_name', $user_id, '$last_edit', '$description')");
		return $this->db->insert_id();
	}
	
	function editProperty(	$property_id,
							$client_id, 
							$template_id, 
							$title, 
							$folder_name, 
							$user_id, 
							$last_edit, 
							$description)
	{
		$query = $this->db->query("	UPDATE properties 
									SET template_id = $template_id, 
										client_id = $client_id, 
										title = '$title', 
										folder_name = '$folder_name', 
										user_id = $user_id, 
										last_edit = '$last_edit', 
										description = '$description' 
									WHERE property_id = $property_id");
		return;
	}
	
	function deleteProperty($property_id)
	{
		$query = $this->db->query("	DELETE FROM properties 
									WHERE property_id = $property_id");
		return;
	}
	
}
?>