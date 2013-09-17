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

        // add computation of subtotal per item less discount
        // remove join with estate product since details of item should already be on estate_order_items
        $query = $this->db->select($what)
                          ->from($this->tbl_name)
                          // ->join('estate_product', 'estate_order_items.product_id = estate_product.product_id')
                          ->where('order_id', $order_id)
                          ->get();

        $result = $query->result();
        if(count($result) == 0) return FALSE;
        return $result;
    }

    function get_orderitem_by_type($refnum, $type){

        if($refnum == NULL) return FALSE;

        // add computation of subtotal per item less discount
        // remove join with estate product since details of item should already be on estate_order_items
        $query = $this->db->select($what)
                          ->from($this->tbl_name)
                          // ->join('estate_product', 'estate_order_items.product_id = estate_product.product_id')
                          ->where('product_type', $type)
                          ->where('order_id', $refnum)
                          ->get();

        $result = $query->row_array();

        if(count($result) == 0) return FALSE;
        return $result;
    }
/*    function get_subtotal_by_orderitem_id($order_item_id)
    {
         $query = $this->db->select($what)
                          ->from($this->tbl_name)
                          ->where('id', $order_item_id) // should be order_item_id in the future
                          ->join('estate_product', 'estate_order_items.product_id = estate_product.product_id')
                          ->get();

        $result = $query->row_array();

        // discount percentage 10.5
        $discount = $result['percent_discount'] ? ( (100 - $result['percent_discount']) / 100 ) : 1;

        // compute and return for subtotal
        return ( ( $result['product_amount'] * $result['quantity'] ) * $discount );
    }*/
}
