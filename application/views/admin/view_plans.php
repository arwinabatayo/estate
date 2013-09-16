<?php 
/**
 * 9.16.2013
 * Ultima Logic
 * robert hughes
 */
?>
<div id="g_content">

	<div id="g_tools">
		<a href="<?php echo base_url(); ?>admin/plans/add"><img src="<?php echo base_url(); ?>_assets/images/tools/add.png" />Add Plan</a>
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
		<div class="item"><img src="<?php echo base_url();  ?>_assets/images/global_icon_edit.png" /> Edit plan</div>
		<div class="item"><img src="<?php echo base_url();  ?>_assets/images/global_icon_delete.png" /> Delete plan</div>
	</div>
	
	<div class="h_clearboth"></div>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/properties.png" /></div>
		<div class="g_pagelabel_text">Plans</div>
		<?php echo $pagination; ?>
	</div>
	
	<?php if ($plans) { ?>
	
		<table class="g_table zebra">
		
			<tr>
				<th>Title</th>
				<th>Description</th>
				<th>Long Description</th>
				<th>Peso Value</th>
				<th>Max Gadget PV</th>
				<th>Amount</th>
				<th>Status</th>
				<th>Actions</th>
			</tr>
			
			<?php foreach ($plans as $plans => $a) { ?>
			<tr>
				<td><?php echo $a['_title']; ?></td>
				<td><?php echo $a['_description']; ?></td>
				<td><?php echo $a['_longdesc']; ?></td>
				<td><?php echo $a['_pesovalue']; ?></td>
				<td><?php echo $a['_max_gadget_pv']; ?></td>
				<td><?php echo number_format($a['_amount'],2); ?></td>
				<td width="50" align="center">
					<?php if( $a['_status'] == 1 ){ echo 'Enabled'; }else{ echo 'Disabled'; } ?>
				</td>
				
				<!-- actions -->
				<td width="53" align="right">
					<a 	href="<?php echo base_url(); ?>admin/plans/edit/<?php echo $a['_id']; ?>"
						class="g_tableicon"
						title="Edit accessory">
						<img src="<?php echo base_url(); ?>_assets/images/global_icon_edit.png" />
					</a>
					<a 	href="javascript:void(0);" 
						class="btn_delete_accessory g_tableicon" 
						title="Delete accessory"
						data-accessory-id="<?php echo $a['_id']; ?>" 
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
	var _id = $(this).attr('data-plan-id');
	var current_page = $(this).attr('data-current-page');
	
	if (confirm("Are you sure you want to delete this plan?")) {
		displayNotification("message", "Working...")
		$.ajax({
			url: "<?php echo base_url(); ?>admin/plans/process_delete",
			type: "POST",
			data: "_id="+_id+"&current_page="+current_page+"&"+$("#form_pagination").serialize(),
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#middle_wrapper").html(response);
					displayNotification("success", "Plan successfully deleted.");
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	}
});
</script>