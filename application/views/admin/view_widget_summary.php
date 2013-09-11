<?php if ($summary) { ?>

	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/reports.png" /></div>
		<div class="g_pagelabel_text">Summary</div>
	</div>

	<table class="g_table">
		
		<tr>
		<?php foreach ($summary as $summ => $s) { ?>
			<td class="h_padding20">
				<div class="space_usage"><?php echo $s['text']; ?></div>
				<div class="space_usage_label"><?php echo $s['label']; ?></div>
			</td>
		<?php } ?>
		</tr>
		
	</table>
	
<?php } ?>
