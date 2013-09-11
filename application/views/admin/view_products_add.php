<div id="g_content">

	<div id="g_tools"> 
		<a href="<?php echo base_url(); ?>admin/products"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/list.png" />Products List</a>	
		<a href="javascript: void(0);" id="btn_add_product"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/save.png" />Save Changes</a>	
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>
	<div class="g_spacer"></div>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/add.png" /></div>
		<div class="g_pagelabel_text">Add product</div>
	</div>
	
	<table class="g_table zebra">
		<tr><td class="g_widget">
		
			<form id="form_add_product" class="g_form">
				
				<!-- name -->
				<div class="item">
					<div class="label">Name *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="name" 
								maxlength="255"
								data-alphanum="1"				
								data-unique="1"
								data-field="product_name"
								data-table="estate_product"
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
				
				<!-- size -->
				<div class="item">
					<div class="label">Size *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="size" 
								maxlength="11"
								data-is-number="1"				
								data-required="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- color -->
				<div class="item">
					<div class="label">Color *</div>
					<div class="input">
						<input 	class="	g_inputtext h_fontlucida h_backgroundlight"
													type="text" 
													name="color" 
													maxlength="7" 
													readonly="readonly" 
													data-colorpicker="1" 
													data-required="1" 
													value="#FFFFFF" />
						<div 	class="color_indicator" 
								data-color='#FFFFFF' 
								style="background: #FFFFFF">
						</div>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- image -->
				<div class="item">
					<div class="label">Image *</div>
					<div class="input">
						<div class="product_image">
							<div id="product-image-top-overlay">
								
							</div>
							<div id="product_image_wrapper">
							</div>
							<a id="change_product_image">Upload image</a><div id="upload_result"></div>						
						</div>
						<div class="clearboth"></div>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- amount -->
				<div class="item">
					<div class="label">Amount *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="amount" 
								maxlength="11"
								data-is-number="1"				
								data-required="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- peso value -->
				<div class="item">
					<div class="label">Peso value *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="peso_value" 
								maxlength="11"
								data-is-number="1"				
								data-required="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- quantity -->
				<div class="item">
					<div class="label">Quantity *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="quantity" 
								maxlength="11"
								data-is-number="1"				
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
							<option value="1">Disabled</option>
							<option value="2">Enabled</option>
						</select>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<input type="hidden" name="property_id" value="<?php echo $property_id; ?>" id="property_id">
			</form>
			
		</td></tr>
	</table>
</div>

<script type="text/javascript" language="javascript" src="<?php echo base_url() . '_assets/js/ajaxupload.3.5.js'; ?>"></script>
<script type="text/javascript" language="javascript">
$(function(){
	placeHolder();
	checkSidebarStatus();
	implementColorPicker();
	
	var btnUpload=$('#change_product_image');
	var mestatus=$('#upload_result');
	var files=$('#product_image_wrapper');
	new AjaxUpload( btnUpload, {
		action: '<?php echo base_url(); ?>admin/products/upload_product_image',
		name: 'product_image',
		onSubmit: function(file, ext){
			 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
				mestatus.text('Only JPG, PNG or GIF files are allowed');
				return false;
			}
			displayNotification("message", "Working...");
		},
		onComplete: function(file, response){
			alert(response);
			return;
			var data = jQuery.parseJSON(response);
			files.html('');
			if(data.status==="success"){
				var product_image_string = '<input type="hidden" value="' + data.filename + '" name="product-image-name" id="product-image-name">';
				product_image_string += '<img src="<?php echo $this->config->item('base_product_url') . '_temp/'; ?>'+data.filename+'" title="' + data.filename + '" alt="' + data.filename + '" class="product_image" />';
				
				$('#product_image_wrapper').append(product_image_string);
				displayNotification("success", data.msg);
			} else{
				displayNotification("error", data.msg);
			}
		}
	});
});

$("#btn_add_product").click(function(e){
	//displayNotification("message", "Working...");
	if (validate_form("form_add_product")) {
		/*
		$.ajax({
			url: "<?php echo base_url(); ?>admin/configurations/process_add",
			type: "POST",
			data: $("#form_add_product").serialize(),
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#middle_wrapper").html(response);
					var property_id = <?php echo $property_id; ?>;
					if (typeof history.pushState != 'undefined') { window.history.pushState("object or string", "Title", "<?php echo base_url(); ?>admin/configurations/property/"+property_id); }
					displayNotification("success", "New configuration successfully added.");
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
		*/
	}
});

</script>