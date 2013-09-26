<?php
class Model_pickup extends CI_Model
{
    function get_stores($store_id = NULL, $order_by, $order, $limit, $limit_by = 'all', $filter_arr = array(), $status = NULL)
    {
        $additional_query = "";
        if ($filter_arr) {
            if( isset($filter_arr['letter']) && $filter_arr['letter'] != '' ){
                    $additional_query .= " WHERE estate_store.name LIKE '" . $filter_arr['letter'] . "%'";
            }
        }
        if ($order_by && $order)	{ $additional_query .= " ORDER BY $order_by $order"; }
        if ($limit_by != 'all') 	{ $additional_query .= " LIMIT $limit, $limit_by"; }

        $where = "";
        if(!empty($store_id)){ $where = " WHERE id = " . $store_id;}
        if($status != NULL) { $where =" WHERE status = 1"; }

        $query = $this->db->query("SELECT * FROM estate_store" . $where. $additional_query);
        $result = $query->result_array();
        $query = $this->db->query("SELECT FOUND_ROWS() AS 'count'");
        $result["total_count"] = $query->row()->count;

        if(count($result) == 0) return array();
        return $result;
    }
        
    function get_store_properties($store_id = NULL, $order_by, $order, $limit, $limit_by = 'all', $status = NULL, $filter_latest = FALSE)
    {
        $additional_query = "";

        if($status != NULL) { $additional_query .=" AND status = ".$status; }
        if($filter_latest === TRUE) { $additional_query .=" AND date_of_operation >= '".date("Y-m-d", time())."'"; }
        if ($order_by && $order)	{ $additional_query .= " ORDER BY $order_by $order"; }
        if ($limit_by != 'all') 	{ $additional_query .= " LIMIT $limit, $limit_by"; }
        
        $where = "";
        if(!empty($store_id)){ $where = " WHERE store_id = " . $store_id; }
        $sql = " SELECT	* FROM estate_gadget_store".$where;
        $query = $this->db->query($sql.$additional_query);
        $result = $query->result_array();
        $query = $this->db->query($sql);
        $result["total_count"] = $query->num_rows();
        if(count($result) == 0) return array();
        return $result;
    }
        
    function add_store($data)
    {
        $this->db->insert('estate_store', $data);
        return;
    }
        
    function add_store_properties($data)
    {
        $this->db->insert('estate_gadget_store', $data);
        return;
    }

    function delete_store($store_id){
        $store_details = $this->get_store_details($store_id);
        $this->db->where('id', $store_id);
        $this->db->delete('estate_store'); 
        return $store_details;
    }
        
    function delete_store_property($store_id, $property_id){
        $property_details = $this->get_property_details($store_id);
        $this->db->where('id', $property_id);
        $this->db->delete('estate_gadget_store'); 
        return $property_details;
    }
        
    function get_property_details($store_id = NULL, $property_id = NULL)
    {
        if(empty($store_id)) return FALSE;
        $additional_query = "";
        if(!empty($property_id)) { $additional_query = ' and estate_gadget_store.id = '.$property_id; }
        $query = $this->db->query(" SELECT * FROM estate_gadget_store WHERE estate_gadget_store.store_id = " . $store_id.$additional_query);
        $result = $query->row_array();
        if(count($result) == 0) return array();
        return $result;
    }

    function get_store_details($store_id = NULL)
    {
        if(empty($store_id)) return FALSE;
        $query = $this->db->query("SELECT * FROM estate_store WHERE estate_store.id = " . $store_id);
        $result = $query->row_array();
        if(count($result) == 0) return array();
        return $result;
    }

    function update_store($store_id, $data)
    {
        $this->db->where('id', $store_id);
        $this->db->update('estate_store', $data); 
    }

    function update_property($property_id, $data)
    {
        $this->db->where('id', $property_id);
        $this->db->update('estate_gadget_store', $data); 
        echo $this->db->last_query();
    }
    
    function search_store($store_name = NULL, $search_by = 'name', $like = FALSE)
    {
        if($like === TRUE ) {
            $this->db->like($search_by, $store_name); 
        } else {
            $this->db->where($search_by, $store_name);
        }
        $query = $this->db->get('estate_store');
        $result = $query->result_array();
        if(count($result) == 0) return array();
        return $result;
    }
    
    function list_stores_nearby($array_values)
    {
        $this->db->where($array_values);
        $this->db->where('status', '1');
        $query = $this->db->get('estate_store');
        $result = $query->result_array();
        if(count($result) == 0) return array();
        return $result;
    }
}
