<div id="message_wrapper" class="notification">
<div class="inner">
	<div id="message">Working...</div>
	<img src="<?php echo base_url(); ?>_assets/images/loading.gif" />
</div>
</div>

<div id="success_wrapper" class="notification notification_top">
	<div class="icon"></div>
	<div class="close">
		<img 	class="g_tableicon" 
				title="Close"
				src="<?php echo base_url(); ?>_assets/images/global_icon_close.png" />
	</div>
	<div id="success"></div>
</div>

<div id="error_wrapper" class="notification notification_top">
	<div class="icon"></div>
	<div class="close">
		<img 	class="g_tableicon" 
				title="Close"
				src="<?php echo base_url(); ?>_assets/images/global_icon_close.png" />
	</div>
	<div id="error"></div>
</div>

<script type="text/javascript" language="javascript">
$(".close").click(function(){
	hideAllNotifications();
});
</script>