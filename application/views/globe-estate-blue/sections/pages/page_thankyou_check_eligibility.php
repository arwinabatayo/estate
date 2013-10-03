		<?php //print_r($eligible_numbers); ?>					  

				<div class="check-eligibility">
					<!--<h2>Thank you for lorem Ipsum, dolor sit amet</h2>-->
					<?php if($eligible_numbers){ ?>	
					<!--<p>However our system shows that you have <?php echo count($eligible_numbers) ?> other numbers associated with this account. You may check the eligibility by selecting the number you want to add. If you wish to leave the page, you may select exit.</p>-->
					<p>You seem to have 3 other numbers associated with this account. Would you like to merge them into this account ?</p>
					<?php } ?>	
					<hr/>
					
					<div class="check-eligibility-btn">
						<ul>
							<?php 

							if($eligible_numbers){ ?>
								<?php foreach($eligible_numbers as $row){ ?>
								
							
								<li>
									<input tabindex="1" type="radio" id="flat-radio-1" name="eligible_number" style="" value="<?php echo $row->mobile_numbers ?>" />
									<label for=""><?php echo $row->mobile_numbers ?></label>
								</li>
								<?php } ?>
								
							<?php } ?>
						</ul>
						
						<div class="clr"></div>
					</div>
					<br />
					<?php if($eligible_numbers){ ?>
					<button class="blue-btn fl">Check Eligibility</button>
					<button class="blue-btn fr">Exit</button>
					<?php }else{ ?>
						<p class="textcenter"><button class="blue-btn" onclick="window.location='<?php echo base_url() ?>'">Exit</button></p>
					<?php } ?>
					
					<div class="clr"></div>
				</div>
