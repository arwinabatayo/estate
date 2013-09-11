<?php
class Model_templates extends CI_Model
{
	
	function getTemplates($company_id, $user_type, $order_by, $order, $limit, $limit_by = 5, $filter_arr = array()) 
	{
	
		$templates_allowed = $this->session->userdata('templates_allowed');
	
		if ($templates_allowed) {
		
			$additional_query = "";
			if ($filter_arr) {
				if ($filter_arr['letter']) 			{ $additional_query .= " AND templates.title LIKE '" . $filter_arr['letter'] . "%'"; }
				if ($filter_arr['template_type']) 	{ $additional_query .= " AND templates.template_type_id = " . $filter_arr['template_type']; }
			}
			
			if (!$filter_arr['template_type']) {
			foreach ($templates_allowed as $template => $t) { 
				$additional_query .= " OR templates.template_type_id = $t";
			}
			}
			
			if ($order_by && $order)	{ $additional_query .= " ORDER BY $order_by $order"; }
			if ($limit_by != 'all') 	{ $additional_query .= " LIMIT $limit, $limit_by"; }
				
			if ((substr($additional_query, 0, 4) == " AND") || (substr($additional_query, 0, 4) == " OR ")) { 
				$additional_query = substr($additional_query, 4);
				$additional_query = " WHERE " . $additional_query;
			}
			
			$query = $this->db->query("	SELECT SQL_CALC_FOUND_ROWS *
										FROM templates
										INNER JOIN template_type
										ON templates.template_type_id = template_type.template_type_id" . $additional_query);
			$data = $query->result_array();
			
			// set total count
			$query = $this->db->query("	SELECT FOUND_ROWS() AS 'count'");
			$data["total_count"] = $query->row()->count;
			return $data;	
			
		} else {

			return NULL;
		
		}
		
	}
	
	function getTemplateDetails($template_id)
	{
		$query = $this->db->query("	SELECT * 
									FROM templates 
									INNER JOIN template_type
									ON templates.template_type_id = template_type.template_type_id
									WHERE template_id = $template_id"); 
		$template_details = $query->result_array();
		return $template_details[0];
	}
	
	function addTemplate($title, $template_type, $description, $folder_name, $responsive, $last_edit)
	{
		$query = $this->db->query("	INSERT INTO templates (title, template_type_id, description, folder, responsive, last_edit) 
									VALUES ('$title', $template_type, '$description', '$folder_name', $responsive, '$last_edit')");
		return;
	}
	
	function editTemplate($template_id, $title, $folder_name, $template_type, $description, $responsive, $last_edit)
	{
		$query = $this->db->query("	UPDATE templates 
									SET title = '$title', 
										description = '$description', 
										template_type_id = $template_type,
										folder = '$folder_name',
										last_edit = '$last_edit',
										responsive = $responsive
									WHERE template_id = $template_id");
		return;
	}
	
	function deleteTemplate($template_id)
	{
		$query = $this->db->query("	DELETE FROM templates 
									WHERE template_id = $template_id");
		return;
	}
	
	function getAllTemplates()
	{
		$query = $this->db->query("	SELECT SQL_CALC_FOUND_ROWS *
									FROM templates
									INNER JOIN template_type
									ON templates.template_type_id = template_type.template_type_id");
		$data = $query->result_array();
		
		// set total count
		$query = $this->db->query("	SELECT FOUND_ROWS() AS 'count'");
		$data["total_count"] = $query->row()->count;
		return $data;		
	}

}
?>