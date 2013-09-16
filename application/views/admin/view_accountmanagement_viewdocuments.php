<div id="g_content">

	<div id="g_tools"> 
		<a href="javascript: void(0);" id="btn_submit"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/save.png" />Submit</a>	
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>
	<div class="g_spacer"></div>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/generic.png" /></div>
		<div class="g_pagelabel_text">View Documents</div>
	</div>
	
	<table class="g_table zebra">
		<tr>
			<td width="53" align="right">
				<a target="_blank" href="<?php echo base_url(); ?>admin/accountmamanagement/showdocument/1" class="g_tableicon">Document 1</a>
				<div class="h_clearboth"></div>
			</td>
		</tr>
		<tr>
			<td width="53" align="right">
				<av	href="<?php echo base_url(); ?>admin/accountmamanagement/showdocument/2" class="g_tableicon">Document 2</a>
				<div class="h_clearboth"></div>
			</td>
		</tr>
		<tr>
			<td width="53" align="right">
				<a 	href="<?php echo base_url(); ?>admin/accountmamanagement/showdocument/3" class="g_tableicon">Document 3</a>
				<div class="h_clearboth"></div>
			</td>
		</tr>
	</table>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/generic.png" /></div>
		<div class="g_pagelabel_text">Order Status</div>
	</div>
	
	<table class="g_table">
		<tr><td class="g_widget">
			
			<form id="form_approval" class="g_form">
				<!-- status -->
				<div class="item">
					<div class="label">Status *</div>
					<div class="input">
						<select class="g_select" name="status" data-required="1">
							<option value="0" selected="selected">Select status</option>
							<?php foreach( $order_statuses as $status ){ ?>
								<?php if( $this->session->userdata('user_type') == ROLE_RELATIONSHIP_MANAGER ){ ?>
									<?php if( $status['order_status_id'] >= ORDERSTATUS_DONE ){ ?>
										<option value="<?php echo $status['order_status_id']; ?>"><?php echo $status['status_name'] . ' (' . $status['status_code'] . ')'; ?></option>
									<?php } ?>
								<?php }else{ ?>
									<?php if( $status['order_status_id'] >= ORDERSTATUS_APPROVED ){ ?>
										<option value="<?php echo $status['order_status_id']; ?>"><?php echo $status['status_name'] . ' (' . $status['status_code'] . ')'; ?></option>
									<?php } ?>
								<?php } ?>
							<?php } ?>
						</select>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- comments -->
				<div class="item">
					<div class="label">Enter comments here *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="comments" 
								maxlength="200" 
								data-required="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<input type="hidden" value="<?php echo $account_id; ?>" id="account_id" name="account_id" />
				<input type="hidden" value="<?php echo $order_number; ?>" id="order_number" name="order_number" />
			</form>
		</td></tr>
	</table>
</div>

<script type="text/javascript" language="javascript">
$(function(){
	zebraTable();
});

$("#btn_submit").click(function(e){
	displayNotification("message", "Working...");
	if (validate_form("form_approval")) {
		$.ajax({
			url: "<?php echo base_url(); ?>admin/accountmanagement/updateOrderStatus",
			type: "POST",
			data: $("#form_approval").serialize(),
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#middle_wrapper").html(response);
					if (typeof history.pushState != 'undefined') { window.history.pushState("object or string", "Title", "<?php echo base_url(); ?>admin/accountmanagement"); }
					displayNotification("success", "Order status successfully updated.");
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	}
});

</script>