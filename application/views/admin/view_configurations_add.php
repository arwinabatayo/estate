<div id="g_content">

	<div id="g_tools"> 
		<a href="<?php echo base_url(); ?>admin/configurations/property/<?php echo $property_id; ?>"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/list.png" />Configurations List</a>	
		<a href="javascript: void(0);" id="btn_add_configuration"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/save.png" />Save Changes</a>	
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>
	<div class="g_spacer"></div>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/add.png" /></div>
		<div class="g_pagelabel_text">Add configuration</div>
	</div>
	
	<table class="g_table zebra">
		<tr><td class="g_widget">
		
			<form id="form_add_configuration" class="g_form">
				
				<!-- label -->
				<div class="item">
					<div class="label">Label *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="label" 
								maxlength="255"
								data-alphanum="1"				
								data-unique="1"
								data-field="label"
								data-table="configurations"
								data-required="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- status -->
				<div class="item">
					<div class="label">Status *</div>
					<div class="input">
						<select class="g_select" name="status" data-required="1">
							<option value="0" selected="selected">Select status</option>
							<option value="1">Disabled</option>
							<option value="2">Enabled</option>
						</select>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<input type="hidden" name="property_id" value="<?php echo $property_id; ?>" id="property_id">
			</form>
			
		</td></tr>
	</table>

</div>

<script type="text/javascript" language="javascript">
$(function(){
	placeHolder();
	checkSidebarStatus();
});

$("#btn_add_configuration").click(function(e){
	displayNotification("message", "Working...");
	if (validate_form("form_add_configuration")) {
		$.ajax({
			url: "<?php echo base_url(); ?>admin/configurations/process_add",
			type: "POST",
			data: $("#form_add_configuration").serialize(),
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#middle_wrapper").html(response);
					var property_id = <?php echo $property_id; ?>;
					if (typeof history.pushState != 'undefined') { window.history.pushState("object or string", "Title", "<?php echo base_url(); ?>admin/configurations/property/"+property_id); }
					displayNotification("success", "New configuration successfully added.");
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	}
});
</script>