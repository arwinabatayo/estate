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
	<?php // display here the product_type 'gadget' ?>
	Status : <?php echo $order['status']; ?>
	Device : device name
	Plan : Plan name
	Forms : 
	Delivery tracker : 

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
		            			// analyze product info
		            			$_item = unserialize($item->product_info);
						?>
				            <tr id="prod-item-<?php echo $_item['id']; ?>">
				              <td>
				              	<img src="<?php echo $_item['product_image']; ?>" />
				               </td>
				              <td>
								  <span class="fleft"><?php echo $_item['name']; //. " / " . $_item['product_data_capacity']; ?></span>
								  <br/>
							  </td>
				              <td align="center" class="textcenter"><?php echo $_item['qty'];?></td>

				              <td><?php echo $_item['price']; ?></td>
				              <td> <?php echo $_item['discount']; ?> </td>
				              <td><?php echo 'Php ' .  number_format($_item['subtotal'], 2); ?></td>
				            </tr>

		            <?php

						}
					?>

		            <tr>
		              <td colspan="4"></td>
		              <td><strong>Sub total</strong></td>
		              <td><span><?php echo 'Php ' . number_format($order['subtotal'], 2);  ?></span> </td>
		            </tr>
		            <tr>
		              <td colspan="4"></td>
		              <td><strong>Shipping &amp; Handling</strong></td>
		              <?php // add shipping total and handling fee from orders TODO : add handling_fee on orders
		              		$shipping_handling = $order['shipping_fee'] + $order['handling_fee'];
		              ?>
		              <td><?php echo $shipping_handling; ?></td>
		            </tr>
<!-- 		            <tr>
		              <td colspan="4"></td>
		              <td><strong>% Tax</strong></td>
		              <td><?php echo $order['tax']; ?></td>
		            </tr>
 -->		            <tr>
		              <td colspan="4"></td>
		              <td><strong>Total</strong></td>
		              <td><span class="cashoutLabel"><?php echo  'Php ' . number_format($order['total'], 2); ?></span></td>
		            </tr>
			</table>
            </div>
    </section>
</div>