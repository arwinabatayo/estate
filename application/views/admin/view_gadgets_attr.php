<tr id="gadget-attr-<?php echo $item_count; ?>">
	<td>
		<?php 
			foreach ($imgs['datas'] as $img) { 
				$imgSrc = $img['src'];
				$imgName =  $img['name'];
		?>
			<input type="radio" name="details[<?php echo $item_count; ?>][img]" id="img-<?php echo $item_count; ?>" value="<?php echo $imgName; ?>">
			<img src="<?php echo $imgSrc; ?>" class="selectImg">
		<?php } ?>
		
	</td>
	<td><input type="text" name="details[<?php echo $item_count; ?>][cid]" id="cid" value="" placeholder="CID" size="8" data-required="1"></td>
	<td>
		<?php if ($colors) { ?>
		<select name="details[<?php echo $item_count; ?>][color]" data-required="1">
			<option>Color</option>
			<?php foreach ($colors as $color => $a) { ?>
			<option value="<?php echo $a['id']?>"><?php echo $a['name']?></option>
			<?php }?>
		</select>
		<?php } else { ?>
		Color not set
		<?php } ?>
	</td>
	<td>
		<?php if ($net_connectivity) { ?>
		<select name="details[<?php echo $item_count; ?>][net_connectivity]" data-required="1">
			<option>Network Connectivity</option>
			<?php foreach ($net_connectivity as $net_conn => $a) { ?>
			<option value="<?php echo $a['id']?>"><?php echo $a['name']?></option>
			<?php }?>
		</select>
		<?php } else { ?>
		Network Connectivity not set
		<?php } ?>
	</td>
	<td>
		<?php if ($data_capacity) { ?>
		<select name="details[<?php echo $item_count; ?>][data_capacity]" data-required="1">
			<option>Data Capacity</option>
			<?php foreach ($data_capacity as $data_cap => $a) { ?>
			<option value="<?php echo $a['id']?>"><?php echo $a['name']?></option>
			<?php }?>
		</select>
		<?php } else { ?>
		Data Capacity not set
		<?php } ?>
	</td>
	<td><input type="text" name="details[<?php echo $item_count; ?>][amount]" id="amount" value="" placeholder="Amount" size="7" data-required="1"></td>
	<td><input type="text" name="details[<?php echo $item_count; ?>][discount]" id="discount" value="" placeholder="Discount" size="7" data-required="1"></td>
	<td><input type="text" name="details[<?php echo $item_count; ?>][peso_value]" id="peso_value" value="" placeholder="Peso Value" size="9" data-required="1"></td>
	<td><input type="text" name="details[<?php echo $item_count; ?>][qty]" id="qty" value="" placeholder="Quantity" size="5" data-required="1"></td>
	<td>
		<select name="details[<?php echo $item_count; ?>][is_active]" data-required="1">
			<option>Status</option>
			<option value="1">Enable</option>
			<option value="0">Disable</option>
		</select>
	</td>
	<td>
		<a href="javascript:void(0);" class="btn_deleteAttr g_tableicon" title="Delete Attribute">
			<img src="<?php echo base_url(); ?>_assets/images/global_icon_delete.png" />
		</a>
	</td>
</tr>