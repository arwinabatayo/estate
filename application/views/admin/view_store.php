<div id="g_content">
	<div id="g_tools">
		<a href="<?php echo base_url(); ?>admin/store/add"><img src="<?php echo base_url(); ?>_assets/images/tools/add.png" />Add Store</a>
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>
	<div class="g_spacer"></div>
	
	<?php echo $filter; ?>

        <div class="g_pagelabel h_width80px h_floatleft">
	<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/generic.png" /></div>
	<div class="g_pagelabel_text">Legend</div>
        </div>

        <div id="g_legend">
                <div class="item"><img src="<?php echo base_url();  ?>_assets/images/global_icon_settings.png" /> Add store properties</div>
                <div class="item"><img src="<?php echo base_url();  ?>_assets/images/global_icon_view.png" /> View store details</div>
                <div class="item"><img src="<?php echo base_url();  ?>_assets/images/global_icon_edit.png" /> Edit store details</div>
                <div class="item"><img src="<?php echo base_url();  ?>_assets/images/global_icon_deactivate.png" /> Delete store</div>
        </div>

        <div class="h_clearboth"></div>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/properties.png" /></div>
		<div class="g_pagelabel_text">Stores</div>
		<?php echo $pagination; ?>
	</div>
	
	<?php if ($pickup) { ?>
	
		<table class="g_table zebra">
		
			<tr>
				<th>Store Name</th>
                                <th>Postal Code</th>
                                <th>Province</th>
                                <th>City</th>
                                <th>Municipality</th>
                                <th>Barangay</th>
                                <th>Street</th>
                                <th>Subdivision</th>
                                <th>Status</th>
				<th>Actions</th>
			</tr>
			<?php foreach ($pickup as $pickup => $a) { ?>
			<tr>
				<td><?php echo $a['name']; ?></td>
                                <td><?php echo $a['postal_code']; ?></td>
                                <td><?php echo $a['province']; ?></td>
                                <td><?php echo $a['city']; ?></td>
                                <td><?php echo $a['municipality']; ?></td>
                                <td><?php echo $a['barangay']; ?></td>
                                <td><?php echo $a['street']; ?></td>
                                <td><?php echo $a['subdivision']; ?></td>
                                <td><?php if($a['status'] == 1) { echo "Active"; } else { echo "Inactive"; }; ?></td>
				
				<!-- actions -->
				<td width="80" align="center">
                                    
                                        <a class="g_tableicon" 
						title="Add store properties"
						href="<?php echo base_url(); ?>admin/store/properties_add/<?php echo $a['id']; ?>">
						<img src="<?php echo base_url(); ?>_assets/images/global_icon_settings.png" />	
					</a>
                                        <a 	class="g_tableicon" 
						title="View store details"
						href="<?php echo base_url(); ?>admin/store/preview/<?php echo $a['id']; ?>">
						<img src="<?php echo base_url(); ?>_assets/images/global_icon_view.png" />	
					</a>
					<a 	href="<?php echo base_url(); ?>admin/store/edit/<?php echo $a['id']; ?>"
						class="g_tableicon"
						title="Edit store details">
						<img src="<?php echo base_url(); ?>_assets/images/global_icon_edit.png"/>
					</a>
                                        <a 	href="javascript:void(0);" 
                                                class="btn_delete_store g_tableicon" 
                                                title="Delete store"
                                                data-store-id="<?php echo $a['id']; ?>" 
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

$(".btn_delete_store").click(function(){
	var store_id = $(this).attr('data-store-id');
	var current_page = $(this).attr('data-current-page');
	
	if (confirm("Are you sure you want to delete this store?")) {
		displayNotification("message", "Working...")
		$.ajax({
			url: "<?php echo base_url(); ?>admin/store/process_delete",
			type: "POST",
			data: "store_id="+store_id+"&current_page="+current_page+"&"+$("#form_pagination").serialize(),
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#middle_wrapper").html(response);
					displayNotification("success", "Store successfully deleted.");
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	}
});
</script>