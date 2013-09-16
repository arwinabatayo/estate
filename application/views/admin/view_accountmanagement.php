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
								maxlength="200" />
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
								data-is-whole-number="1" 
								maxlength="20" />
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
								maxlength="200" />
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
								maxlength="200" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- account category -->
				<div class="item">
					<div class="label">Account category</div>
					<div class="input">
						<select class="g_select" name="account_category">
							<option value="0" selected="selected">Select account category</option>
							<?php if( $account_categories && count($account_category) > 0 ){ ?>
								<?php foreach( $account_categories as $account_category ){ ?>
									<option value="<?php echo $account_category['f_account_category_id']; ?>"><?php echo $account_category['f_account_category_title']; ?></option>
								<?php } ?>
							<?php } ?>
						</select>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- lock-in period -->
				<div class="item">
					<div class="label">Lock-in period</div>
					<div class="input">
						<select class="g_select" name="lock_in_period">
							<option value="0" selected="selected">Select lock-in period</option>
							<?php if( $lock_in_periods && count($lock_in_periods) > 0 ){ ?>
								<?php foreach( $lock_in_periods as $lock_in_period ){ ?>
									<option value="<?php echo $lock_in_period['lockup_id']; ?>"><?php echo $lock_in_period['lockup_desc']; ?></option>
								<?php } ?>
							<?php } ?>
						</select>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- due date -->
				<div class="item">
					<div class="label">Due date</div>
					<div class="input">
						<input 	class="g_inputtext dpicker h_backgroundlight" 
								type="text" 
								name="due_date" 
								data-datepicker="1"
								data-format="yy-mm-dd"
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
	
	<?php if ($accounts) { ?>
	
		<table class="g_table zebra">
		
			<tr>
				<th>Account Id</th>
				<th>Order Number</th>
				<th>Name</th>
				<th>Email</th>
				<th>Mobile Number</th>
				<th>Lockin Duration</th>
				<th>Outstanding Balance</th>
				<th>Due Date</th>
				<th>Credit Limit</th>
				<th>Status</th>
			</tr>
			
			<?php foreach ($accounts as $accounts => $a) { ?>
				<tr>
					<td><a href="<?php echo base_url() . 'admin/accountmanagement/viewaccount/' . $a['account_id'] . '/' . $a['order_number']; ?>"><?php echo $a['account_id']; ?></a></td>
					<td><?php echo $a['order_number']; ?></td>
					<td><?php echo $a['name'] . ' ' . $a['surname']; ?></td>
					<td><?php echo $a['email']; ?></td>
					<td><?php echo $a['mobile_number']; ?></td>
					<td><?php echo $a['lockin_duration']; ?></td>
					<td><?php echo $a['outstanding_balance']; ?></td>
					<td><?php echo date('M-d-Y', strtotime($a['due_date'])); ?></td>
					<td><?php echo $a['credit_limit']; ?></td>
					<td><?php if( $a['status'] == 0 ){ echo 'Inactive'; }else{ echo 'Active'; } ?></td>
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
	implementDatePicker();
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