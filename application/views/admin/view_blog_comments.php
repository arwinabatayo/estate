<div id="g_content" class="blogs-wrapper">
	<div id="g_tools">
		<a href="<?php echo base_url(); ?>admin/blogs/blog_list/<?php echo $property_id; ?>"><img src="<?php echo base_url(); ?>_assets/images/tools/list.png" />Article List</a>
		<a href="<?php echo base_url(); ?>admin/blogs/categories/<?php echo $property_id; ?>"><img src="<?php echo base_url(); ?>_assets/images/tools/categories.png" />Category List</a>
		<a href="<?php echo base_url(); ?>admin/properties/edit/<?php echo $property_id; ?>"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/settings.png" />Blog Settings</a>		
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>

	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/generic.png" /></div>
		<div class="g_pagelabel_text">Comments - <?php echo $property_details['property_title']; ?></div>
	</div>
	<?php if ($blog_comment) { ?>
		<table class="g_table zebra">
			<tr>
				<th style="min-width: 120px;">Author</th>
				<th style="min-width: 120px;">Comment</th>
				<th style="min-width: 120px;">In Response To</th>
				<th></th>
			</tr>

			<?php krsort($blog_comment); ?>
			<?php foreach ($blog_comment as $comment => $c) { ?>
				<tr>
					<td><strong><?php echo $c['posted_by']; ?></strong>
						<p class="small"><?php echo $c['email']; ?></p>
					</td>
					<td>
						<p class="small">Posted on 
							<em><strong><?php echo date( "Y/m/d \a\\t\ H:i A",  strtotime( $c['date_comment'] ) );?></strong></em>
						</p>
						<?php echo $c['comment_content']; ?>
					</td>
					<td><?php echo $post_title[$c['p_id']];?> </td>
					<!-- actions -->
					<td width="40" align="right">
						<a 	href="<?php echo base_url(); ?>admin/blogs/edit_comments/<?php echo $property_id; ?>/<?php echo $c['comm_id']; ?>"
							class="g_tableicon"
							title="Edit Comment">
							<img src="<?php echo base_url(); ?>_assets/images/global_icon_edit.png" />
						</a>			
						<a 	href="javascript:void(0);" 
							class="btn_delete_comment g_tableicon" 
							title="Delete Comment"
							data-comm-id="<?php echo $c['comm_id']; ?>" 
							data-property-id="<?php echo $property_id; ?>" 
							data-property-folder="<?php echo $folder_name; ?>"
							data-current-page="<?php echo $current_page; ?>" >
							<img src="<?php echo base_url(); ?>_assets/images/global_icon_delete.png" />
						</a>
						<div class="h_clearboth"></div>
					</td>
				</tr>				

			<?php } ?>
		</table>		
	<?php } else { ?> 
		<table class="g_table">	
			<tr>
				<td colspan="7" class="h_padding20">
					<div class="g_nodata">
						<div class="icon"></div>No data to display</div>
				</td>
			</tr>
		</table>			
	<?php } ?>
	
	<?php echo $pagination; ?>
	
</div>

<script type="text/javascript" language="javascript">
$(function(){
	zebraTable();
});

$(".btn_delete_comment").click(function(){
	var comm_id = $(this).attr('data-comm-id');
	var property_id = $(this).attr('data-property-id');
	var folder_name = $(this).attr('data-property-folder');
	var current_page = $(this).attr('data-current-page');
	
	if (confirm("Are you sure you want to delete this comment?")) {
		displayNotification("message", "Working...")
		$.ajax({
			url: "<?php echo base_url(); ?>admin/blogs/process_delete_comment",
			type: "POST",
			data: "comm_id="+comm_id+"&property_id="+property_id+"&folder_name="+folder_name+"&current_page="+current_page+"&"+$("#form_pagination").serialize(),
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#middle_wrapper").html(response);
					displayNotification("success", "Comment successfully deleted.");
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	}
});

</script>