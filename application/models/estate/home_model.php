<?php
/**
 * Model for Gadgets Sku configration
 * @author Robert Hughes
 * 9/26/2013
 */
class Home_model extends CI_Model {
    var $tbl_name = 'estate_orders';

    function __construct() {
            parent::__construct();
    }
    function getDeviceIds($url) {
    	$query = $this->db->select('id')
    					->from('estate_gadgets')
    					->where('url', $url)
    					->where('is_active', '1')
    					->get();
    	 
    	$result = $query->result_array();
    	if(count($result) == 0) return FALSE;
    	return $result;
    }
    function getDevices($url) {
    	$query = $this->db->select('*')
			    	->from('estate_gadgets')
			    	->where('url', $url)
			    	->where('is_active', '1')
			    	->get();
    	
    	$result = $query->result_array();
    	$result['count'] = count($result); 
    	if(count($result) == 0) return FALSE;
    	return $result;
    }
    
    function getAvailableColors($deviceID) {
    	$query = $this->db->query("SELECT egac.id clid, egac.name clname, egac.image climg, ega.image gadgetimg
    			FROM estate_gadget_attributes ega
    			INNER JOIN estate_gadget_attr_colors egac
    			ON ega.colorid = egac.id
    			WHERE ega.gadget_id='{$deviceID}'
    			AND ega.is_active=1
    			GROUP BY clid
    			ORDER BY clname");
    
		$result = $query->result_array();
    
    	$result['count'] = count($result);
    	if(count($result) == 0) return FALSE;
    	return $result;
    }
    
    function getCapacity($deviceID, $colorID) {
    	$query = $this->db->query("SELECT egadc.id dcid, egadc.name dcname, egadc.image dcimg
    			FROM estate_gadget_attributes ega
    			INNER JOIN estate_gadget_attr_data_capacity egadc
    			ON ega.data_capacity_id = egadc.id
    			WHERE ega.gadget_id='{$deviceID}'
    			AND ega.colorid='{$colorID}'
    			AND ega.is_active=1
    			ORDER BY dcname");
    			 
    	$result = $query->result_array();
    	
    	$result['count'] = count($result);
    	if(count($result) == 0) return FALSE;
    	return $result;
    }
    function getGadgetAmount($deviceID, $colorID, $capacityID, $netConnectivityID=1) {
    	$query = $this->db->query("SELECT amount
    			FROM estate_gadget_attributes 
    			WHERE gadget_id='{$deviceID}'
    			AND colorid='{$colorID}'
    			AND data_capacity_id='{$capacityID}'
    			AND net_connectivity_id='{$netConnectivityID}'
    			AND is_active=1
    			ORDER BY date_created
    			LIMIT 1");
    	
    	$row = $query->row();

		return $row->amount;
    }
}

