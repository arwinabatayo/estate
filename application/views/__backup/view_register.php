<div id="register_body">

	<div id="register_design"></div>
	
	<div id="register_wrapper">
	<div id="register_wrapper_inner">
	
		<div id="register_message"></div>
		<div id="register_header">Registration</div>

		<?php if ($sess_user['logged_in']) { ?>
			
			<div class="h_padding20 h_textaligncenter">You are currently logged in</div>
			
		<?php } else { ?>
		
			<img src="<?php echo base_url(); ?>_assets/images/login.png" id="login_icon" />
			
			<div id="register_elements">
			<form id="form_register">
			
				<select class="g_select" name="user_type" data-required="1">
					<option value="0" selected="selected">Select User Type</option>
					<?php if ($user_types) { ?>
					<?php foreach ($user_types as $user_type => $ut) { ?>
						<?php if ($ut['user_type_id'] != 5) { ?>
						<option value="<?php echo $ut['user_type_id']?>"><?php echo $ut['title']; ?></option>	
						<?php } ?>
					<?php } ?>
					<?php } ?>
				</select>
				
				<input 	type="text" 
						id="input_company" 
						name="company" 
						data-required="1"
						autocomplete="off"				
						placeholder="Company name" />
				
				<input 	type="text" 
						id="input_firstname" 
						name="first_name" 
						data-required="1"
						autocomplete="off"				
						placeholder="First Name" />
						
				<input 	type="text" 
						id="input_lastname" 
						name="last_name" 
						data-required="1"
						autocomplete="off"				
						placeholder="Last Name" />
				
				<input 	type="text" 
						id="input_username" 
						name="username" 
						data-required="1"
						autocomplete="off"
						data-email="1"
						data-unique="1"
						data-field="username"
						data-table="users"					
						placeholder="Username" />
						
				<div class="additional_notes">
					<div class="guide"><div class="icon"></div>A valid email is required for the username.</div>
				</div>
				
				<input 	type="password" 	
						id="input_password" 
						name="password" 
						data-match="input_confirmpassword"
						data-required="1"
						autocomplete="off"				
						placeholder="Password" />

				<input 	type="password" 
						id="input_confirmpassword" 
						data-match="input_password"
						data-required="1"
						autocomplete="off"				
						placeholder="Confirm password" />

				<input type="button" id="button_register" value="Register" />
				<div class="h_clearboth"></div>
				
			</form>
			</div>
			
			<div class="h_clearboth"></div>
		
		<?php } ?>
			
	</div>
	</div>

</div>

<script type="text/javascript" language="javascript">
$("#button_register").click(function(){ tryRegister(); });

function tryRegister() {
	$("#register_message").html("Validating...");
	if (validate_form("form_register")) {
		$.ajax({
			url: "<?php echo base_url(); ?>ajax/register",
			type: "POST",
			data: $("#form_register").serialize(),
			success: function(response, textStatus, jqXHR){
				if (response == "1") { 
					$("#register_message").html('Registration successful. Redirecting...'); 
					window.location = "<?php echo base_url(); ?>admin/dashboard";
				} else if (response == "2") {
					$("#register_message").html('Unable to login. Account has been deactivated.'); 
				} else {
					$("#register_message").html('Unable to login. Username / Password did not match.'); 
				}
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	}
}
</script>