<div id="g_content">

	<div id="g_tools">
		<a href="<?php echo base_url(); ?>admin/reports/log"><img src="<?php echo base_url(); ?>_assets/images/tools/log.png" />Activity Log</a>
		<?php if ($sess_user['user_type'] == ROLE_SUPER_ADMIN) { ?>
			<a href="<?php echo base_url(); ?>admin/reports/clients"><img src="<?php echo base_url(); ?>_assets/images/tools/clients.png" />Clients</a>
		<?php } ?>
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>
	
	<div class="h_floatleft h_width40percent"><div class="h_paddingright15"><?php include("view_widget_diskspace.php"); ?></div></div>
	<div class="h_floatright h_width60percent"><div class="h_paddingleft15"><?php include("view_widget_summary.php"); ?></div></div>
	<div class="h_clearboth"></div>
	
	<!-- properties disk space usage -->
	
	<div class="h_floatleft h_width50percent"><div class="h_paddingright15">
	
		<div class="g_pagelabel">
			<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/reports.png" /></div>
			<div class="g_pagelabel_text">Disk Space Usage Breakdown</div>
		</div>

		<?php if ($properties) { ?>
			<table class="g_table zebra">
				<tr>
					<th>Title</th>
					<th width="70">Disk Space</th>
					<th width="75">Percentage</th>
				</tr>
				<?php foreach ($properties as $property => $p) { ?>
					<tr>
						<td><?php echo $p['property_title']; ?></td>
						<td class="h_textalignright" width="70"><?php echo $p['folder_size_text']; ?></td>
						<td class="h_backgrounddisk h_textalignright" width="75"><?php echo $p['percentage']; ?></td>
					</tr>
				<?php } ?>
			</table>
		<?php } else { ?>
			<table class="g_table">
				<tr><td class="h_padding20"><div class="g_nodata"><div class="icon"></div>No data to display</div></td></tr>
			</table>
		<?php } ?>
		
	</div></div>
	
	<div class="h_clearboth"></div>

</div>

<script type="text/javascript" language="javascript">
$(function(){
	zebraTable();
	checkSidebarStatus();
});
</script>