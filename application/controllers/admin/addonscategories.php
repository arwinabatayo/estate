<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Addonscategories extends MY_Controller 
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
		$this->load->model('model_addonscategories');
		
		$user_type = $this->session->userdata('user_type');	
		
		$filter_arr = array();
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve addons categories
		$pagination_limit = 5;
		$current_page = 1;
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$addonscategories_arr = $this->model_addonscategories->getAddonsCategories(	$property_id, 
																					$user_type, 
																					"estate_add_ons_category.add_ons_category_title", 
																					"asc", 
																					$limit,
																					$pagination_limit,
																					$filter_arr);
		$addonscategory_total_count = $addonscategories_arr['total_count'];
		unset($addonscategories_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['addonscategories'] == $addonscategory_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'addonscategories',
								'filter_arr' => $filter_arr,
								'item_count' => $addonscategory_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "addonscategories";
		$_data['item_count'] = $item_count;
		$_data['addonscategories'] = $addonscategories_arr;
		$_data['legend'] = $this->load->view('admin/view_addonscategories_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_addonscategories_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$_data['content'] = $this->load->view('admin/view_addonscategories', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function add()
	{
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "addonscategories";
		$_data['content'] = $this->load->view('admin/view_addonscategories_add', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function process_add()
	{
		$this->load->model('model_addonscategories');
		
		$data										= array();
		$data['add_ons_category_title'] 			= $this->cleanStringForDB($this->input->post('add_ons_category_title'));
		$data['add_ons_category_description'] 		= $this->cleanStringForDB($this->input->post('add_ons_category_description'));
		$data['add_ons_category_image'] 			= $this->cleanStringForDB($this->input->post('addonscategory-image-name'));
		
		//move image file
		$image_file = trim($this->input->post('addonscategory-image-name'));
		
		if( file_exists( $this->config->item('base_addonscategory_path') . '_temp/' . $image_file ) ){
			@copy($this->config->item('base_addonscategory_path') . '_temp/' . $image_file, $this->config->item('base_addonscategory_path') . $image_file);
		
			//delete image file from _temp folder
			@unlink($this->config->item('base_addonscategory_path') . '_temp/' . $image_file);
		}
		
		//add addons category
		$this->model_addonscategories->addAddonsCategory($data);
		
		// log changes
		$addonscategory = trim($this->input->post('add_ons_category_title'));
		$log = "Added addons category " . $addonscategory;
		$timestamp = date("Y-m-d H:i:s");
		$this->model_main->addLog($log, "Add addons category", $timestamp);
		
		$user_type = $this->session->userdata('user_type');	
		
		$filter_arr = array();
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve addons categories
		$pagination_limit = 5;
		$current_page = 1;
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$addonscategories_arr = $this->model_addonscategories->getAddonsCategories(	$property_id, 
																					$user_type, 
																					"estate_add_ons_category.add_ons_category_title", 
																					"asc", 
																					$limit,
																					$pagination_limit,
																					$filter_arr);
		$addonscategory_total_count = $addonscategories_arr['total_count'];
		unset($addonscategories_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['addonscategories'] == $addonscategory_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'addonscategories',
								'filter_arr' => $filter_arr,
								'item_count' => $addonscategory_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "addonscategories";
		$_data['item_count'] = $item_count;
		$_data['addonscategories'] = $addonscategories_arr;
		$_data['legend'] = $this->load->view('admin/view_addonscategories_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_addonscategories_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$this->load->view('admin/view_addonscategories', $_data);
		return;
	}
	
	public function edit($addonscategory_id=null)
	{
		$this->load->model('model_addonscategories');
		
		if ($addonscategory_id == null) { redirect(site_url('admin/addonscategories')); } // addonscategory_id?
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "addonscategories";
		$_data['addonscategory_id'] = $addonscategory_id;
		$_data['addonscategory_details'] = $this->model_addonscategories->getAddonsCategoryDetails($addonscategory_id);
		$_data['content'] = $this->load->view('admin/view_addonscategories_edit', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function process_items()
	{
		$this->load->model('model_addonscategories');
	
		$user_type = $this->session->userdata('user_type');	
		
		$filter_arr = array();
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve addons categories
		$pagination_limit = 5;
		$current_page = $this->input->post('current_page');
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$addonscategories_arr = $this->model_addonscategories->getAddonsCategories(	$property_id, 
																					$user_type, 
																					"estate_add_ons_category.add_ons_category_title", 
																					"asc", 
																					$limit,
																					$pagination_limit,
																					$filter_arr);
		$addonscategory_total_count = $addonscategories_arr['total_count'];
		unset($addonscategories_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['addonscategories'] == $addonscategory_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'addonscategories',
								'filter_arr' => $filter_arr,
								'item_count' => $addonscategory_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "addonscategories";
		$_data['item_count'] = $item_count;
		$_data['addonscategories'] = $addonscategories_arr;
		$_data['legend'] = $this->load->view('admin/view_addonscategories_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_addonscategories_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$this->load->view('admin/view_addonscategories', $_data);
		return;
	}
	
	public function process_edit(){
		
		$this->load->model('model_addonscategories');
		
		$data										= array();
		$data['add_ons_category_title'] 			= $this->cleanStringForDB($this->input->post('add_ons_category_title'));
		$data['add_ons_category_description'] 		= $this->cleanStringForDB($this->input->post('add_ons_category_description'));
		$data['add_ons_category_image'] 			= $this->cleanStringForDB($this->input->post('addonscategory-image-name'));
		
		//get addonscategory_id
		$addonscategory_id = $this->input->post('addonscategory_id');
		
		//move image file
		$image_file = trim($this->input->post('addonscategory-image-name'));
		
		//old image
		$old_image = $this->input->post('old-addonscategory-image-name');
		
		if( file_exists( $this->config->item('base_addonscategory_path') . '_temp/' . $image_file ) ){
			@copy($this->config->item('base_addonscategory_path') . '_temp/' . $image_file, $this->config->item('base_addonscategory_path') . $image_file);
		
			//delete image file from _temp folder
			@unlink($this->config->item('base_addonscategory_path') . '_temp/' . $image_file);
		}
		
		//update main plan type
		$this->model_addonscategories->updateAddonsCategory($data, $addonscategory_id);
		
		// log changes
		$addonscategory = trim($this->input->post('add_ons_category_title'));
		$log = "Updated addons category " . $addonscategory;
		$timestamp = date("Y-m-d H:i:s");
		$this->model_main->addLog($log, "Update addons category ", $timestamp);
		
		if( trim($old_image) != trim($image_file) ){
			if( file_exists( $this->config->item('base_addonscategory_path') . $old_image ) ){
				//delete old image
				@unlink($this->config->item('base_addonscategory_path') . $old_image);
			}
		}
		
		$user_type = $this->session->userdata('user_type');	
		
		$filter_arr = array();
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve addons categories
		$pagination_limit = 5;
		$current_page = 1;
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$addonscategories_arr = $this->model_addonscategories->getAddonsCategories(	$property_id, 
																					$user_type, 
																					"estate_add_ons_category.add_ons_category_title", 
																					"asc", 
																					$limit,
																					$pagination_limit,
																					$filter_arr);
		$addonscategory_total_count = $addonscategories_arr['total_count'];
		unset($addonscategories_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['addonscategories'] == $addonscategory_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'addonscategories',
								'filter_arr' => $filter_arr,
								'item_count' => $addonscategory_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "addonscategories";
		$_data['item_count'] = $item_count;
		$_data['addonscategories'] = $addonscategories_arr;
		$_data['legend'] = $this->load->view('admin/view_addonscategories_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_addonscategories_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$this->load->view('admin/view_addonscategories', $_data);
		return;
	}
	
	public function upload_addonscategory_image()
	{
		if (!$this->session->userdata('logged_in')) { redirect('admin/login'); } // logged in?
		
		if($_FILES['addonscategory_image']['size'] != 0){
			$image_path 				= $this->config->item('base_addonscategory_path') . "_temp/";
			$orig_image_name			= $_FILES["addonscategory_image"]['name'];

			$config						= array();
			$config['upload_path'] 		= $image_path;
			$config['allowed_types'] 	= 'gif|jpg|png|jpeg';
			$config['max_size']			= '9999';
			$config['file_name']		= $orig_image_name;
			
			$this->load->library('upload', $config);
			
			if(!$this->upload->do_upload("addonscategory_image")){
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
				
					$msg = "Addons caetgory image successfully uploaded.";
					
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
		$this->load->model('model_addonscategories');
		
		if( $this->input->post('addonscategory_id') ){
			$addonscategory_id = $this->input->post('addonscategory_id');
		}else{
			$addonscategory_id = 0;
		}
		
		//delete addons category
		$addonscategory_details = $this->model_addonscategories->deleteAddonsCategory($addonscategory_id);
		
		//delete addons category image
		if( isset($addonscategory_details['add_ons_category_image']) ){
			if( file_exists( $this->config->item('base_addonscategory_path') . $addonscategory_details['add_ons_category_image'] ) ){
				@unlink($this->config->item('base_addonscategory_path') . $addonscategory_details['add_ons_category_image']);
			}
		}
		
		// log changes
		$addonscategory = trim($addonscategory_details['add_ons_category_title']);
		$log = "Deleted addons category " . $addonscategory;
		$timestamp = date("Y-m-d H:i:s");
		$this->model_main->addLog($log, "Delete addons category ", $timestamp);
		
		$user_type = $this->session->userdata('user_type');	
		
		$filter_arr = array();
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve addons categories
		$pagination_limit = 5;
		$current_page = 1;
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$addonscategories_arr = $this->model_addonscategories->getAddonsCategories(	$property_id, 
																					$user_type, 
																					"estate_add_ons_category.add_ons_category_title", 
																					"asc", 
																					$limit,
																					$pagination_limit,
																					$filter_arr);
		$addonscategory_total_count = $addonscategories_arr['total_count'];
		unset($addonscategories_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['addonscategories'] == $addonscategory_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'addonscategories',
								'filter_arr' => $filter_arr,
								'item_count' => $addonscategory_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "addonscategories";
		$_data['item_count'] = $item_count;
		$_data['addonscategories'] = $addonscategories_arr;
		$_data['legend'] = $this->load->view('admin/view_addonscategories_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_addonscategories_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$this->load->view('admin/view_addonscategories', $_data);
		return;
	}
}
?>