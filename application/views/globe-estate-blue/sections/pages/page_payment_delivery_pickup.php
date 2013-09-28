	                    
	                    

           <h3>Delivery / Pickup</h3>
           <form method="POST" id="delorpickForm">
	            <div class="row-fluid del-pickup">
					<h1>How would you like to get your order?</h1>
	                <ul>
	                	<li>
	                    	<img src="<?php echo $assets_url ?>site-blue/images/icon-delpick.png">
	                        <span>
	                        	<input type="radio" value="delivery" name="delivery_mode" id="delivery">
	                        	<label for="delivery">Delivery</label>
	                        </span>
						</li>
	                   	<li>
	                    	<img src="<?php echo $assets_url ?>site-blue/images/icon-delpick2.png">                    
	                        <span><input type="radio" value="pickup" name="delivery_mode" id="pickup">
	                        	<label for="pickup">Pickup</label>
	                        </span>
	                    </li>
	                </ul>
	                <div class="button">
	                	<button class="blue-btn" id="deliveryorpickupBtn">Continue</button>
	                </div>
	            </div>
            </form>
