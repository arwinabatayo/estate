<div id="g_content">

	<div id="g_tools">
		<?php if ($sess_user['user_type'] == ROLE_SUPER_ADMIN) { ?>
			<a href="<?php echo base_url(); ?>admin/clients"><img src="<?php echo base_url(); ?>_assets/images/tools/clients.png" />Clients</a>
		<?php } ?>
		
		<?php if ($sess_user['templates_access']) { ?>
			<a href="<?php echo base_url(); ?>admin/templates"><img src="<?php echo base_url(); ?>_assets/images/tools/templates.png" />Templates</a>
		<?php } ?>
		
		<a href="<?php echo base_url(); ?>admin/properties"><img src="<?php echo base_url(); ?>_assets/images/tools/properties.png" />Properties</a>
		<a href="<?php echo base_url(); ?>admin/users"><img src="<?php echo base_url(); ?>_assets/images/tools/users.png" />Users</a>
		<a href="<?php echo base_url(); ?>admin/reports"><img src="<?php echo base_url(); ?>_assets/images/tools/reports.png" />Reports</a>
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>
	
	<div class="h_floatleft h_width40percent"><div class="h_paddingright15"><?php include("view_widget_diskspace.php"); ?></div></div>
	<div class="h_floatright h_width60percent"><div class="h_paddingleft15"><?php include("view_widget_summary.php"); ?></div></div>
	<div class="h_clearboth"></div>
	
	<div class="h_floatleft h_width45percent"><div class="h_paddingright15"><?php include("view_widget_recentusers.php"); ?></div></div>
	<div class="h_floatright h_width55percent"><div class="h_paddingleft15"><?php include("view_widget_recenttemplates.php"); ?></div></div>
	<div class="h_clearboth"></div>
	<div class="g_spacer"></div>
	
	<?php include("view_widget_recentproperties.php"); ?>
	<?php include("view_widget_activitylog.php"); ?>
	
</div>

<script type="text/javascript" language="javascript">
$(function(){
	zebraTable();
	checkSidebarStatus();
});
</script>