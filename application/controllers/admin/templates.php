<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Templates extends MY_Controller 
{

	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata['logged_in']) { redirect(site_url('admin/logout')); } // logged in?
		
		if( $this->session->userdata('user_type') && $this->session->userdata('user_type') < 10 ){ 
			// is non-ecommerce users
			// allow access
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
		$this->load->model('model_templates');
	
		$company_id = $this->session->userdata('company_id');
		$user_type = $this->session->userdata('user_type');		
	
		if ($this->input->post('filter')) {
			$filter_arr = array('letter' => $this->input->post('letter'),
								'template_type' => $this->input->post('template_type'));
		}
	
		$pagination_limit = 10;
		$current_page = 1;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$template_arr = $this->model_templates->getTemplates(	$company_id, 
																$user_type, 
																'templates.title', 
																'asc', 
																$limit, 
																$pagination_limit, 
																$filter_arr);
		$template_total_count = $template_arr['total_count'];
		unset($template_arr['total_count']);
		$template_arr = $this->getTemplateScreenshotPath($template_arr);
		$template_arr = $this->addIdAsCode($template_arr, "template_id", 5);
	
		// populate reponse
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'has_filter' => $this->input->post('filter'),
								'titles' => $this->getAlphabet(),
								'filter_arr' => $filter_arr,
								'types' => $this->populateTemplateTypes());
		$_pagination = array(	'page' => 'templates',
								'filter_arr' => $filter_arr,
								'item_count' => $template_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
	
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "templates";
		$_data['templates'] = $template_arr;
		$_data['filter'] = $this->load->view('admin/view_templates_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view("admin/view_pagination", $_pagination, TRUE);
		$_data['content'] = $this->load->view("admin/view_templates", $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function add()
	{
		$company_id = $this->session->userdata('company_id');
		$user_type = $this->session->userdata('user_type');	
		
		// determine if permission denied
		if ($user_type != ROLE_SUPER_ADMIN) {
			$_data['sess_user'] = $this->session->userdata;
			$_data['page'] = "error"; 
			$_data['content'] = $this->load->view('error/view_error_denied', $_data, TRUE);
			$this->load->view('admin/view_main_back', $_data);
			return;
		}
	
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "templates"; // templates
		$_data['template_types'] = $this->populateTemplateTypes();		
		$_data['content'] = $this->load->view('admin/view_templates_add', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function edit($template_id)
	{
		$this->load->model('model_templates');
		
		$company_id = $this->session->userdata('company_id');
		$user_type = $this->session->userdata('user_type');	
		
		// get template details
		$template_details = $this->model_templates->getTemplateDetails($template_id);
		
		// determine if permission denied
		if ($user_type != ROLE_SUPER_ADMIN) {
			$_data['sess_user'] = $this->session->userdata;
			$_data['page'] = "error"; 
			$_data['content'] = $this->load->view('error/view_error_denied', $_data, TRUE);
			$this->load->view('admin/view_main_back', $_data);
			return;
		}
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "templates"; 
		$_data['template_types'] = $this->populateTemplateTypes();
		$_data['template_details'] = $template_details;
		$_data['content'] = $this->load->view('admin/view_templates_edit', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function process_add()
	{
		$this->load->model('model_templates');
		
		$company_id = $this->session->userdata('company_id');
		$user_type = $this->session->userdata('user_type');	
		
		$user_id = $this->session->userdata('user_id');
		$title = $this->cleanStringForDB($this->input->post('title'));
		$folder_name = $this->cleanString($title, "_");
		$template_type = $this->input->post('template_type');
		$description = $this->cleanStringForDB($this->input->post('description'));
		$responsive = ($this->input->post('responsive') == "yes") ? 1 : 0;
		$timestamp = date("Y-m-d H:i:s", now());
		
		// insert record
		$this->model_templates->addTemplate($title, $template_type, $description, $folder_name, $responsive, $timestamp);
		
		// log changes
		$log = "Added template ".$title;
		$this->model_main->addLog($log, "Add template", $timestamp);
		
		// create directory for the new property
		$template_folder = $this->config->item("base_template_path").$folder_name;
		@mkdir($template_folder);
		
		$current_page = 1;
		$pagination_limit = 10;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$template_arr = $this->model_templates->getTemplates($company_id, $user_type, "templates.title", "asc", $limit, $pagination_limit);
		$template_total_count = $template_arr['total_count'];
		unset($template_arr['total_count']);
		$template_arr = $this->getTemplateScreenshotPath($template_arr);
		$template_arr = $this->addIdAsCode($template_arr, "template_id", 5);
		
		// populate reponse
		$_filter = array(		'has_filter' => 1,
								'current_page' => 1,
								'titles' => $this->getAlphabet(),
								'filter_arr' => $filter_arr,
								'types' => $this->populateTemplateTypes());
		$_pagination = array(	'page' => 'templates',
								'item_count' => $template_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['templates'] = $template_arr;
		$_data['filter'] = $this->load->view('admin/view_templates_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$this->load->view('admin/view_templates', $_data);
		return;
	}
	
	public function process_edit()
	{
		$this->load->model('model_templates');
		
		$company_id = $this->session->userdata('company_id');
		$user_type = $this->session->userdata('user_type');	

		$user_id = $this->session->userdata('user_id');
		$template_id = $this->input->post('template_id');
		$orig_folder_name = $this->input->post('orig_folder_name');
		$title = $this->cleanStringForDB($this->input->post('title'));
		$folder_name = $this->cleanString($title, "_");
		$template_type = $this->input->post('template_type');
		$description = $this->cleanStringForDB($this->input->post('description'));
		$responsive = ($this->input->post('responsive') == "yes") ? 1 : 0;
		$timestamp = date("Y-m-d H:i:s", now());
		
		// update record
		$this->model_templates->editTemplate(	$template_id, 
												addslashes($title), 
												addslashes($folder_name), 
												$template_type,
												addslashes($description),
												$responsive,
												$timestamp);
		$template_details = $this->model_templates->getTemplateDetails($template_id);
		
		// log changes
		$log = "Edited template ".$title;
		$this->model_main->addLog($log, "Edit template", $timestamp);
		
		// edit folder name
		$orig_name = $orig_folder_name;
		$orig_folder_name = $this->config->item("base_template_path").$orig_name;
		$new_folder_name = $this->config->item("base_template_path").$folder_name;
		@rename($orig_folder_name, $new_folder_name);
		
		// edit screenshot name
		$orig_screenshot_name = $this->config->item("base_template_path").$orig_name.".png";
		$new_screenshot_name = $this->config->item("base_template_path").$folder_name.".png";
		@rename($orig_screenshot_name, $new_screenshot_name);

		// load response
		$_data['template_details'] = $template_details;
		$_data['template_types'] = $this->populateTemplateTypes();
		$this->load->view('admin/view_templates_edit', $_data);
		return;
	}
	
	public function process_delete()
	{
		$this->load->model('model_templates');
		
		$company_id = $this->session->userdata('company_id');
		$user_type = $this->session->userdata('user_type');	
		
		if ($this->input->post('filter')) {
			$filter_arr = array('letter' => $this->input->post('letter'),
								'template_type' => $this->input->post('template_type'));
		}
		
		$template_id = $this->input->post('template_id');
		$folder_name = $this->input->post('folder_name');
		$current_page = $this->input->post('current_page');
		$timestamp = date("Y-m-d H:i:s", now());
		$template_details = $this->model_templates->getTemplateDetails($template_id);
		$title = $template_details['title'];
		
		// delete property and files in the server
		$this->model_templates->deleteTemplate($template_id);
		$folder_path = $this->config->item("base_template_path").$folder_name;
		@chmod($folder_path, 0777);
		@delete_files($folder_path, true); // delete folder contents
		@rmdir($folder_path); // delete folder itself
		
		// log changes
		$log = "Deleted template ".$title;
		$this->model_main->addLog($log, "Delete template", $timestamp);
		
		// just get the number of templates for this instance
		$template_arr = $this->model_templates->getTemplates(	$company_id, 
																$user_type,
																'title', 
																'asc', 
																1,
																1,																
																$filter_arr);
		// determine if current page still has contents
		$pagination_limit = 10;
		$item_count = $template_arr['total_count'];
		if (($current_page * $pagination_limit) >= $item_count) {
			$current_page = ceil($item_count / $pagination_limit);
		}
		
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		if ($limit < 0) { $limit = 0; $current_page = 1; }
		$template_arr = $this->model_templates->getTemplates(	$company_id, 
																$user_type, 
																'title', 
																'asc', 
																$limit, 
																$pagination_limit,
																$filter_arr);

		$template_total_count = $template_arr['total_count'];
		unset($template_arr['total_count']);
		$template_arr = $this->getTemplateScreenshotPath($template_arr);
		$template_arr = $this->addIdAsCode($template_arr, "template_id", 5);
		
		// populate reponse
		$_filter = array(		'has_filter' => $this->input->post('filter'),
								'current_page' => $current_page,
								'titles' => $this->getAlphabet(),
								'filter_arr' => $filter_arr,
								'types' => $this->populateTemplateTypes());
		$_pagination = array(	'page' => 'templates',
								'filter_arr' => $filter_arr,
								'item_count' => $template_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
	
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['templates'] = $template_arr;		
		$_data['filter'] = $this->load->view('admin/view_templates_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$this->load->view('admin/view_templates', $_data);
		return;
	}
	
	public function process_items()
	{
		$this->load->model('model_templates');
		
		$company_id = $this->session->userdata('company_id');
		$user_type = $this->session->userdata('user_type');	
		
		if ($this->input->post('filter')) {
			$filter_arr = array('letter' => $this->input->post('letter'),
								'template_type' => $this->input->post('template_type'));
		}
		
		$pagination_limit = 10;
		$current_page = $this->input->post('current_page');
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$template_arr = $this->model_templates->getTemplates(	$company_id, 
																$user_type, 
																"title", 
																"asc", 
																$limit, 
																$pagination_limit,
																$filter_arr);
		$template_total_count = $template_arr['total_count'];
		unset($template_arr['total_count']);
		$template_arr = $this->getTemplateScreenshotPath($template_arr);
		$template_arr = $this->addIdAsCode($template_arr, "template_id", 5);
		
		// populate response
		$_filter = array(		'has_filter' => $this->input->post('filter'),
								'current_page' => $current_page,
								'titles' => $this->getAlphabet(),
								'filter_arr' => $filter_arr,
								'types' => $this->populateTemplateTypes());
		$_pagination = array(	'page' => 'templates',
								'filter_arr' => $filter_arr,
								'item_count' => $template_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "templates";
		$_data['templates'] = $template_arr;
		$_data['filter'] = $this->load->view('admin/view_templates_filter', $_filter, true);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, true);
		$this->load->view('admin/view_templates', $_data);
		return;
	}
	
}
?>