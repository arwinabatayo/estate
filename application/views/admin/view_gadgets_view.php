
<div id="g_content">
	<div id="g_tools"> 
	
		<a href="<?php echo base_url(); ?>admin/gadgets"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/list.png" />Gadgets List</a>	
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>
	<div class="g_spacer"></div>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/add.png" /></div>
		<div class="g_pagelabel_text">Add gadget - <?php echo $gadgets_details['name']; ?></div>
	</div>
	
	<form id="form_add_gadgets" class="g_form">
	<table class="g_table zebra">
		<tr><td class="g_widget">
		
				<!-- gadgets title -->
				<div class="item">
					<div class="label">Name *</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="name" 
								maxlength="100"
								data-alphanum="1"				
								data-unique="1"
								data-field="name"
								data-table="estate_plan_bundle"
								value="<?php echo $gadgets_details['name']; ?>"
								data-required="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				<!-- status -->
				<div class="item">
					<div class="label">Status *</div>
					<div class="input">
						<select class="g_select" name="is_active" data-required="1">
							<option value="" selected="selected">Select status</option>
							<option value="0">Disabled</option>
							<option value="1">Enabled</option>
						</select>
					</div>
					<div class="h_clearboth"></div>
				</div>
				<!-- status -->
				<div class="item">
					<div class="input">
						<input type="button" name="addAttr" id="addAttr" value="Add Attribute" data-img-cnt="0">
					</div>
					<div class="h_clearboth"></div>
				</div>
		</td></tr>
	</table>
	<table class="g_table zebra" id="attrDetails">
		<tr>
			<th>Image</th>
			<th>CID</th>
			<th>Color</th>
			<th>Network Connectivity</th>
			<th>Capacity</th>
			<th>Amount</th>
			<th>Discount</th>
			<th>Peso Value</th>
			<th>Quantity</th>
			<th>Status</th>
			<th>Action</th>
		</tr>
		<?php foreach($gadgets_details['attrs'] as $attrs) { ?>
		<tr id="gadget-attr-<?php echo $attrs['id']; ?>">
			<td><img src="<?php echo base_url()."_assets/uploads/thumbnail/".$attrs['image']; ?>" class="selectImg"></td>
			<td><?php echo $attrs['cid']; ?></td>
			<td><?php echo $attrs['colorattr']; ?></td>
			<td><?php echo $attrs['netwoattr']; ?></td>
			<td><?php echo $attrs['datacapattr']; ?></td>
			<td><?php echo $attrs['amount']; ?></td>
			<td><?php echo $attrs['discount']; ?></td>
			<td><?php echo $attrs['required_pv']; ?></td>
			<td><?php echo $attrs['stock_qty']; ?></td>
			<td><?php echo $attrs['is_active']; ?></td>
			<!-- actions -->
			<td width="60" align="center">
				<a 	href="javascript:void(0);" 
					class="btn_delete g_tableicon" 
					title="Delete gadget"
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
		
	</form>
	
</div>

<script src="<?php echo base_url() . '_assets/js/jquery.min.js'; ?>"></script>
<script src="<?php echo base_url() . '_assets/jquery-file-upload/js/vendor/jquery.ui.widget.js'; ?>"></script>
<script src="<?php echo base_url() . '_assets/jquery-file-upload/js/jquery.iframe-transport.js'; ?>"></script>
<script src="<?php echo base_url() . '_assets/jquery-file-upload/js/jquery.fileupload.js'; ?>"></script>

<script type="text/javascript" language="javascript">
$(function() {
	placeHolder();
	checkSidebarStatus();
	hideSidebar(1);
	
	jQuery.extend({
	    handleError: function( s, xhr, status, e ) {
	        // If a local callback was specified, fire it
	        if ( s.error )
	            s.error( xhr, status, e );
	        // If we have some XML response text (e.g. from an AJAX call) then log it in the console
	        else if(xhr.responseText)
	            console.log(xhr.responseText);
	    }
	});
	
});



</script>