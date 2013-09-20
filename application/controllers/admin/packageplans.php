<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Packageplans extends MY_Controller 
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
		$this->load->model('model_packageplans');
		
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

		$package_plans_arr = $this->model_packageplans->getPackagePlans();
		$package_plans_total_count = $package_plans_arr['total_count'];
		unset($package_plans_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['package_plans'] == $package_plans_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'packageplans',
								'filter_arr' => $filter_arr,
								'item_count' => $package_plans_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "packageplans";
		$_data['item_count'] = $item_count;
		$_data['packge_plans'] = $package_plans_arr;
		$_data['legend'] = $this->load->view('admin/view_packageplans_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_packageplans_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$_data['content'] = $this->load->view('admin/view_packageplans', $_data, TRUE);
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
	
	public function edit($plan_id=null)
	{
		$this->load->model('model_packageplans');
		
		if ($plan_id == null) { redirect(site_url('admin/packageplans')); } // accessory_id?
		$text_arr = array();
		$surf_arr = array();
		$call_arr = array();
		$idd_arr = array();
		$combo_id_arr = array();

		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "packageplans";
		$_data['plan_id'] = $plan_id;
		$_data['combos'] = $this->model_packageplans->getCombos();
		$_data['plan_details'] = $this->model_packageplans->getPackagePlanDetails($plan_id);
		$_data['active_flag'] = $this->model_packageplans->getPackagePlans($plan_id);
		//echo "<pre>";
		//var_dump($_data['combos']); exit;

		foreach($_data['plan_details'] as $key_plan	=> $value_plan){
			array_push($combo_id_arr, $_data['plan_details'][$key_plan]['combo_id']);
		}

		foreach($_data['combos'] as $key_combo => $value_combo){
			$_data['combos'][$key_combo]['selected'] = false;

			switch(strtolower($_data['combos'][$key_combo]['category'])){
				case "text"	: 
					if(in_array($_data['combos'][$key_combo]['id'], $combo_id_arr)){
						$_data['combos'][$key_combo]['selected'] = true;
					} 
					array_push($text_arr, $_data['combos'][$key_combo]);
				break;
				case "surf"	: 
					if(in_array($_data['combos'][$key_combo]['id'], $combo_id_arr)){
						$_data['combos'][$key_combo]['selected'] = true;
					} 
					array_push($surf_arr, $_data['combos'][$key_combo]); 
				break;
				case "call"	:	
					if(in_array($_data['combos'][$key_combo]['id'], $combo_id_arr)){
						$_data['combos'][$key_combo]['selected'] = true;
					} 
					array_push($call_arr, $_data['combos'][$key_combo]); 
				break;
				case "idd"	:	
					if(in_array($_data['combos'][$key_combo]['id'], $combo_id_arr)){
						$_data['combos'][$key_combo]['selected'] = true;
					} 
					array_push($idd_arr, $_data['combos'][$key_combo]); 
				break;
			}
			
		}

		//echo "<pre>"; var_dump($text_arr); exit;
		$_data['text_arr'] = $text_arr;
		$_data['call_arr'] = $call_arr;
		$_data['surf_arr'] = $surf_arr;
		$_data['idd_arr'] = $idd_arr;
		$_data['content'] = $this->load->view('admin/view_packageplans_edit', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function process_items()
	{
		$this->load->model('model_packageplans');
	
		$user_type = $this->session->userdata('user_type');	
		
		$filter_arr = array();
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve package plans
		$pagination_limit = 5;
		$current_page = 1;
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$plans_arr = $this->model_packageplans->getFilterPlans(	$property_id, 
															$user_type, 
															"", 
															"asc", 
															$limit,
															$pagination_limit,
															$filter_arr);

		$package_plans_arr = $this->model_packageplans->getPackagePlans();
		$package_plans_total_count = $package_plans_arr['total_count'];
		unset($package_plans_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['package_plans'] == $package_plans_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'packageplans',
								'filter_arr' => $filter_arr,
								'item_count' => $package_plans_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "packageplans";
		$_data['item_count'] = $item_count;
		$_data['packge_plans'] = $package_plans_arr;
		$_data['legend'] = $this->load->view('admin/view_packageplans_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_packageplans_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$_data['content'] = $this->load->view('admin/view_packageplans', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function process_edit(){
		
		$this->load->model('model_packageplans');

		$combos = array("combo_text", "combo_call", "combo_surf", "combo_idd");
		
		$data = array();
		$combo_ids = array();
		/*$text = array();
		$call = array();
		$surf = array();
		$idd = array();*/

		//foreach($combos as $key_combo){
		//$combo_name = $combos[$key_combo]; 
		$combo_details = $this->input->post("combo_text");

		//echo "<pre>";var_dump($combo_details); exit;
		foreach($combo_details as $key_bundle){
			array_push($combo_ids, $this->cleanStringForDB($key_bundle));
		}

		$combo_details = $this->input->post("combo_call");
		foreach($combo_details as $key_bundle){
			array_push($combo_ids, $this->cleanStringForDB($key_bundle));
		}

		$combo_details = $this->input->post("combo_surf");
		foreach($combo_details as $key_bundle){
			array_push($combo_ids, $this->cleanStringForDB($key_bundle));
		}

		$combo_details = $this->input->post("combo_idd");
		foreach($combo_details as $key_bundle){
			array_push($combo_ids, $this->cleanStringForDB($key_bundle));
		}
		//}
															
		/*$data['combo_text'] 									= $text;
		$data['combo_call'] 									= $call;
		$data['combo_surf'] 									= $surf;
		$data['combo_idd'] 										= $idd;*/
		$data['combo_ids']										= $combo_ids;
		$data['plan_id'] 										= $this->cleanStringForDB($this->input->post('plan_id'));
		$data['status']											= $this->cleanStringForDB($this->input->post('status'));

		/*if( !$this->input->post('status') 
			|| $this->input->post('status') == '' 
			|| $this->input->post('status') == 'disabled' )
		{ 
			$data['status'] 									= 0;
		}elseif( $this->input->post('status') == 'enabled' ){
			$data['status'] 									= 1;
		}else{
			$data['status'] 									= 0;
		}*/
		//get accessory_id
		$plan_id = $this->input->post('plan_id');
		
		//echo "<pre>";var_dump($data); exit;
		//update accessory
		$this->model_packageplans->updatePackagePlans($data);
		
		// log changes

		$package_plan = trim($this->model_packageplans->getPackagePlans($plan_id)[0]['title']);
		$log = "Updated package plan " . $package_plan;
		$timestamp = date("Y-m-d H:i:s");
		$this->model_main->addLog($log, "Update package plan", $timestamp);
		
		$user_type = $this->session->userdata('user_type');	
		
		$filter_arr = array();
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
		
		// retrieve package plans
		$pagination_limit = 5;
		$current_page = 1;
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;

		$package_plans_arr = $this->model_packageplans->getPackagePlans();
		$package_plans_total_count = $package_plans_arr['total_count'];
		unset($package_plans_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['package_plans'] == $package_plans_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'packageplans',
								'filter_arr' => $filter_arr,
								'item_count' => $package_plans_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "packageplans";
		$_data['item_count'] = $item_count;
		$_data['packge_plans'] = $package_plans_arr;
		$_data['legend'] = $this->load->view('admin/view_packageplans_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_packageplans_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$_data['content'] = $this->load->view('admin/view_packageplans', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
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
		$this->load->model('model_packageplans');
		
		if( $this->input->post('id') ){
			$package_id = $this->input->post('id');
		}else{
			$package_id = 0;
		}
		
		//delete accessory
		$package_details = $this->model_packageplans->deletePackagePlan($package_id);
		
		// log changes
		$package_plan = trim($package_details['title']);
		$log = "Deleted package plan " . $package_plan;
		$timestamp = date("Y-m-d H:i:s");
		$this->model_main->addLog($log, "Delete package plan ", $timestamp);
		
		$user_type = $this->session->userdata('user_type');	
		
		$filter_arr = array();
		if ($this->input->post('filter')) {
			$filter_arr['letter'] = $this->input->post('letter');
		}
	
		// retrieve package plans
		$pagination_limit = 5;
		$current_page = 1;
		$property_id = null;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;

		$package_plans_arr = $this->model_packageplans->getPackagePlans();
		$package_plans_total_count = $package_plans_arr['total_count'];
		unset($package_plans_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['package_plans'] == $package_plans_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'filter' => $this->input->post('filter'),
								'labels' => $this->getAlphabet(),
								'filter_arr' => $filter_arr);
		$_pagination = array(	'page' => 'packageplans',
								'filter_arr' => $filter_arr,
								'item_count' => $package_plans_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "packageplans";
		$_data['item_count'] = $item_count;
		$_data['packge_plans'] = $package_plans_arr;
		$_data['legend'] = $this->load->view('admin/view_packageplans_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_packageplans_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$_data['content'] = $this->load->view('admin/view_packageplans', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
}
?>