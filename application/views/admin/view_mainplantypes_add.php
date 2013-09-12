<div id="g_content">

	<div id="g_tools"> 
		<a href="<?php echo base_url(); ?>admin/mainplantypes"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/list.png" />Main Plan Types List</a>	
		<a href="javascript: void(0);" id="btn_add_mainplantype"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/save.png" />Save Changes</a>	
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>
	<div class="g_spacer"></div>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/add.png" /></div>
		<div class="g_pagelabel_text">Add main plan type</div>
	</div>
	
	<table class="g_table zebra">
		<tr><td class="g_widget">
		
			<form id="form_add_mainplantype" class="g_form">
				
				<!-- main plan type -->
				<div class="item">
					<div class="label">Main plan type *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="main_plan_type" 
								maxlength="255"
								data-alphanum="1"				
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
								<input type="hidden" value="" data-image-required="1" data-image-wrapper="mainplantype_image_wrapper_wrapper" name="mainplantype-image-name" id="mainplantype-image-name" />
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
							<option value="0" selected="selected">Select status</option>
							<option value="1">Disabled</option>
							<option value="2">Enabled</option>
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

$("#btn_add_mainplantype").click(function(e){
	displayNotification("message", "Working...");
	if (validate_form("form_add_mainplantype")) {
		$.ajax({
			url: "<?php echo base_url(); ?>admin/mainplantypes/process_add",
			type: "POST",
			data: $("#form_add_mainplantype").serialize(),
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#middle_wrapper").html(response);
					if (typeof history.pushState != 'undefined') { window.history.pushState("object or string", "Title", "<?php echo base_url(); ?>admin/mainplantypes"); }
					displayNotification("success", "New main plan type successfully added.");
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	}
});

</script>