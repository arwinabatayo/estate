		<?php global $breadcrumbs_model ?>
		
		
		<?php 
		
		if($show_breadcrumbs){ ?>
            <ul class="breadcrumb flow-breadcrumb pull-right">
				<?php for ($x=1; $x <= count($breadcrumbs_model); $x++){ 	
					  $cls  = ($x <= $current_step) ? ' selected' : '';
					  $href = ($x <= $current_step) ? base_url(). $breadcrumbs_model[$x]['link'] : 'javascript:void(0)';
					?>
                <li class="arrow<?php echo $cls ?>">
					<a id="bc_step<?php echo $x ?>" href="<?php echo $href ?>" class="<?php echo $cls ?>">
						<span class="num"><?php echo $x ?></span><?php echo $breadcrumbs_model[$x]['name'] ?>
						<?php
						if($x < count($breadcrumbs_model)) echo '<span class="arrow-point"></span>';
						?>
						
					</a>
				</li>
                <?php } ?>
            </ul>
         	<?php } ?>


