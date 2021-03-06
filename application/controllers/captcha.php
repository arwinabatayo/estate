<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Captcha extends CI_Controller {
	
    function __construct(){
		parent::__construct();
		
		error_reporting(1);
        ini_set('display_errors',1); 
		$this->load->library('session');
		        
	}
	

	
	function index(){

	}
	

	
	function test(){
		echo SITE_BASEPATH;
		//$captcha_config  = unserialize( $this->session->userdata('captcha_cfg') );
       // print_r($captcha_config);
	}
	
	function validate(){
		$d = (object) $this->input->post();
		$captcha_code = $this->session->userdata('captcha_code');
		
        $result=array();
		$result['status'] = 'error';
		$result['msg']    = 'Characters did not match!';
		
		if($d->input_code == $captcha_code){
			
			$result['status'] = 'success';
            
            $mobile_number = $this->session->userdata('msisdn');
            $verification_code_sent = true; // API CALL - sendVerificationCode
            
			
				if( $verification_code_sent ){
                        $this->load->model('estate/networks_model');
                        $mobile = $this->session->userdata('current_subscriber_mobileno');
                        
                        
                        $this->load->library('GlobeWebService','','api_globe');
                        $verification_code = random_string('alnum', 6);
                        $message = "Please use this code ".$verification_code." to verify your account.";
                        $sms_status = $this->api_globe->api_send_sms($mobile, $message, "Project Esate");
						
						/* Temporary Code For SAT and UAT Purposes */ 
						$email = $this->session->userdata('current_subscriber_email');
						$this->load->library('GlobeWebService','','api_globe');
						$email_status = $this->api_globe->SendEmail($email, "Project Estate SMS Verification Code", $verification_code);

                        if($sms_status == TRUE) {
							
                            $this->load->model('estate/networks_model');
                            $this->networks_model->insert_sms_verification($mobile, $verification_code);
                            $result['msg']    = 'SMS successfully sent to you mobile number!';
                            
                        } else {
                            
                            $result['status'] = "error";
                            $result['msg'] = "Failed sending sms. Please try again.";
                        }
                }else{
                            $result['msg']    = 'Error occured while sending verification code';
                }
                
                
		}

		echo json_encode($result);
		exit;
		
		
	}
	
	function get_captcha_img(){

		$img = $this->_captcha();
		$src = array(
			'src' => $img['image_src'] 
		);
		//print_r($src);
		echo json_encode($src);
	}
		
	private function _captcha($config = array()) {

		// Check for GD library
		if( !function_exists('gd_info') ) {
			throw new Exception('Required GD library is missing');
		}
		
	//	$this->session->unset_userdata('captcha_cfg');
		
		// Default values
		$captcha_config = array(
			'code' => '',
			'min_length' => 5,
			'max_length' => 5,
			//'png_backgrounds' => array(dirname(__FILE__) . '/default.png'),
			'png_backgrounds' => array(SITE_BASEPATH.'/_assets/estate/_captcha/default.png'),
			'fonts' => array(SITE_BASEPATH.'/_assets/estate/_captcha/times_new_yorker.ttf'),
			'characters' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',
			'min_font_size' => 24,
			'max_font_size' => 30,
			'color' => '#000',
			'angle_min' => 0,
			'angle_max' => 15,
			'shadow' => true,
			'shadow_color' => '#CCC',
			'shadow_offset_x' => -2,
			'shadow_offset_y' => 2
		);

		// Overwrite defaults with custom config values
		if( is_array($config) ) {
			foreach( $config as $key => $value ) $captcha_config[$key] = $value;
		}
		
		// Restrict certain values
		if( $captcha_config['min_length'] < 1 ) $captcha_config['min_length'] = 1;
		if( $captcha_config['angle_min'] < 0 ) $captcha_config['angle_min'] = 0;
		if( $captcha_config['angle_max'] > 10 ) $captcha_config['angle_max'] = 10;
		if( $captcha_config['angle_max'] < $captcha_config['angle_min'] ) $captcha_config['angle_max'] = $captcha_config['angle_min'];
		if( $captcha_config['min_font_size'] < 10 ) $captcha_config['min_font_size'] = 10;
		if( $captcha_config['max_font_size'] < $captcha_config['min_font_size'] ) $captcha_config['max_font_size'] = $captcha_config['min_font_size'];
		
		// Use milliseconds instead of seconds
		srand(microtime() * 100);
		
		// Generate CAPTCHA code if not set by user
		if( empty($captcha_config['code']) ) {
			$captcha_config['code'] = '';
			$length = rand($captcha_config['min_length'], $captcha_config['max_length']);
			while( strlen($captcha_config['code']) < $length ) {
				$captcha_config['code'] .= substr($captcha_config['characters'], rand() % (strlen($captcha_config['characters'])), 1);
			}
		}

		// Generate image src
		//$image_src = substr(__FILE__, strlen($_SERVER['DOCUMENT_ROOT'])) . '?_CAPTCHA&amp;t=' . urlencode(microtime());
		//$image_src = '/' . ltrim(preg_replace('/\\\\/', '/', $image_src), '/');
		
		//$image_src = base_url().'captcha/create_captcha?_CAPTCHA&amp;t=' . urlencode(microtime());
		$image_src = base_url().'captcha/create_captcha?_CAPTCHA&t=' .urlencode(microtime());

		//$_SESSION['_CAPTCHA']['config'] = serialize($captcha_config);
		
		
		$this->session->set_userdata('captcha_cfg', serialize($captcha_config) );
		$this->session->set_userdata('captcha_code', $captcha_config['code'] );
		
		return array(
			'code' => $captcha_config['code'],
			'image_src' => $image_src
		);
		
	}
	
	function get_captcha_config(){
		
		/*$captcha_config  =  $this->session->userdata('captcha_cfg');
		//print_r( $this->session->userdata('captcha_cfg') );
		return $captcha_config;*/
	}
	
	function create_captcha(){
	
	if( !function_exists('hex2rgb') ) {
		function hex2rgb($hex_str, $return_string = false, $separator = ',') {
			$hex_str = preg_replace("/[^0-9A-Fa-f]/", '', $hex_str); // Gets a proper hex string
			$rgb_array = array();
			if( strlen($hex_str) == 6 ) {
				$color_val = hexdec($hex_str);
				$rgb_array['r'] = 0xFF & ($color_val >> 0x10);
				$rgb_array['g'] = 0xFF & ($color_val >> 0x8);
				$rgb_array['b'] = 0xFF & $color_val;
			} elseif( strlen($hex_str) == 3 ) {
				$rgb_array['r'] = hexdec(str_repeat(substr($hex_str, 0, 1), 2));
				$rgb_array['g'] = hexdec(str_repeat(substr($hex_str, 1, 1), 2));
				$rgb_array['b'] = hexdec(str_repeat(substr($hex_str, 2, 1), 2));
			} else {
				return false;
			}
			return $return_string ? implode($separator, $rgb_array) : $rgb_array;
		}
	}
	
	
	// Draw the image
	if( isset($_GET['_CAPTCHA']) ) {
		
		//session_start();
		
		//$captcha_config = unserialize($_SESSION['_CAPTCHA']['config']);
		//unset($_SESSION['_CAPTCHA']);
		
		//$captcha_config  = unserialize( $this->session->userdata('captcha_cfg') );
		$captcha_config  = unserialize( $this->session->userdata('captcha_cfg') );
//print_r($captcha_config);
//die();
		// Use milliseconds instead of seconds
		srand(microtime() * 100);
		
		// Pick random background, get info, and start captcha
		$background = $captcha_config['png_backgrounds'][rand(0, count($captcha_config['png_backgrounds']) -1)];
		list($bg_width, $bg_height, $bg_type, $bg_attr) = getimagesize($background);
		
		// Create captcha object
		$captcha = imagecreatefrompng($background);
	    imagealphablending($captcha, true);
	    imagesavealpha($captcha , true);
		
		$color = hex2rgb($captcha_config['color']);
		$color = imagecolorallocate($captcha, $color['r'], $color['g'], $color['b']);
	        
		// Determine text angle
		$angle = rand( $captcha_config['angle_min'], $captcha_config['angle_max'] ) * (rand(0, 1) == 1 ? -1 : 1);
		
		// Select font randomly
		$font = $captcha_config['fonts'][rand(0, count($captcha_config['fonts']) - 1)];
		
		// Verify font file exists
		if( !file_exists($font) ) throw new Exception('Font file not found: ' . $font);
		
		//Set the font size.
		$font_size = rand($captcha_config['min_font_size'], $captcha_config['max_font_size']);
		$text_box_size = imagettfbbox($font_size, $angle, $font, $captcha_config['code']);
		
		// Determine text position
		$box_width = abs($text_box_size[6] - $text_box_size[2]);
		$box_height = abs($text_box_size[5] - $text_box_size[1]);
		$text_pos_x_min = 0;
		$text_pos_x_max = ($bg_width) - ($box_width);
		$text_pos_x = rand($text_pos_x_min, $text_pos_x_max);			
		$text_pos_y_min = $box_height;
		$text_pos_y_max = ($bg_height) - ($box_height / 2);
		$text_pos_y = rand($text_pos_y_min, $text_pos_y_max);
		
		// Draw shadow
		if( $captcha_config['shadow'] ){
			$shadow_color = hex2rgb($captcha_config['shadow_color']);
		 	$shadow_color = imagecolorallocate($captcha, $shadow_color['r'], $shadow_color['g'], $shadow_color['b']);
			imagettftext($captcha, $font_size, $angle, $text_pos_x + $captcha_config['shadow_offset_x'], $text_pos_y + $captcha_config['shadow_offset_y'], $shadow_color, $font, $captcha_config['code']);	
		}
		
		// Draw text
		imagettftext($captcha, $font_size, $angle, $text_pos_x, $text_pos_y, $color, $font, $captcha_config['code']);	
		
		// Output image
		header("Content-type: image/png");
		imagepng($captcha);
		
	 }

	}
	
	
}

