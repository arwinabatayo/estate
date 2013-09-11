<table border="0" cellpadding="0" cellspacing="0">
	<tr><td>Good day <?php echo $user_fullname; ?>,</td></tr>
	<tr><td>&nbsp;</td></tr>
	<tr><td>It looks like you forgot your password. </td></tr>
	<tr><td>If you did not request for a reset in password, kindly ignore the link below. </td></tr>
	<tr><td>To reset your password simply click the following link: <a href="<?php echo base_url(); ?>forgot/<?php echo $token; ?>">Reset Password</a></td></tr>
	<tr><td>&nbsp;</td></tr>
	<tr><td>Regards,</td></tr>
	<tr><td>Filament Team</td></tr>
</table>