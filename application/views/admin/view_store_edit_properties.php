<div id="g_content">

	<div id="g_tools"> 
		<a href="<?php echo base_url(); ?>admin/store"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/list.png" />Store List</a>	
		<a href="javascript: void(0);" id="btn_edit_property"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/save.png" />Save Changes</a>	
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>
	<div class="g_spacer"></div>

	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/add.png" /></div>
		<div class="g_pagelabel_text">Edit store</div>
	</div>
	
	<table class="g_table zebra">
		<tr><td class="g_widget">
		
			<form id="form_edit_property" class="g_form">
				<input type="hidden" id="store_id" name="store_id" value="<?php echo $property_details['store_id']; ?>" />
				<div class="item">
					<div class="label">Slots Available *</div>
                                        <input type="hidden" name="property_id" value="<?php echo $property_details['id']; ?>"/>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								maxlength="10"
								name="slots_available"
								data-required="1" 
                                                                value="<?php echo $property_details['slots_available']; ?>"/>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
                                <!-- Date of Operation From -->
				<div class="item">
                                        <div class="label">Date of Operation</div>
                                        <div class="input">
                                                <input 	class="g_inputtext dpicker" 
                                                                type="text" 
                                                                id="date_of_operation" 
                                                                name="date_of_operation" 
                                                                data-required="1" 
                                                                value="<?php echo $property_details['date_of_operation']; ?>"/>					
                                        </div>
                                        <div class="h_clearboth"></div>
                                </div>
                                
                                                              
                                <!-- Time of Operation From -->
				<div class="item">
                                        <div class="label">Time of Operation From</div>
                                        <div class="input">
                                                <input 	class="g_inputtext dpicker" 
                                                                type="text" 
                                                                id="time_of_operation_from" 
                                                                name="time_of_operation_from" 
                                                                data-required="1" 
                                                                value="<?php echo $property_details['time_of_operation_from']; ?>"/>					
                                        </div>
                                        <div class="h_clearboth"></div>
                                </div>
                                
                                <!-- Time of Operation To -->
				<div class="item">
                                        <div class="label">Time of Operation To</div>
                                        <div class="input">
                                                <input 	class="g_inputtext dpicker" 
                                                                type="text" 
                                                                id="time_of_operation_to" 
                                                                name="time_of_operation_to" 
                                                                data-required="1" 
                                                                value="<?php echo $property_details['time_of_operation_from']; ?>"/>					
                                        </div>
                                        <div class="h_clearboth"></div>
                                </div>
                                
                                <!-- Status -->
                                <div class="item">
					<div class="label">Status</div>
                                        <div class="input">
                                                <select class="g_select h_width100px" name="property_status">
                                                    <option value="1" <?php if($property_details['status'] == 1) { ?> selected="selected" <?php } ?>>Active</option>
                                                    <option value="0" <?php if($property_details['status'] == 0) { ?> selected="selected" <?php } ?>>Inactive</option>					
                                                </select>
                                        </div>
                                </div>
			</form>
			
		</td></tr>
	</table>
</div>

<style>
 .dpicker {
    position: relative;
    z-index: 9999;
}
</style>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>_assets/js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" language="javascript">
$(function() {

	$( "#date_of_operation" ).datepicker({ dateFormat: 'yy-mm-dd' });
        $( "#time_of_operation_from" ).timepicker();
        $( "#time_of_operation_to" ).timepicker();
});
</script>
<script type="text/javascript" language="javascript">


$("#btn_edit_property").click(function(e){
	displayNotification("message", "Working...");
        var store_id = $('#store_id').val();
	if (validate_form("form_edit_property")) {
		$.ajax({
			url: "<?php echo base_url(); ?>admin/store/process_edit_property",
			type: "POST",
			data: $("#form_edit_property").serialize(),
			success: function(response, textStatus, jqXHR){
                                setTimeout(function () {
					$("#middle_wrapper").html(response);
					if (typeof history.pushState != 'undefined') { window.history.pushState("object or string", "Property", "<?php echo base_url(); ?>admin/store/preview/"+store_id); }
					displayNotification("success", "Property successfully updated.");
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				//alert('x');
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	}
});

</script>