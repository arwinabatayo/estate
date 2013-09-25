<?php
/**
 * 9.23.2013 [update]
 * Ultima Logic
 * robert hughes
 */
?>
<div id="g_content">
	
	<div id="g_tools">
		<a href="<?php echo base_url(); ?>admin/gadgets"><img src="<?php echo base_url(); ?>_assets/images/tools/revert.png" />Back</a>
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>
	<div class="g_spacer"></div>
	
	<?php echo $filter; ?>
	
	<div class="g_pagelabel h_width150px h_floatleft">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/generic.png" /></div>
		<div class="g_pagelabel_text">Add Network Connectivity</div>
	</div>
	
	<div id="g_legend">
		<form method="post" id="formAttr">
			<div class="item">* <input type="text" name="name" placeholder="Name" data-required="1"></div>
			<div class="item">* 
				<select name="is_active">
					<option value="1">Enabled</option>
					<option value="0">Disabled</option>
				</select>
			</div>
			<div class="item"><input type="button" value="SUBMIT" id="addAttr"></div>
		</form>
	</div>
	
	<div class="h_clearboth"></div>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/properties.png" /></div>
		<div class="g_pagelabel_text">Network Connectivity</div>
		<?php echo $pagination; ?>
	</div>
	
	<?php if ($net_connectivity) { ?>
	
		<table class="g_table zebra h_width150px ">
		
			<tr>
				<th>Name</th>
				<th>Status</th>
				<th>Actions</th>
			</tr>
			
			<?php foreach ($net_connectivity as $net_conn => $a) { ?>
			<tr>
				
				<td><?php echo $a['name']; ?></td>
				<td width="50" align="center">
					<?php if( $a['is_active'] == 1 ){ echo 'Enabled'; }else{ echo 'Disabled'; } ?>
				</td>
				
				<!-- actions -->
				<td<?php echo $addstyle; ?> width="60" align="right">
					<a 	href="javascript:void(0);"
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

	$("#addAttr").click(function(e) {
		e.preventDefault();
		
		displayNotification("message", "Working...");
		
		if (validate_form("formAttr")) {
			$.ajax({
				url: "<?php echo base_url(); ?>admin/gadgets/process_add_net_connectivity",
				type: "POST",
				data: $("#formAttr").serialize(),
				success: function(response, textStatus, jqXHR){
					setTimeout(function () {
						$("#middle_wrapper").html(response);
						if (typeof history.pushState != 'undefined') { window.history.pushState("object or string", "Title", "<?php echo base_url(); ?>admin/gadgets/view_gadget_net_connectivity"); }
						displayNotification("success", "New Network Connectivity successfully added.");
					}, 500);
				},
				error: function(jqXHR, textStatus, errorThrown){
						$("#middle_wrapper").html(jqXHR.responseText);
					displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
				}
			});
		}
	});
});

</script>