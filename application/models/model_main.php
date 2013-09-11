<?php
class Model_main extends CI_Model
{
	
	function getItems($table, $where = "", $order = array())
	{
		if ($order) {
		foreach ($order as $o) {
			$this->db->order_by($o['order_by'], $o['order']);
		}
		}
		
		if ($where) {
			$query = $this->db->get_where($table, $where);
		} else {
			$query = $this->db->get($table);
		}
		
		return $query->result_array();
	}
	
	function getMenuItems() 
	{
		$query = $this->db->query("	SELECT * 
									FROM menu_items
									WHERE disabled = 0
									AND display_menu = 1
									ORDER BY seq ASC");
		return $query->result_array();
	}
	
	function getMenuItemsDashboard() 
	{
		$query = $this->db->query("	SELECT * 
									FROM menu_items
									WHERE display_dashboard = 1
									ORDER BY seq ASC");
		$menu_arr = $query->result_array();
		
		return $menu_arr;
	}	
	
	function getClients($order_by, $order)
	{		
		$company_id = $this->session->userdata('company_id');
		$user_type = $this->session->userdata('user_type');
		
		if ($user_type == ROLE_SUPER_ADMIN) 
		{
			$query = $this->db->query("	SELECT * 
										FROM clients
										ORDER BY $order_by $order");
		} 
		else 
		{ 
			$query = $this->db->query("	SELECT * 
										FROM clients
										WHERE (agency_id = $company_id OR client_id = $company_id)
										ORDER BY $order_by $order");
		}
		
		return $query->result_array();
	}
	
	function getAgencies($order_by, $order)
	{		
		$query = $this->db->query("	SELECT * 
									FROM clients
									WHERE agency_id = 0 
									ORDER BY $order_by $order");
		return $query->result_array();
	}
	
	function getAgents()
	{		
		$query = $this->db->query("	SELECT * 
									FROM users
									WHERE user_type = " . ROLE_AGENT . "
									ORDER BY last_name ASC");
		return $query->result_array();
	}
	
	function getTemplates()
	{		
		$additional_query = "";
		$templates_allowed = $this->session->userdata('templates_allowed');
		if ($templates_allowed) {
		foreach ($templates_allowed as $template => $t) {
			$additional_query .= " OR templates.template_type_id = " . $t;
		}
		}
		$additional_query .= " ORDER BY title ASC";
		
		if (substr($additional_query, 0, 4) == " OR ") { 
			$additional_query = substr($additional_query, 4);
			$additional_query = " WHERE " . $additional_query;
		}
		
		$query = $this->db->query("	SELECT * 
									FROM templates
									INNER JOIN template_type
									ON templates.template_type_id = template_type.template_type_id" . $additional_query);
		return $query->result_array();
	}
	
	function getTemplateTypes()
	{		
		$additional_query = "";
		$templates_allowed = $this->session->userdata('templates_allowed');
		if ($templates_allowed) {
		foreach ($templates_allowed as $template => $t) {
			$additional_query .= " OR template_type_id = " . $t;
			// if microsite is available, mobile site should also be available
			if ($t == 1) { $additional_query .= " OR template_type_id = 2"; }
		}
		}
		
		if (substr($additional_query, 0, 4) == " OR ") { 
			$additional_query = substr($additional_query, 4);
			$additional_query = " WHERE " . $additional_query;
		}
		
		$query = $this->db->query("	SELECT * 
									FROM template_type" . $additional_query);
		return $query->result_array();
	}
	
	function getUserRoles()
	{
		$user_type = $this->session->userdata('user_type');
		
		$query = $this->db->query("	SELECT * 
									FROM user_type
									WHERE user_type_id <= $user_type
									ORDER BY user_type_id ASC");
		return $query->result_array();
	}
	
	function checkUnique($field, $value, $table)
	{
		$query = $this->db->query("	SELECT * 
									FROM $table
									WHERE LCASE($field) = '$value'");
		$count = count($query->result_array());
		return $count;
	}
	
	function checkPassword($user_id, $input_password)
	{
		$query = $this->db->query("	SELECT * 
									FROM users
									WHERE user_id = $user_id");
		$user_details = $query->result_array();
		$user_password = $user_details[0]['password'];
		$input_password = md5($input_password);

		if ($user_password == $input_password) { return 1; }
		else { return 0; }
	}
	
	function getLog($company_id, $user_type, $order_by, $order, $limit, $limit_by = 6, $filter_arr = array()) 
	{
		$additional_query = "";
		if ($user_type == ROLE_AGENCY_ADMIN) { $additional_query .= " WHERE (users.company_id = $company_id OR clients.agency_id = $company_id)"; }
		else if ($user_type != ROLE_SUPER_ADMIN) { $additional_query .= " WHERE users.company_id = $company_id"; }
		
		if ($filter_arr) {
			if ($filter_arr['client_id']) 	{ $additional_query .= " AND clients.client_id = " . $filter_arr['client_id']; }
			if ($filter_arr['user_id']) 	{ $additional_query .= " AND users.user_id = " . $filter_arr['user_id']; }
		}
		if ($order_by && $order)	{ $additional_query .= " ORDER BY $order_by $order"; }
		if ($limit_by != 'all') 	{ $additional_query .= " LIMIT $limit, $limit_by"; }

		$query = $this->db->query("	SELECT SQL_CALC_FOUND_ROWS * 
									FROM log
									INNER JOIN users 
									ON log.user_id = users.user_id
									INNER JOIN clients 
									ON users.company_id = clients.client_id" . $additional_query);			
		$data = $query->result_array();
		$query = $this->db->query("	SELECT FOUND_ROWS() AS 'count'");
		$data["total_count"] = $query->row()->count;
		return $data;
	}
	
	function getLogByUserId($user_id, $order_by, $order, $limit, $limit_by=6) 
	{
		$query = $this->db->query("	SELECT SQL_CALC_FOUND_ROWS * 
									FROM log
									INNER JOIN users 
									ON log.user_id = users.user_id
									INNER JOIN clients 
									ON users.company_id = clients.client_id
									WHERE users.user_id = $user_id
									ORDER BY $order_by $order 
									LIMIT $limit, $limit_by");	
		$data = $query->result_array();
		$query = $this->db->query("	SELECT FOUND_ROWS() AS 'count'");
		$data["total_count"] = $query->row()->count;
		return $data;
	}
	
	function addLog($log, $type, $timestamp)
	{
		$user_id = $this->session->userdata('user_id'); 
		$ip_address = getenv(REMOTE_ADDR);
		$query = $this->db->query("	INSERT INTO log (log, type, date, from_ip, user_id) 
									VALUES ('$log', '$type', '$timestamp', '$ip_address', $user_id)");	
		return;
	}
	
	function getDatabaseSize()
	{
		$query = $this->db->query("SHOW TABLE STATUS");		
		$size = 0;
		if ($query->result_array()) {
		foreach ($query->result_array() as $db_stats => $db) {
			 $size += $db["Data_length"] + $db["Index_length"];  
		}
		}
		return $size;
	}
	
	function getTableSize($table_arr)
	{
		$result_arr = array();
		$counter = 0;
		$query = $this->db->query("SHOW TABLE STATUS");
		$database_arr = $query->result_array();
		if ($database_arr) {
		foreach ($database_arr as $database_table => $dt) {
			if (in_array($dt['Name'], $table_arr)) { 
				$result_arr[$counter]['table'] = $dt['Name']; 
				$result_arr[$counter]['size'] = $dt['Data_length']; 
				$counter++;
			}
		}
		}
		return $result_arr;
	}
	
	function retrieveCount($company_id, $user_type, $table, $field)
	{
		$query = $this->db->query("	SELECT COUNT($field) 
									FROM $table");
		$result = $query->result_array();
		$result = $result[0]['COUNT('.$field.')'];
		return $result;
	}
	
	function getFeatures()
	{
		$query = $this->db->query("	SELECT * 
									FROM features 
									ORDER BY seq ASC");
		return $query->result_array();
	}	
	
	function getSimplePropertyDetails($property_id)
	{
		$query = $this->db->query("	SELECT * 
									FROM properties 
									where property_id = $property_id");
		
		if( $query->num_rows() > 0 ){
			return $query->row_array();
		}else{
			return array();
		}
	}
}
?>