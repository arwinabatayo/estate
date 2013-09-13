<div id="left-siderbar" class="span3">

	<div class="line-tab">LINE 1</div>
	<br class="clear"/>
    <section class="jq-accordion" id="siderbar-panel">
            <div>
            	<?php $user = $account;?>
                <h3><a href="#">My Account - <?php echo $user->mobile_number; ?></a></h3>
                <div>
					<?php if($user->mobile_number){ ?>
					<p><strong>Mobile Number:</strong> <?php echo $user->mobile_number ?></p>
					<?php } ?>

					<?php if($user->account_id ){ ?>
					<p><strong>Account #:</strong> <?php echo $user->account_id ?></p>
					<?php } ?>

					<?php if($user->account_id ){ //TODO: get from account_plan ?>
					<p><strong>Plan:</strong> 3799</p>
					<?php } ?>

					<?php if($user->account_id ){ //TODO get from DB ?>
					<p><strong>Category:</strong> Consumer</p>
					<?php } ?>

					<?php if($user->name && $user->surname){ ?>
					<p><strong>Name:</strong> <?php echo $user->name . ' ' . $user->surname ?></p>
					<?php } ?>

					<?php if($user->lockin_duration ){ ?>
					<p><strong>Lock-in Duration:</strong> <?php echo date('M d, Y',strtotime($user->lockin_duration) ) ?></p>
					<?php } ?>

					<?php if($user->outstanding_balance ){ ?>
					<p><strong>Outstanding Balance:</strong> Php <?php echo number_format($user->outstanding_balance,2) ?></p>
					<?php } ?>

					<?php if($user->due_date){ ?>
					<p><strong>Due Date:</strong> <?php echo date('M d, Y',strtotime($user->due_date) ) ?></p>
					<?php } ?>

					<?php if($user->credit_limit ){ ?>
					<p><strong>Credit Limit:</strong> Php <?php echo number_format($user->credit_limit,2) ?></p>
					<?php } ?>

					<?php if($user->account_id ){ //TODO not in DB ?>
					<p><strong>Overdue:</strong> Php <?php echo number_format($user->credit_limit,2) ?></p>
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
		            		// load model orderitem
		            		$this->load->model('estate/orderitem_model');
		            		$total = 0;
		            		// display all order items
		            		foreach ($order_items as $item) {
		            			// get subtotal per item
		            			$subtotal = $this->orderitem_model->get_subtotal_by_orderitem_id( $item->id );
						?>
				            <tr id="prod-item-<?php echo $item->id; ?>">
				              <td>
				              	<img src="<?php echo $item->product_image; ?>" />
				               </td>
				              <td>
								  <span class="fleft"><?php echo $item->product_name . " / " . $item->product_data_capacity; ?></span>
								  <br/>
								  <span class="fleft"><?php /*TODO*/ echo 'show package plan' ?></span>
							  </td>
				              <td align="center" class="textcenter"><?php echo $item->quantity;?></td>

				              <td><?php echo $item->product_amount; ?></td>
				              <td> <?php echo $item->percent_discount; ?> </td>
				              <td><?php echo 'Php ' .  number_format($subtotal, 2); ?></td>
				            </tr>

		            <?php
		            		// combine all subtotal
		            		$total += $subtotal;
						}
					?>

		            <tr>
		              <td colspan="4"></td>
		              <td><strong>Sub total</strong></td>
		              <td><span><?php echo 'Php ' . number_format($total, 2);  ?></span> </td>
		            </tr>
		            <tr>
		              <td colspan="4"></td>
		              <td><strong>Shipping &amp; Handling</strong></td>
		              <?php // add shipping total and handling fee from orders
		              		$shipping_handling = $order['shipping_total'] + $order['handling_fee'];
		              ?>
		              <td><?php echo $shipping_handling; ?></td>
		            </tr>
		            <tr>
		              <td colspan="4"></td>
		              <td><strong>Total</strong></td>
		              <?php // compute grand total = subtotal + shipping + handling
		              		$tax_amount = $order['tax'] ? $total * ($order['tax'] / 100) : 0;
		              		$grand_total = $shipping_handling + ($total - $tax_amount);
		              ?>
		              <td><span class="cashoutLabel"><?php echo  'Php ' . number_format($grand_total, 2); ?></span></td>
		            </tr>
			</table>
            </div>
    </section>
</div>