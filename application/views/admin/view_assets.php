<?php $reference_asset = 1; ?>
<?php if ($file_arr) { ?>
<?php foreach ($file_arr as $file => $f) { ?>

	<div 	class="item"
			data-reference=<?php echo $reference_asset; ?>
			data-filename="<?php echo $f['file_name']; ?>">
			<div class="inner">
				<img 	class="actual" 
						src="<?php echo $f['url_thumb']; ?>"
						data-width="<?php echo $f['size_thumb'][0]; ?>"
						data-height="<?php echo $f['size_thumb'][1]; ?>" />
			</div>
			<div class="details">
				<div class="text"><?php echo $f['file_name']; ?></div>
				<div class="text"><?php echo $f['size'][0] . " x " . $f['size'][1]; ?></div>
			</div>
	</div>
	<?php $reference_asset++; ?>

<?php } ?>
<?php } ?>

<div class="h_clearboth"></div>
<div style="height: 0px;">&nbsp;</div>

<input type="hidden" value="<?php echo $reference; ?>" id="field_to_edit" />

<script type="text/javascript" language="javsacript">
$("#asset_wrapper .item").click(function(){
	var filename = $(this).attr('data-filename');
	var fieldtoedit = $("#field_to_edit").val();
	$(".g_overlay").fadeOut(200, function(){
		$("#asset_wrapper").hide();
		$("input[data-reference='"+fieldtoedit+"']").val(filename);
		$(".additional_notes[data-reference='"+fieldtoedit+"']").removeClass("h_displaynone");
		$(".img_preview .img_actions .remove_value[data-reference='"+fieldtoedit+"']").removeClass("h_displaynone");
		$(".info[data-reference='"+fieldtoedit+"']").html('<div class="icon"></div>Field updated. Please save your changes.').fadeIn(200);
		
		// detect loading
		$(".img_preview[data-reference='"+fieldtoedit+"'] img.tobe_edited").attr("src", "<?php echo base_url() . "/_assets/images/loading.gif"; ?>");
		$("#g_preload_property_edit img").attr("src", "<?php echo $this->config->item('base_property_url') . $property_details['folder_name'] . "/assets/"; ?>"+filename);
		$("#g_preload_property_edit img").bind("load", function(){
			setTimeout(function () {
				$(".img_preview[data-reference='"+fieldtoedit+"'] img.tobe_edited").attr("src", "<?php echo $this->config->item('base_property_url') . $property_details['folder_name'] . "/assets/"; ?>"+filename);
			}, 1500);
		});		
		
		if ($(".img_preview[data-reference='"+fieldtoedit+"']").attr('data-icon')) {
			$(".img_preview[data-reference='"+fieldtoedit+"']").addClass('icon');
		}
		$(".remove_value[data-reference='"+fieldtoedit+"']").show();
		$("body").removeClass('h_overflowhidden');
	});
});

// center images inside the thumbnails
$("#asset_wrapper .item .inner .actual, #blog_asset_wrapper .item .inner .actual").each(function(){
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

$("#blog_asset_wrapper .item").click(function(e){
	var filename = $(this).attr('data-filename');
	var src_file = "<?php echo $this->config->item('base_property_url') . $property_details['folder_name'] . "/assets/"; ?>"+filename;
	tinyMCE.execCommand('mceInsertContent',false,'<img src=\"'+src_file+'\"/>');
});
</script>