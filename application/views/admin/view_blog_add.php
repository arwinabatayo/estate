<div id="g_content" class="blogs-wrapper">
	<div id="g_tools">
		<a href="<?php echo base_url(); ?>admin/blogs/blog_list/<?php echo $property_id; ?>"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/list.png" />Article List</a>
		<a href="javascript: void(0);" id="btn_add_article"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/save.png" />Save Changes</a>
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>

	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/add.png" /></div>
		<div class="g_pagelabel_text">New Article - <?php echo $property_details['property_title']; ?></div>
	</div>
	
	<table class="g_table	">
		<tr>
			<td class="g_widget">		
				<div class="h_floatleft">
					<form id="form_add_article" class="g_form">
						<div class="item">
							<div class="label">Title</div>
							<div class="input">
								<input 	class="g_inputtext title" 
										type="text" 
										name="title" 
										data-required="1" />					
							</div>
							<div class="h_clearboth"></div>
						</div>					
						<div class="item h_floatleft">
							<div class="label">Category</div>
							<div class="input">					
								<select class="g_select" data-required="1" id="category" name="category">
									<option value="0" selected="selected">Select category</option>
									<?php foreach ($categories as $category => $c) { ?>
											<option data-required="1" value="<?php echo $c['cat_id']; ?>"><?php echo $c['cat_name']; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>	
						<div class="item h_floatleft h_marginleft30">
							<div class="label">Created by</div>
							<div class="input">
								<input 	class="g_inputtext" 
										type="text" 
										name="author_name" 
										data-required="1" />					
							</div>
							<div class="h_clearboth"></div>
						</div>	
						<div class="item h_floatleft">
							<div class="label">Status</div>
							<div class="input">
								<select class="g_select" name="status">
									<option data-required="1" value="1" selected="selected">Published</option>
									<option data-required="1" value="0">Unpublished</option>
								</select>				
							</div>
						</div>
						<div class="item h_floatleft h_marginleft30">
							<div class="label">Publish Date</div>
							<div class="input">
								<input 	class="g_inputtext dpicker" 
										type="text" 
										id="published" 
										name="published" 
										data-required="1" />					
							</div>
							<div class="h_clearboth"></div>
						</div>
						<div class="h_clearboth"></div>
						
						<div style="width: 950px;">
							<div class="item h_floatleft h_margintop10">
								<div class="label h_bordernone">Article Content</div>
								<div class="h_clearboth"></div>
							</div>
							
							<div class="h_floatright h_positionrelative">
								<input type="button" class="h_margin0 h_paddingleft35 insert_indicator g_inputbutton" value="Insert Image"/>
								<div class="insert_img_icon"><img src="<?php echo base_url(); ?>_assets/images/global_icon_assets.png" /></div>
							</div>								
						
							<div class="h_clearboth"></div>
						
							<div class="item">
								<textarea name="content" id="content"></textarea>
							</div>
						</div>

						<input type="hidden" name="property_id" id="property_id" value="<?php echo $property_id; ?>" />					
						<input type="hidden" name="category_name" id="category_name" value="" />					
						<input type="hidden" name="created" id="created" value="<?php echo date('Y-m-d H:i:s'); ?>" />					
					</form>
				</div>
			</td>
		</tr>
	</table>
</div>
<div id="blog" class="g_overlay">
	<div id="blog_asset_wrapper"></div> <!-- asset overlay -->
	<div id="editor_wrapper"></div> <!-- custom text/html editor overlay -->
</div>	

<script type="text/javascript" language="javascript">
$(function() {

	$( "#published" ).datepicker({ dateFormat: 'yy-mm-dd <?php echo date("Y-m-d H:i:s"); ?>' });
	
	$("#category").change(function() {	
		var text = $("#category option:selected").text();
		$('#category_name').val(text);	
		
	});
});

tinyMCE.init({
	mode  : "textareas",
	theme : "advanced",
	width : "950",
	height: "400",
	theme_advanced_statusbar_location : "none", 
	theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect,|,forecolor,backcolor,|,pagebreak",
	theme_advanced_buttons2 : "tablecontrols,|,bullist,numlist,|,outdent,indent,blockquote,|,link,unlink,anchor,image,|,code",
	theme_advanced_buttons3 : "",
	theme_advanced_buttons4 : "",
	relative_urls : true,
	remove_script_host : false,
	//document_base_url: "<?php echo $this->config->item('base_property_url') . $property_details['folder_name']; ?>"	,
	document_base_url: "<BASE_URL>"	,
	force_br_newlines : true,
	force_p_newlines : false,
	plugins : "paste,table,pagebreak",
	paste_text_sticky : true,
	setup : function(ed) {
		ed.onInit.add(function(ed) {
			ed.pasteAsPlainText = true;
		});
	}
});

$("#btn_add_article").click(function(){
	tinyMCE.triggerSave();
	if (validate_form("form_add_article")) {
		displayNotification("message", "Working...");
		
		$.ajax({
			url: "<?php echo base_url(); ?>admin/blogs/process_add",
			type: "POST",
			data: $("#form_add_article").serialize(),
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#middle_wrapper").html(response);
					if (typeof history.pushState != 'undefined') { window.history.pushState("object or string", "Title", "<?php echo base_url(); ?>admin/blogs/blog_list/<?php echo $property_id; ?>"); }
					displayNotification("success", "New article successfully added.");
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	}
});

// close overlay
$(".g_overlay").click(function(){
	$(".g_overlay").hide();
	$("#blog_asset_wrapper").hide();
	$("#editor_wrapper").hide();
	$("#upload_wrapper").hide();
	$("body").removeClass('h_overflowhidden');
});

// insert image to editor
$('.insert_indicator').each(function(){
	$(this).click(function(){
		var reference = $(this).attr("data-reference");
		displayNotification("message", "Working...");
		$.ajax({
			url: "<?php echo base_url(); ?>admin/properties/display_assets",
			type: "POST",
			data: "property_id="+$("#property_id").val()+"&reference="+reference,
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					//alert(response);
					$("#blog_asset_wrapper").html(response);
					$("body").addClass('h_overflowhidden');
					$("#blog_asset_wrapper").show();
					$(".g_overlay").fadeIn();
					hideAllNotifications();
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	});
});



// center images inside the thumbnails
$("#blog_asset_wrapper .item .inner .actual").each(function(){
	var img_src = $(this).attr('src');
	var max_width = $(this).parent('.inner').width();
	var max_height = $(this).parent('.inner').height();
	console.log(max_width);
	var ratio = 0;
	var width = $(this).attr('data-width');
	var height = $(this).attr('data-height');
	
	// check if the current width is larger than the max
	if(width > max_width){
		ratio = max_width / width; // get ratio for scaling image
		$(this).css("width", max_width); // set new width
		$(this).css("height", height * ratio); // scale height based on ratio
		height = height * ratio; // reset height to match scaled image
		width = width * ratio; // reset width to match scaled image
	}

	// check if current height is larger than max
	if(height > max_height){
		ratio = max_height / height; // get ratio for scaling image
		$(this).css("height", max_height); // set new height
		$(this).css("width", width * ratio); // scale width based on ratio
		height = max_height;
		width = width * ratio; // eeset width to match scaled image
	}
	
	var margin_left = '-'+(parseInt(width))/2+'px';
	var margin_top = '-'+(parseInt(height))/2+'px';

	$(this).css('width', width);
	$(this).css('height', height);
	
	$(this).css('margin-left', margin_left);
	$(this).css('margin-top', margin_top);
});
</script>