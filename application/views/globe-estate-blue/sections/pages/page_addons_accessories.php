			<div id="main-page" class="span9">
	            <section class="jq-accordion" id="plan-order-page">
	                    <div>
	                        <h3><a href="#">Add-ons | Accessories</a></h3>
	                        <div>
							   <div class="well textright">
									<h4 style="font-size:24px;font-weight:normal">Accessories</h4>
									<p style="font-size:110%">Nullam suscipit ultrices enim. Ut nec sem. Quisque laoreet vulputate dui. Aenean rutrum diam vitae magna rhoncus lobortis. Nunc bibendum, dui in posuere blandit, ante nibh varius felis, a commodo purus leo non risus.</p>
							   </div>
						       
						        <div class="row-fluid product-row">
								   <?php 
								       if($accessories){ 
										   $items = $accessories;
										   include('partials/tpl_cart_item_accessories.php');
										} 
									?>
							   </div>
							   <br />
							   <br />
							   <p class="textright"><button class="btn-large ui-button-success" onclick="window.location.replace('<?php echo base_url() ?>subscriber-info')">CONTINUE</button></p>
	
								
	                        </div>
	                    </div>


	            </section> 
				
			</div>
		
