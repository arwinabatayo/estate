<div id="g_content">
	
	<div id="g_tools"> 
		<a href="<?php echo base_url(); ?>admin/templates"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/list.png" />Template List</a>	
		<a href="javascript: void(0);" id="btn_edit_template"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/save.png" />Save Changes</a>	
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/edit.png" /></div>
		<div class="g_pagelabel_text">Edit template - <?php echo $template_details['title']; ?></div>
	</div>
	
	<table class="g_table zebra">
		<tr><td class="g_widget">
		
			<form id="form_edit_template" class="g_form">
				
				<!-- title -->
				<div class="item">
					<div class="label">Title</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="title" 
								value="<?php echo $template_details['title']; ?>" 
								maxlength="32"
								data-alphanum="1"	
								data-orig-val="<?php echo $template_details['title']; ?>"						
								data-unique="1"
								data-field="title"
								data-table="templates"
								data-required="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- template_type -->
				<div class="item">
					<div class="label">Template Type</div>
					<div class="input">
						<select class="g_select" name="template_type" data-required="1">
							<?php if ($template_types) { ?>
							<?php foreach ($template_types as $template_type => $tt) { ?>
								<option data-required="1" 
										value="<?php echo $tt['template_type_id']; ?>" 
										<?php if ($template_details['template_type_id'] == $tt['template_type_id']) { echo "selected='selected'"; } ?>>
										<?php echo $tt['template_type_title']; ?>
								</option>
							<?php } ?>
							<?php } ?>
						</select>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- description -->
				<div class="item">
					<div class="label">Description</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="description" 
								maxlength="2048"
								value="<?php echo $template_details['description']; ?>" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- responsive -->
				<div class="item">
					<div class="label">Responsive</div>
					<div class="input">
						<select class="g_select" name="responsive">
							<option value="no">No</option>
							<option <?php echo ($template_details['responsive'] == 1) ? "selected='selected'" : ""; ?> value="yes">Yes</option>
						</select>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<input type="hidden" name="template_id" id="template_id" value="<?php echo $template_details['template_id']; ?>" />
				<input type="hidden" name="orig_folder_name" value="<?php echo $template_details['folder']; ?>" />
			
			</form>
		
		</td></tr>
	</table>

</div>

<script type="text/javascript" language="javascript">
$(function(){
	placeHolder();
	checkSidebarStatus();
});

$("#btn_edit_template").click(function(e){
	displayNotification("message", "Working...");
	if (validate_form("form_edit_template")) {
		$.ajax({
			url: "<?php echo base_url(); ?>admin/templates/process_edit",
			type: "POST",
			data: $("#form_edit_template").serialize(),
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#middle_wrapper").html(response);
					displayNotification("success", "Changes to the template saved.");
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	}
});
</script>