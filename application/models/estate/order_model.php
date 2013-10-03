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

			if($data['order_type'] == 4){
				//$this->session->userdata('user_type')
				$this->session->set_userdata('order_id', $id);
			}
						
			//return the order id 
			$order_number = $order['order_number'];	

			$order_config = $this->session->userdata('order_config');
			$order_config['order_number'] = $order_number;
			$this->session->set_userdata('order_config', $order_config);
			
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

    function get_recent_order_by_email($email)
    {
    	// get account id by email
    	$q = $this->db->select('estate_orders.*')
				->from($this->tbl_name)
				->join('estate_accounts', 'estate_orders.account_id = estate_accounts.account_id')
				->where('estate_accounts.email', $email)
				->order_by("estate_orders.order_number", "desc")
				->get();
		$result = $q->row_array();

		if(count($result) == 0) return FALSE;
        return $result;
    	// get recent order by account id
    }

    //Lawrence 10-02-2013
    function save_application($data=array(),$item)
    {
        $this->db->insert('estate_orders', $data);
        $id = $this->db->insert_id();
        $order	= array('order_number'=> date('U').$id);

        $this->db->where('id', $id);
        $this->db->update('estate_orders', $order);       
        

        $save['cid']     	    = '0';
        $save['order_id']	    = (int) $id;
        $save['product_id']     = (int) $item['product_id'];
        $save['quantity'] 	    = (int) $item['qty'];
        $save['product_type'] 	= $item['product_type'];

        $this->db->insert('estate_order_items', $save);
        
        
        return $order[order_number];
    }
    //=================================
}
