<?php if ($this->session->userdata('logged_in')) { ?>

	Your are logged in as <?php echo $this->session->userdata('username'); ?><br/>

<?php } else { ?>

	<div id="forgot_body">

		<div id="forgot_design"></div>
		
		<div id="forgot_wrapper">
		<div id="forgot_wrapper_inner">
		
			<div id="forgot_message"></div>
			<div id="forgot_header">Forgot Password</div>

			<?php if ($no_token) { ?>
			
				<img src="<?php echo base_url(); ?>_assets/images/forgot.png" id="forgot_icon" />
				
				<div id="forgot_elements">
				<form id="form_forgot">
				
					<input 	type="text" 
							id="input_user" 
							name="username" 
							data-required="1"
							autocomplete="off"				
							placeholder="Email" />
					
					<!-- temporary register link -->
					<div style="float: left; margin: 6px 0px 0px 0px;">
						<a style="font-size: 12px;" href="<?php echo base_url(); ?>">Back to Home</a>  
					</div>
					
					<input type="button" id="button_forgot" value="Send Instructions" />
					<div class="h_clearboth"></div>
					
				</form>
				</div>
				
			<?php } else if ($expired) { ?>
			
				<div class="message">Link expired.</div>
			
			<?php } else { ?>
			
				<div class="message">Password has been reset. An email has been sent.</div>
			
			<?php } ?>
			
			<div class="h_clearboth"></div>
				
		</div>
		</div>

	</div>

	<script type="text/javascript" language="javascript">
	$(function(){
		$("#input_user").focus();
		
		$(document).keypress(function(e) {
			if ($("#input_user").is(":focus")) { 
				if(e.which == 13) { tryforgot(); }
			}
		});
	});

	$("#button_forgot").click(function(){ tryforgot(); });

	function tryforgot() {
		$("#input_user").css("border", "1px solid #CCCCCC");
	
		var message = "";
		var proceed = true;
		var error_missing_fields = false;
		var error_email_format = false;
		var this_value = $.trim($("#input_user").val());
		
		if (this_value == "") {
			error_missing_fields = true;
			proceed = false;
			$("#input_user").css("border", "1px solid #990000");
		}
		
		if (!isEmailValid(this_value) && (this_value != "")) {
			error_email_format = true;
			proceed = false;
			$("#input_user").css("border", "1px solid #990000");
		}
		
		if (error_missing_fields) { message = message + "Missing fields required."; } 
		if (error_email_format) { message = message + "Email format is not valid. "; } 
		
		$("#forgot_message").html(message);
		
		if (proceed) {
			if (confirm("An email containing the instructions on how to reset your password will be sent to the email address provided. \nDo you wish to proceed?")) {
				$.ajax({
					url: "<?php echo base_url(); ?>ajax/passchange_request",
					type: "POST",
					data: "email="+this_value, 
					success: function(response, textStatus, jqXHR){
						message = "Instructions sent to email.";
						$("#input_user").css("border", "1px solid #CCCCCC");
						$("#forgot_message").html(message);
					},
					error: function(jqXHR, textStatus, errorThrown){
						// displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
					}
				});
			}
		}
	}
	</script>

<?php } ?>