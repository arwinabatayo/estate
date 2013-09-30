	                    
	                    

           <h3>Delivery</h3>
		    <div style="background:linear-gradient(to bottom, #ffffff 0%,#d7e2f1 100%);">
		      
					<div class="pickup">
							<div class="del-option">
								<ul>
									<li>
										<div class="billing-container">
											<input type="radio" value="billing" name="shipping_address" id="billing"><label for="billing">Ship to my Billing Address</label>
										</div>
										<div class="delContent myAdd" id="billingContent">
	
	
				                            <table width="100%" cellpadding="5" cellspacing="0">
				                                <tr class="title">
				                                    <td>Billing Address</td>
				                                    <td>Home Telephone</td>
				                                    <td>Mobile Number</td>                                                                
				                                </tr>
				                                <tr>
				                                    <td>
													<?php //TODO - move to address formatter helper  ?>
													<?php echo $billing_address->street.', '.$billing_address->subdivision .'<br />' ?>
													<?php echo $billing_address->municipality.', '.$billing_address->city .' '. $billing_address->postal_code.'<br />' ?>
													                            
				                                    </td>
				                                    <td>049 5117788</td>
				                                    <td><?php echo $account_info->mobile_number ?></td>                                                                
				                                </tr>                            
				                            </table>
	
											<div class="clr"></div>
										</div>
										
									</li>
									<li>
										<div class="ship-container">
											<input type="radio" value="ship" name="shipping_address" id="ship"><label for="ship">Ship to Different Address</label>
										</div>
										<div class="delContent myAdd" id="shipContent" style="display: none;">
				                            <table width="100%" cellpadding="2" cellspacing="0">
				                                <tr>
				                                    <td><span>Room / Floor / House Number</span></td>
				                                    <td><span>Building Name / Street</span></td>
				                                    <td><span>Subdivision / Barangay</span></td>                                                                
				                                </tr>
				                                <tr>
				                                    <td><input type="text" id="unit" name="unit" required class="input-large" /></td>
				                                    <td><input type="text" id="unit" name="street" class="input-large" /></td>
				                                    <td><input type="text" id="unit" name="barangay" class="input-large" /></td>                                                                
				                                </tr>                            
				                                <tr>
				                                    <td><span>Municipality/Town</span></td>
				                                    <td><span>City/Province</span></td>
				                                    <td><span>Postal Code/Zip Code</span></td>                                                                
				                                </tr>
				                                <tr>
				                                    <td><input type="text" id="city" name="city" class="input-large" /></td>
				                                    <td><input type="text" id="town" name="town" class="input-large" /></td>
				                                    <td><input type="text" id="postal" name="postal" class="input-large" /></td>                                                                
				                                </tr>   
				                                <tr>
													<td colspan="3">
														<p class="bold">Contact Details</p>
														<h6>Home Telephone Number</h6>
													</td>
				                                </tr>                         
				                                <tr>
				                                    <td><span>Area Code</span></td>
				                                    <td><span>Telephone Number</span></td>
				                                    <td></td>                                                                
				                                </tr>
				                                <tr>
				                                    <td><input type="text" id="area" name="area" class="input-large" /></td>
				                                    <td><input type="text" id="landline" name="landline" class="input-large" /></td>
				                                    <td></td>                                                                
				                                </tr>                            
				                                <tr>
													<td colspan="3">
														<p>&nbsp;</p>
														<h6>Mobile Number</h6>
													</td>
				                                </tr>                         
				                                <tr>
				                                    <td><span>Area Code</span></td>
				                                    <td><span>Mobile Number</span></td>
				                                    <td><span>Network Carrier</span></td>                                                            
				                                </tr>
				                                <tr>
				                                    <td><input type="text" id="access_code" name="access_code" class="input-large" /></td>
				                                    <td><input type="text" id="mobile_number" name="mobile_number" class="input-large" /></td>
				                                    <td>
														<select name="network_carrier" class="input-large">
															<option value="smart">Smart Post Paid</option>
															<option value="sun">Sun Cellular</option>
														</select>
				                                    </td>                                                                
				                                </tr>                            
				                            </table>
															
									</div>
									</li>
								</ul>	
							</div>
					</div>
		    </div>
			<div class="textright">
					<br />
					<button class="blue-btn" id="shippingTypeBtn">Continue</button>   
			</div>
            
	

