<div id="g_content">

	<div id="g_tools"> 
		<a href="<?php echo base_url(); ?>admin/properties"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/list.png" />Property List</a>	
		<a href="javascript: void(0);" id="btn_add_property"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/save.png" />Save Changes</a>	
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>
	<div class="g_spacer"></div>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/add.png" /></div>
		<div class="g_pagelabel_text">Add property</div>
	</div>
	
	<table class="g_table zebra">
		<tr><td class="g_widget">
		
			<form id="form_add_property" class="g_form">
				
				<!-- client -->
				<div class="item">
					<div class="label">Client *</div>
					<div class="input">
						<?php if ($sess_user['user_type'] >= ROLE_AGENCY_ADMIN) { ?>
							<select class="g_select" name="client_id" data-required="1">
								<option value="0" selected="selected">Select client</option>
								<?php if ($clients) { ?>
								<?php foreach ($clients as $client => $c) { ?>
									<option data-required="1" value="<?php echo $c['client_id']; ?>"><?php echo $c['title']; ?></option>
								<?php } ?>
								<?php } ?>
							</select>
						<?php } else { ?>
							<input type="text" class="g_inputtext h_backgroundlight" readonly="readonly" value="<?php echo $sess_user['company_name']; ?>" />
							<input type="hidden" name="client_id" value="<?php echo $sess_user['company_id']; ?>" />
						<?php } ?>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- template -->
				<div class="item">
					<div class="label">Template *</div>
					<div class="input">
						<select class="g_select" name="template_id" data-required="1">
							<option value="0" selected="selected">Select template</option>
							<?php if ($template_types) { ?>
							<?php foreach ($template_types as $template_type => $tt) { ?>
								<?php if( $tt['template_type_id'] == 6 ){ ?>
									<optgroup label="<?php echo $tt['template_type_title']; ?>">	
										<?php if ($templates) { ?>
										<?php foreach ($templates as $template => $t) { ?>
											<?php if ($tt['template_type_id'] == $t['template_type_id']) { ?>
												<option data-required="1" 
														<?php echo ($template_id == $t['template_id']) ? "selected='selected'" : ""; ?>
														value="<?php echo $t['template_id']; ?>">
													<?php echo $t['title']; ?>
												</option>
											<?php } ?>
										<?php } ?>
										<?php } ?>
									</optgroup>
								<?php } ?>
							<?php } ?>
							<?php } ?>
						</select>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- title -->
				<div class="item">
					<div class="label">Title *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="title" 
								maxlength="128"
								data-alphanum="1"				
								data-unique="1"
								data-field="title"
								data-table="properties"
								data-required="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- description -->
				<div class="item">
					<div class="label">Description</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="description" 
								maxlength="512"
								data-alphanum="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- description -->
				<div class="item">
					<div class="label">Copy images from template?</div>
					<div class="input">
						<select class="g_select" name="with_assets">
							<option value="yes">Yes</option>
							<option value="no" selected="selected">No</option>
						</select>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- product -->
				<div class="item">
					<div class="label">Product</div>
					<div class="input">
						<select class="g_select" name="product" data-required="1">
							<option value="0" selected="selected">Select product</option>
							<?php foreach( $products as $key => $value ){ ?>
								<option data-required="1" value="<?php echo $value['product_id']; ?>">
									<?php echo $value['product_name']; ?>
								</option>
							<?php } ?>
						</select>
					</div>
					<div class="h_clearboth"></div>
				</div>
			
			</form>
			
		</td></tr>
	</table>

</div>

<input type="hidden" value="<?php echo $page_sub; ?>" id="_page" />

<script type="text/javascript" language="javascript">
$(function(){
	placeHolder();
	checkSidebarStatus();
});

$("#btn_add_property").click(function(e){
	displayNotification("message", "Working...");
	if (validate_form("form_add_property")) {
		$.ajax({
			url: "<?php echo base_url(); ?>admin/properties/process_add",
			type: "POST",
			data: $("#form_add_property").serialize(),
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#middle_wrapper").html(response);
					if ($("#_page").val() == "edit") {
						var property_id = $("#property_id").val();
						if (typeof history.pushState != 'undefined') { window.history.pushState("object or string", "Title", "<?php echo base_url(); ?>admin/properties/edit/"+property_id); }
						displayNotification("success", "New property successfully added. All assets from the template successfully copied. You can now customize your site.");
					} else if ($("#_page").val() == "add") { 
						displayNotification("error", "You have reached the maximum number of sites created allowed for this template.");
					}
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	}
});
</script>