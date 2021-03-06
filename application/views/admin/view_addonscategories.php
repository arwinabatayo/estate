<div id="g_content">

	<div id="g_tools">
		<a href="<?php echo base_url(); ?>admin/addonscategories/add"><img src="<?php echo base_url(); ?>_assets/images/tools/add.png" />Add Addons Category</a>
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
		<div class="item"><img src="<?php echo base_url();  ?>_assets/images/global_icon_edit.png" /> Edit add ons category</div>
		<div class="item"><img src="<?php echo base_url();  ?>_assets/images/global_icon_settings.png" /> Manage add ons category</div>
		<div class="item"><img src="<?php echo base_url();  ?>_assets/images/global_icon_delete.png" /> Delete add ons category</div>
	</div>
	
	<div class="h_clearboth"></div>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/properties.png" /></div>
		<div class="g_pagelabel_text">Addons Categories</div>
		<?php echo $pagination; ?>
	</div>
	
	<?php if ($addonscategories) { ?>
	
		<table class="g_table zebra">
		
			<tr>
				<th>Title</th>
				<th>Actions</th>
			</tr>
			
			<?php foreach ($addonscategories as $addonscategories => $a) { ?>
			<tr>
				<td><?php echo $a['add_ons_category_title']; ?></td>
				
				<!-- actions -->
				<td width="68" align="right">
					<a 	href="<?php echo base_url(); ?>admin/addonscategories/edit/<?php echo $a['add_ons_category_id']; ?>"
						class="g_tableicon"
						title="Edit addons category">
						<img src="<?php echo base_url(); ?>_assets/images/global_icon_edit.png" />
					</a>	
					<a 	href="<?php echo base_url(); ?>admin/addons/index/<?php echo $a['add_ons_category_id']; ?>"
						class="g_tableicon"
						title="Manage addons">
						<img src="<?php echo base_url(); ?>_assets/images/global_icon_settings.png" />
					</a>	
					<a 	href="javascript:void(0);" 
						class="btn_delete_add_ons_category g_tableicon" 
						title="Delete addons category"
						data-add-ons-category-id="<?php echo $a['add_ons_category_id']; ?>" 
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

$(".btn_delete_add_ons_category").click(function(){
	var addonscategory_id = $(this).attr('data-add-ons-category-id');
	var current_page = $(this).attr('data-current-page');
	
	if (confirm("Are you sure you want to delete this addons category?")) {
		displayNotification("message", "Working...")
		$.ajax({
			url: "<?php echo base_url(); ?>admin/addonscategories/process_delete",
			type: "POST",
			data: "addonscategory_id="+addonscategory_id+"&current_page="+current_page+"&"+$("#form_pagination").serialize(),
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#middle_wrapper").html(response);
					displayNotification("success", "Addons category successfully deleted.");
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	}
});
</script>