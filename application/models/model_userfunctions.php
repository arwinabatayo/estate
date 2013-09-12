<?php
class Model_userfunctions extends CI_Model
{
	function getUserFunctions()
	{
		$query = $this->db->get('estate_user_functions');
		
		return $query->result_array();
	}
	
	function getUserRoleDetails($user_type_id)
	{
		$this->db->where('user_type_id', $user_type_id);
		$query = $this->db->get('user_type');
		
		if( $query->num_rows() > 0 ){
			return $query->row_array();
		}else{
			return array();
		}
	}
	
	function update_userfunction_vs_ecommerceuserrole($function_id, $user_type_id, $is_checked)
	{
		//get user role details
		$user_role_details = $this->getUserRoleDetails($user_type_id);
		
		$allowed_functions = trim($user_role_details['allowed_functions'], ',');
		$arr_allowed_functions = explode(',', $allowed_functions);
		$fin_allowed_functions = array();
		$fin_string_allowed_functions = '';
		
		if( $is_checked == 1 ){  //add function to user role's allowed functions
			if( !in_array($function_id, $arr_allowed_functions) ){
				$fin_allowed_functions = $arr_allowed_functions;
				$fin_allowed_functions[] = $function_id;
				
				$fin_string_allowed_functions = implode(',', $fin_allowed_functions);
			}
		}else{	//remove function from user role's allowed functions
			if( in_array($function_id, $arr_allowed_functions) ){
				foreach( $arr_allowed_functions as $af ){
					if( $af != $function_id ){
						$fin_allowed_functions[] = $af;
					}
				}
				
				$fin_string_allowed_functions = implode(',', $fin_allowed_functions);
			}
		}
		
		//update allowed function for a specific user role
		$data = array(
			'allowed_functions' => trim($fin_string_allowed_functions, ',')
		);

		$this->db->where('user_type_id', $user_type_id);
		$this->db->update('user_type', $data); 
	}
}
?>