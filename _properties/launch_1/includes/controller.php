<?php 
error_reporting(0);

//GET SITE DATA
$controller = new Controller;
$site_data_temp = $controller->xml2array(file_get_contents("includes/data.xml"), 1, 'attribute');
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

if( isset($site_data) && isset($site_data['general_app_settings']) && isset($site_data['general_app_settings']['base_url']) && $site_data['general_app_settings']['base_url'] != '' ){
	//base url
	$base_url = $site_data['general_app_settings']['base_url'];
}else{
	die('misconfiguration in base_url');
}

//REDIRECT
if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == ""){
    $redirect = $base_url;
    header("Location: $redirect");
}

//get data url
$get_data_url = $base_url . 'getData.php';

//send email url
$send_email_url = $base_url . 'sendEmail.php';

//response key -> tells jQuery that data retrieval is successfull
$response_key = 'E3BBEE5F4FB9FEA7BCAA3E582F6597F8F578F8CBAE656B766A74';

/*CONFIGURATION*/
if( isset($site_data) && isset($site_data['general_app_settings']) && isset($site_data['general_app_settings']['fb_app_id']) && $site_data['general_app_settings']['fb_app_id'] != '' ){
	$fb_app_id = $site_data['general_app_settings']['fb_app_id'];
}else{
	die('misconfiguration in facebook app id');
}

$category_1 = 'default category 1 text';
$category_2 = 'default category 2 text';
$category_3 = 'default category 3 text';
$category_4 = 'default category 4 text';
$category_5 = 'default category 5 text';

if( isset($site_data) && isset($site_data['category_names']) && isset($site_data['category_names']['category_name_1']) && $site_data['category_names']['category_name_1'] != '' ){
	$category_1 = ucwords($site_data['category_names']['category_name_1']);
}
if( isset($site_data) && isset($site_data['category_names']) && isset($site_data['category_names']['category_name_2']) && $site_data['category_names']['category_name_2'] != '' ){
	$category_2 = ucwords($site_data['category_names']['category_name_2']);
}
if( isset($site_data) && isset($site_data['category_names']) && isset($site_data['category_names']['category_name_3']) && $site_data['category_names']['category_name_3'] != '' ){
	$category_3 = ucwords($site_data['category_names']['category_name_3']);
}
if( isset($site_data) && isset($site_data['category_names']) && isset($site_data['category_names']['category_name_4']) && $site_data['category_names']['category_name_4'] != '' ){
	$category_4 = ucwords($site_data['category_names']['category_name_4']);
}
if( isset($site_data) && isset($site_data['category_names']) && isset($site_data['category_names']['category_name_5']) && $site_data['category_names']['category_name_5'] != '' ){
	$category_5 = ucwords($site_data['category_names']['category_name_5']);
}
	
function checkRemoteFile($url){
	if(@GetImageSize($url)){
		//image exists!
		return true;
	}else{
		//image does not exist.
		return false;
	}
}

function filterString($str){
	return preg_replace('/[\Â]/', '', $str);
}

function htmlallentities($str){
  $res = '';
  $strlen = strlen($str);
  for($i=0; $i<$strlen; $i++){
    $byte = ord($str[$i]);
    if($byte < 128) // 1-byte char
      $res .= $str[$i];
    elseif($byte < 192); // invalid utf8
    elseif($byte < 224) // 2-byte char
      $res .= '&#'.((63&$byte)*64 + (63&ord($str[++$i]))).';';
    elseif($byte < 240) // 3-byte char
      $res .= '&#'.((15&$byte)*4096 + (63&ord($str[++$i]))*64 + (63&ord($str[++$i]))).';';
    elseif($byte < 248) // 4-byte char
      $res .= '&#'.((15&$byte)*262144 + (63&ord($str[++$i]))*4096 + (63&ord($str[++$i]))*64 + (63&ord($str[++$i]))).';';
  }
  return $res;
}

class Controller
{
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
	
	function determineTotal($array1, $array2)
	{
		unset($array1['attr']);
		unset($array2['attr']);
		$total = 0;
		if (count($array1) >= count($array2)) { $total = count($array1); } 
		else { $total = count($array2); }
		return $total;
	}
}
?>