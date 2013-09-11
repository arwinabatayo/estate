<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-GB">

	<head>
	
		<title>Admin Login</title>
		
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
		<meta name='description' content='Sitemee' />
		<meta name="author" content="Jeri Ilao">
		
		<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>_assets/js/jquery.js"></script>
		
		<link rel="stylesheet" href="<?php echo base_url(); ?>_assets/css/admin/_global.css?<?php echo time(); ?>" type="text/css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>_assets/css/_helpers.css?<?php echo time(); ?>" type="text/css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>_assets/css/fonts.css?<?php echo time(); ?>" type="text/css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>_assets/css/admin/notifications.css?<?php echo time(); ?>" type="text/css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>_assets/css/admin/<?php echo $page; ?>.css?<?php echo time(); ?>" type="text/css" />
		
		<link rel="icon" type="image/png" href="<?php echo base_url(); ?>_assets/images/favicon.png">
		
		<script type="text/javascript" language="javascript">
		var config = {
			base: "<?php echo base_url(); ?>"
		};
		</script>
		
		<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>_assets/js/util.js?<?php echo time(); ?>"></script>
		<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>_assets/js/validate_form.js"></script>
		
	</head>
	
	<body>
	
		<div id="login_body">

			<div id="login_design"></div>
			
			<div id="login_wrapper">
			<div id="login_wrapper_inner">
			
				<div id="login_message"></div>
				<div id="login_header">Login</div>

				<img src="<?php echo base_url(); ?>_assets/images/login.png" id="login_icon" />
				
				<div id="login_elements">
				<form id="form_login" action="<?php echo base_url(); ?>admin/dashboard" method="POST">
				
					<input 	type="text" 
							id="input_user" 
							name="username" 
							data-required="1"				
							placeholder="Email" />
					<input 	type="password" 
							id="input_pass" 
							name="password" 
							data-required="1"				
							placeholder="Password" />
							
					<!-- temporary register link -->
					<!--
					<div style="float: left; margin: 6px 0px 0px 0px;">
						<a style="font-size: 12px;" href="<?php echo base_url(); ?>admin/forgot">Forgot Password</a>  
					</div>
					-->
					
					<input type="submit" id="button_login" value="Secure Login" />
					<div class="h_clearboth"></div>
					
				</form>
				</div>
				
				<div class="h_clearboth"></div>
					
			</div>
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

		$("#button_login").click(function(e){ 
			e.preventDefault();
			tryLogin(); 
		});

		function tryLogin()
		{
			$("#login_message").html("Checking user credentials");
			$("#button_login").attr('disabled', 'disabled');
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
							$("#button_login").removeAttr('disabled');
						} else {
							$("#login_message").html('Unable to login. Username / Password did not match.'); 
							$("#button_login").removeAttr('disabled');
						}
					},
					error: function(jqXHR, textStatus, errorThrown){
						displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
					}
				});
			}
		}
		</script>
		
	</body>

</html>