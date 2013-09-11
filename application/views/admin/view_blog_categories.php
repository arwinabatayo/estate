<div id="g_content" class="blogs-wrapper">
	<div id="g_tools">
		<a href="<?php echo base_url(); ?>admin/blogs/add_category/<?php echo $property_id; ?>"><img src="<?php echo base_url(); ?>_assets/images/tools/add.png" />Add Category</a>
		<a href="<?php echo base_url(); ?>admin/blogs/blog_list/<?php echo $property_id; ?>"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/list.png" />Article List</a>
		<a href="<?php echo base_url(); ?>admin/blogs/comments/<?php echo $property_id; ?>"><img src="<?php echo base_url(); ?>_assets/images/tools/comments.png" />Comments</a>
		<a href="<?php echo base_url(); ?>admin/properties/edit/<?php echo $property_id; ?>"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/settings.png" />Blog Settings</a>		
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>

	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/generic.png" /></div>
		<div class="g_pagelabel_text">Categories - <?php echo $property_details['property_title']; ?></div>
	</div>
	<table class="g_table zebra">
		<tr>
			<th style="min-width: 120px;">Title</th>
			<th></th>
		</tr>
		<?php if ($blog_cat) { ?>
			<?php krsort($blog_cat); ?>
			<?php foreach ($blog_cat as $cat => $c) { ?>
				<tr>
					<td><?php echo $c['cat_name']; ?></td>
					<!-- actions -->
					<td width="38" align="right">
						<?php if ( $c['c_id']  != 1 ) { ?>
						<a 	href="<?php echo base_url(); ?>admin/blogs/edit_category/<?php echo $property_id; ?>/<?php echo $c['cat_id']; ?>"
							class="g_tableicon"
							title="Edit Article">
							<img src="<?php echo base_url(); ?>_assets/images/global_icon_edit.png" />
						</a>
						<a 	href="javascript:void(0);" 
							class="btn_delete_category g_tableicon" 
							title="Delete Article"
							data-cat-id="<?php echo $c['cat_id']; ?>" 
							data-property-id="<?php echo $property_id; ?>" 
							data-property-folder="<?php echo $folder_name; ?>"
							data-current-page="<?php echo $current_page; ?>" >
							<img src="<?php echo base_url(); ?>_assets/images/global_icon_delete.png" />
						</a>
						<div class="h_clearboth"></div>
						<?php } ?>
					</td>
				</tr>				

			<?php } ?>
			
		<?php } else { ?> 
		
			<tr><td colspan="7" class="h_padding20"><div class="g_nodata"><div class="icon"></div>No data to display</div></td></tr>
			
		<?php } ?>
	
	</table>
	
	<?php echo $pagination; ?>
	
</div>

<script type="text/javascript" language="javascript">
$(function(){
	zebraTable();
	checkSidebarStatus();
});

$(".btn_delete_category").click(function(){
	var cat_id = $(this).attr('data-cat-id');
	var property_id = $(this).attr('data-property-id');
	var folder_name = $(this).attr('data-property-folder');
	var current_page = $(this).attr('data-current-page');
	
	if (confirm("Are you sure you want to delete this category?")) {
		displayNotification("message", "Working...")
		$.ajax({
			url: "<?php echo base_url(); ?>admin/blogs/process_delete_category",
			type: "POST",
			data: "cat_id="+cat_id+"&property_id="+property_id+"&folder_name="+folder_name+"&current_page="+current_page+"&"+$("#form_pagination").serialize(),
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#middle_wrapper").html(response);
					displayNotification("success", "Category successfully deleted.");
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	}
});

// filter properties
$("#btn_filter_article").click(function(){
	$("#g_filter").fadeToggle();
});
</script>