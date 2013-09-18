<div id="g_content">
	<div id="g_tools"> 
		<a href="<?php echo base_url(); ?>admin/boosters"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/list.png" />Combos List</a>	
		<a href="javascript: void(0);" id="btn_add_booster"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/save.png" />Save Changes</a>	
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>
	<div class="g_spacer"></div>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/add.png" /></div>
		<div class="g_pagelabel_text">Add booster</div>
	</div>
	
	<table class="g_table zebra">
		<tr><td class="g_widget">
		
			<form id="form_add_booster" class="g_form">
				
				<!-- combos title -->
				<div class="item">
					<div class="label">Name *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="name" 
								maxlength="100"
								data-alphanum="1"				
								data-unique="1"
								data-field="name"
								data-table="estate_plan_bundle"
								data-required="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- cid -->
				<div class="item">
					<div class="label">CID *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="cid" 
								maxlength="11"
								data-is-whole-number="1"
								data-required="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- combos description -->
				<div class="item">
					<div class="label">Description</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="description" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- combos long description -->
				<div class="item">
					<div class="label">Long Description</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="long_description" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				
				
				<!-- combos amount -->
				<div class="item">
					<div class="label">amount</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="amount" 
								maxlength="11"
								data-is-whole-number="1"
								data-required="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- status -->
				<div class="item">
					<div class="label">Status *</div>
					<div class="input">
						<select class="g_select" name="is_active" data-required="1">
							<option value="" selected="selected">Select status</option>
							<option value="0">Disabled</option>
							<option value="1">Enabled</option>
						</select>
					</div>
					<div class="h_clearboth"></div>
				</div>
			</form>
			
		</td></tr>
	</table>
</div>

<script type="text/javascript" language="javascript" src="<?php echo base_url() . '_assets/js/ajaxupload.3.5.js'; ?>"></script>
<script type="text/javascript" language="javascript">
$(function(){
	placeHolder();
	checkSidebarStatus();
	$("#btn_add_booster").click(function(e){
		displayNotification("message", "Working...");
		if (validate_form("form_add_booster")) {
			$.ajax({
				url: "<?php echo base_url(); ?>admin/boosters/process_add",
				type: "POST",
				data: $("#form_add_booster").serialize(),
				success: function(response, textStatus, jqXHR){
					setTimeout(function () {
						$("#middle_wrapper").html(response);
						if (typeof history.pushState != 'undefined') { window.history.pushState("object or string", "Title", "<?php echo base_url(); ?>admin/boosters"); }
						displayNotification("success", "New boosters successfully added.");
					}, 500);
				},
				error: function(jqXHR, textStatus, errorThrown){
						$("#middle_wrapper").html(jqXHR.responseText);
					displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
				}
			});
		}
	});
});
</script>