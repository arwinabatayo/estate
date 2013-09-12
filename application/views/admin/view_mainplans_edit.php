<div id="g_content">

	<div id="g_tools"> 
		<a href="<?php echo base_url(); ?>admin/mainplantypes"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/list.png" />Main Plan Types List</a>	
		<a href="javascript: void(0);" id="btn_edit_mainplan"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/save.png" />Save Changes</a>	
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>
	<div class="g_spacer"></div>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/add.png" /></div>
		<div class="g_pagelabel_text">Edit main plan - <?php echo $mainplan_details['main_plan_title']; ?></div>
	</div>
	
	<table class="g_table zebra">
		<tr><td class="g_widget">
		
			<form id="form_edit_mainplan" class="g_form">
				
				<!-- main plan -->
				<div class="item">
					<div class="label">Main plan *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="main_plan" 
								maxlength="255"
								value="<?php echo $mainplan_details['main_plan_title']; ?>"
								data-orig-val="<?php echo $mainplan_details['main_plan_title']; ?>"
								data-alphanum="1"				
								data-unique="1"
								data-field="f_main_plan_title"
								data-table="estate_main_plan"
								data-required="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- plan description -->
				<div class="item">
					<div class="label">Main plan description</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="main_plan_description" 
								maxlength="255"
								value="<?php echo $mainplan_details['main_plan_description']; ?>"
								data-alphanum="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- main plan type -->
				<div class="item">
					<div class="label">Main plan type *</div>
					<div class="input">
						<select class="g_select" name="main_plan_type_id" id="main_plan_type_id" data-required="1">
							<option value="0">Select main plan type</option>
							<?php foreach( $mainplantypes as $value ){ ?>
								<option value="<?php echo $value['main_plan_type_id']; ?>" <?php if( isset($mainplan_details['main_plan_type_id']) && $mainplan_details['main_plan_type_id'] == $value['main_plan_type_id'] ){ echo 'selected="selected"'; } ?>><?php echo $value['type']; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- image -->
				<div class="item">
					<div class="label">Image *</div>
					<div class="input">
						<div class="mainplan_image" id="mainplan_image_wrapper_wrapper">
							<div id="mainplan_image_wrapper">
								<?php if( isset($mainplan_details['main_plan_image']) && trim($mainplan_details['main_plan_image']) != '' ){ ?>
									<input type="hidden" value="<?php echo $mainplan_details['main_plan_image']; ?>" data-image-required="1" data-image-wrapper="mainplan_image_wrapper_wrapper" name="mainplan-image-name" id="mainplan-image-name" />
									<img src="<?php echo base_url() . $this->config->item('base_mainplan_url') . trim($mainplan_details['main_plan_image']); ?>" title="<?php echo trim($mainplan_details['main_plan_image']); ?>" alt="<?php echo trim($mainplan_details['main_plan_image']); ?>" class="img_mainplan_image" />
								<?php }else{ ?>
									<input type="hidden" value="" data-image-required="1" data-image-wrapper="mainplan_image_wrapper_wrapper" name="mainplan-image-name" id="mainplan-image-name" />
								<?php } ?>
							</div>
							<a id="change_mainplan_image">Upload image</a><div id="upload_result"></div>						
						</div>
						<div class="clearboth"></div>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- status -->
				<div class="item">
					<div class="label">Status *</div>
					<div class="input">
						<select class="g_select" name="status" data-required="1">
							<option value="0" <?php if( $mainplan_details['main_plan_status'] == 0 ){ echo 'selected="selected"'; } ?>>Select status</option>
							<option value="1" <?php if( $mainplan_details['main_plan_status'] == 1 ){ echo 'selected="selected"'; } ?>>Disabled</option>
							<option value="2" <?php if( $mainplan_details['main_plan_status'] == 2 ){ echo 'selected="selected"'; } ?>>Enabled</option>
						</select>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<input type="hidden" value="<?php echo $main_plan_id; ?>" name="main_plan_id" id="main_plan_id" />
				<input type="hidden" value="<?php echo $mainplan_details['main_plan_image']; ?>" name="old-mainplan-image-name" id="old-mainplan-image-name" />
			</form>
			
		</td></tr>
	</table>
</div>

<script type="text/javascript" language="javascript" src="<?php echo base_url() . '_assets/js/ajaxupload.3.5.js'; ?>"></script>
<script type="text/javascript" language="javascript">
$(function(){
	placeHolder();
	checkSidebarStatus();
	
	var btnUpload=$('#change_mainplan_image');
	var mestatus=$('#upload_result');
	var files=$('#mainplan_image_wrapper');
	new AjaxUpload( btnUpload, {
		action: '<?php echo base_url(); ?>admin/mainplans/upload_mainplan_image',
		name: 'mainplan_image',
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
				var mainplan_image_string = '<input type="hidden" value="' + data.filename + '" data-image-required="1" data-image-wrapper="mainplan_image_wrapper_wrapper" name="mainplan-image-name" id="mainplan-image-name">';
				mainplan_image_string += '<img src="<?php echo base_url() . $this->config->item('base_mainplan_url') . '_temp/'; ?>'+data.filename+'" title="' + data.filename + '" alt="' + data.filename + '" class="img_mainplan_image" />';
				
				$('#mainplan_image_wrapper').append(mainplan_image_string);
				displayNotification("success", data.msg);
			} else{
				displayNotification("error", data.msg);
			}
		}
	});
});

$("#btn_edit_mainplan").click(function(e){
	displayNotification("message", "Working...");
	if (validate_form("form_edit_mainplan")) {
		var main_plan_type_id = $("#main_plan_type_id").val();
		$.ajax({
			url: "<?php echo base_url(); ?>admin/mainplans/process_edit",
			type: "POST",
			data: $("#form_edit_mainplan").serialize(),
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#middle_wrapper").html(response);
					if (typeof history.pushState != 'undefined') { window.history.pushState("object or string", "Title", "<?php echo base_url(); ?>admin/mainplans/index/"+main_plan_type_id); }
					displayNotification("success", "New main plan successfully updated.");
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	}
});

</script>