<div class="g_pagelabel">
	<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/log.png" /></div>
	<div class="g_pagelabel_text">Activity Log</div>
</div>

<?php if ($log) { ?>
<table class="g_table zebra">
	
	<tr>
		<th width="116">Date</th>
		<th colspan="3">User</th>
		<th>Log</th>
		<?php if ($sess_user['user_type'] == ROLE_SUPER_ADMIN) { ?><th>Company</th><?php } ?>
		<th width="80">From IP</th>
	</tr>
	
	<?php foreach ($log as $l) { ?>
		<tr>
			<td width="116"><?php echo $l['date']; ?></td>
			<td width="32" style="padding: 0px;">
				<a href="<?php echo base_url(); ?>admin/users/view/<?php echo $l['user_id']; ?>">
				<img class="g_tableavatar" src="<?php echo $l['avatar_path']; ?>?<?php echo time(); ?>" />
				</a>
			</td>
			<td><?php echo $l['username']; ?></td>
			<td><?php echo $l['first_name'] . " " . $l['last_name']; ?></td>
			<td><?php echo $l['log']; ?></td>
			<?php if ($sess_user['user_type'] == ROLE_SUPER_ADMIN) { ?><td><?php echo $l['title_short']; ?></td><?php } ?>
			<td width="80"><?php echo $l['from_ip']; ?></td>
		</tr>
	<?php } ?>
	
</table>
<?php } ?>