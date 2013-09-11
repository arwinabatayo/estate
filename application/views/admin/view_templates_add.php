<div id="g_content">

	<div id="g_tools"> 
		<a href="<?php echo base_url(); ?>admin/templates"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/list.png" />Template List</a>	
		<a href="javascript: void(0);" id="btn_add_template"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/save.png" />Save Changes</a>	
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>

	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/add.png" /></div>
		<div class="g_pagelabel_text">Add template</div>
	</div>
	
	<table class="g_table">
		<tr><td class="g_widget">
		
			<form id="form_add_template" class="g_form">
				
				<!-- title -->
				<div class="item">
					<div class="label">Title</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="title" 
								maxlength="32"
								data-alphanum="1"				
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
							<option value="0" selected="selected">Select platform</option>
							<?php if ($template_types) { ?>
							<?php foreach ($template_types as $template_type => $tt) { ?>
								<?php if( $tt['template_type_id'] == 6 ){ ?>
									<option data-required="1" 
											value="<?php echo $tt['template_type_id']; ?>">
											<?php echo $tt['template_type_title']; ?>
									</option>
								<?php } ?>
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
								maxlength="512" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- responsive -->
				<div class="item">
					<div class="label">Responsive</div>
					<div class="input">
						<select class="g_select" name="responsive">
							<option value="no">No</option>
							<option value="yes">Yes</option>
						</select>
					</div>
					<div class="h_clearboth"></div>
				</div>
			
			</form>
			
		</td></tr>
	</table>

</div>

<script type="text/javascript" language="javascript">
$(function(){
	placeHolder();
	zebraTable();
	checkSidebarStatus();
});

$("#btn_add_template").click(function(e){
	displayNotification("message", "Working...");
	if (validate_form("form_add_template")) {
		$.ajax({
			url: "<?php echo base_url(); ?>admin/templates/process_add",
			type: "POST",
			data: $("#form_add_template").serialize(),
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#middle_wrapper").html(response);
					if (typeof history.pushState != 'undefined') { window.history.pushState("object or string", "Title", "<?php echo base_url(); ?>admin/templates"); }
					displayNotification("success", "New template successfully added.");
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	}
});
</script>