<div id="g_content">

	<div id="g_tools"> 
		<a href="<?php echo base_url(); ?>admin/properties/edit/<?php echo $property_details['property_id']; ?>"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/edit.png" />Edit Property</a>
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>

	<div class="h_width45percent">
	
		<div class="g_pagelabel">
			<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/edit.png" /></div>
			<div class="g_pagelabel_text">Revert changes - <?php echo $property_details['property_title']; ?></div>
		</div>

		<?php if ($files) { ?>
		
			<table class="g_table zebra">
			
				<tr>
					<th>File name</th>
					<th width="116">Date</th>
					<th></th>
				</tr>
				
				<?php foreach ($files as $file => $f) { ?>
					<tr>
						<td><?php echo $f['file']; ?></td>
						<td width="116"><?php echo $f['date']; ?></td>
						<td width="45">
							<a 	href="javascript: void(0);" 
								data-propertyid="<?php echo $property_details['property_id']; ?>"
								data-filename="<?php echo $f['file']; ?>"
								class="btn_restore">
								Restore
							</a>
						</td>
					</tr>
				<?php } ?>
				
			</table>
			
		<?php } else { ?>
		
			<table class="g_table">
				<tr><td class="g_widget">
					<div class="g_nodata"><div class="icon"></div>No backups to display</div>
				</td></tr>
			</table>
			
		<?php } ?>
	
	</div>
	
</div>

<script type="text/javascript" language="javascript">
$(function(){
	zebraTable();
	checkSidebarStatus();
});

$(".btn_restore").click(function(){
	var property_id = $(this).attr('data-propertyid');
	var filename = $(this).attr('data-filename');
	if (confirm("Are you sure you want to restore the data to this previous version?")) {
		displayNotification("message", "Working...")
		$.ajax({
			url: "<?php echo base_url(); ?>admin/properties/process_revert",
			type: "POST",
			data: "property_id="+property_id+"&filename="+filename,
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					displayNotification("success", "Property data successfully restored to previous version.");
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	}
});
</script>