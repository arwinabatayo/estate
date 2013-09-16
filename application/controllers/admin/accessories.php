<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accessories extends MY_Controller 
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
		$this->load->model('model_accessories');
		
		$user_type = $this->session->userdata('user_type');	
		
		$filter_arr = array();
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve accessories
		$pagination_limit = 5;
		$current_page = 1;
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$accessories_arr = $this->model_accessories->getAccessories(	$property_id, 
																		$user_type, 
																		"estate_accessories.title", 
																		"asc", 
																		$limit,
																		$pagination_limit,
																		$filter_arr);
		$accessory_total_count = $accessories_arr['total_count'];
		unset($accessories_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['accessories'] == $accessory_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'accessories',
								'filter_arr' => $filter_arr,
								'item_count' => $accessory_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "accessories";
		$_data['item_count'] = $item_count;
		$_data['accessories'] = $accessories_arr;
		$_data['legend'] = $this->load->view('admin/view_accessories_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_accessories_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$_data['content'] = $this->load->view('admin/view_accessories', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function add()
	{
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "accessories";
		$_data['content'] = $this->load->view('admin/view_accessories_add', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function process_add()
	{
		$this->load->model('model_accessories');
		
		$data										= array();
		$data['title'] 								= $this->cleanStringForDB($this->input->post('accessories_title'));
		$data['cid'] 								= $this->cleanStringForDB($this->input->post('accessories_cid'));
		$data['description'] 						= $this->cleanStringForDB($this->input->post('accessories_description'));
		$data['amount'] 							= $this->cleanStringForDB($this->input->post('accessories_amount'));
		$data['quantity'] 							= $this->cleanStringForDB($this->input->post('accessories_quantity'));
		$data['image'] 								= $this->cleanStringForDB($this->input->post('accessory-image-name'));
		$data['peso_value'] 						= $this->cleanStringForDB($this->input->post('accessories_peso_value'));
		if( !$this->input->post('status') 
			|| $this->input->post('status') == '' 
			|| $this->input->post('status') == 'disabled' )
		{ 
			$data['status'] 									= 0;
		}elseif( $this->input->post('status') == 'enabled' ){
			$data['status'] 									= 1;
		}else{
			$data['status'] 									= 0;
		}
		
		//move image file
		$image_file = trim($this->input->post('accessory-image-name'));
		
		if( file_exists( $this->config->item('base_accessory_path') . '_temp/' . $image_file ) ){
			@copy($this->config->item('base_accessory_path') . '_temp/' . $image_file, $this->config->item('base_accessory_path') . $image_file);
		
			//delete image file from _temp folder
			@unlink($this->config->item('base_accessory_path') . '_temp/' . $image_file);
		}
		
		//add accessory
		$this->model_accessories->addAccessory($data);
		
		// log changes
		$accessory = trim($this->input->post('accessories_title'));
		$log = "Added accessory " . $accessory;
		$timestamp = date("Y-m-d H:i:s");
		$this->model_main->addLog($log, "Add accessory", $timestamp);
		
		$user_type = $this->session->userdata('user_type');	
		
		$filter_arr = array();
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve accessories
		$pagination_limit = 5;
		$current_page = 1;
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$accessories_arr = $this->model_accessories->getAccessories(	$property_id, 
																		$user_type, 
																		"estate_accessories.title", 
																		"asc", 
																		$limit,
																		$pagination_limit,
																		$filter_arr);
		$accessory_total_count = $accessories_arr['total_count'];
		unset($accessories_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['accessories'] == $accessory_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'accessories',
								'filter_arr' => $filter_arr,
								'item_count' => $accessory_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "accessories";
		$_data['item_count'] = $item_count;
		$_data['accessories'] = $accessories_arr;
		$_data['legend'] = $this->load->view('admin/view_accessories_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_accessories_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$this->load->view('admin/view_accessories', $_data);
		return;
	}
	
	public function edit($accessory_id=null)
	{
		$this->load->model('model_accessories');
		
		if ($accessory_id == null) { redirect(site_url('admin/accessories')); } // accessory_id?
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "accessories";
		$_data['accessory_id'] = $accessory_id;
		$_data['accessory_details'] = $this->model_accessories->getAccessoryDetails($accessory_id);
		$_data['content'] = $this->load->view('admin/view_accessories_edit', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function process_items()
	{
		$this->load->model('model_accessories');
	
		$user_type = $this->session->userdata('user_type');	
		
		$filter_arr = array();
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve accessories
		$pagination_limit = 5;
		$current_page = $this->input->post('current_page');
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$accessories_arr = $this->model_accessories->getAccessories(	$property_id, 
																		$user_type, 
																		"estate_accessories.title", 
																		"asc", 
																		$limit,
																		$pagination_limit,
																		$filter_arr);
		$accessory_total_count = $accessories_arr['total_count'];
		unset($accessories_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['accessories'] == $accessory_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'accessories',
								'filter_arr' => $filter_arr,
								'item_count' => $accessory_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "accessories";
		$_data['item_count'] = $item_count;
		$_data['accessories'] = $accessories_arr;
		$_data['legend'] = $this->load->view('admin/view_accessories_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_accessories_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$this->load->view('admin/view_accessories', $_data);
		return;
	}
	
	public function process_edit(){
		
		$this->load->model('model_accessories');
		
		$data													= array();
		$data['title'] 											= $this->cleanStringForDB($this->input->post('accessories_title'));
		$data['cid'] 											= $this->cleanStringForDB($this->input->post('accessories_cid'));
		$data['description'] 									= $this->cleanStringForDB($this->input->post('accessories_description'));
		$data['amount'] 										= $this->cleanStringForDB($this->input->post('accessories_amount'));
		$data['quantity'] 										= $this->cleanStringForDB($this->input->post('accessories_quantity'));
		$data['image'] 											= $this->cleanStringForDB($this->input->post('accessory-image-name'));
		$data['peso_value'] 									= $this->cleanStringForDB($this->input->post('accessories_peso_value'));
		if( !$this->input->post('status') 
			|| $this->input->post('status') == '' 
			|| $this->input->post('status') == 'disabled' )
		{ 
			$data['status'] 									= 0;
		}elseif( $this->input->post('status') == 'enabled' ){
			$data['status'] 									= 1;
		}else{
			$data['status'] 									= 0;
		}
		//get accessory_id
		$accessory_id = $this->input->post('accessory_id');
		
		//move image file
		$image_file = trim($this->input->post('accessory-image-name'));
		
		//old image
		$old_image = $this->input->post('old-accessory-image-name');
		
		if( file_exists( $this->config->item('base_accessory_path') . '_temp/' . $image_file ) ){
			@copy($this->config->item('base_accessory_path') . '_temp/' . $image_file, $this->config->item('base_accessory_path') . $image_file);
		
			//delete image file from _temp folder
			@unlink($this->config->item('base_accessory_path') . '_temp/' . $image_file);
		}
		
		//update accessory
		$this->model_accessories->updateAccessory($data, $accessory_id);
		
		// log changes
		$accessory = trim($this->input->post('accessories_title'));
		$log = "Updated accessory " . $accessory;
		$timestamp = date("Y-m-d H:i:s");
		$this->model_main->addLog($log, "Update accessory", $timestamp);
		
		if( trim($old_image) != trim($image_file) ){
			if( file_exists( $this->config->item('base_accessory_path') . $old_image ) ){
				//delete old image
				@unlink($this->config->item('base_accessory_path') . $old_image);
			}
		}
		
		$user_type = $this->session->userdata('user_type');	
		
		$filter_arr = array();
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve accessories
		$pagination_limit = 5;
		$current_page = 1;
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$accessories_arr = $this->model_accessories->getAccessories(	$property_id, 
																		$user_type, 
																		"estate_accessories.title", 
																		"asc", 
																		$limit,
																		$pagination_limit,
																		$filter_arr);
		$accessory_total_count = $accessories_arr['total_count'];
		unset($accessories_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['accessories'] == $accessory_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'accessories',
								'filter_arr' => $filter_arr,
								'item_count' => $accessory_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "accessories";
		$_data['item_count'] = $item_count;
		$_data['accessories'] = $accessories_arr;
		$_data['legend'] = $this->load->view('admin/view_accessories_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_accessories_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$this->load->view('admin/view_accessories', $_data);
		return;
	}
	
	public function upload_accessory_image()
	{
		if (!$this->session->userdata('logged_in')) { redirect('admin/login'); } // logged in?
		
		if($_FILES['accessory_image']['size'] != 0){
			$image_path 				= $this->config->item('base_accessory_path') . "_temp/";
			$orig_image_name			= $_FILES["accessory_image"]['name'];

			$config						= array();
			$config['upload_path'] 		= $image_path;
			$config['allowed_types'] 	= 'gif|jpg|png|jpeg';
			$config['max_size']			= '9999';
			$config['file_name']		= $orig_image_name;
			
			$this->load->library('upload', $config);
			
			if(!$this->upload->do_upload("accessory_image")){
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
				
					$msg = "Accessory image successfully uploaded.";
					
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
		$this->load->model('model_accessories');
		
		if( $this->input->post('accessory_id') ){
			$accessory_id = $this->input->post('accessory_id');
		}else{
			$accessory_id = 0;
		}
		
		//delete accessory
		$accessory_details = $this->model_accessories->deleteAccessory($accessory_id);
		
		//delete accessory image
		if( isset($accessory_details['image']) ){
			if( file_exists( $this->config->item('base_accessory_path') . $accessory_details['image'] ) ){
				@unlink($this->config->item('base_accessory_path') . $accessory_details['image']);
			}
		}
		
		// log changes
		$accessory = trim($accessory_details['title']);
		$log = "Deleted accessory " . $accessory;
		$timestamp = date("Y-m-d H:i:s");
		$this->model_main->addLog($log, "Delete accessory ", $timestamp);
		
		$user_type = $this->session->userdata('user_type');	
		
		$filter_arr = array();
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve accessories
		$pagination_limit = 5;
		$current_page = 1;
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$accessories_arr = $this->model_accessories->getAccessories(	$property_id, 
																		$user_type, 
																		"estate_accessories.title", 
																		"asc", 
																		$limit,
																		$pagination_limit,
																		$filter_arr);
		$accessory_total_count = $accessories_arr['total_count'];
		unset($accessories_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['accessories'] == $accessory_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'accessories',
								'filter_arr' => $filter_arr,
								'item_count' => $accessory_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "accessories";
		$_data['item_count'] = $item_count;
		$_data['accessories'] = $accessories_arr;
		$_data['legend'] = $this->load->view('admin/view_accessories_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_accessories_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$this->load->view('admin/view_accessories', $_data);
		return;
	}
}
?>