<?php
class Model_accounts extends CI_Model
{
	function getAllAccounts() 
	{
		/*
		$query = $this->db->get('estate_accounts');
		
		if( $query->num_rows() > 0 ){
			return $query->result_array();
		}else{
			return array();
		}
		*/
		
		return array();
	}
	
	function getAllAccountCategories()
	{
		/*
		$query = $this->db->get('estate_account_categories');
		
		if( $query->num_rows() > 0 ){
			return $query->result_array();
		}else{
			return array();
		}
		*/
		
		return array();
	}
	
	function getAccountDetails($account_id, $order_number)
	{
		$query = $this->db->query("	SELECT * ,
									estate_accounts.account_id AS account_id, 
									estate_orders.order_number AS order_number, 
									estate_accounts.category_id AS category_id, 
									estate_accounts.category_subtype_id AS category_subtype_id, 
									estate_accounts.rm_id AS rm_id, 
									estate_accounts.name AS name,
									estate_accounts.middle AS middle,
									estate_accounts.surname AS surname,
									estate_accounts.email AS email,
									estate_accounts.mobile_number AS mobile_number,
									estate_accounts.billing_address_id AS billing_address_id,
									estate_accounts.lockin_duration AS lockin_duration,
									estate_accounts.outstanding_balance AS outstanding_balance,
									estate_accounts.due_date AS due_date,
									estate_accounts.credit_limit AS credit_limit,
									estate_accounts.status AS status
									FROM estate_accounts 
									INNER JOIN estate_orders
									ON estate_accounts.account_id = estate_orders.account_id
									WHERE estate_accounts.account_id = $account_id 
									AND estate_orders.account_id = $account_id 
									AND estate_orders.order_number = $order_number");
		$account_details = $query->result_array();
		$account_details = $account_details[0];
		return $account_details;
	}
	
	function getAccounts($user_type, $order_by, $order, $limit, $limit_by=50, $filter_arr = array())
	{
		$additional_query = "";
		$additional_query .= " WHERE estate_accounts.account_id != 'null' ";

		if ($filter_arr) {
			if ($filter_arr['account_number']) 				{ $additional_query .= " AND estate_accounts.account_id LIKE '%" . $filter_arr['account_number'] . "%'"; }
		}
		if ($order_by && $order)	{ $additional_query .= " ORDER BY $order_by $order"; }
		if ($limit_by != 'all') 	{ $additional_query .= " LIMIT $limit, $limit_by"; }
		
		if( $user_type == ROLE_AGENT_ACCESS ){
			$query = $this->db->query("	SELECT 	SQL_CALC_FOUND_ROWS *, 
												estate_accounts.account_id AS account_id, 
												estate_orders.order_number AS order_number, 
												estate_accounts.category_id AS category_id, 
												estate_accounts.category_subtype_id AS category_subtype_id, 
												estate_accounts.rm_id AS rm_id, 
												estate_accounts.name AS name,
												estate_accounts.middle AS middle,
												estate_accounts.surname AS surname,
												estate_accounts.email AS email,
												estate_accounts.mobile_number AS mobile_number,
												estate_accounts.billing_address_id AS billing_address_id,
												estate_accounts.lockin_duration AS lockin_duration,
												estate_accounts.outstanding_balance AS outstanding_balance,
												estate_accounts.due_date AS due_date,
												estate_accounts.credit_limit AS credit_limit,
												estate_accounts.status AS status
										FROM estate_accounts 
										INNER JOIN estate_orders 
										ON estate_accounts.account_id = estate_orders.account_id " . $additional_query);
		}elseif( $user_type == ROLE_RELATIONSHIP_MANAGER ){
			$query = $this->db->query("	SELECT 	SQL_CALC_FOUND_ROWS *, 
												estate_accounts.account_id AS account_id, 
												estate_orders.order_number AS order_number, 
												estate_accounts.category_id AS category_id, 
												estate_accounts.category_subtype_id AS category_subtype_id, 
												estate_accounts.rm_id AS rm_id, 
												estate_accounts.name AS name,
												estate_accounts.middle AS middle,
												estate_accounts.surname AS surname,
												estate_accounts.email AS email,
												estate_accounts.mobile_number AS mobile_number,
												estate_accounts.billing_address_id AS billing_address_id,
												estate_accounts.lockin_duration AS lockin_duration,
												estate_accounts.outstanding_balance AS outstanding_balance,
												estate_accounts.due_date AS due_date,
												estate_accounts.credit_limit AS credit_limit,
												estate_accounts.status AS status
										FROM estate_accounts 
										INNER JOIN estate_orders 
										ON estate_accounts.account_id = estate_orders.account_id " . $additional_query);
		}elseif( $user_type == ROLE_ACCOUNT_MANAGER ){
			$query = $this->db->query("	SELECT 	SQL_CALC_FOUND_ROWS *, 
												estate_accounts.account_id AS account_id, 
												estate_orders.order_number AS order_number, 
												estate_accounts.category_id AS category_id, 
												estate_accounts.category_subtype_id AS category_subtype_id, 
												estate_accounts.rm_id AS rm_id, 
												estate_accounts.name AS name,
												estate_accounts.middle AS middle,
												estate_accounts.surname AS surname,
												estate_accounts.email AS email,
												estate_accounts.mobile_number AS mobile_number,
												estate_accounts.billing_address_id AS billing_address_id,
												estate_accounts.lockin_duration AS lockin_duration,
												estate_accounts.outstanding_balance AS outstanding_balance,
												estate_accounts.due_date AS due_date,
												estate_accounts.credit_limit AS credit_limit,
												estate_accounts.status AS status
										FROM estate_accounts 
										INNER JOIN estate_orders 
										ON estate_accounts.account_id = estate_orders.account_id " . $additional_query);
		}elseif( $user_type == ROLE_PLATINUM_QUEUE ){
			$query = $this->db->query("	SELECT 	SQL_CALC_FOUND_ROWS *, 
												estate_accounts.account_id AS account_id, 
												estate_orders.order_number AS order_number, 
												estate_accounts.category_id AS category_id, 
												estate_accounts.category_subtype_id AS category_subtype_id, 
												estate_accounts.rm_id AS rm_id, 
												estate_accounts.name AS name,
												estate_accounts.middle AS middle,
												estate_accounts.surname AS surname,
												estate_accounts.email AS email,
												estate_accounts.mobile_number AS mobile_number,
												estate_accounts.billing_address_id AS billing_address_id,
												estate_accounts.lockin_duration AS lockin_duration,
												estate_accounts.outstanding_balance AS outstanding_balance,
												estate_accounts.due_date AS due_date,
												estate_accounts.credit_limit AS credit_limit,
												estate_accounts.status AS status
										FROM estate_accounts 
										INNER JOIN estate_orders 
										ON estate_accounts.account_id = estate_orders.account_id " . $additional_query);
		}elseif( $user_type == ROLE_GLOBE_BUSINESS_SALES_SUPPORT_TEAM ){
			$query = $this->db->query("	SELECT 	SQL_CALC_FOUND_ROWS *, 
												estate_accounts.account_id AS account_id, 
												estate_orders.order_number AS order_number, 
												estate_accounts.category_id AS category_id, 
												estate_accounts.category_subtype_id AS category_subtype_id, 
												estate_accounts.rm_id AS rm_id, 
												estate_accounts.name AS name,
												estate_accounts.middle AS middle,
												estate_accounts.surname AS surname,
												estate_accounts.email AS email,
												estate_accounts.mobile_number AS mobile_number,
												estate_accounts.billing_address_id AS billing_address_id,
												estate_accounts.lockin_duration AS lockin_duration,
												estate_accounts.outstanding_balance AS outstanding_balance,
												estate_accounts.due_date AS due_date,
												estate_accounts.credit_limit AS credit_limit,
												estate_accounts.status AS status
										FROM estate_accounts 
										INNER JOIN estate_orders 
										ON estate_accounts.account_id = estate_orders.account_id " . $additional_query);
		}elseif( $user_type == ROLE_ONLINE_SALES ){
			$query = $this->db->query("	SELECT 	SQL_CALC_FOUND_ROWS *, 
												estate_accounts.account_id AS account_id, 
												estate_orders.order_number AS order_number, 
												estate_accounts.category_id AS category_id, 
												estate_accounts.category_subtype_id AS category_subtype_id, 
												estate_accounts.rm_id AS rm_id, 
												estate_accounts.name AS name,
												estate_accounts.middle AS middle,
												estate_accounts.surname AS surname,
												estate_accounts.email AS email,
												estate_accounts.mobile_number AS mobile_number,
												estate_accounts.billing_address_id AS billing_address_id,
												estate_accounts.lockin_duration AS lockin_duration,
												estate_accounts.outstanding_balance AS outstanding_balance,
												estate_accounts.due_date AS due_date,
												estate_accounts.credit_limit AS credit_limit,
												estate_accounts.status AS status
										FROM estate_accounts 
										INNER JOIN estate_orders 
										ON estate_accounts.account_id = estate_orders.account_id " . $additional_query);
		}else{ //no user_role filter
			$query = $this->db->query("	SELECT 	SQL_CALC_FOUND_ROWS *, 
												estate_accounts.account_id AS account_id, 
												estate_orders.order_number AS order_number, 
												estate_accounts.category_id AS category_id, 
												estate_accounts.category_subtype_id AS category_subtype_id, 
												estate_accounts.rm_id AS rm_id, 
												estate_accounts.name AS name,
												estate_accounts.middle AS middle,
												estate_accounts.surname AS surname,
												estate_accounts.email AS email,
												estate_accounts.mobile_number AS mobile_number,
												estate_accounts.billing_address_id AS billing_address_id,
												estate_accounts.lockin_duration AS lockin_duration,
												estate_accounts.outstanding_balance AS outstanding_balance,
												estate_accounts.due_date AS due_date,
												estate_accounts.credit_limit AS credit_limit,
												estate_accounts.status AS status
										FROM estate_accounts 
										INNER JOIN estate_orders 
										ON estate_accounts.account_id = estate_orders.account_id " . $additional_query);
		}
									
									
		$data = $query->result_array();
		$query = $this->db->query("	SELECT FOUND_ROWS() AS 'count'");
		$data["total_count"] = $query->row()->count;
		return $data;
	}
}
?>