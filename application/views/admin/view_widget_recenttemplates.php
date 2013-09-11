<div class="g_pagelabel">
	<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/templates.png" /></div>
	<div class="g_pagelabel_text">Recently Added Templates</div>
</div>

<?php if ($template_arr) { ?>
	<table class="g_table zebra">
		<tr>
			<th>Date Added</th>
			<th>Template</th>
			<th>Type</th>
		</tr>
		<?php foreach ($template_arr as $template => $t) { ?>
			<tr>
				<td width="116"><?php echo $t['last_edit']; ?></td>
				<td><?php echo $t['title']; ?></td>
				<td><?php echo $t['template_type_title']; ?></td>
			</tr>
		<?php } ?>
	</table>
<?php } else { ?>
	<table class="g_table">
		<tr><td class="h_padding20"><div class="g_nodata">No data to display</div></td></tr>
	</table>
<?php } ?>
