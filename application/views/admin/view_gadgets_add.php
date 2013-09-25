<style>
<!--
.bar {
    height: 18px;
    background: green;
}
-->
</style>
<div id="g_content">
	<div id="g_tools"> 
	
		<a href="<?php echo base_url(); ?>admin/gadgets"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/list.png" />Gadgets List</a>	
		<a href="javascript: void(0);" id="btn_add_gadgets"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/save.png" />Save Changes</a>	
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>
	<div class="g_spacer"></div>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/add.png" /></div>
		<div class="g_pagelabel_text">Add gadget</div>
	</div>
	
	<form id="form_add_gadgets" class="g_form">
	<table class="g_table zebra">
		<tr><td class="g_widget">
		
				<!-- gadgets title -->
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
								data-table="estate_plan_bundle"
								data-required="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				<div class="item">
					<div class="label">Images *</div>
					<div class="input">
						<span class="btn btn-success fileinput-button">
					        <i class="glyphicon glyphicon-plus"></i>
					        <span>Select files...</span>
					        <input id="fileupload" type="file" name="files[]" multiple>
					    </span>
					</div>
					<div class="h_clearboth"></div>
					<div id="progress">
					    <div class="bar" style="width: 0%;"></div>
					</div>
					<div class="h_clearboth"></div>
				    <!-- The container for the uploaded files -->
				    <div id="files" class="files" style="float:left;"></div>
					<div class="h_clearboth"></div>
				</div>
				<!-- status -->
				<div class="item">
					<div class="label">Status *</div>
					<div class="input">
						<select class="g_select" name="is_active" data-required="1">
							<option value="" selected="selected">Select status</option>
							<option value="0">Disabled</option>
							<option value="1">Enabled</option>
						</select>
					</div>
					<div class="h_clearboth"></div>
				</div>
				<!-- status -->
				<div class="item">
					<div class="input">
						<input type="button" name="addAttr" id="addAttr" value="Add Attribute" data-img-cnt="0">
					</div>
					<div class="h_clearboth"></div>
				</div>
		</td></tr>
	</table>
	<table class="g_table zebra" id="attrDetails">
		<tr>
			<th>Image</th>
			<th>CID</th>
			<th>Color</th>
			<th>Network Connectivity</th>
			<th>Capacity</th>
			<th>Amount</th>
			<th>Discount</th>
			<th>Peso Value</th>
			<th>Quantity</th>
			<th>Status</th>
			<th>Actions</th>
		</tr>
		<tr id="0">
			<td class="h_padding20" colspan="11"><div class="g_nodata"><div class="icon"></div>No attribute(s) to display</div></td>
		</tr>
		
		</table>
		
	</form>
	
</div>

<script src="<?php echo base_url() . '_assets/js/jquery.min.js'; ?>"></script>
<script src="<?php echo base_url() . '_assets/jquery-file-upload/js/vendor/jquery.ui.widget.js'; ?>"></script>
<script src="<?php echo base_url() . '_assets/jquery-file-upload/js/jquery.iframe-transport.js'; ?>"></script>
<script src="<?php echo base_url() . '_assets/jquery-file-upload/js/jquery.fileupload.js'; ?>"></script>

<script type="text/javascript" language="javascript">
$(function() {
	placeHolder();
	checkSidebarStatus();
	hideSidebar(1);
	
	jQuery.extend({
	    handleError: function( s, xhr, status, e ) {
	        // If a local callback was specified, fire it
	        if ( s.error )
	            s.error( xhr, status, e );
	        // If we have some XML response text (e.g. from an AJAX call) then log it in the console
	        else if(xhr.responseText)
	            console.log(xhr.responseText);
	    }
	});
	
    'use strict';
    // Change this to the location of your server-side upload handler:
    var url = window.location.hostname === 'blueimp.github.io' ?
                '//jquery-file-upload.appspot.com/' : 'server/php/';
    $('#fileupload').fileupload({
    	url: "<?php echo base_url(); ?>admin/gadgets/upload_gadget_image",
        dataType: 'json',
        done: function (e, data) {
        	var img = $('<img class="uploadedimg" style="float:left;">'); //Equivalent: $(document.createElement('img'))
        	$('#progress .bar').hide();
        	
            $.each(data.result.files, function (index, file) {
                img.attr('src', file.thumbnailUrl);
                img.attr('data-full-path', file.url);
                img.attr('data-name', file.name);
            	img.appendTo('#files');
                $("#addAttr").attr('data-img-cnt','1');
            });
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .bar').css(
                'width',
                progress + '%'
            );
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');



    
    
	$("#addAttr").click(function(e) {
		e.preventDefault();
		$("#0").hide();
		var arrPaths = [];
		
		arrPaths.push($( "#attrDetails tr:last" ).attr('id'));
		 
		if($(this).attr("data-img-cnt") == 1) {
			$(".uploadedimg").each(function() {
				var obj = {};
				obj['src'] = $(this).attr('src');
				obj['name'] = $(this).attr('data-name');
				
				arrPaths.push(obj);
			})
			
			$.ajax({
				type: "post",
				url: "<?php echo base_url(); ?>admin/gadgets/addAttr",
				data: {datas : arrPaths},
				success: function(response, textStatus, jqXHR){
					$("#attrDetails").append(response);
					$(".btn_deleteAttr").click(function(e) {
						e.preventDefault();
						$(this).parent().parent().remove();
					});
				},
				error: function(jqXHR, textStatus, errorThrown){
						$("#middle_wrapper").html(jqXHR.responseText);
					displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
				}
			});
		} else {
			alert("Please upload Image");
		}
		
	})
	
	$(window).bind('beforeunload', function(){
	  return 'Are you sure you want to leave?';
	});
	
	$("#btn_add_gadgets").click(function(e){
//		displayNotification("message", "Working...");
		if (validate_form("form_add_gadgets")) {
			$.ajax({
				url: "<?php echo base_url(); ?>admin/gadgets/process_add",
				type: "POST",
				data: $("#form_add_gadgets").serialize(),
				success: function(response, textStatus, jqXHR){
//					alert(response);
// 					setTimeout(function () {
// 						$("#middle_wrapper").html(response);
//						if (typeof history.pushState != 'undefined') { window.history.pushState("object or string", "Title", "<?php echo base_url(); ?>admin/gadgets"); }
// 						displayNotification("success", "New gadgets successfully added.");
// 					}, 500);
				},
				error: function(jqXHR, textStatus, errorThrown){
						$("#middle_wrapper").html(jqXHR.responseText);
					displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
				}
			});
		}
	});
});



</script>