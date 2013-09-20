<div id="g_content">
	<div class="h_clearboth"></div>
	<div class="g_spacer"></div>
	
	<?php echo $filter; ?>
	
	<div class="g_pagelabel h_width80px h_floatleft">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/generic.png" /></div>
		<div class="g_pagelabel_text">Legend</div>
	</div>
	
	<div id="g_legend">
		<div class="item">Click co-existence to Edit</div>
	</div>
	
	<div class="h_clearboth"></div>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/properties.png" /></div>
		<div class="g_pagelabel_text">Co-Existence - <?php echo $coexist_name; ?></div>
		<?php echo $pagination; ?>
	</div>
	
	<?php if ($coexistence) { ?>
		<table class="g_table zebra">
			<tr>
			<th></th>
			<?php foreach($coexistence['headers'] as $ids => $value) { ?>
				<th style="padding: 2px !important;"><?php echo $value; ?></th>
			<?php } ?>
			</tr>
			<?php foreach($coexistence as $ids => $value) { ?>
			<tr>
				<th style="padding: 2px !important;"><?php echo $value['name']; ?></th>
				<?php 
					foreach($value['coex'] as $coexID => $coexValue) {
						
						switch ($coexValue['is_acceptable']) {
							case "0" :
								$sRet = "NO";
								$addbg = 'background-color: #A2B824 !important; color: #fff !important;';
							break;
							case "1" : 
								$sRet ="YES";
								$addbg = "";
							break;
						}
				?>
				<td style="padding: 2px !important;font-weight:bold !important;<?php echo $addbg; ?>" class="editable" id="<?php echo $coexValue['coexid']; ?>">
					<?php echo $sRet; ?>
				</td>
				<?php }?>
			</tr>
			<?php } ?>
			<!-- HERE -->
			
		</table>
			
	<?php } else { ?> 
		
		<table class="g_table">
			<tr><td class="h_padding20"><div class="g_nodata"><div class="icon"></div>No data to display</div></td></tr>
		</table>
			
	<?php } ?>
	
	<div class="g_pagination_wrapper"><?php echo $pagination; ?></div>
	
</div>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>_assets/js/jquery.jeditable.js"></script>
<script type="text/javascript" language="javascript">
$(function(){
	zebraTable();
	hideSidebar(1);
	
	$('.editable').editable("<?php echo base_url(); ?>admin/coexistence/process_editable_save", { 
	     data   : " {0:'NO',1:'YES'}",
	     type   : 'select',
	     submit : 'OK',
	   	 style   : 'display: inline',
   		 callback : function(value, settings) {
   	   		 
   	   		if(value == 'YES') {
	   	   		$(this).attr("style","padding: 2px !important;font-weight:bold !important;");
   	   		} else {
				$(this).attr("style","padding: 2px !important;font-weight:bold !important;background-color:#A2B824 !important;color:#FFF !important;");
   	   		}
            console.log(this);
            console.log(value);
            console.log(settings);
         }
	 });
});

$(".btn_delete").click(function(){
	var id = $(this).attr('data-id');
	var current_page = $(this).attr('data-current-page');
	var name = $(this).attr('data-value-name');	
	if (confirm("Are you sure you want to delete "+name+"?")) {
		displayNotification("message", "Working...")
		$.ajax({
			url: "<?php echo base_url(); ?>admin/coexistence/process_delete",
			type: "POST",
			data: "id="+id+"&current_page="+current_page+"&"+$("#form_pagination").serialize(),
			success: function(response, textStatus, jqXHR){
				
				setTimeout(function () {
					displayNotification("success", "Co-Existence "+name+" successfully deleted, Please wait.");
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