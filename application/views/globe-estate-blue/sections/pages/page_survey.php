		<div class="row-fluid flow rec">
	        <div class="container">
		        <form method="post" id="surveyForm">
		            <div class="span6 lgreybg t-f-order">         
						<h3>We would like to fit our<br /> offering to your interest</h3>
						
						<hr/>
						
						<p><strong>Please check all that apply.</strong></p><br />
						
						<div class="thank-order-check">
							<ul>
								<?php if($survey_list) { ?>
									<?php foreach ($survey_list as $key => $values) { ?>
								<li>
									<input type="checkbox" name="survey[<?php echo $values['id'] ?>]" id="<?php echo $values['id'] ?>" value="<?php echo $values['id'] ?>" />
									<label for="Gadgets"><?php echo $values['name']; ?></label>
								</li>
									<?php } ?>
								<?php } ?>
								
							</ul>
							
			        		<div align="center" class="plan-sum-btn">
			                	<button class="blue-btn" id="surveyBtn">Continue</button>
			                </div>
						</div>
					</form>
	            </div>
	            <div class="span6 dbluebg" style="min-height: 460px;">
	                <div class="row-fluid">
	                    <span class="flow-title2">Thank you! We have received your payment and order.</span>
	                </div>
	                <div class="row-fluid">
	                    <div class="link-printrec">
	                        <i class="flow-icon icon-printrec pull-left"></i>
	                        <a>Print your receipt.</a>    
	                    </div>
	                </div>
	                <div class="row-fluid">
	                    <p class="flow-instruction">An email will be sent to you shortly containing a reference number. You can use this to check the status of your order.</p>
	                </div>
	            </div>
	        </div>
	    </div>
