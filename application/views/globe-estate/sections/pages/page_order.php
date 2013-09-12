<div id="left-siderbar" class="span3">

	<div class="line-tab">LINE 1</div>	
	<br class="clear"/>
    <section class="jq-accordion" id="siderbar-panel">
            <div>
            	<?php $user = $account;?>
                <h3><a href="#">My Account - <?php echo $user->f_mobile_number; ?></a></h3>
                <div>
					<?php if($user->f_mobile_number){ ?>
					<p><strong>Mobile Number:</strong> <?php echo $user->f_mobile_number ?></p>
					<?php } ?>
					
					<?php if($user->f_account_id ){ ?>
					<p><strong>Account #:</strong> <?php echo $user->f_account_id ?></p>
					<?php } ?>
					
					<?php if($user->f_account_id ){ //TODO: get from account_plan ?>
					<p><strong>Plan:</strong> 3799</p>
					<?php } ?>
					
					<?php if($user->f_account_id ){ //TODO get from DB ?>
					<p><strong>Category:</strong> Consumer</p>
					<?php } ?>
					
					<?php if($user->f_name && $user->f_surname){ ?>
					<p><strong>Name:</strong> <?php echo $user->name.' '.$user->surname ?></p>
					<?php } ?>
					
					<?php if($user->f_lockin_duration ){ ?>
					<p><strong>Lock-in Duration:</strong> <?php echo date('M d, Y',strtotime($user->f_lockin_duration) ) ?></p>
					<?php } ?>
					
					<?php if($user->f_outstanding_balance ){ ?>
					<p><strong>Outstanding Balance:</strong> Php <?php echo number_format($user->f_outstanding_balance,2) ?></p>
					<?php } ?>
					
					<?php if($user->f_due_date){ ?>
					<p><strong>Due Date:</strong> <?php echo date('M d, Y',strtotime($user->f_due_date) ) ?></p>
					<?php } ?>
					
					<?php if($user->f_credit_limit ){ ?>
					<p><strong>Credit Limit:</strong> Php <?php echo number_format($user->f_credit_limit,2) ?></p>
					<?php } ?>
					
					<?php if($user->f_account_id ){ //TODO not in DB ?>
					<p><strong>Overdue:</strong> Php <?php echo number_format($user->f_credit_limit,2) ?></p>
					<?php } ?>
                </div>
            </div>
    </section>   
    
</div>

<div id="main-page" class="span9">
    <section class="jq-accordion" id="plan-order-page">
            <div>
                <table class="table table-striped table-bordered table-hover table-condensed">
		            <thead>
		              <tr>
		                <th>Product</th>
		                <th>Item Description</th>
		                <th class="textcenter">QTY</th>
		                <th>Unit Price</th>
		                <th>% Discount</th>
		                <th>Total</th>
		              </tr>
		            </thead>
		            
		            <?php 
		            		foreach ($orders as $item) {
						?>
				            <tr id="prod-item-<?php echo $item->id; ?>">
				              <td> 
				              
				               </td>
				              <td>
								  <span class="fleft"><?php echo $item->f_product_name .'/'. $item->f_size; ?></span>
								  <br/>
								  <span class="fleft"><?php echo 'package plan test' ?></span>
							  </td>
				              <td align="center" class="textcenter"><?php echo $item->quantity;?></td>
				              
				              <td><?php echo $item->f_product_amount; ?></td>
				              <td> <?php echo isset($item->discount) ? 'source unknown' : '' ?> </td>
				              <td><?php echo 'Php ' . ($item->quantity * $item->f_product_amount); ?></td>
				            </tr>
		            
		            <?php 
							} 
						
					?>
						
		            <tr>
		              <td colspan="4"></td>
		              <td><strong>Sub total</strong></td>
		              <?php // TODO : changed to subtotal from orders table ?>
		              <td><span><?php echo $this->cart_model->get_items_subtotal(true)  ?></span> </td>
		            </tr>
		            <tr>
		              <td colspan="4"></td>
		              <td><strong>Shipping &amp; Handling</strong></td>
		              <?php // TODO : changed to shipping fee from orders table ?>
		              <td><?php echo $this->cart_model->get_shipping_fee(true)  ?></td>
		            </tr>
		            <tr>
		              <td colspan="4"></td>
		              <td><strong>Total</strong></td>
		              <?php // TODO : changed to total from orders table ?>
		              <td><span class="cashoutLabel"><?php echo $this->cart_model->total(true) ?></span></td>
		            </tr>
			</table>
            </div>


    </section> 
	
</div>