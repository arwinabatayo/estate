		<?php
			global $breadcrumbs_model; // to do - move this to model
			
			$breadcrumbs_model = array(
				1 => array('name'=>'ADD DEVICE','link'=>''),
				2 => array('name'=>'CHOOSE YOUR PLAN','link'=>'plan'),
				3 => array('name'=>'ADD-ONS','link'=>'addons'),
				4 => array('name'=>'SUBSCRIBERS INFO','link'=>'subscriber-info'),
				5 => array('name'=>'PAYMENT','link'=>'payment'),
			);

		?>
	
	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">

				<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
			
				<a class="brand" href="<?php echo base_url(); ?>">Globe Estate</a>
				
				<div class="nav-collapse">
					
					<form action="#" class="navbar-search pull-right" method="post" accept-charset="utf-8">						<input type="text" name="term" class="search-query span2" placeholder="Search"/>
					</form>
					<ul class="nav pull-right">
						<li><a href="#">Products</a></li>
						<li><a href="#">Shop</a></li>
						<li><a href="#">Broadband</a></li>
						<li><a href="#">Business</a></li>
						<li><a href="#">Help &amp; Support</a></li>
						<!--<li><a href="http://localhost/iserver/projects/nhaus/globe-estate/secure/login">Login</a></li>
						<li><a href="http://localhost/iserver/projects/nhaus/globe-estate/cart/view_cart">Your cart is empty </a></li>-->
					</ul>
					<br />
					<div id="mobile-breadcrumbs">
						<ul class="nav pull-right">
						<?php for ($x=1; $x <= count($breadcrumbs_model); $x++){ 	
							  $cls  = ($x <= $current_step) ? 'current' : '';
							  $href = ($x <= $current_step) ? base_url(). $breadcrumbs_model[$x]['link'] : 'javascript:void(0)';
							  $bullet = ($x <= $current_step) ? '<i class="icon-check icon-white"></i>' : $x.'.';
							?>
							<li><a id="bc_subnav_step<?php echo $x ?>" href="<?php echo $href ?>" class="<?php echo $cls ?>"><?php echo $bullet ?> <?php echo ucwords( $breadcrumbs_model[$x]['name'] ) ?></a>
						
						<?php } ?>
                       </ul>
					</div>
					
				</div>
			</div>
		</div>
	</div>
	
	
	<div class="row-fluid">
		<br />
		<div class="span7 divcenter sub-menu">
			<ul class="nav pull-right">
				<li class="consultation"><a href="javascript: void(0);">Plan Consultation</a></li>
				<li class="calculator"><a href="javascript: void(0);">Reset Calculator</a></li>
				<li class="info" style="margin-right:0"><a href="javascript: void(0);">Status</a></li>
			</ul>
		</div>
	</div>

	
