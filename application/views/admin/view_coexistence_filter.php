<div class="g_pagelabel h_width80px h_floatleft">
	<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/generic.png" /></div>
	<div class="g_pagelabel_text">Filter</div>
</div>

<div id="g_filter">
<form id="form_filter_coexistence" class="g_form">
	
	<!-- label -->
	<?php if ($labels) { ?>
	<div class="item h_floatleft h_margin0 h_marginright8">
		<div class="label h_widthauto h_paddingright10">Type</div>
		<div class="input">
			<select name="coextype" class="g_select h_width200px">
				<option value="b2b">Boosters / Boosters</option>
				<option value="c2b">Boosters / Combos</option>
				<option value="c2c">Combos / Combos</option>
				
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
	<input type="hidden" name="main_plan_type_id" value="<?php echo $main_plan_type_id; ?>" />
	<div class="h_clearboth"></div>
			
</form>
</div>

<div class="h_clearboth"></div>

<script type="text/javascript" language="javascript">
$(".filter_button").click(function(){ 
	displayNotification("message", "Working...");
	$.ajax({
		url: "<?php echo base_url(); ?>admin/coexistence/process_items",
		type: "POST",
		data: $("#form_filter_coexistence").serialize(),
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