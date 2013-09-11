<div id="g_content" class="blogs-wrapper">
	<div id="g_tools">
		<a href="<?php echo base_url(); ?>admin/blogs/comments/<?php echo $property_id; ?>"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/comments.png" />Comments</a>
		<a href="javascript: void(0);" id="btn_edit_comment"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/save.png" />Save Changes</a>
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>

	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/edit.png" /></div>
		<div class="g_pagelabel_text">Edit Comment - <?php echo $property_details['property_title']; ?></div>
	</div>
	<table class="g_table zebra">
		<tr>
			<td class="g_widget">		
				<form id="form_edit_comment" class="g_form">
					<div class="item">
						<div class="label">Article</div>
						<div class="input">
							<input 	class="g_inputtext h_backgroundlight" 
									type="text" 
									name="name"
									readonly="readonly"
									value="<?php echo $post_title; ?>"
									data-required="1" />					
						</div>
						<div class="h_clearboth"></div>
					</div>					
					<div class="item">
						<div class="label">Posted by</div>
						<div class="input">
							<input 	class="g_inputtext" 
									type="text" 
									name="name" 
									value="<?php echo $posted_by; ?>"
									data-required="1" />					
						</div>
						<div class="h_clearboth"></div>
					</div>					
					<div class="item">
						<div class="label">Email</div>
						<div class="input">
							<input 	class="g_inputtext" 
									type="text" 
									name="email" 
									value="<?php echo $email; ?>"
									data-required="1" />					
						</div>
						<div class="h_clearboth"></div>
					</div>	
					<div class="item">
						<div class="label">Comment</div>
						<div class="input">
							<textarea 	style="width: 496px; margin: 0px;" 
										data-minlength="1" 
										data-required="1" 
										id="post-comment" 
										rows="8" 
										name="comment"><?php echo trim($comment_content); ?></textarea>					
						</div>
						<div class="h_clearboth"></div>
					</div>	
					<input type="hidden" name="property_id" id="property_id" value="<?php echo $property_id; ?>" />					
					<input type="hidden" name="comm_id" id="comm_id" value="<?php echo $comm_id; ?>" />									
					<input type="hidden" name="updated" id="updated" value="<?php echo date('Y-m-d H:i:s'); ?>" />					
				</form>
			</td>
		</tr>
	</table>
	
</div>

<script type="text/javascript" language="javascript">

$("#btn_edit_comment").click(function(){
	if (validate_form("form_edit_comment")) {
		displayNotification("message", "Working...");
		
		$.ajax({
			url: "<?php echo base_url(); ?>admin/blogs/process_edit_comment",
			type: "POST",
			data: $("#form_edit_comment").serialize(),
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#middle_wrapper").html(response);
					// if (typeof history.pushState != 'undefined') { window.history.pushState("object or string", "Title", "<?php echo base_url(); ?>admin/blogs/comments/<?php echo $property_id; ?>"); }
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