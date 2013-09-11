			<div id="main-page" class="span9">
	            <section class="jq-accordion" id="plan-order-page">
	                    <div>
	                        <h3><a href="#">Add-ons Accessories</a></h3>
	                        <div>
							   <div class="well textright">
									<h4 style="font-size:24px;font-weight:normal">Retain Current Plan</h4>
									<p style="font-size:110%">Nullam suscipit ultrices enim. Ut nec sem. Quisque laoreet vulputate dui. Aenean rutrum diam vitae magna rhoncus lobortis. Nunc bibendum, dui in posuere blandit, ante nibh varius felis, a commodo purus leo non risus.</p>
							   </div>
						   
							   <h5 class="textright">Gadget Care</h5>
							   <div class="row-fluid product-row">
								   <?php 
								       if($gadget_care){ 
										   $items = $gadget_care;
										   include('partials/tpl_cart_item.php');
										} 
									?>
								   <!--
									<div class="span2 product-item">
										<img src="<?php echo $assets_path ?>images/gadget.jpg" alt="" />
									</div>
									-->
									
							   </div>
							   <br />
							   <hr />
							   <h5 class="textright">Freebies</h5>
							   <div>
							   <div class="row-fluid product-row">
								   <?php 
								       if($freebies){ 
										   $items = $freebies;
										   include('partials/tpl_cart_item.php');
										} 
									?>
									
								   <?php /*
									<div class="span2 product-item">
										<img src="<?php echo $assets_path ?>images/freebies.jpg" alt="" />
									</div>
									* */ ?>
							   </div>
							   <br />
							   </div>
							   <hr />
							   <h5 class="textright">Special Offers</h5>
							   <div>
								   <div class="row-fluid product-row">
									
								   <?php 
								       if($offers){ 
										   $items = $offers;
										   include('partials/tpl_cart_item.php');

										} 
									?>
									<?php /*
										<div class="span2 product-item">
											<img src="<?php echo $assets_path ?>images/offers.jpg" alt="" />
										</div>
									*/ ?>	
										
								   </div>
								   <br />
							   </div>
							   <br />
							   <br />
							   
							   <p class="textright"><button class="btn-large ui-button-success" onclick="window.location.href='<?php echo base_url() ?>addons/accessories'">CONTINUE</button></p>
	
								
	                        </div>
	                    </div>


	            </section> 
				
			</div>
		
