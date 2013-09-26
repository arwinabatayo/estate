<div id="g_content">
	<div id="g_tools">
                <a href="<?php echo base_url(); ?>admin/store"><img src="http://localhost/estate/_assets/images/tools/list.png" class="g_icon">Store List</a>
		<a href="<?php echo base_url(); ?>admin/store/properties_add/<?php echo $store[0]['id']; ?>"><img src="<?php echo base_url(); ?>_assets/images/tools/add.png" />Add Property</a>
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>
	<div class="g_spacer"></div>
	
        <div class="g_pagelabel h_width80px h_floatleft">
	<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/generic.png" /></div>
	<div class="g_pagelabel_text">Legend</div>
        </div>

        <div id="g_legend">
                <div class="item"><img src="<?php echo base_url();  ?>_assets/images/global_icon_edit.png" /> Edit property details</div>
                <div class="item"><img src="<?php echo base_url();  ?>_assets/images/global_icon_deactivate.png" /> Delete property</div>
        </div>

        <div class="h_clearboth"></div>
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/properties.png" /></div>
		<div class="g_pagelabel_text">Store Properties - <?php echo $store[0]['name']; ?></div>
		<?php echo $pagination; ?>
	</div>
	<?php if ($store_properties) { ?>
	
		<table class="g_table zebra">
		
			<tr>
				<th>Slots Available</th>
                                <th>Date of Operation From</th>
                                <th>Time of Operation From</th>
                                <th>Time of Operation To</th>
                                <th>Status</th>
				<th>Actions</th>
			</tr>
			<?php foreach ($store_properties as $properties => $a) { ?>
			<tr>
				<td><?php echo $a['slots_available']; ?></td>
                                <td><?php echo $a['date_of_operation']; ?></td>
                                <td><?php echo $a['time_of_operation_from']; ?></td>
                                <td><?php echo $a['time_of_operation_to']; ?></td>
                                <td><?php if($a['status'] == 1) { echo "Active"; } else { echo "inactive";} ; ?></td>
				
				<!-- actions -->
				<td width="80" align="center">
					<a 	href="<?php echo base_url(); ?>admin/store/edit_properties/<?php echo $a['store_id']; ?>/<?php echo $a['id']; ?>"
						class="g_tableicon"
						title="Edit store details">
						<img src="<?php echo base_url(); ?>_assets/images/global_icon_edit.png"/>
					</a>
                                        <a 	href="javascript:void(0);" 
                                                class="btn_delete_store_property g_tableicon" 
                                                title="Delete store property"
                                                data-property-id="<?php echo $a['id']; ?>" 
                                                data-store-id="<?php echo $a['store_id']; ?>" 
                                                data-current-page="<?php echo $current_page; ?>" >
                                                <img src="<?php echo base_url(); ?>_assets/images/global_icon_deactivate.png" />
                                        </a>
					<div class="h_clearboth"></div>
				</td>
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
});

$(".btn_delete_store_property").click(function(){
	var property_id = $(this).attr('data-property-id');
        var store_id = $(this).attr('data-store-id');
	var current_page = $(this).attr('data-current-page');
	
	if (confirm("Are you sure you want to delete this store?")) {
		displayNotification("message", "Working...")
		$.ajax({
			url: "<?php echo base_url(); ?>admin/store/process_delete_properties",
			type: "POST",
			data: "store_id="+store_id+"&property_id="+property_id+"&current_page="+current_page+"&"+$("#form_pagination").serialize(),
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#middle_wrapper").html(response);
					displayNotification("success", "Property successfully deleted.");
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	}
});
</script>