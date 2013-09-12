<div id="g_content">

	<div id="g_tools"> 
		<a href="<?php echo base_url(); ?>admin/addons/index/<?php echo $addon_details['add_ons_category_id']; ?>"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/list.png" />Addons List</a>	
		<a href="javascript: void(0);" id="btn_edit_addon"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/save.png" />Save Changes</a>	
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>
	<div class="g_spacer"></div>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/add.png" /></div>
		<div class="g_pagelabel_text">Edit addon - <?php echo $addon_details['add_on_title']; ?></div>
	</div>
	
	<table class="g_table zebra">
		<tr><td class="g_widget">
		
			<form id="form_edit_addon" class="g_form">
				
				<!-- addon -->
				<div class="item">
					<div class="label">Addon *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="addon_title" 
								maxlength="255"
								value="<?php echo $addon_details['add_on_title']; ?>"
								data-orig-val="<?php echo $addon_details['add_on_title']; ?>"
								data-alphanum="1"				
								data-unique="1"
								data-field="f_add_on_title"
								data-table="estate_add_ons"
								data-required="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- addon description -->
				<div class="item">
					<div class="label">Addon description</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="addon_description" 
								maxlength="255"
								value="<?php echo $addon_details['add_on_description']; ?>"
								data-alphanum="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- addon amount -->
				<div class="item">
					<div class="label">Addon amount *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="addon_amount" 
								maxlength="11"
								value="<?php echo $addon_details['add_on_amount']; ?>"
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
							<option value="0" <?php if( $addon_details['add_on_status'] == 0 ){ echo 'selected="selected"'; } ?>>Select status</option>
							<option value="1" <?php if( $addon_details['add_on_status'] == 1 ){ echo 'selected="selected"'; } ?>>Disabled</option>
							<option value="2" <?php if( $addon_details['add_on_status'] == 2 ){ echo 'selected="selected"'; } ?>>Enabled</option>
						</select>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- addon category -->
				<div class="item">
					<div class="label">Addon category *</div>
					<div class="input">
						<select readonly="readonly" class="g_select" id="addon_category_id" name="addon_category_id" data-required="1">
							<option value="0">Select addon category</option>
							<?php foreach( $addonscategories as $value ){ ?>
								<option <?php if( $value['add_ons_category_id'] == $addon_details['add_ons_category_id'] ){ echo 'selected="selected"'; } ?> value="<?php echo $value['add_ons_category_id']; ?>"><?php echo $value['add_ons_category_title']; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- addon quantity -->
				<div class="item">
					<div class="label">Addon quantity *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="addon_quantity" 
								maxlength="11"
								value="<?php echo $addon_details['add_ons_quantity']; ?>"
								data-is-whole-number="1"
								data-required="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- image -->
				<div class="item">
					<div class="label">Image *</div>
					<div class="input">
						<div class="addon_image" id="addon_image_wrapper_wrapper">
							<div id="addon_image_wrapper">
								
								<?php if( isset($addon_details['add_on_image']) && trim($addon_details['add_on_image']) != '' ){ ?>
									<input type="hidden" value="<?php echo $addon_details['add_on_image']; ?>" data-image-required="1" data-image-wrapper="addon_image_wrapper_wrapper" name="addon-image-name" id="addon-image-name" />
									<img src="<?php echo base_url() . $this->config->item('base_addon_url') . trim($addon_details['add_on_image']); ?>" title="<?php echo trim($addon_details['add_on_image']); ?>" alt="<?php echo trim($addon_details['add_on_image']); ?>" class="img_addon_image" />
								<?php }else{ ?>
									<input type="hidden" value="" data-image-required="1" data-image-wrapper="addon_image_wrapper_wrapper" name="addon-image-name" id="addon-image-name" />
								<?php } ?>
							</div>
							<a id="change_addon_image">Upload image</a><div id="upload_result"></div>						
						</div>
						<div class="clearboth"></div>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- addon peso value -->
				<div class="item">
					<div class="label">Addon peso value *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="addon_peso_value" 
								maxlength="11"
								value="<?php echo $addon_details['add_ons_peso_value']; ?>"
								data-is-whole-number="1"
								data-required="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<input type="hidden" name="add_on_id" value="<?php echo $addon_details['add_on_id']; ?>" />
				<input type="hidden" name="old-addon-image-name" value="<?php echo $addon_details['add_on_image']; ?>" />
			</form>
			
		</td></tr>
	</table>
</div>

<script type="text/javascript" language="javascript" src="<?php echo base_url() . '_assets/js/ajaxupload.3.5.js'; ?>"></script>
<script type="text/javascript" language="javascript">
$(function(){
	placeHolder();
	checkSidebarStatus();
	
	var btnUpload=$('#change_addon_image');
	var mestatus=$('#upload_result');
	var files=$('#addon_image_wrapper');
	new AjaxUpload( btnUpload, {
		action: '<?php echo base_url(); ?>admin/addons/upload_addon_image',
		name: 'addon_image',
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
				var addon_image_string = '<input type="hidden" value="' + data.filename + '" data-image-required="1" data-image-wrapper="addon_image_wrapper_wrapper" name="addon-image-name" id="addon-image-name">';
				addon_image_string += '<img src="<?php echo base_url() . $this->config->item('base_addon_url') . '_temp/'; ?>'+data.filename+'" title="' + data.filename + '" alt="' + data.filename + '" class="img_addon_image" />';
				
				mestatus.html('');
				
				$('#addon_image_wrapper_wrapper').css('border', '1px solid #CCC');
				$('#addon_image_wrapper').append(addon_image_string);
				displayNotification("success", data.msg);
			} else{
				displayNotification("error", data.msg);
			}
		}
	});
});

$("#btn_edit_addon").click(function(e){
	displayNotification("message", "Working...");
	if (validate_form("form_edit_addon")) {
		var addons_category_id = $('#addon_category_id').val();
		$.ajax({
			url: "<?php echo base_url(); ?>admin/addons/process_edit",
			type: "POST",
			data: $("#form_edit_addon").serialize(),
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#middle_wrapper").html(response);
					if (typeof history.pushState != 'undefined') { window.history.pushState("object or string", "Title", "<?php echo base_url(); ?>admin/addons/index/" + addons_category_id); }
					displayNotification("success", "Addon successfully updated.");
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	}
});

</script>