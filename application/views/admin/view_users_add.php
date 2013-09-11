<div id="g_content">

	<div id="g_tools"> 
		<a href="<?php echo base_url(); ?>admin/users"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/list.png" />User List</a>
		<a href="javascript: void(0);" id="btn_add_user"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/save.png" />Save Changes</a>
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>
	<div class="g_spacer"></div>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/add.png" /></div>
		<div class="g_pagelabel_text">Add user</div>
	</div>
	
	<input type="hidden" value="<?php echo $sess_user['company_id']; ?>" id="ref_company_id" />
	
	<table class="g_table">
		<tr><td class="g_widget">
		
			<form id="form_add_user" class="g_form">
			<div class="user_details_wrapper">
				
				<div class="item">
					<div class="label">Company</div>
					<div class="input">
						<?php if ($sess_user['user_type'] >= ROLE_AGENCY_ADMIN) { ?>
							<select id="select_company" class="g_select" name="client_id" data-required="1">
								<option value="0" selected="selected">Select company</option>
								<?php if ($clients) { ?>
								<?php foreach ($clients as $client => $c) { ?>
									<option value="<?php echo $c['client_id']?>"><?php echo $c['title']; ?></option>	
								<?php } ?>
								<?php } ?>
							</select>
						<?php } else { ?>
							<input type="text" class="g_inputtext h_backgroundlight" readonly="readonly" value="<?php echo $sess_user['company_name']; ?>" />
							<input type="hidden" name="client_id" value="<?php echo $sess_user['company_id']; ?>" />
						<?php } ?>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<div id="field_user_type_loading">Working...</div>
				
				<div class="item" id="field_user_type">
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
						</select>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<div class="item">
					<div class="label">First Name</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="first_name" 
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
								data-required="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<div class="item">
					<div class="label">Username</div>
					<div class="input">
						<input 	class="g_inputtext"  
								type="text" 
								name="username" 
								data-email="1"
								data-required="1" 
								data-unique="1"
								data-field="username"
								data-table="users"
								data-minlength="8"
								autocomplete="off" />
					</div>
					<div class="h_clearboth"></div>
									
					<div class="additional_notes">
						<div class="guide">
							<div class="icon"></div>
							Please enter the user's valid email address.
						</div>
					</div>
					
				</div>
			
			</div>
			</form>
		
		</td></tr>
	</table>

</div>

<script type="text/javascript" language="javascript">
$(function(){
	zebraTable();
	placeHolder();

    var intervalFunc = function () {
		$('#upload_avatar').val($('#file_upload').val());
    };
	
	/*
    $('#upload_avatar').live('click', function () {
        $('#file_upload').click();
        setInterval(intervalFunc, 1);
        return false;
    });
	*/
});

$("#btn_add_user").click(function(){
	if (validate_form("form_add_user")) {
		displayNotification("message", "Working...");
		$.ajax({
			url: "<?php echo base_url(); ?>admin/users/process_add",
			type: "POST",
			data: $("#form_add_user").serialize(),
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#middle_wrapper").html(response);
					if (typeof history.pushState != 'undefined') { window.history.pushState("object or string", "Title", "<?php echo base_url(); ?>admin/users"); }
					displayNotification("success", "New user successfully added. The user has been emailed his/her login credentials.");
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	}
});

$("#select_company").change(function(){
	/*
	if ($(this).val() == $("#ref_company_id").val()) {
		$("#select_user_type").prop("selectedIndex", 0);
	}
	*/
	$("#field_user_type_loading").fadeIn(250);
	$.ajax({
		url: "<?php echo base_url(); ?>admin/users/get_company_user_types",
		type: "POST",
		data: "company_id="+$("#select_company").val(),
		success: function(response, textStatus, jqXHR){
			setTimeout(function () {
				$("#field_user_type").html(response);
				$("#field_user_type_loading").fadeOut(250);
			}, 500);
		},
		error: function(jqXHR, textStatus, errorThrown){
			displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
		}
	});
});
</script>