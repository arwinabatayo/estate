		<?php
			
			global $breadcrumbs_model

		?>
		
		
		<?php if($show_breadcrumbs){ ?>
		<div class="row textcenter" id="desktop-breadcrumbs">
			<div class="steps">
				<?php for ($x=1; $x <= count($breadcrumbs_model); $x++){ 	
					  $cls  = ($x <= $current_step) ? 'current' : '';
					  $href = ($x <= $current_step) ? base_url(). $breadcrumbs_model[$x]['link'] : 'javascript:void(0)';
					?>
					 <a id="bc_step<?php echo $x ?>" href="<?php echo $href ?>" class="<?php echo $cls ?>"><?php echo $x ?>. <?php echo $breadcrumbs_model[$x]['name'] ?></a>
				
				<?php } ?>
				
			</div>
			<br />		
			<br />	
		</div>		
		<?php } ?>

