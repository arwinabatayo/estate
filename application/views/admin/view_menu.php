<div id="g_side">
	<div id="logo_wrapper">
		<a href="<?php echo base_url(); ?>">
			<?php if ($sess_user['company_logo']) { ?>
			<img src="<?php echo $sess_user['company_logo']; ?>?<?php echo time(); ?>" />
			<?php } ?>
		</a>
	</div>
	
	<div id="g_profile">
		<div id="avatar">
			<a href="<?php echo base_url(); ?>admin/account">
			<img src="<?php echo $sess_user['avatar_path']; ?>?<?php echo time(); ?>" />
			</a>
		</div>
		<div id="avatar_info">
			<div id="welcome">Welcome!</div>
			<div id="name"><?php echo $sess_user['first_name']; ?> <?php echo $sess_user['last_name']; ?></div>
			<div id="company"><?php echo $sess_user['company_name']; ?></div>
		</div>
		<div class="h_clearboth"></div>
	</div>
	
	<div id="g_profile2">
	
		<div class="links">
			<img src="<?php echo base_url(); ?>_assets/images/menu/account.png" />
			<a href="<?php echo base_url(); ?>admin/account">My Account</a> 
			<img src="<?php echo base_url(); ?>_assets/images/menu/logout.png" />
			<a href="<?php echo base_url(); ?>admin/logout">Logout</a>
			<div class="h_clearboth"></div>
		</div>
		
		<div>
			<?php 
			switch ($sess_user['user_type']) {
				case ROLE_ONLINE_SALES : 						echo "Online Sales privileges"; break;
				case ROLE_GLOBE_BUSINESS_SALES_SUPPORT_TEAM : 	echo "Globe Business Sales Support Team privileges"; break;
				case ROLE_PLATINUM_QUEUE : 						echo "Platinum Queue privileges"; break;
				case ROLE_ACCOUNT_MANAGER : 					echo "Account Manager privileges"; break;
				case ROLE_RELATIONSHIP_MANAGER : 				echo "Relationship Manager privileges"; break;
				case ROLE_AGENT_ACCESS : 						echo "Agent Access privileges"; break;
				case ROLE_SUPER_ADMIN : 						echo "Super Administrator privileges"; break;
				case ROLE_AGENCY_ADMIN : 						echo "Agency Administrator privileges"; break;
				case ROLE_COMPANY_ADMIN : 						echo "Administrator privileges"; break;
				case ROLE_COMPANY_USER : 						echo "Limited User privileges"; break;
				case ROLE_AGENT : 								echo "Agent privileges"; break;
			}
			?>
		</div>
		<?php if ($sess_user['last_login']) { ?>
			<div>Last login on <?php echo $sess_user['last_login']; ?></div/>
			<div>From IP address <?php echo $sess_user['last_login_ip']; ?></div>
		<?php } ?>
		
	</div>
	
	<div id="menu">
		<a href="<?php echo base_url(); ?>" target="_blank">Globe Estate<img src="<?php echo base_url(); ?>_assets/images/menu/home.png" title="Globe Home" /></a>
		<?php if ($sess_user['user_type'] <= ROLE_SUPER_ADMIN) { ?><a class="<?php echo ($page == 'dashboard') ? "active" : ""; ?>" href="<?php echo base_url(); ?>admin/dashboard">Dashboard<img src="<?php echo base_url(); ?>_assets/images/menu/dashboard.png" title="Dashboard" /></a><?php } ?>
		<?php if ($sess_user['user_type'] >= ROLE_AGENCY_ADMIN && $sess_user['user_type'] <= ROLE_SUPER_ADMIN) { ?><a class="<?php echo ($page == 'clients') ? "active" : ""; ?>" href="<?php echo base_url(); ?>admin/clients">Clients<img src="<?php echo base_url(); ?>_assets/images/menu/clients.png" title="Clients" /></a><?php } ?>
		<?php if ($sess_user['templates_access'] && $sess_user['user_type'] <= ROLE_SUPER_ADMIN) { ?><a class="<?php echo ($page == 'templates') ? "active" : ""; ?>" 	href="<?php echo base_url(); ?>admin/templates">Templates<img src="<?php echo base_url(); ?>_assets/images/menu/templates.png" title="Templates" /></a><?php } ?>
		<?php if ($sess_user['user_type'] <= ROLE_SUPER_ADMIN) { ?><a class="<?php echo ($page == 'properties' || $page == 'blogs') ? "active" : ""; ?>"	href="<?php echo base_url(); ?>admin/properties">Properties	<img src="<?php echo base_url(); ?>_assets/images/menu/properties.png" title="Properties" /></a><?php } ?>
		<?php if (in_array(6, $this->session->userdata('templates_allowed')) && $this->session->userdata('user_type')  == ROLE_SUPER_ADMIN ) { ?><a class="<?php echo ($page == 'ecommerce' || $page == 'userfunctions' || $page == 'accessories' || $page == 'addons' || $page == 'addonscategories' || $page == 'mainplans' || $page == 'mainplantypes' || $page == 'products') ? "active" : ""; ?>" 	href="<?php echo base_url(); ?>admin/ecommerce">E-Commerce<img src="<?php echo base_url(); ?>_assets/images/menu/properties.png" title="E-Commerce" /></a><?php } ?>
		<?php if (in_array(6, $this->session->userdata('templates_allowed')) && $this->session->userdata('user_type')  > ROLE_SUPER_ADMIN ) { ?><a class="<?php echo ($page == 'accountmanagement') ? "active" : ""; ?>" 	href="<?php echo base_url(); ?>admin/accountmanagement">Account Management<img src="<?php echo base_url(); ?>_assets/images/menu/properties.png" title="Account management" /></a><?php } ?>
		<?php if (in_array(6, $this->session->userdata('templates_allowed')) && $this->session->userdata('user_type')  > ROLE_SUPER_ADMIN ) { ?><a class="<?php echo ($page == 'ordermanagement') ? "active" : ""; ?>" 	href="<?php echo base_url(); ?>admin/ordermanagement">Order Management<img src="<?php echo base_url(); ?>_assets/images/menu/properties.png" title="Order management" /></a><?php } ?>
		<?php if ($sess_user['user_type'] <= ROLE_SUPER_ADMIN) { ?><a class="<?php echo ($page == 'users') ? "active" : ""; ?>" href="<?php echo base_url(); ?>admin/users">Users<img src="<?php echo base_url(); ?>_assets/images/menu/users.png" title="Users" /></a><?php } ?>
		<?php if ($sess_user['user_type'] <= ROLE_SUPER_ADMIN) { ?><a class="<?php echo ($page == 'reports') ? "active" : ""; ?>" href="<?php echo base_url(); ?>admin/reports">Reports<img src="<?php echo base_url(); ?>_assets/images/menu/reports.png" title="Reports" /></a><?php } ?>
		<?php /* <a class="<?php echo ($page == 'account') ? "active" : ""; ?>" href="<?php echo base_url(); ?>admin/account">My Account<img src="<?php echo base_url(); ?>_assets/images/menu/account.png" title="My Account" /></a> */ ?>
		<?php if ($sess_user['user_type'] >= ROLE_AGENCY_ADMIN && $sess_user['user_type'] <= ROLE_SUPER_ADMIN) { ?><a class="<?php echo ($page == 'settings') ? "active" : ""; ?>" href="<?php echo base_url(); ?>admin/settings">Settings<img src="<?php echo base_url(); ?>_assets/images/menu/settings.png" title="Settings" /></a><?php } ?>
		<a class="" id="sidetoggle" href="javascript:void(0);">Hide Sidebar<img src="<?php echo base_url(); ?>_assets/images/menu/sidebar_hide.png" title="Toggle Sidebar" /></a>
		<?php /* <a class="<?php echo ($page == 'logout') ? "active" : ""; ?>" href="<?php echo base_url(); ?>logout">Logout	<img src="<?php echo base_url(); ?>_assets/images/menu/logout.png" title="Logout" /></a> */ ?>
	</div>
	
	<div id="g_copyright">Copyright &copy; 2013 <?php echo $sess_user['company_name']; ?> <br/>All Rights Reserved</div>
	
</div>

<script type="text/javascript" language="javascript">
$("#sidetoggle").click(function(){
	if ($("#g_side").css('margin-left') == "-205px") { showSidebar(1); } 
	else { hideSidebar(1); }
});
</script>