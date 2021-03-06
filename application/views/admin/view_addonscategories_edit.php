<div id="g_content">

	<div id="g_tools"> 
		<a href="<?php echo base_url(); ?>admin/addonscategories"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/list.png" />Addons Categories List</a>	
		<a href="javascript: void(0);" id="btn_edit_addonscategory"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/save.png" />Save Changes</a>	
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>
	<div class="g_spacer"></div>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/add.png" /></div>
		<div class="g_pagelabel_text">Edit Addons Category - <?php echo $addonscategory_details['add_ons_category_title']; ?></div>
	</div>
	
	<table class="g_table zebra">
		<tr><td class="g_widget">
		
			<form id="form_edit_addonscategory" class="g_form">
				
				<!-- category title -->
				<div class="item">
					<div class="label">Addons category *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="add_ons_category_title" 
								maxlength="200"
								value="<?php echo $addonscategory_details['category_title']; ?>"
								data-orig-val="<?php echo $addonscategory_details['category_title']; ?>"
								data-alphanum="1"				
								data-unique="1"
								data-field="category_title"
								data-table="estate_add_ons_category"
								data-required="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- category description -->
				<div class="item">
					<div class="label">Addons category description</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="add_ons_category_description" 
								maxlength="500"
								value="<?php echo $addonscategory_details['category_description']; ?>"
								data-alphanum="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- image -->
				<div class="item">
					<div class="label">Image *</div>
					<div class="input">
						<div class="addonscategory_image" id="addonscategory_image_wrapper_wrapper">
							<div id="addonscategory_image_wrapper">
								<?php if( isset($addonscategory_details['category_image']) && trim($addonscategory_details['category_image']) != '' ){ ?>
									<input type="hidden" value="<?php echo $addonscategory_details['category_image']; ?>" data-image-required="1" data-image-wrapper="addonscategory_image_wrapper_wrapper" name="addonscategory-image-name" id="addonscategory-image-name" />
									<img src="<?php echo base_url() . $this->config->item('base_addonscategory_url') . trim($addonscategory_details['category_image']); ?>" title="<?php echo trim($addonscategory_details['category_image']); ?>" alt="<?php echo trim($addonscategory_details['category_image']); ?>" class="img_addonscategory_image" />
								<?php }else{ ?>
									<input type="hidden" value="" data-image-required="1" data-image-wrapper="addonscategory_image_wrapper_wrapper" name="addonscategory-image-name" id="addonscategory-image-name" />
								<?php } ?>
							</div>
							<a id="change_addonscategory_image">Upload image</a><div id="upload_result"></div>						
						</div>
						<div class="clearboth"></div>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- is_multiple -->
				<div class="item">
					<div class="label">Is multiple *</div>
					<div class="input">
						<select class="g_select" name="is_multiple" data-required="1">
							<option value="0">Select status</option>
							<option value="no" <?php if( isset($addonscategory_details['is_multiple']) && $addonscategory_details['is_multiple'] == 0 ){ echo 'selected="selected"'; } ?>>No</option>
							<option value="yes" <?php if( isset($addonscategory_details['is_multiple']) && $addonscategory_details['is_multiple'] == 1 ){ echo 'selected="selected"'; } ?>>Yes</option>
						</select>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<input type="hidden" value="<?php echo $addonscategory_id; ?>" name="addonscategory_id" id="addonscategory_id" />
				<input type="hidden" value="<?php echo $addonscategory_details['category_image']; ?>" name="old-addonscategory-image-name" id="old-addonscategory-image-name" />
			</form>
			
		</td></tr>
	</table>
</div>

<script type="text/javascript" language="javascript" src="<?php echo base_url() . '_assets/js/ajaxupload.3.5.js'; ?>"></script>
<script type="text/javascript" language="javascript">
$(function(){
	placeHolder();
	checkSidebarStatus();
	
	var btnUpload=$('#change_addonscategory_image');
	var mestatus=$('#upload_result');
	var files=$('#addonscategory_image_wrapper');
	new AjaxUpload( btnUpload, {
		action: '<?php echo base_url(); ?>admin/addonscategories/upload_addonscategory_image',
		name: 'addonscategory_image',
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
				var addonscategory_image_string = '<input type="hidden" value="' + data.filename + '" data-image-required="1" data-image-wrapper="addonscategory_image_wrapper_wrapper" name="addonscategory-image-name" id="addonscategory-image-name">';
				addonscategory_image_string += '<img src="<?php echo base_url() . $this->config->item('base_addonscategory_url') . '_temp/'; ?>'+data.filename+'" title="' + data.filename + '" alt="' + data.filename + '" class="img_addonscategory_image" />';
				
				mestatus.html('');
				
				$('#addonscategory_image_wrapper_wrapper').css('border', '1px solid #CCC');
				$('#addonscategory_image_wrapper').append(addonscategory_image_string);
				displayNotification("success", data.msg);
			} else{
				displayNotification("error", data.msg);
			}
		}
	});
});

$("#btn_edit_addonscategory").click(function(e){
	displayNotification("message", "Working...");
	if (validate_form("form_edit_addonscategory")) {
		$.ajax({
			url: "<?php echo base_url(); ?>admin/addonscategories/process_edit",
			type: "POST",
			data: $("#form_edit_addonscategory").serialize(),
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#middle_wrapper").html(response);
					if (typeof history.pushState != 'undefined') { window.history.pushState("object or string", "Title", "<?php echo base_url(); ?>admin/addonscategories"); }
					displayNotification("success", "Addons category successfully updated.");
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	}
});

</script>