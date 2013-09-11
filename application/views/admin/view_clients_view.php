<div id="g_content">

	<div id="g_tools">
		<a href="<?php echo base_url(); ?>admin/clients"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/list.png" />Client List</a>
		<a href="<?php echo base_url(); ?>admin/clients/edit/<?php echo $client_details['client_id']; ?>"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/edit.png" />Edit Client Details</a>
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>
	
	<!-- client details -->
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/generic.png" /></div>
		<div class="g_pagelabel_text">
			<?php if ($client_details['is_agency']) { ?>
				<span class="label_agency_2">Agency</span>
			<?php } ?>
			Client Details
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
			
				<div id="client_name"><?php echo $client_details['title']; ?></div>
				
				<div id="client_details">
					<div class="short_name"><span>Company short name: </span><?php echo $client_details['title_short']; ?></div>
					<div class="contact_name"><span>Contact person: </span><?php echo $client_details['contact_name']; ?></div>
					<div class="email"><span>Contact email: </span><?php echo $client_details['contact_email']; ?></div>
					<div class="client_status"><span>Client status: </span><?php if ($client_details['status']) { echo "Active"; } else { echo "Inactive"; } ?></div>
				</div>
				
				<div id="client_details_2">
					<div class="agent_name"><span>Agent name: </span>
						<?php if ($client_details['last_name'] != "n/a") { ?>
							<?php echo $client_details['last_name'] . ", " . $client_details['first_name']; ?>
						<?php } else { ?>
							n/a
						<?php } ?>
					</div>
					<div class="agent_email"><span>Agent email: </span><?php echo $client_details['username']; ?></div>
					<div class="fee"><span>Total fee: </span><?php echo $feature_total; ?></div>
				</div>
				
			</div>
	
		</td></tr>
	</table>
	
	<!-- features -->
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/generic.png" /></div>
		<div class="g_pagelabel_text">Features</div>
	</div>
	
	<?php if ($features) { ?>
	
		<table class="g_table zebra">
			<tr>
				<th>Title</th>
				<th>Description</th>
				<th>Limit</th>
				<th class="h_textalignright">Price</th>
			</tr>
		
			<?php foreach ($features as $feature => $f) { ?>
				<tr>
					<td><?php echo $f['feature_title']; ?></td>
					<td><?php echo $f['feature_desc']; ?></td>
					<td><?php echo $f['limit']; ?></td>
					<td class="h_textalignright"><?php echo $f['price']; ?></td>
				</tr>
			<?php } ?>
			
			<tr>
				<td colspan="3" class="h_textalignright">Total</td>
				<td class="h_textalignright"><?php echo $feature_total; ?></td>
			</tr>
		</table>
		
	<?php } else { ?>
	
		<table class="g_table">
			<tr><td class="h_padding20">
				<div class="g_nodata"><div class="icon"></div>No data to display</div>
			</td></tr>
		</table>
		
	<?php } ?>
	
	
	<!-- properties -->
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/properties.png" /></div>
		<div class="g_pagelabel_text">Properties</div>
	</div>
	
	<?php if ($properties) { ?>
	
		<table class="g_table zebra">
			<tr>
				<th>Title</th>
				<th colspan="2">Template</th>
				<th>Type</th>
				<th colspan="3">Created by</th>
				<th width="116">Last Edited</th>
			</tr>
		
			<?php foreach ($properties as $property => $m) { ?>
				<tr>
					<td><?php echo $m['property_title']; ?></td>
					<td width="36"><?php echo $m['template_id_code']; ?></td>
					<td><?php echo $m['template_title']; ?></td>
					<td><?php echo $m['template_type_title']; ?></td>
					<td width="32" class="h_padding0">
						<a href="<?php echo base_url(); ?>users/view/<?php echo $m['user_id']; ?>">
						<img class="g_tableavatar" src="<?php echo $m['avatar_path']; ?>?<?php echo time(); ?>" />
						</a>
					</td>
					<td><?php echo $m['username']; ?></td>
					<td><?php echo $m['first_name'] . " " . $m['last_name']; ?></td>
					<td width="116"><?php echo $m['last_edit']; ?></td>
				</tr>
			<?php } ?>
			
			<?php if ($item_count['properties'] > 10) { ?>
				<tr><td colspan="8" class="h_textalignright">
					<a 	href="javascript: void(0);" 
						data-client-id="<?php echo $m['company_id']; ?>"
						id="btn_view_properties">View all</a>
				</td></tr>
			<?php } ?>
		</table>
		
	<?php } else { ?>
	
		<table class="g_table">
			<tr><td class="h_padding20">
				<div class="g_nodata"><div class="icon"></div>No data to display</div>
			</td></tr>
		</table>
	
	<?php } ?>
		
	<!-- users -->
		
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/users.png" /></div>
		<div class="g_pagelabel_text">Users</div>
	</div>
	
	<?php if ($users) { ?>
	
		<table class="g_table zebra">
			<tr>
				<th style="min-width: 120px;">Last Name</th>
				<th style="min-width: 120px;">First Name</th>
				<th colspan="2">Username</th>
				<th>User Type</th>
				<th>Status</th>
			</tr>
			
			<?php foreach ($users as $user => $u) { ?>
				<tr>
					<td width="95"><?php echo $u['last_name']; ?></td>
					<td width="100"><?php echo $u['first_name']; ?></td>
					<td width="32" class="h_padding0">
						<a href="<?php echo base_url(); ?>users/view/<?php echo $u['user_id']; ?>">
						<img class="g_tableavatar" src="<?php echo $u['avatar_path']; ?>?<?php echo time(); ?>" />
						</a>
					</td>
					<td><?php echo $u['username']; ?></td>
					<td><?php echo $u['user_type_title']; ?></td>
					<td><?php echo ($u['account_status'] == 1) ? "Active": "Inactive"; ?></td>
				</tr>
			<?php } ?> 
			
			<?php if ($item_count['users'] > 10) { ?>
				<tr><td colspan="8" class="h_textalignright">
					<a 	href="javascript: void(0);" 
						data-client-id="<?php echo $m['company_id']; ?>"
						id="btn_view_users">View all</a>
				</td></tr>
			<?php } ?>
		</table>
	
	<?php } else { ?>
	
		<table class="g_table">
			<tr><td class="h_padding20"><div class="g_nodata"><div class="icon"></div>No data to display</div></td></tr>
		</table>
	
	<?php } ?>
	
	<!-- clients -->
	
	<?php if ($client_details['agency_id'] == 0) { ?>
		
		<div class="g_pagelabel">
			<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/clients.png" /></div>
			<div class="g_pagelabel_text">Clients</div>
		</div>
		
		<?php if ($clients) { ?>
		
			<table class="g_table zebra">
				<tr>
					<th>Company Name</th>
					<th>Company Short Name</th>
					<th>Contact Person</th>
					<th>Status</th>
				</tr>
				
				<?php foreach ($clients as $client => $c) { ?>
				<tr>
					<td><?php echo $c['title']; ?></td>
					<td><?php echo $c['title_short']; ?></td>
					<td><?php echo $c['contact_name']; ?></td>
					<td><?php echo ($c['status'] == 1) ? "Active": "Inactive"; ?></td>
				</tr>
				<?php } ?> 
			</table>
		
		<?php } else { ?>
		
			<table class="g_table">
				<tr><td class="h_padding20"><div class="g_nodata"><div class="icon"></div>No data to display</div></td></tr>
			</table>
		
		<?php } ?>
		
	<?php } ?>
	
</div>

<form id="form_view_properties" method="POST" action="<?php echo base_url(); ?>admin/properties">
	<input type="hidden" id="hidden_client_id_property" name="client_id" value="" />
	<input type="hidden" name="filter" value="1" />
</form>

<form id="form_view_users" method="POST" action="<?php echo base_url(); ?>admin/users">
	<input type="hidden" id="hidden_client_id_user" name="client_id" value="" />
	<input type="hidden" name="filter" value="1" />
</form>

<script type="text/javascript" language="javascript">
$(function(){
	zebraTable();
	checkSidebarStatus();
});

$("#btn_view_properties").click(function(){
	var client_id = $(this).attr('data-client-id');
	$("#hidden_client_id_property").val(client_id);
	$("#form_view_properties").submit();
});

$("#btn_view_users").click(function(){
	var client_id = $(this).attr('data-client-id');
	$("#hidden_client_id_user").val(client_id);
	$("#form_view_users").submit();
});
</script>