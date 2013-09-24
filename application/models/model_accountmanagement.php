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
	
	function getAccountCategoriesByUserType($user_type=null)
	{
		if( $user_type == null ){
			return array();
		}else{
			if( $user_type == ROLE_ONLINE_SALES ){ //online sales/order manager
				$this->db->where('category_id', ACCOUNT_CATEGORY_PERSONAL);
				$query1 = $this->db->get('estate_account_category');
				$account_categories = array();
				
				if( $query1->num_rows() > 0 ){
					foreach( $query1->result_array() as $category ){
						$tmp_category_id1 = $category['category_id'];
						$tmp_category_name1 = $category['name'];
						
						$this->db->where('category_id', $tmp_category_id1);
						$query2 = $this->db->get('estate_account_category_subtype');
						
						if( $query2->num_rows() > 0 ){
							foreach( $query2->result_array() as $subcategory ){
								$tmp_category_id2 = $subcategory['subtype_id'];
								$tmp_category_name2 = $subcategory['subtype_desc'];
								
								$account_categories[] = array(
									'type'		=> 'sub',
									'id' 		=> $tmp_category_id1,
									'subid' 	=> $tmp_category_id2,
									'name' 		=> $tmp_category_name2
								);
							}
						}else{
							$account_categories[] = array(
								'type'		=> 'main',
								'id' 		=> $tmp_category_id1,
								'subid' 	=> null,
								'name' 		=> $tmp_category_name1
							);
						}
					}
					
					return $account_categories;
				}else{
					return array();
				}
			}elseif( $user_type == ROLE_GLOBE_BUSINESS_SALES_SUPPORT_TEAM ){ //gbsst
				$this->db->where('category_id', ACCOUNT_CATEGORY_BUSINESS);
				$query1 = $this->db->get('estate_account_category');
				$account_categories = array();
				
				if( $query1->num_rows() > 0 ){
					foreach( $query1->result_array() as $category ){
						$tmp_category_id1 = $category['category_id'];
						$tmp_category_name1 = $category['name'];
						
						$this->db->where('category_id', $tmp_category_id1);
						$query2 = $this->db->get('estate_account_category_subtype');
						
						if( $query2->num_rows() > 0 ){
							foreach( $query2->result_array() as $subcategory ){
								$tmp_category_id2 = $subcategory['subtype_id'];
								$tmp_category_name2 = $subcategory['subtype_desc'];
								
								$account_categories[] = array(
									'type'		=> 'sub',
									'id' 		=> $tmp_category_id1,
									'subid' 	=> $tmp_category_id2,
									'name' 		=> $tmp_category_name2
								);
							}
						}else{
							$account_categories[] = array(
								'type'		=> 'main',
								'id' 		=> $tmp_category_id1,
								'subid' 	=> null,
								'name' 		=> $tmp_category_name1
							);
						}
					}
					
					return $account_categories;
				}else{
					return array();
				}
			}elseif( $user_type == ROLE_PLATINUM_QUEUE ){ //platinum queue
				$this->db->where('category_id', ACCOUNT_CATEGORY_PLATINUM);
				$query1 = $this->db->get('estate_account_category');
				$account_categories = array();
				
				if( $query1->num_rows() > 0 ){
					foreach( $query1->result_array() as $category ){
						$tmp_category_id1 = $category['category_id'];
						$tmp_category_name1 = $category['name'];
						
						$this->db->where('category_id', $tmp_category_id1);
						$query2 = $this->db->get('estate_account_category_subtype');
						
						if( $query2->num_rows() > 0 ){
							foreach( $query2->result_array() as $subcategory ){
								$tmp_category_id2 = $subcategory['subtype_id'];
								$tmp_category_name2 = $subcategory['subtype_desc'];
								
								$account_categories[] = array(
									'type'		=> 'sub',
									'id' 		=> $tmp_category_id1,
									'subid' 	=> $tmp_category_id2,
									'name' 		=> $tmp_category_name2
								);
							}
						}else{
							$account_categories[] = array(
								'type'		=> 'main',
								'id' 		=> $tmp_category_id1,
								'subid' 	=> null,
								'name' 		=> $tmp_category_name1
							);
						}
					}
					
					return $account_categories;
				}else{
					return array();
				}
			}elseif( $user_type == ROLE_ACCOUNT_MANAGER ){ //account manager
				$this->db->where('category_id', ACCOUNT_CATEGORY_BUSINESS);
				$this->db->or_where('category_id', ACCOUNT_CATEGORY_PERSONAL); 
				$query1 = $this->db->get('estate_account_category');
				$account_categories = array();
				
				if( $query1->num_rows() > 0 ){
					foreach( $query1->result_array() as $category ){
						$tmp_category_id1 = $category['category_id'];
						$tmp_category_name1 = $category['name'];
						
						$this->db->where('category_id', $tmp_category_id1);
						$query2 = $this->db->get('estate_account_category_subtype');
						
						if( $query2->num_rows() > 0 ){
							foreach( $query2->result_array() as $subcategory ){
								$tmp_category_id2 = $subcategory['subtype_id'];
								$tmp_category_name2 = $subcategory['subtype_desc'];
								
								$account_categories[] = array(
									'type'		=> 'sub',
									'id' 		=> $tmp_category_id1,
									'subid' 	=> $tmp_category_id2,
									'name' 		=> $tmp_category_name2
								);
							}
						}else{
							$account_categories[] = array(
								'type'		=> 'main',
								'id' 		=> $tmp_category_id1,
								'subid' 	=> null,
								'name' 		=> $tmp_category_name1
							);
						}
					}
					
					return $account_categories;
				}else{
					return array();
				}
			}elseif( $user_type == ROLE_RELATIONSHIP_MANAGER ){ //relationship manager
				$this->db->where('category_id', ACCOUNT_CATEGORY_PLATINUM);
				$query1 = $this->db->get('estate_account_category');
				$account_categories = array();
				
				if( $query1->num_rows() > 0 ){
					foreach( $query1->result_array() as $category ){
						$tmp_category_id1 = $category['category_id'];
						$tmp_category_name1 = $category['name'];
						
						$this->db->where('category_id', $tmp_category_id1);
						$query2 = $this->db->get('estate_account_category_subtype');
						
						if( $query2->num_rows() > 0 ){
							foreach( $query2->result_array() as $subcategory ){
								$tmp_category_id2 = $subcategory['subtype_id'];
								$tmp_category_name2 = $subcategory['subtype_desc'];
								
								$account_categories[] = array(
									'type'		=> 'sub',
									'id' 		=> $tmp_category_id1,
									'subid' 	=> $tmp_category_id2,
									'name' 		=> $tmp_category_name2
								);
							}
						}else{
							$account_categories[] = array(
								'type'		=> 'main',
								'id' 		=> $tmp_category_id1,
								'subid' 	=> null,
								'name' 		=> $tmp_category_name1
							);
						}
					}
					
					return $account_categories;
				}else{
					return array();
				}
			}elseif( $user_type == ROLE_AGENT_ACCESS ){ //agent access
				$query1 = $this->db->get('estate_account_category');
				$account_categories = array();
				
				if( $query1->num_rows() > 0 ){
					foreach( $query1->result_array() as $category ){
						$tmp_category_id1 = $category['category_id'];
						$tmp_category_name1 = $category['name'];
						
						$this->db->where('category_id', $tmp_category_id1);
						$query2 = $this->db->get('estate_account_category_subtype');
						
						if( $query2->num_rows() > 0 ){
							foreach( $query2->result_array() as $subcategory ){
								$tmp_category_id2 = $subcategory['subtype_id'];
								$tmp_category_name2 = $subcategory['subtype_desc'];
								
								$account_categories[] = array(
									'type'		=> 'sub',
									'id' 		=> $tmp_category_id1,
									'subid' 	=> $tmp_category_id2,
									'name' 		=> $tmp_category_name2
								);
							}
						}else{
							$account_categories[] = array(
								'type'		=> 'main',
								'id' 		=> $tmp_category_id1,
								'subid' 	=> null,
								'name' 		=> $tmp_category_name1
							);
						}
					}
					
					return $account_categories;
				}else{
					return array();
				}
			}else{
				return array();
			}
		}
	}
	
	function getAllAccountCategories()
	{
		$query1 = $this->db->get('estate_account_category');
		$account_categories = array();
		
		if( $query1->num_rows() > 0 ){
			foreach( $query1->result_array() as $category ){
				$tmp_category_id1 = $category['category_id'];
				$tmp_category_name1 = $category['name'];
				
				$this->db->where('category_id', $tmp_category_id1);
				$query2 = $this->db->get('estate_account_category_subtype');
				
				if( $query2->num_rows() > 0 ){
					foreach( $query2->result_array() as $subcategory ){
						$tmp_category_id2 = $subcategory['subtype_id'];
						$tmp_category_name2 = $subcategory['subtype_desc'];
						
						$account_categories[] = array(
							'type'		=> 'sub',
							'id' 		=> $tmp_category_id1,
							'subid' 	=> $tmp_category_id2,
							'name' 		=> $tmp_category_name2
						);
					}
				}else{
					$account_categories[] = array(
						'type'		=> 'main',
						'id' 		=> $tmp_category_id1,
						'subid' 	=> null,
						'name' 		=> $tmp_category_name1
					);
				}
			}
			
			return $account_categories;
		}else{
			return array();
		}
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
		$account_details = $query->result_array();
		$account_details = $account_details[0];
		return $account_details;
	}
	
	function getAccounts($user_type, $order_by, $order, $limit, $limit_by=50, $filter_arr = array())
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
			if ($filter_arr['account_id']){
				$additional_query .= " AND estate_accounts.account_id LIKE '%" . $filter_arr['account_id'] . "%' "; 
			}
			if ($filter_arr['mobile_number']){
				$additional_query .= " AND estate_accounts.mobile_number LIKE '%" . $filter_arr['mobile_number'] . "%' "; 
			}
			if ($filter_arr['order_type']){
				$additional_query .= " AND estate_order_type.id = " . $filter_arr['order_type'] . " "; 
			}
			if ($filter_arr['name']){
				$additional_query .= " AND estate_accounts.name LIKE '%" . $filter_arr['name'] . "%' "; 
			}
			if ($filter_arr['lastname']){
				$additional_query .= " AND estate_accounts.surname LIKE '%" . $filter_arr['lastname'] . "%' "; 
			}
			if ($filter_arr['account_category']){
				//check if main account category or sub category
				$needle = '_';
				$pos = strpos($filter_arr['account_category'], $needle);
				if($pos !== false){ //subcategory
					$arr_account_category = explode('_', $filter_arr['account_category']);
					$main_cat = 0;
					$sub_cat = 0;
					if( isset($arr_account_category[0]) ){ $main_cat = $arr_account_category[0]; }
					if( isset($arr_account_category[1]) ){ $sub_cat = $arr_account_category[1]; }
					
					$additional_query .= " AND estate_accounts.category_id = " . $main_cat . " "; 
					$additional_query .= " AND estate_accounts.category_subtype_id = " . $sub_cat . " "; 
				}else{ //main category
					$additional_query .= " AND estate_accounts.category_id = " . $filter_arr['account_category'] . " "; 
				}
			}
			if ($filter_arr['due_date']){
				$additional_query .= " AND estate_accounts.due_date = '" . $filter_arr['due_date'] . "' "; 
			}
			if ( isset($filter_arr['account_status']) ){
				$additional_query .= " AND estate_accounts.status = " . $filter_arr['account_status'] . " "; 
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
	
	function getOrderTypes($status=2)
	{
		if( $status == 0 ){
			$this->db->where('status', 0);
			$query = $this->db->get('estate_order_type');
		}elseif( $status == 1 ){
			$this->db->where('status', 1);
			$query = $this->db->get('estate_order_type');
		}else{
			$query = $this->db->get('estate_order_type');
		}
		
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
	
	function getAccountAddressByType($address_type, $account_id)
	{
		$this->db->where('account_id', $account_id);
		$this->db->where('address_type', $address_type);
		$query = $this->db->get('estate_account_addresses');
		
		if( $query->num_rows() > 0 ){
			return $query->row_array();
		}else{
			return array();
		}
	}
}
?>