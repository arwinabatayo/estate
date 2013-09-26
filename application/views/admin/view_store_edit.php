<div id="g_content">

	<div id="g_tools"> 
		<a href="<?php echo base_url(); ?>admin/store"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/list.png" />Store List</a>	
		<a href="javascript: void(0);" id="btn_edit_pickup"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/save.png" />Save Changes</a>	
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>
	<div class="g_spacer"></div>

	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/add.png" /></div>
		<div class="g_pagelabel_text">Edit store</div>
	</div>
	
	<table class="g_table zebra">
		<tr><td class="g_widget">
		
			<form id="form_edit_store" class="g_form">
				<!-- Store Name -->
				<div class="item">
                                        <input 	type="hidden" name="store_id" value="<?php echo $store_details['id']; ?>" />
					<div class="label">Store Name *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="store_name" 
								maxlength="100"
								data-field="name"
								data-required="1" 
                                                                value="<?php echo $store_details['name']; ?>"/>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- Postal Code -->
				<div class="item">
					<div class="label">Postal Code *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="postal_code" 
								maxlength="100"
								data-required="1" 
                                                                value="<?php echo $store_details['postal_code']; ?>"/>
					</div>
					<div class="h_clearboth"></div>
				</div>
                                
                                <!-- Province -->
				<div class="item">
					<div class="label">Province *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="province" 
								maxlength="100"
								data-required="1" 
                                                                value="<?php echo $store_details['province']; ?>"/>
					</div>
					<div class="h_clearboth"></div>
				</div>
                                <!-- City -->
				<div class="item">
					<div class="label">City *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="city" 
								maxlength="100"
								data-required="1" 
                                                                value="<?php echo $store_details['city']; ?>"/>
					</div>
					<div class="h_clearboth"></div>
				</div>
                                <!-- Municipality -->
				<div class="item">
					<div class="label">Municipality</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="municipality" 
								maxlength="100"
								value="<?php echo $store_details['municipality']; ?>"/>
					</div>
					<div class="h_clearboth"></div>
				</div>
                                <!-- Barangay -->
				<div class="item">
					<div class="label">Barangay</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="barangay" 
								maxlength="100"
								value="<?php echo $store_details['barangay']; ?>"/>
					</div>
					<div class="h_clearboth"></div>
				</div>
                                <!-- Street -->
				<div class="item">
					<div class="label">Street</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="street" 
								maxlength="100"
								value="<?php echo $store_details['street']; ?>"/>
					</div>
					<div class="h_clearboth"></div>
				</div>
                                <!-- Subdivision -->
				<div class="item">
					<div class="label">Subdivision</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="subdivision" 
								maxlength="100"
								value="<?php echo $store_details['subdivision']; ?>"/>
					</div>
					<div class="h_clearboth"></div>
				</div>
                                <div class="item">
					<div class="label">Status</div>
                                        <div class="input">
                                                <select class="g_select h_width100px" name="status">
                                                    <option value="1" value="1" <?php if($store_details['status'] == 1) { ?>selected="selected"<?php } ?>>Active</option>
                                                    <option value="0"  <?php if($store_details['status'] == 0) { ?>selected="selected"<?php } ?>>Inactive</option>					
                                                </select>
                                        </div>
                                </div>
			</form>
			
		</td></tr>
	</table>
</div>

<script type="text/javascript" language="javascript" src="<?php echo base_url() . '_assets/js/ajaxupload.3.5.js'; ?>"></script>
<script type="text/javascript" language="javascript">


$("#btn_edit_pickup").click(function(e){
	displayNotification("message", "Working...");
	if (validate_form("form_edit_store")) {
		$.ajax({
			url: "<?php echo base_url(); ?>admin/store/process_edit",
			type: "POST",
			data: $("#form_edit_store").serialize(),
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#middle_wrapper").html(response);
					if (typeof history.pushState != 'undefined') { window.history.pushState("object or string", "Store Name", "<?php echo base_url(); ?>admin/store"); }
					displayNotification("success", "Store successfully updated.");
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				//alert('x');
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	}
});

</script>