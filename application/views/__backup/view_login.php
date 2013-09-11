<div class="ln_body">
<div class="g_inner">
	
	<form id="form_login" action="<?php echo base_url(); ?>admin/dashboard" method="POST">
	
		<div class="ln_label">Login to Sitemee</div>
	
		<div class="ln_username">
			<input 	type="text" 
					id="input_user" 
					name="username" 
					data-required="1"
					data-email="1"
					placeholder="Email Address" />
		</div>
		
		<div class="ln_password">
			<input 	type="password" 
					id="input_pass" 
					name="password" 
					data-required="1"
					placeholder="Password" />
		</div>
		
		<div id="login_message"></div>
		
		<div class="ln_submit">
			<input type="button" value="Secure Login" id="btn_login" />
		</div>		
		
	</form>
	
	<div class="h_clearboth"></div>

</div>
</div>

<script type="text/javascript" language="javascript">
$(function(){
	$("#input_user").focus();
	
	$(document).keypress(function(e) {
		if ($("#input_user").is(":focus") || $("#input_pass").is(":focus")) { 
			if (e.which == 13) { tryLogin(); }
		}
	});
});

$("#btn_login").click(function(e){
	e.stopPropagation();
	tryLogin(); 
});

function tryLogin()
{
	$("#login_message").html("Checking user credentials");
	$("#btn_login").attr('disabled', 'disabled');
	if (validate_form("form_login")) {
		$.ajax({
			url: "<?php echo base_url(); ?>ajax/login",
			type: "POST",
			data: $("#form_login").serialize(),
			success: function(response, textStatus, jqXHR){
				if (response == "1") { 
					$("#login_message").html('Login successful. Redirecting...');
					$("#form_login").submit();
				} else if (response == "2") {
					$("#login_message").html('Unable to login. Account has been deactivated.'); 
					$("#btn_login").removeAttr('disabled');
				} else {
					$("#login_message").html('Unable to login. Username / Password did not match.'); 
					$("#btn_login").removeAttr('disabled');
				}
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	} else {
		$("#btn_login").removeAttr('disabled');
	}
}
</script>