<?php 
/*
TODO: create function that will process(add, edit, and delete) the xml
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blogs extends MY_Controller 
{

	function __construct() {
		parent::__construct();
		if (!$this->session->userdata['logged_in']) { redirect(site_url('admin/logout')); } // logged in?
	}
	
	public function index($property_id = 0) {
		$_data['sess_user'] = $this->session->userdata;
		$_data['page'] = "error"; 
		$_data['content'] = $this->load->view('error/view_error_404', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function summary($property_id) {
		$this->load->model('model_users');
		$this->load->model('model_properties');

		$company_id = $this->session->userdata('company_id');
		$user_type	= $this->session->userdata('user_type');
		
		$property_details 	= $this->model_properties->getPropertyDetails($property_id);
		
		$blog_posts_data 	= $this->retrieve_data_xml($property_id, 'blog_entries');
		$blog_posts 		= $this->simplify_loop_data($blog_posts_data['blog_entries']);
		
		$blog_comments_data = $this->retrieve_data_xml($property_id, 'blog_comments');
		$blog_comments 		= $this->simplify_loop_data($blog_comments_data['blog_comments']);
		
		$count_article		= $this->count_data($property_id ,"blog_entries", "entry" );
		$count_categories	= $this->count_data($property_id ,"blog_categories", "category" );
		$count_comment		= $this->count_data($property_id ,"blog_comments", "comment" );
		
		$summary = array();
		$summary['count_article']['num'] = $count_article;
		$summary['count_article']['label'] = ($count_article == 1) ? "Article" : "Articles";
		$summary['count_categories']['num'] = $count_categories;
		$summary['count_categories']['label'] = ($count_categories == 1) ? "Category" : "Categories";
		$summary['count_comments']['num'] = $count_comment;
		$summary['count_comments']['label'] = ($count_comment == 1) ? "Comment" : "Comments";
		
		// retrieve blog title
		if($blog_posts['entry']) {
		foreach ( $blog_posts['entry'] as $key => $p ) {
			$post_title[$p['id']] = $p['title'] ; 
		} 
		}
		
		// load response
		$_data['property_details'] 	= $property_details;
		$_data['property_id'] 		= $property_id;
		$_data['count_article'] 	= $count_article;
		$_data['count_categories'] 	= $count_categories;
		$_data['count_comment'] 	= $count_comment;
		$_data['blog_posts'] 		= $blog_posts['entry'];
		$_data['blog_comments'] 	= $blog_comments['comment'];
		$_data['sess_user'] 		= $this->session->userdata;
		$_data['page']				= "blogs";	
		$_data['post_title'] 		= $post_title;
		$_data['summary']			= $summary;
		$_data['content'] 			= $this->load->view('admin/view_blog', $_data, TRUE);
		
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function blog_list($property_id) {
	
		$this->load->model('model_users');
		$this->load->model('model_properties');
	
		$company_id = $this->session->userdata('company_id');
		$user_type	= $this->session->userdata('user_type');	

		// retrieve & simplify blog entries from xml
		$property_details 	= $this->model_properties->getPropertyDetails($property_id);
		$blog_posts_data 	= $this->retrieve_data_xml($property_id, 'blog_entries');
		$blog_posts 		= $this->simplify_loop_data($blog_posts_data['blog_entries']);	
		
		$blog_comments_data 	= $this->retrieve_data_xml($property_id, 'blog_comments');
		$blog_comments 		= $this->simplify_loop_data($blog_comments_data['blog_comments']);
		
		// get number of comments per article
		$counter = 0;
		if ($blog_posts['entry']) {
		foreach ($blog_posts['entry'] as $post => $p) {
			if ($blog_comments['comment']) {
			foreach ($blog_comments['comment'] as $comment => $c) {
				if ($c['p_id'] == $p['id']) {
					$blog_posts['entry'][$counter]['comments'][] = $c;
				}
			}
			}
			$counter++;
		}
		}	
		
		// load response
		$_data['property_id'] 		= $property_id;
		$_data['template_type_id'] 	= $property_details['template_type_id'];
		$_data['folder_name'] 		= $property_details['folder_name'];
		$_data['property_details'] 	= $property_details;
		$_data['blog_posts'] 		= $blog_posts['entry'];
		$_data['sess_user'] 		= $this->session->userdata;
		$_data['page']				= "blogs";
		$_data['content'] 			= $this->load->view('admin/view_blog_list', $_data, TRUE);
		
		$this->load->view('admin/view_main_back', $_data);
		
		return;
	}	
	
	public function add($property_id) {
	
		$this->load->model('model_properties');
		$property_details 	= $this->model_properties->getPropertyDetails($property_id);		

		// load response
		$_data['property_details']	= $property_details;
		$_data['categories'] 		= $this->retrieve_categories($property_id);
		$_data['property_id'] 		= $property_id;
		$_data['sess_user'] 		= $this->session->userdata;
		$_data['page'] 				= "blogs";
		$_data['clients'] 			= $this->populateClients();
		$_data['templates'] 		= $this->populateTemplates();
		$_data['template_types'] 	= $this->populateTemplateTypes();
		$_data['template_id'] 		= $template_id;
		$_data['content'] 			= $this->load->view('admin/view_blog_add', $_data, TRUE);
		
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function edit($property_id , $entry_id) {
		$this->load->model('model_properties');

		$property_details 	= $this->model_properties->getPropertyDetails($property_id);
		$blog_posts_data 	= $this->retrieve_data_xml($property_id, 'blog_entries');
		$blog_posts 		= $this->simplify_loop_data($blog_posts_data['blog_entries']);	
		
		$blog_posts = $blog_posts['entry'];
		
		foreach ($blog_posts as $blog => $b) {
			if( $b['id'] == $entry_id ) {
				foreach ($b as $key => $p) {
					$_data[$key] = $p;
				}
			}
		}
		
		$_data['post'] 				= $post;
		$_data['categories'] 		= $this->retrieve_categories($property_id);
		$_data['property_id'] 		= $property_id;
		$_data['sess_user'] 		= $this->session->userdata;
		$_data['page'] 				= "blogs";
		$_data['property_details']  = $property_details;
		$_data['clients'] 			= $this->populateClients();
		$_data['templates'] 		= $this->populateTemplates();
		$_data['template_types'] 	= $this->populateTemplateTypes();
		$_data['template_id'] 		= $template_id;
		$_data['content'] 			= $this->load->view('admin/view_blog_edit', $_data, TRUE);
		
		$this->load->view('admin/view_main_back', $_data);	
		return;
	}

	public function process_add() {	
	
		$this->load->model('model_properties');
	
		$property_id	= $this->input->post('property_id', TRUE);
		$title			= $this->input->post('title', TRUE);
		$alias			= $this->clean($title);
		$content		= $this->input->post('content', TRUE);
		$category_id 	= $this->input->post('category', TRUE);
		$category 		= $this->input->post('category_name', TRUE);
		$status 		= $this->input->post('status', TRUE);
		$author_name 	= $this->input->post('author_name', TRUE);
		//$published 		= $this->input->post('published', TRUE)." ". date("H:i:s");
		$published 		= $this->input->post('published', TRUE);
		$created 		= date("Y-m-d H:i:s");
		$updated 		= date("Y-m-d H:i:s");
		
		$property_details 	= $this->model_properties->getPropertyDetails($property_id);	
		$folder_path 		= $this->config->item("base_property_path") . $property_details['folder_name'];			
					
		$site = simplexml_load_file($folder_path."/includes/blog_entries.xml");
		
		$e_id 			= count($site->entry);
		if( $e_id != 0 ) {
			$latest_idNode 	= $site->entry[$e_id-1];
			$last_id 		= $latest_idNode->attributes()->id;		
		} else {
			$last_id = 0;
		}

		$site->addChild("entry");
		if($e_id != 0 ){
			$entryNode = $site->entry[$e_id];
		} else { 
			$entryNode = $site->entry;
		}
		
		$entryNode->addAttribute('id', $last_id+1);
		$entryNode->addAttribute('cat', $category_id);
		$entryNode->addChild('published', date("Y-m-d H:i:s", strtotime($published)));
		$entryNode->addChild('created', $created);
		$entryNode->addChild('updated', $updated);
		$entryNode->addChild('status', $status);
		$entryNode->addChild('category', $category);
		$entryNode->addChild('title', $title);
		$entryNode->addChild('alias', $alias);
		$entryNode->addChild('content');
		
		//add CDATA
		$node = dom_import_simplexml($entryNode->content);
		$doc = $node->ownerDocument; 
		$node->appendChild($doc->createCDATASection($content));	
		
		$entryNode->addChild('author_name', $author_name);
		
		$dom = new DOMDocument('1.0');
		$dom->preserveWhiteSpace = false;
		$dom->formatOutput = true;
		$dom->loadXML($site->asXML());
		$dom->save($folder_path."/includes/blog_entries.xml");	
		
		// log changes 
		$log = "Added new article ".$title." in property ".$property_details['property_title'];
		$this->model_main->addLog($log, "Add article", $created);
		
		$blog_posts_data 	= $this->retrieve_data_xml($property_id, 'blog_entries');
		$blog_posts 		= $this->simplify_loop_data($blog_posts_data['blog_entries']);
		
		$blog_comments_data 	= $this->retrieve_data_xml($property_id, 'blog_comments');
		$blog_comments 		= $this->simplify_loop_data($blog_comments_data['blog_comments']);
		
		// get number of comments per article
		$counter = 0;
		if ($blog_posts['entry']) {
		foreach ($blog_posts['entry'] as $post => $p) {
			if ($blog_comments['comment']) {
			foreach ($blog_comments['comment'] as $comment => $c) {
				if ($c['p_id'] == $p['id']) {
					$blog_posts['entry'][$counter]['comments'][] = $c;
				}
			}
			}
			$counter++;
		}
		}	
		
		// load response
		$_data['property_id'] 		= $property_id;
		$_data['property_details']	= $property_details;
		$_data['blog_posts'] 		= $blog_posts['entry'];
		$_data['sess_user'] 		= $this->session->userdata;
		$_data['page']				= "blogs";
		$_data['folder_name'] 		= $property_details['folder_name'];
		$_data['template_type_id']	= $property_details['template_type_id'];
		$_data['content'] 			= $this->load->view('admin/view_blog_list', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		
		return;
		
	}
	
	public function process_edit() {
		$this->load->model('model_properties');
		
		$post_id		= $this->input->post('post_id', TRUE);
		$property_id	= $this->input->post('property_id', TRUE);
		$title			= $this->input->post('title', TRUE);
		$content		= $this->input->post('content', TRUE);
		$category_id 	= $this->input->post('category', TRUE);
		$category 		= $this->input->post('category_name', TRUE);
		$status 		= $this->input->post('status', TRUE);
		$author_name 	= $this->input->post('author_name', TRUE);
		$published 		= $this->input->post('published', TRUE);
		$created 		= $this->input->post('created', TRUE);
		$updated 		= $this->input->post('updated', TRUE);

		$property_details 	= $this->model_properties->getPropertyDetails($property_id);
		$folder_path 		= $this->config->item("base_property_path") . $property_details['folder_name'];			
		
		$site = simplexml_load_file($folder_path."/includes/blog_entries.xml");

		//set the entryNode
		if( $site ) {
			$p_ctr = count($site->entry) - 1;
			for ($i = 0; $i <= $p_ctr; $i++) {			
				if( $site->entry[$i]->attributes()->id == $post_id ) {
					$entryNode 	= $site->entry[$i];
				}
				
			}
		}		
		
		$entryNode->attributes()->cat = $category_id;
		
		$entryNode->published 	= date("Y-m-d H:i:s", strtotime($published));
		$entryNode->created 	= trim($created);
		$entryNode->created 	= trim($created);
		$entryNode->updated 	= trim($updated);
		$entryNode->status 		= trim($status);
		$entryNode->category 	= trim($category);
		$entryNode->title 		= trim($title);
		$entryNode->content 	= "";
		
		// add CDATA
		$node = dom_import_simplexml($entryNode->content);
		$doc = $node->ownerDocument; 
		$node->appendChild($doc->createCDATASection($content));	
		
		$entryNode->author_name = trim($author_name);

		$dom = new DOMDocument('1.0');
		$dom->preserveWhiteSpace = false;
		$dom->formatOutput = true;
		$dom->loadXML($site->asXML());
		$dom->save($folder_path."/includes/blog_entries.xml");	
		
		// log changes 
		$log = "Edited article ".$title." in property ".$property_details['property_title'];
		$this->model_main->addLog($log, "Edit article", $updated);
		
		$blog_posts_data 	= $this->retrieve_data_xml($property_id, 'blog_entries');
		$blog_posts 		= $this->simplify_loop_data($blog_posts_data['blog_entries']);	
		
		$blog_posts = $blog_posts['entry'];
		
		foreach ($blog_posts as $blog => $b) {
			if($b['id'] == $post_id) {
				foreach ($b as $key => $p) {
					$_data[$key] = $p;
				}
			}
		}
		
		// load response
		$_data['post'] 				= $post;
		$_data['categories'] 		= $this->retrieve_categories($property_id);
		$_data['property_id'] 		= $property_id;
		$_data['folder_name'] 		= $property_details['folder_name'];
		$_data['property_details']  = $property_details;
		$_data['blog_posts'] 		= $blog_posts['entry'];
		$_data['sess_user'] 		= $this->session->userdata;
		$_data['page']				= "blogs";
		$_data['clients'] 			= $this->populateClients();
		$_data['templates'] 		= $this->populateTemplates();
		$_data['template_types'] 	= $this->populateTemplateTypes();
		$_data['template_type_id']	= $property_details['template_type_id'];
		$_data['template_id'] 		= $template_id;
		$_data['content'] 			= $this->load->view('admin/view_blog_edit', $_data, TRUE);
		
		$this->load->view('admin/view_main_back', $_data);
		
		return;
	}
	
	public function process_delete() {
	
		$this->load->model('model_properties');
		
		$post_id 		= $this->input->post('post_id');
		$property_id 	= $this->input->post('property_id');
		$folder_name 	= $this->input->post('folder_name');
		$current_page 	= $this->input->post('current_page');		
		$timestamp 		= date("Y-m-d H:i:s", now());
		
		$property_details 	= $this->model_properties->getPropertyDetails($property_id);	
		$folder_path 		= $this->config->item("base_property_path") . $property_details['folder_name'];	
		
		$data 	= file_get_contents($folder_path."/includes/blog_entries.xml");
		$doc	= new SimpleXMLElement($data);
		

		
		foreach($doc->entry as $entry){
			if($entry['id'] == $post_id) {
				$title = $entry->title;		
				$dom = dom_import_simplexml($entry);
				$dom->parentNode->removeChild($dom);
			} 
		}
		
		$dom = new DOMDocument('1.0');
		$dom->preserveWhiteSpace = false;
		$dom->formatOutput = true;
		$dom->loadXML($doc->asXML());
		$dom->save($folder_path."/includes/blog_entries.xml");	
		
		// log changes 
		$log = "Deleted article ".$title." in property ".$property_details['property_title'];
		$this->model_main->addLog($log, "Delete article", $timestamp);		
		
		$blog_posts_data 	= $this->retrieve_data_xml($property_id, 'blog_entries');
		$blog_posts 		= $this->simplify_loop_data($blog_posts_data['blog_entries']);
		
		// load response
		$_data['property_id'] 		= $property_id;
		$_data['blog_posts'] 		= $blog_posts['entry'];
		$_data['sess_user'] 		= $this->session->userdata;
		$_data['page']				= "blogs";
		$_data['folder_name'] 		= $property_details['folder_name'];
		$_data['template_type_id']	= $property_details['template_type_id'];
		$_data['content'] 			= $this->load->view('admin/view_blog_list', $_data, TRUE);
		
		$this->load->view('admin/view_main_back', $_data);
		return;
		
	}
	
	public function categories($property_id) {
		
		$this->load->model('model_users');
		$this->load->model('model_properties');
	
		$company_id = $this->session->userdata('company_id');
		$user_type	= $this->session->userdata('user_type');	

		// retrieve & simplyfy blog categories from xml
		$property_details 	= $this->model_properties->getPropertyDetails($property_id);
		$blog_cat_data 		= $this->retrieve_data_xml($property_id, 'blog_categories');
		$blog_cat 			= $this->simplify_loop_data($blog_cat_data['blog_categories']);	

		// load response
		$_data['property_id'] 		= $property_id;
		$_data['property_details'] 	= $property_details;
		$_data['folder_name'] 		= $property_details['folder_name'];
		$_data['blog_cat'] 			= $blog_cat['category'];
		$_data['sess_user'] 		= $this->session->userdata;
		$_data['page']				= "blogs";
		$_data['content'] 			= $this->load->view('admin/view_blog_categories', $_data, TRUE);
		
		$this->load->view('admin/view_main_back', $_data);
		
		return;		
	
	}
	
	public function add_category($property_id){
		
		$this->load->model('model_properties');
		$property_details 	= $this->model_properties->getPropertyDetails($property_id);
		
		// load response
		$_data['categories'] 		= $this->retrieve_categories($property_id);
		$_data['property_id'] 		= $property_id;
		$_data['property_details'] 	= $property_details;
		$_data['sess_user'] 		= $this->session->userdata;
		$_data['page'] 				= "blogs";
		$_data['clients'] 			= $this->populateClients();
		$_data['templates'] 		= $this->populateTemplates();
		$_data['template_types'] 	= $this->populateTemplateTypes();
		$_data['template_id'] 		= $template_id;
		$_data['content'] 			= $this->load->view('admin/view_blog_categories_add', $_data, TRUE);
		
		$this->load->view('admin/view_main_back', $_data);
		return;
		
	}
	
	public function edit_category($property_id, $cat_id) {
		$this->load->model('model_properties');

		$property_details 	= $this->model_properties->getPropertyDetails($property_id);
		$blog_cat_data 	= $this->retrieve_data_xml($property_id, 'blog_categories');
		$blog_cat 		= $this->simplify_loop_data($blog_cat_data['blog_categories']);	
		
		$blog_cat = $blog_cat['category'];
		
		foreach ($blog_cat as $cat => $c) {
			if( $c['cat_id'] == $cat_id ) {
				foreach ($c as $key => $p) {
					$_data[$key] = $p;
				}
			}
		}
		
		$_data['post'] 				= $post;
		$_data['property_id'] 		= $property_id;
		$_data['sess_user'] 		= $this->session->userdata;
		$_data['page'] 				= "blogs";
		$_data['clients'] 			= $this->populateClients();
		$_data['templates'] 		= $this->populateTemplates();
		$_data['template_types'] 	= $this->populateTemplateTypes();
		$_data['template_id'] 		= $template_id;
		$_data['property_details'] 	= $property_details;
		$_data['content'] 			= $this->load->view('admin/view_blog_categories_edit', $_data, TRUE);
		$this->load->view('admin/view_main_back', $_data);
		
		return;
	}
		
	public function process_add_category() {	
	
		$this->load->model('model_properties');
		
		$property_id	= $this->input->post('property_id', TRUE);
		$cat_name		= $this->input->post('cat_name', TRUE);	
		$alias			= $this->clean($cat_name);
		$timestamp 		= date("Y-m-d H:i:s", now());		

		$property_details 	= $this->model_properties->getPropertyDetails($property_id);	
		$folder_path 		= $this->config->item("base_property_path") . $property_details['folder_name'];	
		
		$site = simplexml_load_file($folder_path."/includes/blog_categories.xml");	
		
		$c_id 			= count($site->category);
		$latest_idNode 	= $site->category[$c_id-1];
		$last_id 		= $latest_idNode->attributes()->c_id;	
		
		$site->addChild("category");
		$entryNode = $site->category[$c_id];		
		$entryNode->addAttribute('c_id', $last_id+1);
		$entryNode->addChild('cat_id', $last_id+1);
		$entryNode->addChild('cat_name', trim($cat_name));
		$entryNode->addChild('alias', $alias);

		$dom = new DOMDocument('1.0');
		$dom->preserveWhiteSpace = false;
		$dom->formatOutput = true;
		$dom->loadXML($site->asXML());
		$dom->save($folder_path."/includes/blog_categories.xml");	

		// log changes 
		$log = "Added new category ".$cat_name." in property ".$property_details['property_title'];
		$this->model_main->addLog($log, "Add category", $timestamp);
		
		$blog_cat_data 	= $this->retrieve_data_xml($property_id, 'blog_categories');
		$blog_cat 		= $this->simplify_loop_data($blog_cat_data['blog_categories']);

		// load response
		$_data['property_id'] 		= $property_id;
		$_data['property_details']	= $property_details;
		$_data['folder_name'] 		= $property_details['folder_name'];
		$_data['blog_cat'] 			= $blog_cat['category'];
		$_data['sess_user'] 		= $this->session->userdata;
		$_data['page']				= "blogs";
		$_data['content'] 			= $this->load->view('admin/view_blog_categories', $_data, TRUE);
		
		$this->load->view('admin/view_main_back', $_data);
		
		return;		
		
	}

	public function process_edit_category() {
		$this->load->model('model_properties');
		
		$property_id	= $this->input->post('property_id', TRUE);
		$cat_id			= $this->input->post('cat_id', TRUE);
		$cat_name		= $this->input->post('cat_name', TRUE);
		$timestamp 		= date("Y-m-d H:i:s", now());
		
		$property_details 	= $this->model_properties->getPropertyDetails($property_id);
		$folder_path 		= $this->config->item("base_property_path") . $property_details['folder_name'];			
		
		$site = simplexml_load_file($folder_path."/includes/blog_categories.xml");
		
		$entryNode 	= $site->category[$cat_id-1];
		
		//$entryNode->attributes()->cat = $category_id;

		$entryNode->cat_name 	= trim($cat_name);

		$dom = new DOMDocument('1.0');
		$dom->preserveWhiteSpace = false;
		$dom->formatOutput = true;
		$dom->loadXML($site->asXML());
		$dom->save($folder_path."/includes/blog_categories.xml");
		
		
		$p_data = simplexml_load_file($folder_path."/includes/blog_entries.xml");
		if( $p_data ) {
			$p_ctr = count($p_data->entry) - 1;
			for ($i = 0; $i <= $p_ctr; $i++) {
			
				if( $p_data->entry[$i]->attributes()->cat == $cat_id ) {
					$p_data->entry[$i]->attributes()->cat = $cat_id;
					$p_data->entry[$i]->category = $cat_name;
				}
				
			}
		}
		
		$p_dom = new DOMDocument('1.0');
		$p_dom->preserveWhiteSpace = false;
		$p_dom->formatOutput = true;
		$p_dom->loadXML($p_data->asXML());
		$p_dom->save($folder_path."/includes/blog_entries.xml");	

		// log changes 
		$log = "Edited category ".$cat_name." in property ".$property_details['property_title'];
		$this->model_main->addLog($log, "Edit category", $timestamp);
		
		$blog_cat_data 	= $this->retrieve_data_xml($property_id, 'blog_categories');
		$blog_cat 		= $this->simplify_loop_data($blog_cat_data['blog_categories']);	
		$blog_cat 		= $blog_cat['category'];
		
		foreach ($blog_cat as $cat => $c) {
			if( $c['cat_id'] == $cat_id ) {
				foreach ($c as $key => $p) {
					$_data[$key] = $p;
				}
			}
		}
		
		// load response
		$_data['post'] 				= $post;
		$_data['property_id'] 		= $property_id;
		$_data['folder_name'] 		= $property_details['folder_name'];
		$_data['blog_cat'] 			= $blog_cat['category'];
		$_data['sess_user'] 		= $this->session->userdata;
		$_data['page']				= "blogs";
		$_data['clients'] 			= $this->populateClients();
		$_data['templates'] 		= $this->populateTemplates();
		$_data['template_types'] 	= $this->populateTemplateTypes();
		$_data['template_id'] 		= $template_id;
		$_data['property_details'] 	= $property_details;
		$_data['content'] 			= $this->load->view('admin/view_blog_categories_edit', $_data, TRUE);
		
		$this->load->view('admin/view_main_back', $_data);
		
		return;
	}
	
	public function process_delete_category() {
	
		$this->load->model('model_properties');
		
		$cat_id 		= $this->input->post('cat_id', TRUE);
		$property_id 	= $this->input->post('property_id', TRUE);
		$folder_name 	= $this->input->post('folder_name', TRUE);
		$current_page 	= $this->input->post('current_page', TRUE);
		$timestamp 		= date("Y-m-d H:i:s", now());
		
		$property_details 	= $this->model_properties->getPropertyDetails($property_id);	
		$folder_path 		= $this->config->item("base_property_path") . $property_details['folder_name'];	
		
		$data 	= file_get_contents($folder_path."/includes/blog_categories.xml");
		$doc	= new SimpleXMLElement($data);
		
		foreach($doc->category as $category){
			if($category['c_id'] == $cat_id) {
				$cat_name = $category->cat_name;
				$dom = dom_import_simplexml($category);
				$dom->parentNode->removeChild($dom);
			} 
		}
		
		$dom = new DOMDocument('1.0');
		$dom->preserveWhiteSpace = false;
		$dom->formatOutput = true;
		$dom->loadXML($doc->asXML());
		$dom->save($folder_path."/includes/blog_categories.xml");			

		// log changes 
		$log = "Deleted category ".$cat_name." in property ".$property_details['property_title'];
		$this->model_main->addLog($log, "Deleted category", $timestamp);		
		
		$p_data = simplexml_load_file($folder_path."/includes/blog_entries.xml");
		if( $p_data ) {
			$p_ctr = count($p_data->entry) - 1;
			for ($i = 0; $i <= $p_ctr; $i++) {
			
				if( $p_data->entry[$i]->attributes()->cat == $cat_id ) {
					$p_data->entry[$i]->attributes()->cat = 1;
					$p_data->entry[$i]->category = "Uncategorized";
				}
				
			}
		}
		
		$p_dom = new DOMDocument('1.0');
		$p_dom->preserveWhiteSpace = false;
		$p_dom->formatOutput = true;
		$p_dom->loadXML($p_data->asXML());
		$p_dom->save($folder_path."/includes/blog_entries.xml");	
		
		$blog_cat_data 	= $this->retrieve_data_xml($property_id, 'blog_categories');
		$blog_cat 		= $this->simplify_loop_data($blog_cat_data['blog_categories']);	
		
		// load response
		$_data['property_id'] 		= $property_id;
		$_data['property_details']	= $property_details;
		$_data['blog_cat'] 			= $blog_cat['category'];
		$_data['sess_user'] 		= $this->session->userdata;
		$_data['page']				= "blogs";
		$_data['content'] 			= $this->load->view('admin/view_blog_categories', $_data, TRUE);
		
		$this->load->view('admin/view_main_back', $_data);
		return;
	}
	
	public function comments($property_id, $post_id = "") {
	
		$this->load->model('model_users');
		$this->load->model('model_properties');
	
		$company_id = $this->session->userdata('company_id');
		$user_type	= $this->session->userdata('user_type');	

		// retrieve & simplyfy comment from xml
		$property_details 	= $this->model_properties->getPropertyDetails($property_id);
		
		$blog_comment_data 	= $this->retrieve_data_xml($property_id, 'blog_comments');
		$blog_comment 		= $this->simplify_loop_data($blog_comment_data['blog_comments']);
		
		$blog_posts_data 	= $this->retrieve_data_xml($property_id, 'blog_entries');
		$blog_posts 		= $this->simplify_loop_data($blog_posts_data['blog_entries']);		
			
		if(!empty( $post_id ) ) {
			
			$blog_comments = array();			
			foreach ($blog_comment['comment'] as $kblog => $blogs) { 
				if( $blogs['p_id'] == $post_id ) {
					foreach ($blogs as $blog => $b) {
						$blog_comments[$kblog][$blog] = $b;
					}
				}
			}			
		} else {
		
			$blog_comments = $blog_comment['comment']; 
			
		}
		
		// retrieve blog title
		if($blog_posts['entry']) {
			foreach ( $blog_posts['entry'] as $key => $p ) {
				$post_title[$p['id']] = $p['title'] ; 
			} 
		}

		// load response
		$_data['property_id'] 		= $property_id;
		$_data['property_details'] 	= $property_details;
		$_data['folder_name'] 		= $property_details['folder_name'];
		$_data['blog_comment'] 		= $blog_comments;
		$_data['post_title'] 		= $post_title;
		$_data['sess_user'] 		= $this->session->userdata;
		$_data['page']				= "blogs";
		$_data['content'] 			= $this->load->view('admin/view_blog_comments', $_data, TRUE);
		
		$this->load->view('admin/view_main_back', $_data);
		
		return;		
		
	}
	
	public function edit_comments($property_id, $comm_id) {
	
		$this->load->model('model_properties');

		$property_details 	= $this->model_properties->getPropertyDetails($property_id);
		$blog_comment_data 	= $this->retrieve_data_xml($property_id, 'blog_comments');
		$blog_comment 		= $this->simplify_loop_data($blog_comment_data['blog_comments']);	

		$blog_posts_data 	= $this->retrieve_data_xml($property_id, 'blog_entries');
		$blog_posts 		= $this->simplify_loop_data($blog_posts_data['blog_entries']);	
		
		$blog_comm = $blog_comment['comment'];
		
		foreach ($blog_comm as $comm => $c) {
			if( $c['comm_id'] == $comm_id ) {
				$post_id = $c['p_id'];
				foreach ($c as $key => $p) {
					$_data[$key] = $p;
				}
			}
		}
		
		/// retrieve blog title
		foreach ( $blog_posts['entry'] as $key => $p ) {
			if( $post_id == $p['id'] ) {
				$_data['post_title'] = $p['title'] ; 
			}
		}
		
		$_data['property_id'] 		= $property_id;
		$_data['property_details'] 	= $this->model_properties->getPropertyDetails($property_id);
		$_data['sess_user'] 		= $this->session->userdata;
		$_data['page'] 				= "blogs";
		$_data['clients'] 			= $this->populateClients();
		$_data['templates'] 		= $this->populateTemplates();
		$_data['template_types'] 	= $this->populateTemplateTypes();
		$_data['template_id'] 		= $template_id;
		$_data['content'] 			= $this->load->view('admin/view_blog_comment_edit', $_data, TRUE);
		
		$this->load->view('admin/view_main_back', $_data);
		
	}

	public function process_edit_comment(){
	
		$this->load->model('model_properties');
		
		$property_id	= $this->input->post('property_id', TRUE);
		$comm_id		= $this->input->post('comm_id', TRUE);
		$posted_by		= $this->input->post('name', TRUE);
		$email			= $this->input->post('email', TRUE);
		$comment_content= $this->input->post('comment', TRUE);
		$timestamp 		= date("Y-m-d H:i:s", now());
		
		$property_details 	= $this->model_properties->getPropertyDetails($property_id);
		$folder_path 		= $this->config->item("base_property_path") . $property_details['folder_name'];			
		
		$site = simplexml_load_file($folder_path."/includes/blog_comments.xml");

		//set the entryNode
		if( $site ) {
			$p_ctr = count($site->comment) - 1;
			for ($i = 0; $i <= $p_ctr; $i++) {			
				if( $site->comment[$i]->attributes()->comm_id == $comm_id ) {
					$entryNode 	= $site->comment[$i];
				}
				
			}
		}	

		$entryNode->posted_by 			= trim($posted_by);
		$entryNode->email 				= trim($email);
		$entryNode->comment_content 	= trim($comment_content);

		$dom = new DOMDocument('1.0');
		$dom->preserveWhiteSpace = false;
		$dom->formatOutput = true;
		$dom->loadXML($site->asXML());
		$dom->save($folder_path."/includes/blog_comments.xml");	

		// log changes
		$p_comment = (strlen($comment_content) > 30 ? substr($comment_content, 0, 30)."..." : $comment_content );		
		$log = "Edited comment ".$p_comment." in property ".$property_details['property_title'];
		$this->model_main->addLog($log, "Edit comment", $timestamp);
		
		$blog_posts_data 	= $this->retrieve_data_xml($property_id, 'blog_entries');
		$blog_posts 		= $this->simplify_loop_data($blog_posts_data['blog_entries']);	
		
		$blog_comment_data 	= $this->retrieve_data_xml($property_id, 'blog_comments');
		$blog_comment 		= $this->simplify_loop_data($blog_comment_data['blog_comments']);
	
		$blog_comm = $blog_comment['comment'];
		
		foreach ($blog_comm as $comm => $c) {
			if( $c['comm_id'] == $comm_id ) {
				$post_id = $c['p_id'];
				foreach ($c as $key => $p) {
					$_data[$key] = $p;
				}
			}
		}
		
		// retrieve blog title
		foreach ( $blog_posts['entry'] as $key => $p ) {
			if( $post_id == $p['id'] ) {
				$_data['post_title'] = $p['title'] ; 
			}
		}
		
		// load response
		$_data['property_id'] 		= $property_id;
		$_data['folder_name'] 		= $property_details['folder_name'];
		$_data['property_details'] 	= $property_details;
		$_data['blog_comment'] 		= $blog_comment['comment'];
		$_data['sess_user'] 		= $this->session->userdata;
		$_data['page']				= "blogs";
		$_data['content'] 			= $this->load->view('admin/view_blog_comment_edit', $_data, TRUE);
		
		$this->load->view('admin/view_main_back', $_data);
		
		return;
			
	}
	
	public function process_delete_comment(){
	
		$this->load->model('model_properties');
		
		$comm_id 		= $this->input->post('comm_id', TRUE);
		$property_id 	= $this->input->post('property_id', TRUE);
		$folder_name 	= $this->input->post('folder_name', TRUE);
		$current_page 	= $this->input->post('current_page', TRUE);
		$timestamp 		= date("Y-m-d H:i:s", now());
		
		$property_details 	= $this->model_properties->getPropertyDetails($property_id);	
		$folder_path 		= $this->config->item("base_property_path") . $property_details['folder_name'];	
		
		$data 	= file_get_contents($folder_path."/includes/blog_comments.xml");
		$doc	= new SimpleXMLElement($data);
		
		foreach($doc->comment as $comment){
			if($comment['comm_id'] == $comm_id) {
				$comment_content = strip_tags($comment->comment_content);
				$dom = dom_import_simplexml($comment);
				$dom->parentNode->removeChild($dom);
			} 
		}
		
		$dom = new DOMDocument('1.0');
		$dom->preserveWhiteSpace = false;
		$dom->formatOutput = true;
		$dom->loadXML($doc->asXML());
		$dom->save($folder_path."/includes/blog_comments.xml");	
		
		// log changes 
		
		$p_comment = (strlen($comment_content) > 30 ? substr($comment_content, 0, 30)."..." : $comment_content );
		$log = "Deleted comment ".$p_comment." in property ".$property_details['property_title'];
		$this->model_main->addLog($log, "Delete comment", $timestamp);
		
		$blog_comment_data 	= $this->retrieve_data_xml($property_id, 'blog_comments');
		$blog_comment 		= $this->simplify_loop_data($blog_comment_data['blog_comments']);	
		
		$blog_posts_data 	= $this->retrieve_data_xml($property_id, 'blog_entries');
		$blog_posts 		= $this->simplify_loop_data($blog_posts_data['blog_entries']);	
		
		// retrieve blog title
		if($blog_posts['entry']) {
			foreach ( $blog_posts['entry'] as $key => $p ) {
				$post_title[$p['id']] = $p['title'] ; 
			} 
		}
		
		// load response
		$_data['property_id'] 		= $property_id;
		$_data['blog_comment'] 		= $blog_comment['comment'];
		$_data['sess_user'] 		= $this->session->userdata;
		$_data['page']				= "blogs";
		$_data['post_title']		= $post_title;
		$_data['property_details'] 	= $property_details;
		$_data['content'] 			= $this->load->view('admin/view_blog_comments', $_data, TRUE);
		
		$this->load->view('admin/view_main_back', $_data);
		return;
	
	}
	
	public function retrieve_data_xml($property_id, $filename) {
		// retrieve site data from xml
		$property_details 	= $this->model_properties->getPropertyDetails($property_id);
		$folder_path 		= $this->config->item("base_property_path") . $property_details['folder_name'];	
		
		if (file_exists($folder_path."/includes/".$filename.".xml")) {
			$site_data = $this->xml2array(file_get_contents($folder_path."/includes/".$filename.".xml"), 1, 'attribute');
		} else {
			$site_data = "File not found.";
		}

		return $xml_data = $site_data; 
	}
	
	public function simplify_loop_data($array_data) {

		$b_data = array();
		if ($array_data) {
			foreach ($array_data as $label => $s) {
				$b_data[$label] = array();
				if ($s) {			
					foreach ($s as $key => $value) {				
						if ( is_numeric( $key ) ) {
							foreach ($value as $b => $bv) {
								if ($b != "attr") {
									$b_data[$label][$key][$b] = $bv['value'];
								} else {
									foreach ($value['attr'] as $att => $attr) {
										$b_data[$label][$key][$att] = $attr;
									}
								}
							}
						} else {
							if ($key != "attr") {
								$b_data[$label][0][$key] = $value['value'];
							} else {
								foreach ($value as $k_attr => $a) {
									$b_data[$label][0][$k_attr] = $a;
								}
							}
						}
					}
				}
			}
			return $b_data; 
		}	
	}
	
	public function retrieve_categories($property_id){
	
		$this->load->model('model_properties');
		
		// retrieve simplyfy data from xml
		$property_details 	= $this->model_properties->getPropertyDetails($property_id);
		$blog_cat_data 		= $this->retrieve_data_xml($property_id, 'blog_categories');
		$blog_cat 			= $this->simplify_loop_data($blog_cat_data['blog_categories']);	
		
		return $blog_cat['category'];
	}

	public function count_data($property_id , $filename, $node ) {
		
		$this->load->model('model_properties');
		
		$property_details 	= $this->model_properties->getPropertyDetails($property_id);	
		$folder_path 		= $this->config->item("base_property_path") . $property_details['folder_name'];	
		
		$site = simplexml_load_file($folder_path."/includes/".$filename.".xml");	
		
		$c_data 			= count($site->$node);
		
		return $c_data;
	}
	
	public function clean($string) {
	   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
	   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	}	
	
}
?>