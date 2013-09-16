<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Addons extends MY_Controller 
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
	
	public function index($category_id=null)
	{
		if ($category_id==null) { redirect(site_url('admin/addonscategories')); } // category_id?
		
		$this->load->model('model_addons');
		
		$user_type = $this->session->userdata('user_type');	
		
		$filter_arr = array();
		$filter_arr['category_id'] = $category_id;
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve addons
		$pagination_limit = 5;
		$current_page = 1;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$addons_arr = $this->model_addons->getAddons(	$category_id, 
														$user_type, 
														"estate_add_ons.title", 
														"asc", 
														$limit,
														$pagination_limit,
														$filter_arr);
		$addon_total_count = $addons_arr['total_count'];
		unset($addons_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['addons'] == $addon_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'category_id' => $category_id,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'addons',
								'category_id' => $category_id,
								'filter_arr' => $filter_arr,
								'item_count' => $addon_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "addons";
		$_data['category_id'] = $category_id;
		$_data['item_count'] = $item_count;
		$_data['addons'] = $addons_arr;
		$_data['legend'] = $this->load->view('admin/view_addons_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_addons_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$_data['content'] = $this->load->view('admin/view_addons', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function add($category_id=null)
	{
		if ($category_id==null) { redirect(site_url('admin/addonscategories')); } // main plan id?
		
		$this->load->model('model_addonscategories');
		$this->load->model('model_addons');
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "addons";
		$_data['addonscategories'] = $this->model_addonscategories->getAllAddonsCategories();
		$_data['category_id'] = $category_id;
		$_data['content'] = $this->load->view('admin/view_addons_add', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function process_add()
	{
		$this->load->model('model_addons');
		
		$data = array();
		$data['category_id'] 			= $this->cleanStringForDB($this->input->post('category_id'));
		$data['cid'] 					= $this->cleanStringForDB($this->input->post('addon_cid'));
		$data['title'] 					= $this->cleanStringForDB($this->input->post('addon_title'));
		$data['description'] 			= $this->cleanStringForDB($this->input->post('addon_description'));
		$data['amount'] 				= $this->cleanStringForDB($this->input->post('addon_amount'));
		$data['quantity'] 				= $this->cleanStringForDB($this->input->post('addon_quantity'));
		$data['image'] 					= $this->cleanStringForDB($this->input->post('addon-image-name'));
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
		$data['peso_value'] 				= $this->cleanStringForDB($this->input->post('addon_peso_value'));
		
		//move image file
		$image_file = trim($this->input->post('addon-image-name'));
		
		if( file_exists( $this->config->item('base_addon_path') . '_temp/' . $image_file ) ){
			@copy($this->config->item('base_addon_path') . '_temp/' . $image_file, $this->config->item('base_addon_path') . $image_file);
		
			//delete image file from _temp folder
			@unlink($this->config->item('base_addon_path') . '_temp/' . $image_file);
		}
		
		//add addon
		$this->model_addons->addAddon($data);
		
		// log changes
		$addon = trim($this->input->post('addon_title'));
		$log = "Added addon " . $addon;
		$timestamp = date("Y-m-d H:i:s");
		$this->model_main->addLog($log, "Add addon", $timestamp);
		
		$user_type = $this->session->userdata('user_type');	
		
		$filter_arr = array();
		$category_id = $this->input->post('category_id');
		$filter_arr['category_id'] = $category_id;
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve addons
		$pagination_limit = 5;
		$current_page = 1;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$addons_arr = $this->model_addons->getAddons(	$category_id, 
														$user_type, 
														"estate_add_ons.title", 
														"asc", 
														$limit,
														$pagination_limit,
														$filter_arr);
		$addon_total_count = $addons_arr['total_count'];
		unset($addons_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['addons'] == $addon_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'category_id' => $category_id,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'addons',
								'category_id' => $category_id,
								'filter_arr' => $filter_arr,
								'item_count' => $addon_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "addons";
		$category_id = $this->input->post('category_id');
		$_data['category_id'] = $category_id;
		$_data['item_count'] = $item_count;
		$_data['addons'] = $addons_arr;
		$_data['legend'] = $this->load->view('admin/view_addons_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_addons_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$this->load->view('admin/view_addons', $_data);
		return;
	}
	
	public function upload_addon_image()
	{
		if (!$this->session->userdata('logged_in')) { redirect('admin/login'); } // logged in?
		
		if($_FILES['addon_image']['size'] != 0){
			$image_path 				= $this->config->item('base_addon_path') . "_temp/";
			$orig_image_name			= $_FILES["addon_image"]['name'];

			$config						= array();
			$config['upload_path'] 		= $image_path;
			$config['allowed_types'] 	= 'gif|jpg|png|jpeg';
			$config['max_size']			= '9999';
			$config['file_name']		= $orig_image_name;
			
			$this->load->library('upload', $config);
			
			if(!$this->upload->do_upload("addon_image")){
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
				
					$msg = "Addon image successfully uploaded.";
					
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
	
	public function edit($addon_id=null)
	{
		if ($addon_id==null) { redirect(site_url('admin/addonscategories')); } // addon_id?
		
		$this->load->model('model_addonscategories');
		$this->load->model('model_addons');
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "addons";
		$_data['addonscategories'] = $this->model_addonscategories->getAllAddonsCategories();
		$_data['addon_details'] = $this->model_addons->getAddonDetails($addon_id);
		$_data['content'] = $this->load->view('admin/view_addons_edit', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function process_items()
	{
		$this->load->model('model_addons');
	
		$user_type = $this->session->userdata('user_type');	
		
		$filter_arr = array();
		$filter_arr['category_id'] = $this->input->post('category_id');
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve addons
		$pagination_limit = 5;
		$current_page = $this->input->post('current_page');
		$category_id = $this->input->post('category_id');
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$addons_arr = $this->model_addons->getAddons(	$category_id, 
														$user_type, 
														"estate_add_ons.title", 
														"asc", 
														$limit,
														$pagination_limit,
														$filter_arr);
		$addon_total_count = $addons_arr['total_count'];
		unset($addons_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['addons'] == $addon_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'category_id' => $category_id,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'addons',
								'category_id' => $category_id,
								'filter_arr' => $filter_arr,
								'item_count' => $addon_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "addons";
		$_data['category_id'] = $category_id;
		$_data['item_count'] = $item_count;
		$_data['addons'] = $addons_arr;
		$_data['legend'] = $this->load->view('admin/view_addons_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_addons_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$this->load->view('admin/view_addons', $_data);
		return;
	}
	
	public function process_edit()
	{
		$this->load->model('model_addons');
		
		$data = array();
		$data['title'] 				= $this->cleanStringForDB($this->input->post('addon_title'));
		$data['cid'] 				= $this->cleanStringForDB($this->input->post('addon_cid'));
		$data['description'] 			= $this->cleanStringForDB($this->input->post('addon_description'));
		$data['amount'] 				= $this->cleanStringForDB($this->input->post('addon_amount'));
		$data['category_id'] 					= $this->cleanStringForDB($this->input->post('category_id'));
		$data['quantity'] 			= $this->cleanStringForDB($this->input->post('addon_quantity'));
		$data['image'] 				= $this->cleanStringForDB($this->input->post('addon-image-name'));
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
		$data['peso_value'] 				= $this->cleanStringForDB($this->input->post('addon_peso_value'));
		
		//get add_on_id
		$add_on_id = $this->input->post('add_on_id');
		
		//move image file
		$image_file = trim($this->input->post('addon-image-name'));
		
		//old image
		$old_image = $this->input->post('old-addon-image-name');
		
		if( file_exists( $this->config->item('base_addon_path') . '_temp/' . $image_file ) ){
			@copy($this->config->item('base_addon_path') . '_temp/' . $image_file, $this->config->item('base_addon_path') . $image_file);
		
			//delete image file from _temp folder
			@unlink($this->config->item('base_addon_path') . '_temp/' . $image_file);
		}
		
		//update main plan
		$this->model_addons->updateAddon($data, $add_on_id);
		
		// log changes
		$addon_title = trim($this->input->post('addon_title'));
		$log = "Updated addon " . $addon_title;
		$timestamp = date("Y-m-d H:i:s");
		$this->model_main->addLog($log, "Update addon ", $timestamp);
		
		if( trim($old_image) != trim($image_file) ){
			if( file_exists( $this->config->item('base_addon_path') . $old_image ) ){
				//delete old image
				@unlink($this->config->item('base_addon_path') . $old_image);
			}
		}
		
		$user_type = $this->session->userdata('user_type');	
		
		$filter_arr = array();
		$category_id = $this->input->post('category_id');
		$filter_arr['category_id'] = $category_id;
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve addons
		$pagination_limit = 5;
		$current_page = 1;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$addons_arr = $this->model_addons->getAddons(	$category_id, 
														$user_type, 
														"estate_add_ons.title", 
														"asc", 
														$limit,
														$pagination_limit,
														$filter_arr);
		$addon_total_count = $addons_arr['total_count'];
		unset($addons_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['addons'] == $addon_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'category_id' => $category_id,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'addons',
								'category_id' => $category_id,
								'filter_arr' => $filter_arr,
								'item_count' => $addon_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "addons";
		$_data['category_id'] = $category_id;
		$_data['item_count'] = $item_count;
		$_data['addons'] = $addons_arr;
		$_data['legend'] = $this->load->view('admin/view_addons_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_addons_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$this->load->view('admin/view_addons', $_data);
		return;
	}
	
	public function process_delete(){
		$this->load->model('model_addons');
		
		if( $this->input->post('addon_id') ){
			$addon_id = $this->input->post('addon_id');
		}else{
			$addon_id = 0;
		}
		
		//delete addon
		$addon_details = $this->model_addons->deleteAddon($addon_id);
		
		//delete addon image
		if( isset($addon_details['type_image']) ){
			if( file_exists( $this->config->item('base_addon_path') . $addon_details['addon_image'] ) ){
				@unlink($this->config->item('base_addon_path') . $addon_details['addon_image']);
			}
		}
		
		// log changes
		$addon = trim($addon_details['title']);
		$log = "Deleted addon " . $addon;
		$timestamp = date("Y-m-d H:i:s");
		$this->model_main->addLog($log, "Delete addon ", $timestamp);
		
		$user_type = $this->session->userdata('user_type');	
		
		$filter_arr = array();
		$category_id = $this->input->post('category_id');
		$filter_arr['category_id'] = $category_id;
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve addons
		$pagination_limit = 5;
		$current_page = 1;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$addons_arr = $this->model_addons->getAddons(	$category_id, 
														$user_type, 
														"estate_add_ons.title", 
														"asc", 
														$limit,
														$pagination_limit,
														$filter_arr);
		$addon_total_count = $addons_arr['total_count'];
		unset($addons_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['addons'] == $addon_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'category_id' => $category_id,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'addons',
								'category_id' => $category_id,
								'filter_arr' => $filter_arr,
								'item_count' => $addon_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "addons";
		$_data['category_id'] = $category_id;
		$_data['item_count'] = $item_count;
		$_data['addons'] = $addons_arr;
		$_data['legend'] = $this->load->view('admin/view_addons_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_addons_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$this->load->view('admin/view_addons', $_data);
		return;
	}
}
?>