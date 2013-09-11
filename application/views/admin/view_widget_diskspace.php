<div class="g_pagelabel">
	<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/reports.png" /></div>
	<div class="g_pagelabel_text">Disk Space Usage</div>
</div>

<table class="g_table"><tr><td class="g_widget">	
	
	<?php if ($sess_user['user_type'] == ROLE_SUPER_ADMIN) { ?>
	
		<div class="remaining">
			<div class="size"><?php echo $summary['properties_disk']['text']; ?> TOTAL</div>
			<div class="percent"></div>
			<div class="h_clearboth"></div>
		</div>
	
	<?php } else { ?>
	
		<div class="remaining">
			<div class="size"><?php echo $summary['properties_disk']['text']; ?> / <?php echo $client_details['disk_space_text']; ?> (<?php echo round($client_details['percentage']); ?>%)</div>
			<div class="percent">
				<div class="value" style="width: <?php echo $client_details['percentage']; ?>%">&nbsp;</div>
			</div>
			<div class="h_clearboth"></div>
		</div>
	
	<?php } ?>

</td></tr></table>