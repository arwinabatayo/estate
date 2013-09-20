<div id="g_content">
	<div id="g_tools"> 
		<a href="<?php echo base_url(); ?>admin/combos"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/list.png" />Combo List</a>	
		<a href="javascript: void(0);" id="btn_edit_combos"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/save.png" />Save Changes</a>	
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>
	<div class="g_spacer"></div>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/add.png" /></div>
		<div class="g_pagelabel_text">Edit combo - <?php echo $combos_details['_name']; ?></div>
	</div>
	
	<table class="g_table zebra">
		<tr><td class="g_widget">
		
			<form id="form_edit_combo" class="g_form">
				
				<!-- combo title -->
				<div class="item">
					<div class="label">Name *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="name" 
								value="<?php echo $combos_details['_name']; ?>"
								data-orig-val="<?php echo $combos_details['_name']; ?>"
								data-field="name"
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
								value="<?php echo $combos_details['_cid']; ?>"
								data-is-whole-number="1"
								data-required="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- combo description -->
				<div class="item">
					<div class="label">Description</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="description" 
								value="<?php echo $combos_details['_description']; ?>"
								 />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- combo long description -->
				<div class="item">
					<div class="label">Long Description</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="long_description" 
								value="<?php echo $combos_details['_long_desc']; ?>"
								 />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- combo amount -->
				<div class="item">
					<div class="label">Peso Value *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="peso_value" 
								value="<?php echo $combos_details['_peso_value']; ?>"
								data-is-whole-number="1"
								data-required="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- status -->
				<div class="item">
					<div class="label">Status *</div>
					<div class="input">
						<select class="g_select" name="is_active" data-required="0">
							<option value="">Select status</option>
							<option value="0" <?php if( isset($combos_details['_status']) && $combos_details['_status'] == 0 ){ echo 'selected="selected"'; } ?>>Disabled</option>
							<option value="1" <?php if( isset($combos_details['_status']) && $combos_details['_status'] == 1 ){ echo 'selected="selected"'; } ?>>Enabled</option>
						</select>
					</div>
					<div class="h_clearboth"></div>
				</div>
				<input type="hidden" value="<?php echo $combos_id; ?>" name="id" id="id" />
			</form>
			
		</td></tr>
	</table>
</div>

<script type="text/javascript" language="javascript" src="<?php echo base_url() . '_assets/js/ajaxupload.3.5.js'; ?>"></script>
<script type="text/javascript" language="javascript">
$(function(){
	placeHolder();
	checkSidebarStatus();
	
	$("#btn_edit_combos").click(function(e){
		displayNotification("message", "Working...");
		if (validate_form("form_edit_combo")) {
			$.ajax({
				url: "<?php echo base_url(); ?>admin/combos/process_edit",
				type: "POST",
				data: $("#form_edit_combo").serialize(),
				success: function(response, textStatus, jqXHR){
					setTimeout(function () {
						$("#middle_wrapper").html(response);
						if (typeof history.pushState != 'undefined') { window.history.pushState("object or string", "Title", "<?php echo base_url(); ?>admin/combos"); }
						displayNotification("success", "Combo successfully updated.");
					}, 500);
				},
				error: function(jqXHR, textStatus, errorThrown){
					alert('x');
					displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
				}
			});
		}
	});
});



</script>