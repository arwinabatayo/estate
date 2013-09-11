<?php if ($item_count > $pagination_limit) { ?>
<div id="g_pagination">
	<label>&nbsp; Pages &nbsp;</label>

	<?php
	// save everything in an array first
	$counter = 1;
	$pagination_arr = array();
	
	while ($item_count > 0) {
		if ($counter == $current_page) {
			$pagination_arr[$counter] = "<span>".$counter."</span>";
		} else {
			$pagination_arr[$counter] = "<a href='javascript: void(0);' class='page' data-page='".$counter."'>".$counter."</a>";
		}
		$item_count = $item_count - $pagination_limit;
		$counter++;
	}
	?>
	
	<?php $num_items_per_batch = 10; ?>
	<?php $num_batches = ceil(count($pagination_arr) / $num_items_per_batch); ?>
	<?php $current_batch = ceil($current_page / $num_items_per_batch); ?>
	
	<?php if ($current_batch > 1) { ?>
		<a href="javascript: void(0);" class="page" data-page="<?php echo $current_page-1; ?>">&nbsp; Prev &nbsp;</a>
	<?php } ?>
	
	<?php if ($pagination_arr) { ?>
	<?php foreach ($pagination_arr as $key => $value) { ?>
		<?php if (ceil($key / $num_items_per_batch) == ceil($current_page / $num_items_per_batch)) { ?>
			<?php echo $value; ?>
			<?php $last_value = $key; ?>
		<?php } ?>
	<?php } ?>
	<?php } ?>
	
	<?php if ($num_batches > ceil($current_page / $num_items_per_batch)) { ?>
		<a href="javascript: void(0);" class="page" data-page="<?php echo $last_value+1; ?>">&nbsp; Next &nbsp;</a>
	<?php } ?>
	
	<div class="h_clearboth"></div>
</div>

<form id="form_pagination">
	<?php if ($filter_arr) { ?>
		<input type="hidden" name="filter" value="1" />
		<?php foreach ($filter_arr as $key => $value) { ?>
			<input type="hidden" name="<?php echo $key; ?>" value="<?php echo $value; ?>" />
		<?php } ?>
	<?php } ?>
</form>

<div class="h_clearboth"></div>
<?php } ?>

<script type="text/javascript" language="javascript">
$(".page").click(function(){
	displayNotification("message", "Working...");
	var current_page = $(this).attr('data-page');
	$.ajax({
		url: "<?php echo base_url(); ?>admin/<?php echo $page; ?>/process_items",
		type: "POST",
		data: "current_page="+current_page+"&"+$("#form_pagination").serialize(),	
		success: function(response, textStatus, jqXHR){
			setTimeout(function () {
				$("#middle_wrapper").html(response);
				hideAllNotifications();
			}, 500);
		},
		error: function(jqXHR, textStatus, errorThrown){
			displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
		}
	});
});
</script>