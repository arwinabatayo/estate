<div id="g_content">

	<div id="g_tools">
		<a href="<?php echo base_url(); ?>admin/properties/add"><img src="<?php echo base_url(); ?>_assets/images/tools/add.png" />Add Property</a>
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>
	<div class="g_spacer"></div>
	
	<?php echo $filter; ?>
	
	<div class="g_pagelabel h_width80px h_floatleft">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/generic.png" /></div>
		<div class="g_pagelabel_text">Legend</div>
	</div>
	
	<div id="g_legend">
		<div class="item"><img src="<?php echo base_url();  ?>_assets/images/global_icon_view.png" /> Preview property</div>
		<div class="item"><img src="<?php echo base_url();  ?>_assets/images/global_icon_edit.png" /> Edit property</div>
		<div class="item"><img src="<?php echo base_url();  ?>_assets/images/global_icon_settings.png" /> Manage Configurations</div>
		<div class="item"><img src="<?php echo base_url();  ?>_assets/images/global_icon_assets.png" /> Manage assets</div>
		<div class="item"><img src="<?php echo base_url();  ?>_assets/images/global_icon_blog.png" /> Blog articles</div>
		<div class="item"><img src="<?php echo base_url();  ?>_assets/images/global_icon_delete.png" /> Delete property</div>
	</div>
	
	<div class="h_clearboth"></div>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/properties.png" /></div>
		<div class="g_pagelabel_text">Properties</div>
		<?php echo $pagination; ?>
	</div>
	
	<?php if ($properties) { ?>
	
		<table class="g_table zebra">
		
			<tr>
				<?php if ($sess_user['user_type'] == ROLE_SUPER_ADMIN) { ?><th>Client</th><?php } ?>
				<th>Title</th>
				<th>Template</th>
				<th>Type</th>
				<th colspan="2">Owner</th>
				<th width="116">Last Edited</th>
				<th>Actions</th>
			</tr>
			
			<?php foreach ($properties as $property => $m) { ?>
			<tr>
				<?php if ($sess_user['user_type'] == ROLE_SUPER_ADMIN) { ?><td><?php echo $m['client_title_short']; ?></td><?php } ?>
				<td><?php echo $m['property_title']; ?></td>
				<td><?php echo $m['template_title']; ?></td>
				<td><?php echo $m['template_type_title']; ?></td>
				<td width="32" class="h_padding0">
					<a href="<?php echo base_url(); ?>admin/users/view/<?php echo $m['user_id']; ?>">
					<img class="g_tableavatar" src="<?php echo $m['avatar_path']; ?>?<?php echo time(); ?>" />
					</a>
				</td>
				<td><?php echo $m['username']; ?></td>
				<td width="116"><?php echo $m['property_last_edit']; ?></td>
				
				<!-- actions -->
				<td width="125" align="right">
					<!-- don't show preview on mobile apps -->
					<?php if ($m['template_type_id'] == 4) { ?>
						<a 	href="javascript: void(0);" 
							class="g_tableicon g_tableiconinactive">
							<img src="<?php echo base_url(); ?>_assets/images/global_icon_view_inactive.png" />
						</a>
					<?php } else { ?>
						<a 	href="<?php echo base_url(); ?>preview/<?php echo $m['template_type_id']; ?>/<?php echo $m['folder_name']; ?>" 
							target="_blank"
							class="g_tableicon"
							title="Preview property">
							<img src="<?php echo base_url(); ?>_assets/images/global_icon_view.png" />
						</a>
					<?php } ?>
					<a 	href="<?php echo base_url(); ?>admin/properties/edit/<?php echo $m['property_id']; ?>"
						class="g_tableicon"
						title="Edit property">
						<img src="<?php echo base_url(); ?>_assets/images/global_icon_edit.png" />
					</a>	
					<a 	href="<?php echo base_url(); ?>admin/configurations/property/<?php echo $m['property_id']; ?>"
						class="g_tableicon"
						title="Manage configurations">
						<img src="<?php echo base_url(); ?>_assets/images/global_icon_settings.png" />
					</a>			
					<a 	href="<?php echo base_url(); ?>admin/properties/manage_assets/<?php echo $m['property_id']; ?>"
						class="g_tableicon"
						title="Manage assets">
						<img src="<?php echo base_url(); ?>_assets/images/global_icon_assets.png" />
					</a>
					<?php if ($m['template_type_id'] == 5) { ?>
						<a 	href="<?php echo base_url(); ?>admin/blogs/summary/<?php echo $m['property_id']; ?>"
							class="g_tableicon" 
							title="Blog Articles">
							<img src="<?php echo base_url(); ?>_assets/images/global_icon_blog.png" />
						</a>
					<?php } else { ?>
						<a 	href="javascript: void(0);"
								class="g_tableicon g_tableiconinactive">
							<img src="<?php echo base_url(); ?>_assets/images/global_icon_blog_inactive.png" />
						</a>
					<?php } ?>
					<a 	href="javascript:void(0);" 
						class="btn_delete_property g_tableicon" 
						title="Delete property"
						data-property-id="<?php echo $m['property_id']; ?>" 
						data-property-folder="<?php echo $m['folder_name']; ?>"
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
			<tr><td class="h_padding20"><div class="g_nodata"><div class="icon"></div>No data to display</div></td></tr>
		</table>
			
	<?php } ?>
	
	<div class="g_pagination_wrapper"><?php echo $pagination; ?></div>
	
</div>

<script type="text/javascript" language="javascript">
$(function(){
	zebraTable();
});

$(".btn_delete_property").click(function(){
	var property_id = $(this).attr('data-property-id');
	var folder_name = $(this).attr('data-property-folder');
	var current_page = $(this).attr('data-current-page');
	
	if (confirm("Are you sure you want to delete this property? \nRemember that it will delete the files for the site as well.")) {
		displayNotification("message", "Working...")
		$.ajax({
			url: "<?php echo base_url(); ?>admin/properties/process_delete",
			type: "POST",
			data: "property_id="+property_id+"&folder_name="+folder_name+"&current_page="+current_page+"&"+$("#form_pagination").serialize(),
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#middle_wrapper").html(response);
					displayNotification("success", "Property successfully deleted.");
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	}
});
</script>