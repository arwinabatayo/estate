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
				
				<!-- property / launch -->
				<div class="item">
					<div class="label">Launch *</div>
					<div class="input">
						<select class="g_select" name="property" data-required="1">
							<option value="0" selected="selected">Select Launch</option>
							<?php foreach( $properties as $key => $value ){ ?>
								<?php if( trim($key) != "total_count" ){ ?>
									<option value="<?php echo $value['property_id']; ?>"><?php echo $value['property_title']; ?></option>
								<?php } ?>
							<?php } ?>
						</select>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- name -->
				<div class="item">
					<div class="label">Name *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="name" 
								maxlength="100"
								data-alphanum="1"				
								data-unique="1"
								data-field="name"
								data-table="estate_gadgets"
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
								maxlength="500"
								data-alphanum="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- required_pv -->
				<div class="item">
					<div class="label">Required Peso Value *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="required_pv" 
								maxlength="11"
								data-is-whole-number="1"
								data-required="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- gadget_cid -->
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
				
				<!-- data capacity -->
				<div class="item">
					<div class="label">Data capacity</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="data_capacity" 
								maxlength="50" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- network connectivity -->
				<div class="item">
					<div class="label">Network connectivity</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="network_connectivity" 
								maxlength="120" />
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
								maxlength="10"
								data-is-number="1"				
								data-required="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- discount -->
				<div class="item">
					<div class="label">Discount</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="discount" 
								maxlength="4"
								data-is-whole-number="1" />
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
								maxlength="8"
								data-is-whole-number="1"				
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
								maxlength="5"
								data-is-whole-number="1"				
								data-required="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- image -->
				<div class="item">
					<div class="label">Image *</div>
					<div class="input">
						<div class="product_image" id="product_image_wrapper_wrapper">
							<div id="product_image_wrapper">
								<input type="hidden" value="" data-image-required="1" data-image-wrapper="product_image_wrapper_wrapper" name="product-image-name" id="product-image-name" />
							</div>
							<a id="change_product_image">Upload image</a><div id="upload_result"></div>						
						</div>
						<div class="clearboth"></div>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- size -->
				<div class="item">
					<div class="label">Size</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="size" 
								maxlength="50" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- color -->
				<div class="item">
					<div class="label">Color *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="color" 
								maxlength="50" 
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
			</form>
			
		</td></tr>
	</table>
</div>

<script type="text/javascript" language="javascript" src="<?php echo base_url() . '_assets/js/ajaxupload.3.5.js'; ?>"></script>
<script type="text/javascript" language="javascript">
$(function(){
	placeHolder();
	checkSidebarStatus();
	
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
			var data = jQuery.parseJSON(response);
			files.html('');
			if(data.status==="success"){
				var product_image_string = '<input type="hidden" value="' + data.filename + '" data-image-required="1" data-image-wrapper="product_image_wrapper_wrapper" name="product-image-name" id="product-image-name">';
				product_image_string += '<img src="<?php echo base_url() . $this->config->item('base_product_url') . '_temp/'; ?>'+data.filename+'" title="' + data.filename + '" alt="' + data.filename + '" class="img_product_image" />';
				
				mestatus.html('');
				
				$('#product_image_wrapper_wrapper').css('border', '1px solid #CCC');
				$('#product_image_wrapper').append(product_image_string);
				displayNotification("success", data.msg);
			} else{
				displayNotification("error", data.msg);
			}
		}
	});
});

$("#btn_add_product").click(function(e){
	displayNotification("message", "Working...");
	if (validate_form("form_add_product")) {
		$.ajax({
			url: "<?php echo base_url(); ?>admin/products/process_add",
			type: "POST",
			data: $("#form_add_product").serialize(),
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#middle_wrapper").html(response);
					if (typeof history.pushState != 'undefined') { window.history.pushState("object or string", "Title", "<?php echo base_url(); ?>admin/products"); }
					displayNotification("success", "New product successfully added.");
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