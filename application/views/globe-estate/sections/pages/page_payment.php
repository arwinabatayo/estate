			<div id="main-page" class="span10 divcenter">
	            <section class="jq-accordion" id="personal-info-page">

	                    <div>
	                        <h3><a href="#">Your Cart</a></h3>
	                       
							<div>
								<?php include('partials/payment_cart_summary.php') ?>
								
								<br class="clear">
								<br />	
							    <p class="textright"><button class="btn-large ui-button-success goNext">CONTINUE</button></p>
	                        </div>
	                    </div>

	                    <div>
	                        <h3><a href="#">Delivery / Pickup</a></h3>
	                        <div>
								
								<div class="textcenter">
									<h4 style="font-size:24px;font-weight:normal">Where do you want to pickup your order?</h4>
									<br />
									<p>
									<input type="radio" name="delivery_mode" value="ship" checked="checked" />Deliver &nbsp;&nbsp;&nbsp;
									<input type="radio" name="delivery_mode" value="pickup" />Pickup
									</p>
								</div>

							    <br />
								
								<?php include('partials/payment_delivery_pickup.php') ?>
								
								
								<?php include('partials/payment_delivery_ship.php') ?>
							   
							   <br />			      
							   <br />			      
							   
							   <p class="textright"><button class="btn-large ui-button-success goNext" >CONTINUE</button></p>
	                        </div>
	                    </div>

	                    <div>
	                        <h3><a href="#">Pay Your Order</a></h3>
	                        <div>
							   <br />	
                               <div class="textcenter">
									<h4 style="font-size:24px;font-weight:normal">Choose your Payment Method</h4>
									<br />
									<p>
									<input type="radio" name="payment_option" value="cc" checked="checked" />Credit Card &nbsp;&nbsp;&nbsp;
									<input type="radio" name="payment_option" value="gcash" checked="checked" />G-Cash &nbsp;&nbsp;&nbsp;
									<input type="radio" name="payment_option" value="bill" checked="checked" />Charge to Bill &nbsp;&nbsp;&nbsp;
									<input type="radio" name="payment_option" value="eps" checked="checked" />EPS /Debit Card &nbsp;&nbsp;&nbsp;
									</p>
									<br />
									<br />
									<!--<p><button class="btn-large ui-button-success" onclick="window.location.href='<?php echo base_url() ?>payment/gateway'">CONTINUE</button></p>-->
									<p><button class="btn-large ui-button-success" id="btnProceedToPayment">CONTINUE</button></p>
							   </div>
	                        </div>
	                    </div>

	            </section> 
	            
	            
			</div>
		
