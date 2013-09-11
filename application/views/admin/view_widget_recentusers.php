<div class="g_pagelabel">
	<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/users.png" /></div>
	<div class="g_pagelabel_text">Recently Added Users</div>
</div>

<table class="g_table zebra">

	<tr>
		<th>Date Added</th>
		<th colspan="2">Users</th>
	</tr>
	
	<?php if ($user_arr) { ?>
		<?php foreach ($user_arr as $user => $u) { ?>
			<tr>
				<td width="116" style="text-align: right;"><?php echo $u['member_since']; ?></td>
				<td width="32" style="padding: 0px;">
					<a href="<?php echo base_url(); ?>admin/users/view/<?php echo $u['user_id']; ?>">
					<img class="g_tableavatar" src="<?php echo $u['avatar_path']; ?>?<?php echo time(); ?>" />
					</a>
				</td>
				<td><?php echo $u['username']; ?></td>
			</tr>
		<?php } ?>
	<?php } else { ?>
		<tr><td colspan="4">
			<div class="g_nodata">No data to display</div>
		</td></tr>
	<?php } ?>
	
</table>