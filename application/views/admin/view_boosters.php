<div id="g_content">

	<div id="g_tools">
		<a href="<?php echo base_url(); ?>admin/boosters/add"><img src="<?php echo base_url(); ?>_assets/images/tools/add.png" />Add Booster</a>
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
		<div class="item"><img src="<?php echo base_url();  ?>_assets/images/global_icon_edit.png" /> Edit booster</div>
		<div class="item"><img src="<?php echo base_url();  ?>_assets/images/global_icon_delete.png" /> Delete booster</div>
	</div>
	
	<div class="h_clearboth"></div>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/properties.png" /></div>
		<div class="g_pagelabel_text">Boosters</div>
		<?php echo $pagination; ?>
	</div>
	
	<?php if ($boosters) { ?>
	
		<table class="g_table zebra">
		
			<tr>
				<th>CID</th>
				<th>Title</th>
				<th>Description</th>
				<th>Long Description</th>
				<th>Amount</th>
				<th>Status</th>
				<th>Actions</th>
			</tr>
			
			<?php foreach ($boosters as $boosters => $a) { ?>
			<tr>
				<td><?php echo $a['cid']; ?></td>
				<td><?php echo $a['name']; ?></td>
				<td><?php echo $a['description']; ?></td>
				<td><?php echo $a['long_description']; ?></td>
				<td><?php echo $a['amount']; ?></td>
				<td width="50" align="center">
					<?php if( $a['is_active'] == 1 ){ echo 'Enabled'; }else{ echo 'Disabled'; } ?>
				</td>
				
				<!-- actions -->
				<td width="53" align="right">
					<a 	href="<?php echo base_url(); ?>admin/boosters/edit/<?php echo $a['id']; ?>"
						class="g_tableicon"
						title="Edit combo">
						<img src="<?php echo base_url(); ?>_assets/images/global_icon_edit.png" />
					</a>
					<a 	href="javascript:void(0);" 
						class="btn_delete g_tableicon" 
						title="Delete combo"
						data-value-name="<?php echo strtoupper($a['name']); ?>"
						data-id="<?php echo $a['id']; ?>" 
						data-current-page="<?php echo $current_page; ?>" >
						<img src="<?php echo base_url(); ?>_assets/images/global_icon_delete.png" />
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

$(".btn_delete").click(function(){
	var id = $(this).attr('data-id');
	var current_page = $(this).attr('data-current-page');
	var name = $(this).attr('data-value-name');	
	if (confirm("Are you sure you want to delete "+name+"?")) {
		displayNotification("message", "Working...")
		$.ajax({
			url: "<?php echo base_url(); ?>admin/boosters/process_delete",
			type: "POST",
			data: "id="+id+"&current_page="+current_page+"&"+$("#form_pagination").serialize(),
			success: function(response, textStatus, jqXHR){
				
				setTimeout(function () {
					displayNotification("success", "Booster "+name+" successfully deleted, Please wait.");
					$("#middle_wrapper").html(response);
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	}
});
</script>