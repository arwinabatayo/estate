<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cart extends CI_Controller {
    
    function __construct() 
    {
        parent::__construct();
        //global data
		$this->_data->tpl_view    = $this->config->item('globe_estate_template_path');
		$this->_data->assets_path = $assets_path = $this->config->item('globe_estate_assets');
		$this->_data->assets_url  = base_url().$assets_path;
		$this->_data->current_method      = $this->router->method;
		$this->_data->current_controller  = strtolower( $this->router->class );
		$this->_data->show_breadcrumbs    =  true;
		$this->_data->current_step        =  3;
		$this->_data->page_title          =  'Add-ons';

    }

    public function index()
    {
      //  $this->load->view('cart/index');
    }
    
    public function get_cart()
    {
        $cart_contents = $this->cart->contents();
        
        print_r($cart_contents);
        
        //echo json_encode($cart_contents);
    }
    
    public function update_cart()
    {
        $account_id = "1212";
        $key = "96e59dd45c5cff38ba94e169202ccd41";
        
        /* cart */
        $_data = array(
            'rowid' => $key,
            'qty'   => 1
        );
        $data['status'] = $this->cart->update($_data); 
         
        /* db */
        $cart_contents = $this->cart->contents();
        foreach($cart_contents as $k=>$v){
           if($k == $key) {
               foreach($_data as $kk=>$vv) {
                 $cart_contents[$k][$kk] = $vv;
               }                
           }
        }
        $info = $this->_parse_contents();
        $this->cart_model->update_cart_info($account_id, $info);        
        echo json_encode($data);
    }
    
    public function delete_cart()
    {
        $account_id = "1212";
        $key = "5eacd98e0995bcb12ed069a936f16eec";
       
        /* cart */
        $item_exist = FALSE;
        $cart_contents = $this->cart->contents();
        
        if(!empty($cart_contents)) {
            foreach($cart_contents as $k=>$v) {
            if($k == $key)
                $item_exist = TRUE;
                unset($cart_contents[$key]);
            }
        }
        $this->cart->destroy();
        $data['status'] = $this->cart->insert($cart_contents);
        
        /* db */
        if(count($cart_contents) == 0 && $item_exist == TRUE) {
            $this->cart_model->delete_cart($account_id, TRUE);
        } else {
            $info = $this->_parse_contents();
            $this->cart_model->insert_previous_info($account_id, $info);
        }
       echo json_encode($data);
    }
    
    public function destroy()
    {
        $account_id = 1;
        
        $this->cart->destroy();
        $this->cart_model->delete_cart($account_id, TRUE);
        echo json_encode(array('status'=>'true'));
    }
    
    private function _parse_contents() 
    {
        $cart_contents = $this->cart->contents();
        $info = '';
        foreach($cart_contents as $kkk=>$vvv) {
           unset($vvv['subtotal']);
           unset($vvv['rowid']);
           $info[] = $vvv;
        }
        return $info;
    }
    
    public function view_cart_summary()
    {
        $this->_data->cart_contents = $this->cart->contents();
        
        $this->_data->page = 'summary';
        
        $this->load->view($this->_data->tpl_view, $this->_data);
        
    }
    
    function test(){
		
		//$d=array('alpha'=>'','beta'=>'2','charlie'=>'8');
		
	//	$o = $this->set_order_config($d);
		//$o = $this->get_order_config();
		//print_r($o);
		//$v = $this->cart->has_options('dfd10bb28b3de6ed50c48294da85c8b2');
		$v = $this->cart_model->remove_gadget();
		echo var_dump($v);
		
	}
	
	
    function addtocart(){
		
		$this->load->model('estate/products_model');
		
		$d = (object) $this->input->post();
		$account_id = 1; //TODO get subs id
		$options = array();
		$title  = '';
		$amount = 0;
			 
		$out = array(
			'status' => 'failed',
			'msg'    => 'Some error occured or the system is busy. Please try again later'
		);
		
		if( $d->product_id ){
			
			 $_fields = $this->products_model->get_product_fields($d->product_type,$d->product_id);
			 
			 $title  = $_fields['title'];
			 $amount = $_fields['amount'];
			 
			 if( $d->product_type == 'gadget' ){
				 
				//TODO: 
				$title = 'iPhone 5';
				$amount = 12500;
				$options=array(
					'capacity' => $d->gadget_capacity,
					'color'    => $d->gadget_color
				);
				 
				// remove existing gadget
				$this->cart_model->remove_gadget();
			 }
			 
			 

				
			$cart_input = array(
				'id'              => $d->product_type.'_'.$d->product_id,
				'qty'             => 1,
				'price'           => $amount,
				'price_formatted' => 'Php '.number_format($amount,2),
				'name'            => $title,
				'product_id'      => $d->product_id,
				'discount'        => $d->product_discount,
				'product_type'    => $d->product_type,
				'options'         => $options,
			);
	        
	        //TODO:
	        //peso value, ultima rules              
			 
			 //   return boolean
			//    $this->_call_your_ultima_logic();
		    //  
			 
			 
	       /* cart */
	       $out['status'] = 'success';
	       $out['rowid']  = $rowid = $this->cart->insert($cart_input);
	       $out['total']  = $this->cart_model->total(true);
	       
	       $out = array_merge($cart_input,$out);

	       /* db */       
	       if($rowid){
				$this->_data->cartItem  = $info = $this->_parse_contents();
				$this->cart_model->insert_previous_info($account_id, $info); 
		    }else{
				$out['status'] = 'failed';
				
			}
			
		}
		
		//print_r($info);

		echo json_encode($out);

	}
	
    public function delete()
    {
    
		$d = (object) $this->input->post();
		$account_id = 1; //TODO get subs id
		
		$key = $d->keyid;
		
		$out = array(
			'status' => 'success'
		);
				
        /* cart */
        $item_exist = FALSE;
        $is_gadget = FALSE; // if this is a gadget then destroy all items!
        $cart_contents = $this->cart->contents();
        
        if($key){
			
	        if(!empty($cart_contents)) {
	           
	            foreach($cart_contents as $k=>$v) {
					if($k == $key)
						$item_exist = TRUE;
						unset($cart_contents[$key]);
	            }
	            
	            if( $v['product_type'] == 'gadget' ){
					$is_gadget = TRUE;
				}
	        }
	        
	        $this->cart->destroy();
			
			if(!$is_gadget){ //flashout all data if you delete the gadget
				$this->cart->insert($cart_contents);
			}
			
	        /* db */
	        if(count($cart_contents) == 0 && $item_exist == TRUE) {
	            
	            if( !$this->cart_model->delete_cart($account_id, TRUE) ){
					$out = array(
						'status' => 'failed',
						'msg'    => 'Some error occured or the system is busy. Please try again later'
					);
				}
	            
	        } else {
	            $info = $this->_parse_contents();
	            $this->cart_model->insert_previous_info($account_id, $info);
	        }
			
			$out['total']  = $this->cart_model->total(true);
		
		}
        
		echo json_encode($out);
		
    }
	
	//@return array config
	function set_order_config(){
		$d = (object) $this->input->post();
		if($d->key)	
			return $this->cart_model->set_order_config( array($d->key=>$d->val));
	}
	
	function getOrderConfig(){
			return $this->cart_model->get_order_config();
	}
    
    function test(){
	
	}
		function robert_test() {
		
		}
}
