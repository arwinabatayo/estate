<div id="g_content">
	
<?php // comment out filtering ?>
<?php /*
	<div id="g_tools"> 
		<a href="javascript: void(0);" id="btn_filter"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/search.png" />Filter</a>	
		<div class="h_clearboth"></div>
	</div>

	<div class="h_clearboth"></div>
	<div class="g_spacer"></div>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/generic.png" /></div>
		<div class="g_pagelabel_text">Order Management</div>
	</div>
	

	<table class="g_table">
		<tr><td class="g_widget">
		
			<form id="form_filter" class="g_form">
				
				<!-- order reference number -->
				<div class="item">
					<div class="label">Order reference number</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="order_reference_number" 
								value="<?php echo $this->input->post('order_reference_number'); ?>" 
								maxlength="200" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- application type -->
				<div class="item">
					<div class="label">Application type</div>
					<div class="input">
						<select class="g_select" name="order_type" data-required="1">
							<option value="0">Select application type</option>
							<?php foreach( $order_types as $order_type ){ ?>
								<?php if( $order_type['id'] == $this->input->post('order_type') ){ ?>
									<option value="<?php echo $order_type['id']; ?>" selected="selected"><?php echo $order_type['title']; ?></option>
								<?php }else{ ?>
									<option value="<?php echo $order_type['id']; ?>"><?php echo $order_type['title']; ?></option>
								<?php } ?>
							<?php } ?>
						</select>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- date ordered -->
				<div class="item">
					<div class="label">Date ordered</div>
					<div class="input">
						<input 	class="g_inputtext dpicker h_backgroundlight" 
								type="text" 
								name="date_ordered" 
								value="<?php echo $this->input->post('date_ordered'); ?>" 
								data-datepicker="1"
								data-format="yy-mm-dd"
								maxlength="255" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- date shipped -->
				<div class="item">
					<div class="label">Date shipped</div>
					<div class="input">
						<input 	class="g_inputtext dpicker h_backgroundlight" 
								type="text" 
								name="date_shipped" 
								value="<?php echo $this->input->post('date_shipped'); ?>" 
								data-datepicker="1"
								data-format="yy-mm-dd"
								maxlength="255" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- status -->
				<div class="item">
					<div class="label">Order status *</div>
					<div class="input">
						<select class="g_select" name="order_status" data-required="1">
							<option value="0">Select order status</option>
							<?php foreach( $order_statuses as $status ){ ?>
								<option <?php if( $this->input->post('order_status') && $this->input->post('order_status') == $status['order_status_id'] ){ echo 'selected="selected"'; } ?> value="<?php echo $status['order_status_id']; ?>"><?php echo $status['status_name'] . ' (' . $status['status_code'] . ')'; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- delivery type -->
				<div class="item">
					<div class="label">Delivery type</div>
					<div class="input">
						<input 	class="" 
								type="radio" 
								<?php if( $this->input->post('delivery_type') && $this->input->post('delivery_type') == 'pickup' ){ echo 'checked="checked"'; } ?> 
								name="delivery_type" 
								maxlength="200"
								value="pickup" /> Pickup
						<input 	class="" 
								type="radio" 
								<?php if( $this->input->post('delivery_type') && $this->input->post('delivery_type') == 'delivery' ){ echo 'checked="checked"'; } ?> 
								name="delivery_type" 
								maxlength="200"
								value="delivery" /> Delivery
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<input type="hidden" name="filter" value="1" />
				<input type="hidden" name="current_page" value="1" />
			</form>
			
		</td></tr>
	</table>
*/ ?>

	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/generic.png" /></div>
		<div class="g_pagelabel_text">Orders Shipping Details</div>
		<?php echo $pagination; ?>
	</div>
	
	<?php if ($accounts) { ?>
	
		<table class="g_table zebra">
		
			<tr>
				<th>Order Number</th>
				<th>Account Id</th>
				<th>Order Type</th>
				<th>Date Ordered</th>
				<th>Date Shipped</th>
				<th>Delivery Type</th>
				<th>Tracking ID</th>
				<th>Courier</th>
				<th>IMEI</th>
				<th>SIM Serial</th>
				<th>Status</th>
			</tr>
			
			<?php foreach ($accounts as $accounts => $a) { ?>
				<tr>
					<td><a href="<?php echo base_url() . 'admin/ordershipping/editorder/' . $a['account_id'] . '/' . $a['order_number']; ?>"><?php echo $a['order_number']; ?></a></td>
					<td><?php echo $a['account_id']; ?></td>
					<td><?php echo $a['order_type_title']; ?></td>
					<td><?php if( $a['ordered_on'] == null || $a['ordered_on'] == '0000-00-00 00:00:00' ){ echo '--'; }else{ echo date('M-d-Y', strtotime($a['ordered_on'])); } ?></td>
					<td><?php if( $a['shipped_on'] == null ){ echo '--'; }else{ echo date('M-d-Y', strtotime($a['shipped_on'])); } ?></td>
					<td><?php if( $a['delivery_type'] == null ){ echo '--'; }else{echo $a['delivery_type'];} ?></td>
					<td><?php if( $a['tracking_id'] == null ){ echo '--'; }else{echo $a['tracking_id'];} ?></td>
					<td><?php if( $a['shipping_courier'] == null ){ echo '--'; }else{echo $a['shipping_courier'];} ?></td>
					<td><?php if( $a['IMEI'] == null ){ echo '--'; }else{echo $a['IMEI'];} ?></td>
					<td><?php if( $a['sim_serial'] == null ){ echo '--'; }else{echo $a['sim_serial'];} ?></td>
					<td><?php if( $a['order_status_name'] == null ){ echo '--'; }else{echo $a['order_status_name'];} ?></td>
				</tr>
			<?php } ?> 
			
		</table>
			
	<?php } else { ?> 
		
		<table class="g_table">
			<tr><td class="h_padding20"><div class="g_nodata"><div class="icon"></div>No data to display</div></td></tr>
		</table>
			
	<?php } ?>
	
	<div class="g_pagination_wrapper"><?php echo $pagination; ?></div>
	
</div>

<script type="text/javascript" language="javascript">
$(function(){
	zebraTable();
	implementDatePicker();
});

$("#btn_filter").click(function(){
	displayNotification("message", "Working...");
	$.ajax({
		url: "<?php echo base_url(); ?>admin/ordermanagement/process_filter",
		type: "POST",
		data: $("#form_filter").serialize(),
		success: function(response, textStatus, jqXHR){
			setTimeout(function () {
				$("#middle_wrapper").html(response);
				displayNotification('success', 'Displaying filtered results');
			}, 500);
		},
		error: function(jqXHR, textStatus, errorThrown){
			$("#middle_wrapper").html(jqXHR.responseText);
			displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
		}
	});
});
</script>