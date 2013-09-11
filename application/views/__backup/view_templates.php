<div class="tm_body">
<div class="g_inner">

	<div class="tm_label">Templates</div>

	<div class="items">
		
		<?php if ($templates) { ?>
		<?php foreach ($templates as $template => $t) { ?>
		
			<div class="item">
			<div class="inner">
				
				<div class="platform">
					<?php if ($t['template_type_id'] == 4) { ?>
						<img src="<?php echo base_url(); ?>_assets/images/template_types/6.png" />
					<?php } ?>
					<img src="<?php echo base_url(); ?>_assets/images/template_types/<?php echo $t['template_type_id']; ?>.png" />
					<?php if ($t['responsive']) { ?>
						<img src="<?php echo base_url(); ?>_assets/images/template_types/html5.png" />
					<?php } ?>
					<div class="h_clearboth"></div>
				</div>
				<div class="screen">
					<img src="<?php echo $t['screenshot_path']; ?>" />
				</div>
				<div class="label"><?php echo $t['title']; ?></div>
				<div class="description"><?php echo $t['description']; ?></div>
				
			</div>
			</div>
		
		<?php } ?>
		<?php } ?>

		
		<div class="h_clearboth"></div>
		
	</div>
	
</div>
</div>

<script type="text/javascript" language="javascript">
// hover in description
$(".screen").hover(
	function(){ $(this).children('.description').fadeIn(250); },
	function(){ $(this).children('.description').fadeOut(250); }
);
</script>