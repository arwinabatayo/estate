    <?php
		
		//print_r($cartItems);
		
    ?>
    <div id="cartSummaryTable">
		<?php if($cartItems){ ?>
	    <table class="table table-striped table-bordered table-hover table-condensed">
	            <thead>
	              <tr>
	                <th>Product</th>
	                <th>Item Description</th>
	                <th class="textcenter">QTY</th>
	                <th>Unit Price</th>
	                <th>Discount</th>
	                <th>Total</th>
	              </tr>
	            </thead>
	            
	            <?php 
						foreach($cartItems as $item){
					?>
			            <tr id="prod-item-<?php echo $item['rowid'] ?>">
			              <td> 
			              
			               </td>
			              <td>
							  <span class="fleft"><?php echo $item['name'] ?></span>
							  <span class="icoDelete fright"> <a href="javascript:void(0)" class="btnDelete" id="<?php echo $item['rowid'] ?>" rel="<?php echo $item['name'] ?>"><i class="icon-remove"></i></a>&nbsp;</span>
						  </td>
			              <td align="center" class="textcenter"><?php echo $item['qty'] ?></td>
			              
			              <td><?php echo $item['price_formatted'] ?></td>
			              <td> <?php echo isset($item['discount']) ? $item['discount'] : '' ?> </td>
			              <td><?php echo 'Php '.number_format($item['subtotal']) ?></td>
			            </tr>
	            
	            <?php 
						}
					
				?>
					
	            <tr>
	              <td colspan="4"></td>
	              <td><strong>Sub total</strong></td>
	              <td><span><?php echo $this->cart_model->get_items_subtotal(true)  ?></span> </td>
	            </tr>
	            <tr>
	              <td colspan="4"></td>
	              <td><strong>Shipping &amp; Handling</strong></td>
	              <td><?php echo $this->cart_model->get_shipping_fee(true)  ?></td>
	            </tr>
	            <tr>
	              <td colspan="4"></td>
	              <td><strong>Total</strong></td>
	              <td><span class="cashoutLabel"><?php echo $this->cart_model->total(true) ?></span>
	              </td>
	            </tr>
		</table>
		<?php } ?>
		
		<hr />
		<br />
		<div class="textcenter">
			<p><input type="checkbox" value="1" /> <a href="#">I Agree to the Terms &amp; Conditions</a></p>
			<button class="btn-large ui-button-success goNext">CONFIRM ORDER</button>
		</div>
									    
	</div>
	
