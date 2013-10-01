<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends MY_Controller 
{
	
	function __construct()
	{
		parent::__construct();
	}
	
	public function login()
	{
		$this->load->model('model_users');
	
		$username = $this->input->post('username');
		$password = md5($this->input->post('password'));
		$timestamp = date("Y-m-d H:i:s", now());
		
		$user_details = $this->model_users->login($username, $password);
		
		if (!$user_details) 
		{
			echo "0";
		} 
		else if ($user_details['account_status'] == 1) 
		{ 
			ob_start();
			session_start();
			
			$this->load->model('model_clients');
			
			$user_details = $this->getAvatarPath($user_details);
			$avatar_path = $user_details['avatar_path'];
			$company_details = $this->model_clients->getClientDetails($user_details['company_id']);
			$company_features_arr = $this->model_clients->getClientFeatures($user_details['company_id']);
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
			
			// retrieve browser
			$browser = $this->detectBrowser();
			
			// determine if company logo exists
			$company_logo = "";
			if ($company_details['agency_id'] != 0) {
				$agency_details = $this->model_clients->getClientDetails($company_details['agency_id']);
				if (file_exists($this->config->item('base_client_path').$agency_details['folder']."/logo.png")) {
					$company_logo = base_url() . "_clients/" . $agency_details['folder'] . "/logo.png"; 
				}
			} else {
				if (file_exists($this->config->item('base_client_path').$company_details['folder']."/logo.png")) {
					$company_logo = base_url() . "_clients/" . $company_details['folder'] . "/logo.png"; 
				}
			}
			
			$newdata = array( 	'user_id' => $user_details['user_id'],
								'username'  => $user_details['username'],
								'user_type'  => $user_details['user_type'],
								'company_id'  => $user_details['company_id'],
								'company_name'  => $company_details['title'],
								'company_name_short'  => $company_details['title_short'],
								'company_logo'  => $company_logo,
								'company_features'  => $company_features,
								'templates_access'  => $company_details['templates_access'],
								'templates_allowed'  => $templates_allowed,
								'last_login'  => $user_details['last_login'],
								'last_login_ip'  => $user_details['last_login_ip'],
								'avatar_path' => $avatar_path,
								'first_name'  => $user_details['first_name'],
								'last_name'  => $user_details['last_name'],
								'browser'  => $browser,
								'logged_in' => TRUE);
			
			/*// detect if user type is ecommerce
			if( $user_details['user_type'] > ROLE_SUPER_ADMIN ){
				$user_functions = $this->model_users->getUserFunctionsByUserType($user_details['user_type']);
				$newdata['allowed_user_functions'] = $user_functions;
			}*/
			
			$this->session->set_userdata($newdata);
					
			// log changes
			$log = "Logged in";
			$this->model_main->addLog($log, "Login", $timestamp);
			
			// update last login of user
			$last_login = date("Y-m-d H:i:s", now());
			$this->model_users->updateLastLogin($user_details['user_id'], $last_login);
			
			echo "1";
		} 
		else if ($user_details['account_status'] == 0) 
		{ 
			echo "2"; // if account has been deactivated
		}
		return;
	}
	
	public function check_unique()
	{
		$field = $this->input->post('field');
		$value = strtolower($this->cleanStringForDB($this->input->post('value')));
		$table = $this->input->post('table');
		$check = $this->model_main->checkUnique($field, $value, $table);
		if ($check) { echo "duplicate"; }
		else { echo "unique"; }
		return;
	}
	
	public function check_password()
	{
		$user_id = $this->input->post('user_id');
		$input_password = $this->input->post('input_password');
		$check = $this->model_main->checkPassword($user_id, $input_password);
		if ($check) { echo "match"; }
		else { echo "mismatch"; }
		return;
	}
	
	public function passchange_request()
	{
		$this->load->model('model_users');
	
		$email = $this->input->post('email');
		$user_details = $this->model_users->getUserDetailsByUsername($email);
		$user_fullname = $user_details['first_name'] . " " . $user_details['last_name'];
		
		// send the email
		$_data['user_fullname'] = $user_fullname;
		$_data['token'] = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 20);
		$this->model_users->updateToken($user_details['user_id'], $_data['token']);
		$message = $this->load->view('email/view_passchangerequest', $_data, TRUE);
		
		$config['mailtype'] = 'html';
		
		$this->load->library('email');
		$this->email->initialize($config);
		$this->email->from('no-reply@sitemee.com', 'Sitemee');
		$this->email->reply_to(SUPPORT_EMAIL, SUPPORT_NAME);
		$this->email->to($email); 
		$this->email->subject('Sitemee Forgot Password');
		$this->email->message($message);
		$this->email->send();
		
		echo $this->email->print_debugger();
		return;
	}
	
	public function upload_asset()
	{	
		$this->load->model('model_users');
		$this->load->model('model_clients');
	
		$current_user_id = $this->session->userdata('user_id');
		$user_id = $this->input->post('user_id');
		$username = $this->input->post('username');
		$upload_type = $this->input->post('upload_type');
		$property_title = $this->input->post('property_title');
		$timestamp = date("Y-m-d H:i:s", now());
	
		$allowed_extensions = array("gif", "jpg", "jpeg", "png", "mp3", "GIF", "JPG", "JPEG", "PNG", "MP3");
		$config['upload_path'] = $this->input->post('folder_path');
		$config['allowed_types'] = 'zip|rar|gif|jpg|jpeg|png|mp3|ZIP|RAR|GIF|JPG|JPEG|PNG|MP3';
		$config['max_size']	= '20480';
		$config['max_width'] = '4096';
		$config['max_height'] = '4096';
		
		if ($upload_type == 'avatar' || $upload_type == 'logo') { $config['overwrite'] = TRUE; }
		else { $config['overwrite'] = FALSE; }

		if ($this->input->post('file_name')) {
			$config['file_name'] = $this->input->post('file_name');
		}
		
		$field_name = "file_to_upload";
		 
		$this->load->library('image_lib');
		$this->load->library('upload', $config);
		
		if (!$this->upload->do_upload($field_name)) {
			if ($upload_type == "property_asset_edit") { echo '{ "file": "0", "error" : "'. $this->upload->display_errors() .'" }'; } 
			else { echo $this->upload->display_errors(); }
		} else {
			$upload_data = $this->upload->data();	
			
			// log changes
			if ($upload_type == "avatar") 
			{
				if ($current_user_id == $user_id) { 
					$log = "Updated avatar";
					$this->model_main->addLog($log, "Upload avatar", $timestamp);
					
					$user_details = $this->model_users->getUserDetailsByUserId($user_id);
					$user_details = $this->getAvatarPath($user_details);
					$newdata = array('avatar_path' => $user_details['avatar_path']);
					$this->session->set_userdata($newdata);	
				} else { 
					$log = "Updated avatar of user ".$username;
					$this->model_main->addLog($log, "Upload avatar", $timestamp);
				}
			} 
			else if ($upload_type == "logo") 
			{
				$company_details = $this->model_clients->getClientDetails($this->session->userdata('company_id'));
				if (file_exists($this->config->item('base_client_path').$company_details['folder']."/logo.png")) {
					$company_details['logo'] = base_url() . "_clients/" . $company_details['folder'] . "/logo.png"; 
				}
				
				$log = "Updated logo of " . $company_details['title'];
				$this->model_main->addLog($log, "Upload logo", $timestamp);
				
				// if only editing own company
				if ($company_details['client_id'] == $this->session->userdata('company_id')) {
					$newdata = array('company_logo' => $company_details['logo']);
					$this->session->set_userdata($newdata);					
				}
			}
			else if ($upload_type == "property_asset" || $upload_type == "property_asset_edit") 
			{
				// create thumb here
				$size = getimagesize($this->input->post('folder_path')."/".$upload_data['file_name']);
				$width = $size[0];
				if ($width > 148) {
					$this->createThumb($this->input->post('folder_path')."/".$upload_data['file_name'], $this->input->post('folder_path')."/thumbs", 148);
				}
			
				if ($upload_data['file_type'] == "application/octet-stream" || $upload_data['file_type'] == "application/zip") {
					$log = "Uploaded a zip archive to " . $property_title;
				} else {
					$log = "Uploaded an asset to " . $property_title;
				}
				$this->model_main->addLog($log, "Upload asset", $timestamp);
				
				// increment data version
				$folder_name = str_replace(" ", "_", strtolower($property_title));
				$folder_path = $this->config->item("base_property_path").$folder_name;
				$site = simplexml_load_file($folder_path."/includes/data.xml");
				$site->site_settings->data_version = $site->site_settings->data_version + 1;
				
				// format xml
				$dom = new DOMDocument('1.0');
				$dom->preserveWhiteSpace = false;
				$dom->formatOutput = true;
				$dom->loadXML($site->asXML());
				$dom->save($folder_path."/includes/data.xml");
			}
			
			// perform unzip here
			$complete_file_path = $this->input->post('folder_path') . "/" . $upload_data['file_name'];
			$unzip_error = "";
			
			if ($upload_data['file_type'] == "application/octet-stream" || $upload_data['file_type'] == "application/zip" || $upload_data['file_type'] == "application/x-zip-compressed") {
				$zip = new ZipArchive;
				$res = $zip->open($complete_file_path);
				if ($res === TRUE) {
					// check contents of zip first
					@mkdir($this->input->post('folder_path')."/zip");
					$zip->extractTo($this->input->post('folder_path')."/zip");
					$zip->close();
					$valid_contents = $this->checkValidContents($this->input->post('folder_path')."/zip", $allowed_extensions);
					
					// if the zip file has valid contents, copy every file upwards and delete the folder
					if ($valid_contents) { 
						$files_arr = get_filenames($this->input->post('folder_path')."/zip", FALSE, TRUE);
						if ($files_arr) {
						foreach ($files_arr as $file => $f) { 
							if (file_exists($this->input->post('folder_path')."/".$f)) {
								$newfilename = $this->fileNewname($this->input->post('folder_path') , $f);
							} else {
								$newfilename = $f;
							}
							$newfilename = str_replace(" ", "_", $newfilename);
							
							@copy($this->input->post('folder_path')."/zip/".$f, $this->input->post('folder_path')."/".$newfilename);

							// create thumb here
							$size = getimagesize($this->input->post('folder_path')."/".$newfilename);
							$width = $size[0];
							if ($width > 148) {
								$this->createThumb($this->input->post('folder_path')."/".$newfilename, $this->input->post('folder_path')."/thumbs", 148);
							}	
							
							@unlink($this->input->post('folder_path')."/zip/".$f);
						}
						}
					} else {
						$unzip_error = "Zip file contains invalid files.";
					}
					$this->removeDir($this->input->post('folder_path')."/zip");
				} else {
					$unzip_error = "Failed to unzip file.";
				}
				@unlink($complete_file_path);
			}

			if ($unzip_error) 
			{ 
				echo $unzip_error; 
			} 
			else if ($upload_type == "property_asset_edit") 
			{ 
				echo '{ "file": "'. $upload_data['file_name'] .'", "error": "0" }';
			} 
			else 
			{ 
				echo "File/s uploaded successfully!"; 
			}
		}
	
		return;
	}
	// Robert
	public function upload_file() {
		$this->load->model('estate/blob_model');
		
		$user = isset($account_info) ? $account_info : (object) $this->session->userdata('subscriber_info');
		
		$status = "";
		$msg = "";
		$file_element_name = 'myfile';
	
		if (empty($_POST['title'])) {
			$status = "error";
			$msg = "Please enter a title";
		}
		
		if ($status != "error") {
			$fileContent = $_FILES[$file_element_name];
			$config['upload_path'] = base_url()."/_assets/uploads/";
			$config['allowed_types'] = 'png|pdf';
			$config['max_size']  = 1024 * 8;
			$config['encrypt_name'] = TRUE;
	
			$data['binary']   		= addslashes(file_get_contents($_FILES[$file_element_name]['tmp_name']));
			$data['account_id'] 	= $user->account_id;
			$data['mobile_number'] 	= $user->mobile_number;
			$data['filename'] 		= $fileContent["name"];
			$data['filetype'] 		= $fileContent["type"];
			$data['filesize'] 		= $fileContent["size"];
			$data['document_type'] 	= 'pofc';
			
			$this->load->library('upload', $config);
			$this->blob_model->save_file($data,"estate_financial_files_table");
			
			$status = "ok";
		}
		echo json_encode(array('status' => $status, 'msg' => $msg));
	}
	
}
?>