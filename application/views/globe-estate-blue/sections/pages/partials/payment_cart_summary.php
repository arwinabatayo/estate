    <?php
		
		//print_r($cartItems);
    ?>
    <div id="cartSummaryTable">
        <?php if($cartItems){ ?>
            	<table width="100%" cellpadding="0" cellspacing="0">
                	<tr class="plan-sum-title">
                    	<td name="product" align="center" width="">Product</td>
                    	<td align="left" width="">Item Description</td>
                    	<td name="unit-price" align="left" width="">Unit Price</td>
                    	<td name="discount" align="left" width="">Discount</td>
                    	<td align="left">Total</td>                                                                                                
                        <td>&nbsp;</td>
                    </tr>
	            <?php 
						foreach($cartItems as $item){
							$prodType = strtolower($item['product_type']);
					?>

		                <tr class="<?php echo ($prodType == 'gadget') ? '':'light' ?>" id="prod-item-<?php echo $item['rowid'] ?>">
		                    	<td name="product" align="center">
									<!-- #IMAGE HERE-->
									<div class="prod-image-box"></div>
								</td>
		                    	<td>
		                        	<span><?php echo $item['name'] ?></span>
		                            <span><!--#options --></span>
		                            <span class="violet"><?php 
										if( $prodType == 'addon' ){
											echo 'ADD-ONS';
										}else if($prodType == 'gadget'){
											echo 'PLAN 3799';
										}else{
											echo strtoupper($prodType) ;
										}
		                            ?></span>
		                        </td>
		                    	<td name="unit-price"><?php echo $item['price_formatted'] ?></td>
		                    	<td name="discount"><?php echo $item['discount'] ? '<span class="discount">Less '.$item['discount'].'%</span>': '' ?></td>
		                    	<td><?php echo 'Php '.number_format($item['subtotal']) ?></td>                                                                                                
		                        <td>
									<?php if($prodType != 'gadget'){ ?>
									<a data-alt="Delete" class="btnDelete del" id="<?php echo $item['rowid'] ?>" rel="<?php echo $item['name'] ?>"><img src="<?php echo $assets_url ?>site-blue/images/icons/icon-delete.png" alt="Delete"></a>
									<?php } ?>
								</td>                    	

			            </tr>
	            
	            <?php 
						}
					
				?>
                  
                </table> 
                <table width="100%" cellpadding="0" cellspacing="0" class="total-sum">
                	<tr>
                    	<td width="65%" align="right">Subtotal</td>
                    	<td class="price">
							<span id="cashoutLabelSubtotal">
							<?php echo $this->cart_model->get_items_subtotal(true)  ?>
							</span>
						</td>                        
                    </tr>
                    <?php 
                    //Plan Summary & Confirm Order is sharing this tpl - m4rk
                    if($current_method == 'confirm_order'){ ?>
                	<tr>
                    	<td align="right">Shipping and handling cost</td>
                    	<td class="price"><?php echo $this->cart_model->get_shipping_fee(true)  ?></td>                        
                    </tr>
                    <?php }else{ ?>
                	<tr>
                    	<td align="right">Reset Cost</td>
                    	<td class="price">-</td>                        
                    </tr>
                    <?php } ?>

                	<tr class="gtotal">
                    	<td align="right">Total</td>
                    	<td class="gprice">
							<span id="cashoutLabel">
								<?php echo $this->cart_model->total(true) ?>
							</span>
						</td>                        
                    </tr>
					<tr>
						<td>&nbsp;</td>
						<td><div class="agree-check" style="position:relative; float:left;"><input tabindex="13" type="checkbox" id="flat-checkbox-1"></div> <p style="padding-left:25px;">I agree to the Terms & Conditions</p> <div class="clr"></div></td>
					</tr>
                </table>
                <br />
                <div class="plan-sum-btn">
					 <?php if($current_method == 'confirm_order'){ ?>
						
						<button class="blue-btn pull-right" onclick="window.location.href='<?php echo base_url() ?>payment-method'">Continue</button>
                	  
                	  <?php }else{ ?>
                	  
						<button class="blue-btn pull-right" onclick="window.location.href='<?php echo base_url() ?>delivery-pickup'">Continue</button>
                	  
                	  <?php } ?>
                </div>

		<?php } else { ?>
            	<table width="100%" cellpadding="0" cellspacing="0">
                	<tr class="plan-sum-title">
						<td>
							<p class="textcenter">Your shopping cart is empty.</p>
						</td>
                	</tr>
                </table>	
		
		
		<?php } ?>

	</div>
