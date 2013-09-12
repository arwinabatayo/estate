<div id="g_content">

	<div id="g_tools">
		<a href="<?php echo base_url(); ?>admin/products/add"><img src="<?php echo base_url(); ?>_assets/images/tools/add.png" />Add Product</a>
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
		<div class="item"><img src="<?php echo base_url();  ?>_assets/images/global_icon_edit.png" /> Edit product</div>
		<div class="item"><img src="<?php echo base_url();  ?>_assets/images/global_icon_delete.png" /> Delete product</div>
	</div>
	
	<div class="h_clearboth"></div>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/properties.png" /></div>
		<div class="g_pagelabel_text">Products</div>
		<?php echo $pagination; ?>
	</div>
	
	<?php if ($products) { ?>
	
		<table class="g_table zebra">
		
			<tr>
				<th>Product name</th>
				<th>Status</th>
				<th>Actions</th>
			</tr>
			
			<?php foreach ($products as $products => $p) { ?>
			<tr>
				<td><?php echo $p['product_name']; ?></td>
				<td width="50" align="center">
					<?php if( $p['product_status_flag'] != 2 ){ echo 'Disabled'; }else{ echo 'Enabled'; } ; ?>
				</td>
				
				<!-- actions -->
				<td width="53" align="right">
					<a 	href="<?php echo base_url(); ?>admin/products/edit/<?php echo $p['product_id']; ?>"
						class="g_tableicon"
						title="Edit product">
						<img src="<?php echo base_url(); ?>_assets/images/global_icon_edit.png" />
					</a>	
					<a 	href="javascript:void(0);" 
						class="btn_delete_product g_tableicon" 
						title="Delete product"
						data-product-id="<?php echo $p['product_id']; ?>" 
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

$(".btn_delete_product").click(function(){
	var product_id = $(this).attr('data-product-id');
	var current_page = $(this).attr('data-current-page');
	
	if (confirm("Are you sure you want to delete this product?")) {
		displayNotification("message", "Working...")
		$.ajax({
			url: "<?php echo base_url(); ?>admin/products/process_delete",
			type: "POST",
			data: "product_id="+product_id+"&current_page="+current_page+"&"+$("#form_pagination").serialize(),
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#middle_wrapper").html(response);
					displayNotification("success", "Product successfully deleted.");
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	}
});
</script>