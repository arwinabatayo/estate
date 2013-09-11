<div id="g_content">

	<div id="g_tools">
		<?php if ($sess_user['browser'] == "ie" || $sess_user['browser'] == "safari") { ?>
			<a href="javascript: void(0);" id="btn_toggle_logo"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/changeavatar.png" />Change Logo</a>
		<?php } else { ?>
			<a href="javascript: void(0);" id="btn_upload_logo"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/changeavatar.png" />Change Logo</a>
		<?php } ?>
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>
	<div class="g_spacer"></div>
	
	<form 	id="form_upload_logo" 
			action="<?php echo base_url(); ?>ajax/upload_asset" 
			method="POST" 
			enctype="multipart/form-data" 
			target="iframe_location">
		<input 	type="hidden" name="user_id" 		value="<?php echo $user_details['user_id']; ?>" />
		<input 	type="hidden" name="username" 		value="<?php echo $user_details['username']; ?>" />
		<input 	type="hidden" name="file_name" 		value="logo.png" />
		<input 	type="hidden" name="upload_type" 	value="logo" />
		<input 	type="hidden" name="folder_path" 	value="<?php echo $folder_path; ?>" />
		<input 	id="real_upload" type="file" name="file_to_upload" />
	</form>
	<iframe id="iframe_location" name="iframe_location" scrolling="no"></iframe>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/settings.png" /></div>
		<div class="g_pagelabel_text">Settings</div>
	</div>
	
	<table class="g_table zebra">
		<tr><td class="g_widget">
		
			<div id="settings_logo_wrapper">
				<div class="label">Company Logo</div>
				<div id="settings_logo">
					<img src="<?php echo $company_details['logo']; ?>?<?php echo time(); ?>" />
				</div>
				<div class="g_info h_margintop10 h_marginright20"><div class="icon"></div>All users under the agency will see this logo.</div>
			</div>
			
		</td></tr>
	</table>
	
</div>

<script type="text/javascript" language="javascript">
// upload file custom
$('#btn_upload_logo').click(function(){
	hideAllNotifications();
	$("#real_upload").trigger('click');
});

$('#btn_toggle_logo').click(function(){
	$("#real_upload").slideToggle(200);
});

$("#real_upload").change(function(){
	$("#form_upload_logo").submit();
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
				url: "<?php echo $logo_url."?"; ?>"+n,
				type: "GET",
				data: "",
				success: function(response, textStatus, jqXHR){
					$("#settings_logo").html(response);
					$("#logo_wrapper a").html(response);
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
</script>