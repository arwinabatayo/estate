<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Properties extends MY_Controller 
{

	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata['logged_in']) { redirect(site_url('admin/logout')); } // logged in?
	}
	
	public function index()
	{
		$this->load->model('model_users');
		$this->load->model('model_properties');
	
		$company_id = $this->session->userdata('company_id');
		$user_type = $this->session->userdata('user_type');	
	
		if ($this->input->post('filter')) {
			$filter_arr = array('client_id' => $this->input->post('client_id'),
								'letter' => $this->input->post('letter'),
								'template_id' => $this->input->post('template_id'),
								'template_type' => $this->input->post('template_type'),
								'user_id' => $this->input->post('user_id'));
		}
	
		// retrieve properties
		$pagination_limit = 50;
		$current_page = 1;
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$property_arr = $this->model_properties->getProperties($company_id, 
																$user_type, 
																"properties.title", 
																"asc", 
																$limit,
																$pagination_limit,
																$filter_arr);
		$property_total_count = $property_arr['total_count'];
		unset($property_arr['total_count']);
		$property_arr = $this->addIdAsCode($property_arr, "template_id", 5);
		$property_arr = $this->getAvatarPath($property_arr);
		
		// get list of users for filtering
		$user_arr = $this->model_users->getUsers($company_id, $user_type, 'username', 'asc', 0, 'all');
		unset($user_arr['total_count']);
		
		// get list of items count
		$item_count = array();
		$item_count['properties'] == $property_total_count;
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'current_page' => $current_page,
								'has_filter' => $this->input->post('filter'),
								'clients' => $this->populateClients('title_short', 'ASC'),
								'titles' => $this->getAlphabet(),
								'templates' => $this->populateTemplates(),
								'types' => $this->populateTemplateTypes(),
								'filter_arr' => $filter_arr,
								'users' => $user_arr);
		$_pagination = array(	'page' => 'properties',
								'filter_arr' => $filter_arr,
								'item_count' => $property_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "properties";
		$_data['item_count'] = $item_count;
		$_data['properties'] = $property_arr;
		$_data['legend'] = $this->load->view('admin/view_properties_legend', NULL, TRUE);
		$_data['filter'] = $this->load->view('admin/view_properties_filter', $_filter, TRUE);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);
		$_data['content'] = $this->load->view('admin/view_properties', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function add()
	{
		// post template id from templates page
		$template_id = "";
		if ($this->input->post('template_id')) { $template_id = $this->input->post('template_id'); }
		
		//load model
		$this->load->model('model_products');
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "properties";
		$_data['clients'] = $this->populateClients();
		$_data['products'] = $this->model_products->getAllProducts();
		$_data['templates'] = $this->populateTemplates();
		$_data['template_types'] = $this->populateTemplateTypes();
		$_data['template_id'] = $template_id;
		$_data['content'] = $this->load->view('admin/view_properties_add', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function edit($property_id)
	{
		$this->load->model('model_users');
		$this->load->model('model_properties');
		
		$company_id = $this->session->userdata('company_id');
		$user_type = $this->session->userdata('user_type');
		
		$user_arr = $this->model_users->getUsers(	$company_id, 
													$user_type, 
													"last_name", 
													"asc", 
													0,
													"all", 
													$filter_arr);
		unset($user_arr['total_count']);
													
		// retrieve site data from xml
		$property_details = $this->model_properties->getPropertyDetails($property_id);
		$property_details['template_id_code'] = $this->padDigit($property_details['template_id'], 5);
		$property_details['xml_url'] = base_url() . "_properties/" . $property_details['folder_name'] . "/includes/data.xml";
		$folder_path = $this->config->item("base_property_path") . $property_details['folder_name'];		
		if (file_exists($folder_path."/includes/data.xml")) {
			$site_data = $this->xml2array(file_get_contents($folder_path."/includes/data.xml"), 1, 'attribute');
			$site_data = $this->cleanArrayAddLabel($site_data['site']);
		}
		
		// add preview_url if mobile app
		if ($property_details['template_type_id'] == 4) {
			if (file_exists($folder_path."/preview.swf")) {
				$property_details['preview_url'] = base_url() . "_properties/" . $property_details['folder_name'] . "/preview.html";
				$property_details['preview_url_type'] = "swf";
			} else {
				$property_details['preview_url'] = base_url() . "_properties/" . $property_details['folder_name'] . "/preview/app.html";
				$property_details['preview_url_type'] = "html5";
			}
		}
		
		// determine if permission denied
		if (($company_id != $property_details['client_id']) && ($user_type < ROLE_AGENCY_ADMIN)) {
			$_data['sess_user'] = $this->session->userdata;
			$_data['page'] = "error"; 
			$_data['content'] = $this->load->view('view_error_denied', $_data, TRUE);
			$this->load->view('view_main', $_data);
			return;
		}
		
		// function needed for uksort
		function cmp($a, $b)
		{
			$anum = substr($a, strrpos($a, '_')+1);
			$bnum = substr($b, strrpos($b, '_')+1);
			
			if ($anum == $bnum) { 
				return strcasecmp($a, $b);
			}
			return ($anum < $bnum) ? -1 : 1;
		}
		
		// add the parent to each field before grouping
		if ($site_data) {
		foreach ($site_data as $sdata => $sd) { 
			if ($sd) {
			foreach ($sd as $key => $value) {
				if ($key != "label") { $site_data[$sdata][$key]['attr']['parent'] = $sdata; }
			}
			}
		}
		}
		
		// group site data
		$grouped_data = array();
		if ($site_data) {
		foreach ($site_data as $sdata => $sd) {
			if ($sd['attr']['group']) {
				if ($sd['attr']['sub_group']) {	
					if ($grouped_data[$sd['attr']['group']][$sd['attr']['sub_group']]) {
						$grouped_data[$sd['attr']['group']][$sd['attr']['sub_group']] = $grouped_data[$sd['attr']['group']][$sd['attr']['sub_group']] + $sd;
						uksort($grouped_data[$sd['attr']['group']][$sd['attr']['sub_group']], "cmp");
					} else {
						$grouped_data[$sd['attr']['group']][$sd['attr']['sub_group']] = $sd;
					}
				} else {
					$grouped_data[$sd['attr']['group']][$sd['attr']['group']] = $sd;
				}
			} else { 
				$grouped_data[$sdata][$sdata] = $sd;
			}
		}
		}
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "properties";
		$_data['clients'] = $this->populateClients();
		$_data['users'] = $user_arr;
		$_data['templates'] = $this->populateTemplates();
		$_data['property_details'] = $property_details;
		$_data['folder_path'] = $folder_path."/assets";
		$_data['site_data'] = $grouped_data;
		$_data['current_active_tab'] = ($this->input->post('current_active_tab')) ? $this->input->post('current_active_tab') : 1;
		$_data['upload_reference'] = ($this->input->post('reference')) ? $this->input->post('reference') : 0;
		$_data['content'] = $this->load->view('admin/view_properties_edit', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function manage_assets($property_id)
	{	
		$this->load->model('model_properties');
		
		$company_id = $this->session->userdata('company_id');
		$user_type = $this->session->userdata('user_type');
		
		$property_details = $this->model_properties->getPropertyDetails($property_id);
		$folder_path = $this->config->item("base_property_path") . $property_details['folder_name'] . "/assets";	
		$file_arr = get_dir_file_info($folder_path, TRUE);
		$file_arr_return = $this->detailedFileArr($file_arr, $property_details['folder_name']);
	
		// determine if permission denied
		if (($company_id != $property_details['client_id']) && ($user_type != ROLE_SUPER_ADMIN)) {
			$_data['sess_user'] = $this->session->userdata;
			$_data['page'] = "error"; 
			$_data['content'] = $this->load->view('error/view_error_denied', $_data, TRUE);
			$this->load->view('admin/view_main_back', $_data);
			return;
		}
		
		if ($this->input->post('filter')) {
			$filter_arr = array('letter' => $this->input->post('file_name'));
		}
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'has_filter' => $this->input->post('filter'),
								'titles' => $this->getAlphabet(),
								'property_id' => $property_id,
								'filter_arr' => $filter_arr);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "properties"; // properties
		$_data['clients'] = $this->populateClients();
		$_data['templates'] = $this->populateTemplates();
		$_data['property_details'] = $property_details;
		$_data['folder_path'] = $folder_path;
		$_data['file_arr'] = $file_arr_return;
		$_data['filter'] = $this->load->view('admin/view_manage_assets_filter', $_filter, TRUE);
		$_data['content'] = $this->load->view('admin/view_manage_assets', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function process_add()
	{	
		$this->load->model('model_users');
		$this->load->model('model_properties');
		$this->load->model('model_templates');
	
		$company_id = $this->session->userdata('company_id');
		$user_type = $this->session->userdata('user_type');		
	
		$user_arr = $this->model_users->getUsers(	$company_id, 
													$user_type, 
													"last_name", 
													"asc", 
													0,
													"all", 
													$filter_arr);
		unset($user_arr['total_count']);
	
		$user_id = $this->session->userdata('user_id');
		$client_id = $this->input->post('client_id');
		$title = $this->cleanStringForDB($this->input->post('title'));
		$folder_name = $this->cleanString($title, "_");
		$template_id = $this->input->post('template_id');
		$with_assets = $this->input->post('with_assets');
		$timestamp = date("Y-m-d H:i:s", now());
		$description = $this->cleanStringForDB($this->input->post('description'));

		// get template details
		$template_details = $this->model_templates->getTemplateDetails($template_id);
		$template_type_id = $template_details['template_type_id'];
		
		// check first if client has reached the maximum number of items for the specific template type
		$features = $this->session->userdata('company_features');
		
		if ($features) {
		foreach ($features as $feature => $f) {
			if ($f['template_type_id'] == $template_type_id) { $template_limit = $f['limit']; }
		}
		}

		// just get the number of properties for this instance
		$filter_arr = array('template_type' => $template_type_id);
		$property_arr = $this->model_properties->getProperties($company_id, 
																$user_type, 
																"properties.title", 
																'asc', 
																1,
																1,
																$filter_arr);
		$property_total_count = $property_arr['total_count'];

		// if template_limit is 0, he can create unlimited sites for the particular template type
		if (($template_limit > $property_total_count) || ($template_limit == 0)) {
		
			// insert record
			$property_id = $this->model_properties->addProperty($client_id, $template_id, $title, $folder_name, $user_id, $timestamp, $description);
			
			// log changes
			$log = "Added property ".$title;
			$this->model_main->addLog($log, "Add property", $timestamp);
			
			// create directory for the new property
			$new_folder = $this->config->item("base_property_path").$folder_name;
			@mkdir($new_folder);
			@chmod($new_folder, 0755);
			
			// copy all content of template folder to new_folder
			$template_details = $this->model_templates->getTemplateDetails($template_id);
			$template_folder = $this->config->item("base_template_path") . $template_details['folder'];
			$files_arr = get_filenames($template_folder, FALSE, TRUE);
			$this->copyTemplateToSite($files_arr, $template_folder, $new_folder);
			
			// delete assets if the user selecte 'no assets'
			if ($with_assets == "no") {
				$folder_path = $this->config->item("base_property_path").$folder_name."/assets";
				$files = glob($folder_path . "/*");
				foreach($files as $file) {
					if(is_file($file)) { @unlink($file); }
				}
			}
			
			// retrieve property details
			$property_details = $this->model_properties->getPropertyDetails($property_id);
			$property_details['template_id_code'] = $this->padDigit($property_details['template_id'], 5);
			$property_details['xml_url'] = base_url() . "_properties/" . $property_details['folder_name'] . "/includes/data.xml";
			
			// retrieve site data from xml	
			$folder_path = $this->config->item("base_property_path").$folder_name;
			if (file_exists($folder_path."/includes/data.xml")) {
				$site_data = $this->xml2array(file_get_contents($folder_path."/includes/data.xml"), 1, 'attribute');
				$site_data = $this->cleanArrayAddLabel($site_data['site']);
			}
			
			// add preview_url if mobile app
			if ($property_details['template_type_id'] == 4) {
				if (file_exists($this->config->item("base_property_path").$folder_name."/preview.swf")) {
					$property_details['preview_url'] = base_url() . "_properties/" . $property_details['folder_name'] . "/preview.html";
					$property_details['preview_url_type'] = "swf";
				} else {
					$property_details['preview_url'] = base_url() . "_properties/" . $property_details['folder_name'] . "/preview/app.html";
					$property_details['preview_url_type'] = "html5";
				}
			}
				
			// function needed for uksort
			function cmp($a, $b)
			{
				$anum = substr($a, strrpos($a, '_')+1);
				$bnum = substr($b, strrpos($b, '_')+1);
				
				if ($anum == $bnum) { 
					return strcasecmp($a, $b);
				}
				return ($anum < $bnum) ? -1 : 1;
			}
			
			// add the parent to each field before grouping
			if ($site_data) {
			foreach ($site_data as $sdata => $sd) { 
				if ($sd) {
				foreach ($sd as $key => $value) {
					if ($key != "label") { $site_data[$sdata][$key]['attr']['parent'] = $sdata; }
				}
				}
			}
			}
			
			// group site data
			$grouped_data = array();
			if ($site_data) {
			foreach ($site_data as $sdata => $sd) {
				if ($sd['attr']['group']) {
					if ($sd['attr']['sub_group']) {	
						if ($grouped_data[$sd['attr']['group']][$sd['attr']['sub_group']]) {
							$grouped_data[$sd['attr']['group']][$sd['attr']['sub_group']] = $grouped_data[$sd['attr']['group']][$sd['attr']['sub_group']] + $sd;
							uksort($grouped_data[$sd['attr']['group']][$sd['attr']['sub_group']], "cmp");
						} else {
							$grouped_data[$sd['attr']['group']][$sd['attr']['sub_group']] = $sd;
						}
					} else {
						$grouped_data[$sd['attr']['group']][$sd['attr']['group']] = $sd;
					}
				} else { 
					$grouped_data[$sdata][$sdata] = $sd;
				}
			}
			}
			
			// load response
			$_data['sess_user'] = $this->session->userdata;
			$_data['page'] = "properties";
			$_data['page_sub'] = "edit";
			$_data['users'] = $user_arr;
			$_data['clients'] = $this->populateClients();
			$_data['templates'] = $this->populateTemplates();
			$_data['property_details'] = $property_details;
			$_data['folder_path'] = $folder_path."/assets";
			$_data['site_data'] = $grouped_data;
			$_data['current_active_tab'] = 1;
			$this->load->view('admin/view_properties_edit', $_data);
			
		} else {
		
			// post template id from templates page
			$template_id = "";
			if ($this->input->post('template_id')) { $template_id = $this->input->post('template_id'); }
		
			// load response
			$_data['sess_user'] = $this->session->userdata;
			$_data['page'] = "properties";
			$_data['page_sub'] = "add";
			$_data['clients'] = $this->populateClients();
			$_data['templates'] = $this->populateTemplates();
			$_data['template_id'] = $template_id;
			$this->load->view('admin/view_properties_add', $_data);
			
		}
		
		return;
	}
	
	public function process_edit()
	{	

		$this->load->model('model_users');
		$this->load->model('model_properties');
		
		$company_id = $this->session->userdata('company_id');
		$user_type = $this->session->userdata('user_type');	
		
		$user_arr = $this->model_users->getUsers(	$company_id, 
													$user_type, 
													"last_name", 
													"asc", 
													0,
													"all", 
													$filter_arr);
		unset($user_arr['total_count']);
		
		$user_id = $this->session->userdata('user_id');
		$owner_id = $this->input->post('owner_id');
		$property_id = $this->input->post('property_id');
		$client_id = $this->input->post('client_id');
		$title = $this->cleanStringForDB($this->input->post('title'));
		$orig_folder_name = $this->input->post('orig_folder_name');
		$folder_name = $this->cleanString($title, "_");
		$template_id = $this->input->post('template_id');
		$timestamp = date("Y-m-d H:i:s", now());
		$description = $this->cleanStringForDB($this->input->post('description'));
		$current_active_tab = $this->input->post('current_active_tab');
		
		// dynamic fields post values
		$add_item = $this->input->post('add_item');
		$remove_item = $this->input->post('remove_item');
		$group = $this->input->post('group');
		$subgroup = $this->input->post('subgroup');
		$element = $this->input->post('element');
		
		// update record
		$this->model_properties->editProperty(	$property_id, 
												$client_id, 
												$template_id, 
												addslashes($title), 
												addslashes($folder_name), 
												$owner_id, 
												$timestamp, 
												addslashes($description));
		$property_details = $this->model_properties->getPropertyDetails($property_id);
		$property_details['template_id_code'] = $this->padDigit($property_details['template_id'], 5);
		$property_details['xml_url'] = base_url() . "_properties/" . $property_details['folder_name'] . "/includes/data.xml";
		
		// log changes
		$log = "Edited property ".$title;
		$this->model_main->addLog($log, "Edit property", $timestamp);
		
		// edit folder name also
		$orig_folder_name = $this->config->item("base_property_path").$orig_folder_name;
		$new_folder_name = $this->config->item("base_property_path").$folder_name;
		@rename($orig_folder_name, $new_folder_name);

		// create backup of current xml before doing any changes
		$folder_name = $this->cleanString($title, "_");
		$folder_path = $this->config->item("base_property_path").$folder_name."/includes/data.xml";
		$backup_path = $this->config->item("base_property_path").$folder_name."/backup/data_".now().".xml";
		@copy($folder_path, $backup_path);
		
		// add preview_url if mobile app
		if ($property_details['template_type_id'] == 4) {
			if (file_exists($this->config->item("base_property_path").$folder_name."/preview.swf")) {
				$property_details['preview_url'] = base_url() . "_properties/" . $property_details['folder_name'] . "/preview.html";
				$property_details['preview_url_type'] = "swf";
			} else {
				$property_details['preview_url'] = base_url() . "_properties/" . $property_details['folder_name'] . "/preview/app.html";
				$property_details['preview_url_type'] = "html5";
			}
		}
		
		// edit contents of data.xml
		$this->processXML($this->input->post());
		
		// if add item
		if ($add_item) {
			
			$folder_name = $this->cleanString($title, "_");
			$folder_path = $this->config->item("base_property_path").$folder_name;
			$site_data = $this->xml2array(file_get_contents($folder_path."/includes/data.xml"), 1, 'attribute');
			$site_data = $this->cleanArrayAddLabel($site_data['site']);
			
			// save all parents with the same subgroup to an array
			$parent_arr = array();
			if ($site_data) {
			foreach ($site_data as $key => $value) { 
				if ($site_data[$key]['attr']['group'] == $group && $site_data[$key]['attr']['sub_group'] == $subgroup) {
					$parent_arr[] = $key;
				}
			}			
			}	
			
			$site = simplexml_load_file($folder_path."/includes/data.xml");
			
			if ($parent_arr) {
			foreach ($parent_arr as $parent => $p) { 
			
				$last_child = "";
			
				// get last child and append the number
				// else get name attribute
				if ($site->$p->children()) {
					foreach ($site->$p->children() as $key => $value) {
						$last_child = $key;
					}
					if (!$last_child) {
						$_attributes = $site->$p->attributes();
						$last_child = $_attributes['name'] . "_0"; 
					}
				}
				
				// get attributes of parent
				$attributes = array();
				if ($site->$p->attributes()) {
				foreach ($site->$p->attributes() as $key => $value) {
					$value = (array)$value;
					$attributes[$key] = $value[0];
					unset($attributes['dynamic']);
					unset($attributes['name']);
					unset($attributes['group']);
					unset($attributes['sub_group']);
				}			
				}			
				
				// get children name
				$last_child = explode("_", $last_child);
				$counter = 0;
				$child_name = "";
				foreach ($last_child as $child => $c) { 	
					if ($counter < (count($last_child)-1)) { $child_name .= $c . "_"; }
					$counter++;
				}
				$new_child = $child_name . (end($last_child) + 1);
				
				// perform write
				$site->$p->addChild($new_child);
				if ($attributes) {
				foreach ($attributes as $key => $value) {
					$site->$p->$new_child->addAttribute($key, $value);
					if ($key == "timestamp") { $site->$p->$new_child = now(); } 
				}
				}
				
				// format xml
				$dom = new DOMDocument('1.0');
				$dom->preserveWhiteSpace = false;
				$dom->formatOutput = true;
				$dom->loadXML($site->asXML());
				$dom->save($folder_path."/includes/data.xml");
				
			}
			}
			
		}
		
		// if remove item
		if ($remove_item) {
		
			$folder_name = $this->cleanString($title, "_");
			$folder_path = $this->config->item("base_property_path").$folder_name;
			$site_data = $this->xml2array(file_get_contents($folder_path."/includes/data.xml"), 1, 'attribute');
			$site_data = $this->cleanArrayAddLabel($site_data['site']);
			
			// save all parents with the same subgroup to an array
			$parent_arr = array();
			if ($site_data) {
			foreach ($site_data as $key => $value) { 
				if ($site_data[$key]['attr']['group'] == $group && $site_data[$key]['attr']['sub_group'] == $subgroup) {
					$parent_arr[] = $key;
				}
			}			
			}	
			
			$data = file_get_contents($folder_path."/includes/data.xml");
			$doc=new SimpleXMLElement($data);
				
			if ($parent_arr) {
			foreach ($parent_arr as $parent => $p) {

				$dom = dom_import_simplexml($doc->$p);
				
				if ($dom->childNodes) {
				foreach($dom->childNodes as $node) {
					if (substr($node->nodeName, strrpos($node->nodeName, '_')+1) == $element) {
						$dom->removeChild($dom->getElementsByTagName($node->nodeName)->item(0));
					}
				}
				}
				
			}
			}
			
			// format xml
			$dom = new DOMDocument('1.0');
			$dom->preserveWhiteSpace = false;
			$dom->formatOutput = true;
			$dom->loadXML($doc->asXML());
			$dom->save($folder_path."/includes/data.xml");
			
		}

		// retrieve site data from xml	
		$folder_path = $this->config->item("base_property_path").$folder_name;
		if (file_exists($folder_path."/includes/data.xml")) {
			$site_data = $this->xml2array(file_get_contents($folder_path."/includes/data.xml"), 1, 'attribute');
			$site_data = $this->cleanArrayAddLabel($site_data['site']);
		}
		
		// function needed for uksort
		function cmp($a, $b)
		{
			$anum = substr($a, strrpos($a, '_')+1);
			$bnum = substr($b, strrpos($b, '_')+1);
			
			if ($anum == $bnum) { 
				return strcasecmp($a, $b);
			}
			return ($anum < $bnum) ? -1 : 1;
		}
		
		// add the parent to each field before grouping
		if ($site_data) {
		foreach ($site_data as $sdata => $sd) { 
			if ($sd) {
			foreach ($sd as $key => $value) {
				if ($key != "label") { $site_data[$sdata][$key]['attr']['parent'] = $sdata; }
			}
			}
		}
		}
		
		// group site data
		$grouped_data = array();
		if ($site_data) {
		foreach ($site_data as $sdata => $sd) {
			if ($sd['attr']['group']) {
				if ($sd['attr']['sub_group']) {	
					if ($grouped_data[$sd['attr']['group']][$sd['attr']['sub_group']]) {
						$grouped_data[$sd['attr']['group']][$sd['attr']['sub_group']] = $grouped_data[$sd['attr']['group']][$sd['attr']['sub_group']] + $sd;
						uksort($grouped_data[$sd['attr']['group']][$sd['attr']['sub_group']], "cmp");
					} else {
						$grouped_data[$sd['attr']['group']][$sd['attr']['sub_group']] = $sd;
					}
				} else {
					$grouped_data[$sd['attr']['group']][$sd['attr']['group']] = $sd;
				}
			} else { 
				$grouped_data[$sdata][$sdata] = $sd;
			}
		}
		}
		
		// load response
		$_data['clients'] = $this->populateClients();
		$_data['users'] = $user_arr;
		$_data['templates'] = $this->populateTemplates();
		$_data['property_details'] = $property_details;
		// $_data['site_data'] = $site_data;
		$_data['site_data'] = $grouped_data;
		$_data['folder_path'] = $folder_path."/assets";
		$_data['current_active_tab'] = $current_active_tab;
		$this->load->view('admin/view_properties_edit', $_data);
		return;
	}
	
	public function process_delete()
	{
		$this->load->model('model_properties');
		$this->load->model('model_users');
	
		$company_id = $this->session->userdata('company_id');
		$user_type = $this->session->userdata('user_type');
		
		if ($this->input->post('filter')) {
			$filter_arr = array('client_id' => $this->input->post('client_id'),
								'letter' => $this->input->post('letter'),
								'template_id' => $this->input->post('template_id'),
								'template_type' => $this->input->post('template_type'),
								'user_id' => $this->input->post('user_id'));
		}
		
		$property_id = $this->input->post('property_id');
		$folder_name = $this->input->post('folder_name');
		$current_page = $this->input->post('current_page');
		$timestamp = date("Y-m-d H:i:s", now());
		
		$property_details = $this->model_properties->getPropertyDetails($property_id);
		
		// delete property and files in the server
		$this->model_properties->deleteProperty($property_id);
		$folder_path = $this->config->item("base_property_path").$folder_name;
		@chmod($folder_path, 0755);
		@delete_files($folder_path, true); // delete folder contents
		@rmdir($folder_path); // delete folder itself
		
		// log changes
		$log = "Deleted property " . $property_details['property_title'];
		$this->model_main->addLog($log, "Delete property", $timestamp);
		
		// just get the number of properties for this instance
		$property_arr = $this->model_properties->getProperties($company_id, 
																$user_type, 
																"properties.title", 
																'asc', 
																1,
																1,
																$filter_arr);
		
		// determine if current page still has contents
		$pagination_limit = 50;
		$item_count = $property_arr['total_count'];
		if (($current_page * $pagination_limit) >= $item_count) {
			$current_page = ceil($item_count / $pagination_limit);
		}
		
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		if ($limit < 0) { $limit = 0; $current_page = 1; }
		$property_arr = $this->model_properties->getProperties($company_id, 
																$user_type, 
																"properties.title", 
																'asc', 
																$limit,
																$pagination_limit,
																$filter_arr);
		$property_total_count = $property_arr['total_count'];
		unset($property_arr['total_count']);
		$property_arr = $this->addIdAsCode($property_arr, "template_id", 5);
		$property_arr = $this->getAvatarPath($property_arr);
	
		// get list of users for filtering
		$user_arr = $this->model_users->getUsers($company_id, $user_type, 'username', 'asc', 0, 'all');
		unset($user_arr['total_count']);
		
		// populate response
		$_filter = array(		'has_filter' => $this->input->post('filter'),
								'clients' => $this->populateClients(),
								'titles' => $this->getAlphabet(),
								'templates' => $this->populateTemplates(),
								'types' => $this->populateTemplateTypes(),
								'filter_arr' => $filter_arr,
								'users' => $user_arr);	
		$_pagination = array(	'page' => 'properties',
								'filter_arr' => $filter_arr,
								'item_count' => $property_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
	
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "properties";
		$_data['properties'] = $property_arr;
		$_data['filter'] = $this->load->view('admin/view_properties_filter', $_filter, TRUE);		
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, TRUE);		
		$this->load->view('admin/view_properties', $_data);
		return;
	}
	
	public function process_items()
	{		
		$this->load->model('model_properties');
		$this->load->model('model_users');
	
		$company_id = $this->session->userdata('company_id');
		$user_type = $this->session->userdata('user_type');	
		
		if ($this->input->post('filter')) {
			$filter_arr = array('client_id' => $this->input->post('client_id'),
								'letter' => $this->input->post('letter'),
								'template_id' => $this->input->post('template_id'),
								'template_type' => $this->input->post('template_type'),
								'user_id' => $this->input->post('user_id'));
		}
		
		$pagination_limit = 50;
		$current_page = $this->input->post('current_page');
		$limit = ($current_page * $pagination_limit) - $pagination_limit;
		$property_arr = $this->model_properties->getProperties($company_id, 
																$user_type, 
																"properties.title",
																"asc", 
																$limit, 
																$pagination_limit, 
																$filter_arr);
		$property_total_count = $property_arr['total_count'];
		unset($property_arr['total_count']);
		$property_arr = $this->addIdAsCode($property_arr, "template_id", 5);
		$property_arr = $this->getAvatarPath($property_arr);
		
		// get list of users for filtering
		$user_arr = $this->model_users->getUsers($company_id, $user_type, 'username', 'asc', 0, 'all');
		unset($user_arr['total_count']);
		$user_arr = $this->getAvatarPath($user_arr);
		
		// populate response
		$_filter = array(		'sess_user' => $this->session->userdata,
								'has_filter' => $this->input->post('filter'),
								'current_page' => $current_page,
								'clients' => $this->populateClients(),
								'titles' => $this->getAlphabet(),
								'templates' => $this->populateTemplates(),
								'types' => $this->populateTemplateTypes(),
								'filter_arr' => $filter_arr,
								'users' => $user_arr);
		$_pagination = array(	'page' => 'properties',
								'filter_arr' => $filter_arr,
								'item_count' => $property_total_count,
								'pagination_limit' => $pagination_limit,
								'current_page' => $current_page);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "properties";  	
		$_data['properties'] = $property_arr;
		$_data['filter'] = $this->load->view('admin/view_properties_filter', $_filter, true);
		$_data['pagination'] = $this->load->view('admin/view_pagination', $_pagination, true);
		$this->load->view('admin/view_properties', $_data);
		return;
	}
	
	public function display_assets()
	{
		$this->load->model('model_properties');
	
		$property_id = $this->input->post('property_id');
		$reference = $this->input->post('reference');
		$property_details = $this->model_properties->getPropertyDetails($property_id);
		$folder_path = $this->config->item("base_property_path") . $property_details['folder_name'] . "/assets";	
		$file_arr = get_dir_file_info($folder_path, TRUE);
		$file_arr_return = $this->detailedFileArr($file_arr, $property_details['folder_name']);
		
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['property_details'] = $property_details;
		$_data['folder_path'] = $folder_path;
		$_data['file_arr'] = $file_arr_return;
		$_data['reference'] = $reference;
		if ($reference) { $this->load->view('admin/view_assets', $_data); } // in editor
		else { $this->load->view('admin/view_manage_assets', $_data); } // in manage assets page
		return;
	}
	
	public function delete_asset()
	{	
		$this->load->model('model_properties');
		
		$property_id = $this->input->post('property_id');
		$path = $this->input->post('path');
		$path_thumb = $this->input->post('path_thumb');
		
		// perform delete of file
		@unlink($path);
		@unlink($path_thumb);
		
		// increment data version
		$property_details = $this->model_properties->getPropertyDetails($property_id);
		$folder_path = $this->config->item("base_property_path").$property_details['folder_name'];
		$site = simplexml_load_file($folder_path."/includes/data.xml");
		$site->site_settings->data_version = $site->site_settings->data_version + 1;
		
		// format xml
		$dom = new DOMDocument('1.0');
		$dom->preserveWhiteSpace = false;
		$dom->formatOutput = true;
		$dom->loadXML($site->asXML());
		$dom->save($folder_path."/includes/data.xml");
		return;
	}
	
	public function delete_allassets()
	{
		$this->load->model('model_properties');
		
		$property_id = $this->input->post('property_id');
		$asset_path = $this->input->post('folder_path');
		
		// increment data version
		$property_details = $this->model_properties->getPropertyDetails($property_id);
		$folder_path = $this->config->item("base_property_path").$property_details['folder_name'];
		$site = simplexml_load_file($folder_path."/includes/data.xml");
		$site->site_settings->data_version = $site->site_settings->data_version + 1;
		
		// format xml
		$dom = new DOMDocument('1.0');
		$dom->preserveWhiteSpace = false;
		$dom->formatOutput = true;
		$dom->loadXML($site->asXML());
		$dom->save($folder_path."/includes/data.xml");
		
		// perform deletion of all the files
		$files = glob($asset_path . "/*");
		foreach($files as $file) {
			if(is_file($file)) { @unlink($file); }
		}
		
		// perform deletion of all the file thumbs
		$files = glob($asset_path . "/thumbs/*");
		foreach($files as $file) {
			if(is_file($file)) { @unlink($file); }
		}
		
		$this->display_assets();
		
		return;
	}
	
	public function display_editor()
	{
		$content = $this->input->post('content');
		$reference = $this->input->post('reference');
	
		// load response
		$_data['content'] = $content;
		$_data['reference'] = $reference;
		$this->load->view('view_editor', $_data);
		return;
	}
	
	public function revert($property_id)
	{
		$this->load->model('model_properties');
		
		$company_id = $this->session->userdata('company_id');
		$user_type = $this->session->userdata('user_type');
	
		// retrieve site data from xml
		$property_details = $this->model_properties->getPropertyDetails($property_id);
		$property_details['template_id_code'] = $this->padDigit($property_details['template_id'], 5);
		$property_details['xml_url'] = base_url() . "_properties/" . $property_details['folder_name'] . "/includes/data.xml";
		$folder_path = $this->config->item("base_property_path") . $property_details['folder_name'];		
		if (file_exists($folder_path."/includes/data.xml")) {
			$site_data = $this->xml2array(file_get_contents($folder_path."/includes/data.xml"), 1, 'attribute');
			$site_data = $this->cleanArrayAddLabel($site_data['site']);
		}
		
		// determine if permission denied
		if (($company_id != $property_details['client_id']) && ($user_type != ROLE_SUPER_ADMIN)) {
			$_data['sess_user'] = $this->session->userdata;
			$_data['page'] = "error"; 
			$_data['content'] = $this->load->view('view_error_denied', $_data, TRUE);
			$this->load->view('view_main', $_data);
			return;
		}
	
		// retrieve files from backup folder
		$backup_path = $this->config->item("base_property_path") . $property_details['folder_name'] . "/backup";	
		$file_arr = get_filenames($backup_path, FALSE);
		rsort($file_arr);
		
		$counter = 0;
		if ($file_arr) {
		foreach ($file_arr as $file => $f) {
			$date = explode("_", $f);
			$date = explode(".", $date[1]);
			$date = date("Y-m-d H:i:s", $date[0]);
			
			$file_arr[$counter] = array('file' => $f, 'date' => $date);
			$counter++;
		}
		}
	
		// load response
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "properties";
		$_data['files'] = $file_arr;
		$_data['property_details'] = $property_details;
		$_data['content'] = $this->load->view('admin/view_properties_revert', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	function process_revert()
	{
		$this->load->model('model_properties');
		
		$property_id = $this->input->post('property_id');
		$filename = $this->input->post('filename');
		$property_details = $this->model_properties->getPropertyDetails($property_id);
		
		// perform overwrite
		$folder_name = $this->cleanString($property_details['title'], "_");
		$backup_path = $this->config->item("base_property_path").$property_details['folder_name']."/backup/".$filename;
		$folder_path = $this->config->item("base_property_path").$property_details['folder_name']."/includes/data.xml";
		echo $backup_path;
		@unlink($folder_path);
		@copy($backup_path, $folder_path);
		
		// log changes
		$timestamp = date("Y-m-d H:i:s", now());
		$log = "Reverted changes to ".$property_details['title'];
		$this->model_main->addLog($log, "Revert changes", $timestamp);		
		
		return;
	}
	
}
?>