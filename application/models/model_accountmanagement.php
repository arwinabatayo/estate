<?php
class Model_accountmanagement extends CI_Model
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
									estate_accounts.rel_mngr_id AS rel_mngr_id, 
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
									estate_account_category.category_id AS category_id,
									estate_account_category.name AS category_name,
									estate_order_status.order_status_id AS order_status_id,
									estate_order_status.status_name AS order_status_name,
									estate_order_status.status_code AS order_status_code,
									estate_order_type.id AS order_type_id,
									estate_order_type.title AS order_type_title,
									estate_accounts.status AS status,
									estate_orders.delivery_type AS delivery_type,
									estate_orders.status_comments AS status_comments,
									estate_order_status.status_name AS order_status_title
									FROM estate_accounts 
									INNER JOIN estate_orders
									ON estate_accounts.account_id = estate_orders.account_id
									LEFT JOIN estate_order_type 
									ON estate_orders.order_type  = estate_order_type.id 
									LEFT JOIN estate_order_status 
									ON estate_order_status.order_status_id = estate_orders.status
									LEFT JOIN estate_account_category 
									ON estate_accounts.category_id = estate_account_category.category_id
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
		
		/////////////////////////////////
		if( $user_type == ROLE_AGENT_ACCESS ){
			
		}elseif( $user_type == ROLE_RELATIONSHIP_MANAGER ){
			$user_id = $this->session->userdata('user_id');
			$additional_query .= " AND estate_accounts.category_id = " . ACCOUNT_CATEGORY_PLATINUM . " ";
			$additional_query .= " AND estate_accounts.rel_mngr_id != 0 ";
			$additional_query .= " AND estate_accounts.rel_mngr_id = " . $user_id . " ";
			$additional_query .= " AND estate_orders.status = " . ORDERSTATUS_FOR_APPROVAL . " ";
		}elseif( $user_type == ROLE_ACCOUNT_MANAGER ){
			$additional_query .= " AND (estate_accounts.category_id = " . ACCOUNT_CATEGORY_BUSINESS . " ";
			$additional_query .= " OR estate_accounts.category_id = " . ACCOUNT_CATEGORY_PERSONAL . ") ";
			$additional_query .= " AND estate_accounts.rel_mngr_id = 0 ";
			$additional_query .= " AND estate_orders.status = " . ORDERSTATUS_FOR_APPROVAL . " ";
		}elseif( $user_type == ROLE_PLATINUM_QUEUE ){
			$additional_query .= " AND estate_accounts.category_id = " . ACCOUNT_CATEGORY_PLATINUM . " ";
			$additional_query .= " AND estate_accounts.rel_mngr_id = 0 ";
			$additional_query .= " AND estate_orders.status = " . ORDERSTATUS_FOR_APPROVAL . " ";
		}elseif( $user_type == ROLE_GLOBE_BUSINESS_SALES_SUPPORT_TEAM ){
			$additional_query .= " AND estate_accounts.category_id = " . ACCOUNT_CATEGORY_BUSINESS . " ";
			$additional_query .= " AND estate_accounts.rel_mngr_id = 0 ";
			$additional_query .= " AND estate_orders.status = " . ORDERSTATUS_APPROVED . " ";
		}elseif( $user_type == ROLE_ONLINE_SALES ){
			$additional_query .= " AND estate_accounts.category_id = " . ACCOUNT_CATEGORY_PERSONAL . " ";
			$additional_query .= " AND estate_accounts.rel_mngr_id = 0 ";
			$additional_query .= " AND estate_orders.status = " . ORDERSTATUS_APPROVED . " ";
		}else{ //no user_role filter
			
		}
		/////////////////////////////////
		
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
												estate_accounts.rel_mngr_id AS rel_mngr_id, 
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
												estate_account_category.category_id AS category_id,
												estate_account_category.name AS category_name,
												estate_order_status.order_status_id AS order_status_id,
												estate_order_status.status_name AS order_status_name,
												estate_order_status.status_code AS order_status_code,
												estate_order_type.id AS order_type_id,
												estate_order_type.title AS order_type_title,
												estate_accounts.status AS status,
												estate_orders.delivery_type AS delivery_type,
												estate_orders.status_comments AS status_comments,
												estate_order_status.status_name AS order_status_title
												FROM estate_accounts 
												INNER JOIN estate_orders
												ON estate_accounts.account_id = estate_orders.account_id
												LEFT JOIN estate_order_type 
												ON estate_orders.order_type  = estate_order_type.id 
												LEFT JOIN estate_order_status 
												ON estate_order_status.order_status_id = estate_orders.status 
												LEFT JOIN estate_account_category 
												ON estate_accounts.category_id = estate_account_category.category_id " . $additional_query);
		}elseif( $user_type == ROLE_RELATIONSHIP_MANAGER ){
			$query = $this->db->query("	SELECT 	SQL_CALC_FOUND_ROWS *, 
												estate_accounts.account_id AS account_id, 
												estate_orders.order_number AS order_number, 
												estate_accounts.category_id AS category_id, 
												estate_accounts.category_subtype_id AS category_subtype_id, 
												estate_accounts.rel_mngr_id AS rel_mngr_id, 
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
												estate_account_category.category_id AS category_id,
												estate_account_category.name AS category_name,
												estate_order_status.order_status_id AS order_status_id,
												estate_order_status.status_name AS order_status_name,
												estate_order_status.status_code AS order_status_code,
												estate_order_type.id AS order_type_id,
												estate_order_type.title AS order_type_title,
												estate_accounts.status AS status,
												estate_orders.delivery_type AS delivery_type,
												estate_orders.status_comments AS status_comments,
												estate_order_status.status_name AS order_status_title
												FROM estate_accounts 
												INNER JOIN estate_orders
												ON estate_accounts.account_id = estate_orders.account_id
												LEFT JOIN estate_order_type 
												ON estate_orders.order_type  = estate_order_type.id 
												LEFT JOIN estate_order_status 
												ON estate_order_status.order_status_id = estate_orders.status 
												LEFT JOIN estate_account_category 
												ON estate_accounts.category_id = estate_account_category.category_id " . $additional_query);
		}elseif( $user_type == ROLE_ACCOUNT_MANAGER ){
			$query = $this->db->query("	SELECT 	SQL_CALC_FOUND_ROWS *, 
												estate_accounts.account_id AS account_id, 
												estate_orders.order_number AS order_number, 
												estate_accounts.category_id AS category_id, 
												estate_accounts.category_subtype_id AS category_subtype_id, 
												estate_accounts.rel_mngr_id AS rel_mngr_id, 
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
												estate_account_category.category_id AS category_id,
												estate_account_category.name AS category_name,
												estate_order_status.order_status_id AS order_status_id,
												estate_order_status.status_name AS order_status_name,
												estate_order_status.status_code AS order_status_code,
												estate_order_type.id AS order_type_id,
												estate_order_type.title AS order_type_title,
												estate_accounts.status AS status,
												estate_orders.delivery_type AS delivery_type,
												estate_orders.status_comments AS status_comments,
												estate_order_status.status_name AS order_status_title
												FROM estate_accounts 
												INNER JOIN estate_orders
												ON estate_accounts.account_id = estate_orders.account_id
												LEFT JOIN estate_order_type 
												ON estate_orders.order_type  = estate_order_type.id 
												LEFT JOIN estate_order_status 
												ON estate_order_status.order_status_id = estate_orders.status 
												LEFT JOIN estate_account_category 
												ON estate_accounts.category_id = estate_account_category.category_id " . $additional_query);
		}elseif( $user_type == ROLE_PLATINUM_QUEUE ){
			$query = $this->db->query("	SELECT 	SQL_CALC_FOUND_ROWS *, 
												estate_accounts.account_id AS account_id, 
												estate_orders.order_number AS order_number, 
												estate_accounts.category_id AS category_id, 
												estate_accounts.category_subtype_id AS category_subtype_id, 
												estate_accounts.rel_mngr_id AS rel_mngr_id, 
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
												estate_account_category.category_id AS category_id,
												estate_account_category.name AS category_name,
												estate_order_status.order_status_id AS order_status_id,
												estate_order_status.status_name AS order_status_name,
												estate_order_status.status_code AS order_status_code,
												estate_order_type.id AS order_type_id,
												estate_order_type.title AS order_type_title,
												estate_accounts.status AS status,
												estate_orders.delivery_type AS delivery_type,
												estate_orders.status_comments AS status_comments,
												estate_order_status.status_name AS order_status_title
												FROM estate_accounts 
												INNER JOIN estate_orders
												ON estate_accounts.account_id = estate_orders.account_id
												LEFT JOIN estate_order_type 
												ON estate_orders.order_type  = estate_order_type.id 
												LEFT JOIN estate_order_status 
												ON estate_order_status.order_status_id = estate_orders.status 
												LEFT JOIN estate_account_category 
												ON estate_accounts.category_id = estate_account_category.category_id " . $additional_query);
		}elseif( $user_type == ROLE_GLOBE_BUSINESS_SALES_SUPPORT_TEAM ){
			$query = $this->db->query("	SELECT 	SQL_CALC_FOUND_ROWS *, 
												estate_accounts.account_id AS account_id, 
												estate_orders.order_number AS order_number, 
												estate_accounts.category_id AS category_id, 
												estate_accounts.category_subtype_id AS category_subtype_id, 
												estate_accounts.rel_mngr_id AS rel_mngr_id, 
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
												estate_account_category.category_id AS category_id,
												estate_account_category.name AS category_name,
												estate_order_status.order_status_id AS order_status_id,
												estate_order_status.status_name AS order_status_name,
												estate_order_status.status_code AS order_status_code,
												estate_order_type.id AS order_type_id,
												estate_order_type.title AS order_type_title,
												estate_accounts.status AS status,
												estate_orders.delivery_type AS delivery_type,
												estate_orders.status_comments AS status_comments,
												estate_order_status.status_name AS order_status_title
												FROM estate_accounts 
												INNER JOIN estate_orders
												ON estate_accounts.account_id = estate_orders.account_id
												LEFT JOIN estate_order_type 
												ON estate_orders.order_type  = estate_order_type.id 
												LEFT JOIN estate_order_status 
												ON estate_order_status.order_status_id = estate_orders.status 
												LEFT JOIN estate_account_category 
												ON estate_accounts.category_id = estate_account_category.category_id " . $additional_query);
		}elseif( $user_type == ROLE_ONLINE_SALES ){
			$query = $this->db->query("	SELECT 	SQL_CALC_FOUND_ROWS *, 
												estate_accounts.account_id AS account_id, 
												estate_orders.order_number AS order_number, 
												estate_accounts.category_id AS category_id, 
												estate_accounts.category_subtype_id AS category_subtype_id, 
												estate_accounts.rel_mngr_id AS rel_mngr_id, 
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
												estate_account_category.category_id AS category_id,
												estate_account_category.name AS category_name,
												estate_order_status.order_status_id AS order_status_id,
												estate_order_status.status_name AS order_status_name,
												estate_order_status.status_code AS order_status_code,
												estate_order_type.id AS order_type_id,
												estate_order_type.title AS order_type_title,
												estate_accounts.status AS status,
												estate_orders.delivery_type AS delivery_type,
												estate_orders.status_comments AS status_comments,
												estate_order_status.status_name AS order_status_title
												FROM estate_accounts 
												INNER JOIN estate_orders
												ON estate_accounts.account_id = estate_orders.account_id
												LEFT JOIN estate_order_type 
												ON estate_orders.order_type  = estate_order_type.id 
												LEFT JOIN estate_order_status 
												ON estate_order_status.order_status_id = estate_orders.status 
												LEFT JOIN estate_account_category 
												ON estate_accounts.category_id = estate_account_category.category_id " . $additional_query);
		}else{ //no user_role filter
			$query = $this->db->query("	SELECT 	SQL_CALC_FOUND_ROWS *, 
												estate_accounts.account_id AS account_id, 
												estate_orders.order_number AS order_number, 
												estate_accounts.category_id AS category_id, 
												estate_accounts.category_subtype_id AS category_subtype_id, 
												estate_accounts.rel_mngr_id AS rel_mngr_id, 
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
												estate_account_category.category_id AS category_id,
												estate_account_category.name AS category_name,
												estate_order_status.order_status_id AS order_status_id,
												estate_order_status.status_name AS order_status_name,
												estate_order_status.status_code AS order_status_code,
												estate_order_type.id AS order_type_id,
												estate_order_type.title AS order_type_title,
												estate_accounts.status AS status,
												estate_orders.delivery_type AS delivery_type,
												estate_orders.status_comments AS status_comments,
												estate_order_status.status_name AS order_status_title
												FROM estate_accounts 
												INNER JOIN estate_orders
												ON estate_accounts.account_id = estate_orders.account_id
												LEFT JOIN estate_order_type 
												ON estate_orders.order_type  = estate_order_type.id 
												LEFT JOIN estate_order_status 
												ON estate_order_status.order_status_id = estate_orders.status 
												LEFT JOIN estate_account_category 
												ON estate_accounts.category_id = estate_account_category.category_id " . $additional_query);
		}
									
									
		$data = $query->result_array();
		$query = $this->db->query("	SELECT FOUND_ROWS() AS 'count'");
		$data["total_count"] = $query->row()->count;
		return $data;
	}
	
	function getOrderStatuses()
	{
		$this->db->where('is_active', 1);
		$query = $this->db->get('estate_order_status');
		
		if( $query->num_rows() > 0 ){
			return $query->result_array();
		}else{
			return array();
		}
	}
	
	function getOrderTypes()
	{
		$this->db->where('status', 1);
		$query = $this->db->get('estate_order_type');
		
		if( $query->num_rows() > 0 ){
			return $query->result_array();
		}else{
			return array();
		}
	}
	
	function getRelationshipManagers($status=null)
	{
		if( $status == 1 ){
			$this->db->where('account_status', 1);
			$this->db->where('user_type', ROLE_RELATIONSHIP_MANAGER);
			$query = $this->db->get('users');
			
			if( $query->num_rows() > 0 ){
				return $query->result_array();
			}else{
				return array();
			}
		}elseif( $status == 0 ){
			$this->db->where('account_status', 0);
			$this->db->where('user_type', ROLE_RELATIONSHIP_MANAGER);
			$query = $this->db->get('users');
			
			if( $query->num_rows() > 0 ){
				return $query->result_array();
			}else{
				return array();
			}
		}elseif( $status == null ){
			$this->db->where('user_type', ROLE_RELATIONSHIP_MANAGER);
			$query = $this->db->get('users');
			
			if( $query->num_rows() > 0 ){
				return $query->result_array();
			}else{
				return array();
			}
		}else{
			$this->db->where('user_type', ROLE_RELATIONSHIP_MANAGER);
			$query = $this->db->get('users');
			
			if( $query->num_rows() > 0 ){
				return $query->result_array();
			}else{
				return array();
			}
		}
	}
	
	function updateAccountRelationshipManager($account_id, $relationship_manager_id)
	{
		$data = array(
		   'rel_mngr_id' => $relationship_manager_id
		);
		
		$this->db->where('account_id', $account_id);
		$this->db->update('estate_accounts', $data);  
		
		return;
	}
	
	function updateOrderStatus($order_number, $status, $comments)
	{
		$data = array(
		   'status' => $status,
		   'status_comments' => $comments
		);

		$this->db->where('order_number', $order_number);
		$this->db->update('estate_orders', $data);
	}
}
?>