<div id="g_content">

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
		
			<form id="form_add_accessory" class="g_form">
				
				<!-- order reference number -->
				<div class="item">
					<div class="label">Order reference number</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="order_reference_number" 
								maxlength="200" />
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
							<option value="0" selected="selected">Select order status</option>
							<?php foreach( $order_statuses as $status ){ ?>
								<option value="<?php echo $status['order_status_id']; ?>"><?php echo $status['status_name'] . ' (' . $status['status_code'] . ')'; ?></option>
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
								checked="checked"
								name="delivery_type" 
								maxlength="200"
								value="pickup" /> Pickup
						<input 	class="" 
								type="radio" 
								name="delivery_type" 
								maxlength="200"
								value="delivery" /> Delivery
					</div>
					<div class="h_clearboth"></div>
				</div>
			</form>
			
		</td></tr>
	</table>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/generic.png" /></div>
		<div class="g_pagelabel_text">Result</div>
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
				<th>Status</th>
			</tr>
			
			<?php foreach ($accounts as $accounts => $a) { ?>
				<tr>
					<td><a href="<?php echo base_url() . 'admin/ordermanagement/vieworder/' . $a['account_id'] . '/' . $a['order_number']; ?>"><?php echo $a['order_number']; ?></a></td>
					<td><?php echo $a['account_id']; ?></td>
					<td><?php echo $a['order_type_title']; ?></td>
					<td><?php echo date('M-d-Y', strtotime($a['ordered_on'])); ?></td>
					<td><?php echo date('M-d-Y', strtotime($a['shipped_on'])); ?></td>
					<td><?php echo $a['delivery_type']; ?></td>
					<td><?php echo $a['order_status_name']; ?></td>
				</tr>
			<?php } ?> 
			
		</table>
			
	<?php } else { ?> 
		
		<table class="g_table">
			<tr><td class="h_padding20"><div class="g_nodata"><div class="icon"></div>No data to display</div></td></tr>
		</table>
			
	<?php } ?>
	
</div>

<script type="text/javascript" language="javascript">
$(function(){
	zebraTable();
	implementDatePicker();
});

$(".input_uf_eur").change(function(){
	var function_id = $(this).attr('data-uf');
	var user_type_id = $(this).attr('data-eur');
	var is_checked = 0;
	
	if(	$(this).is(":checked")	){
		is_checked = 1;
	}else{
		is_checked = 0;
	}
	
	displayNotification("message", "Working...")
	$.ajax({
		url: "<?php echo base_url(); ?>admin/userfunctions/update_userfunction_vs_ecommerceuserrole",
		type: "POST",
		data: "function_id="+function_id+"&user_type_id="+user_type_id+"&is_checked="+is_checked,
		success: function(response, textStatus, jqXHR){
			setTimeout(function () {
				displayNotification("success", "User functions successfully updated.");
			}, 500);
		},
		error: function(jqXHR, textStatus, errorThrown){
			$('#middle_wrapper').html(jqXHR.responseText);
			displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
		}
	});
});
</script>