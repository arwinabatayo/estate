<div id="g_content">

	<div class="h_clearboth"></div>
	<div class="g_spacer"></div>
	
	<?php echo $filter; ?>
	
	<div class="g_pagelabel h_width80px h_floatleft">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/generic.png" /></div>
		<div class="g_pagelabel_text">Legend</div>
	</div>
	
	<div id="g_legend">
		<div class="item"><img src="<?php echo base_url();  ?>_assets/images/global_icon_edit.png" /> Edit package plan</div>
		
	</div>
	
	<div class="h_clearboth"></div>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/properties.png" /></div>
		<div class="g_pagelabel_text">Package Plans</div>
		<?php echo $pagination; ?>
	</div>
	
	<?php if ($packge_plans) { ?>
	
		<table class="g_table zebra">
		
			<tr>
				<th>Title</th>
				<th>Actions</th>
			</tr>
			
			<?php foreach ($packge_plans as $packge_plans => $a) { ?>
			<tr>
				<td><?php echo $a['title']; ?></td>
				
				<!-- actions -->
				<td width="40" align="center">
					<a 	href="<?php echo base_url(); ?>admin/packageplans/edit/<?php echo $a['id']; ?>"
						class="g_tableicon"
						title="Edit package plan">
						<img src="<?php echo base_url(); ?>_assets/images/global_icon_edit.png"/>
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

$(".btn_delete_accessory").click(function(){
	var accessory_id = $(this).attr('data-accessory-id');
	var current_page = $(this).attr('data-current-page');
	
	if (confirm("Are you sure you want to delete this accessory?")) {
		displayNotification("message", "Working...")
		$.ajax({
			url: "<?php echo base_url(); ?>admin/packageplans/process_delete",
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
</script>