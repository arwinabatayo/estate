<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mainplantypes extends MY_Controller 
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata['logged_in']) { redirect(site_url('admin/logout')); } // logged in?
		
		if( $this->session->userdata('user_type') && $this->session->userdata('user_type') < 10 ){ 
			// is non-ecommerce users
			// dont allow access
			redirect(site_url('admin/dashboard')); 
		}elseif( $this->session->userdata('user_type') == 10 ){
			// is superadmin
			// allow access
		}else{
			// is ecommerce users
			// dont allow access
			redirect(site_url('admin/accountmanagement')); 
		}
	}
	
	public function index()
	{
		$this->load->model('model_mainplantypes');
		
		$user_type = $this->session->userdata('user_type');	
		
		$filter_arr = array();
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve main plan types
		$pagination_limit = 5;
		$current_page = 1;
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$mainplantypes_arr = $this->model_mainplantypes->getMainPlanTypes(	$property_id, 
																			$user_type, 
																			"estate_main_plan_type.f_type", 
																			"asc", 
																			$limit,
																			$pagination_limit,
																			$filter_arr);
		$mainplantype_total_count = $mainplantypes_arr['total_count'];
		unset($mainplantypes_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['mainplantypes'] == $mainplantype_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'mainplantypes',
								'filter_arr' => $filter_arr,
								'item_count' => $mainplantype_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "mainplantypes";
		$_data['item_count'] = $item_count;
		$_data['mainplantypes'] = $mainplantypes_arr;
		$_data['legend'] = $this->load->view('admin/view_mainplantypes_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_mainplantypes_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$_data['content'] = $this->load->view('admin/view_mainplantypes', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function add()
	{
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "mainplantypes";
		$_data['content'] = $this->load->view('admin/view_mainplantypes_add', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function process_add()
	{
		$this->load->model('model_mainplantypes');
		
		$data										= array();
		$data['f_type'] 							= $this->cleanStringForDB($this->input->post('main_plan_type'));
		$data['f_type_description'] 				= $this->cleanStringForDB($this->input->post('type_description'));
		$data['f_type_image']						= $this->cleanStringForDB($this->input->post('mainplantype-image-name'));
		if( !$this->input->post('status') 
			|| $this->input->post('status') == '' 
			|| $this->input->post('status') == '0' 
			|| $this->input->post('status') == 0 )
		{ 
			$data['f_main_plan_type_status'] 		= 1;
		}else{
			$data['f_main_plan_type_status'] 		= $this->cleanStringForDB($this->input->post('status'));
		}
		
		//move image file
		$image_file = trim($this->input->post('mainplantype-image-name'));
		
		if( file_exists( $this->config->item('base_mainplantype_path') . '_temp/' . $image_file ) ){
			@copy($this->config->item('base_mainplantype_path') . '_temp/' . $image_file, $this->config->item('base_mainplantype_path') . $image_file);
		
			//delete image file from _temp folder
			@unlink($this->config->item('base_mainplantype_path') . '_temp/' . $image_file);
		}
		
		//add main plan type
		$this->model_mainplantypes->addMainPlanType($data);
		
		// log changes
		$main_plan_type = trim($this->input->post('main_plan_type'));
		$log = "Added main plan type " . $main_plan_type;
		$timestamp = date("Y-m-d H:i:s");
		$this->model_main->addLog($log, "Add main plan type", $timestamp);
		
		$user_type = $this->session->userdata('user_type');	
		
		$filter_arr = array();
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve main plan types
		$pagination_limit = 5;
		$current_page = 1;
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$mainplantypes_arr = $this->model_mainplantypes->getMainPlanTypes(	$property_id, 
																			$user_type, 
																			"estate_main_plan_type.f_type", 
																			"asc", 
																			$limit,
																			$pagination_limit,
																			$filter_arr);
		$mainplantype_total_count = $mainplantypes_arr['total_count'];
		unset($mainplantypes_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['mainplantypes'] == $mainplantype_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'mainplantypes',
								'filter_arr' => $filter_arr,
								'item_count' => $mainplantype_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "mainplantypes";
		$_data['item_count'] = $item_count;
		$_data['mainplantypes'] = $mainplantypes_arr;
		$_data['legend'] = $this->load->view('admin/view_mainplantypes_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_mainplantypes_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$this->load->view('admin/view_mainplantypes', $_data);
		return;
	}
	
	public function edit($main_plan_type_id=null)
	{
		$this->load->model('model_mainplantypes');
		
		if ($main_plan_type_id == null) { redirect(site_url('admin/mainplantypes')); } // main_plan_type_id?
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "mainplantypes";
		$_data['mainplantype_details'] = $this->model_mainplantypes->getMainPlanTypeDetails($main_plan_type_id);
		$_data['content'] = $this->load->view('admin/view_mainplantypes_edit', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function process_items()
	{
		$this->load->model('model_mainplantypes');
	
		$user_type = $this->session->userdata('user_type');	
		
		$filter_arr = array();
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve main plan types
		$pagination_limit = 5;
		$current_page = $this->input->post('current_page');
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$mainplantypes_arr = $this->model_mainplantypes->getMainPlanTypes(	$property_id, 
																			$user_type, 
																			"estate_main_plan_type.f_type", 
																			"asc", 
																			$limit,
																			$pagination_limit,
																			$filter_arr);
		$mainplantype_total_count = $mainplantypes_arr['total_count'];
		unset($mainplantypes_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['mainplantypes'] == $mainplantype_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'mainplantypes',
								'filter_arr' => $filter_arr,
								'item_count' => $mainplantype_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "mainplantypes";
		$_data['item_count'] = $item_count;
		$_data['mainplantypes'] = $mainplantypes_arr;
		$_data['legend'] = $this->load->view('admin/view_mainplantypes_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_mainplantypes_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$this->load->view('admin/view_mainplantypes', $_data);
		return;
	}
	
	public function process_edit(){
		
		$this->load->model('model_mainplantypes');
		
		$data									= array();
		$data['f_type'] 						= $this->cleanStringForDB($this->input->post('main_plan_type'));
		$data['f_type_description'] 			= $this->cleanStringForDB($this->input->post('type_description'));
		$data['f_type_image'] 					= $this->cleanStringForDB($this->input->post('mainplantype-image-name'));
		if( !$this->input->post('status') 
			|| $this->input->post('status') == '' 
			|| $this->input->post('status') == '0' 
			|| $this->input->post('status') == 0 )
		{ 
			$data['f_main_plan_type_status'] 		= 1;
		}else{
			$data['f_main_plan_type_status'] 		= $this->cleanStringForDB($this->input->post('status'));
		}
		//get main_plan_type_id
		$main_plan_type_id = $this->input->post('main_plan_type_id');
		
		//move image file
		$image_file = trim($this->input->post('mainplantype-image-name'));
		
		//old image
		$old_image = $this->input->post('old-mainplantype-image-name');
		
		if( file_exists( $this->config->item('base_mainplantype_path') . '_temp/' . $image_file ) ){
			@copy($this->config->item('base_mainplantype_path') . '_temp/' . $image_file, $this->config->item('base_mainplantype_path') . $image_file);
		
			//delete image file from _temp folder
			@unlink($this->config->item('base_mainplantype_path') . '_temp/' . $image_file);
		}
		
		//update main plan type
		$this->model_mainplantypes->updateMainPlanType($data, $main_plan_type_id);
		
		// log changes
		$main_plan_type = trim($this->input->post('main_plan_type'));
		$log = "Updated main plan type " . $main_plan_type;
		$timestamp = date("Y-m-d H:i:s");
		$this->model_main->addLog($log, "Update main plan type", $timestamp);
		
		if( trim($old_image) != trim($image_file) ){
			if( file_exists( $this->config->item('base_mainplantype_path') . $old_image ) ){
				//delete old image
				@unlink($this->config->item('base_mainplantype_path') . $old_image);
			}
		}
		
		$user_type = $this->session->userdata('user_type');	
		
		$filter_arr = array();
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve main plan types
		$pagination_limit = 5;
		$current_page = 1;
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$mainplantypes_arr = $this->model_mainplantypes->getMainPlanTypes(	$property_id, 
																			$user_type, 
																			"estate_main_plan_type.f_type", 
																			"asc", 
																			$limit,
																			$pagination_limit,
																			$filter_arr);
		$mainplantype_total_count = $mainplantypes_arr['total_count'];
		unset($mainplantypes_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['mainplantypes'] == $mainplantype_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'mainplantypes',
								'filter_arr' => $filter_arr,
								'item_count' => $mainplantype_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "mainplantypes";
		$_data['item_count'] = $item_count;
		$_data['mainplantypes'] = $mainplantypes_arr;
		$_data['legend'] = $this->load->view('admin/view_mainplantypes_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_mainplantypes_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$this->load->view('admin/view_mainplantypes', $_data);
		return;
	}
	
	public function upload_mainplantype_image()
	{
		if (!$this->session->userdata('logged_in')) { redirect('admin/login'); } // logged in?
		
		if($_FILES['mainplantype_image']['size'] != 0){
			$image_path 				= $this->config->item('base_mainplantype_path') . "_temp/";
			$orig_image_name			= $_FILES["mainplantype_image"]['name'];

			$config						= array();
			$config['upload_path'] 		= $image_path;
			$config['allowed_types'] 	= 'gif|jpg|png|jpeg';
			$config['max_size']			= '9999';
			$config['file_name']		= $orig_image_name;
			
			$this->load->library('upload', $config);
			
			if(!$this->upload->do_upload("mainplantype_image")){
				$msg = $this->upload->display_errors();
				$upload = array("status" => "error", "msg" => $msg, "filename" => $orig_image_name);
			}else{
				$image_data = $this->upload->data();
				
				$image_filename = $image_data['file_name'];
				$image_path_with_filename = $image_path . $image_filename;
				$image_path_without_filename = str_replace($image_filename, '', $image_path_with_filename);
				
				if( file_exists($image_path_with_filename) ){
					//file exists
					$fileParts = pathinfo($image_path_with_filename);
					$ext = $fileParts['extension'];
					$main_image_is_unique = false;
					
					//rename main image
					while( $main_image_is_unique == false ){
						$new_filename = date("Y-m-d_H-i-s") . '.' . $ext;
						$new_image_path_with_filename = $image_path_without_filename . $new_filename;
						
						if( !file_exists($new_image_path_with_filename) ){
							$main_image_is_unique = true;
							rename($image_path_with_filename, $new_image_path_with_filename);
							$image_filename = $new_filename;
							$image_path_with_filename = $new_image_path_with_filename;
							break;
						}
					}

					$status = "success";
				
					$msg = "Main plan type image successfully uploaded.";
					
					$upload = array("status" => $status, "msg" => $msg, "filename" => $image_filename);
				}else{
					$upload = array("status" => "error", "msg" => "Oops, something went wrong. Your action may or may not have been completed.");
				}
			}	
		}else{
			$upload = array("status" => "error", "msg" => "Oops, something went wrong. Your action may or may not have been completed.");
		}
		
		echo json_encode($upload);
	}
	
	public function process_delete(){
		$this->load->model('model_mainplantypes');
		
		if( $this->input->post('main_plan_type_id') ){
			$main_plan_type_id = $this->input->post('main_plan_type_id');
		}else{
			$main_plan_type_id = 0;
		}
		
		//delete main plan type
		$mainplantype_details = $this->model_mainplantypes->deleteMainPlanType($main_plan_type_id);
		
		//delete main plan type image
		if( isset($mainplantype_details['type_image']) ){
			if( file_exists( $this->config->item('base_mainplantype_path') . $mainplantype_details['type_image'] ) ){
				@unlink($this->config->item('base_mainplantype_path') . $mainplantype_details['type_image']);
			}
		}
		
		// log changes
		$main_plan_type = trim($mainplantype_details['type']);
		$log = "Deleted main plan type " . $main_plan_type;
		$timestamp = date("Y-m-d H:i:s");
		$this->model_main->addLog($log, "Delete main plan type", $timestamp);
		
		$user_type = $this->session->userdata('user_type');	
		
		$filter_arr = array();
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve main plan types
		$pagination_limit = 5;
		$current_page = 1;
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$mainplantypes_arr = $this->model_mainplantypes->getMainPlanTypes(	$property_id, 
																			$user_type, 
																			"estate_main_plan_type.f_type", 
																			"asc", 
																			$limit,
																			$pagination_limit,
																			$filter_arr);
		$mainplantype_total_count = $mainplantypes_arr['total_count'];
		unset($mainplantypes_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['mainplantypes'] == $mainplantype_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'mainplantypes',
								'filter_arr' => $filter_arr,
								'item_count' => $mainplantype_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "mainplantypes";
		$_data['item_count'] = $item_count;
		$_data['mainplantypes'] = $mainplantypes_arr;
		$_data['legend'] = $this->load->view('admin/view_mainplantypes_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_mainplantypes_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$this->load->view('admin/view_mainplantypes', $_data);
		return;
	}
}
?>