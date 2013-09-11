<div class="g_pagelabel h_width80px h_floatleft">
	<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/generic.png" /></div>
	<div class="g_pagelabel_text">Filter</div>
</div>

<div id="g_filter">
<form id="form_filter_properties" class="g_form">
	
	<!-- client -->
	<?php if ($sess_user['user_type'] == ROLE_SUPER_ADMIN) { ?>
	<?php if ($clients) { ?>
	<div class="item h_floatleft h_margin0 h_marginright8">
		<div class="label h_widthauto h_paddingright10">Company</div>
		<div class="input">
			<select name="client_id" class="g_select h_width100px">
				<option value="">All</option>
				<?php foreach ($clients as $client => $c) { ?>
					<option value="<?php echo $c['client_id']; ?>" <?php echo ($filter_arr['client_id'] == $c['client_id']) ? "selected='selected'" : ""; ?>>
						<?php echo $c['title_short']; ?>
					</option>
				<?php } ?>
			</select>
		</div>
		<div class="h_clearboth"></div>
	</div>
	<?php } ?>
	<?php } ?>
	
	<!-- title -->
	<?php if ($titles) { ?>
	<div class="item h_floatleft h_margin0 h_marginright8">
		<div class="label h_widthauto h_paddingright10">Title</div>
		<div class="input">
			<select name="letter" class="g_select h_width100px">
				<option value="">All</option>
				<?php foreach ($titles as $title => $t) { ?>
					<option <?php echo ($filter_arr['letter'] == $t) ? "selected='selected'" : ""; ?>><?php echo $t; ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="h_clearboth"></div>
	</div>
	<?php } ?>
	
	<!-- template -->
	<?php if ($templates) { ?>
	<div class="item h_floatleft h_margin0 h_marginright8">
		<div class="label h_widthauto h_paddingright10">Template</div>
		<div class="input">
			<select name="template_id" class="g_select h_width100px">
				<option value="">All</option>
				<?php if ($types) { ?>
				<?php foreach ($types as $template_type => $tt) { ?>
					<optgroup label="<?php echo $tt['template_type_title']; ?>">
						<?php foreach ($templates as $template => $t) { ?>
							<?php if ($tt['template_type_id'] == $t['template_type_id']) { ?>
							<option value="<?php echo $t['template_id']; ?>" <?php echo ($filter_arr['template_id'] == $t['template_id']) ? "selected='selected'" : ""; ?>>
								<?php echo $t['title']; ?>
							</option>
							<?php } ?>
						<?php } ?>
					</optgroup>
				<?php } ?>
				<?php } ?>
			</select>
		</div>
		<div class="h_clearboth"></div>
	</div>
	<?php } ?>
	
	<!-- type -->
	<?php if ($types) { ?>
	<div class="item h_floatleft h_margin0 h_marginright8">
		<div class="label h_widthauto h_paddingright10">Type</div>
		<div class="input">
			<select name="template_type" class="g_select h_width100px">
				<option value="">All</option>
				<?php foreach ($types as $type => $t) { ?>
					<option value="<?php echo $t['template_type_id']; ?>" <?php echo ($filter_arr['template_type'] == $t['template_type_id']) ? "selected='selected'" : ""; ?>>
						<?php echo $t['template_type_title']; ?>
					</option>
				<?php } ?>
			</select>
		</div>
		<div class="h_clearboth"></div>
	</div>
	<?php } ?>
	
	<!-- created by -->
	<?php if ($users) { ?>
	<div class="item h_floatleft h_margin0 h_marginright8">
		<div class="label h_widthauto h_paddingright10">Owner</div>
		<div class="input">
			<select name="user_id" class="g_select h_width100px">
				<option value="">All</option>
				<?php foreach ($users as $user => $u) { ?>
					<option value="<?php echo $u['user_id']; ?>" <?php echo ($filter_arr['user_id'] == $u['user_id']) ? "selected='selected'" : ""; ?>>
						<?php echo $u['username']; ?>
					</option>
				<?php } ?>
			</select>
		</div>
		<div class="h_clearboth"></div>
	</div>
	<?php } ?>
	
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
		url: "<?php echo base_url(); ?>admin/properties/process_items",
		type: "POST",
		data: $("#form_filter_properties").serialize(),
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