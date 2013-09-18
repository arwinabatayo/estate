<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*					error_reporting(1);
					ini_set('display_errors',1);*/

include('phpqrcode/qrlib.php');

class Phpqrcode
{
	public function getQrcodePng($str, $_filename)
	{

		//html PNG location prefix
		$PNG_WEB_DIR = '/temp/';

		//set it to writable location, a place for temp generated PNG files
		$PNG_TEMP_DIR = SITE_BASEPATH . DIRECTORY_SEPARATOR . '_assets/estate/qrcode' . $PNG_WEB_DIR;

		$filename = $PNG_TEMP_DIR . $_filename;

		if (!file_exists($PNG_TEMP_DIR)) {
			mkdir($PNG_TEMP_DIR);
		}

		QRcode::png($str, $filename, 'M', 10);

		return base_url() . '_assets/estate/qrcode' . $PNG_WEB_DIR . $_filename; // _assets/estate/qrcode
	}
}