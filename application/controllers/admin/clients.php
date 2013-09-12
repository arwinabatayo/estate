<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clients extends MY_Controller 
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
		$this->load->model('model_clients');
	
		$company_id = $this->session->userdata('company_id');
		$user_type = $this->session->userdata('user_type');		
		
		// determine if permission denied
		if ($user_type < ROLE_AGENCY_ADMIN) {
			$_data['sess_user'] = $this->session->userdata;
			$_data['page'] = "error"; 
			$_data['content'] = $this->load->view('error/view_error_denied', $_data, TRUE);
			$this->load->view('admin/view_main_back', $_data);
			return;
		}
	
		if ($this->input->post('filter')) {
			$filter_arr = array('letter' => $this->input->post('letter'),
								'status' => $this->input->post('status'));
		}
	
		// retrieve clients
		$pagination_limit = 50;
		$current_page = 1;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$client_arr = $this->model_clients->getClients(	$user_type, 
														$company_id,
														'title', 
														'asc', 
														$limit, 
														$pagination_limit, 
														$filter_arr);
		$client_total_count = $client_arr['total_count'];
		unset($client_arr['total_count']);
		$client_arr = $this->decodeBase64($client_arr, array('contact_email'));
		$client_arr = $this->getAvatarPath($client_arr);
		$client_arr = $this->addNullIndicators($client_arr, ".....");
		$client_arr = $this->model_clients->getClientAgencies($client_arr);
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'has_filter' => $this->input->post('filter'),
								'filter_arr' => $filter_arr,
								'letters' => $this->getAlphabet());
		$_pagination = array(	'page' => 'clients',
								'item_count' => $client_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
	
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "clients";
		$_data['clients'] = $client_arr;
		$_data['filter'] = $this->load->view('admin/view_clients_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$_data['content'] = $this->load->view('admin/view_clients', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
	}
	
	public function add()
	{
		$company_id = $this->session->userdata('company_id');
		$user_type = $this->session->userdata('user_type');		
		
		// determine if permission denied
		if ($user_type < ROLE_AGENCY_ADMIN) {
			$_data['sess_user'] = $this->session->userdata;
			$_data['page'] = "error"; 
			$_data['content'] = $this->load->view('erorr/view_error_denied', $_data, TRUE);
			$this->load->view('admin/view_main_back', $_data);
			return;
		}
	
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "clients";
		$_data['agents'] = $this->populateAgents();
		$_data['agencies'] = $this->populateAgencies();
		$_data['content'] = $this->load->view('admin/view_clients_add', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function view($client_id)
	{	
		$this->load->model('model_clients');
		$this->load->model('model_users');
			
		$company_id = $this->session->userdata('company_id');
		$user_type = $this->session->userdata('user_type');		
		
		// determine if permission denied
		if ($user_type < ROLE_AGENCY_ADMIN) {
			$_data['sess_user'] = $this->session->userdata;
			$_data['page'] = "error"; 
			$_data['content'] = $this->load->view('error/view_error_denied', $_data, TRUE);
			$this->load->view('admin/view_main_back', $_data);
			return;
		}
		
		// get client details
		$client_details = $this->model_clients->getClientDetails($client_id);
		$client_details = $this->decodeBase64($client_details, array('contact_email'));
		$client_details = $this->addNullIndicators($client_details, "n/a");
		if (file_exists($this->config->item('base_client_path').$client_details['folder']."/logo.png")) {
			$client_details['logo'] = base_url() . "_clients/" . $client_details['folder'] . "/logo.png"; 
		} else {
			$client_details['logo'] = base_url() . "_assets/images/no_logo.png";
		}
		
		// get client features
		$feature_arr = $this->model_clients->getClientFeatures($client_id);
		$feature_total = $this->getTotal($feature_arr, 'price', 2);
		$feature_arr = $this->formatNum($feature_arr, 'price', 2);
		
		// get properties of the client
		$property_arr = $this->model_clients->getClientProperties($client_details['client_id']);
		$property_total_count = $property_arr['total_count'];
		unset($property_arr['total_count']);
		$property_arr = $this->addIdAsCode($property_arr, "template_id", 5);
		$property_arr = $this->getAvatarPath($property_arr);

		// get users under the company
		$user_arr = $this->model_users->getUsersByClientId(	$client_details['client_id'], 
															ROLE_SUPER_ADMIN, 
															"last_name", 
															"asc", 
															0, 
															10);
		$user_total_count = $user_arr['total_count'];
		unset($user_arr['total_count']);
		$user_arr = $this->getAvatarPath($user_arr);
		
		// get clients of the company if it's an agency
		if ($client_details['agency_id'] == 0) {
			$client_arr = $this->model_clients->getAgencyClients($client_details['client_id'], "title", "asc", 0, 'all');
			$client_total_count = $client_arr['total_count'];
			unset($client_arr['total_count']);
			$client_arr = $this->decodeBase64($client_arr, array('contact_email'));
			$client_arr = $this->getAvatarPath($client_arr);
			$client_arr = $this->addNullIndicators($client_arr, ".....");	
		}
		
		// get item count for widgets
		$item_count['properties'] = $property_total_count;
		$item_count['users'] = $user_total_count;
		$item_count['clients'] = $client_total_count;
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "clients";
		$_data['client_details'] = $client_details;
		$_data['features'] = $feature_arr;
		$_data['feature_total'] = $feature_total;
		$_data['properties'] = $property_arr;
		$_data['users'] = $user_arr;
		$_data['clients'] = $client_arr;
		$_data['item_count'] = $item_count;
		$_data['content'] = $this->load->view('admin/view_clients_view', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function edit($client_id)
	{
		$this->load->model('model_clients');
		$this->load->model('model_users');
		
		$company_id = $this->session->userdata('company_id');
		$user_type = $this->session->userdata('user_type');		
		$user_id = $this->session->userdata('user_id');		
		
		// determine if permission denied
		if ($user_type < ROLE_AGENCY_ADMIN) {
			$_data['sess_user'] = $this->session->userdata;
			$_data['page'] = "error"; 
			$_data['content'] = $this->load->view('error/view_error_denied', $_data, TRUE);
			$this->load->view('admin/view_main_back', $_data);
			return;
		}
		
		// get user details 
		$user_details = $this->model_users->getUserDetailsByUserId($user_id);
		
		// get client details
		$client_details = $this->model_clients->getClientDetails($client_id);
		$client_details = $this->decodeBase64($client_details, array('contact_email'));
		if (file_exists($this->config->item('base_client_path').$client_details['folder']."/logo.png")) {
			$client_details['logo'] = base_url() . "_clients/" . $client_details['folder'] . "/logo.png"; 
		} else {
			$client_details['logo'] = base_url() . "_assets/images/no_logo.png";
		}
		
		// get features
		$feature_all = $this->populateFeatures();
		$feature_all = $this->formatNum($feature_all, 'price', 2);
		$feature_arr = $this->model_clients->getClientFeatures($client_id);
		$feature_list = array();
		if ($feature_arr) {
		foreach ($feature_arr as $feature => $f) {
			$feature_list[] = $f['feature_id'];
		}
		}
		
		$logo_url = base_url() . "admin/settings/logo/" . $client_details['client_id'];
		$folder_path = $this->config->item("base_client_path") . $client_details['folder'];
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "clients";
		$_data['features'] = $feature_list;
		$_data['feature_all'] = $feature_all;
		$_data['agents'] = $this->populateAgents();
		$_data['agencies'] = $this->populateAgencies('title_short', 'ASC');
		$_data['client_details'] = $client_details;
		$_data['user_details'] = $user_details;
		$_data['folder_path'] = $folder_path;
		$_data['logo_url'] = $logo_url;
		$_data['content'] = $this->load->view('admin/view_clients_edit', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function process_add()
	{
		$this->load->model('model_clients');
	
		$company_id = $this->session->userdata('company_id');
		$user_type = $this->session->userdata('user_type');
		
		$user_id = $this->session->userdata('user_id');
		$title = $this->cleanStringForDB($this->input->post('title'));
		$title_short = $this->cleanStringForDB($this->input->post('title_short'));
		$folder_name = $this->cleanString($title, "_");
		$contact_name = $this->cleanStringForDB($this->input->post('contact_name'));
		$contact_email = base64_encode($this->cleanStringForDB($this->input->post('contact_email')));
		$agent_id = $this->input->post('agent_id');
		if ($this->input->post('agency') == "none") { $agency_id = 0; } else { $agency_id = $this->input->post('agency'); }
		if ($this->input->post('status') == "active") { $status = 1; } else { $status = 0; }
		if ($this->input->post('templates_access') == "yes") { $templates_access = 1; } else { $templates_access = 0; }
		$timestamp = date("Y-m-d H:i:s", now());
		
		// insert record
		$this->model_clients->addClient($title,
										$title_short,
										$contact_name, 
										$contact_email, 
										$status, 
										$folder_name,
										$agent_id,
										$agency_id,
										$templates_access);
		
		// log changes
		$log = "Added client ".$title;
		$this->model_main->addLog($log, "Add client", $timestamp);
		
		// create directory for the new client
		$client_folder = $this->config->item("base_client_path").$folder_name;
		@mkdir($client_folder);
		
		$current_page = 1;
		$pagination_limit = 50;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$client_arr = $this->model_clients->getClients($user_type, $company_id, "title", "asc", $limit, $pagination_limit);
		$client_total_count = $client_arr['total_count'];
		unset($client_arr['total_count']);
		$client_arr = $this->decodeBase64($client_arr, array('contact_email'));
		$client_arr = $this->getAvatarPath($client_arr);
		$client_arr = $this->addNullIndicators($client_arr, ".....");	
		$client_arr = $this->model_clients->getClientAgencies($client_arr);
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'has_filter' => 1,
								'current_page' => 1,
								'filter_arr' => $filter_arr,
								'letters' => $this->getAlphabet());
		$_pagination = array(	'page' => 'clients',
								'item_count' => $client_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
	
		// load response
		$_data['clients'] = $client_arr;
		$_data['filter'] = $this->load->view('admin/view_clients_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$this->load->view('admin/view_clients', $_data);
		return;
	}
	
	public function process_edit()
	{
		$this->load->model('model_clients');
		$this->load->model('model_users');
		
		$user_id = $this->session->userdata('user_id');
		$client_id = $this->input->post('client_id');
		$orig_folder_name = $this->input->post('orig_folder_name');
		$title = $this->cleanStringForDB($this->input->post('title'));
		$title_short = $this->cleanStringForDB($this->input->post('title_short'));
		$folder_name = $this->cleanString($title, "_");
		$contact_name = $this->cleanStringForDB($this->input->post('contact_name'));
		$features = $this->input->post('features');
		$contact_email = base64_encode($this->cleanStringForDB($this->input->post('contact_email')));
		$agent_id = $this->input->post('agent_id');
		if ($this->input->post('status') == "active") { $status = 1; } else { $status = 0; }
		if ($this->input->post('templates_access') == "yes") { $templates_access = 1; } else { $templates_access = 0; }
		$timestamp = date("Y-m-d H:i:s", now());
		
		// get user details 
		$user_details = $this->model_users->getUserDetailsByUserId($user_id);
	
		// update record
		$this->model_clients->editClient(	$client_id, 
											addslashes($title), 
											addslashes($title_short), 
											addslashes($folder_name), 
											addslashes($contact_name),
											addslashes($contact_email),
											$status,
											$agent_id,
											$templates_access);
											
		$client_details = $this->model_clients->getClientDetails($client_id);
		$client_details = $this->decodeBase64($client_details, array('contact_email'));
		if (file_exists($this->config->item('base_client_path').$client_details['folder']."/logo.png")) {
			$client_details['logo'] = base_url() . "_clients/" . $client_details['folder'] . "/logo.png"; 
		} else {
			$client_details['logo'] = base_url() . "_assets/images/no_logo.png";
		}
		
		// deactivate all users under the client
		if ($status == 0) { $this->model_clients->deactivateUsersByClientId($client_id); }
		
		// log changes
		$log = "Edited client ".$title;
		$this->model_main->addLog($log, "Edit client", $timestamp);
		
		// edit folder name also
		$orig_folder_name = $this->config->item("base_client_path").$orig_folder_name;
		$new_folder_name = $this->config->item("base_client_path").$folder_name;
		@rename($orig_folder_name, $new_folder_name);
		
		// update features
		$this->model_clients->updateFeatures($client_id, $features);
		
		// re-set session variables
		if ($client_id == $this->session->userdata('company_id')) {
			$company_features_arr = $this->model_clients->getClientFeatures($client_id);
			$company_features = array();
			$counter = 0;
			if ($company_features_arr) {
			foreach ($company_features_arr as $features => $f) {
				$company_features[$counter]['feature_id'] = $f['feature_id'];
				$company_features[$counter]['feature_title'] = $f['feature_title'];
				$company_features[$counter]['template_type_id'] = $f['template_type_id'];
				$company_features[$counter]['limit'] = $f['limit'];
				$counter++;
			}
			}
			$templates_allowed = $this->getTemplatesAllowed($company_features);

			$newdata = array(
				'company_features'  => $company_features,
				'templates_allowed'  => $templates_allowed
			);
			$this->session->set_userdata($newdata);
		}
		
		// get features
		$feature_all = $this->populateFeatures();
		$feature_all = $this->formatNum($feature_all, 'price', 2);
		$feature_arr = $this->model_clients->getClientFeatures($client_id);
		$feature_list = array();
		if ($feature_arr) {
		foreach ($feature_arr as $feature => $f) {
			$feature_list[] = $f['feature_id'];
		}
		}
		
		$logo_url = base_url() . "admin/settings/logo/" . $client_details['company_id'];
		$folder_path = $this->config->item("base_client_path") . $client_details['folder'];
		
		// load response
		$_data['features'] = $feature_list;
		$_data['feature_all'] = $feature_all;
		$_data['logo_url'] = $logo_url;
		$_data['client_details'] = $client_details;
		$_data['user_details'] = $user_details;
		$_data['folder_path'] = $folder_path;
		$_data['agents'] = $this->populateAgents();	
		$this->load->view('admin/view_clients_edit', $_data);
		return;
	}
	
	public function process_deactivate()
	{
		$this->load->model('model_clients');
		
		$company_id = $this->session->userdata('company_id');
		$user_type = $this->session->userdata('user_type');
	
		if ($this->input->post('filter')) {
			$filter_arr = array('letter' => $this->input->post('letter'),
								'status' => $this->input->post('status'));
		}
	
		$client_id = $this->input->post('client_id');
		$timestamp = date("Y-m-d H:i:s", now());
		$current_page = $this->input->post('current_page');
		$client_details = $this->model_clients->getClientDetails($client_id);
		$title = $client_details['title'];
		
		// deactivate client and users
		$this->model_clients->deactivateClient($client_id);
		$this->model_clients->deactivateUsersByClientId($client_id);
		
		// log changes
		$log = "Deactivated client ".$title;
		$this->model_main->addLog($log, "Deactivate client", $timestamp);
		
		
		// just get the number of clients for this instance
		$client_arr = $this->model_clients->getClients(	'title', 
														'asc',
														1, 
														1,
														$filter_arr);
		// determine if current page still has contents
		$pagination_limit = 50;
		$item_count = $client_arr['total_count'];
		if (($current_page * $pagination_limit) >= $item_count) {
			$current_page = ceil($item_count / $pagination_limit);
		}
		
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		if ($limit < 0) { $limit = 0; $current_page = 1; }
		$client_arr = $this->model_clients->getClients(	'title', 
														'asc',
														$limit, 
														$pagination_limit,
														$filter_arr);
		$client_total_count = $client_arr['total_count'];
		unset($client_arr['total_count']);
		$client_arr = $this->addNullIndicators($client_arr, ".....");
				
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'has_filter' => $this->input->post('filter'),
								'current_page' => $current_page,
								'filter_arr' => $filter_arr,
								'letters' => $this->getAlphabet());
		$_pagination = array(	'page' => 'clients',
								'filter_arr' => $filter_arr,
								'item_count' => $client_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
								
		// load response
		$_data['clients'] = $client_arr;		
		$_data['filter'] = $this->load->view('admin/view_clients_filter', $_filter, true);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, true);
		$this->load->view('admin/view_clients', $_data);
		return;
	}
	
	public function process_items()
	{
		$this->load->model('model_clients');
		
		$company_id = $this->session->userdata('company_id');
		$user_type = $this->session->userdata('user_type');	
		
		if ($this->input->post('filter')) {
			$filter_arr = array('letter' => $this->input->post('letter'),
								'status' => $this->input->post('status'));
		}
		
		// retrieve clients
		$pagination_limit = 50;
		$current_page = $this->input->post('current_page');
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$client_arr = $this->model_clients->getClients(	$user_type,
														$company_id, 
														'title', 
														'asc', 
														$limit, 
														$pagination_limit, 
														$filter_arr);
		$client_total_count = $client_arr['total_count'];
		unset($client_arr['total_count']);
		$client_arr = $this->decodeBase64($client_arr, array('contact_email'));
		$client_arr = $this->getAvatarPath($client_arr);
		$client_arr = $this->addNullIndicators($client_arr, ".....");
		$client_arr = $this->model_clients->getClientAgencies($client_arr);

		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'has_filter' => $this->input->post('filter'),
								'current_page' => $current_page,
								'filter_arr' => $filter_arr,
								'letters' => $this->getAlphabet());
		$_pagination = array(	'page' => 'clients',
								'filter_arr' => $filter_arr,
								'item_count' => $client_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
								
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "clients";  	
		$_data['clients'] = $client_arr;
		$_data['filter'] = $this->load->view('admin/view_clients_filter', $_filter, true);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, true);
		$this->load->view('admin/view_clients', $_data);
		return;
	}
	
}
?>