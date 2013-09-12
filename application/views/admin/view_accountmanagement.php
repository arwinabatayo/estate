<div id="g_content">

	<div id="g_tools"> 
		<a href="javascript: void(0);" id="btn_filter"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/search.png" />Filter</a>	
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>
	<div class="g_spacer"></div>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/generic.png" /></div>
		<div class="g_pagelabel_text">Account Management</div>
	</div>
	
	<table class="g_table">
		<tr><td class="g_widget">
		
			<form id="form_add_accessory" class="g_form">
				
				<!-- mobile number -->
				<div class="item">
					<div class="label">Mobile number</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="mobile_number" 
								maxlength="255" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- plan -->
				<div class="item">
					<div class="label">Plan</div>
					<div class="input">
						<select class="g_select" name="plan">
							<option value="0" selected="selected">Select plan</option>
							<?php if( $plan_bundles && count($plan_bundles) > 0 ){ ?>
								<?php foreach( $plan_bundles as $plan_bundle ){ ?>
									<option value="<?php echo $plan_bundle['f_plan_bundle_id']; ?>"><?php echo $plan_bundle['f_plan_bundle_title']; ?></option>
								<?php } ?>
							<?php } ?>
						</select>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- lastname -->
				<div class="item">
					<div class="label">Last name</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="lastname" 
								maxlength="255" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- firstname -->
				<div class="item">
					<div class="label">First name</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="firstname" 
								maxlength="255" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- account type -->
				<div class="item">
					<div class="label">Account type</div>
					<div class="input">
						<select class="g_select" name="account_type">
							<option value="0" selected="selected">Select account type</option>
							<?php if( $account_types && count($account_types) > 0 ){ ?>
								<?php foreach( $account_types as $account_type ){ ?>
									<option value="<?php echo $account_type['f_account_type_id']; ?>"><?php echo $account_type['f_account_type_title']; ?></option>
								<?php } ?>
							<?php } ?>
						</select>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- account number -->
				<div class="item">
					<div class="label">Account number</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="account_number" 
								maxlength="255" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- lock in duration -->
				<div class="item">
					<div class="label">Lock-in duration</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="lock_in_duration" 
								maxlength="255" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- due date -->
				<div class="item">
					<div class="label">Due date</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="due_date" 
								maxlength="255" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- account status -->
				<div class="item">
					<div class="label">Status</div>
					<div class="input">
						<select class="g_select" name="acccount_status">
							<option value="0" selected="selected">Select account status</option>
							<option value="active">Active</option>
							<option value="inactive">Inactive</option>
						</select>
					</div>
					<div class="h_clearboth"></div>
				</div>
			</form>
			
		</td></tr>
	</table>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/generic.png" /></div>
		<div class="g_pagelabel_text">Result</div>
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