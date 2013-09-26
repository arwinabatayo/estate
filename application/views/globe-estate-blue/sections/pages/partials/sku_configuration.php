<form id="addGadget" action="" onsubmit="return false">	
            <div class="row-fluid adddevice">
                <div class="span6 ldarkgreybg">
                    <div class="row-fluid">
                        <div class="flow-title offset1">
                            <i class="flow-icon icon-appl pull-left"></i>
                            <span class="pull-left">Apple iPhone 5</span>                            
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="spec-options offset1">
                            <span class="flow-title2">Choose Color</span>
                            <ul>
                                <li><img src="<?php echo $assets_url ?>images/iphone5/iphone-color-black.png"/><span><input id="black" class="opt_color" type="radio" name="gadget_color" value="black" checked="checked"><label for="black">Black</label></span></li>
                                <li><img src="<?php echo $assets_url ?>images/iphone5/iphone-color-white.png"/><span><input id="white" class="opt_color" type="radio" name="gadget_color" value="white"><label for="white">White</label></span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="spec-options offset1">
                            <span class="flow-title2">Choose Capacity</span>
                            <ul>
                                <li><img src="<?php echo $assets_url ?>images/iphone5/iphone16gb.png"/><span><input id="16gb" type="radio" name="gadget_capacity" value="16gb" checked="checked"><label for="16gb">16GB</label></span></li>
                                <li><img src="<?php echo $assets_url ?>images/iphone5/iphone32gb.png"/><span><input id="32gb" type="radio" name="gadget_capacity" value="32gb"><label for="32gb">32GB</label></span></li>
                                <li><img src="<?php echo $assets_url ?>images/iphone5/iphone64gb.png"/><span><input id="64gb" type="radio" name="gadget_capacity" value="64gb"><label for="64gb">64GB</label></span></li>
                            </ul>                            
                        </div>  
                    </div>
                    <div class="row-fluid text-center">
                        <button class="blue-btn" id="btn-add-device-continue">Continue</button>
                    </div>
                </div>
                <div id="product_preview" class="span6 p-model text-center" style="padding-top:0">
                    
                    <img class="p_img c_black" alt="iPhone 5  Black" src="<?php echo $assets_url ?>images/iphone5/iphone5-black.jpg" style="height:580px" />
                    <img class="p_img c_white" alt="iPhone 5  White" src="<?php echo $assets_url ?>images/iphone5/iphone5-white.jpg" style="height:580px;display:none" />

                </div>                
            </div>
            
			 <?php /*TODO: make it db driven */ ?>
			 <input type="hidden" name="cart_id" value="1_gadget" />
		     <input type="hidden" name="product_id" value="1" />
		     <input type="hidden" name="product_name" value="iPhone 5" />
		     <input type="hidden" name="product_price" value="12500" />
		     <input type="hidden" name="product_type" value="gadget" />
</form>            
            
            
            
            
            
            
            
            
            
            
            
            
