<div id="g_content">

	<div id="g_tools">
		<a href="<?php echo base_url(); ?>admin/accessories/add"><img src="<?php echo base_url(); ?>_assets/images/tools/add.png" />Add Combo</a>
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
		<div class="item"><img src="<?php echo base_url();  ?>_assets/images/global_icon_edit.png" /> Edit accessory</div>
		<div class="item"><img src="<?php echo base_url();  ?>_assets/images/global_icon_delete.png" /> Delete accessory</div>
	</div>
	
	<div class="h_clearboth"></div>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/properties.png" /></div>
		<div class="g_pagelabel_text">Combos</div>
		<?php echo $pagination; ?>
	</div>
	
	<?php if ($combos) { ?>
	
		<table class="g_table zebra">
		
			<tr>
				<th>CID</th>
				<th>Title</th>
				<th>Description</th>
				<th>Long Description</th>
				<th>Peso Value</th>
				<th>Status</th>
				<th>Actions</th>
			</tr>
			
			<?php foreach ($combos as $combos => $a) { ?>
			<tr>
				<td><?php echo $a['cid']; ?></td>
				<td><?php echo $a['name']; ?></td>
				<td><?php echo $a['description']; ?></td>
				<td><?php echo $a['long_description']; ?></td>
				<td><?php echo $a['peso_value']; ?></td>
				<td width="50" align="center">
					<?php if( $a['is_active'] == 1 ){ echo 'Enabled'; }else{ echo 'Disabled'; } ?>
				</td>
				
				<!-- actions -->
				<td width="53" align="right">
					<a 	href="<?php echo base_url(); ?>admin/accessories/edit/<?php echo $a['accessories_id']; ?>"
						class="g_tableicon"
						title="Edit accessory">
						<img src="<?php echo base_url(); ?>_assets/images/global_icon_edit.png" />
					</a>
					<a 	href="javascript:void(0);" 
						class="btn_delete_accessory g_tableicon" 
						title="Delete accessory"
						data-accessory-id="<?php echo $a['accessories_id']; ?>" 
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

$(".btn_delete_accessory").click(function(){
	var accessory_id = $(this).attr('data-accessory-id');
	var current_page = $(this).attr('data-current-page');
	
	if (confirm("Are you sure you want to delete this accessory?")) {
		displayNotification("message", "Working...")
		$.ajax({
			url: "<?php echo base_url(); ?>admin/accessories/process_delete",
			type: "POST",
			data: "accessory_id="+accessory_id+"&current_page="+current_page+"&"+$("#form_pagination").serialize(),
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#middle_wrapper").html(response);
					displayNotification("success", "Accessory successfully deleted.");
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	}
});
</script>