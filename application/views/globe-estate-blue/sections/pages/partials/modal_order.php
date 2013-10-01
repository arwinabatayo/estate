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
