<div id="g_content">

	<div id="g_tools">
		<a href="<?php echo base_url(); ?>admin/clients"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/list.png" />Client List</a>	
		<a href="javascript: void(0);" id="btn_add_client"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/save.png" />Save Changes</a>	
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>

	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/add.png" /></div>
		<div class="g_pagelabel_text">Add Client</div>
	</div>
	
	<table class="g_table zebra">
		<tr><td class="g_widget">

			<form id="form_add_client" class="g_form">
				
				<!-- company name -->
				<div class="item">
					<div class="label">Company Name</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="title" 
								maxlength="128"			
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
								maxlength="10"	
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
								maxlength="128" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- contact email -->
				<div class="item">
					<div class="label">Contact Email</div>
					<div class="input">
						<input 	class="g_inputtext" 
								data-email="1"
								type="text" 
								name="contact_email" 
								maxlength="128" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- agent -->
				<div class="item">
					<div class="label">Agent</div>
					<div class="input">
						<select class="g_select" name="agent_id" data-required="1">
							<option value="0" selected="selected">Select agent</option>
							<option data-required="1" value="none">None</option>
							<?php if ($agents) { ?>
							<?php foreach ($agents as $agent => $a) { ?>
								<option data-required="1" value="<?php echo $a['user_id']; ?>"><?php echo $a['last_name'] . ", " . $a['first_name']; ?></option>
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
							<option value="0" selected="selected">Select status</option>
							<option data-required="1" value="inactive">Inactive</option>
							<option data-required="1" value="active">Active</option>
						</select>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- agency -->
				<div class="item">
					<div class="label">Agency</div>
					<div class="input">
						<?php if ($sess_user['user_type'] >= ROLE_SUPER_ADMIN) { ?>
							<select class="g_select" name="agency" data-required="1">
								<option value="0" selected="selected">Select Agency</option>
								<option data-required="1" value="none">None</option>
								<?php if ($agencies) { ?>
								<?php foreach ($agencies as $agency => $a) { ?>
									<option data-required="1" value="<?php echo $a['client_id']; ?>"><?php echo $a['title_short']; ?></option>
								<?php } ?>	
								<?php } ?>
							</select>
						<?php } else { ?>
							<input type="text" class="g_inputtext h_backgroundlight" readonly="readonly" value="<?php echo $sess_user['company_name']; ?>" />
							<input type="hidden" name="agency" value="<?php echo $sess_user['company_id']; ?>" />
						<?php } ?>
					</div>
					<div class="h_clearboth"></div>
					
					<div class="additional_notes">
						<div class="guide">
							<div class="icon"></div>
							If "None" is selected from the agency dropdown, the company will automatically be considered as an agency.
						</div>
					</div>
					
				</div>
				
				<!-- templates access -->
				<div class="item">
					<div class="label">Allow templates page access?</div>
					<div class="input">
						<select class="g_select" name="templates_access" data-required="1">
							<option value="0" selected="selected">Select permission</option>
							<option data-required="1" value="yes">Yes</option>
							<option data-required="1" value="no">No</option>
						</select>
					</div>
					<div class="h_clearboth"></div>
				</div>
			
			</form>
		</td></tr>
	</table>

</div>

<script type="text/javascript" language="javascript">
$(function(){
	placeHolder();
	checkSidebarStatus();
});

$("#btn_add_client").click(function(e){
	if (validate_form("form_add_client")) {
		displayNotification("message", "Working...");
		$.ajax({
			url: "<?php echo base_url(); ?>admin/clients/process_add",
			type: "POST",
			data: $("#form_add_client").serialize(),
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#middle_wrapper").html(response);
					if (typeof history.pushState != 'undefined') { window.history.pushState("object or string", "Title", "<?php echo base_url(); ?>admin/clients"); }
					displayNotification("success", "New client successfully added.");
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	}
});
</script>