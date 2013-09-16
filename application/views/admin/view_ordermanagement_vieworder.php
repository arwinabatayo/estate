<div id="g_content">

	<div id="g_tools">
		<?php if( 	$this->session->userdata('user_type') == ROLE_ONLINE_SALES 
					|| $this->session->userdata('user_type') == ROLE_GLOBE_BUSINESS_SALES_SUPPORT_TEAM ){ ?>
			<a href="javascript: void(0);" id="btn_order_done"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/save.png" />Order Done</a>	
		<?php } ?>
		<?php if( $this->session->userdata('user_type') != ROLE_AGENT_ACCESS ){ ?>
			<a href="javascript: void(0);" id="btn_update_order"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/save.png" />Save Changes</a>	
		<?php } ?>
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>
	<div class="g_spacer"></div>

	<form id="form_edit_order" class="g_form">
		
		
		<div class="g_pagelabel">
			<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/edit.png" /></div>
			<div class="g_pagelabel_text">My Order Details</div>
		</div>
		
		<table class="g_table zebra">
			<tr><td class="g_widget">
				
				My Order Details
				
			</td></tr>
		</table>
		
		<div class="g_pagelabel">
			<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/edit.png" /></div>
			<div class="g_pagelabel_text">My Gadget</div>
		</div>
		
		<table class="g_table zebra">
			<tr><td class="g_widget">
					
				My Gadget
				
			</td></tr>
		</table>
		
		<div class="g_pagelabel">
			<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/edit.png" /></div>
			<div class="g_pagelabel_text">My Delivery</div>
		</div>
		
		<table class="g_table zebra">
			<tr><td class="g_widget">
				
				My Delivery
				
			</td></tr>
		</table>
		
		<div class="g_pagelabel">
			<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/edit.png" /></div>
			<div class="g_pagelabel_text">My Payment</div>
		</div>
		
		<table class="g_table zebra">
			<tr><td class="g_widget">
				
				My Payment
				
			</td></tr>
		</table>
		
		<div class="g_pagelabel">
			<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/edit.png" /></div>
			<div class="g_pagelabel_text">My Others</div>
		</div>
		
		<table class="g_table zebra">
			<tr><td class="g_widget">
				
				My Others
				
			</td></tr>
		</table>
		
		<input type="hidden" value="<?php echo $account_id; ?>" name="account_id" />
		<input type="hidden" value="<?php echo $order_number; ?>" name="order_number" />
	</form>
	<form id="form_order_done">
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

$("#btn_order_done").click(function(e){
	displayNotification("message", "Working...");
	$.ajax({
		url: "<?php echo base_url(); ?>admin/ordermanagement/mark_order_as_done",
		type: "POST",
		data: $("#form_order_done").serialize(),
		success: function(response, textStatus, jqXHR){
			setTimeout(function () {
				$("#middle_wrapper").html(response);
				if (typeof history.pushState != 'undefined') { window.history.pushState("object or string", "Title", "<?php echo base_url(); ?>admin/ordermanagement"); }
				displayNotification("success", "Order succesfully marked as done.");
			}, 500);
		},
		error: function(jqXHR, textStatus, errorThrown){
			displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
		}
	});
});

</script>