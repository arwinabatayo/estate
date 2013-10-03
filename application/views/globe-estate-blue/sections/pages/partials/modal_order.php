<div id="status-pager" class="modal hide fade pop-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-body pop-content">
        <p class="pop-txtblue-large">PRINT</p>
        
        <hr/>
        
        <ul>
            <li>
                <img src="<?php echo $assets_path ?>site-blue/images/icons/icon_msa_form.png" width="150" height="152" alt=""/>
                <p>MSA FORM</p>
                <a href="#" onClick="downloadForm('msa');">Print</a>
            </li>
            <li>
                <img src="<?php echo $assets_path ?>site-blue/images/icons/icon_qr_code.png" width="149" height="152" alt=""/>
                <p>QR CODE</p>
                <a href="#" onClick="downloadForm('qr');">Print</a>
            </li>
            <li>
                <img src="<?php echo $assets_path ?>site-blue/images/icons/icon_receipt.png" width="150" height="152" alt=""/>
                <p>RECEIPT</p>
                <a href="#" onClick="downloadForm('receipt');">Print</a>
            </li>
        </ul>
        
        <div class="clr"></div>
    </div>
</div>

<div id="delivery-tracker" class="modal hide fade pop-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-body pop-content">
        <p class="pop-txtblue-large">On Schedule</p>
        
        <hr/>
        
        <p>Tracking Number: <?php echo $order['tracking_id']; ?></p>
        
        <div class="d-t-process-demo">
            <ul>
                <li class="col-lg-3">
                    <img src="<?php echo $assets_path ?>site-blue/images/icons/icon_circle_check.jpg" width="50" height="51" alt=""/>
                    <p>INITIATED</p>
                </li>
                <li class="col-lg-3">
                    <img src="<?php echo $assets_path ?>site-blue/images/icons/icon_arrow_with_check.jpg" width="109" height="51" alt=""/>
                    <p>PICK-UP</p>
                </li>
                <li class="col-lg-3">
                    <img src="<?php echo $assets_path ?>site-blue/images/icons/icon_number_3.jpg" width="116" height="51" alt=""/>
                    <p>IN - TRANSIT</p>
                </li>
                <li class="col-lg-3">
                    <img src="<?php echo $assets_path ?>site-blue/images/icons/icon_arrow_number4.jpg" width="111" height="51" alt=""/>
                    <p>DELIVERED</p>
                </li>
            </ul>
            
            <div class="clr"></div>
        </div>
        
        <p><strong>On Globe vehicle for Delivery</strong></p>
        <p><span><?php echo $delivery_info['delivery_dest']; ?></span></p>
        
        <hr/>
        
        <div class="pull-left">
            <p><strong>SHIPMENT DATES</strong></p>
            
            <ul>
                <li>
                    <label for="Ship Date:">Ship Date:</label>
                    <span><?php echo date("F j, Y", strtotime($delivery_info['shipment_date'])); ?></span>
                    
                    <div class="clr"></div>
                </li>
                <li>
                    <label for="Ship Date:">Estimated Delivery:</label>
                    <span><?php echo date("F j, Y", strtotime($delivery_info['est_delivery_date']));   ?></span>
                    
                    <div class="clr"></div>
                </li>
            </ul>
            
            <div class="clr"></div>
        </div>
        
        <div class="pull-right">
            <p>DESTINATION</p>
            
            <p><?php echo $delivery_info['shipment_dest']; ?></p>
        </div>
        
        <div class="clr"></div>
    </div>
</div>

<!--<div id="receipt-popup" class="modal hide fade pop-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-body pop-content">
        
        
        <div class="clr"></div>
    </div>
</div>-->

<div id="receipt-popup" class="modal fade pop-modal">
        <div class="modal-body pop-content">
            <button type="button" class="close pop-close" data-dismiss="modal" aria-hidden="true">×</button>   
            <div class="r-p-logo fl"><img src="images/icons/icon_globe.png" width="" height="" alt=""/></div>
            <div class="r-p-number fr">Receipt i768576957955</div>
            
            <div class="clr"></div>
            
            <div class="r-p-title">
                <p class="fl">Date: July 18, 2013</p>
                <p class="fr">Order Number: 645</p>
                
                <div class="clr"></div>
            </div>
            
            <div class="r-p-title2"><p>Billing Information</p></div>
            
            <div class="r-p-personal-info-left fl">
                <p>Allan V. Argosino</p>
                <p>
                    111 Manzanilla St. San Jose Village 2<br />
                    Binan, Lzaguna
                </p>
                <p>
                    <strong>PHONE</strong><br />
                    0225365869
                </p>
                <p>
                    <strong>EMAIL</strong><br />
                    Avargosino@gmail.com
                </p>
            </div>
            
            <div class="r-p-personal-info-right fr">
                <ul>
                    <li>
                        <label for="NAME">NAME</label> 
                            <span>Allan V. Argosino</span>
                            
                            <div class="clr"></div>
                    </li>
                    <li>
                        <label for="PAID">PAID</label>  
                            <span>(Visa) P 19, 750.00</span>
                    
                            <div class="clr"></div>
                    </li>
                    <li>
                        <label for="EMAIL">EMAIL</label> 
                            <span>Avargosino@gmail.com</span>
                            
                            <div class="clr"></div>
                    </li>
                    <li>
                        <label for="ACCOUNT NO.">ACCOUNT NO.</label> 
                            <span>############9876</span>
                            
                            <div class="clr"></div>
                    </li>
                </ul>
            </div>
            
            <div class="clr"></div>
            
            <ul class="r-product-details">
                <li class="r-p-title3">
                    <span class="col-lg-2">Product</span>
                    <span class="col-lg-3">Item Description</span>
                    <span class="col-lg-1">Qty</span>
                    <span class="col-lg-2">Unit Price</span>
                    <span class="col-lg-2">Discount</span>
                    <span class="col-lg-2">Total</span>
                    
                    <div class="clr"></div>
                </li>
                <li>
                    <div class="col-lg-2"><div class="r-p-frame"><img src="images/item_phone.jpg" width="52" height="80" alt=""/></div></div>
                    <div class="col-lg-3">
                        <p>iPhone 5<br />16 GB</p>
                        <p>Package Plan 2499</p>
                    </div>
                    <div class="col-lg-1">1</div>
                    <div class="col-lg-2">P 12,500.00</div>
                    <div class="col-lg-2"></div>
                    <div class="col-lg-2">P 12,500.00</div>
                    
                    <div class="clr"></div>
                </li>
                <li>
                    <div class="col-lg-2"><div class="r-p-frame"><img src="images/item_gadget_care.jpg" width="67" height="78" alt=""/></div></div>
                    <div class="col-lg-3">
                        <p>Gadget Care</p>
                        <p>Add-Ons</p>
                    </div>
                    <div class="col-lg-1">1</div>
                    <div class="col-lg-2">P 4,500.00</div>
                    <div class="col-lg-2">Less 20%</div>
                    <div class="col-lg-2">P 4,500.00</div>
                    
                    <div class="clr"></div>
                </li>
                <li>
                    <div class="col-lg-2"><div class="r-p-frame"><img src="images/item_headset.jpg" width="70" height="79" alt=""/></div></div>
                    <div class="col-lg-3">
                        <p>iPhone 5<br />16 GB</p>
                        <p>Package Plan 2499</p>
                    </div>
                    <div class="col-lg-1">1</div>
                    <div class="col-lg-2">P 4,500.00</div>
                    <div class="col-lg-2"></div>
                    <div class="col-lg-2">P 4,500.00</div>
                    
                    <div class="clr"></div>
                </li>
                <li class="r-p-cost">
                    <label for="Subtotal">Subtotal</label>
                        <span class="span2">P 19,600.00</span>
                        
                        <div class="clr"></div>
                    <label for="Shipping and Handling Cost">Shipping and Handling Cost</label>
                        <span class="span2">P 850.00</span>
                        
                        <div class="clr"></div>
                </li>
                <li class="r-p-title4">
                    <label for="Total">Total</label>
                        <span>P 20,450.00</span>
                        
                        <div class="clr"></div>
                </li>
            </ul>
            
            <div class="clr"></div>
            
            <input type="submit" name="submit" value="Print" class="blue-btn"/>
        </div>
    </div>
