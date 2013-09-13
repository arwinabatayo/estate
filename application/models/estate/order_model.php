<?php
class Order_model extends CI_Model
{
    var $tbl_name = 'estate_orders';

    function __construct()
    {
            parent::__construct();
    }


    function save_order()
    {

    }

    function save_order_item()
    {

    }

    /**
     * get order by reference number / order number
     *
     * @param  string  order_id
     * @param  string  what (optional) - specify the fields needed
     * @return array
     */
    function get_order_by_refnum($refnum, $what='*')
    {
        if($refnum == NULL) return FALSE;

        $query = $this->db->select($what)
                          ->from($this->tbl_name)
                          ->where('order_number', $refnum)
                          ->get();
        $result = $query->row_array();
        $query->free_result();

        if(count($result) == 0) return FALSE;
        return $result;
    }

}
