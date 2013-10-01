<?php
/**
 * Survey Page
 * @author Robert Hughes 10.1.13
 *
 */
class Survey_model extends CI_Model {
    function __construct() {
            parent::__construct();
    }

    function get_all_survey($is_active='1') {
    	$this->db->where('is_active', $is_active);
    	$this->db->order_by('order_by', 'ASC');
    	$query = $this->db->get('estate_survey');
    	
    	if( $query->num_rows() > 0 ){
    		$tmp = $query->result_array();
    		
    		$aRet = array();
    		foreach( $tmp as $key => $values ) {
    			$aRet[$key]['id'] = $values['id'];
    			$aRet[$key]['name'] = $values['name'];
    			$aRet[$key]['description'] = $values['description'];
    			$aRet[$key]['txt_name'] = $values['txt_name'];
    		}
    		return $aRet;
    	}else{
    		return array();
    	}
    }
    
    function save_survey($data) {
    	if( $this->db->insert('estate_account_offers', $data) ){
    		return TRUE;
    	} else {
    		return $this->db->_error_message();
    	}
    }
   
}