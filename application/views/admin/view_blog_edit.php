<div id="g_content" class="blogs-wrapper">
	<div id="g_tools">
		<a href="<?php echo base_url(); ?>admin/blogs/blog_list/<?php echo $property_id; ?>"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/list.png" />Article List</a>
		<a href="javascript: void(0);" id="btn_edit_article"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/save.png" />Save Changes</a>
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>

	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/edit.png" /></div>
		<div class="g_pagelabel_text">Edit Article - <?php echo $property_details['property_title']; ?></div>
	</div>
	<table class="g_section">
		<tr>
			<td class="g_widget">
				<form id="form_add_article" class="g_form">
				
					<div class="item">
						<div class="label">Title</div>
						<div class="input">
							<input 	class="g_inputtext title" 
									type="text" 
									name="title" 
									value="<?php echo $title; ?>"
									data-required="1" />					
						</div>
						<div class="h_clearboth"></div>
					</div>	
					
					<div class="item">
						<div class="label">Category</div>
						<div class="input">					
							<select class="g_select" data-required="1" id="category" name="category">
								<option value="0" selected="selected">Select category</option>
								<?php foreach ($categories as $key => $c) { ?>
									<option <?php echo ( $c['cat_id'] == $cat ? 'selected="selected"' : '' ); ?>
										data-required="1" 
										value="<?php echo $c['cat_id']; ?>">
											<?php echo $c['cat_name']; ?>
									</option>
								<?php } ?>
							</select>
						</div>
						<div class="h_clearboth"></div>
					</div>	
					
					<div class="item">
						<div class="label">Created by</div>
						<div class="input">
							<input 	class="g_inputtext" 
									type="text" 
									name="author_name" 
									value="<?php echo $author_name; ?>"
									data-required="1" />					
						</div>
						<div class="h_clearboth"></div>
					</div>	
					
					<div class="item">
						<div class="label">Status</div>
						<div class="input">
							<select class="g_select" name="status">
								<option <?php echo ( $status == 1? 'selected="selected"' : '' ); ?> data-required="1" value="1" selected="selected">Published</option>
								<option <?php echo ( $status == 0? 'selected="selected"' : '' ); ?> data-required="1" value="0">Unpublished</option>
							</select>				
						</div>
						<div class="h_clearboth"></div>
					</div>
					
					<div class="item">
						<div class="label">Publish Date</div>
						<div class="input">
							<input 	class="g_inputtext dpicker" 
									type="text" 
									id="published" 
									name="published"
									value="<?php echo $published; ?>"
									data-required="1" />					
						</div>
						<div class="h_clearboth"></div>
					</div>
					
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
							<textarea name="content" id="content"><?php echo $content; ?></textarea>
						</div>		
					</div>					
					
					<input type="hidden" name="property_id" id="property_id" value="<?php echo $property_id; ?>" />					
					<input type="hidden" name="post_id" id="post_id" value="<?php echo $id; ?>" />					
					<input type="hidden" name="category_name" id="category_name" value="<?php echo $category; ?>" />					
					<input type="hidden" name="updated" id="updated" value="<?php echo date('Y-m-d H:i:s'); ?>" />	
					<input type="hidden" name="created" id="created" value="<?php echo $created; ?>" />						
				</form>
			</td>
		</tr>		
	</table>	
</div>

<div id="blog" class="g_overlay">
	<div id="blog_asset_wrapper"></div> <!-- asset overlay -->
</div>	

<script type="text/javascript" language="javascript">

$(function() {
	//implementDatePicker();

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

$("#btn_edit_article").click(function(){
	if (confirm("Are you sure you want to save changes?")) {
		tinyMCE.triggerSave();
		if (validate_form("form_add_article")) {
			displayNotification("message", "Working...");
			
			$.ajax({
				url: "<?php echo base_url(); ?>admin/blogs/process_edit",
				type: "POST",
				data: $("#form_add_article").serialize(),
				success: function(response, textStatus, jqXHR){
					setTimeout(function () {
						$("#middle_wrapper").html(response);
						// if (typeof history.pushState != 'undefined') { window.history.pushState("object or string", "Title", "<?php echo base_url(); ?>admin/blogs/blog_list/<?php echo $property_id; ?>"); }
						displayNotification("success", "Changes saved.");
					}, 500);
				},
				error: function(jqXHR, textStatus, errorThrown){
					displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
				}
			});
		}
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
					// alert(response);
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

</script>