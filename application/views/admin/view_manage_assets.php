<div id="g_content">

	<div id="g_tools"> 
		<a href="<?php echo base_url(); ?>admin/properties"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/list.png" />Property List</a>	
		<a href="<?php echo base_url(); ?>admin/properties/edit/<?php echo $property_details['property_id']; ?>"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/edit.png" />Edit Property</a>
		<a href="javascript: void(0);" id="btn_delete_allassets"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/deleteall.png" />Delete All Assets</a>
		<?php if ($sess_user['browser'] == "ie" || $sess_user['browser'] == "safari") { ?>
			<a href="javascript: void(0);" id="btn_toggle_asset"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/upload.png" />Upload Asset</a>
		<?php } else { ?>
			<a href="javascript: void(0);" id="btn_upload_asset"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/upload.png" />Upload Asset</a>
		<?php } ?>
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>
	
	<?php // echo $filter; ?>
	
	<form 	id="form_upload_asset" 
			action="<?php echo base_url(); ?>ajax/upload_asset" 
			method="POST" 
			enctype="multipart/form-data" 
			target="iframe_location">
		<input 	type="hidden" name="upload_type" 	value="property_asset" />
		<input 	type="hidden" name="property_title" value="<?php echo $property_details['property_title']; ?>" />
		<input 	type="hidden" name="folder_path" 	value="<?php echo $folder_path; ?>" />
		<input 	id="real_upload" type="file" name="file_to_upload" />
	</form>
	<iframe id="iframe_location" name="iframe_location" scrolling="no" src=""></iframe>
	
	<div class="g_pagelabel">
		<div class="asset_view_option">
			<a href="javascript: void(0);" class="btn_view_gallery active">Gallery View</a> |
			<a href="javascript: void(0);" class="btn_view_list">List View</a>
		</div>
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/generic.png" /></div>
		<div class="g_pagelabel_text">Manage assets - <?php echo $property_details['property_title']; ?></div>
	</div>
	
	<table class="g_table"><tr>
		<?php $reference_asset = 1; ?>
		<?php if ($file_arr) { ?>
			<td id="manage_assets_wrapper">
				<?php foreach ($file_arr as $file => $f) { ?>

					<div class="item" data-reference="<?php echo $reference_asset; ?>">
						<div class="icon">
							<img src="<?php echo base_url(); ?>_assets/images/file_types/<?php echo $f['ext']; ?>.png" />
						</div>
						<div class="label"><?php echo $f['file_name']; ?></div>
						<?php if ($f['ext'] == "jpg" || $f['ext'] == "png" || $f['ext'] == "gif") { ?>
							<div 	class="inner display_img" 
									data-url="<?php echo $f['url']; ?>" 
									data-url-thumb="<?php echo $f['url_thumb']; ?>" 
									data-width="<?php echo $f['size'][0]; ?>"
									data-height="<?php echo $f['size'][1]; ?>">
								<img 	class="actual" 
										src="<?php echo $f['url_thumb']; ?>"
										data-width-thumb="<?php echo $f['size_thumb'][0]; ?>"
										data-height-thumb="<?php echo $f['size_thumb'][1]; ?>" />
							</div>
						<?php } else if ($f['ext'] == "mp3") { ?>
							<div 	class="inner display_mp3" 
									data-url="<?php echo $f['url']; ?>" 
									data-filename="<?php echo $f['file_name']; ?>">
								<img src="<?php echo base_url(); ?>_assets/images/file_types/mp3_play.png" />
							</div>
						<?php } ?>
						<div class="details">
							<div class="text">
								<?php if ($f['ext'] == "jpg" || $f['ext'] == "png") { ?>
									<span>Dimensions:</span> <?php echo $f['size'][0] . " x " . $f['size'][1]; ?>
								<?php } else { ?>
									&nbsp;
								<?php } ?>
							</div>
							<div class="text"><span>File size:</span> <?php echo $f['file_size']; ?></div>
							<div class="text"><span>Extension:</span> <?php echo $f['ext']; ?></div>
							<div class="text actions">
								<a 	href="javascript: void(0);" 
									class="display_img" 
									data-url="<?php echo $f['url']; ?>" 
									data-url-thumb="<?php echo $f['url_thumb']; ?>" 
									data-width="<?php echo $f['size'][0]; ?>"
									data-height="<?php echo $f['size'][1]; ?>">
									View
								</a> |
								<a 	class="delete_asset" 
									href="javascript: void(0);"
									title="Delete asset" 
									data-reference="<?php echo $reference_asset; ?>"
									data-path="<?php echo $f['path']; ?>"
									data-path-thumb="<?php echo $f['path_thumb']; ?>">
									Delete
								</a>
							</div>
							<div class="h_clearboth"></div>
						</div>
					</div>
					<?php $reference_asset++; ?>

				<?php } ?>
				<div class="h_clearboth"></div>
				<div class="g_nodata h_displaynone"><div class="icon"></div>No data to display</div>
			</td>
		<?php } else { ?>
			<td class="h_padding20">
				<div class="g_nodata"><div class="icon"></div>No data to display</div>
			</td>
		<?php } ?>
	</tr></table>
		
</div>

<input type="hidden" value="<?php echo $folder_path; ?>" id="folder_path" />

<div class="g_overlay">.
	<!-- asset overlay -->
	<div id="preview_wrapper">
		<img id="preview" src="" />
		<div class="close"><img class="g_tableicon" src="<?php echo base_url(); ?>_assets/images/global_icon_close.png" /></div>
	</div> 
	
	<!-- audio player -->
	<div id="audio_wrapper">
		<?php include("view_player_audio.php"); ?>
	</div>
</div>

<script type="text/javascript" language="javascript">
// close overlay
$(".g_overlay").click(function(){
	$(".g_overlay").hide();
	$("#preview_wrapper").hide();
	$("#audio_wrapper").hide();
	$("#middle_wrapper").removeClass('h_overflowhidden');
	$(".g_overlay #preview_wrapper img#preview").attr('src', '');
});

$(".g_overlay #preview_wrapper .close").click(function(){
	$(".g_overlay").hide();
	$("#preview_wrapper").hide();
	$("#middle_wrapper").removeClass('h_overflowhidden');
	$(".g_overlay #preview_wrapper img#preview").attr('src', '');
})

// upload file custom
$('#btn_upload_asset').click(function(){
	hideAllNotifications();
	$("#real_upload").trigger('click');
});

$('#btn_toggle_asset').click(function(){
	$("#real_upload").slideToggle(200);
});

$("#real_upload").change(function(){
	$("#form_upload_asset").submit();
	displayNotification("message", "Working...");
});

$("#iframe_location").on('load', function(){
	var result = $(this).contents().find('body').html();
	if (result == "File/s uploaded successfully!") {
		$.ajax({
			url: "<?php echo base_url(); ?>admin/properties/display_assets",
			type: "POST",
			data: "property_id=<?php echo $property_details['property_id']; ?>",
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#middle_wrapper").html(response);
					displayNotification("success", "File uploaded successfully!");
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	} else if (result != "") {
		displayNotification("error", result);
	}
});

// delete asset
$("#manage_assets_wrapper .item .details .delete_asset").click(function(e){
	e.stopPropagation();
	if (confirm("Are you sure you want to delete this asset?")) {
		displayNotification("message", "Working...");
		var reference = $(this).attr('data-reference');
		var path = $(this).attr('data-path');
		var path_thumb = $(this).attr('data-path-thumb');
		$.ajax({
			url: "<?php echo base_url(); ?>admin/properties/delete_asset",
			type: "POST",
			data: "path="+path+"&path_thumb="+path_thumb+"&property_id=<?php echo $property_details['property_id']; ?>",
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#manage_assets_wrapper .item[data-reference='"+reference+"'], #manage_assets_wrapper .item_list[data-reference='"+reference+"']").hide(200, function(){
						// check if the 'no assets to display' message is to be shown
						var displayMessage = true;
						$("#manage_assets_wrapper .item").each(function(){
							if ($(this).css('display') != 'none') { displayMessage = false; }
						});
						$("#manage_assets_wrapper .item_list").each(function(){
							if ($(this).css('display') != 'none') { displayMessage = false; }
						});
						if (displayMessage) { 
							$("#manage_assets_wrapper .g_nodata").removeClass('h_displaynone');
							$("#manage_assets_wrapper").css('padding', '20px');
						}
					});
					displayNotification("success", "Asset deleted.");
				}, 1000);
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	}
});

// delete all assets
$("#btn_delete_allassets").click(function(){
	if (confirm("Are you sure you want to delete all assets for this property?\nThis step is usually done when clearing out a template's assets.")) {
		displayNotification('message', 'Working...');
		var folder_path = $("#folder_path").val();
		$.ajax({
			url: "<?php echo base_url(); ?>admin/properties/delete_allassets",
			type: "POST",
			data: "folder_path="+folder_path+"&property_id=<?php echo $property_details['property_id']; ?>",
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#middle_wrapper").html(response);
					displayNotification("success", "All assets deleted.");
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	}
});

$(".g_overlay #preview_wrapper").click(function(e){
	e.stopPropagation();
});

// trigger for overlaying the image
$(".display_img").click(function(){
	hideAllNotifications(); 
	
	var img_src = $(this).attr('data-url');
	var max_width = $(window).width()-60;
	var max_height = $(window).height()-60;
	var ratio = 0;

	$(".g_overlay #preview_wrapper img#preview").css('width', '');
	$(".g_overlay #preview_wrapper img#preview").css('height', '');
	
	$(".g_overlay #preview_wrapper").show();
	$(".g_overlay").fadeIn(500);
	$(".g_overlay #preview_wrapper img#preview").attr('src', img_src);
	
	var width = $(this).attr('data-width');
	var height = $(this).attr('data-height');
	
	// check if the current width is larger than the max
	if(width > max_width){
		ratio = max_width / width; // get ratio for scaling image
		$(".g_overlay #preview_wrapper img#preview").css("width", max_width); // set new width
		$(".g_overlay #preview_wrapper img#preview").css("height", height * ratio); // scale height based on ratio
		height = height * ratio; // reset height to match scaled image
		width = width * ratio; // reset width to match scaled image
	}

	// check if current height is larger than max
	if(height > max_height){
		ratio = max_height / height; // get ratio for scaling image
		$(".g_overlay #preview_wrapper img#preview").css("height", max_height); // set new height
		$(".g_overlay #preview_wrapper img#preview").css("width", width * ratio); // scale width based on ratio
		height = max_height;
		width = width * ratio; // reset width to match scaled image
	}
	
	var margin_left = '-'+(parseInt(width)+20)/2+'px';
	var margin_top = '-'+(parseInt(height)+20)/2+'px';

	$(".g_overlay #preview_wrapper").css('width', width);
	$(".g_overlay #preview_wrapper").css('height', height);
	
	$(".g_overlay #preview_wrapper").css('margin-left', margin_left);
	$(".g_overlay #preview_wrapper").css('margin-top', margin_top);
});

// center images inside the thumbnails
$("#manage_assets_wrapper .item .inner .actual").each(function(){
	var img_src = $(this).attr('src');
	var max_width = $(this).parent('.inner').width();
	var max_height = $(this).parent('.inner').height();
	var ratio = 0;
	var width = $(this).attr('data-width-thumb');
	var height = $(this).attr('data-height-thumb');
	
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


// change view of assets to list
$(".btn_view_list").click(function(){
	displayListView();
});

// change view of assets to gallery
$(".btn_view_gallery").click(function(){
	displayGridView();
});

function displayListView()
{
	$(".btn_view_list").addClass('active');
	$(".btn_view_gallery").removeClass('active');
	$("#manage_assets_wrapper .item").each(function(){
		$(this).removeClass('item');
		$(this).addClass('item_list');
	});
	$("#manage_assets_wrapper").addClass("h_padding30");
	$("#grid_view").val("0");
	return;
}

function displayGridView()
{
	$(".btn_view_gallery").addClass('active');
	$(".btn_view_list").removeClass('active');
	$("#manage_assets_wrapper .item_list").each(function(){
		$(this).removeClass('item_list');
		$(this).addClass('item');
	});
	$("#manage_assets_wrapper").removeClass("h_padding30");
	$("#grid_view").val("1");
	return;
}

$(".g_overlay #audio_wrapper").click(function(e){
	e.stopPropagation();
});

// trigger for playing audio files
$(".display_mp3").click(function(){
	var filename = $(this).attr('data-filename');
	var url = $(this).attr('data-url');

	$(".g_overlay").fadeIn(500);

	$("#jquery_jplayer_1").jPlayer({
		ready: function () {
			$(this).jPlayer("setMedia", {
				mp3: url
			});
		},
		swfPath: "/js",
		supplied: "mp3"
	});
	$(".jp-title ul li").html(filename);
	
	$("#audio_wrapper").fadeIn();
});
</script>