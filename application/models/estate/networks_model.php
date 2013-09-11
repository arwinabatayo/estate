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
            $query = $this->db->select($what)
                               ->from('estate_network_number_prefixes')
                               ->where('f_network', $network)
                               ->get();
            $result = $query->result_array();
            if(count($result) == 0) return FALSE;
            return $result;
	}
}