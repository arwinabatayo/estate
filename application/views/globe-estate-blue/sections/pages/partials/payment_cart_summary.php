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
                    	<td name="discount" align="left" width="">% Discount</td>
                    	<td align="left">Total</td>                                                                                                
                        <td>&nbsp;</td>
                    </tr>
	            <?php 
						foreach($cartItems as $item){
					?>
			            <tr id="prod-item-<?php echo $item['rowid'] ?>">
			            
		                    <tr>
		                    	<td name="product" align="center">
									<!-- #IMAGE HERE-->
									<img src="images/prod-img1.png" />
								</td>
		                    	<td>
		                        	<span><?php echo $item['name'] ?></span>
		                            <span><!--#options --></span>
		                            <span class="violet"><?php echo strtoupper($item['product_type']) ?></span>
		                        </td>
		                    	<td name="unit-price"><?php echo $item['price_formatted'] ?></td>
		                    	<td name="discount"><?php echo $item['discount'] ? '<span class="discount">Less '.$item['discount'].'%</span>': '' ?></td>
		                    	<td><?php echo 'Php '.number_format($item['subtotal']) ?></td>                                                                                                
		                        <td><a data-alt="Delete" class="btnDelete del" id="<?php echo $item['rowid'] ?>" rel="<?php echo $item['name'] ?>"><img src="<?php echo $assets_url ?>site-blue/images/icons/icon-delete.png" alt="Delete"></a></td>                    	

			            </tr>
	            
	            <?php 
						}
					
				?>
                  
                </table> 
                <table width="100%" cellpadding="0" cellspacing="0" class="total-sum">
                	<tr>
                    	<td width="668" align="right">Subtotal</td>
                    	<td class="price"><?php echo $this->cart_model->get_items_subtotal(true)  ?></td>                        
                    </tr>
                	<tr>
                    	<td width="668" align="right">Reset Cost</td>
                    	<td class="price">-</td>                        
                    </tr>
                	<tr class="gtotal">
                    	<td width="668" align="right">Total</td>
                    	<td class="gprice"><?php echo $this->cart_model->total(true) ?></td>                        
                    </tr>                         
                </table>
                <br />
                <div class="plan-sum-btn">
                	<button class="blue-btn pull-right">Continue</button>
                </div>

		<?php } else { ?>
		
		<p>Your shopping cart is empty.</p>
		
		<?php } ?>

	</div>
