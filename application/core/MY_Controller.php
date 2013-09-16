<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller 
{

	function populateMenu()
	{
		$menu_items = $this->model_main->getMenuItems();
		$counter = 0;
		
		if ($menu_items) {
		foreach ($menu_items as $menu_item => $mi) {	
			$menu_items[$counter]['link'] = base_url() . $menu_items[$counter]['controller'];	
			$counter++;
		}
		}
		
		return $menu_items;
	}
	
	function populateMenuDashboard()
	{
		$menu_items = $this->model_main->getMenuItemsDashboard();
		
		// append the path to the image field
		$counter = 0;
		if ($menu_items) {
		foreach ($menu_items as $menu_item => $mi) {
			$inner_counter = 0;
			if ($mi['sub_menu']) {
			foreach ($mi['sub_menu'] as $sub_menu => $sm) {
				$menu_items[$counter]['sub_menu'][$inner_counter]['image'] = base_url() . "_assets/images/".  $sm['image'];
				$menu_items[$counter]['sub_menu'][$inner_counter]['link'] = base_url() .  $sm['link'];
				$inner_counter++;
			}
			}
			$counter++;
		}
		}
		
		return $menu_items;
	}
	
	function populateUserRoles()
	{
		return $this->model_main->getUserRoles();
	}
	
	function populateEcommerceUserRoles()
	{
		return $this->model_main->getEcommerceUserRoles();
	}
	
	function populateClients($order_by='title', $order='ASC')
	{
		return $this->model_main->getClients($order_by, $order);
	}
	
	function populateAgencies($order_by='title', $order='ASC')
	{
		return $this->model_main->getAgencies($order_by, $order);
	}
	
	function populateAgents()
	{
		return $this->model_main->getAgents();
	}
	
	function populateTemplates()
	{
		$template_arr = $this->model_main->getTemplates();
		$template_arr = $this->addIdAsCode($template_arr, "template_id", 5);
		return $template_arr;
	}
	
	function populateTemplateTypes()
	{
		$template_type_arr = $this->model_main->getTemplateTypes();
		return $template_type_arr;
	}
	
	function populateFeatures()
	{
		return $this->model_main->getFeatures();
	}
	
	function populateSummary($company_id, $user_type, $status=0)
	{
		$summary_arr = array(); 
		
		$summary_arr[0]['title'] = "Clients";
		$summary_arr[0]['count'] = $this->getCount($company_id, $user_type, "clients", "client_id");

		$summary_arr[1]['title'] = "Templates";
		$summary_arr[1]['count'] = $this->getCount($company_id, $user_type, "templates", "template_id");

		$summary_arr[2]['title'] = "Properties";
		$summary_arr[2]['count'] = $this->getCount($company_id, $user_type, "properties", "property_id");

		$summary_arr[3]['title'] = "Users";
		$summary_arr[3]['count'] = $this->getCount($company_id, $user_type, "users", "user_id");
		
		return $summary_arr;
	}
	
	function getCount($company_id, $user_type, $table, $field)
	{
		return $this->model_main->retrieveCount($company_id, $user_type, $table, $field);
	}
	
	function cleanString($string, $delimiter)
	{
		$string = strip_tags($string);
        $string = stripslashes(	$string);
        $string = preg_replace( "#[^a-zA-Z0-9 ]#", "", $string);
		$string = str_replace("&", "", $string);
		$string = trim($string);
		$string = preg_replace('/\s{2,}/',' ', $string); // eliminate double spaces - prevent "__" in file folder name
		$string = str_replace(" ", $delimiter, $string); // create file folder name
		$string = strtolower($string);
		return $string;
	}
	
	function cleanStringForDB($item)
	{	
		if (is_array($item)) {
			$counter = 0;
			if ($item) {
			foreach ($item as $i) {
				if (is_array($i)) {
					if ($i) {
					foreach ($i as $key => $value) {
						$item[$counter][$key] = $this->cleanStringForDB($value);	
					}
					}
				} else {
					$item[$counter] = $this->cleanStringForDB($i);	
				}
				$item[$counter][$key] = $this->cleanStringForDB($value);
				$counter++;
			}
			}
			return $item;
		} else {
			$string = trim($item);
			$string = htmlentities($string, ENT_QUOTES);
			return $string;
		}
	}
	
	function shortenString($string, $length)
	{
		$pieces = str_split($string);
		$counter = 0;
		$shortened = "";
		while ($counter < $length) {
			$shortened .= $pieces[$counter];
			$counter++;
		}
		if (strlen($shortened) < strlen($string)) { $shortened = trim($shortened)."..."; }
		return $shortened;
	}
	
	function shortenArrayItem($array, $field_arr, $length)
	{
		if ($field_arr) {
		foreach ($field_arr as $field => $f) {
			$counter = 0;
			if ($array) {
			foreach ($array as $arr => $a) {
				if (is_array($a)) {
					$shortened = $this->shortenString($a[$f], 30);
					$array[$counter][$f] = $shortened;
					$counter++;
				}
			}
			}
		}
		}
		return $array;
	}
	
	function padDigit($digit, $length)
	{	
		while (strlen($digit) < $length) {
			$digit = "0" . $digit;
		}
		return $digit;
	}
		
	function toArray($xml)
	{
        $array = json_decode(json_encode($xml), true);
        foreach (array_slice($array, 0) as $key => $value ) {
            if (empty($value)) { $array[$key] = null; }
            else if (is_array($value)) { $array[$key] = $this->toArray($value); }
        }
		$array = $this->cleanArrayAddLabel($array);
        return $array;
    }
	
	function cleanArrayAddLabel($array)
	{
		$to_replace = array("_", ".", "+", "-");
		$new_array = array(); 
		if ($array) {
		foreach ($array as $key => $value) { 
			$label = str_replace($to_replace, " ", $key);
			$label = ucwords($label);
			if (is_array($value)) { $value = $this->cleanArrayAddLabel($value); }
			$new_array[$key] = $value;
			if (is_array($new_array[$key])) { $new_array[$key]['label'] = $label; }
		}
		}
		return $new_array;
	}
	
	function processXML($post_array)
	{	
		$title = $post_array['title'];
		$folder_name = $this->cleanString($title, "_");
		$folder_path = $this->config->item("base_property_path").$folder_name;
		
		// fix hierarchy of post data first
		$site_data = $this->xml2array(file_get_contents($folder_path."/includes/data.xml"), 1, 'attribute');
		$site_data = $this->cleanArrayAddLabel($site_data['site']);
		
		// get array sections
		$arr_sections = array();
		if ($site_data) {
		foreach ($site_data as $key => $value) {
			$arr_sections[] = $key;
		}
		}
		
		$nested_arr = array();
		if ($arr_sections) {
		foreach ($arr_sections as $key => $value) {
			$key_length = strlen($value)+2;
			if ($post_array) {
			foreach ($post_array as $key_post => $value_post) {
				if (substr($key_post, -$key_length) == "__".$value) {
					$key_post_new = substr($key_post, 0, -$key_length);
					$nested_arr[$value][$key_post_new] = $value_post;
				}
			}
			}
		}
		}
		
		/*
		echo "<pre style='text-align: left;'>";
		print_r($nested_arr);
		echo "</pre>";
		*/
		
		// $value2 = str_replace("%C2", "", $value2); // remove prepended "%C2"
			
		// update xml
		$site = simplexml_load_file($folder_path."/includes/data.xml");

		if ($nested_arr) {
		foreach ($nested_arr as $key => $value) { 
			if ($value) {
			foreach ($value as $key2 => $value2) {
				// for cdata
				$temp_arr = array();
				$temp_arr = $site->$key->$key2->attributes();
				if ($temp_arr['customhtml']) {
					$site->$key->$key2 = NULL;
					$node = dom_import_simplexml($site->$key->$key2);
					$doc = $node->ownerDocument; 
					$value2 = str_replace(PHP_EOL, '', $value2);
					$value2 = trim($value2);
					$node->appendChild($doc->createCDATASection($value2));
				} else { 
					// for incremental site data xml version
					if ($key2 == "data_version") { $value2 = $value2 + 1; } 
					else { $value2 = $value2; }
					$site->$key->$key2 = $value2;
				}
				// $site->asXML($folder_path."/includes/data.xml");
				
				// format xml
				$dom = new DOMDocument('1.0');
				$dom->preserveWhiteSpace = false;
				$dom->formatOutput = true;
				$dom->loadXML($site->asXML());
				$dom->save($folder_path."/includes/data.xml");
			}
			}
		}
		}

		return;
	}
	
	function copyTemplateToSite($files_arr, $template_folder, $new_folder) 
	{
		if ($files_arr) {
		foreach ($files_arr as $files => $f) {
			if (is_dir($template_folder."/".$f)) {
				@mkdir($new_folder."/".$f);
				@chmod($new_folder."/".$f, 0755);
				$inner_files_arr = get_filenames($template_folder."/".$f, FALSE, TRUE);
				$this->copyTemplateToSite($inner_files_arr, $template_folder."/".$f, $new_folder."/".$f);
			} else {
				@copy($template_folder."/".$f, $new_folder."/".$f);	
			}
		}
		}
		return;
	}
	
	/** 
	* xml2array() will convert the given XML text to an array in the XML structure. 
	* Link: http://www.bin-co.com/php/scripts/xml2array/ 
	* Arguments : 	$contents - The XML text 
	*             	$get_attributes - 1 or 0. If this is 1 the function will get the attributes as well as the tag values - this results in a different array structure in the return value.
	*            	$priority - Can be 'tag' or 'attribute'. This will change the way the resulting array sturcture. For 'tag', the tags are given more importance.
	* Return: The parsed XML in an array form. Use print_r() to see the resulting array structure. 
	* Examples:	 	$array =  xml2array(file_get_contents('feed.xml')); 
	*           	$array =  xml2array(file_get_contents('feed.xml', 1, 'attribute')); 
	*/ 
	function xml2array($contents, $get_attributes=1, $priority = 'tag') 
	{
		if(!$contents) return array(); 

		if(!function_exists('xml_parser_create')) { 
			return array(); 
		} 

		//Get the XML parser of PHP - PHP must have this module for the parser to work 
		$parser = xml_parser_create(''); 
		xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8"); # http://minutillo.com/steve/weblog/2004/6/17/php-xml-and-character-encodings-a-tale-of-sadness-rage-and-data-loss 
		xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0); 
		xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1); 
		xml_parse_into_struct($parser, trim($contents), $xml_values); 
		xml_parser_free($parser); 

		if(!$xml_values) return;

		//Initializations 
		$xml_array = array(); 
		$parents = array(); 
		$opened_tags = array(); 
		$arr = array(); 

		$current = &$xml_array; //Refference 

		//Go through the tags. 
		$repeated_tag_index = array(); //Multiple tags with same name will be turned into an array 
		foreach($xml_values as $data) { 
			unset($attributes,$value); //Remove existing values, or there will be trouble 

			//This command will extract these variables into the foreach scope tag(string), type(string), level(int), attributes(array). 
			extract($data);//We could use the array by itself, but this cooler. 

			$result = array(); 
			$attributes_data = array(); 
			 
			if(isset($value)) { 
				if($priority == 'tag') $result = $value; 
				else $result['value'] = $value; //Put the value in a assoc array if we are in the 'Attribute' mode
			} 

			//Set the attributes too. 
			if(isset($attributes) and $get_attributes) { 
				foreach($attributes as $attr => $val) { 
					if($priority == 'tag') $attributes_data[$attr] = $val; 
					else $result['attr'][$attr] = $val; //Set all the attributes in a array called 'attr' 
				} 
			} 

			//See tag status and do the needed. 
			if($type == "open") { //The starting of the tag '<tag>' 
				$parent[$level-1] = &$current; 
				if(!is_array($current) or (!in_array($tag, array_keys($current)))) { //Insert New tag 
					$current[$tag] = $result; 
					if($attributes_data) $current[$tag. '_attr'] = $attributes_data; 
					$repeated_tag_index[$tag.'_'.$level] = 1; 

					$current = &$current[$tag]; 

				} else { //There was another element with the same tag name 

					if(isset($current[$tag][0])) {//If there is a 0th element it is already an array 
						$current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result; 
						$repeated_tag_index[$tag.'_'.$level]++; 
					} else {//This section will make the value an array if multiple tags with the same name appear together
						$current[$tag] = array($current[$tag],$result);//This will combine the existing item and the new item together to make an array
						$repeated_tag_index[$tag.'_'.$level] = 2; 
						 
						if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well
							$current[$tag]['0_attr'] = $current[$tag.'_attr']; 
							unset($current[$tag.'_attr']); 
						} 

					} 
					$last_item_index = $repeated_tag_index[$tag.'_'.$level]-1; 
					$current = &$current[$tag][$last_item_index]; 
				} 

			} elseif($type == "complete") { //Tags that ends in 1 line '<tag />' 
				//See if the key is already taken. 
				if(!isset($current[$tag])) { //New Key 
					$current[$tag] = $result; 
					$repeated_tag_index[$tag.'_'.$level] = 1; 
					if($priority == 'tag' and $attributes_data) $current[$tag. '_attr'] = $attributes_data; 

				} else { //If taken, put all things inside a list(array) 
					if(isset($current[$tag][0]) and is_array($current[$tag])) {//If it is already an array... 

						// ...push the new element into that array. 
						$current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result; 
						 
						if($priority == 'tag' and $get_attributes and $attributes_data) { 
							$current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data; 
						} 
						$repeated_tag_index[$tag.'_'.$level]++; 

					} else { //If it is not an array... 
						$current[$tag] = array($current[$tag],$result); //...Make it an array using using the existing value and the new value
						$repeated_tag_index[$tag.'_'.$level] = 1; 
						if($priority == 'tag' and $get_attributes) { 
							if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well
								 
								$current[$tag]['0_attr'] = $current[$tag.'_attr']; 
								unset($current[$tag.'_attr']); 
							} 
							 
							if($attributes_data) { 
								$current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data; 
							} 
						} 
						$repeated_tag_index[$tag.'_'.$level]++; //0 and 1 index is already taken 
					} 
				} 

			} elseif($type == 'close') { //End of tag '</tag>' 
				$current = &$parent[$level-1]; 
			} 
		} 
		 
		return($xml_array); 
	}  
	
	function generateRandomPassword() 
	{
		$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
		$pass = array();
		$alphaLength = strlen($alphabet) - 1;
		
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		
		$pass = implode($pass);
		return $pass;
	}
	
	function arraySort($array, $on, $order=SORT_ASC)
	{
		$new_array = array();
		$sortable_array = array();

		if (count($array) > 0) {
		
			foreach ($array as $k => $v) {
				if (is_array($v)) {
					foreach ($v as $k2 => $v2) {
						if ($k2 == $on) { $sortable_array[$k] = $v2; }
					}
				} else {
					$sortable_array[$k] = $v;
				}
			}

			switch ($order) {
				case SORT_ASC:	asort($sortable_array); break;
				case SORT_DESC: arsort($sortable_array); break;
			}

			foreach ($sortable_array as $k => $v) { $new_array[$k] = $array[$k]; }
			
		}

		return $new_array;
	}
	
	function getFolderSize($path) 
	{
		$total_size = 0;
		$files = scandir($path);
		$cleanPath = rtrim($path, '/'). '/';

		foreach($files as $t) {
		if ($t<>"." && $t<>"..") {
			$currentFile = $cleanPath . $t;
			if (is_dir($currentFile)) {
				$size = $this->getFolderSize($currentFile);
				$total_size += $size;
			} else {
				$size = filesize($currentFile);
				$total_size += $size;
			}
		}   
		}

		return $total_size;
	}

	function getFolderSizeByItem($array, $field, $folder)
	{
		$size = 0;
		if ($array) {
		foreach ($array as $arr => $a) { 
			if ($field == "user_id") { $folder_name = $this->padDigit($a[$field], 5); }
			if ($field == "folder_name") { $folder_name = $a[$field]; }
			$size = $size + $this->getFolderSize($folder.$folder_name);
		}
		}
		return $size;
	}
	
	function formatSize($size) 
	{
		$units = explode(' ', 'B KB MB GB TB PB');
		$mod = 1024;
		for ($i = 0; $size > $mod; $i++) { $size /= $mod; }
		$endIndex = strpos($size, ".")+3;
		return substr($size, 0, $endIndex).' '.$units[$i];
	}
	
	function addNullIndicators($array, $null_indicator)
	{
		$counter = 0;
		if ($array) {
		foreach ($array as $arr => $a) { 
			if ($a && is_array($a)) {
				foreach ($a as $key => $value) {
					if ($value == "") { $array[$counter][$key] = $null_indicator; }
				}
			}
			else
			{
				if ($a == "") { $array[$arr] = $null_indicator; }
			}
			$counter++;
		}
		}
		return $array;
	}
	
	function decodeBase64($array, $to_decode)
	{
		$counter = 0;
		if ($array) {
		foreach ($array as $key => $a) { 
			if (is_array($a)) { // for 2-dimensional arrays
				if ($a) {
				foreach ($a as $key => $value) {
					if (in_array($key, $to_decode)) { $array[$counter][$key] = base64_decode($value); }
				}
				}
			} else {
				if (in_array($key, $to_decode)) { $array[$key] = base64_decode($a); }
			}
			$counter++;
		}
		}
		return $array;
	}
	
	function getGeneralSummary()
	{		
		$this->load->model('model_users');
		$this->load->model('model_properties');
	
		$company_id = $this->session->userdata('company_id');
		$user_type = $this->session->userdata('user_type');
		
		// user count
		$user_arr = $this->model_users->getUsersByClientId($company_id, $user_type, "last_name", "asc", 0, "all");
		$count = $user_arr['total_count'];
		$summary['count_users']['label'] = ($count == 1) ? "User" : "Users";
		$summary['count_users']['num'] = $count;
		$summary['count_users']['text'] = $count;
		
		// property count
		$property_arr = $this->model_properties->getProperties($company_id, $user_type, "properties.title", "asc", 0, "all");
		$count = $property_arr['total_count'];
		$summary['count_properties']['label'] = ($count == 1) ? "Property" : "Properties";
		$summary['count_properties']['num'] = $count;
		$summary['count_properties']['text'] = $count;
		
		// MySQL users table
		$user_arr = $this->model_users->getUsersByClientId($company_id, $user_type, "last_name", "asc", 0, "all");
		unset($user_arr['total_count']);
		$users_folder_size = $this->getFolderSizeByItem($user_arr, "user_id", $this->config->item('base_user_path'));
		$users_folder_size_text = $this->formatSize($users_folder_size);
		$summary['mysql_users']['label'] = "MySQL DB Usage";
		$summary['mysql_users']['num'] = $users_folder_size;
		$summary['mysql_users']['text'] = $users_folder_size_text;
		
		// properties disk space
		$property_arr = $this->model_properties->getProperties($company_id, $user_type, "properties.title", "asc", 0, "all");
		unset($property_arr['total_count']);
		$property_folder_size = $this->getFolderSizeByItem($property_arr, "folder_name", $this->config->item('base_property_path'));
		$property_folder_size_text = $this->formatSize($property_folder_size);
		$summary['properties_disk']['label'] = "Disk Space Usage";
		$summary['properties_disk']['num'] = $property_folder_size;
		$summary['properties_disk']['text'] = $property_folder_size_text;
		
		return $summary;
	}
	
	function getSummary()
	{		
		$this->load->model('model_users');
		$this->load->model('model_properties');
	
		$company_id = $this->session->userdata('company_id');
		$user_type = $this->session->userdata('user_type');
		
		// user count
		$user_arr = $this->model_users->getUsers($company_id, $user_type, "last_name", "asc", 0, "all");
		$count = $user_arr['total_count'];
		$summary['count_users']['label'] = ($count == 1) ? "User" : "Users";
		$summary['count_users']['num'] = $count;
		$summary['count_users']['text'] = $count;
		
		// property count
		$property_arr = $this->model_properties->getProperties($company_id, $user_type, "properties.title", "asc", 0, "all");
		$count = $property_arr['total_count'];
		$summary['count_properties']['label'] = ($count == 1) ? "Property" : "Properties";
		$summary['count_properties']['num'] = $count;
		$summary['count_properties']['text'] = $count;
		
		// MySQL users table
		$user_arr = $this->model_users->getUsers($company_id, $user_type, "last_name", "asc", 0, "all");
		unset($user_arr['total_count']);
		$users_folder_size = $this->getFolderSizeByItem($user_arr, "user_id", $this->config->item('base_user_path'));
		$users_folder_size_text = $this->formatSize($users_folder_size);
		$summary['mysql_users']['label'] = "MySQL DB Usage";
		$summary['mysql_users']['num'] = $users_folder_size;
		$summary['mysql_users']['text'] = $users_folder_size_text;
		
		// properties disk space
		$property_arr = $this->model_properties->getProperties($company_id, $user_type, "properties.title", "asc", 0, "all");
		unset($property_arr['total_count']);
		$property_folder_size = $this->getFolderSizeByItem($property_arr, "folder_name", $this->config->item('base_property_path'));
		$property_folder_size_text = $this->formatSize($property_folder_size);
		$summary['properties_disk']['label'] = "Disk Space Usage";
		$summary['properties_disk']['num'] = $property_folder_size;
		$summary['properties_disk']['text'] = $property_folder_size_text;
		
		return $summary;
	}
	
	function getAvatarPath($array)
	{
		$counter = 0;
		if ($array) {
		foreach ($array as $key => $a) {
			if (is_array($a)) { 
				$folder_name = $this->padDigit($a['user_id'], 5);
				$folder_path = $this->config->item("base_user_path") . $folder_name;
				if (file_exists($folder_path . "/avatar.png")) { 
					$avatar_path = base_url() . "_users/" . $folder_name . "/avatar.png";
				} else {
					$avatar_path = base_url() . "_users/_default/avatar.png";
				}
				$array[$counter]['avatar_path'] = $avatar_path;
				$counter++;
			} else {
				if ($key == "user_id") {
					$folder_name = $this->padDigit($a, 5);
					$folder_path = $this->config->item("base_user_path") . $folder_name;
					if (file_exists($folder_path . "/avatar.png")) { 
						$avatar_path = base_url() . "_users/" . $folder_name . "/avatar.png";
					} else {
						$avatar_path = base_url() . "_users/_default/avatar.png";
					}
					$array['avatar_path'] = $avatar_path;
				}
			}
		}
		}
		return $array;
	}
	
	function getTemplateScreenshotPath($array, $location="back")
	{
		// get screenshots for templates
		$counter = 0;
		if ($array) { 
		foreach ($array as $arr => $a) { 
			$folder_name = $this->cleanString($a['title'], "_");
			if (file_exists($this->config->item('base_template_path') . $folder_name . ".jpg")) {
				$array[$counter]['screenshot_path'] = base_url() . "_templates/" . $folder_name . ".jpg";
			} else if (file_exists($this->config->item('base_template_path') . $folder_name . ".png")) {
				$array[$counter]['screenshot_path'] = base_url() . "_templates/" . $folder_name . ".png";
			} else { 
				if ($location == "back") { $array[$counter]['screenshot_path'] = base_url() . "_assets/images/no_screenshot.png"; } 
				else { $array[$counter]['screenshot_path'] = base_url() . "_assets/images/no_screenshot_front.png"; }
			}
			$counter++;
		}
		}
		return $array;
	}
	
	function addIdAsCode($array, $field, $num_digits) 
	{
		$counter = 0;
		if ($array) {
		foreach ($array as $arr => $a) {
			if ($a && is_array($a)) {
			foreach ($a as $key => $value) {
				if ($key == $field) { $array[$counter][$field.'_code'] = $this->padDigit($value, $num_digits); }
			}
			}
			$counter++;
		}
		}
		return $array;
	}
	
	function getAlphabet()
	{
		$alphabet = range('A', 'Z');
		return $alphabet;
	}
	
	function formatNum($array, $field, $decimal_places, $currency = "P")
	{
		$counter = 0;
		if ($array) {
		foreach ($array as $arr => $a) {
			if ($a) {
			foreach ($a as $key => $value) {
				if ($key == $field) {
					$array[$counter][$key] = $currency . number_format($array[$counter][$key], $decimal_places, '.', '');
				}
			}
			}
			$counter++;
		}	
		}
		return $array;
	}
	
	function getTotal($array, $field, $decimal_places, $currency = "P")
	{
		$total = 0;
		if ($array) {
		foreach ($array as $arr => $a) {
			if ($a) {
			foreach ($a as $key => $value) {
				if ($key == $field) { $total = $total + $value; } 
			}
			}
		}
		}
		return $currency . number_format($total, $decimal_places, '.', '');
	}
	
	function getTemplatesAllowed($features)
	{
		$templates_allowed = array();
		if ($features) {
		foreach ($features as $feature => $f) {
			if ($f['template_type_id'] != 0) {
			if (!in_array($f['template_type_id'], $templates_allowed)) {
				$templates_allowed[] = $f['template_type_id'];
				// if microsite is available, mobile site should also be available
				if ($f['template_type_id'] == 1) { $templates_allowed[] = 2; } 
			}			
			}
		}
		}
		return $templates_allowed;
	}
	
	// recursively delete a folder - even folder inside and so on..
	function removeDir($dir) 
	{
		foreach(glob($dir . '/*') as $file) 
		{
			if(is_dir($file)) { $this->removeDir($file); }
			else { @unlink($file); }
		}
		$file_arr = get_filenames($dir, FALSE);
		rmdir($dir);
		return;
	}
	
	function fileNewname($path, $filename)
	{
		if ($pos = strrpos($filename, '.')) {
		   $name = substr($filename, 0, $pos);
		   $ext = substr($filename, $pos);
		} else {
		   $name = $filename;
		}

		$newpath = $path.'/'.$filename;
		$newname = $filename;
		$counter = 0;
		while (file_exists($newpath)) {
			$newname = $name .'_'. $counter . $ext;
			$newpath = $path.'/'.$newname;
			$counter++;
		 }

		return $newname;
	}
	
	function checkValidContents($dir, $allowed_extensions)
	{
		$valid_contents = TRUE;
		
		foreach(glob($dir . '/*') as $file) 
		{
			$ext = substr(strrchr($file,'.'), 1);
			if (!in_array($ext, $allowed_extensions)) { $valid_contents = FALSE; }
		}
		
		return $valid_contents;
	}
	
	function getHighestVal($array, $field)
	{
		$highest_val = 0;
		if ($array) {
		foreach ($array as $arr => $a) {
			if ($a[$field] > $highest_val) { $highest_val = $a[$field]; }
		}
		}
		return $highest_val;
	}
	
	function detectBrowser()
	{
		$u_agent = $_SERVER['HTTP_USER_AGENT'];
		$ub = '';
		if(preg_match('/MSIE/i',$u_agent)) { $ub = "ie"; }
		if(preg_match('/Firefox/i',$u_agent)) { $ub = "firefox"; }
		if(preg_match('/Safari/i',$u_agent)) { $ub = "safari"; }
		if(preg_match('/Chrome/i',$u_agent)) { $ub = "chrome"; }
		if(preg_match('/Flock/i',$u_agent)) { $ub = "flock"; }
		if(preg_match('/Opera/i',$u_agent)) { $ub = "opera"; }
		return $ub;
	}
	
	function createThumb($img_path, $thumb_path, $thumb_width) 
	{
		if (!(file_exists($thumb_path))) { @mkdir($thumb_path); }
	
		$thumb_width = (int)$thumb_width;
		$info = pathinfo($img_path);
		if (strtolower($info['extension']) == 'jpg') 
		{
			// load image and get image size
			$img = imagecreatefromjpeg($img_path);
			$width = imagesx($img);
			$height = imagesy($img);

			// calculate thumbnail size
			$new_width = $thumb_width;
			$new_height = floor($height * ($thumb_width / $width));
			$tmp_img = imagecreatetruecolor($new_width, $new_height); // create a new temporary image
			imagecopyresized($tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height); // copy and resize old image into new image 
			imagejpeg($tmp_img, $thumb_path."/".$info['basename']); // save thumbnail into a file
		}
		else if (strtolower($info['extension']) == 'png')
		{		
			// load image and get image size
			$img = imagecreatefrompng($img_path);
			$width = imagesx($img);
			$height = imagesy($img);

			// calculate thumbnail size
			$new_width = $thumb_width;
			$new_height = floor($height * ($thumb_width / $width));
			$tmp_img = imagecreatetruecolor($new_width, $new_height); // create a new temporary image
			
			$background = imagecolorallocate($img, 0, 0, 0);
			// removing the black from the placeholder
			imagecolortransparent($tmp_img, $background);

			// turning off alpha blending (to ensure alpha channel information 
			// is preserved, rather than removed (blending with the rest of the 
			// image in the form of black))
			imagealphablending($tmp_img, false);

			// turning on alpha channel information saving (to ensure the full range 
			// of transparency is preserved)
			imagesavealpha($tmp_img, true);
			
			imagecopyresized($tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height); // copy and resize old image into new image 
			imagepng($tmp_img, $thumb_path."/".$info['basename']); // save thumbnail into a file
		}
		
		return;
	}
	
	function detailedFileArr($file_arr, $folder_name) 
	{
		// append the path to each image
		$counter = 0;
		if ($file_arr) {
		foreach ($file_arr as $key => $f) { 
			$file_path = $this->config->item('base_property_path') . $folder_name . "/assets/" . $key;
			$file_path_thumb = $this->config->item('base_property_path') . $folder_name . "/assets/thumbs/" . $key;
			
			if (is_dir($file_path))
			{
				unset($file_arr[$key]);
			}
			else
			{
				$file_url = base_url() . "_properties/" . $folder_name . "/assets/" . $key;
				$file_url_thumb = base_url() . "_properties/" . $folder_name . "/assets/thumbs/" . $key;
			
				$file_arr_return[$counter]['file_name'] = $key;
				$file_arr_return[$counter]['path'] = $file_path;
				$file_arr_return[$counter]['path_thumb'] = (file_exists($file_path_thumb)) ? $file_path_thumb : $file_path;
				$file_arr_return[$counter]['url'] = $file_url;
				$file_arr_return[$counter]['url_thumb'] = (file_exists($file_path_thumb)) ? $file_url_thumb : $file_url;
				$file_arr_return[$counter]['size'] = getimagesize($file_arr_return[$counter]['url']);
				$file_arr_return[$counter]['size_thumb'] = getimagesize($file_arr_return[$counter]['url_thumb']);
				$file_arr_return[$counter]['file_size'] = $this->formatSize(filesize($file_path));
				$file_arr_return[$counter]['ext'] = pathinfo($key, PATHINFO_EXTENSION);
				$counter++;
			}

		}
		}
		$file_arr_return = $this->arraySort($file_arr_return, 'file_name', SORT_ASC); // sort array
		return $file_arr_return;
	}
	
	function getPropertyDataXML($property_id)
	{
		$property_details = $this->model_main->getSimplePropertyDetails($property_id);
		
		if( isset($property_details['title']) ){
			$folder_name = $this->cleanString($property_details['title'], "_");
		}else{
			return array();
		}
		
		//GET SITE DATA
		$site_data_temp = $this->xml2array(file_get_contents( $this->config->item('base_property_url') . $folder_name . "/includes/data.xml"), 1, 'attribute');
		$site_data_temp = $site_data_temp['site'];

		// simplfiy site_data structure more
		$site_data = array();
		if ($site_data_temp) {
			foreach ($site_data_temp as $label => $s) {
				$site_data[$label] = array();
				if ($s) {
					foreach ($s as $key => $value) {
						if ($key != "attr") {
							if (isset($value['value'])) {
								$site_data[$label][$key] = $value['value'];
							} else { 
								$site_data[$label][$key] = "";
							}
						}
					}
				}
			}
		}
		
		$site_data['site_settings']['property_base_url'] = base_url() . $this->config->item('base_property_url') . $folder_name . '/';
		$site_data['site_settings']['property_assets_url'] = base_url() . $this->config->item('base_property_url') . $folder_name . '/assets/';
		$site_data['site_settings']['property_assets_thumbs_url'] = base_url() . $this->config->item('base_property_url') . $folder_name . '/assets/thumbs/';
		$site_data['site_settings']['property_base_path'] = $this->config->item('base_property_path') . $folder_name . '/';
		
		return $site_data;
	}
}
?>