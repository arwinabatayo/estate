<div class="ft_body">
<div class="g_inner">
	
	<div class="ft_label">Why Sitemee</div>
	
	<div class="wrapper">
	
		<div class="left">
		<div class="inner">
		
			<?php if ($features) { ?>
			<?php foreach ($features as $feature => $f) { ?>
			
				<div class="ft_item">
					<div class="box">
						<img src="<?php echo base_url(); ?>_assets/images/features/<?php echo $f['img']; ?>" />
						<div class="text">
							<div class="label"><?php echo $f['feature']; ?></div>
							<div class="desc"><?php echo $f['description']; ?></div>
						</div>
					</div>
				</div>
		
			<?php } ?>
			<?php } ?>
			
		</div>
		</div>
		
		<div class="right">
		<div class="inner">
		
			<?php if ($benefits) { ?>
			<?php foreach ($benefits as $benefit => $b) { ?>
			
				<div class="ft_item">
					<div class="box">
						<img src="<?php echo base_url(); ?>_assets/images/features/<?php echo $b['img']; ?>" />
						<div class="text">
							<div class="label"><?php echo $b['feature']; ?></div>
							<div class="desc"><?php echo $b['description']; ?></div>
						</div>
					</div>
				</div>
		
			<?php } ?>
			<?php } ?>
		
		</div>
		</div>
		
		<div class="h_clearboth"></div>
	
	</div>
	
</div>
</div>