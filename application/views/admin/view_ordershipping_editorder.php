<div id="g_content">

	<div id="g_tools">
		<?php if( 	$this->session->userdata('user_type') == ROLE_ONLINE_SALES 
					|| $this->session->userdata('user_type') == ROLE_GLOBE_BUSINESS_SALES_SUPPORT_TEAM ){ ?>
			<a href="javascript: void(0);" id="btn_order_done"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/save.png" />Order Done</a>	
		<?php } ?>
		<?php if( $this->session->userdata('user_type') != ROLE_AGENT_ACCESS ){ ?>
			<a href="javascript: void(0);" id="btn_update_order"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/save.png" />Save Changes</a>	
		<?php } ?>
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>
	<div class="g_spacer"></div>

	<form id="form_edit_order" class="g_form">
		
	<?php /*
		<div class="g_pagelabel">
			<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/edit.png" /></div>
			<div class="g_pagelabel_text">My Gadget</div>
		</div>
		
		<table class="g_table zebra">
			<tr><td class="g_widget">
		
			<form id="form_filter" class="g_form">
				
				<!-- gadget details -->
				<div class="item">
					<div class="label">Gadget</div>
					<div class="input">
						<select class="g_select" name="order_type" data-required="1">
							<option value="0">Select gadget</option>
							<?php foreach( $gadgets as $gadget ){ ?>
								<?php if( $gadget['gadget_id'] == $this->input->post('order_type') ){ ?>
									<option value="<?php echo $gadget['gadget_id']; ?>" selected="selected"><?php echo $gadget['name']; ?></option>
								<?php }else{ ?>
									<option value="<?php echo $gadget['gadget_id']; ?>"><?php echo $gadget['name']; ?></option>
								<?php } ?>
							<?php } ?>
						</select>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
			</form>
				
			</td></tr>
		</table>
	*/ ?>
		<div class="g_pagelabel">
			<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/edit.png" /></div>
			<div class="g_pagelabel_text">My Order Shipping Details</div>
		</div>
		
		<table class="g_table zebra">
			<tr><td class="g_widget">
				
				<!-- order reference number -->
				<div class="item">
					<div class="label">Order reference number</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="order_reference_number" 
								value="<?php echo $order_details['order_number']; ?>" 
								maxlength="200" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- account number -->
				<div class="item">
					<div class="label">Account number</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="account_number" 
								value="<?php echo $account_details['account_id']; ?>" 
								maxlength="200" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- tracking ID -->
				<div class="item">
					<div class="label">Tracking ID</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="tracking_id" 
								value="<?php echo $order_details['tracking_id']; ?>" 
								maxlength="100" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- courier -->
				<div class="item">
					<div class="label">Courier</div>
					<div class="input">
						<select class="g_select" name="shipping_courier" data-required="1">
							<option value="">Select Courier</option>
							<?php foreach( $couriers as $courier ){ ?>
								<?php 
									$sel = '';
									if( $courier['courier_code'] == $order_details['shipping_courier'] ) { 
										$sel = ' selected="selected"';	
									}
								?>
									<option value="<?php echo $courier['courier_code']; ?>"<?php echo $sel; ?>><?php echo $courier['courier_name']; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- IMEI -->
				<div class="item">
					<div class="label">IMEI</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="imei" 
								value="<?php echo $order_details['IMEI']; ?>" 
								maxlength="100" />
					</div>
					<div class="h_clearboth"></div>
				</div>

				<!-- SIM serial -->
				<div class="item">
					<div class="label">Sim Serial</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="sim_serial" 
								value="<?php echo $order_details['sim_serial']; ?>" 
								maxlength="100" />
					</div>
					<div class="h_clearboth"></div>
				</div>

			</td></tr>
		</table>

	<?php /*	
		<div class="g_pagelabel">
			<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/edit.png" /></div>
			<div class="g_pagelabel_text">My Delivery</div>
		</div>
		
	
		<table class="g_table zebra">
			<tr><td class="g_widget">
				
				<!-- delivery type -->
				<div class="item">
					<div class="label">Delivery type</div>
					<div class="input">
						<input 	class="delivery_type_toggle" 
								data-delivery-type="delivery" 
								type="radio" 
								<?php if( $order_details['delivery_type'] && $order_details['delivery_type'] == 'delivery' ){ echo 'checked="checked"'; } ?> 
								name="delivery_type" 
								maxlength="200"
								value="delivery" /> Delivery
						<input 	class="delivery_type_toggle" 
								data-delivery-type="pickup" 
								type="radio" 
								<?php if( $order_details['delivery_type'] && $order_details['delivery_type'] == 'pickup' ){ echo 'checked="checked"'; } ?> 
								name="delivery_type" 
								maxlength="200"
								value="pickup" /> Pickup
					</div>
					<div class="h_clearboth"></div>
				</div>
				<hr />
				<div class="item deliverytype deliverytypedelivery"  style="display: <?php if( $order_details['delivery_type'] == 'delivery' ){ echo 'block;'; }else{ echo 'none;'; } ?>">
					<div class="input">
						<input 	class="shipto" 
								type="radio" 
								checked="checked" 
								name="shipto" 
								value="shiptomybillingaddress" /> Ship to my Billing Address
					</div>
					<div class="h_clearboth"></div>
					<div class="input">
						<input 	class="shipto" 
								type="radio" 
								name="shipto" 
								value="shiptodifferentaddress" /> Ship to Different Address
					</div>
					<div class="h_clearboth"></div>
					<div class="item" id="add-different-address" style="display: none;">
						different address <br />
						different address <br />
						different address <br />
					</div>
					<script type="text/javascript">
						$('input[name="shipto"]').change(function(){
							var shipto = $(this).val();
							
							if( shipto == 'shiptodifferentaddress'){
								$('#add-different-address').css('display', 'block');
							}else{
								$('#add-different-address').css('display', 'none');
							}
						});
					</script>
				</div>
				<div class="item deliverytype deliverytypepickup" style="display: <?php if( $order_details['delivery_type'] == 'pickup' ){ echo 'block;'; }else{ echo 'none;'; } ?>">
					<div class="input">
						pickup
					</div>
					<div class="h_clearboth"></div>
				</div>
				<script type="text/javascript">
					$('input[name="delivery_type"]').change(function(){
						var deliverytype = $(this).val();
						
						$('.item.deliverytype').css('display', 'none');
						$('.item.deliverytype.deliverytype' + deliverytype).css('display', 'block');
					});
				</script>
			</td></tr>
		</table>
		
		<div class="g_pagelabel">
			<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/edit.png" /></div>
			<div class="g_pagelabel_text">My Payment</div>
		</div>
		
		<table class="g_table zebra">
			<tr><td class="g_widget">
				
				My Payment
				
			</td></tr>
		</table>
		
		<div class="g_pagelabel">
			<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/edit.png" /></div>
			<div class="g_pagelabel_text">My Others</div>
		</div>
		
		<table class="g_table zebra">
			<tr><td class="g_widget">
				
				My Others
				
			</td></tr>
		</table>
	*/ ?>	
		<input type="hidden" value="<?php echo $account_id; ?>" name="account_id" />
		<input type="hidden" value="<?php echo $order_number; ?>" name="order_number" />
	</form>
	<?php /*
	<form id="form_order_done">
		<input type="hidden" value="<?php echo $account_id; ?>" name="account_id" />
		<input type="hidden" value="<?php echo $order_number; ?>" name="order_number" />
	</form>
	*/ ?>
</div>

<script type="text/javascript" language="javascript" src="<?php echo base_url() . '_assets/js/ajaxupload.3.5.js'; ?>"></script>
<script type="text/javascript" language="javascript">
$(function(){
	placeHolder();
	checkSidebarStatus();
	implementDatePicker();
});
<?php /*
$("#btn_order_done").click(function(e){
	displayNotification("message", "Working...");
	$.ajax({
		url: "<?php echo base_url(); ?>admin/ordermanagement/mark_order_as_done",
		type: "POST",
		data: $("#form_order_done").serialize(),
		success: function(response, textStatus, jqXHR){
			setTimeout(function () {
				$("#middle_wrapper").html(response);
				if (typeof history.pushState != 'undefined') { window.history.pushState("object or string", "Title", "<?php echo base_url(); ?>admin/ordermanagement"); }
				displayNotification("success", "Order succesfully marked as done.");
			}, 500);
		},
		error: function(jqXHR, textStatus, errorThrown){
			displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
		}
	});
});
*/ ?>

$("#btn_update_order").click(function(e){
	displayNotification("message", "Working...");
	$.ajax({
		url: "<?php echo base_url(); ?>admin/ordershipping/update_order",
		type: "POST",
		data: $("#form_edit_order").serialize(),
		success: function(response, textStatus, jqXHR){
			setTimeout(function () {
				$("#middle_wrapper").html(response);
				if (typeof history.pushState != 'undefined') { window.history.pushState("object or string", "Title", "<?php echo base_url(); ?>admin/ordershipping"); }
				displayNotification("success", "Order shipping details updated.");
			}, 500);
		},
		error: function(jqXHR, textStatus, errorThrown){
			displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
		}
	});
});

</script>