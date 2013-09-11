<div class="label">User Type</div>
<div class="input">
	<select class="g_select" name="user_type" data-required="1">
		<option value="0" selected="selected">Select user type</option>
		<?php if ($user_types) { ?>
		<?php foreach ($user_types as $user_type => $ut) { ?>
			<?php if ($sess_user['user_type'] >= $ut['user_type_id']) { ?>
				<option value="<?php echo $ut['user_type_id']?>"><?php echo $ut['title']; ?></option>	
			<?php } ?>
		<?php } ?>
		<?php } ?>
	</select>
</div>
<div class="h_clearboth"></div>