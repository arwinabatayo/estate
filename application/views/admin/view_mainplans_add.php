<div id="g_content">

	<div id="g_tools"> 
		<a href="<?php echo base_url(); ?>admin/mainplans/index/<?php echo $main_plan_type_id; ?>"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/list.png" />Main Plans List</a>	
		<a href="javascript: void(0);" id="btn_add_mainplan"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/save.png" />Save Changes</a>	
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>
	<div class="g_spacer"></div>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/add.png" /></div>
		<div class="g_pagelabel_text">Add main plan</div>
	</div>
	
	<table class="g_table zebra">
		<tr><td class="g_widget">
		
			<form id="form_add_mainplan" class="g_form">
				
				<!-- main plan -->
				<div class="item">
					<div class="label">Main plan *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="main_plan" 
								maxlength="255"
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
								data-alphanum="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- main plan type -->
				<div class="item">
					<div class="label">Main plan type *</div>
					<div class="input">
						<select class="g_select" name="main_plan_type_id" data-required="1">
							<option value="0" selected="selected">Select main plan type</option>
							<?php foreach( $mainplantypes as $value ){ ?>
								<option value="<?php echo $value['main_plan_type_id']; ?>"><?php echo $value['type']; ?></option>
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
								<input type="hidden" value="" data-image-required="1" data-image-wrapper="mainplan_image_wrapper_wrapper" name="mainplan-image-name" id="mainplan-image-name" />
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
							<option value="0" selected="selected">Select status</option>
							<option value="1">Disabled</option>
							<option value="2">Enabled</option>
						</select>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<input type="hidden" value="<?php echo $main_plan_type_id; ?>" name="main_plan_type_id" id="main_plan_type_id" />
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

$("#btn_add_mainplan").click(function(e){
	displayNotification("message", "Working...");
	if (validate_form("form_add_mainplan")) {
		$.ajax({
			url: "<?php echo base_url(); ?>admin/mainplans/process_add",
			type: "POST",
			data: $("#form_add_mainplan").serialize(),
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#middle_wrapper").html(response);
					if (typeof history.pushState != 'undefined') { window.history.pushState("object or string", "Title", "<?php echo base_url(); ?>admin/mainplans/index/<?php echo $main_plan_type_id; ?>"); }
					displayNotification("success", "New main plan successfully added.");
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	}
});

</script>