<div id="g_content">

	<div id="g_tools"> 
		<a href="<?php echo base_url(); ?>admin/plans"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/list.png" />Plans List</a>	
		<a href="javascript: void(0);" id="btn_add_plan"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/save.png" />Save Changes</a>	
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>
	<div class="g_spacer"></div>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/add.png" /></div>
		<div class="g_pagelabel_text">Add plan</div>
	</div>
	
	<table class="g_table zebra">
		<tr><td class="g_widget">
			<form id="form_add_plan" class="g_form">
				
				<!-- plan title -->
				<div class="item">
					<div class="label">Title *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="title" 
								maxlength="100"
								data-alphanum="1"				
								data-unique="1"
								data-field="title"
								data-table="estate_plans"
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
				
				<!-- plan description -->
				<div class="item">
					<div class="label">Description</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="description" 
								maxlength="500"
								data-alphanum="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- plan description -->
				<div class="item">
					<div class="label">Long Description</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="long_desc" 
								maxlength="500"
								data-alphanum="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- plan amount -->
				<div class="item">
					<div class="label">Amount *</div>
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
						<select class="g_select" name="status" data-required="1">
							<option value="0" selected="selected">Select status</option>
							<option value="disabled">Disabled</option>
							<option value="enabled">Enabled</option>
						</select>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- max gadget peso value -->
				<div class="item">
					<div class="label">Max Gadget Peso value *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="max_gadget_peso_value" 
								maxlength="11"
								data-is-whole-number="1"
								data-required="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- plan peso value -->
				<div class="item">
					<div class="label">Peso value *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="peso_value" 
								maxlength="11"
								data-is-whole-number="1"
								data-required="1" />
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
	
	var btnUpload=$('#change_plan_image');
	var mestatus=$('#upload_result');
	var files=$('#plan_image_wrapper');
	new AjaxUpload( btnUpload, {
		action: '<?php echo base_url(); ?>admin/plans/upload_plan_image',
		name: 'plan_image',
		onSubmit: function(file, ext){
			 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
				mestatus.text('Only JPG, PNG or GIF files are allowed');
				return false;
			}
			displayNotification("message", "Working...");
		},
		onComplete: function(file, response){
			var data = jQuery.parseJSON(response);
			files.html('');
			if(data.status==="success"){
				var plan_image_string = '<input type="hidden" value="' + data.filename + '" data-image-required="1" data-image-wrapper="plan_image_wrapper_wrapper" name="plan-image-name" id="plan-image-name">';
				plan_image_string += '<img src="<?php echo base_url() . $this->config->item('base_plan_url') . '_temp/'; ?>'+data.filename+'" title="' + data.filename + '" alt="' + data.filename + '" class="img_plan_image" />';
				
				$('#plan_image_wrapper').append(plan_image_string);
				displayNotification("success", data.msg);
			} else{
				displayNotification("error", data.msg);
			}
		}
	});
});

$("#btn_add_plan").click(function(e){
	displayNotification("message", "Working...");
	if (validate_form("form_add_plan")) {
		$.ajax({
			url: "<?php echo base_url(); ?>admin/plans/process_add",
			type: "POST",
			data: $("#form_add_plan").serialize(),
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#middle_wrapper").html(response);
					if (typeof history.pushState != 'undefined') { window.history.pushState("object or string", "Title", "<?php echo base_url(); ?>admin/plans"); }
					displayNotification("success", "New plan successfully added.");
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
					$("#middle_wrapper").html(jqXHR.responseText);
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	}
});

</script>