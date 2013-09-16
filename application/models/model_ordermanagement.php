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
	
	function mark_order_as_done($account_id, $order_number)
	{
		$data = array(
		   'status' => ORDERSTATUS_DONE,
		   'status_comments' => 'done'
		);

		$this->db->where('order_number', $order_number);
		$this->db->update('estate_orders', $data);
	}
}
?>