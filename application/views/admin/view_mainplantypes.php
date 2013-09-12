<div id="g_content">

	<div id="g_tools">
		<a href="<?php echo base_url(); ?>admin/mainplantypes/add"><img src="<?php echo base_url(); ?>_assets/images/tools/add.png" />Add Main Plan Type</a>
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
		<div class="item"><img src="<?php echo base_url();  ?>_assets/images/global_icon_edit.png" /> Edit main plan type</div>
		<div class="item"><img src="<?php echo base_url();  ?>_assets/images/global_icon_settings.png" /> Manage main plans</div>
		<div class="item"><img src="<?php echo base_url();  ?>_assets/images/global_icon_delete.png" /> Delete main plan type</div>
	</div>
	
	<div class="h_clearboth"></div>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/properties.png" /></div>
		<div class="g_pagelabel_text">Main Plan Types</div>
		<?php echo $pagination; ?>
	</div>
	
	<?php if ($mainplantypes) { ?>
	
		<table class="g_table zebra">
		
			<tr>
				<th>Main Plan Type</th>
				<th>Status</th>
				<th>Actions</th>
			</tr>
			
			<?php foreach ($mainplantypes as $mainplantypes => $m) { ?>
			<tr>
				<td><?php echo $m['type']; ?></td>
				<td width="50" align="center">
					<?php if( $m['main_plan_type_status'] != 2 ){ echo 'Disabled'; }else{ echo 'Enabled'; } ; ?>
				</td>
				
				<!-- actions -->
				<td width="68" align="right">
					<a 	href="<?php echo base_url(); ?>admin/mainplantypes/edit/<?php echo $m['main_plan_type_id']; ?>"
						class="g_tableicon"
						title="Edit main plan type">
						<img src="<?php echo base_url(); ?>_assets/images/global_icon_edit.png" />
					</a>	
					<a 	href="<?php echo base_url(); ?>admin/mainplans/index/<?php echo $m['main_plan_type_id']; ?>"
						class="g_tableicon"
						title="Manage main plans">
						<img src="<?php echo base_url(); ?>_assets/images/global_icon_settings.png" />
					</a>	
					<a 	href="javascript:void(0);" 
						class="btn_delete_main_plan_type g_tableicon" 
						title="Delete main plan type"
						data-main-plan-type-id="<?php echo $m['main_plan_type_id']; ?>" 
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

$(".btn_delete_main_plan_type").click(function(){
	var main_plan_type_id = $(this).attr('data-main-plan-type-id');
	var current_page = $(this).attr('data-current-page');
	
	if (confirm("Are you sure you want to delete this main plan type?")) {
		displayNotification("message", "Working...")
		$.ajax({
			url: "<?php echo base_url(); ?>admin/mainplantypes/process_delete",
			type: "POST",
			data: "main_plan_type_id="+main_plan_type_id+"&current_page="+current_page+"&"+$("#form_pagination").serialize(),
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#middle_wrapper").html(response);
					displayNotification("success", "Main plan type successfully deleted.");
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	}
});
</script>