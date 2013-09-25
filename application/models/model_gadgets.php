<?php
/**
 * 9.18.2013
* Ultima Logic
* robert hughes
*/

class Model_gadgets extends CI_Model
{
	
	function getGadgets($property_id=null, $user_type, $order_by, $order, $limit, $limit_by = 50, $filter_arr = array()) 
	{
		
		$additional_query = "";
		if ($filter_arr) {
			if( isset($filter_arr['letter']) && $filter_arr['letter'] != '' ){
				$additional_query .= " WHERE estate_gadgets.name LIKE '" . $filter_arr['letter'] . "%'";
			}
			if( isset($filter_arr['gadget_id']) && $filter_arr['gadget_id'] != '' ) {
				if(!empty($additional_query)) {
					$additional_query .= " AND estate_gadgets.gadget_id=".$filter_arr['gadget_id'];
				} else {
					$additional_query .= " WHERE estate_gadgets.gadget_id=".$filter_arr['gadget_id'];
				}
			}
		}
		if ($order_by && $order)	{ $additional_query .= " ORDER BY $order_by $order"; }
		if ($limit_by != 'all') 	{ $additional_query .= " LIMIT $limit, $limit_by"; }
	
		$query = $this->db->query("	SELECT 	SQL_CALC_FOUND_ROWS *
									FROM estate_gadgets " . $additional_query);
		$data = $query->result_array();
		$query = $this->db->query("	SELECT FOUND_ROWS() AS 'count'");
		$data["total_count"] = $query->row()->count;
		
		return $data;
	}
	
	function getGadgetDetails($gadget_id) {
		
		$this->db->where('id', $gadget_id);
		$query = $this->db->get('estate_gadgets');
	
		if( $query->num_rows() > 0){
			$tmp = $query->row_array();
			$dtls = array();
			
			$dtls['id']		= $tmp['id'];
			$dtls['name'] 	= $tmp['name'];
			$dtls['status'] = $tmp['is_active'];
			
			$this->db->where('gadget_id', $gadget_id);
			$queryAttrs = $this->db->get('estate_gadget_attributes');
			
			$data = $queryAttrs->result_array();
		
			foreach($data as $k => $array) {
				foreach($array as $key => $string) {
					if($key == "colorid") {
						$aColor = $this->getColors($string);
						$data[$k]['colorattr'] = $aColor[0]['name'];
					}
					if($key == "net_connectivity_id") {
						$aNetWo = $this->getNetConnectivity($string);
						$data[$k]['netwoattr'] = $aNetWo[0]['name'];
					}
					if($key == "data_capacity_id") {
						$aNetWo = $this->getDataCapacity($string);
						$data[$k]['datacapattr'] = $aNetWo[0]['name'];
					}
				}
			}
			
			$dtls['attrs'] = $data;
			return $dtls;
		}else{
			return array();
		}
	}
	
	function addGadget($data) {
		$this->db->insert("estate_gadgets", $data['estate_gadgets']);
		
		$lastInsetedId = $this->db->insert_id();
		
		unset($data['estate_gadgets']);
		
		foreach ($data as $dataTable => $rows) {
			foreach($rows as $dataFields) {
				$dataFields['date_created'] = date('Y-m-d H:i:s');
				$dataFields['gadget_id'] = $lastInsetedId;
				$this->db->insert($dataTable, $dataFields);
			}
		}
		
		return;
	}
	
	function updateBundle($data, $id)
	{
		
		$this->db->where('id', $id);
		$this->db->update('estate_gadgets', $data);
		
		
		return;
	}
	
	function deleteBundle($id){
		$combos_details = $this->getBundleDetails($id);
	
		$this->db->where('id', $id);
		$this->db->delete('estate_gadgets');
		return $combos_details;
	}
	
	/*** COLORS ***/
	function getColors($id) {
		$additional = '';
		if(!empty($id)) {
			$additional = " WHERE id={$id}";
		}
		$query = $this->db->query("SELECT SQL_CALC_FOUND_ROWS * FROM estate_gadget_attr_colors{$additional}");
		$data = $query->result_array();
		$query = $this->db->query("	SELECT FOUND_ROWS() AS 'count'");
		$data["total_count"] = $query->row()->count;
		return $data;
	}
	
	function addColors($data) {
		$this->db->insert('estate_gadget_attr_colors', $data);
		return;
	}
	
	/*** DATA CAPACITY ***/
	function getDataCapacity($id) {
		$additional = '';
		if(!empty($id)) {
			$additional = " WHERE id={$id}";
		}
		$query = $this->db->query("	SELECT SQL_CALC_FOUND_ROWS * FROM estate_gadget_attr_data_capacity{$additional}");
		$data = $query->result_array();
		$query = $this->db->query("	SELECT FOUND_ROWS() AS 'count'");
		$data["total_count"] = $query->row()->count;
		return $data;
	}
	
	function addDataCapacity($data) {
		$this->db->insert('estate_gadget_attr_data_capacity', $data);
		return;
	}
	
	/*** NETWORK CONNECTIVITY ***/
	function getNetConnectivity($id) {
		$additional = '';
		if(!empty($id)) {
			$additional = " WHERE id={$id}";
		}
		$query = $this->db->query("	SELECT SQL_CALC_FOUND_ROWS * FROM estate_gadget_attr_net_connectivity{$additional}");
		$data = $query->result_array();
		$query = $this->db->query("	SELECT FOUND_ROWS() AS 'count'");
		$data["total_count"] = $query->row()->count;
		return $data;
	}
	
	function addNetConnectivity($data) {
		$this->db->insert('estate_gadget_attr_net_connectivity', $data);
		return;
	}
}
?>