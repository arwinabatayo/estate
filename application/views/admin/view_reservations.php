<div id="g_content">

	<?php /*
	<div id="g_tools">
		<a href="<?php echo base_url(); ?>admin/accessories/add"><img src="<?php echo base_url(); ?>_assets/images/tools/add.png" />Add Accessory</a>
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
		<div class="item"><img src="<?php echo base_url();  ?>_assets/images/global_icon_edit.png" /> Edit accessory</div>
		<div class="item"><img src="<?php echo base_url();  ?>_assets/images/global_icon_delete.png" /> Delete accessory</div>
	</div>
	*/?>

	<div class="h_clearboth"></div>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/properties.png" /></div>
		<div class="g_pagelabel_text">Reservations</div>
		<?php echo $pagination; ?>
	</div>
	
	<?php if ($reservations) { ?>
	
		<table class="g_table zebra">
		
			<tr>
				<th>ID</th>
				<th>Action</th>
				<th>Account ID</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Middle Name</th>
				<th>Email</th>
				<th>Phone</th>
				<th>Social Network Site Name</th>
				<th>Social Network User ID</th>
				<th>Item Reserved</th>
				<th>Date/Time Reserved</th>
			</tr>
			
			<?php
				foreach ($reservations as $reservation => $r) {
					$rspecs = json_decode($r['reserved_item_specs']);
					$item_specs = $rspecs->product_name . ' / ' . $rspecs->product_capacity . ' GB at P ' . $rspecs->product_price; 
			?>
			<tr>
				<td><?php echo $r['reserve_id']; ?></td>
				<td width="50" align="center">
					<a href="javascript: void(0);" id="reserve_id-<?php echo $r['reserve_id']; ?>" onclick="updateStatus('<?php echo $r['reserve_id']; ?>');"><?php if( $r['informed_flag'] == 'n' ){ echo 'Mark as informed'; } else { echo 'Mark as not informed'; } ?></a>
				</td>
				
				<!-- actions -->
				<td><?php echo $r['account_id']; ?></td>
				<td><?php echo $r['first_name']; ?></td>
				<td><?php echo $r['last_name']; ?></td>
				<td><?php echo $r['middle_name']; ?></td>
				<td><?php echo $r['email']; ?></td>
				<td><?php echo $r['msisdn']; ?></td>
				<td><?php echo $r['social_network_sitename']; ?></td>
				<td><?php echo $r['social_network_user_id']; ?></td>
				<td><?php echo $item_specs; ?></td>
				<td><?php echo $r['reserved_datetime']; ?></td>
				<?php /*
				<td width="53" align="right">
					<a 	href="<?php echo base_url(); ?>admin/accessories/edit/<?php echo $a['accessories_id']; ?>"
						class="g_tableicon"
						title="Edit accessory">
						<img src="<?php echo base_url(); ?>_assets/images/global_icon_edit.png" />
					</a>
					<a 	href="javascript:void(0);" 
						class="btn_delete_accessory g_tableicon" 
						title="Delete accessory"
						data-accessory-id="<?php echo $a['accessories_id']; ?>" 
						data-current-page="<?php echo $current_page; ?>" >
						<img src="<?php echo base_url(); ?>_assets/images/global_icon_delete.png" />
					</a>
					<div class="h_clearboth"></div>
				</td>
				*/ ?>
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

function updateStatus(reserve_id)
{
	$.ajax({
		url : "<?php echo base_url(); ?>admin/reservations/updateReserveStatus",
		type : "post", 
		data : "reserve_id="+reserve_id,
		success: function(response){
			resp = jQuery.parseJSON(response);

			if (resp.status == 'success') {
				setTimeout(function () {
					$('#reserve_id-'+reserve_id).html(resp.curr_status);
					displayNotification("success", "Reservation successfully updated.");
				}, 500);
			}
		},
		error: function(jqXHR, textStatus, errorThrown){
			displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
		}
	});
}

<?php /*
$(".btn_delete_accessory").click(function(){
	var accessory_id = $(this).attr('data-accessory-id');
	var current_page = $(this).attr('data-current-page');
	
	if (confirm("Are you sure you want to delete this accessory?")) {
		displayNotification("message", "Working...")
		$.ajax({
			url: "<?php echo base_url(); ?>admin/accessories/process_delete",
			type: "POST",
			data: "accessory_id="+accessory_id+"&current_page="+current_page+"&"+$("#form_pagination").serialize(),
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#middle_wrapper").html(response);
					displayNotification("success", "Accessory successfully deleted.");
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	}
});
*/ ?>
</script>