<div id="g_content">

	<div id="g_tools"> 
		<a href="<?php echo base_url(); ?>admin/packageplans"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/list.png" />Package Plans List</a>	
		<a href="javascript: void(0);" id="btn_edit_packageplan"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/save.png" />Save Changes</a>	
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>
	<div class="g_spacer"></div>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/add.png" /></div>
		<div class="g_pagelabel_text">Edit package plan - <?php echo $plan_details['title']; ?></div>
	</div>
	
	<table class="g_table zebra">
		<tr><td class="g_widget">
		
			<form id="form_edit_packageplan" class="g_form">
				<div class="item">
					<div class="label">TEXT *</div>
					<div class="input">
						<table class="">
							<?php foreach($text_arr as $key_text => $value_text){ ?>
								<tr>
									<td>
										<input 	class="g_inputtext" 
										type="checkbox" 
										name="combo_text[]" 
										maxlength="100"
										value="<?php echo $text_arr[$key_text]['id']; ?>"
										data-orig-val="<?php echo $text_arr[$key_text]['selected']; ?>"
										data-alphanum="1"				
										data-unique="1"
										data-field="title"
										data-table="estate_package_plans"
										<?php echo ($text_arr[$key_text]['selected']) ? "checked" : ""; ?>  />
									</td>
									<td>	
										<?php echo trim($text_arr[$key_text]['name']); ?>
									</td>
								</tr>
							<?php } ?>
						</table>
					</div>
					<div class="h_clearboth"></div>
				</div>

				<div class="item">
					<div class="label">CALL *</div>
					<div class="input">
						<table>
							<?php foreach($call_arr as $key_call => $value_call){ ?>
								<tr>
									<td>
										<input 	class="g_inputtext" 
										type="checkbox" 
										name="combo_call[]" 
										maxlength="100"
										value="<?php echo $call_arr[$key_call]['id']; ?>"
										data-orig-val="<?php echo $call_arr[$key_call]['selected']; ?>"
										data-alphanum="1"				
										data-unique="1"
										data-field="title"
										data-table="estate_package_plans"
										<?php echo ($call_arr[$key_call]['selected']) ? "checked" : ""; ?>  />
									</td>
									<td>	
										<?php echo trim($call_arr[$key_call]['name']); ?>
									</td>
								</tr>
							<?php } ?>
						</table>
					</div>
					<div class="h_clearboth"></div>
				</div>

				<div class="item">
					<div class="label">SURF *</div>
					<div class="input">
						<table>
							<?php foreach($surf_arr as $key_surf => $value_surf){ ?>
								<tr>
									<td>
										<input 	class="g_inputtext" 
										type="checkbox" 
										name="combo_surf[]" 
										maxlength="100"
										value="<?php echo $surf_arr[$key_surf]['id']; ?>"
										data-orig-val="<?php echo $surf_arr[$key_surf]['selected']; ?>"
										data-alphanum="1"				
										data-unique="1"
										data-field="title"
										data-table="estate_package_plans"
										<?php echo ($surf_arr[$key_surf]['selected']) ? "checked" : ""; ?>  />
									</td>
									<td>	
										<?php echo trim($surf_arr[$key_surf]['name']); ?>
									</td>
								</tr>
							<?php } ?>
						</table>
					</div>
					<div class="h_clearboth"></div>
				</div>

				<div class="item">
					<div class="label">IDD *</div>
					<div class="input">
						<table>
							<?php foreach($idd_arr as $key_idd => $value_idd){ ?>
								<tr>
									<td>
										<input 	class="g_inputtext" 
										type="checkbox" 
										name="combo_idd[]" 
										maxlength="100"
										value="<?php echo $idd_arr[$key_idd]['id']; ?>"
										data-orig-val="<?php echo $idd_arr[$key_idd]['selected']; ?>"
										data-alphanum="1"				
										data-unique="1"
										data-field="title"
										data-table="estate_package_plans"
										<?php echo ($idd_arr[$key_idd]['selected']) ? "checked" : ""; ?>  />
									</td>
									<td>	
										<?php echo trim($idd_arr[$key_idd]['name']); ?>
									</td>
								</tr>
							<?php } ?>
						</table>
					</div>
					<div class="h_clearboth"></div>

					<!-- status -->
					<div class="item">
						<div class="label">Status *</div>
						<div class="input">
							<select class="g_select" name="status" data-required="1">
								<option value="0">Select status</option>
								<option value="disabled" <?php if( isset($active_flag[0]['is_active']) && $active_flag[0]['is_active'] == "0" ){ echo 'selected="selected"'; } ?>>Disabled</option>
								<option value="enabled" <?php if( isset($active_flag[0]['is_active']) && $active_flag[0]['is_active'] == "1" ){ echo 'selected="selected"'; } ?>>Enabled</option>
							</select>
						</div>
						<div class="h_clearboth"></div>
					</div>
				</div>

		
				<input type="hidden" value="<?php echo $plan_id; ?>" name="plan_id" id="plan_id" />
				
			</form>
			
		</td></tr>
	</table>
</div>

<script type="text/javascript" language="javascript" src="<?php echo base_url() . '_assets/js/ajaxupload.3.5.js'; ?>"></script>
<script type="text/javascript" language="javascript">


$("#btn_edit_packageplan").click(function(e){
	displayNotification("message", "Working...");
	//console.log($("#form_edit_packageplan").serialize());
	if (validate_form("form_edit_packageplan")) {
		$.ajax({
			url: "<?php echo base_url(); ?>admin/packageplans/process_edit",
			type: "POST",
			data: $("#form_edit_packageplan").serialize(),
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#middle_wrapper").html(response);
					if (typeof history.pushState != 'undefined') { window.history.pushState("object or string", "Title", "<?php echo base_url(); ?>admin/packageplans"); }
					displayNotification("success", "Accessory successfully updated.");
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