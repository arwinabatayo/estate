<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
					error_reporting(1);
					ini_set('display_errors',1);

class Products extends MY_Controller 
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata['logged_in']) { redirect(site_url('admin/logout')); } // logged in?
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
															"estate_product.product_name", 
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
		$_pagination = array(	'page' => 'configurations',
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
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "products";
		$_data['content'] = $this->load->view('admin/view_products_add', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function upload_product_image(){
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
				$status = 'error-'.$_FILES['product_image'].'-'.$orig_image_name.'--'.$msg;
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
	
}
?>