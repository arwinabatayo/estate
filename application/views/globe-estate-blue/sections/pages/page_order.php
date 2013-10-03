    <ul class="c-s-bread-crumb">
        <li><p><span>Status</span><br /><?php echo $order['status']; ?></p></li>
        <li><p><span>Device</span><br /><?php echo $gadget_item['name']; ?></p></li>
        <li><p><span>Plan</span><br /><?php echo $plan_item['name']; ?></p></li>
        <li><p><span>Forms</span><br /><a href="javascript: void(0);" id="printable-forms">Print</a></p></li>
        <li><p><span>Delivery Tracker</span><br />Est. Delivery - <?php echo $delivery_info['est_delivery_date']; ?><br /><a href="javascript: void(0);" id="lnk-delivery-tracker">View Delivery Status</a></p></li>
    </ul>

      <div class="accordion row-fluid chooseplan clearfix" id="accordion2">  
     
        <?php   
            if($current_controller != 'home'){
                include(ESTATE_THEME_BASEPATH.'/sections/sidebar_panel.php');
            }
        ?>
        
        <div class="span9">
            <div class="accordion2 account-content" id="accordion3">
                <div class="accordion-group account-content-grp">
                  <div class="accordion-heading">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion3" href="#x">
                        <ul class="check-status-shop-cart-title">
                            <li>
                                <span class="span2">Product</span>
                                <span class="span3">Item</span>
                                <span class="span1">Qty.</span>
                                <span class="span2">Unit</span>
                                <span class="span2">Discount</span>
                                <span class="span2">Total</span>
                                
                                <div class="clr"></div>
                            </li>
                        </ul>
                    </a>
                  </div>
                  <div id="xx" class="accordion-body collapse" style="height: auto; ">
                    <div class="accordion-inner c-s-shopCart">
                        <div class="row-fluid">
                            <div class="check-status-shop-cart">
                                <ul>

                                    <?php
                                        // load model orderitem
                                        $this->load->model('estate/orderitem_model');
                                        $total = 0;
                                        // display all order items
                                        foreach ($order_items as $item) {
                                            // analyze product info
                                            $_item = unserialize($item->product_info);
                                            // var_dump($_item);
                                            $capacity = $_item['options']['capacity'] ? '/ ' . $_item['options']['capacity'] . ' GB' : '';
                                            $discount = $_item['discount'] ? $_item['discount'] : '&nbsp;&nbsp;';
                                    ?>
                                    <li>
                                        <div class="pad-space">
                                            <span class="span2"><div class="c-s-product-image"><img src="<?php echo $_item['product_image']; ?>" /></div></span>
                                            <span class="span3"><?php echo $_item['name']; ?> <?php echo $capacity; ?><br /> <a href="#" class="input-block-level"><?php echo ucwords($_item['product_type']); ?></a></span>
                                            <span class="span1"><?php echo $_item['qty'];?></span>
                                            <span class="span2"><?php echo number_format($_item['price'], 2); ?></span>
                                            <span class="span2"><?php echo $discount; ?></span>
                                            <span class="span2"><?php echo 'Php ' .  number_format($_item['subtotal'], 2); ?></span>
                                            
                                            <div class="clr"></div>
                                        </div>
                                    </li>
                                    <?php } ?>
                                </ul>
                                
                                <div class="input-block-level c-s-sub-total">
                                    <span class="span8">Sub-Total</span>
                                        <span class="span4"><?php echo number_format($order['subtotal'], 2);  ?></span>
                                </div>
                                
                                    <div class="clr"></div>
                                <div class="input-block-level c-s-shipping">
                                    <span class="span8">Shipping & Handling</span>
                                        <?php // add shipping total and handling fee from orders TODO : add handling_fee on orders
                                            $shipping_handling = $order['shipping_fee'] + $order['handling_fee'];
                                        ?>
                                        <span class="span4"><?php echo $shipping_handling; ?></span>
                                </div>
                                    
                                    <div class="clr"></div>
                                <div class="input-block-level c-s-total">
                                    <span class="span8">Total</span>
                                        <span class="span4"><?php echo  'Php ' . number_format($order['total'], 2); ?></span>
                                </div>
                                    <div class="clr"></div>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
            </div>
            <div class="row-fluid link-bottom">
                <ul class="pull-right">
                    <li><a>Contact Us</a></li>
                    <li>|</li>
                    <li><a>Live Chat</a></li>
                </ul>
            </div>                             
        </div>
    
    </div>


