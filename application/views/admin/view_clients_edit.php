<div id="g_content">

	<div id="g_tools">
		<a href="<?php echo base_url(); ?>admin/clients"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/list.png" />Client List</a>	
		<a href="<?php echo base_url(); ?>admin/clients/view/<?php echo $client_details['client_id']; ?>"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/view.png" />View Client Details</a>	
		<?php if (($client_details['agency_id'] == "0") || ($sess_user['user_type'] == ROLE_SUPER_ADMIN && $client_details['agency_id'] == "0")) { ?><a href="javascript: void(0);" id="btn_upload_logo"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/changeavatar.png" />Change Logo</a><?php } ?>
		<a href="javascript: void(0);" id="btn_edit_client"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/save.png" />Save Changes</a>	
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>
	
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
	
	<form id="form_edit_client" class="g_form">	
	
		<!-- client details -->
		
		<div class="g_pagelabel">
			<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/edit.png" /></div>
			<div class="g_pagelabel_text">
				<?php if ($client_details['is_agency']) { ?>
					<span class="label_agency_2">Agency</span>
				<?php } ?>
				Edit Client - <?php echo $client_details['title']; ?>
			</div>
		</div>
		
		<table class="g_table">
			<tr><td class="g_widget">
					
				<?php if (($client_details['agency_id'] == "0") || ($sess_user['user_type'] == ROLE_SUPER_ADMIN && $client_details['agency_id'] == "0")) { ?>
				<div class="h_floatleft h_marginright20">
					<div class="logo_wrapper">
						<img src="<?php echo $client_details['logo']; ?>?<?php echo time(); ?>" />
					</div>	
					<div class="g_info"><div class="icon"></div>Recommended Dimensions: 250x090</div>				
				</div>		
				<?php } ?>		
					
				<div class="h_floatleft">
				
					<!-- company name -->
					<div class="item">
						<div class="label">Company Name</div>
						<div class="input">
							<input 	class="g_inputtext" 
									type="text" 
									name="title" 
									value="<?php echo $client_details['title']; ?>" 
									maxlength="128"
									data-orig-val="<?php echo $client_details['title']; ?>"						
									data-unique="1"
									data-field="title"
									data-table="clients"
									data-required="1" />
						</div>
						<div class="h_clearboth"></div>
					</div>
									
					<!-- company short name -->
					<div class="item">
						<div class="label">Company Short Name</div>
						<div class="input">
							<input 	class="g_inputtext" 
									type="text" 
									name="title_short" 
									value="<?php echo $client_details['title_short']; ?>" 
									maxlength="10"
									data-orig-val="<?php echo $client_details['title_short']; ?>"						
									data-unique="1"
									data-field="title_short"
									data-table="clients"
									data-required="1" />
						</div>
						<div class="h_clearboth"></div>
					</div>
					
					<!-- contact name -->
					<div class="item">
						<div class="label">Contact Name</div>
						<div class="input">
							<input 	class="g_inputtext" 
									type="text" 
									name="contact_name" 
									maxlength="128"
									value="<?php echo $client_details['contact_name']; ?>" />
						</div>
						<div class="h_clearboth"></div>
					</div>
					
					<!-- contact name -->
					<div class="item">
						<div class="label">Contact Email</div>
						<div class="input">
							<input 	class="g_inputtext" 
									data-email="1"
									type="text" 
									name="contact_email" 
									maxlength="128"
									value="<?php echo $client_details['contact_email']; ?>" />
						</div>
						<div class="h_clearboth"></div>
					</div>
					
					<!-- agent -->
					<div class="item">
						<div class="label">Agent</div>
						<div class="input">
							<select class="g_select" name="agent_id" data-required="1">
								<option <?php echo ($client_details['user_id'] == 0) ? "selected='selected'": ""; ?> data-required="1" value="none">None</option>
								<?php if ($agents) { ?>
								<?php foreach ($agents as $agent => $a) { ?>
									<option <?php echo ($a['user_id'] == $client_details['user_id']) ? "selected='selected'" : ""; ?> data-required="1" value="<?php echo $a['user_id']; ?>">
										<?php echo $a['last_name']; ?>, <?php echo $a['first_name']; ?>
									</option>
								<?php } ?>
								<?php } ?>
							</select>
						</div>
						<div class="h_clearboth"></div>
					</div>
					
					<!-- status -->
					<div class="item">
						<div class="label">Status</div>
						<div class="input">
							<select class="g_select" name="status" data-required="1">
								<option data-required="1" value="inactive" 	<?php echo ($client_details['status'] == 0) ? "selected='selected'" : ""; ?>>Inactive</option>
								<option data-required="1" value="active" 	<?php echo ($client_details['status'] == 1) ? "selected='selected'" : ""; ?>>Active</option>
							</select>
						</div>
						<div class="h_clearboth"></div>
					</div>
					
					<!-- templates access -->
					<div class="item">
						<div class="label">Allow templates page access?</div>
						<div class="input">
							<select class="g_select" name="templates_access" data-required="1">
								<option data-required="1" value="yes" <?php echo ($client_details['templates_access'] == 1) ? "selected='selected'" : ""; ?>>Yes</option>
								<option data-required="1" value="no"  <?php echo ($client_details['templates_access'] == 0) ? "selected='selected'" : ""; ?>>No</option>
							</select>
						</div>
						<div class="h_clearboth"></div>
					</div>
					
					<input type="hidden" name="client_id" id="client_id" value="<?php echo $client_details['client_id']; ?>" />
					<input type="hidden" name="orig_folder_name" value="<?php echo $client_details['folder']; ?>" />
				
				</div>
					
			</td></tr>
		</table>
	
		<!-- features -->
		
		<div class="g_pagelabel">
			<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/edit.png" /></div>
			<div class="g_pagelabel_text">Features</div>
		</div>
		
		<table class="g_table zebra">
			<?php if ($feature_all) { ?>
				<tr>
					<th colspan="2">Title</th>
					<th>Description</th>
					<th>Limit</th>
					<th class="h_textalignright">Price</th>
				</tr>
			
				<?php foreach ($feature_all as $feature => $f) { ?>
					<tr>
						<td style="width: 20px; padding: 0px 12px;">
							<input 	type="checkbox" 
									class="feature_selection"
									data-template-type="<?php echo $f['template_type_id']; ?>"
									<?php echo (in_array($f['feature_id'], $features)) ? "checked='checked'" : ""; ?>
									name="features[]" 
									value="<?php echo $f['feature_id']?>" /> 
						</td>
						<td><?php echo $f['feature_title']; ?></td>
						<td><?php echo $f['feature_desc']; ?></td>
						<td><?php echo $f['limit']; ?></td>
						<td class="h_textalignright"><?php echo $f['price']; ?></td>
					</tr>
				<?php } ?>
			<?php } else { ?>
				<tr><td class="h_padding20">
					<div class="g_nodata"><div class="icon"></div>No data to display</div>
				</td></tr>
			<?php } ?>
		</table>
		
	</form>

</div>

<script type="text/javascript" language="javascript">
$(function(){
	zebraTable();
	placeHolder();
	checkSidebarStatus();
});
	
$(".feature_selection").click(function(){
	if ($(this).is(":checked")) {
		var template_type = $(this).attr('data-template-type');
		if (template_type != 0) {
			$(".feature_selection[data-template-type='"+template_type+"']").prop('checked', false);
			$(this).prop('checked', true);
		}
	}
});
	
$("#btn_edit_client").click(function(e){
	if (validate_form("form_edit_client")) {
		displayNotification("message", "Working...");
		$.ajax({
			url: "<?php echo base_url(); ?>admin/clients/process_edit",
			type: "POST",
			data: $("#form_edit_client").serialize(),
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#middle_wrapper").html(response);
					var additional_message = "";
					if ($(".g_select[name='status']").val() == "inactive") { additional_message = " Users under this client have been deactivated as well"; }
					displayNotification("success", "Changes to the client saved."+additional_message);
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	}
});

// upload file custom
$('#btn_upload_logo').click(function(){
	hideAllNotifications();
	$("#real_upload").trigger('click');
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
					$(".logo_wrapper").html(response);
					<?php if ($sess_user['company_id'] == $client_details['client_id']) { ?>
						$("#logo_wrapper a").html(response);
					<?php } ?>
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