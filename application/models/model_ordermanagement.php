<?php
class Model_ordermanagement extends CI_Model
{
	function getOrderDetails($account_id, $order_number)
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
									estate_order_status.status_name AS order_status_title, 
									estate_account_plan.main_plan_id AS account_main_plan_id, 
									estate_account_plan.date_created AS account_plan_date_created, 
									estate_account_plan.account_plan_status AS account_plan_status, 
									estate_main_plan.title AS main_plan_title, 
									estate_main_plan.description AS main_plan_description, 
									estate_main_plan.image AS main_plan_image, 
									estate_main_plan.created AS main_plan_created 
									FROM estate_accounts 
									INNER JOIN estate_orders 
									ON estate_accounts.account_id = estate_orders.account_id 
									LEFT JOIN estate_order_type 
									ON estate_orders.order_type  = estate_order_type.id 
									LEFT JOIN estate_order_status 
									ON estate_order_status.order_status_id = estate_orders.status 
									LEFT JOIN estate_account_category 
									ON estate_accounts.category_id = estate_account_category.category_id 
									LEFT JOIN estate_account_plan 
									ON estate_accounts.account_id = estate_account_plan.account_id 
									LEFT JOIN estate_main_plan 
									ON estate_main_plan.main_plan_id = estate_account_plan.main_plan_id 
									WHERE estate_accounts.account_id = $account_id 
									AND estate_orders.account_id = $account_id 
									AND estate_orders.order_number = $order_number");
		$order_details = $query->result_array();
		$order_details = $order_details[0];
		return $order_details;
	}
	
	function getOrders($user_type, $order_by, $order, $limit, $limit_by=50, $filter_arr = array())
	{
		$additional_query = "";
		$additional_query .= " WHERE estate_accounts.account_id != 'null' ";
		
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
		
		if ($filter_arr) {
			if ($filter_arr['order_number']){
				$additional_query .= " AND estate_orders.order_number LIKE '%" . $filter_arr['order_number'] . "%' "; 
			}
			if ($filter_arr['order_type']){
				$additional_query .= " AND estate_order_type.id = " . $filter_arr['order_type'] . " "; 
			}
			if ($filter_arr['date_ordered']){
				$additional_query .= " AND estate_orders.date_ordered = '" . $filter_arr['date_ordered'] . "' "; 
			}
			if ($filter_arr['date_shipped']){
				$additional_query .= " AND estate_orders.date_shipped = '" . $filter_arr['date_shipped'] . "' "; 
			}
			if ( isset($filter_arr['order_status']) ){
				$additional_query .= " AND estate_orders.status = " . $filter_arr['order_status'] . " "; 
			}
			if ( isset($filter_arr['delivery_type']) ){
				$additional_query .= " AND LOWER(estate_orders.delivery_type) = '" . $filter_arr['delivery_type'] . "' "; 
			}
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
												estate_orders.tracking_id AS tracking_id,
												estate_orders.shipping_courier AS courier,
												estate_orders.IMEI AS IMEI,
												estate_orders.sim_serial AS sim_serial, 
												estate_orders.status_comments AS status_comments, 
												estate_order_status.status_name AS order_status_title, 
												estate_account_plan.main_plan_id AS account_main_plan_id, 
												estate_account_plan.date_created AS account_plan_date_created, 
												estate_account_plan.account_plan_status AS account_plan_status, 
												estate_main_plan.title AS main_plan_title, 
												estate_main_plan.description AS main_plan_description, 
												estate_main_plan.image AS main_plan_image, 
												estate_main_plan.created AS main_plan_created 
												FROM estate_accounts 
												INNER JOIN estate_orders 
												ON estate_accounts.account_id = estate_orders.account_id 
												LEFT JOIN estate_order_type 
												ON estate_orders.order_type  = estate_order_type.id 
												LEFT JOIN estate_order_status 
												ON estate_order_status.order_status_id = estate_orders.status 
												LEFT JOIN estate_account_category 
												ON estate_accounts.category_id = estate_account_category.category_id 
												LEFT JOIN estate_account_plan 
												ON estate_accounts.account_id = estate_account_plan.account_id 
												LEFT JOIN estate_main_plan 
												ON estate_main_plan.main_plan_id = estate_account_plan.main_plan_id " . $additional_query);
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
												estate_orders.tracking_id AS tracking_id,
												estate_orders.shipping_courier AS courier,
												estate_orders.IMEI AS IMEI,
												estate_orders.sim_serial AS sim_serial,
												estate_orders.status_comments AS status_comments, 
												estate_order_status.status_name AS order_status_title, 
												estate_account_plan.main_plan_id AS account_main_plan_id, 
												estate_account_plan.date_created AS account_plan_date_created, 
												estate_account_plan.account_plan_status AS account_plan_status, 
												estate_main_plan.title AS main_plan_title, 
												estate_main_plan.description AS main_plan_description, 
												estate_main_plan.image AS main_plan_image, 
												estate_main_plan.created AS main_plan_created 
												FROM estate_accounts 
												INNER JOIN estate_orders 
												ON estate_accounts.account_id = estate_orders.account_id 
												LEFT JOIN estate_order_type 
												ON estate_orders.order_type  = estate_order_type.id 
												LEFT JOIN estate_order_status 
												ON estate_order_status.order_status_id = estate_orders.status 
												LEFT JOIN estate_account_category 
												ON estate_accounts.category_id = estate_account_category.category_id 
												LEFT JOIN estate_account_plan 
												ON estate_accounts.account_id = estate_account_plan.account_id 
												LEFT JOIN estate_main_plan 
												ON estate_main_plan.main_plan_id = estate_account_plan.main_plan_id " . $additional_query);
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
												estate_orders.tracking_id AS tracking_id,
												estate_orders.shipping_courier AS courier,
												estate_orders.IMEI AS IMEI,
												estate_orders.sim_serial AS sim_serial, 
												estate_orders.status_comments AS status_comments, 
												estate_order_status.status_name AS order_status_title, 
												estate_account_plan.main_plan_id AS account_main_plan_id, 
												estate_account_plan.date_created AS account_plan_date_created, 
												estate_account_plan.account_plan_status AS account_plan_status, 
												estate_main_plan.title AS main_plan_title, 
												estate_main_plan.description AS main_plan_description, 
												estate_main_plan.image AS main_plan_image, 
												estate_main_plan.created AS main_plan_created 
												FROM estate_accounts 
												INNER JOIN estate_orders 
												ON estate_accounts.account_id = estate_orders.account_id 
												LEFT JOIN estate_order_type 
												ON estate_orders.order_type  = estate_order_type.id 
												LEFT JOIN estate_order_status 
												ON estate_order_status.order_status_id = estate_orders.status 
												LEFT JOIN estate_account_category 
												ON estate_accounts.category_id = estate_account_category.category_id 
												LEFT JOIN estate_account_plan 
												ON estate_accounts.account_id = estate_account_plan.account_id 
												LEFT JOIN estate_main_plan 
												ON estate_main_plan.main_plan_id = estate_account_plan.main_plan_id " . $additional_query);
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
												estate_orders.tracking_id AS tracking_id,
												estate_orders.shipping_courier AS courier,
												estate_orders.IMEI AS IMEI,
												estate_orders.sim_serial AS sim_serial, 
												estate_orders.status_comments AS status_comments, 
												estate_order_status.status_name AS order_status_title, 
												estate_account_plan.main_plan_id AS account_main_plan_id, 
												estate_account_plan.date_created AS account_plan_date_created, 
												estate_account_plan.account_plan_status AS account_plan_status, 
												estate_main_plan.title AS main_plan_title, 
												estate_main_plan.description AS main_plan_description, 
												estate_main_plan.image AS main_plan_image, 
												estate_main_plan.created AS main_plan_created 
												FROM estate_accounts 
												INNER JOIN estate_orders 
												ON estate_accounts.account_id = estate_orders.account_id 
												LEFT JOIN estate_order_type 
												ON estate_orders.order_type  = estate_order_type.id 
												LEFT JOIN estate_order_status 
												ON estate_order_status.order_status_id = estate_orders.status 
												LEFT JOIN estate_account_category 
												ON estate_accounts.category_id = estate_account_category.category_id 
												LEFT JOIN estate_account_plan 
												ON estate_accounts.account_id = estate_account_plan.account_id 
												LEFT JOIN estate_main_plan 
												ON estate_main_plan.main_plan_id = estate_account_plan.main_plan_id " . $additional_query);
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
												estate_orders.tracking_id AS tracking_id,
												estate_orders.shipping_courier AS courier,
												estate_orders.IMEI AS IMEI,
												estate_orders.sim_serial AS sim_serial, 
												estate_orders.status_comments AS status_comments, 
												estate_order_status.status_name AS order_status_title, 
												estate_account_plan.main_plan_id AS account_main_plan_id, 
												estate_account_plan.date_created AS account_plan_date_created, 
												estate_account_plan.account_plan_status AS account_plan_status, 
												estate_main_plan.title AS main_plan_title, 
												estate_main_plan.description AS main_plan_description, 
												estate_main_plan.image AS main_plan_image, 
												estate_main_plan.created AS main_plan_created 
												FROM estate_accounts 
												INNER JOIN estate_orders 
												ON estate_accounts.account_id = estate_orders.account_id 
												LEFT JOIN estate_order_type 
												ON estate_orders.order_type  = estate_order_type.id 
												LEFT JOIN estate_order_status 
												ON estate_order_status.order_status_id = estate_orders.status 
												LEFT JOIN estate_account_category 
												ON estate_accounts.category_id = estate_account_category.category_id 
												LEFT JOIN estate_account_plan 
												ON estate_accounts.account_id = estate_account_plan.account_id 
												LEFT JOIN estate_main_plan 
												ON estate_main_plan.main_plan_id = estate_account_plan.main_plan_id " . $additional_query);
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
												estate_orders.tracking_id AS tracking_id,
												estate_orders.shipping_courier AS courier,
												estate_orders.IMEI AS IMEI,
												estate_orders.sim_serial AS sim_serial, 
												estate_orders.status_comments AS status_comments, 
												estate_order_status.status_name AS order_status_title, 
												estate_account_plan.main_plan_id AS account_main_plan_id, 
												estate_account_plan.date_created AS account_plan_date_created, 
												estate_account_plan.account_plan_status AS account_plan_status, 
												estate_main_plan.title AS main_plan_title, 
												estate_main_plan.description AS main_plan_description, 
												estate_main_plan.image AS main_plan_image, 
												estate_main_plan.created AS main_plan_created 
												FROM estate_accounts 
												INNER JOIN estate_orders 
												ON estate_accounts.account_id = estate_orders.account_id 
												LEFT JOIN estate_order_type 
												ON estate_orders.order_type  = estate_order_type.id 
												LEFT JOIN estate_order_status 
												ON estate_order_status.order_status_id = estate_orders.status 
												LEFT JOIN estate_account_category 
												ON estate_accounts.category_id = estate_account_category.category_id 
												LEFT JOIN estate_account_plan 
												ON estate_accounts.account_id = estate_account_plan.account_id 
												LEFT JOIN estate_main_plan 
												ON estate_main_plan.main_plan_id = estate_account_plan.main_plan_id " . $additional_query);
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
												estate_orders.tracking_id AS tracking_id,
												estate_orders.shipping_courier AS courier,
												estate_orders.IMEI AS IMEI,
												estate_orders.sim_serial AS sim_serial, 
												estate_orders.status_comments AS status_comments, 
												estate_order_status.status_name AS order_status_title, 
												estate_account_plan.main_plan_id AS account_main_plan_id, 
												estate_account_plan.date_created AS account_plan_date_created, 
												estate_account_plan.account_plan_status AS account_plan_status, 
												estate_main_plan.title AS main_plan_title, 
												estate_main_plan.description AS main_plan_description, 
												estate_main_plan.image AS main_plan_image, 
												estate_main_plan.created AS main_plan_created 
												FROM estate_accounts 
												INNER JOIN estate_orders 
												ON estate_accounts.account_id = estate_orders.account_id 
												LEFT JOIN estate_order_type 
												ON estate_orders.order_type  = estate_order_type.id 
												LEFT JOIN estate_order_status 
												ON estate_order_status.order_status_id = estate_orders.status 
												LEFT JOIN estate_account_category 
												ON estate_accounts.category_id = estate_account_category.category_id 
												LEFT JOIN estate_account_plan 
												ON estate_accounts.account_id = estate_account_plan.account_id 
												LEFT JOIN estate_main_plan 
												ON estate_main_plan.main_plan_id = estate_account_plan.main_plan_id " . $additional_query);
		}
									
									
		$data = $query->result_array();
		$query = $this->db->query("	SELECT FOUND_ROWS() AS 'count'");
		$data["total_count"] = $query->row()->count;
		return $data;
	}
	
	function mark_order_as_done($account_id, $order_number)
	{
		$data = array(
		   'status' => ORDERSTATUS_DONE,
		   'status_comments' => 'done'
		);

		$this->db->where('order_number', $order_number);
		$this->db->update('estate_orders', $data);
	}
	
	function getOrderAddressByType($address_type, $order_number)
	{
		$this->db->where('order_number', $order_number);
		$query = $this->db->get('estate_orders');
		
		if( $query->num_rows() > 0 ){
			$order_details = $query->row_array();
			
			if( $address_type == 'billing' ){
				$address_id = $order_details['billing_address_id'];
			}else{
				$address_id = $order_details['shipping_address_id'];
			}
			
			$this->db->where('id', $address_id);
			$query = $this->db->get('estate_account_addresses');
			
			if( $query->num_rows() > 0 ){
				return $query->row_array();
			}else{
				return array();
			}
		}else{
			return array();
		}
	}

	function updateShippingDetails($account_id, $order_number, $data)
	{
		$this->db->where('order_number', $order_number)
				->where('account_id', $account_id)
				->update('estate_orders', $data);
	}
}
?>