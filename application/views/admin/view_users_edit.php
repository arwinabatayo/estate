<div id="g_content">

	<div id="g_tools">
		<a href="<?php echo base_url(); ?>admin/users"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/list.png" />User List</a>
		<a href="<?php echo base_url(); ?>admin/users/view/<?php echo $user_details['user_id']; ?>"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/view.png" />View User Details</a>
		<?php if ($sess_user['browser'] == "ie" || $sess_user['browser'] == "safari") { ?>
			<a href="javascript: void(0);" id="btn_toggle_avatar"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/changeavatar.png" />Change Avatar</a>
		<?php } else { ?>
			<a href="javascript: void(0);" id="btn_upload_avatar"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/changeavatar.png" />Change Avatar</a>		
		<?php } ?>
		<a href="javascript: void(0);" id="btn_reset_password" data-user-id="<?php echo $user_details['user_id']; ?>"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/resetpassword.png" />Reset Password</a>
		<a href="javascript: void(0);" id="btn_edit_user"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/save.png" />Save Changes</a>
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>
	<div class="g_spacer"></div>
	
	<!-- upload form -->
	<form 	id="form_upload_avatar" 
			action="<?php echo base_url(); ?>ajax/upload_asset" 
			method="POST" 
			enctype="multipart/form-data" 
			target="iframe_location">
		<input 	type="hidden" name="user_id" 		value="<?php echo $user_details['user_id']; ?>" />
		<input 	type="hidden" name="username" 		value="<?php echo $user_details['username']; ?>" />
		<input 	type="hidden" name="file_name" 		value="avatar.png" />
		<input 	type="hidden" name="upload_type" 	value="avatar" />
		<input 	type="hidden" name="folder_path" 	value="<?php echo $folder_path; ?>" />
		<input 	id="real_upload" type="file" name="file_to_upload" />
	</form>
	<iframe id="iframe_location" name="iframe_location" scrolling="no"></iframe>
	
	<form id="form_edit_user" class="g_form">
	
		<div class="g_pagelabel">
			<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/edit.png" /></div>
			<div class="g_pagelabel_text">Edit user - <?php echo $user_details['first_name'] . " " . $user_details['last_name']; ?></div>
		</div>
	
		<table class="g_table zebra"><tr><td class="g_widget">
			
			<div class="avatar_wrapper">
				<img src="<?php echo $user_details['avatar_path']; ?>?<?php echo time(); ?>" />
			</div>
			
			<div class="user_details_wrapper">
				
				<div class="item">
					<div class="label">First Name</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="first_name" 
								value="<?php echo $user_details['first_name']; ?>"
								data-required="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<div class="item">
					<div class="label">Last Name</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="last_name" 
								value="<?php echo $user_details['last_name']; ?>"
								data-required="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<div class="item">
					<div class="label">Username</div>
					<div class="input">
						<input 	class="g_inputtext h_backgroundlight"
								disabled="disabled"
								value="<?php echo $user_details['username']; ?>" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<div class="item">
					<div class="label">Member Since</div>
					<div class="input">
						<input 	class="g_inputtext h_backgroundlight"
								disabled="disabled"
								value="<?php echo $user_details['member_since']; ?>" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<div class="item">
					<div class="label">Last Login</div>
					<div class="input">
						<input 	class="g_inputtext h_backgroundlight"
								disabled="disabled"
								value="<?php echo $user_details['last_login']; ?>" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<div class="item">
					<div class="label">Last Login IP</div>
					<div class="input">
						<input 	class="g_inputtext h_backgroundlight"
								disabled="disabled"
								value="<?php echo $user_details['last_login_ip']; ?>" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<div class="item">
					<div class="label">Company</div>
					<div class="input">
						<input 	class="g_inputtext h_backgroundlight"
								disabled="disabled"
								value="<?php echo $user_details['company']; ?>" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<div class="item">
					<div class="label">User Type</div>
					<div class="input">
						<select class="g_select" name="user_type" data-required="1">
							<?php if ($user_types) { ?>
							<?php foreach ($user_types as $user_type => $ut) { ?>
								<?php if ($sess_user['user_type'] >= $ut['user_type_id']) { ?>	
									<?php if ($ut['user_type_id'] == ROLE_AGENCY_ADMIN) { ?>
										<?php if ($user_details['agency_id'] == "0") { ?>
											<option value="<?php echo $ut['user_type_id']; ?>" <?php echo ($user_details['user_type_id'] == $ut['user_type_id']) ? "selected='selected'" : ""; ?>><?php echo $ut['title']; ?></option>										
										<?php } ?>
									<?php } else { ?>
										<option value="<?php echo $ut['user_type_id']; ?>" <?php echo ($user_details['user_type_id'] == $ut['user_type_id']) ? "selected='selected'" : ""; ?>><?php echo $ut['title']; ?></option>
									<?php } ?>
								<?php } ?>
							<?php } ?>
							<?php } ?>	
							<?php if( $ecommerce_user_types && count($ecommerce_user_types) > 0 ){ ?>
								<?php foreach ($ecommerce_user_types as $ecommerce_user_type => $eut) { ?>
									<option value="<?php echo $eut['user_type_id']; ?>" <?php echo ($user_details['user_type_id'] == $eut['user_type_id']) ? "selected='selected'" : ""; ?>><?php echo $eut['title']; ?></option>
								<?php } ?>
							<?php } ?>
						</select>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<div class="item">
					<div class="label">Account Status</div>
					<div class="input">
						<select class="g_select" name="status" data-required="1">
							<?php if ($user_details['account_status']) { ?>
								<option value="active" selected="selected">Active</option>
								<option value="inactive">Inactive</option>
							<?php } else { ?>
								<option value="active">Active</option>
								<option value="inactive" selected="selected">Inactive</option>							
							<?php } ?>
						</select>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<input type="hidden" value="<?php echo $user_details['user_id']; ?>" name="user_id" />
				<input type="hidden" value="<?php echo $user_details['username']; ?>" name="username" />
			
			</div>
			
		</td></tr></table>
	
	</form>

</div>

<script type="text/javascript" language="javascript">
$(function(){
	placeHolder();
	checkSidebarStatus();
});

$("#btn_edit_user").click(function(){
	displayNotification("message", "Working...");
	if (validate_form("form_edit_user")) {
		$.ajax({
			url: "<?php echo base_url(); ?>admin/users/process_edit",
			type: "POST",
			data: $("#form_edit_user").serialize(),
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#middle_wrapper").html(response);
					displayNotification("success", "Changes to the user details saved.");
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	}
});

// upload file custom
$('#btn_upload_avatar').click(function(){
	hideAllNotifications();
	$("#real_upload").trigger('click');
});

// upload file custom
$('#btn_toggle_avatar').click(function(){
	$("#real_upload").slideToggle(200);
});

$("#real_upload").change(function(){
	$("#form_upload_avatar").submit();
	displayNotification("message", "Working...");
});

$("#iframe_location").load(function(){
	var result = $(this).contents().find('body').html();
	if (result == "File/s uploaded successfully!") {
		setTimeout(function () {
			// $(".avatar_wrapper").load("<?php echo $avatar_url."?".time(); ?>");
			var d = new Date();
			var n = d.getTime();
			$.ajax({
				url: "<?php echo $avatar_url."?"; ?>"+n,
				type: "GET",
				data: "",
				success: function(response, textStatus, jqXHR){
					$(".avatar_wrapper").html(response);
				},
				error: function(jqXHR, textStatus, errorThrown){
					displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
				}
			});
			displayNotification("success", result);
		}, 500);
	} else if (result != "") {
		displayNotification("error", result);
	}
});

// reset password
$("#btn_reset_password").click(function(){
	if (confirm("Are you sure you want to reset the password for this user?")) {
		displayNotification("message", "Working...");
		var user_id = $(this).attr('data-user-id');
		$.ajax({
			url: "<?php echo base_url(); ?>admin/users/reset_password",
			type: "POST",
			data: "user_id="+user_id,
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					displayNotification("success", "Password reset. An email has been sent to the user.");
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	}
});
</script>