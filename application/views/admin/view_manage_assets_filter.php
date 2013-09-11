<div class="g_pagelabel h_width80px h_floatleft">
	<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/generic.png" /></div>
	<div class="g_pagelabel_text">Filter</div>
</div>

<div id="g_filter">
<form id="form_filter_assets" class="g_form">
	
	<!-- letters -->
	<?php if ($titles) { ?>
	<div class="item h_floatleft h_margin0 h_marginright8">
		<div class="label h_widthauto h_paddingright10">File Name</div>
		<div class="input">
			<select name="file_name" class="g_select h_width100px">
				<option value="">All</option>
				<?php foreach ($titles as $title => $t) { ?>
					<option <?php echo ($filter_arr['letter'] == $t) ? "selected='selected'" : ""; ?> value="<?php echo $t; ?>"><?php echo $t; ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="h_clearboth"></div>
	</div>
	<?php } ?>
	
	<?php /*
	<!-- users -->
	<?php if ($users) { ?>
	<div class="item h_floatleft h_margin0 h_marginright8">
		<div class="label h_widthauto h_paddingright10">User</div>
		<div class="input">
			<select name="user_id" class="g_select h_width100px">
				<option value="">All</option>
				<?php foreach ($users as $user => $u) { ?>
					<option <?php echo ($filter_arr['user_id'] == $u['user_id']) ? "selected='selected'" : ""; ?> value="<?php echo $u['user_id']; ?>">
						<?php echo $u['username']; ?>
					</option>
				<?php } ?>
			</select>
		</div>
		<div class="h_clearboth"></div>
	</div>
	<?php } ?>
	*/ ?>
	
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
		url: "<?php echo base_url(); ?>admin/properties/manage_assets/<?php echo $property_id; ?>",
		type: "POST",
		data: $("#form_filter_assets").serialize(),
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