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
		
			<form id="form_filter" class="g_form">
				
				<!-- account number -->
				<div class="item">
					<div class="label">Account number</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="account_number" 
								value="<?php echo $this->input->post('account_number'); ?>" 
								data-is-whole-number="1" 
								maxlength="20" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- mobile number -->
				<div class="item">
					<div class="label">Mobile number</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="mobile_number" 
								value="<?php echo $this->input->post('mobile_number'); ?>" 
								maxlength="200" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- application type -->
				<div class="item">
					<div class="label">Application type</div>
					<div class="input">
						<select class="g_select" name="order_type" data-required="1">
							<option value="0">Select application type</option>
							<?php foreach( $order_types as $order_type ){ ?>
								<?php if( $order_type['id'] == $this->input->post('order_type') ){ ?>
									<option value="<?php echo $order_type['id']; ?>" selected="selected"><?php echo $order_type['title']; ?></option>
								<?php }else{ ?>
									<option value="<?php echo $order_type['id']; ?>"><?php echo $order_type['title']; ?></option>
								<?php } ?>
							<?php } ?>
						</select>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- plan -->
				<!--
				<div class="item">
					<div class="label">Current plan</div>
					<div class="input">
						<select class="g_select" name="current_plan">
							<option value="0" selected="selected">Select plan</option>
							<?php if( $plans && count($plans) > 0 ){ ?>
								<?php foreach( $plans as $plan ){ ?>
									<option value="<?php echo $plan['id']; ?>"><?php echo $plan['title']; ?></option>
								<?php } ?>
							<?php } ?>
						</select>
					</div>
					<div class="h_clearboth"></div>
				</div>
				-->
				
				<!-- lastname -->
				<div class="item">
					<div class="label">Last name</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="lastname" 
								value="<?php echo $this->input->post('lastname'); ?>" 
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
								value="<?php echo $this->input->post('firstname'); ?>" 
								maxlength="200" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- account category -->
				<div class="item">
					<div class="label">Account category</div>
					<div class="input">
						<select class="g_select" name="account_category">
							<option value="0">Select account category</option>
							<?php if( $account_categories && count($account_categories) > 0 ){ ?>
								<?php foreach( $account_categories as $account_category ){ ?>
									<?php if( $account_category['type'] == 'main' ){ ?>
										<?php if( $account_category['id'] == $this->input->post('account_category') ){ ?>
											<option value="<?php echo $account_category['id']; ?>" selected="selected"><?php echo $account_category['name']; ?></option>
										<?php }else{ ?>
											<option value="<?php echo $account_category['id']; ?>"><?php echo $account_category['name']; ?></option>
										<?php } ?>
									<?php }else{ ?>
										<?php if( $account_category['id'] . '_' . $account_category['subid'] == $this->input->post('account_category') ){ ?>
											<option value="<?php echo $account_category['id'] . '_' . $account_category['subid']; ?>"><?php echo $account_category['name']; ?></option>
										<?php }else{ ?>
											<option value="<?php echo $account_category['id'] . '_' . $account_category['subid']; ?>"><?php echo $account_category['name']; ?></option>
										<?php } ?>
									<?php } ?>
								<?php } ?>
							<?php } ?>
						</select>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- lock-in period -->
				<!--
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
				-->
				
				<!-- due date -->
				<div class="item">
					<div class="label">Due date</div>
					<div class="input">
						<input 	class="g_inputtext dpicker h_backgroundlight" 
								type="text" 
								name="due_date" 
								data-datepicker="1"
								data-format="yy-mm-dd"
								value="<?php echo $this->input->post('due_date'); ?>" 
								maxlength="255" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- account status -->
				<div class="item">
					<div class="label">Status</div>
					<div class="input">
						<select class="g_select" name="account_status">
							<option value="0">Select account status</option>
							<option value="active" <?php if( $this->input->post('account_status') == 'active' ){ echo 'selected="selected"'; } ?>>Active</option>
							<option value="inactive" <?php if( $this->input->post('account_status') == 'inactive' ){ echo 'selected="selected"'; } ?>>Inactive</option>
						</select>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<input type="hidden" name="filter" value="1" />
				<input type="hidden" name="current_page" value="1" />
			</form>
			
		</td></tr>
	</table>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/generic.png" /></div>
		<div class="g_pagelabel_text">Result</div>
		<?php echo $pagination; ?>
	</div>
	
	<?php if ($accounts) { ?>
	
		<table class="g_table zebra">
		
			<tr>
				<th>Order Ref #</th>
				<th>Fullname</th>
				<th>Mobile #</th>
				<th>Current Plan</th>
				<th>Account Category</th>
				<th>Lockin Duration</th>
				<th>Overdue Balance</th>
				<th>Due Date</th>
				<th>Credit Limit</th>
			</tr>
			
			<?php foreach ($accounts as $accounts => $a) { ?>
				<tr>
					<td width="80"><a href="<?php echo base_url() . 'admin/accountmanagement/viewaccount/' . $a['account_id'] . '/' . $a['order_number']; ?>"><?php echo $a['order_number']; ?></a></td>
					<td><?php echo $a['fullname']; ?></td>
					<td><?php echo $a['mobile_number']; ?></td>
					<td><?php echo $a['main_plan_description']; ?></td>
					<td><?php echo $a['category_name']; ?></td>
					<td><?php echo $a['lockin_duration']; ?></td>
					<td><?php echo $a['outstanding_balance']; ?></td>
					<td><?php echo date('M-d-Y', strtotime($a['due_date'])); ?></td>
					<td><?php echo $a['credit_limit']; ?></td>
				</tr>
			<?php } ?> 
			
		</table>
			
	<?php } else { ?> 
		
		<table class="g_table">
			<tr><td class="h_padding20"><div class="g_nodata"><div class="icon"></div>No data to display</div></td></tr>
		</table>
			
	<?php } ?>
	
	<div class="g_pagination_wrapper"><?php echo $pagination; ?></div>
	
</div>

<script type="text/javascript" language="javascript">
$(function(){
	zebraTable();
	implementDatePicker();
});

$("#btn_filter").click(function(){
	displayNotification("message", "Working...");
	$.ajax({
		url: "<?php echo base_url(); ?>admin/accountmanagement/process_filter",
		type: "POST",
		data: $("#form_filter").serialize(),
		success: function(response, textStatus, jqXHR){
			setTimeout(function () {
				$("#middle_wrapper").html(response);
				displayNotification('success', 'Displaying filtered results');
			}, 500);
		},
		error: function(jqXHR, textStatus, errorThrown){
			$("#middle_wrapper").html(jqXHR.responseText);
			displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
		}
	});
});
</script>