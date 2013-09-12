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
		
		<?php if( isset($ecommerce_user_types) && count($ecommerce_user_types) > 0 ){ ?>
			<?php foreach( $ecommerce_user_types as $ecommercer_user_type => $eut ){ ?>
				<option value="<?php echo $eut['user_type_id']?>"><?php echo $eut['title']; ?></option>	
			<?php } ?>
		<?php } ?>
	</select>
</div>
<div class="h_clearboth"></div>