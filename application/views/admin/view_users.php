<div id="g_content">
	
	<div id="g_tools">
		<a href="<?php echo base_url(); ?>admin/users/add"><img src="<?php echo base_url(); ?>_assets/images/tools/add.png" />Add User</a>
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>
	<div class="g_spacer"></div>
	
	<?php echo $filter; ?>
	<?php echo $legend; ?>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/users.png" /></div>
		<div class="g_pagelabel_text">Users</div>
		<?php echo $pagination; ?>
	</div>
	
	<?php if ($users) { ?>
		
		<table class="g_table zebra">
		
			<tr>
				<th style="min-width: 120px;">Last Name</th>
				<th style="min-width: 120px;">First Name</th>
				<th colspan="2">Username</th>
				<?php if ($sess_user['user_type'] >= ROLE_AGENCY_ADMIN) { ?><th>Company</th><?php } ?>
				<th>User Type</th>
				<th>Status</th>
				<th></th>
			</tr>
			
			<?php foreach ($users as $user => $u) { ?>
			<tr class="row_user">
				<td width="95"><?php echo $u['last_name']; ?></td>
				<td width="100"><?php echo $u['first_name']; ?></td>
				
				<td width="32" class="h_padding0">
					<a href="<?php echo base_url(); ?>admin/users/view/<?php echo $u['user_id']; ?>">
					<img class="g_tableavatar" src="<?php echo $u['avatar_path']; ?>?<?php echo time(); ?>" />
					</a>
				</td>
				<td><?php echo $u['username']; ?></td>
				
				<?php if ($sess_user['user_type'] >= ROLE_AGENCY_ADMIN) { ?>
					<td><?php echo $u['company_title_short']; ?></td>
				<?php } ?>
				
				<td><?php echo $u['user_type_title']; ?></td>
				<td class="account_status"><?php echo ($u['account_status'] == 1) ? "Active": "Inactive"; ?></td>
				
				<!-- actions -->
				<td width="58">
					<a 	class="g_tableicon" 
						title="View user details"
						href="<?php echo base_url(); ?>admin/users/view/<?php echo $u['user_id']; ?>">
						<img src="<?php echo base_url(); ?>_assets/images/global_icon_view.png" />	
					</a>
					<?php if ($u['user_type_id'] <= $sess_user['user_type']) { ?>
						<a 	class="g_tableicon" 
							title="<?php echo ($u['user_id'] == $sess_user['user_id']) ? "Edit my account" : "Edit user details"; ?>"
							href="<?php echo ($u['user_id'] == $sess_user['user_id']) ? base_url()."admin/account/edit" : base_url()."admin/users/edit/".$u['user_id']; ?>">
							<img src="<?php echo base_url(); ?>_assets/images/global_icon_edit.png" />	
						</a>
					<?php } else { ?>
						<?php if( $u['user_type_id'] > ROLE_SUPER_ADMIN ){ ?>
							<a 	class="g_tableicon" 
								title="<?php echo ($u['user_id'] == $sess_user['user_id']) ? "Edit my account" : "Edit user details"; ?>"
								href="<?php echo ($u['user_id'] == $sess_user['user_id']) ? base_url()."admin/account/edit" : base_url()."admin/users/edit/".$u['user_id']; ?>">
								<img src="<?php echo base_url(); ?>_assets/images/global_icon_edit.png" />	
							</a>
						<?php }else{ ?>
							<a 	href="javascript:void(0);" 
								class="g_tableicon g_tableiconinactive">
								<img src="<?php echo base_url(); ?>_assets/images/global_icon_edit_inactive.png" />
							</a>
						<?php } ?>
					<?php } ?>
					<?php if (($u['account_status']) && ($u['user_type_id'] <= $sess_user['user_type'])) { ?>
						<a 	href="javascript:void(0);" 
							class="btn_delete_user g_tableicon" 
							title="Deactivate user"
							data-user-id="<?php echo $u['user_id']; ?>" 
							data-current-page="<?php echo $current_page; ?>" >
							<img src="<?php echo base_url(); ?>_assets/images/global_icon_deactivate.png" />
						</a>
					<?php } else { ?>
						<?php if( $u['user_type_id'] > ROLE_SUPER_ADMIN ){ ?>
							<a 	href="javascript:void(0);" 
								class="btn_delete_user g_tableicon" 
								title="Deactivate user"
								data-user-id="<?php echo $u['user_id']; ?>" 
								data-current-page="<?php echo $current_page; ?>" >
								<img src="<?php echo base_url(); ?>_assets/images/global_icon_deactivate.png" />
							</a>
						<?php }else{ ?>
							<a 	href="javascript:void(0);" 
								class="g_tableicon g_tableiconinactive">
								<img src="<?php echo base_url(); ?>_assets/images/global_icon_deactivate_inactive.png" />
							</a>
						<?php } ?>
					<?php } ?>
					<div class="h_clearboth"></div>
				</td>
			</tr>
			<?php } ?> 
			
		</table>
		
	<?php } else { ?>
	
		<table class="g_table">
			<tr><td class="h_padding20"><div class="g_nodata"><div class="icon"></div>No data to display</div></td></tr>
		</table>
	
	<?php } ?>
	
	<div class="g_pagination_wrapper"><?php echo $pagination; ?></div>

</div>

<script type="text/javascript" language="javascript">
$(function(){
	zebraTable();
});

// mark inactive rows
$(".row_user td.account_status").each(function(){
	if ($(this).html() == "Inactive") { 
		$(this).parent("tr").children("td").addClass('h_backgrounddark'); 
		$(this).parent("tr").children("td").addClass('h_fontcolorsemilight'); 
	}
});

$(".btn_delete_user").click(function(){
	var user_id = $(this).attr('data-user-id');
	var current_page = $(this).attr('data-current-page');
	
	if (confirm("Are you sure you want to deactivate this user?")) {
		displayNotification("message", "Working...");
		$.ajax({
			url: "<?php echo base_url(); ?>admin/users/process_deactivate",
			type: "POST",
			data: "user_id="+user_id+"&current_page="+current_page+"&"+$("#form_pagination").serialize(),
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#middle_wrapper").html(response);
					displayNotification("success", "User successfully deactivated.")
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	}
});
</script>