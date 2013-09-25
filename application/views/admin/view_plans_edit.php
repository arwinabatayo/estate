<div id="g_content">
	<div id="g_tools"> 
		<a href="<?php echo base_url(); ?>admin/plans"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/list.png" />plans List</a>	
		<a href="javascript: void(0);" id="btn_edit_plan"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/save.png" />Save Changes</a>	
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>
	<div class="g_spacer"></div>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/add.png" /></div>
		<div class="g_pagelabel_text">Edit plan - <?php echo $plans_details['_title']; ?></div>
	</div>
	
	<table class="g_table zebra">
		<tr><td class="g_widget">
		
			<form id="form_edit_plan" class="g_form">
				
				<!-- plan title -->
				<div class="item">
					<div class="label">Title *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="title" 
								maxlength="100"
								value="<?php echo $plans_details['_title']; ?>"
								data-orig-val="<?php echo $plans_details['_title']; ?>"
								data-alphanum="1"				
								data-unique="1"
								data-field="title"
								data-table="estate_plan_bundle"
								data-required="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- cid -->
				<div class="item">
					<div class="label">CID *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="cid" 
								maxlength="11"
								value="<?php echo $plans_details['_cid']; ?>"
								data-is-whole-number="1"
								data-required="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- plan description -->
				<div class="item">
					<div class="label">Description</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="description" 
								maxlength="500"
								value="<?php echo $plans_details['_description']; ?>"
								data-alphanum="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- plan long description -->
				<div class="item">
					<div class="label">Long Description</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="long_desc" 
								maxlength="500"
								value="<?php echo $plans_details['_longdesc']; ?>"
								data-alphanum="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- plan amount -->
				<div class="item">
					<div class="label">Amount *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="amount" 
								maxlength="11"
								value="<?php echo $plans_details['_amount']; ?>"
								data-is-whole-number="1"
								data-required="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- status -->
				<div class="item">
					<div class="label">Status *</div>
					<div class="input">
						<select class="g_select" name="status" data-required="1">
							<option value="0">Select status</option>
							<option value="disabled" <?php if( isset($plans_details['_status']) && $plans_details['_status'] == 0 ){ echo 'selected="selected"'; } ?>>Disabled</option>
							<option value="enabled" <?php if( isset($plans_details['_status']) && $plans_details['_status'] == 1 ){ echo 'selected="selected"'; } ?>>Enabled</option>
						</select>
					</div>
					<div class="h_clearboth"></div>
				</div>
				<!-- plan peso value -->
				<div class="item">
					<div class="label">Max Gadget Peso value *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="max_peso_value" 
								maxlength="11"
								value="<?php echo $plans_details['_max_peso_value']; ?>"
								data-is-whole-number="1"
								data-required="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				
				<!-- plan peso value -->
				<div class="item">
					<div class="label">Peso value *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="peso_value" 
								maxlength="11"
								value="<?php echo $plans_details['_peso_value']; ?>"
								data-is-whole-number="1"
								data-required="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- image -->
				<div class="item">
					<div class="label">Image *</div>
					<div class="input">
						<div class="combo_image" id="combo_image_wrapper_wrapper">
							<div id="combo_image_wrapper">
								<?php if( isset($combo_details['accessories_image']) && trim($combo_details['accessories_image']) != '' ){ ?>
									<input type="hidden" value="<?php echo $combo_details['accessories_image']; ?>" data-image-required="1" data-image-wrapper="combo_image_wrapper_wrapper" name="accessory-image-name" id="accessory-image-name" />
									<img src="<?php echo base_url() . $this->config->item('base_combo_url') . trim($combo_details['accessories_image']); ?>" title="<?php echo trim($combo_details['accessories_image']); ?>" alt="<?php echo trim($combo_details['accessories_image']); ?>" class="img_combo_image" />
								<?php }else{ ?>
									<input type="hidden" value="" data-image-required="1" data-image-wrapper="combo_image_wrapper_wrapper" name="accessory-image-name" id="accessory-image-name" />
								<?php } ?>
							</div>
							<a id="change_combo_image">Upload image</a><div id="upload_result"></div>						
						</div>
						<div class="clearboth"></div>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<input type="hidden" value="<?php echo $plan_id; ?>" name="plan_id" id="plan_id" />
				
			</form>
			
		</td></tr>
	</table>
</div>

<script type="text/javascript" language="javascript" src="<?php echo base_url() . '_assets/js/ajaxupload.3.5.js'; ?>"></script>
<script type="text/javascript" language="javascript">
$("#btn_edit_plan").click(function(e){
	displayNotification("message", "Working...");
	if (validate_form("form_edit_plan")) {
		$.ajax({
			url: "<?php echo base_url(); ?>admin/plans/process_edit",
			type: "POST",
			data: $("#form_edit_plan").serialize(),
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#middle_wrapper").html(response);
					if (typeof history.pushState != 'undefined') { window.history.pushState("object or string", "Title", "<?php echo base_url(); ?>admin/plans"); }
					displayNotification("success", "plan successfully updated.");
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				alert('x');
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	}
});

</script>