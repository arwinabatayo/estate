	                    
	                    

            <div class="row-fluid plan-summary" style="background:#f2f3f5">
				<h3 align="center">Secure Credit Card Payment</h3> 
				<span class="textcenter block">This is a secure 128-bit SSL encrypted payment</span>
				<hr />	
				<div style="margin-left:10%">
					<h5>* Credit Card Number</h5>
					<p>The 16-digits on the front of your credit card</p>
					<p><input type="text" id="cc_num" name="cc_num" class="input-xlarge" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<img src="<?php echo $assets_url ?>site-blue/images/payment_cclogo.png" alt=""/>
					</p>
				</div>
				<hr />	
	
				<div style="margin-left:10%">
					<h5>*Expiration Date</h5>
					<p>The date your credit card expires. Find this on the front of your credit card. </p>
					
					<select class="input-small">
						<option>01</option>
						<option>02</option>
						<option>03</option>
						<option>04</option>
						<option>05</option>
						<option>06</option>
						<option>07</option>
						<option>08</option>
						<option>09</option>
						<option>10</option>
						<option>11</option>
						<option>12</option>
					</select>
					&nbsp;/&nbsp;
					<select class="input-small">
						<option>2013</option>
						<option>2014</option>
						<option>2015</option>
						<option>2016</option>
					</select>

				</div>
				<hr />	
				
				<div style="margin-left:10%">
					<h5>*Security Code <span style="color:gray">(or "CVC" or "CVV")</span></h5>
					<p>The last 3 digits displayed on the back of your credit card</p>

					<p><input type="text" id="ccv" name="ccv" class="input-xlarge" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<img src="<?php echo $assets_url ?>site-blue/images/payment_ccv.png" alt=""/>
					</p>
					<br class="clear" />
				</div>
				<hr />
                <div align="center" class="plan-sum-btn">
                	<button class="blue-btn" onclick="window.location='<?php echo base_url() ?>payment/payorder'">Pay Now</button>
                </div>
                <br class="clear" />

            </div>
            survey 
