<?php
class Model_users extends CI_Model
{

	function login($username, $password)
	{
		$query = $this->db->query("	SELECT * 
									FROM users
									WHERE username = '$username' 
									AND password = '$password'");
		$user_details = $query->result_array();
		$user_details = $user_details[0];
		
		if ($user_details) { return $user_details; }
		else { return null; }
	}
	
	function getUserDetails($username) 
	{
		$query = $this->db->query("	SELECT * 
									FROM users
									WHERE username = '$username'");
		$user_details = $query->result_array();
		$user_details = $user_details[0];
		return $user_details;
	}
	
	function getUserDetailsByUserId($user_id) 
	{
		$query = $this->db->query("	SELECT *, user_type.title AS user_type_title, clients.title AS company
									FROM users
									INNER JOIN user_type 
									ON users.user_type = user_type.user_type_id
									INNER JOIN clients 
									ON users.company_id = clients.client_id 
									WHERE users.user_id = $user_id");
		$user_details = $query->result_array();
		$user_details = $user_details[0];
		return $user_details;
	}
	
	function getUserDetailsByUsername($username) 
	{
		$query = $this->db->query("	SELECT *, user_type.title AS user_type_title, clients.title AS company
									FROM users
									INNER JOIN user_type 
									ON users.user_type = user_type.user_type_id
									INNER JOIN clients 
									ON users.company_id = clients.client_id 
									WHERE users.username = '$username'");
		$user_details = $query->result_array();
		$user_details = $user_details[0];
		return $user_details;
	}
	
	function getUserDetailsByToken($token) 
	{
		$query = $this->db->query("	SELECT *, user_type.title AS user_type_title, clients.title AS company
									FROM users
									INNER JOIN user_type 
									ON users.user_type = user_type.user_type_id
									INNER JOIN clients 
									ON users.company_id = clients.client_id 
									WHERE users.token = '$token'");
		$user_details = $query->result_array();
		$user_details = $user_details[0];
		return $user_details;
	}
	
	function getUsersByClientId($company_id, $user_type, $order_by, $order, $limit, $limit_by=5)
	{
		$additional_query = "";
		if ($order_by && $order)	{ $additional_query .= " ORDER BY $order_by $order"; }
		if ($limit_by != 'all') 	{ $additional_query .= " LIMIT $limit, $limit_by"; }
		$query = $this->db->query("	SELECT 	SQL_CALC_FOUND_ROWS *, 
											user_type.title AS user_type_title, 
											clients.title AS client_title,
											clients.title_short AS client_title_short
									FROM users
									INNER JOIN user_type 
									ON users.user_type = user_type.user_type_id
									INNER JOIN clients 
									ON users.company_id = clients.client_id 
									WHERE users.company_id = $company_id" . $additional_query);
		$data = $query->result_array();
		$query = $this->db->query("	SELECT FOUND_ROWS() AS 'count'");
		$data["total_count"] = $query->row()->count;
		return $data;
	}
	
	function getUsers($company_id, $user_type, $order_by, $order, $limit, $limit_by=50, $filter_arr = array())
	{
		$additional_query = "";
		if ($user_type == ROLE_AGENCY_ADMIN) { $additional_query .= " WHERE (users.company_id = $company_id OR clients.agency_id = $company_id)"; }
		else if ($user_type != ROLE_SUPER_ADMIN) { $additional_query .= " WHERE users.company_id = $company_id"; }

		if ($filter_arr) {
			if ($filter_arr['last_name']) 				{ $additional_query .= " AND users.last_name LIKE '" . $filter_arr['last_name'] . "%'"; }
			if ($filter_arr['first_name']) 				{ $additional_query .= " AND users.first_name LIKE '" . $filter_arr['first_name'] . "%'"; }
			if ($filter_arr['username']) 				{ $additional_query .= " AND users.username LIKE '" . $filter_arr['username'] . "%'"; }
			if ($filter_arr['client_id']) 				{ $additional_query .= " AND users.company_id = " . $filter_arr['client_id']; }
			if ($filter_arr['user_type_id']) 			{ $additional_query .= " AND users.user_type = " . $filter_arr['user_type_id']; }
			if ($filter_arr['status'] == "active") 		{ $additional_query .= " AND users.account_status = 1"; }
			if ($filter_arr['status'] == "inactive")	{ $additional_query .= " AND users.account_status = 0"; }
		}
		if ($order_by && $order)	{ $additional_query .= " ORDER BY $order_by $order"; }
		if ($limit_by != 'all') 	{ $additional_query .= " LIMIT $limit, $limit_by"; }
		
		$query = $this->db->query("	SELECT 	SQL_CALC_FOUND_ROWS *, 
											user_type.title AS user_type_title, 
											clients.title AS company_title,
											clients.title_short AS company_title_short
									FROM users 
									INNER JOIN user_type 
									ON users.user_type = user_type.user_type_id
									INNER JOIN clients 
									ON users.company_id = clients.client_id" . $additional_query);
		$data = $query->result_array();
		$query = $this->db->query("	SELECT FOUND_ROWS() AS 'count'");
		$data["total_count"] = $query->row()->count;
		return $data;
	}
	
	function addUser($username, $last_login, $member_since, $user_type, $first_name, $last_name, $client_id)
	{
		$ip_address = getenv(REMOTE_ADDR);
		$query = $this->db->query("	INSERT INTO users (account_status, username, password, last_login, last_login_ip, member_since, user_type, first_name, last_name, company_id)
									VALUES (1, '$username', '', '$last_login', '$ip_address', '$member_since', $user_type, '$first_name', '$last_name', $client_id)");
		$new_user_id = mysql_insert_id();
		return $new_user_id;
	}
	
	function editUser($user_id, $user_type, $first_name, $last_name, $username, $status)
	{
		$new_password = md5($new_password);
		$query = $this->db->query("	UPDATE users SET 	user_type = $user_type, 
														first_name = '$first_name',
														last_name = '$last_name',
														username = '$username',
														account_status = $status
									WHERE user_id = $user_id");
		return;
	}
	
	function editAccount($user_id, $first_name, $last_name, $new_password="")
	{
		if ($new_password) {
			$query = $this->db->query("	UPDATE users SET 	first_name = '$first_name',
															last_name = '$last_name',
															password = '$new_password'
										WHERE user_id = $user_id");
		} else {
			$query = $this->db->query("	UPDATE users SET 	first_name = '$first_name',
															last_name = '$last_name'
										WHERE user_id = $user_id");
		}

		return;
	}
	
	function deactivateUser($user_id)
	{
		$query = $this->db->query("	UPDATE users 
									SET account_status = 0 
									WHERE user_id = $user_id");
		return;
	}
	
	function updateLastLogin($user_id, $last_login)
	{
		$ip_address = getenv(REMOTE_ADDR);
		$query = $this->db->query("	UPDATE users 
									SET last_login = '$last_login', 
										last_login_ip = '$ip_address'
									WHERE user_id = $user_id");
		return;
	}
	
	function resetPassword($user_id, $new_password)
	{
		$query = $this->db->query("	UPDATE users 
									SET password = '$new_password' 
									WHERE user_id = $user_id");
		return;	
	}
	
	function deleteUser($user_id)
	{
		$query = $this->db->query("	DELETE FROM users 
									WHERE user_id = $user_id");
		return;	
	}
	
	function updateToken($user_id, $token)
	{
		$query = $this->db->query("	UPDATE users 
									SET token = '$token' 
									WHERE user_id = $user_id");
		return;	
	}	
	
}
?>