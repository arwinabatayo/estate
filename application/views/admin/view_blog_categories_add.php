<div id="g_content" class="blogs-wrapper">
	<div id="g_tools">
		<a href="<?php echo base_url(); ?>admin/blogs/categories/<?php echo $property_id; ?>"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/list.png" />Category List</a>
		<a href="javascript: void(0);" id="btn_add_category"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/save.png" />Save Changes</a>
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>

	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/add.png" /></div>
		<div class="g_pagelabel_text">New Category - <?php echo $property_details['property_title']; ?></div>
	</div>
	<table class="g_table zebra">
		<tr>
			<td class="g_widget">		
				<form id="form_add_article" class="g_form">
					<div class="item">
						<div class="label">Title</div>
						<div class="input">
							<input 	class="g_inputtext" 
									type="text" 
									name="cat_name" 
									data-required="1" />					
						</div>
						<div class="h_clearboth"></div>
					</div>					
					<input type="hidden" name="property_id" id="property_id" value="<?php echo $property_id; ?>" />				
					<input type="hidden" name="created" id="created" value="<?php echo date('Y-m-d H:i:s'); ?>" />					
				</form>
			</td>
		</tr>
	</table>
	
</div>

<script type="text/javascript" language="javascript">
$("#btn_add_category").click(function(){
	tinyMCE.triggerSave();
	if (validate_form("form_add_article")) {
		displayNotification("message", "Working...");
		
		$.ajax({
			url: "<?php echo base_url(); ?>admin/blogs/process_add_category",
			type: "POST",
			data: $("#form_add_article").serialize(),
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#middle_wrapper").html(response);
					if (typeof history.pushState != 'undefined') { window.history.pushState("object or string", "Title", "<?php echo base_url(); ?>admin/blogs/categories/<?php echo $property_id; ?>"); }
					displayNotification("success", "New category successfully added.");
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	}
});
</script>