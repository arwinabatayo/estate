<div id="g_content" class="blogs-wrapper">
	<div id="g_tools">
		<a href="<?php echo base_url(); ?>admin/blogs/categories/<?php echo $property_id; ?>">
			<img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/list.png" />Category List
		</a>
		<a href="javascript: void(0);" id="btn_edit_category"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/save.png" />Save Changes</a>
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>

	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/edit.png" /></div>
		<div class="g_pagelabel_text">Edit Category - <?php echo $property_details['property_title']; ?></div>
	</div>
	<table class="g_table zebra">
		<tr>
			<td class="g_widget">		
				<form id="form_edit_category" class="g_form">
					<div class="item">
						<div class="label">Title</div>
						<div class="input">
							<input 	class="g_inputtext" 
									type="text" 
									name="cat_name" 
									value="<?php echo $cat_name; ?>"
									data-required="1" />					
						</div>
						<div class="h_clearboth"></div>
					</div>					

					<input type="hidden" name="property_id" id="property_id" value="<?php echo $property_id; ?>" />					
					<input type="hidden" name="cat_id" id="cat_id" value="<?php echo $cat_id; ?>" />									
					<input type="hidden" name="updated" id="updated" value="<?php echo date('Y-m-d H:i:s'); ?>" />	
					<input type="hidden" name="created" id="created" value="<?php echo $created; ?>" />						
				</form>
			</td>
		</tr>
	</table>
	
</div>

<script type="text/javascript" language="javascript">

$("#btn_edit_category").click(function(){
	if (validate_form("form_edit_category")) {
		displayNotification("message", "Working...");
		
		$.ajax({
			url: "<?php echo base_url(); ?>admin/blogs/process_edit_category",
			type: "POST",
			data: $("#form_edit_category").serialize(),
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#middle_wrapper").html(response);
					// if (typeof history.pushState != 'undefined') { window.history.pushState("object or string", "Title", "<?php echo base_url(); ?>admin/blogs/categories/<?php echo $property_id; ?>"); }
					displayNotification("success", "Changes saved.");
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	}
});
</script>