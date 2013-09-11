<?php
class Model_clients extends CI_Model
{
	
	function getClients($user_type, $company_id, $order_by, $order, $limit, $limit_by=50, $filter_arr = array()) 
	{
		$additional_query = "";
		if ($filter_arr) {
			if ($filter_arr['letter']) 					{ $additional_query .= " AND title LIKE '" . $filter_arr['letter'] . "%'"; }
			if ($filter_arr['status'] == "active") 		{ $additional_query .= " AND status = 1"; }
			if ($filter_arr['status'] == "inactive")	{ $additional_query .= " AND status = 0"; }
		}
		if ($user_type < ROLE_SUPER_ADMIN) {
			$additional_query .= " AND agency_id = $company_id";
		}
		if ($order_by && $order)	{ $additional_query .= " ORDER BY $order_by $order"; }
		if ($limit_by != 'all') 	{ $additional_query .= " LIMIT $limit, $limit_by"; }
	
		if (substr($additional_query, 0, 4) == " AND") { 
			$additional_query = substr($additional_query, 4);
			$additional_query = " WHERE " . $additional_query;
		}
	
		$query = $this->db->query("	SELECT SQL_CALC_FOUND_ROWS * 
									FROM clients " . $additional_query); 
		$data = $query->result_array();
		$query = $this->db->query("	SELECT FOUND_ROWS() AS 'count'");
		$data["total_count"] = $query->row()->count;
		return $data;
	}
	
	function getAgencyClients($agency_id, $order_by, $order, $limit, $limit_by=10) 
	{
		$additional_query = "";
		if ($order_by && $order)	{ $additional_query .= " ORDER BY $order_by $order"; }
		if ($limit_by != 'all') 	{ $additional_query .= " LIMIT $limit, $limit_by"; }
		
		$query = $this->db->query("	SELECT SQL_CALC_FOUND_ROWS * 
									FROM clients 
									WHERE agency_id = $agency_id " . $additional_query);
		$data = $query->result_array();
		$query = $this->db->query("	SELECT FOUND_ROWS() AS 'count'");
		$data["total_count"] = $query->row()->count;
		return $data;
	}
	
	function getClientAgencies($client_arr)
	{
		$counter = 0;
		if ($client_arr) {
		foreach ($client_arr as $clients => $c) {
			$client_arr[$counter]['agency_details'] = $this->getClientDetails($c['agency_id']);
			$counter++;
		}
		}
		return $client_arr;
	}
	
	function getClientDetails($client_id)
	{
		$query = $this->db->query("	SELECT * 
									FROM clients
									LEFT JOIN users 
									ON clients.agent_id = users.user_id
									WHERE clients.client_id = $client_id"); 
		$client_details = $query->result_array();
		return $client_details[0];
	}
	
	function addClient($title, $title_short, $contact_name, $contact_email, $status, $folder_name, $agent_id, $agency_id, $templates_access)
	{
		if ($agent_id == 'none') { $agent_id = 0; } 
		$query = $this->db->query("	INSERT INTO clients (title, title_short, contact_name, contact_email, status, folder, agent_id, disk_space, agency_id, templates_access) 
									VALUES ('$title', '$title_short', '$contact_name', '$contact_email', $status, '$folder_name', $agent_id, '2147483648', $agency_id, $templates_access)");
		return;
	}
	
	function deleteClient($client_id) 
	{
		$query = $this->db->query("	DELETE FROM clients 
									WHERE client_id = $client_id");
		return;
	}
	
	function deactivateClient($client_id)
	{
		$query = $this->db->query("	UPDATE clients 
									SET status = 0 
									WHERE client_id = $client_id");
		return;
	}
	
	function editClient($client_id, $title, $title_short, $folder_name, $contact_name, $contact_email, $status, $agent_id, $templates_access)
	{
		if ($agent_id == 'none') { $agent_id = 0; } 
		$query = $this->db->query("	UPDATE clients 
									SET title = '$title', 
										title_short = '$title_short',
										contact_name = '$contact_name', 
										contact_email = '$contact_email', 
										folder = '$folder_name',
										status = $status,
										agent_id = $agent_id,
										templates_access = $templates_access 
									WHERE client_id = $client_id");
		return;
	}
	
	function getClientProperties($company_id)
	{
		$query = $this->db->query("	SELECT SQL_CALC_FOUND_ROWS *, 	
									templates.title AS template_title,
												properties.title AS property_title
									FROM properties									
									INNER JOIN templates
									ON properties.template_id = templates.template_id
									INNER JOIN users 
									ON properties.user_id = users.user_id
									INNER JOIN template_type 
									ON templates.template_type_id = template_type.template_type_id
									WHERE client_id = $company_id 
									LIMIT 0, 10"); 
		$data = $query->result_array();
		$query = $this->db->query("	SELECT FOUND_ROWS() AS 'count'");
		$data["total_count"] = $query->row()->count;
		return $data;
	}
	
	function deactivateUsersByClientId($client_id)
	{
		$query = $this->db->query("	UPDATE users 
									SET account_status = 0
									WHERE company_id = $client_id");
		return;
	}
	
	function updateFeatures($client_id, $features)
	{	
		// delete all features for the client first
		$query = $this->db->query("	DELETE FROM feature_client 
									WHERE client_id = $client_id");
		
		// insert features
		if ($features) {
			$seq = 1;
			foreach ($features as $feature => $f) {
				$query = $this->db->query("	INSERT INTO feature_client (feature_id, client_id, seq) 
											VALUES ($f, $client_id, $seq)");
				$seq++;
			}
		}
		return;
	}
	
	function getClientFeatures($client_id)
	{
		$query = $this->db->query("	SELECT * 
									FROM features 
									INNER JOIN feature_client 
									ON features.feature_id = feature_client.feature_id 
									WHERE feature_client.client_id = $client_id");
		return $query->result_array();
	}

}
?>