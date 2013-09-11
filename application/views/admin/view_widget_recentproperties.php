<div class="g_pagelabel">
	<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/properties.png" /></div>
	<div class="g_pagelabel_text">Recently Edited Properties</div>
</div>


<?php if ($property_arr) { ?>

	<table class="g_table zebra">
		<tr>
			<th width="116">Last Edited</th>
			<?php if ($sess_user['user_type'] >= ROLE_AGENCY_ADMIN) { ?><th>Client</th><?php } ?>
			<th>Title</th>
			<th colspan="2">Template</th>
			<th>Type</th>
			<th colspan="2">Created by</th>
		</tr>
		
		<?php foreach ($property_arr as $property => $m) { ?>
		<tr>
			<td width="116"><?php echo $m['last_edit']; ?></td>
			<?php if ($sess_user['user_type'] >= ROLE_AGENCY_ADMIN) { ?><td><?php echo $m['client_title_short']; ?></td><?php } ?>
			<td><?php echo $m['property_title']; ?></td>
			<td width="36"><?php echo $m['template_id_code']; ?></td>
			<td><?php echo $m['template_title']; ?></td>
			<td><?php echo $m['template_type_title']; ?></td>
			<td width="32" class="h_padding0">
				<a href="<?php echo base_url(); ?>admin/users/view/<?php echo $m['user_id']; ?>">
				<img class="g_tableavatar" src="<?php echo $m['avatar_path']; ?>?<?php echo time(); ?>" />
				</a>
			</td>
			<td><?php echo $m['username']; ?></td>
		</tr>
		<?php } ?>
		
	</table>
		
<?php } else { ?>
	
	<table class="g_table">
		<tr><td class="h_padding20"><div class="g_nodata">No data to display</div></td></tr>
	</table>
		
<?php } ?>

	
	
	