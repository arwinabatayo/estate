<div id="g_content" class="blogs-wrapper">
	<div id="g_tools">
		<a href="<?php echo base_url(); ?>admin/blogs/summary/<?php echo $property_id; ?>""><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/blog.png" />Blog Summary</a>
		<a href="<?php echo base_url(); ?>admin/blogs/add/<?php echo $property_id; ?>"><img src="<?php echo base_url(); ?>_assets/images/tools/add.png" />Add Article</a>
		<a href="<?php echo base_url(); ?>admin/blogs/categories/<?php echo $property_id; ?>"><img src="<?php echo base_url(); ?>_assets/images/tools/categories.png" />Category List</a>
		<a href="<?php echo base_url(); ?>admin/blogs/comments/<?php echo $property_id; ?>"><img src="<?php echo base_url(); ?>_assets/images/tools/comments.png" />Comments</a>
		<a href="<?php echo base_url(); ?>admin/properties/manage_assets/<?php echo $property_id; ?>"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/assets.png" />Manage Assets</a>
		<a href="<?php echo base_url(); ?>preview/<?php echo $template_type_id; ?>/<?php echo $folder_name; ?>" target="_blank"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/preview.png" />Preview</a>		
		<a href="<?php echo base_url(); ?>admin/properties/edit/<?php echo $property_id; ?>"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/settings.png" />Blog Settings</a>		
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/generic.png" /></div>
		<div class="g_pagelabel_text">Articles - <?php echo $property_details['property_title']; ?></div>
	</div>
	
	<?php if ($blog_posts) { ?>
		<table class="g_table zebra">
			<tr>
				<th>Title</th>
				<th>Category</th>
				<th>Created by</th>
				<th>Status</th>
				<th width="116">Publish Date</th>
				<th width="116">Last Edited</th>
				<th></th>
			</tr>
			<?php krsort($blog_posts); ?>
			<?php foreach ($blog_posts as $blog => $b) { ?>
				<tr class="row_article">
					<td><?php echo $b['title']; ?></td>
					<td><?php echo $b['category']; ?></td>
					<td><?php echo $b['author_name']; ?></td>
					<td class="article_status"><?php echo ($b['status'] == 1) ? "Published": "Unpublished"; ?></td>
					<td><?php echo $b['published']; ?></td>
					<td><?php echo $b['updated']; ?></td>
					
					<!-- actions -->
					<td width="60" align="right">
						<a 	href="<?php echo base_url(); ?>admin/blogs/edit/<?php echo $property_id; ?>/<?php echo $b['id']; ?>"
							class="g_tableicon"
							title="Edit Article">
							<img src="<?php echo base_url(); ?>_assets/images/global_icon_edit.png" />
						</a>	
						<a 	href="<?php echo base_url(); ?>admin/blogs/comments/<?php echo $property_id; ?>/<?php echo $b['id']; ?>"
							class="g_tableicon"
							style="position: relative;"
							title="Article Comments">
							<img src="<?php echo base_url(); ?>_assets/images/global_icon_comment.png" />
							<?php if (count($b['comments']) > 0) { ?> <span class="comment_count"><?php echo count($b['comments']); ?></span> <?php } ?>
						</a>	
						<a 	href="javascript:void(0);" 
							class="btn_delete_post g_tableicon" 
							title="Delete Article"
							data-post-id="<?php echo $b['id']; ?>" 
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
				<td colspan="7" class="h_padding20 g_nodata">
					<div class="g_nodata">
						<div class="icon"></div>No data to display
					</div>
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

$(".btn_delete_post").click(function(){
	var post_id = $(this).attr('data-post-id');
	var property_id = $(this).attr('data-property-id');
	var folder_name = $(this).attr('data-property-folder');
	var current_page = $(this).attr('data-current-page');
	
	if (confirm("Are you sure you want to delete this article?")) {
		displayNotification("message", "Working...")
		$.ajax({
			url: "<?php echo base_url(); ?>admin/blogs/process_delete",
			type: "POST",
			data: "post_id="+post_id+"&property_id="+property_id+"&folder_name="+folder_name+"&current_page="+current_page+"&"+$("#form_pagination").serialize(),
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#middle_wrapper").html(response);
					displayNotification("success", "Article deleted.");
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	}
});

// mark unpublished rows
$(".row_article td.article_status").each(function(){
	if ($(this).html() == "Unpublished") { 
		$(this).parent("tr").children("td").addClass('h_backgrounddark'); 
		$(this).parent("tr").children("td").addClass('h_fontcolorsemilight'); 
	}
});
</script>