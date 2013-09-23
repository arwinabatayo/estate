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
	<ul style="width: auto; height: 70px; list-style: none;">
		<li style="display: inline; margin-right: 25px;"><span style="font-weight: bold;">Status : </span><?php echo $order['status']; ?></li>
		<li style="display: inline; margin-right: 25px;"><span style="font-weight: bold;">Device : </span><?php echo $gadget_item['name']; ?></li>
		<li style="display: inline; margin-right: 25px;"><span style="font-weight: bold;">Plan : </span><?php echo $plan_item['name']; ?></li>
		<li style="display: inline; margin-right: 25px;"><span style="font-weight: bold;">Forms : </span><a href="#" id="printable-forms">Forms</a></li>
		<li style="display: inline; margin-right: 25px;"><span style="font-weight: bold;">Delivery tracker : </span><a href="javascript: void(0);" id="delivery-tracker">.</a><br/><span>Est. Delivery - <?php echo $delivery_info['est_delivery_date']; ?></span></li>
	</ul>

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
                    <tr>
		              <td colspan="4"></td>
		              <td><strong>Total</strong></td>
		              <td><span class="cashoutLabel"><?php echo  'Php ' . number_format($order['total'], 2); ?></span></td>
		            </tr>
			</table>
            </div>
    </section>
</div>

<div class="globe-dialog" id="dialog_print_forms" title="Print">
    <ul style="list-style: none;">
    <li style="display: inline; margin-right: 35px;"><button class="btn btn-primary" onClick="downloadForm('msa');">Print</button>&nbsp;MSA Form</li>
    <li style="display: inline; margin-right: 35px;"><button class="btn btn-primary" onClick="downloadForm('qr');">Print</button>&nbsp;QR Code</li>
    <li style="display: inline;  margin-right: 35px;"><button class="btn btn-primary" onClick="downloadForm('receipt');">Print</button>&nbsp;Receipt</li>
    </ul>
</div>

<div class="globe-dialog" id="dialog_delivery_tracker" title="Tracking Number : <?php echo $order['tracking_id']; ?>">
    <h4><?php echo $delivery_info['short_summary']; ?></h4>
    <div style="width: 500px;" class="textcenter">
        <div id="desktop-breadcrumbs" class="row textcenter">
            <div class="steps">
                <a class="current" id="bc_step1">Initiated</a>

                <a class="current" id="bc_step2">Picked-up</a>

                <a class="current" id="bc_step3">In-transit</a>

                <a class="" id="bc_step4">Delivered</a>
            </div>
            <br>
            <br>
            <h5>On globe vehicle for delivery </h5>
            <h3><?php echo $delivery_info['delivery_dest']; ?></h3>
                    <div style="width: 100%; margin-left: 10px;">
            <div class="left" style="float: left; width: 50%;">
                Shipment Dates <br/><br/>
                Ship Date : <?php echo date("F j, Y", strtotime($delivery_info['shipment_date'])); ?> <br/>
                Estimated Delivery : <?php echo date("F j, Y", strtotime($delivery_info['est_delivery_date']));   ?>
            </div>
            <div class="right" style="float: right; width: 50%">
                Destination <br/><br/>
                <?php echo $delivery_info['shipment_dest']; ?>
            </div>

        </div>
        </div>
    </div>
</div>

<div class="globe-dialog" id="receipt" title="Receipt">
	<div>
		<strong>Date:</strong>
		<strong>Order Number:</strong>
	</div>
	<div>
		<strong>Billing Information</strong>
	</div>
	<div>
		<table>
			<tr>
				<td></td>
				<td></td>
			</tr>
		</table>
	</div>
	<div>
		<table>
			<tr>
				<td>Product</td>
				<td>Item Description</td>
				<td>Unit Price</td>
				<td>% Discount</td>
				<td>Total</td>
			</tr>
			<tr>
				<td>Product</td>
				<td>Item Description</td>
				<td>Unit Price</td>
				<td>% Discount</td>
				<td>Total</td>				
			</tr>
			<tr>
				<td rowspan="3"><strong>Subtotal</strong></td>
				<td rowspan="2"></td>
			</tr>
			<tr>
				<td rowspan="3"><strong>Shipping and Handling Cost</strong></td>
				<td rowspan="2"></td>
			</tr>
		</table>
	</div>

	<div>

	</div>
</div>
