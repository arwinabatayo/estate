<div id="g_content">

	<div id="g_tools">
		<a href="<?php echo base_url(); ?>admin/account"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/account.png" />My Account</a>
		<?php if ($sess_user['browser'] == "ie" || $sess_user['browser'] == "safari") { ?>
			<a href="javascript: void(0);" id="btn_toggle_avatar"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/changeavatar.png" />Change Avatar</a>
		<?php } else { ?>
			<a href="javascript: void(0);" id="btn_upload_avatar"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/changeavatar.png" />Change Avatar</a>
		<?php } ?>
		<a href="javascript: void(0);" id="btn_edit_password"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/password.png" />Change Password</a>
		<a href="javascript: void(0);" id="btn_edit_account"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/save.png" />Save Changes</a>
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>
	<div class="g_spacer"></div>
		
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
		
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/edit.png" /></div>
		<div class="g_pagelabel_text">Edit Account Details</div>
	</div>

	<table class="g_table zebra">
		<tr><td class="g_widget">
		
			<div class="avatar_wrapper">
				<img src="<?php echo $user_details['avatar_path']; ?>?<?php echo time(); ?>" />
			</div>
	
			<form id="form_edit_account" class="g_form h_floatleft">
			
				<div class="item">
					<div class="label">First Name</div>
					<div class="input">
						<input 	class="g_inputtext" 
								name="first_name"
								type="text" 
								data-required="1"
								data-alphanum="1"
								value="<?php echo $user_details['first_name']; ?>" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<div class="item">
					<div class="label">Last Name</div>
					<div class="input">
						<input 	class="g_inputtext"
								name="last_name"
								type="text" 
								data-required="1"
								data-alphanum="1"
								value="<?php echo $user_details['last_name']; ?>" />
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
						<input 	class="g_inputtext h_backgroundlight"
								disabled="disabled"
								value="<?php echo $user_details['user_type_title']; ?>" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<div class="item">
					<div class="label">Account Status</div>
					<div class="input">
						<input 	class="g_inputtext h_backgroundlight"
								disabled="disabled"
								value="<?php if ($user_details['account_status']) { echo "Active"; } else { echo "Inactive"; } ?>" />
					</div>
					<div class="h_clearboth"></div>
				</div>
			
				<div class="h_clearboth"></div>
			
				<div id="edit_pass" class="edit_password_wrapper">
				
					<div class="item">
						<div class="label">Current Password</div>
						<div class="input">
							<input 	class="g_inputtext password_field"
									name="current_password"
									type="password" 
									id="password"
									data-user-id="<?php echo $user_details['user_id']; ?>"
									value="" />
						</div>
						<div class="h_clearboth"></div>
					</div>
					
					<div class="item">
						<div class="label">New Password</div>
						<div class="input">
							<input 	class="g_inputtext password_field"
									name="new_password"
									type="password" 
									id="new_password"
									data-match="confirm_new_password"
									value="" />
						</div>
						<div class="h_clearboth"></div>
					</div>
					
					<div class="item">
						<div class="label">Confirm New Password</div>
						<div class="input">
							<input 	class="g_inputtext password_field"
									name="confirm_new_password"
									type="password" 
									id="confirm_new_password"
									data-match="new_password"
									value="" />
						</div>
						<div class="h_clearboth"></div>
					</div>
				
				</div>
				
				<input type="hidden" value="<?php echo $user_details['user_id']; ?>" name="user_id" />
				<input type="hidden" value="<?php echo $user_details['username']; ?>" name="username" />
				<input type="hidden" value="0" name="change_password" id="did_change_password" />
				
			</form>
			
		</td></tr>
	</table>

</div>

<script type="text/javascript" language="javascript">
$(function(){
	checkSidebarStatus();
});

// save edit
$("#btn_edit_account").click(function(e){

	displayNotification("message", "Working...");
	if (validate_form("form_edit_account")) {
		$.ajax({
			url: "<?php echo base_url(); ?>admin/account/process_edit",
			type: "POST",
			data: $("#form_edit_account").serialize(),
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#middle_wrapper").html(response);
					displayNotification("success", "Changes to the account saved.");
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
					$("#g_profile #avatar a").html(response);
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

// edit password
$("#btn_edit_password").click(function(){
	$(".password_field").each(function(){
		$(this).attr("data-required", "1");
	});
	$("#did_change_password").val("1");
	$("#password").attr("data-match-password", "1");
	$(".edit_password_wrapper").show();
	$('#middle_wrapper').animate({ scrollTop: $("#edit_pass").offset().top }, 500);
});
</script>