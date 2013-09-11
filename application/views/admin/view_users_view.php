<div id="g_content">

	<?php if ($sess_user['user_type'] >= $user_details['user_type_id']) { ?>
		<div id="g_tools">
			<a href="<?php echo base_url(); ?>admin/users/edit/<?php echo $user_details['user_id']; ?>"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/edit.png" />Edit User Details</a>
			<?php if ($sess_user['user_id'] != $user_details['user_id']) { ?>
				<a href="javascript: void(0);" id="btn_delete_user" data-user-id="<?php echo $user_details['user_id']; ?>"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/delete.png" />Delete User</a>
			<?php } ?>
			<div class="h_clearboth"></div>
		</div>
		<div class="h_clearboth"></div>
	<?php } ?>
	<div class="g_spacer"></div>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/generic.png" /></div>
		<div class="g_pagelabel_text">User Details</div>
	</div>
	
	<table class="g_table">
		<tr><td class="g_widget">
	
			<div class="avatar_wrapper">
				<img src="<?php echo $user_details['avatar_path']; ?>?<?php echo time(); ?>" />
			</div>
			
			<div id="account_name"><?php echo $user_details['first_name']; ?> <?php echo $user_details['last_name']; ?></div>
			
			<div id="account_details">
				<div class="username"><span>Username: </span><?php echo $user_details['username']; ?></div>
				<div class="member_since"><span>Member since: </span><?php echo $user_details['member_since']; ?></div>
				<div class="last_login"><span>Last login: </span><?php echo $user_details['last_login']; ?></div>
				<div class="last_login_ip"><span>Last login IP: </span><?php echo $user_details['last_login_ip']; ?></div>
			</div>
			
			<div id="account_details_2">
				<div class="company"><span>Company: </span><?php echo $user_details['company']; ?></div>
				<div class="user_type"><span>User type: </span><?php echo $user_details['user_type_title']; ?></div>
				<div class="account_status"><span>Account status: </span><?php if ($user_details['account_status']) { echo "Active"; } else { echo "Inactive"; } ?></div>
			</div>
	
		</td></tr>
	</table>

	<!-- properties -->
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/generic.png" /></div>
		<div class="g_pagelabel_text">Properties</div>
	</div>
	
	<?php if ($properties) { ?>
	
		<table class="g_table zebra">
			<tr>
				<th width="116">Last Edited</th>
				<th>Title</th>
				<th colspan="2">Template</th>
				<th>Type</th>
			</tr>
			
			<?php foreach ($properties as $property => $m) { ?>
				<tr>
					<td width="116"><?php echo $m['last_edit']; ?></td>
					<td><?php echo $m['property_title']; ?></td>
					<td width="37"><?php echo $m['template_id_code']; ?></td>
					<td><?php echo $m['template_title']; ?></td>
					<td><?php echo $m['template_type_title']; ?></td>
				</tr>
			<?php } ?>
			
			<?php if ($item_count['properties'] > 10) { ?>
				<tr><td colspan="5" class="h_textalignright">
					<a 	href="javascript: void(0);" id="btn_view_properties">View all</a>
					<form id="form_view_properties" action="<?php echo base_url(); ?>admin/properties" method="POST">
						<input type="hidden" name="filter" value="1" />
						<input type="hidden" name="user_id" value="<?php echo $user_details['user_id']; ?>" />
					</form>
				</td></tr>
			<?php } ?>
		</table>
	
	<?php } else { ?>
	
		<table class="g_table">
			<tr><td class="h_padding20"><div class="g_nodata"><div class="icon"></div>No data to display</div></td></tr>
		</table>	

	<?php } ?>
	
	<!-- log -->
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/generic.png" /></div>
		<div class="g_pagelabel_text">Activity Log</div>
	</div>
	
	<?php if ($log) { ?>

		<table class="g_table zebra">
			<tr>
				<th width="116">Date</th>
				<th>Log</th>
				<th width="80">From IP</th>
			</tr>
			
			<?php foreach ($log as $l) { ?>
				<tr>
					<td width="116"><?php echo $l['date']; ?></td>
					<td><?php echo $l['log']; ?></td>
					<td width="80"><?php echo $l['from_ip']; ?></td>
				</tr>
			<?php } ?>
			
			<?php if ($item_count['log'] > 10) { ?>
				<tr><td colspan="3" class="h_textalignright">
					<a 	href="javascript: void(0);" id="btn_view_log">View all</a>
					<form id="form_view_log" action="<?php echo base_url(); ?>admin/log" method="POST">
						<input type="hidden" name="filter" value="1" />
						<input type="hidden" name="user_id" value="<?php echo $user_details['user_id']; ?>" />
					</form>
				</td></tr>
			<?php } ?>
		</table>
	
	<?php } else { ?>
	
		<table class="g_table">
			<tr><td class="h_padding20"><div class="g_nodata"><div class="icon"></div>No data to display</div></td></tr>
		</table>
	
	<?php } ?>

</div>

<script type="text/javascript" language="javascript">
$(function(){
	zebraTable();
	checkSidebarStatus();
});

$("#btn_view_properties").click(function(){
	$("#form_view_properties").submit();
});

$("#btn_view_log").click(function(){
	$("#form_view_log").submit();
});

// delete user
$("#btn_delete_user").click(function(){
	if (confirm("Are you sure you want to delete this user?")) {
		displayNotification("message", "Working...");
		var user_id = $(this).attr('data-user-id');
		$.ajax({
			url: "<?php echo base_url(); ?>admin/users/check_dependencies",
			type: "POST",
			data: "user_id="+user_id,
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					if (response == "0") {
						displayNotification("error", "Failed to delete this user. This user still has properties linked to his account. Please change the ownership of the properties.");
					} else {
						if (typeof history.pushState != 'undefined') { window.history.pushState("object or string", "Title", "<?php echo base_url(); ?>admin/users"); }
						$("#middle_wrapper").html(response);
						displayNotification("success", "Successfully deleted user.");
					}
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	}
});
</script>