<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * GlobeWebService Library
 * @author   Stephen Ralph Moraga
 */

class GlobeWebService
{
    
    /* Protected Variables */
    protected $_sms = "http://10.225.10.4:8411/sms";
    protected $_email = "http://10.225.10.4:8211/email";

    /*
     * Api Send Sms
     * @string $mobile_number required
     * @string $message required
     * @int $source_address optional
     * @return status response
     */
    public function api_send_sms($mobile_number, $message, $source_address = "Esate")
    {
        $pattern = "/^0/";
        $replacement = "63";
        $msisdn = preg_replace($pattern, $replacement, $mobile_number);
        $sms_status = $this->_SendSms($message, $source_address, $msisdn);
        if($sms_status['AppResponseCode'] == 200){
            return TRUE;
        } else {
           return FALSE;
        }
    }
    
    /*
     * Send Sms
     * @string $SmsMsgTxt required
     * @string $SmsSourceAddr required
     * @int $DestMobileNumber required
     * @int $TransactionId optional
     * @return array response
     */
    private function _SendSms($SmsMsgTxt = NULL, $SmsSourceAddr = NULL, $DestMobileNumber = NULL, $TransactionId = NULL)
    {
	if(empty($SmsMsgTxt) || empty($SmsSourceAddr) || empty($DestMobileNumber)) {
            return "Invalid Parameters: Please check your parameters";
        }

        $xml = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:sms="http://www.globe.com/warcraft/wsdl/sms/">';
		$xml .= '<soap:Header/>';
		$xml .= '<soap:Body>';
		$xml .= '<sms:SendSms>';
		if(!empty($TransactionId)) $xml .= '<TransactionId>'.$TransactionId.'</TransactionId>';
		$xml .= '<SmsMsgTxt>'.$SmsMsgTxt.'</SmsMsgTxt>';
		$xml .= '<SmsSourceAddr>'.$SmsSourceAddr.'</SmsSourceAddr>';
		$xml .= '<DestMobileNumber>'.$DestMobileNumber.'</DestMobileNumber>';	 
		$xml .= '</sms:SendSms>';
		$xml .= '</soap:Body>';
        $xml .= '</soap:Envelope>';
        $xml_post_string = $xml;
        $headers = $this->_soap_headers($xml_post_string);       

        $xml_response = $this->_connect($this->_sms, $xml_post_string, $headers);
		$result =  str_replace(array('<soap:Header>', '</soap:Header>', '<soap:Body>', '</soap:Body>'),"", $xml_response);
        $result_array = $this->_xml2array($result);

		if(isset($result_array['soap:Envelope']['soap:Header']['soap:Body']['soap:Fault'])) {
			return "Error: Please check your parameters";
		} else {
			return $result_array['soap:Envelope']['sms:SendSmsResponse']['SendSmsResult'];
		}
    }
    
    /*
     * Send Email
     * @string $To required
     * @string $Subject required
     * @string $Content required
     * @string $ReplyToAddress optional
     * @string $Cc optional
     * @string $Bcc optional
     * @return array response
     */
    public function SendEmail($To = NULL, $Subject = NULL, $Content = NULL, $ReplyToAddress = NULL, $Cc = NULL, $Bcc = NULL)
    {
        if(empty($To) || empty($Subject) || empty($Content)) {
            return "Invalid Parameters: Please check your parameters";
        }
        
        $xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ema="http://www.globe.com/warcraft/wsdl/email/">';
        $xml .= '<soapenv:Header/>';
        $xml .= '<soapenv:Body>';
        $xml .= '<ema:SendEmail>';
        $xml .= '<To>'.$To.'</To>';
        if(!empty($ReplyToAddress)) $xml .= '<ReplyToAddress></ReplyToAddress>';
        if(!empty($Cc)) $xml .= '<Cc></Cc>';
        if(!empty($Bcc)) $xml .= '<Bcc></Bcc>';
        $xml .= '<Subject>'.$Subject.'</Subject>';
        $xml .= '<Content>'.$Content.'</Content>';
        $xml .= '</ema:SendEmail>';
        $xml .= '</soapenv:Body>';
        $xml .= '</soapenv:Envelope>';
        
        $xml_post_string = $xml;
        $headers = $this->_soap_headers($xml_post_string);
         
        $xml_response = $this->_connect($this->_email, $xml_post_string, $headers);
        $result =  str_replace(array('<soap:Header>', '</soap:Header>', '<soap:Body>', '</soap:Body>'),"", $xml_response);
        $result_array = $this->_xml2array($result);

	 if(isset($result_array['soapenv:Envelope']['soapenv:Body']['soapenv:Fault'])) {
		return "Error: Please check your parameters";
	 } else {
		return $result_array['soapenv:Envelope']['soapenv:Body']['ema:sendEmailResponse']['SendEmailResult'];	 
	 }
    }

    /*
     * Get Subscriber By Msisdn
     * @string $MSISDN required
     * @return array response
     */
    public function GetSubscriberByMsisdn($MSISDN = NULL)
    {
        if(empty($MSISDN)) return "Invalid Parameters: Please check your parameters";
	
        $MSISDN= ltrim ($MSISDN,'0');
        
        $xml = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:bil="http://www.globe.com/warcraft/wsdl/billing/">';
        $xml .= '<soap:Header/>';
        $xml .= '<soap:Body>';
        $xml .= '<bil:GetSubscriberByMsisdn>';
        $xml .= '<MSISDN>'.$MSISDN.'</MSISDN>';
        $xml .= '</bil:GetSubscriberByMsisdn>';
        $xml .= '</soap:Body>';
        $xml .= '</soap:Envelope>';
        
        $xml_post_string = $xml;
        $headers = $this->_soap_headers($xml_post_string);
         
        $xml_response = $this->_connect($this->_billing, $xml_post_string, $headers);
        $result =  str_replace(array('<soap:Header>', '</soap:Header>', '<soap:Body>', '</soap:Body>'),"", $xml_response);
        $result_array = $this->_xml2array($result);

	 if(isset($result_array['soap:Envelope']['soap:Body']['soap:Fault'])) {
		return "Error: Please check your parameters";
	 } else {
		return $result_array['soap:Envelope']['ns2:GetSubscriberByMsisdnResponse']['GetSubscriberByMsisdnResult'];	 
	 }
    }

    
    private function _connect($endpoint = NULL, $xml_post_string = NULL, $headers = NULL)
    {
        if($endpoint == NULL || $xml_post_string == NULL || $headers == NULL) return FALSE;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);

        $response = curl_exec($ch); 
        $cErr = curl_error($ch);
        
        if($cErr) {
            echo $cErr;
            die();
        } else {
            return $response;
        }
        curl_close($ch);
    }

    private function _soap_headers($xml_post_string)
    {
        $headers = array(
                     "Content-type: application/soap+xml;",
                     "Accept: text/xml",
                     "Cache-Control: no-cache",
                     "Pragma: no-cache",
                     "SOAPAction: GetWfSession", 
                     "Content-length: ".strlen($xml_post_string),
        );
        return $headers;
    }

    private function _xml2array($contents, $get_attributes=1, $priority = 'tag') {
        if(!$contents) return array();

        if(!function_exists('xml_parser_create')) {
            return array();
        }

        $parser = xml_parser_create('');
        xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8");
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
        xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
        xml_parse_into_struct($parser, trim($contents), $xml_values);
        xml_parser_free($parser);

        if(!$xml_values) return;

        $xml_array = array();
        $parents = array();
        $opened_tags = array();
        $arr = array();

        $current = &$xml_array;

        $repeated_tag_index = array();
        foreach($xml_values as $data) {
            unset($attributes,$value);

            extract($data);

            $result = array();
            $attributes_data = array();

            if(isset($value)) {
                if($priority == 'tag') $result = $value;
                else $result['value'] = $value;
            }

            if(isset($attributes) and $get_attributes) {
                foreach($attributes as $attr => $val) {
                    if($priority == 'tag') $attributes_data[$attr] = $val;
                    else $result['attr'][$attr] = $val;
                }
            }

            if($type == "open") {
                $parent[$level-1] = &$current;
                if(!is_array($current) or (!in_array($tag, array_keys($current)))) { 
                    $current[$tag] = $result;
                    if($attributes_data) $current[$tag. '_attr'] = $attributes_data;
                    $repeated_tag_index[$tag.'_'.$level] = 1;

                    $current = &$current[$tag];

                } else { 

                    if(isset($current[$tag][0])) {
                        $current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;
                        $repeated_tag_index[$tag.'_'.$level]++;
                    } else {
                        $current[$tag] = array($current[$tag],$result);
                        $repeated_tag_index[$tag.'_'.$level] = 2;

                        if(isset($current[$tag.'_attr'])) { 
                            $current[$tag]['0_attr'] = $current[$tag.'_attr'];
                            unset($current[$tag.'_attr']);
                        }

                    }
                    $last_item_index = $repeated_tag_index[$tag.'_'.$level]-1;
                    $current = &$current[$tag][$last_item_index];
                }

            } elseif($type == "complete") { 
                if(!isset($current[$tag])) { 
                    $current[$tag] = $result;
                    $repeated_tag_index[$tag.'_'.$level] = 1;
                    if($priority == 'tag' and $attributes_data) $current[$tag. '_attr'] = $attributes_data;

                } else { 
                    if(isset($current[$tag][0]) and is_array($current[$tag])) {

                        $current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;

                        if($priority == 'tag' and $get_attributes and $attributes_data) {
                            $current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
                        }
                        $repeated_tag_index[$tag.'_'.$level]++;

                    } else { 
                        $current[$tag] = array($current[$tag],$result); 
                        $repeated_tag_index[$tag.'_'.$level] = 1;
                        if($priority == 'tag' and $get_attributes) {
                            if(isset($current[$tag.'_attr'])) {

                                $current[$tag]['0_attr'] = $current[$tag.'_attr'];
                                unset($current[$tag.'_attr']);
                            }

                            if($attributes_data) {
                                $current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
                            }
                        }
                        $repeated_tag_index[$tag.'_'.$level]++; 
                    }
                }

            } elseif($type == 'close') { 
                $current = &$parent[$level-1];
            }
        }
        return($xml_array);
    }
}
?>