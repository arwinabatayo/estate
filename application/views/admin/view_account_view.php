<div id="g_content">

	<div id="g_tools">
		<a href="<?php echo base_url(); ?>admin/account/edit"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/edit.png" />Edit Account</a>
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>
	<div class="g_spacer"></div>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/account.png" /></div>
		<div class="g_pagelabel_text">Account Details</div>
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
	
	<!-- company details -->
	
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
			</tr>
		
			<?php foreach ($features as $feature => $f) { ?>
				<tr>
					<td><?php echo $f['feature_title']; ?></td>
					<td><?php echo $f['feature_desc']; ?></td>
					<td><?php echo $f['limit']; ?></td>
				</tr>
			<?php } ?>
			
		</table>
			
	<?php } else { ?>
	
		<table class="g_table">
			<tr><td class="h_padding20"><div class="g_nodata"><div class="icon"></div>No data to display</div></td></tr>
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
				<th width="116">Last Edited</th>
			</tr>
			
			<?php foreach ($properties as $property => $m) { ?>
				<tr>
					<td><?php echo $m['title']; ?></td>
					<td width="37"><?php echo $m['template_id_code']; ?></td>
					<td><?php echo $m['template_title']; ?></td>
					<td><?php echo $m['template_type_title']; ?></td>
					<td width="116"><?php echo $m['last_edit']; ?></td>
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
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/reports.png" /></div>
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
</script>