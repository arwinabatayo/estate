	                    
	                    

           <h3>Payment Method</h3>
            
            <div class="row-fluid plan-summary">
            	<form>
				<table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                    	<h3 align="center">Choose your payment Method</h3>                   	
                    </tr>                                        
                    <tr class="light">
                    	<td>                	
							<div class="account-group">
								<div class="accordion-body">
									<div class="accordion-inner">
										<ul>
											<li>
												<div class="payment_container">
													<div class="fl atm">
														<span><img src="<?php echo $assets_url ?>site-blue/images/atm.png"/></span>
														<input id="atm" type="radio" name="payment_method" value="atm" data-api='payment-checkout'><label class="adjust" for="atm"></label>
														<div><p>Credit Card</p></div>
													</div>
													<div class="fl gcash">
														<span><img src="<?php echo $assets_url ?>site-blue/images/gcash.png"/></span>
														<input id="gcash" type="radio" name="payment_method" value="gcash" data-api="payment-gcash"><label class="adjust" for="gcash"></label>
														<div><p>GCash</p></div>
													</div>
													<div class="fl chargetobill">
														<span><img src="<?php echo $assets_url ?>site-blue/images/chargebill.png"/></span>
														<input id="chargetobill" type="radio" name="payment_method" value="chargetobill" data-api="payment-chargetobill"><label class="adjust" for="chargetobill"></label>
														<div><p>Charge to Bill</p></div>
													</div>
													<div class="fl debitcard">
														<span><img src="<?php echo $assets_url ?>site-blue/images/debitcard.png"/></span>
														<input id="debitcard" type="radio" name="payment_method" value="debitcard" data-api="payment-debitcard"><label class="adjust" for="debitcard"></label>
														<div><p>EPS / Debit Card</p></div>
													</div>
													<div class="clr"></div>
												</div>
											</li>
										</ul>	
									</div>
								</div>	  	
							</div>						
                    	</td>                	
                    </tr>                
                </table> 
	                <div align="center" class="plan-sum-btn">
	                	<button class="blue-btn" id="paymentMethodBtn">Continue</button>
	                </div>
                </form>
            </div>
            
