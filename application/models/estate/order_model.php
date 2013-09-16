<?php
class Order_model extends CI_Model
{
    var $tbl_name = 'estate_orders';

    function __construct()
    {
            parent::__construct();
    }

	// cart to order - mark
    function save_order($data=array())
    {
		
		$cartItems = $data['items'];
		
		// not needed anymore
		unset($data['items']);
		
		if( count($data)>0 ){
			
			$this->db->insert('estate_orders', $data);
			$id = $this->db->insert_id();
			
			//create a unique order number
			//unix time stamp + unique id of the order just submitted.
			$order	= array('order_number'=> date('U').$id);
			
			$this->db->where('id', $id);
			$this->db->update('estate_orders', $order);
						
			//return the order id 
			$order_number = $order['order_number'];	
			
			//save order items
			if($cartItems && $id)
			{
				// clear existing order items
				$this->db->where('order_id', $id)->delete('estate_order_items');
				
				// update order items
				foreach($cartItems as $rowid => $item)
				{
					// not needed anymore
					unset($item['rowid']);
					
					$save				= array();
					
					$save['cid']     	    = '0';
					$save['order_id']	    = (int) $id;
					$save['product_id']     = (int) $item['product_id'];
					$save['quantity'] 	    = (int) $item['qty'];
					$save['product_type'] 	= $item['product_type'];
					$save['product_info']	= serialize($item); //save each cart info

					$this->db->insert('estate_order_items', $save);
				}
				
			}
			
			return $order_number;
		
		}else{
		
			return FALSE;
		}
		
		
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
