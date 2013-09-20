<?php
class Networks_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get Network Number Prefixes Information.
	 *
	 * @param  string  network (required)  - Ex ( Globe, Smart )
	 * @param  string  what (optional) - specify the fields needed
	 * @return array
	 */
	function check_number_prefix($network = NULL, $what = '*')
	{
            if($network == NULL) return FALSE;
            // echo $network; exit;
            $query = $this->db->select($what)
                               ->from('estate_network_number_prefixes')
                               ->where('f_network', $network)
                               ->get();
            $result = $query->result_array();
            // var_dump($result);
            if(count($result) == 0) return FALSE;
            return $result;
	}

	function insert_sms_verification($msisdn, $code)
	{
		$exist = $this->get_sms_verification($msisdn);
		if(!empty($exist)) {
			$this->delete_sms_verification($msisdn);
		}

		$this->db->set('msisdn', $msisdn);
		$this->db->set('code', $code);
		$this->db->insert('estate_sms_verification');
   }

   function get_sms_verification($msisdn)
   {
		$query = $this->db->select('*')
						   ->from('estate_sms_verification')
						   ->where('msisdn', $msisdn)
						   ->get();
		$result = $query->row_array();
		if(count($result) == 0) return FALSE;
		return $result;
   }

   function delete_sms_verification($msisdn)
   {
	   $this->db->where('msisdn', $msisdn);
	   $this->db->delete('estate_sms_verification'); 
   }
}