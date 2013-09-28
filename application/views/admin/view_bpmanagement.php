<div id="g_content">

	<div class="h_clearboth"></div>
	<div class="g_spacer"></div>
	
	<div class="h_clearboth"></div>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/properties.png" /></div>
		<div class="g_pagelabel_text">Business Process Management</div>
	</div>
	
	<?php if ($processes) { ?>
	
		<table class="g_table zebra">
		
			<tr>
				<th>Title</th>
				<th>Description</th>
				<th>Action</th>
			</tr>
			
			<?php foreach ($processes as $process => $a) { ?>
			<tr>
				<td><?php echo $a->process_code; ?></td>
				<td><?php echo $a->process_desc; ?></td>
				<td width="50" align="center">
					<?php if ( $a->enabled_flag == 1 ) { 
							$action_label = "Enable";
						  } else {
						  	$action_label = "Disable";
						  }
					?>
					<a href="javascript: void(0);" id="process-status-<?php echo $a->process_code; ?>" onclick="updateStatus('<?php echo $a->process_code; ?>');"><?php echo $action_label; ?></a>
				</td>
			</tr>
			<?php } ?> 
			
		</table>
			
	<?php } else { ?> 
		
		<table class="g_table">
			<tr><td class="h_padding20"><div class="g_nodata"><div class="icon"></div>No data to display</div></td></tr>
		</table>
			
	<?php } ?>
	
</div>

<script type="text/javascript" language="javascript">
$(function(){
	zebraTable();
});


function updateStatus(process_code)
{
	$.ajax({
		url : "<?php echo base_url(); ?>admin/bpmanagement/updateProcessStatus",
		type : "POST", 
		data : "process_code="+process_code,
		success: function(response, textStatus, jqXHR){
			resp = jQuery.parseJSON(response);

			if (resp.status == 'success') {
				setTimeout(function () {
					$('#process-status-'+process_code).html(resp.curr_status);
					displayNotification("success", "Process successfully updated.");
				}, 500);
			}
		},
		error: function(jqXHR, textStatus, errorThrown){
			displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
		}
	});
}

</script>