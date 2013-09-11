<div class="g_pagelabel h_width80px h_floatleft">
	<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/generic.png" /></div>
	<div class="g_pagelabel_text">Filter</div>
</div>

<div id="g_filter">
<form id="form_filter_users" class="g_form">
	
	<?php /*
	<!-- last name -->
	<?php if ($letters) { ?>
	<div class="item h_floatleft h_margin0 h_marginright8">
		<div class="label h_widthauto h_paddingright10">Last Name</div>
		<div class="input">
			<select name="last_name" class="g_select h_width100px">
				<option value="">All</option>
				<?php foreach ($letters as $letter => $l) { ?>
					<option <?php echo ($filter_arr['last_name'] == $l) ? "selected='selected'" : ""; ?>><?php echo $l; ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="h_clearboth"></div>
	</div>
	<?php } ?>
	
	<!-- last name -->
	<?php if ($letters) { ?>
	<div class="item h_floatleft h_margin0 h_marginright8">
		<div class="label h_widthauto h_paddingright10">First Name</div>
		<div class="input">
			<select name="first_name" class="g_select h_width100px">
				<option value="">All</option>
				<?php foreach ($letters as $letter => $l) { ?>
					<option <?php echo ($filter_arr['first_name'] == $l) ? "selected='selected'" : ""; ?>><?php echo $l; ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="h_clearboth"></div>
	</div>
	<?php } ?>
	*/ ?>
	
	<!-- company -->
	<?php if ($sess_user['user_type'] >= ROLE_AGENCY_ADMIN) { ?>
	<?php if ($clients) { ?>
	<div class="item h_floatleft h_margin0 h_marginright8">
		<div class="label h_widthauto h_paddingright10">Company</div>
		<div class="input">
			<select name="client_id" class="g_select h_width100px">
				<option value="">All</option>
				<?php foreach ($clients as $client => $c) { ?>
					<option value="<?php echo $c['client_id']; ?>" <?php echo ($filter_arr['client_id'] == $c['client_id']) ? "selected='selected'" : ""; ?>>
						<?php echo $c['title']; ?>
					</option>
				<?php } ?>
			</select>
		</div>
		<div class="h_clearboth"></div>
	</div>
	<?php } ?>
	<?php } ?>
	
	<!-- username -->
	<?php if ($letters) { ?>
	<div class="item h_floatleft h_margin0 h_marginright8">
		<div class="label h_widthauto h_paddingright10">Username</div>
		<div class="input">
			<select name="username" class="g_select h_width100px">
				<option value="">All</option>
				<?php foreach ($letters as $letter => $l) { ?>
					<option <?php echo ($filter_arr['username'] == $l) ? "selected='selected'" : ""; ?>><?php echo $l; ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="h_clearboth"></div>
	</div>
	<?php } ?>
	
	<!-- user type -->
	<?php if ($user_types) { ?>
	<div class="item h_floatleft h_margin0 h_marginright8">
		<div class="label h_widthauto h_paddingright10">User Type</div>
		<div class="input">
			<select name="user_type_id" class="g_select h_width100px">
				<option value="">All</option>
				<?php foreach ($user_types as $user_type => $ut) { ?>
					<option value="<?php echo $ut['user_type_id']; ?>" <?php echo ($filter_arr['user_type_id'] == $ut['user_type_id']) ? "selected='selected'" : ""; ?>>
						<?php echo $ut['title']; ?>
					</option>
				<?php } ?>
			</select>
		</div>
		<div class="h_clearboth"></div>
	</div>
	<?php } ?>
	
	<!-- status -->
	<div class="item h_floatleft h_margin0 h_marginright8">
		<div class="label h_widthauto h_paddingright10">Status</div>
		<div class="input">
			<select name="status" class="g_select h_width100px">
				<option value="">All</option>
				<option value="active" <?php echo ($filter_arr['status'] == 'active') ? "selected='selected'" : ""; ?>>Active</option>
				<option value="inactive" <?php echo ($filter_arr['status'] == 'inactive') ? "selected='selected'" : ""; ?>>Inactive</option>					
			</select>
		</div>
		<div class="h_clearboth"></div>
	</div>
	
	<!-- filter button -->
	<div class="item h_floatleft h_margin0 h_marginright8">
		<div class="input">
			<input type="button" class="filter_button g_inputbutton h_margin0" value="Filter" />
		</div>
		<div class="h_clearboth"></div>
	</div>
	
	<input type="hidden" name="filter" value="1" />
	<input type="hidden" name="current_page" value="1" />
	<div class="h_clearboth"></div>
		
</form>
</div>

<div class="h_clearboth"></div>

<script type="text/javascript" language="javascript">
$(".filter_button").click(function(){ 
	displayNotification("message", "Working...");
	$.ajax({
		url: "<?php echo base_url(); ?>admin/users/process_items",
		type: "POST",
		data: $("#form_filter_users").serialize(),
		success: function(response, textStatus, jqXHR){
			setTimeout(function () {
				$("#middle_wrapper").html(response);
				displayNotification('success', 'Displaying filtered results');
			}, 500);
		},
		error: function(jqXHR, textStatus, errorThrown){
			displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
		}
	});
	
});
</script>