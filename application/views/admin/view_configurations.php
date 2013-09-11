<div id="g_content">

	<div id="g_tools">
		<a href="<?php echo base_url(); ?>admin/configurations/add/<?php echo $property_id; ?>"><img src="<?php echo base_url(); ?>_assets/images/tools/add.png" />Add Configuration</a>
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
		<div class="item"><img src="<?php echo base_url();  ?>_assets/images/global_icon_edit.png" /> Edit configuration</div>
		<div class="item"><img src="<?php echo base_url();  ?>_assets/images/global_icon_delete.png" /> Delete configuration</div>
	</div>
	
	<div class="h_clearboth"></div>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/properties.png" /></div>
		<div class="g_pagelabel_text">Configurations</div>
		<?php echo $pagination; ?>
	</div>
	
	<?php if ($configurations) { ?>
	
		<table class="g_table zebra">
		
			<tr>
				<th>Configuration Label</th>
				<th>Status</th>
				<th>Actions</th>
			</tr>
			
			<?php foreach ($configurations as $configurations => $c) { ?>
			<tr>
				<td><?php echo $c['configuration_label']; ?></td>
				<td width="50" align="center">
					<?php if( $c['configuration_status'] != 2 ){ echo 'Disabled'; }else{ echo 'Enabled'; } ; ?>
				</td>
				
				<!-- actions -->
				<td width="53" align="right">
					<a 	href="<?php echo base_url(); ?>admin/configurations/edit/<?php echo $c['configuration_id']; ?>"
						class="g_tableicon"
						title="Edit configuration">
						<img src="<?php echo base_url(); ?>_assets/images/global_icon_edit.png" />
					</a>	
					<a 	href="javascript:void(0);" 
						class="btn_delete_configuration g_tableicon" 
						title="Delete configuration"
						data-property-id="<?php echo $c['property_id']; ?>" 
						data-configuration-id="<?php echo $c['configuration_id']; ?>" 
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

$(".btn_delete_configuration").click(function(){
	var configuration_id = $(this).attr('data-configuration-id');
	var property_id = $(this).attr('data-property-id');
	var current_page = $(this).attr('data-current-page');
	
	if (confirm("Are you sure you want to delete this configuration?")) {
		displayNotification("message", "Working...")
		$.ajax({
			url: "<?php echo base_url(); ?>admin/configurations/process_delete",
			type: "POST",
			data: "property_id="+property_id+"&configuration_id="+configuration_id+"&current_page="+current_page+"&"+$("#form_pagination").serialize(),
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#middle_wrapper").html(response);
					displayNotification("success", "Configuration successfully deleted.");
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	}
});
</script>