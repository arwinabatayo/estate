<div id="g_content">
	
	<div class="h_clearboth"></div>
	<div class="g_spacer"></div>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/properties.png" /></div>
		<div class="g_pagelabel_text">Order Management</div>
	</div>
	
	<table class="g_table">
		<tr>
			<td>
				asdf
			</td>
		</tr>
	</table>
	
</div>

<script type="text/javascript" language="javascript">
$(function(){
	zebraTable();
});

$(".input_uf_eur").change(function(){
	var function_id = $(this).attr('data-uf');
	var user_type_id = $(this).attr('data-eur');
	var is_checked = 0;
	
	if(	$(this).is(":checked")	){
		is_checked = 1;
	}else{
		is_checked = 0;
	}
	
	displayNotification("message", "Working...")
	$.ajax({
		url: "<?php echo base_url(); ?>admin/userfunctions/update_userfunction_vs_ecommerceuserrole",
		type: "POST",
		data: "function_id="+function_id+"&user_type_id="+user_type_id+"&is_checked="+is_checked,
		success: function(response, textStatus, jqXHR){
			setTimeout(function () {
				displayNotification("success", "User functions successfully updated.");
			}, 500);
		},
		error: function(jqXHR, textStatus, errorThrown){
			$('#middle_wrapper').html(jqXHR.responseText);
			displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
		}
	});
});
</script>