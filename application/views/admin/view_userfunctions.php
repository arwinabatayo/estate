<div id="g_content">
	
	<div class="h_clearboth"></div>
	<div class="g_spacer"></div>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/properties.png" /></div>
		<div class="g_pagelabel_text">User Functions</div>
	</div>
	
	<?php if ($user_functions && $ecommerce_user_roles) { ?>
	
		<table class="g_table zebra">
		
			<tr>
				<th class="no-bg">Function Codes</th>
				<th class="no-bg">User Functions</th>
				<?php foreach( $ecommerce_user_roles as $eur ){ ?>
					<th class="no-bg uf_eur_header"><?php echo $eur['title']; ?></th>
				<?php } ?>
			</tr>
			
			<?php foreach ($user_functions as $uf) { ?>
				<tr>
					<td>
						<?php echo $uf['function_code']; ?>
					</td>
					<td>
						<?php echo $uf['function_description']; ?>
					</td>
					<?php foreach( $ecommerce_user_roles as $eur ){ ?>
						<td class="uf_eur" align="center" valign="middle">
							<?php
								$arr_user_functions = explode(',',  $eur['allowed_functions']);
							?>
							<input <?php if( in_array($uf['function_id'], $arr_user_functions) ){ echo 'checked="checked"'; } ?> type="checkbox" class="input_uf_eur" data-uf="<?php echo $uf['function_id']; ?>"  data-eur="<?php echo $eur['user_type_id']; ?>" />
						</td>
					<?php } ?>
				</tr>
			<?php } ?> 
			
		</table>
			
	<?php } else { ?> 
		
		<table class="g_table">
			<tr><td class="h_padding20"><div class="g_nodata"><div class="icon"></div>No data to display</div></td></tr>
		</table>
			
	<?php } ?>
	
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