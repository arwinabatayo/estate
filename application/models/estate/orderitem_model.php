<?php
class Orderitem_model extends CI_Model
{
    var $tbl_name = 'estate_order_items';

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
    function get_orderitems_by_orderid($order_id, $what='*')
    {   
        if($order_id == NULL) return FALSE;

        $query = $this->db->select($what)
                          ->from($this->tbl_name)
                          ->join('t_product', 'estate_order_items.product_id = t_product.f_product_id')
                          ->where('order_id', $order_id)
                          ->get();

        $result = $query->result();


        if(count($result) == 0) return FALSE;
        return $result;
    }
}
