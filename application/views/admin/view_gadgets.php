<?php
/**
 * 9.23.2013 [update]
 * 9.18.2013
 * Ultima Logic
 * robert hughes
 */
?>
<div id="g_content">
	
	<div id="g_tools">
		<a href="<?php echo base_url(); ?>admin/gadgets/colors"><img src="<?php echo base_url(); ?>_assets/images/tools/view.png" />Colors</a>
		<a href="<?php echo base_url(); ?>admin/gadgets/data_capacity"><img src="<?php echo base_url(); ?>_assets/images/tools/view.png" />Data Capacity</a>
		<a href="<?php echo base_url(); ?>admin/gadgets/net_connectivity"><img src="<?php echo base_url(); ?>_assets/images/tools/view.png" />Network Connectivity</a>
		<a href="<?php echo base_url(); ?>admin/gadgets/add"><img src="<?php echo base_url(); ?>_assets/images/tools/add.png" />Add Gadget</a>
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
	<div class="item"><img src="<?php echo base_url();  ?>_assets/images/global_icon_view.png" /> View gadgets</div>
		<div class="item"><img src="<?php echo base_url();  ?>_assets/images/global_icon_edit.png" /> Edit gadgets</div>
		<div class="item"><img src="<?php echo base_url();  ?>_assets/images/global_icon_delete.png" /> Delete gadgets</div>
	</div>
	
	<div class="h_clearboth"></div>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/properties.png" /></div>
		<div class="g_pagelabel_text">Gadgets</div>
		<?php echo $pagination; ?>
	</div>
	
	<?php if ($gadgets) { ?>
	
		<table class="g_table zebra">
		
			<tr>
				<th>Title</th>
				<th>Status</th>
				<th>Actions</th>
			</tr>
			
			<?php foreach ($gadgets as $gadgets => $a) {
				$addstyle = "";
				if($a['is_active'] == 1) {
					$addstyle = ' style="background-color: #F2C9F2 !important"';
				}
			?>
			
			<tr>
				<td<?php echo $addstyle; ?>><?php echo $a['name']; ?></td>
				<td<?php echo $addstyle; ?> width="50" align="center">
					<?php if( $a['is_active'] == 1 ){ echo 'Enabled'; }else{ echo 'Disabled'; } ?>
				</td>
				
				<!-- actions -->
				<td<?php echo $addstyle; ?> width="60" align="right">
					<a 	href="<?php echo base_url(); ?>admin/gadgets/view/<?php echo $a['id']; ?>"
						class="g_tableicon view_gadget_details"
						title="View gadget">
						<img src="<?php echo base_url(); ?>_assets/images/global_icon_view.png" />
					</a>
					<a 	href="javascript:void(0);" 
						class="btn_delete g_tableicon" 
						title="Delete gadget"
						data-value-name="<?php echo strtoupper($a['name']); ?>"
						data-id="<?php echo $a['id']; ?>" 
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

<div id="dialog-modal" title="Basic modal dialog">
<p>Adding the modal overlay screen makes the dialog look more prominent because it dims out the page content.</p>
</div>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>_assets/js/jquery-ui/ui/jquery.ui.dialog.js"></script>

<script type="text/javascript" language="javascript">
$(function(){
	zebraTable();

// 	$(".view_gadget_details").click(function(e) {
// 		e.preventDefault();

// 		$.ajax({
			url: "<?php echo base_url(); ?>admin/gadgets/view",
// 			type: "POST",
// 			data: $("#form_add_gadgets").serialize(),
// 			success: function(response, textStatus, jqXHR){
// 				alert(response);
// 				$("#middle_wrapper").html(response);
// 			},
// 			error: function(jqXHR, textStatus, errorThrown){
// 					$("#middle_wrapper").html(jqXHR.responseText);
// 				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
// 			}
// 		});
// 	});
	
});

</script>