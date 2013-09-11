<div id="g_content">

	<div id="g_tools">
		<a href="<?php echo base_url(); ?>admin/clients/add"><img src="<?php echo base_url(); ?>_assets/images/tools/add.png" />Add Client</a>
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>
	
	<?php echo $filter; ?>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/clients.png" /></div>
		<div class="g_pagelabel_text">Clients<span><?php echo $filter_message; ?></span></div>
		<?php echo $pagination; ?>
	</div>
	
	<?php if ($clients) { ?>
	
		<table class="g_table zebra">
			<tr>
				<th>Company Name</th>
				<th>Company Short Name</th>
				<th>Contact Person</th>
				<?php if ($sess_user['user_type'] == ROLE_SUPER_ADMIN) { ?><th>Agency</th><?php } ?>
				<!-- <th colspan="2">Agent</th> -->
				<th>Status</th>
				<th>Actions</th>
			</tr>
			<?php foreach ($clients as $client => $c) { ?>
				<tr>
					<td>
						<?php echo $c['title']; ?>
						<?php if (!$c['agency_details']) { ?>
							<span class="label_agency">Agency</span>
						<?php } ?>
					</td>
					<td><?php echo $c['title_short']; ?></td>
					<td><?php echo $c['contact_name']; ?></td>
					<?php if ($sess_user['user_type'] == ROLE_SUPER_ADMIN) { ?><td><?php echo $c['agency_details']['title_short']; ?></td><?php } ?>
					<?php /*
					<td width="32" class="h_padding0">
						<?php if ($c['user_id'] != ".....") { ?>
						<a href="<?php echo base_url(); ?>admin/users/view/<?php echo $c['user_id']; ?>">
						<img class="g_tableavatar" src="<?php echo $c['avatar_path']; ?>?<?php echo time(); ?>" />
						</a>
						<?php } ?>
					</td>
					<td><?php echo $c['username']; ?></td>
					*/ ?>
					<td><?php echo ($c['status'] == 1) ? "Active": "Inactive"; ?></td>
					<td width="58">
						<a 	href="<?php echo base_url(); ?>admin/clients/view/<?php echo $c['client_id']; ?>" 
							class="g_tableicon"
							title="View client details">
							<img src="<?php echo base_url(); ?>_assets/images/global_icon_view.png" />
						</a>
						<a 	href="<?php echo base_url(); ?>admin/clients/edit/<?php echo $c['client_id']; ?>"
							class="g_tableicon"
							title="Edit client details">
							<img src="<?php echo base_url(); ?>_assets/images/global_icon_edit.png" />
						</a>
						<?php if ($c['status']) { ?>
							<a 	href="javascript: void(0);"
								class="btn_delete_client g_tableicon"
								title="Deactivate client"
								data-client-id="<?php echo $c['client_id']; ?>" 
								data-current-page="<?php echo $current_page; ?>" >
								<img src="<?php echo base_url(); ?>_assets/images/global_icon_deactivate.png" />
							</a>
						<?php } else { ?>
							<a 	href="javascript:void(0);" 
								class="g_tableicon g_tableiconinactive">
								<img src="<?php echo base_url(); ?>_assets/images/global_icon_deactivate.png" />
							</a>
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
	checkSidebarStatus();
});

$(".btn_delete_client").click(function(){
	var client_id = $(this).attr('data-client-id');
	var current_page = $(this).attr('data-current-page');

	if (confirm("Are you sure you want to deactivate this client? \nRemember that it will deactivate all the users of the client as well.")) {
		displayNotification("message", "Working...")
		$.ajax({
			url: "<?php echo base_url(); ?>admin/clients/process_deactivate",
			type: "POST",
			data: "client_id="+client_id+"&current_page="+current_page+"&"+$("#form_pagination").serialize(),
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#middle_wrapper").html(response);
					displayNotification("success", "Client successfully deactivated. All users under the client were deactivated as well.")
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	}
});
</script>