<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products extends MY_Controller 
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
		$this->load->model('model_products');
		
		$user_type = $this->session->userdata('user_type');	
		
		$filter_arr = array();
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve products
		$pagination_limit = 5;
		$current_page = 1;
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$product_arr = $this->model_products->getProducts(	$property_id, 
															$user_type, 
															"estate_gadgets.name", 
															"asc", 
															$limit,
															$pagination_limit,
															$filter_arr);
		$product_total_count = $product_arr['total_count'];
		unset($product_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['products'] == $product_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'products',
								'filter_arr' => $filter_arr,
								'item_count' => $product_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "products";
		$_data['item_count'] = $item_count;
		$_data['products'] = $product_arr;
		$_data['legend'] = $this->load->view('admin/view_products_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_products_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$_data['content'] = $this->load->view('admin/view_products', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function add()
	{
		$this->load->model('model_properties');
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "products";
		$_data['properties'] = $this->model_properties->getPropertiesByUserId($this->session->userdata('user_id'), "properties.last_edit", "desc", 0, 100);
		$_data['content'] = $this->load->view('admin/view_products_add', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function process_add()
	{
		$this->load->model('model_products');
		
		$data													= array();
		$tmp_data_attr											= array();
		$data['property_id'] 									= $this->cleanStringForDB($this->input->post('property'));
		$data['name'] 											= $this->cleanStringForDB($this->input->post('name'));
		$data['description'] 									= $this->cleanStringForDB($this->input->post('description'));
		$data['required_pv'] 									= $this->cleanStringForDB($this->input->post('required_pv'));
		$data['cid'] 											= $this->cleanStringForDB($this->input->post('cid'));
		$data['data_capacity'] 									= $this->cleanStringForDB($this->input->post('data_capacity'));
		$data['network_connectivity'] 							= $this->cleanStringForDB($this->input->post('network_connectivity'));
		$data['amount'] 										= $this->cleanStringForDB($this->input->post('amount'));
		$data['discount'] 										= $this->cleanStringForDB($this->input->post('discount'));
		$data['peso_value'] 									= $this->cleanStringForDB($this->input->post('peso_value'));
		$data['quantity'] 										= $this->cleanStringForDB($this->input->post('quantity'));
		$data['image'] 											= $this->cleanStringForDB($this->input->post('product-image-name'));
		if( !$this->input->post('status') 
			|| $this->input->post('status') == '' 
			|| $this->input->post('status') == 'disabled' )
		{ 
			$data['is_active'] 									= 0;
		}elseif( $this->input->post('status') == 'enabled' ){
			$data['is_active'] 									= 1;
		}else{
			$data['is_active'] 									= 0;
		}
		
		$tmp_data_attr['size']									= $this->cleanStringForDB($this->input->post('size'));
		$tmp_data_attr['color']									= $this->cleanStringForDB($this->input->post('color'));
		$data['date_added']										= $this->cleanStringForDB(date("Y-m-d", time()));
		
		//move image file
		$image_file = trim($this->input->post('product-image-name'));
		
		if( file_exists( $this->config->item('base_product_path') . '_temp/' . $image_file ) ){
			@copy($this->config->item('base_product_path') . '_temp/' . $image_file, $this->config->item('base_product_path') . $image_file);
		
			//delete image file from _temp folder
			@unlink($this->config->item('base_product_path') . '_temp/' . $image_file);
		}
		
		//add product
		$this->model_products->addProduct($data, $tmp_data_attr);
		
		// log changes
		$product_name = trim($this->input->post('name'));
		$log = "Added product " . $product_name;
		$timestamp = date("Y-m-d H:i:s");
		$this->model_main->addLog($log, "Add product", $timestamp);
		
		$user_type = $this->session->userdata('user_type');	
		
		$filter_arr = array();
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve products
		$pagination_limit = 5;
		$current_page = 1;
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$product_arr = $this->model_products->getProducts(	$property_id, 
															$user_type, 
															"estate_gadgets.name", 
															"asc", 
															$limit,
															$pagination_limit,
															$filter_arr);
		$product_total_count = $product_arr['total_count'];
		unset($product_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['products'] == $product_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'products',
								'filter_arr' => $filter_arr,
								'item_count' => $product_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "products";
		$_data['item_count'] = $item_count;
		$_data['products'] = $product_arr;
		$_data['legend'] = $this->load->view('admin/view_products_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_products_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$this->load->view('admin/view_products', $_data);
		return;
	}
	
	public function process_items()
	{
		$this->load->model('model_products');
	
		$user_type = $this->session->userdata('user_type');	
		
		$filter_arr = array();
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve products
		$pagination_limit = 5;
		$current_page = $this->input->post('current_page');
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$product_arr = $this->model_products->getProducts(	$property_id, 
															$user_type, 
															"estate_gadgets.name", 
															"asc", 
															$limit,
															$pagination_limit,
															$filter_arr);
		$product_total_count = $product_arr['total_count'];
		unset($product_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['products'] == $product_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'products',
								'filter_arr' => $filter_arr,
								'item_count' => $product_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "products";
		$_data['item_count'] = $item_count;
		$_data['products'] = $product_arr;
		$_data['legend'] = $this->load->view('admin/view_products_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_products_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$this->load->view('admin/view_products', $_data);
		return;
	}
	
	public function upload_product_image()
	{
		if (!$this->session->userdata('logged_in')) { redirect('admin/login'); } // logged in?
		
		if($_FILES['product_image']['size'] != 0){
			$image_path 				= $this->config->item('base_product_path') . "_temp/";
			$orig_image_name			= $_FILES["product_image"]['name'];

			$config						= array();
			$config['upload_path'] 		= $image_path;
			$config['allowed_types'] 	= 'gif|jpg|png|jpeg';
			$config['max_size']			= '9999';
			$config['file_name']		= $orig_image_name;
			
			$this->load->library('upload', $config);
			
			if(!$this->upload->do_upload("product_image")){
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
				
					$msg = "Product image successfully uploaded.";
					
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
	
	public function edit($product_id=null)
	{
		$this->load->model('model_products');
		$this->load->model('model_properties');
		
		if ($product_id == null) { redirect(site_url('admin/products')); } // product_id?
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "products";
		$_data['properties'] = $this->model_properties->getPropertiesByUserId($this->session->userdata('user_id'), "properties.last_edit", "desc", 0, 100);
		$_data['product_details'] = $this->model_products->getProductDetails($product_id);
		$_data['content'] = $this->load->view('admin/view_products_edit', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function process_edit()
	{
		$this->load->model('model_products');
		
		$data													= array();
		$tmp_data_attr											= array();
		$data['property_id'] 									= $this->cleanStringForDB($this->input->post('property'));
		$data['name'] 											= $this->cleanStringForDB($this->input->post('name'));
		$data['description'] 									= $this->cleanStringForDB($this->input->post('description'));
		$data['required_pv'] 									= $this->cleanStringForDB($this->input->post('required_pv'));
		$data['cid'] 											= $this->cleanStringForDB($this->input->post('cid'));
		$data['data_capacity'] 									= $this->cleanStringForDB($this->input->post('data_capacity'));
		$data['network_connectivity'] 							= $this->cleanStringForDB($this->input->post('network_connectivity'));
		$data['amount'] 										= $this->cleanStringForDB($this->input->post('amount'));
		$data['discount'] 										= $this->cleanStringForDB($this->input->post('discount'));
		$data['peso_value'] 									= $this->cleanStringForDB($this->input->post('peso_value'));
		$data['quantity'] 										= $this->cleanStringForDB($this->input->post('quantity'));
		$data['image'] 											= $this->cleanStringForDB($this->input->post('product-image-name'));
		if( !$this->input->post('status') 
			|| $this->input->post('status') == '' 
			|| $this->input->post('status') == 'disabled' )
		{ 
			$data['is_active'] 									= 0;
		}elseif( $this->input->post('status') == 'enabled' ){
			$data['is_active'] 									= 1;
		}else{
			$data['is_active'] 									= 0;
		}
		
		$tmp_data_attr['size']									= $this->cleanStringForDB($this->input->post('size'));
		$tmp_data_attr['color']									= $this->cleanStringForDB($this->input->post('color'));
		//get product id
		$product_id = $this->input->post('gadget_id');
		
		//move image file
		$image_file = trim($this->input->post('product-image-name'));
		
		//old image
		$old_image = $this->input->post('old-product-image-name');
		
		if( file_exists( $this->config->item('base_product_path') . '_temp/' . $image_file ) ){
			@copy($this->config->item('base_product_path') . '_temp/' . $image_file, $this->config->item('base_product_path') . $image_file);
		
			//delete image file from _temp folder
			@unlink($this->config->item('base_product_path') . '_temp/' . $image_file);
		}
		
		//update product
		$this->model_products->updateProduct($data, $tmp_data_attr, $product_id);
		
		// log changes
		$product_name = trim($this->input->post('name'));
		$log = "Updated product " . $product_name;
		$timestamp = date("Y-m-d H:i:s");
		$this->model_main->addLog($log, "Update product", $timestamp);
		
		if( trim($old_image) != trim($image_file) ){
			if( file_exists( $this->config->item('base_product_path') . $old_image ) ){
				//delete old image
				@unlink($this->config->item('base_product_path') . $old_image);
			}
		}
		
		$user_type = $this->session->userdata('user_type');	
		
		$filter_arr = array();
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve products
		$pagination_limit = 5;
		$current_page = 1;
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$product_arr = $this->model_products->getProducts(	$property_id, 
															$user_type, 
															"estate_gadgets.name", 
															"asc", 
															$limit,
															$pagination_limit,
															$filter_arr);
		$product_total_count = $product_arr['total_count'];
		unset($product_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['products'] == $product_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'products',
								'filter_arr' => $filter_arr,
								'item_count' => $product_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "products";
		$_data['item_count'] = $item_count;
		$_data['products'] = $product_arr;
		$_data['legend'] = $this->load->view('admin/view_products_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_products_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$this->load->view('admin/view_products', $_data);
		return;
	}
	
	public function process_delete(){
		$this->load->model('model_products');
		
		if( $this->input->post('gadget_id') ){
			$product_id = $this->input->post('gadget_id');
		}else{
			$product_id = 0;
		}
		
		//delete product
		$product_details = $this->model_products->deleteProduct($product_id);
		
		//delete product image
		if( isset($product_details['image']) ){
			if( file_exists( $this->config->item('base_product_path') . $product_details['image'] ) ){
				@unlink($this->config->item('base_product_path') . $product_details['image']);
			}
		}
		
		// log changes
		$product_name = trim($product_details['name']);
		$log = "Deleted product " . $product_name;
		$timestamp = date("Y-m-d H:i:s");
		$this->model_main->addLog($log, "Delete product", $timestamp);
		
		$user_type = $this->session->userdata('user_type');	
		
		$filter_arr = array();
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve products
		$pagination_limit = 5;
		$current_page = 1;
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$product_arr = $this->model_products->getProducts(	$property_id, 
															$user_type, 
															"estate_gadgets.name", 
															"asc", 
															$limit,
															$pagination_limit,
															$filter_arr);
		$product_total_count = $product_arr['total_count'];
		unset($product_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['products'] == $product_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'products',
								'filter_arr' => $filter_arr,
								'item_count' => $product_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "products";
		$_data['item_count'] = $item_count;
		$_data['products'] = $product_arr;
		$_data['legend'] = $this->load->view('admin/view_products_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_products_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$this->load->view('admin/view_products', $_data);
		return;
	}
}
?>