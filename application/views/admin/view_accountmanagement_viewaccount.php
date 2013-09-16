<div id="g_content">

	<div id="g_tools"> 
		<a href="javascript: void(0);" id="btn_edit_account"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/save.png" />Save Changes</a>	
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>
	<div class="g_spacer"></div>

	<form id="form_edit_account" class="g_form">
	
		<div class="g_pagelabel">
			<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/edit.png" /></div>
			<div class="g_pagelabel_text">My Account Details</div>
		</div>
		
		<table class="g_table zebra">
			<tr><td class="g_widget">
					
				<!-- order number -->
				<div class="item">
					<div class="label">Order Number *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="name" 
								maxlength="200"
								value="<?php echo $account_details['order_number']; ?>"		
								data-unique="1"
								data-field="name"
								data-table="estate_accounts"
								data-required="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- account number -->
				<div class="item">
					<div class="label">Order Number *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="account_id" 
								maxlength="200"
								value="<?php echo $account_details['account_id']; ?>"		
								data-unique="1"
								data-field="name"
								data-table="estate_accounts"
								data-required="1" />
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
								maxlength="200"
								value="<?php echo $account_details['name']; ?>"
								data-required="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- middle -->
				<div class="item">
					<div class="label">Middle *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="middle" 
								maxlength="200"
								value="<?php echo $account_details['middle']; ?>"
								data-required="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- surname -->
				<div class="item">
					<div class="label">Surname *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="surname" 
								maxlength="200"
								value="<?php echo $account_details['surname']; ?>"
								data-required="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- lock-in period -->
				<div class="item">
					<div class="label">Lock-in period *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="lockin_period" 
								maxlength="200"
								value="<?php echo $account_details['lockin_duration']; ?>"
								data-required="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- outstanding balance -->
				<div class="item">
					<div class="label">Outstanding balance *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="outstading_balance" 
								maxlength="200"
								value="<?php echo $account_details['outstanding_balance']; ?>" 
								data-required="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- due date -->
				<div class="item">
					<div class="label">Due date *</div>
					<div class="input">
						<input 	class="g_inputtext dpicker h_backgroundlight" 
								type="text" 
								name="due_date" 
								data-datepicker="1"
								data-format="yy-mm-dd"
								maxlength="255" 
								value="<?php echo date('Y-m-d' , strtotime($account_details['due_date'])); ?>"
								data-required="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- credit limit -->
				<div class="item">
					<div class="label">Credit limit *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="credit_limit" 
								maxlength="200"
								value="<?php echo $account_details['credit_limit']; ?>" 
								data-required="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- status -->
				<div class="item">
					<div class="label">Status *</div>
					<div class="input">
						<select class="g_select" name="status" data-required="1">
							<option value="0">Select status</option>
							<option value="inactive" <?php if( isset($account_details['status']) && $account_details['status'] == 0 ){ echo 'selected="selected"'; } ?>>Inactive</option>
							<option value="active" <?php if( isset($account_details['status']) && $account_details['status'] == 1 ){ echo 'selected="selected"'; } ?>>Active</option>
						</select>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
			</td></tr>
		</table>
		
		<div class="g_pagelabel">
			<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/edit.png" /></div>
			<div class="g_pagelabel_text">My Contact Details</div>
		</div>
		
		<table class="g_table zebra">
			<tr><td class="g_widget">
				
				<!-- mobile number -->
				<div class="item">
					<div class="label">Mobile Number *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="mobile_number" 
								maxlength="200"
								value="<?php echo $account_details['mobile_number']; ?>"
								data-required="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- email -->
				<div class="item">
					<div class="label">Email *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="email" 
								maxlength="200"
								value="<?php echo $account_details['email']; ?>"
								data-required="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
			</td></tr>
		</table>
		
		
		<div class="g_pagelabel">
			<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/edit.png" /></div>
			<div class="g_pagelabel_text">My Documents</div>
		</div>
		
		<table class="g_table zebra">
			<tr><td class="g_widget">
				
				<!-- credit limit -->
				<div class="item">
					<div class="label">Credit limit Increase?</div>
					<div class="input">
						<input 	class="" 
								type="radio" 
								checked="checked"
								name="credit_limit_increase" 
								maxlength="200"
								value="yes" /> Yes
						<input 	class="" 
								type="radio" 
								name="credit_limit_increase" 
								maxlength="200"
								value="no" /> No
					</div>
					<div class="h_clearboth"></div>
				</div>
				<div class="item">
					<div class="label">Credit limit</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="credit_limit" 
								maxlength="200"
								value="<?php echo $account_details['credit_limit']; ?>" />
					</div>
					
					<!-- view financial documents button -->
					<div class="item h_floatright h_margin0 h_marginright8">
						<div class="input">
							<a href="<?php echo base_url() . 'admin/accountmanagement/viewdocuments/' . $account_details['account_id'] . '/' . $account_details['order_number']; ?>"><input type="button" class="g_inputbutton h_margin0" value="View Financial Documents" /></a>
						</div>
						<div class="h_clearboth"></div>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
			</td></tr>
		</table>
		
		<input type="hidden" value="<?php echo $account_id; ?>" name="account_id" />
		<input type="hidden" value="<?php echo $order_number; ?>" name="order_number" />
	</form>
</div>

<script type="text/javascript" language="javascript" src="<?php echo base_url() . '_assets/js/ajaxupload.3.5.js'; ?>"></script>
<script type="text/javascript" language="javascript">
$(function(){
	placeHolder();
	checkSidebarStatus();
	implementDatePicker();
});

$("#btn_edit_account").click(function(e){
	displayNotification("message", "Working...");
	if (validate_form("form_edit_account")) {
		var addons_category_id = $('#addon_category_id').val();
		$.ajax({
			url: "<?php echo base_url(); ?>admin/addons/process_edit",
			type: "POST",
			data: $("#form_edit_account").serialize(),
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#middle_wrapper").html(response);
					if (typeof history.pushState != 'undefined') { window.history.pushState("object or string", "Title", "<?php echo base_url(); ?>admin/addons/index/" + addons_category_id); }
					displayNotification("success", "Addon successfully updated.");
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	}
});

</script>