<div id="g_content">

	<div id="g_tools"> 
		<a href="<?php echo base_url(); ?>admin/accessories"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/list.png" />Accessories List</a>	
		<a href="javascript: void(0);" id="btn_add_accessory"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/save.png" />Save Changes</a>	
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>
	<div class="g_spacer"></div>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/add.png" /></div>
		<div class="g_pagelabel_text">Add accessory</div>
	</div>
	
	<table class="g_table zebra">
		<tr><td class="g_widget">
		
			<form id="form_add_accessory" class="g_form">
				
				<!-- accessory title -->
				<div class="item">
					<div class="label">Title *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="accessories_title" 
								maxlength="100"
								data-alphanum="1"				
								data-unique="1"
								data-field="title"
								data-table="estate_accessories"
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
								name="accessories_cid" 
								maxlength="11"
								data-is-whole-number="1"
								data-required="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- accessory description -->
				<div class="item">
					<div class="label">Description</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="accessories_description" 
								maxlength="500"
								data-alphanum="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- accessory amount -->
				<div class="item">
					<div class="label">Amount *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="accessories_amount" 
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
				
				<!-- accessory quantity -->
				<div class="item">
					<div class="label">Quantity *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="accessories_quantity" 
								maxlength="11"
								data-is-whole-number="1"
								data-required="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- image -->
				<div class="item">
					<div class="label">Image *</div>
					<div class="input">
						<div class="accessory_image" id="v_image_wrapper_wrapper">
							<div id="accessory_image_wrapper">
								<input type="hidden" value="" data-image-required="1" data-image-wrapper="accessory_image_wrapper_wrapper" name="accessory-image-name" id="accessory-image-name" />
							</div>
							<a id="change_accessory_image">Upload image</a><div id="upload_result"></div>						
						</div>
						<div class="clearboth"></div>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- accessory peso value -->
				<div class="item">
					<div class="label">Peso value *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="accessories_peso_value" 
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
	
	var btnUpload=$('#change_accessory_image');
	var mestatus=$('#upload_result');
	var files=$('#accessory_image_wrapper');
	new AjaxUpload( btnUpload, {
		action: '<?php echo base_url(); ?>admin/accessories/upload_accessory_image',
		name: 'accessory_image',
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
				var accessory_image_string = '<input type="hidden" value="' + data.filename + '" data-image-required="1" data-image-wrapper="accessory_image_wrapper_wrapper" name="accessory-image-name" id="accessory-image-name">';
				accessory_image_string += '<img src="<?php echo base_url() . $this->config->item('base_accessory_url') . '_temp/'; ?>'+data.filename+'" title="' + data.filename + '" alt="' + data.filename + '" class="img_accessory_image" />';
				
				$('#accessory_image_wrapper').append(accessory_image_string);
				displayNotification("success", data.msg);
			} else{
				displayNotification("error", data.msg);
			}
		}
	});
});

$("#btn_add_accessory").click(function(e){
	displayNotification("message", "Working...");
	if (validate_form("form_add_accessory")) {
		$.ajax({
			url: "<?php echo base_url(); ?>admin/accessories/process_add",
			type: "POST",
			data: $("#form_add_accessory").serialize(),
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#middle_wrapper").html(response);
					if (typeof history.pushState != 'undefined') { window.history.pushState("object or string", "Title", "<?php echo base_url(); ?>admin/accessories"); }
					displayNotification("success", "New accessory successfully added.");
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