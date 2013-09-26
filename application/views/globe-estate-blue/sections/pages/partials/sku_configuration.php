<form id="addGadget" action="" onsubmit="return false">	
            <div class="row-fluid adddevice">
                <div class="span6 ldarkgreybg">
                    <div class="row-fluid">
                        <div class="flow-title offset1">
                            <i class="flow-icon icon-appl pull-left"></i>
                            <?php 
                            
								if($devices['count'] > 1) {
									unset($devices['count']);
							?>
							<select id="multidevice">
							<?php foreach($devices as $devs) { 
									$setSelected = "";
									if(isset($_GET['type'])) {
										$arrKey = explode("_",$_GET['type']);
										$selectedKey = $arrKey[1];
										if($selectedKey == $devs['id']) {
											$setSelected = " selected";
										}
									}
								?>
								<option value="type_<?php echo $devs['id']; ?>"<?php echo $setSelected; ?> data-id="<?php echo $devs['id']; ?>"><?php echo $devs['name']; ?>
							<?php } ?>
							</select>
							<?php } else { ?>
								<span class="pull-left"><?php echo $devices[0]['name']; ?></span>
							<?php } ?>
                            
                        </div>
                    </div>
                    <div class="row-fluid" id="colors">
                        <div class="spec-options offset1">
                            <span class="flow-title2">Choose Color</span>
                            <ul>
                            <?php $initialGadgetPreview =  "";
                            	foreach($colors as $attrColors) { 
                            		$selected = "";
                            		
                            		if($initialColorId == $attrColors['clid']) {
										$selected = " checked";
										$initialGadgetPreview =  $attrColors['gadgetimg'];
									}
                            	?>
                                <li>
                                	<img src="<?php echo base_url() ?>_assets/uploads/<?php echo $attrColors['climg']?>"/>
                                	<span>
                                		<input id="<?php echo strtolower($attrColors['clname']); ?>" type="radio" name="gadget_color" value="<?php echo strtolower($attrColors['clid']); ?>" data-img="<?php echo base_url() ?>_assets/uploads/<?php echo $attrColors['gadgetimg']; ?>"<?php echo $selected; ?>>
                                		<label for="<?php echo strtolower($attrColors['clname']); ?>"><?php echo $attrColors['clname']?></label>
                                	</span>
                                </li>
                            <?php }?>
                            </ul>
                        </div>
                    </div>
                    <div class="row-fluid" id="capacity">
                        <div class="spec-options offset1">
                            <span class="flow-title2">Choose Capacity</span>
                            <ul>
                            <?php
                            	foreach($capacity as $attrCapacities) {
									$selected = "";
									
									if($initialCapacityId == $attrCapacities['dcid']) {
										$selected = " checked";
									} 
									?>
                                <li>
                                	<img src="<?php echo base_url() ?>_assets/uploads/<?php echo $attrCapacities['dcimg']?>" />
                                	<span>
                                		<input id="<?php echo strtolower(str_replace(" ", "",$attrCapacities['dcname'])); ?>" type="radio" name="gadget_capacity" value="<?php echo strtolower(str_replace(" ", "",$attrCapacities['dcname'])); ?>"<?php echo $selected; ?>>
                                		<label for="<?php echo strtolower(str_replace(" ", "",$attrCapacities['dcname'])); ?>"><?php echo $attrCapacities['dcname']?></label>
                                	</span>
                                </li>
                            <?php }?>
                            </ul>                            
                        </div>
                    </div>
                    <div class="row-fluid text-center" id="continue">
                        <button class="blue-btn" id="btn-add-device-continue">Continue</button>
                    </div>
                </div>
                <div class="span6 p-model text-center" id="gadgetpreview">
                    <img src="<?php echo base_url() ?>_assets/uploads/<?php echo $initialGadgetPreview; ?>" id="previewimg">
                </div>                
            </div>
            
			 <?php /*TODO: make it db driven */ ?>
			 <input type="hidden" name="cart_id" value="1_gadget" />
		     <input type="hidden" name="product_id" value="1" />
		     <input type="hidden" name="product_name" value="iPhone 5" />
		     <input type="hidden" name="product_price" value="12500" />
		     <input type="hidden" name="product_type" value="gadget" />
</form>            
            
            
            
            
            
            
            
            
            
            
            
            
