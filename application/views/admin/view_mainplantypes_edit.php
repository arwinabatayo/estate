<div id="g_content">

	<div id="g_tools"> 
		<a href="<?php echo base_url(); ?>admin/mainplantypes"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/list.png" />Main Plan Types List</a>	
		<a href="javascript: void(0);" id="btn_edit_mainplantype"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/save.png" />Save Changes</a>	
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>
	<div class="g_spacer"></div>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/add.png" /></div>
		<div class="g_pagelabel_text">Edit main plan type - <?php echo $mainplantype_details['type']; ?></div>
	</div>
	
	<table class="g_table zebra">
		<tr><td class="g_widget">
		
			<form id="form_edit_mainplantype" class="g_form">
				
				<!-- main plan type -->
				<div class="item">
					<div class="label">Main plan type *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="main_plan_type" 
								maxlength="255"
								value="<?php echo $mainplantype_details['type']; ?>"
								data-alphanum="1"				
								data-orig-val="<?php echo $mainplantype_details['type']; ?>"				
								data-unique="1"
								data-field="f_type"
								data-table="estate_main_plan_type"
								data-required="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- type description -->
				<div class="item">
					<div class="label">Type description</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="type_description" 
								maxlength="255"
								value="<?php echo $mainplantype_details['type_description']; ?>"
								data-alphanum="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- image -->
				<div class="item">
					<div class="label">Image *</div>
					<div class="input">
						<div class="mainplantype_image" id="mainplantype_image_wrapper_wrapper">
							<div id="mainplantype_image_wrapper">
								<?php if( isset($mainplantype_details['type_image']) && trim($mainplantype_details['type_image']) != '' ){ ?>
									<input type="hidden" value="<?php echo $mainplantype_details['type_image']; ?>" data-image-required="1" data-image-wrapper="mainplantype_image_wrapper_wrapper" name="mainplantype-image-name" id="mainplantype-image-name" />
									<img src="<?php echo base_url() . $this->config->item('base_mainplantype_url') . trim($mainplantype_details['type_image']); ?>" title="<?php echo trim($mainplantype_details['type_image']); ?>" alt="<?php echo trim($mainplantype_details['type_image']); ?>" class="img_mainplantype_image" />
								<?php }else{ ?>
									<input type="hidden" value="" data-image-required="1" data-image-wrapper="mainplantype_image_wrapper_wrapper" name="mainplantype-image-name" id="mainplantype-image-name" />
								<?php } ?>
							</div>
							<a id="change_mainplantype_image">Upload image</a><div id="upload_result"></div>						
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
							<option value="0" <?php if( $mainplantype_details['main_plan_type_status'] == 0 ){ echo 'selected="selected"'; }?>>Select status</option>
							<option value="1" <?php if( $mainplantype_details['main_plan_type_status'] == 1 ){ echo 'selected="selected"'; }?>>Disabled</option>
							<option value="2" <?php if( $mainplantype_details['main_plan_type_status'] == 2 ){ echo 'selected="selected"'; }?>>Enabled</option>
						</select>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<input type="hidden" value="<?php echo $mainplantype_details['main_plan_type_id']; ?>" name="main_plan_type_id" id="main_plan_type_id" />
				<input type="hidden" value="<?php echo $mainplantype_details['type_image']; ?>" name="old-mainplantype-image-name" id="old-mainplantype-image-name" />
			</form>
			
		</td></tr>
	</table>
</div>

<script type="text/javascript" language="javascript" src="<?php echo base_url() . '_assets/js/ajaxupload.3.5.js'; ?>"></script>
<script type="text/javascript" language="javascript">
$(function(){
	placeHolder();
	checkSidebarStatus();
	
	var btnUpload=$('#change_mainplantype_image');
	var mestatus=$('#upload_result');
	var files=$('#mainplantype_image_wrapper');
	new AjaxUpload( btnUpload, {
		action: '<?php echo base_url(); ?>admin/mainplantypes/upload_mainplantype_image',
		name: 'mainplantype_image',
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
				var mainplantype_image_string = '<input type="hidden" value="' + data.filename + '" data-image-required="1" data-image-wrapper="mainplantype_image_wrapper_wrapper" name="mainplantype-image-name" id="mainplantype-image-name">';
				mainplantype_image_string += '<img src="<?php echo base_url() . $this->config->item('base_mainplantype_url') . '_temp/'; ?>'+data.filename+'" title="' + data.filename + '" alt="' + data.filename + '" class="img_mainplantype_image" />';
				
				$('#mainplantype_image_wrapper').append(mainplantype_image_string);
				displayNotification("success", data.msg);
			} else{
				displayNotification("error", data.msg);
			}
		}
	});
});

$("#btn_edit_mainplantype").click(function(e){
	displayNotification("message", "Working...");
	if (validate_form("form_edit_mainplantype")) {
		$.ajax({
			url: "<?php echo base_url(); ?>admin/mainplantypes/process_edit",
			type: "POST",
			data: $("#form_edit_mainplantype").serialize(),
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#middle_wrapper").html(response);
					if (typeof history.pushState != 'undefined') { window.history.pushState("object or string", "Title", "<?php echo base_url(); ?>admin/mainplantypes"); }
					displayNotification("success", "Main plan type successfully updated.");
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	}
});

</script>