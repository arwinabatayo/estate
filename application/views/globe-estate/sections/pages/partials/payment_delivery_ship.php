							   
							   <div id="delivery_ship">
								   <div class="textleft">
										<h4 style="font-size:24px;font-weight:normal">Delivery</h4>
										<br />
										<div class="row-fluid">
											<div class="span6 noLeftMargin">
												<div class="headerbox">
													Billing Address
												</div>
												<div class="contentbox">
													<?php //TODO - move to address formatter helper  ?>
													<?php echo $billing_address->street.', '.$billing_address->subdivision .'<br />' ?>
													<?php echo $billing_address->municipality.', '.$billing_address->city .' '. $billing_address->postal_code.'<br />' ?>
													
													<?php //TODO - get from account info ?>
													Home Telephone Number: 049 5117788<br />
													Mobile Number: 0915 1178863
												</div>
												<br />
												<input type="radio" name="shipping_address" value="billing" checked="checked" />Ship to my Billing Address &nbsp;&nbsp;&nbsp;
												<input type="radio" name="shipping_address" value="new" />Ship to Diffrent Address
												
											</div>
											
											
											<div class="span6">
												<div class="headerbox">
													Shipping Address
												</div>
												<div class="contentbox">
													<div id="shipping_address_field">Same as Billing Address</div>
													
													<form id="new-shipping" class="form-inline" onsubmit="return false">
															<div id="shipping_address_new" style="display:none">
																<div class="row-fluid">
																	<span class="span6 ">
																		<label>Room/Floor/House Number</label>
																		<input type="text" id="unit" name="unit" required class="input-medium" />
																	</span>
																	<span class="span6 ">
																		<label>Building Name/Street</label>
																		<input type="text" id="unit" name="street" class="input-medium" />
																	</span>
																</div>	
																<div class="row-fluid">
																	<span class="span6 ">
																		<label>Subdivision/Barangay</label>
																		<input type="text" id="unit" name="barangay" class="input-medium" />
																	</span>
																	<span class="span6 ">
																		<label>Municipality/Town</label>
																		<input type="text" id="unit" name="town" class="input-medium" />
																	</span>
																</div>	
																<div class="row-fluid">
																	<span class="span6 ">
																		<label>City/Province</label>
																		<input type="text" id="unit" name="city" class="input-medium" />
																	</span>
																	<span class="span6 ">
																		<label>Postal Code/Zip Code</label>
																		<input type="text" id="unit" name="postal" class="input-medium" />
																	</span>
																</div>	
																<br />
																<h5>Contact Details</h5>
																<p class="bold">Home Telephone Number</p>
																<div class="row-fluid">
																	<span class="span6 ">
																		<label>Area Code</label>
																		<input type="text" id="area" name="area" class="input-medium" />
																	</span>
																	<span class="span6 ">
																		<label>Telephone Number</label>
																		<input type="text" id="landline" name="landline" class="input-medium" />
																	</span>
																</div>	
																<br />
																<p class="bold">Mobile Number</p>
																<div class="row-fluid">
																	<span class="span4 ">
																		<label>Access Code</label>
																		<input type="text" id="access_code" name="access_code" class="input-mini" />
																	</span>
																	<span class="span4 ">
																		<label>Mobile Number</label>
																		<input type="text" id="mobile" name="mobile_number" class="input-small" />
																	</span>
																	<span class="span4 ">
																		<label>Network Carrier</label>
																		<select name="network_carrier" class="input-small">
																			<option value="smart">Smart Post Paid</option>
																			<option value="sun">Sun Cellular</option>
																		</select>
																	</span>
																</div>	
																
																<br />
																<br />
																
																	<p style="text-align:right"></p><button class="btn btn-primary">SAVE</button></p>
																<br />
															</div>
													</form>		
															
												</div>
												<br />
											</div>
											<br class="clear" />
										</div>

								   </div>
							   </div>	
