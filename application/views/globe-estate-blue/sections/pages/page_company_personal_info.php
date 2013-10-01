	                    
	                    
		<div class="accordion2 account-content active" id="accordion3">
                        <div class="accordion-group account-content-grp">
                          <div class="accordion-heading">
                            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse4">
                              Company Information <i class="tcoll collapse-toggle"></i>
                            </a>
                          </div>
            
            <div class="row-fluid" id="delivery">
            <form method="post" action="/estate_new/subscriber/saveCompanyPersonalInfo?info_type=company">
              	
								<div class="account-group">
									<div class="accordion-body">
										<div class="accordion-inner">
											
											<p>Some text here</p>

											<div>
												<strong>Company Name</strong></br>
												<input type="text" name="name">
											</div>

											</br><p><strong>Registered Business Address</strong></p></br>

											<div>
												<div>
													<strong>Unit/Floor</strong></br>
													<input type="text" name="unit">
												</div>
												<div>
													<strong>Building Name/Street No.</strong></br>
													<input type="text" name="building_name">
												</div>
												<div>
													<strong>Street Name</strong></br>
													<input type="text" name="street">
												</div>
											</div>

											<div>
												<div>
													<strong>Barangay</strong></br>
													<input type="text" name="barangay">
												</div>
												<div>
													<strong>Municipality/Town</strong></br>
													<input type="text" name="municipality">
												</div>
											</div>


											<div>
												<div>
													<strong>City/Province</strong></br>
													<input type="text" name="city">
												</div>
												<div>
													<strong>Postal Code/Zip Code</strong></br>
													<input type="text" name="postal">
												</div>
											</div>

											<div>
												<div>
													<strong>Industry</strong></br>
													<select name="industry">
														<option>test</option>
													</select>
												</div>
											</div>

											</br><p><strong>Authorized Corporate / Officer Signatory 1 (Signatory 2 is also required; same field required)</strong></p></br>

											<div>
												<div>
													<strong>Position in Company</strong></br>
													<input type="text" name="position_1">
												</div>
												<div>
													<strong>Email Address</strong></br>
													<input type="text" name="email_1">
												</div>
											</div>


											<div>
												<div>
													<strong>Contact Number</strong></br>
													<input type="text" name="contact_1">
												</div>
												<div>
													<strong>Authorized Corporate / Officer</strong></br>
													<input type="text" name="authorized_1">
												</div>
											</div>


											</br><p><strong>After-Sales Corporate Signatory 1 (Signatory 2 is required; same field required)</strong></p></br>

											<div>
												<div>
													<strong>Position in Company</strong></br>
													<input type="text" name="position_2">
												</div>
												<div>
													<strong>Email Address</strong></br>
													<input type="text" name="email_2">
												</div>
											</div>


											<div>
												<div>
													<strong>Contact Number</strong></br>
													<input type="text" name="contact_2">
												</div>
											</div>


											<div>
												<div>
													<strong>VAT Tax Exemption</strong></br>
													Yes <input type="radio" name="vat" value="1">
													No <input type="radio" name="vat" value="0">
												</div>
												<div>
													<strong>Attach BIR Certificate/Sample Account No.</strong></br>
													<input type="file" name="file_data">
												</div>
											</div>

											<div>
												<div>
													<strong>OCT</strong></br>
													Yes <input type="radio" name="oct" value="1">
													No <input type="radio" name="oct" value="0">
												</div>
											</div>

										</div>
									</div>	  	
								</div>						

            <div class="plan-sum-btn adjuster">
				<button class="blue-btn pull-right" id="companyInfoBtn">Continue</button>
			</div>
			</form>		
		</div>

	</div>

	<div class="accordion-group account-content-grp">
	    <div class="accordion-heading">
	        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapse5">BILLING INFORMATION <i class="tcoll collapse-toggle"></i></a>
	    </div>

	    </br><p><strong>Detailed Billing Statement</strong></p></br>
	    <p>How would you like to receive the billing statement?</p>

	    <div>
			<div>
				<input type="radio" name="detailed_billing_type" value="soft"> Soft copy, email to this address
			</div>
			<div id="detailed_billing_email">
				<input type="text" name="detailed_billing_email">
			</div>
			<div>
				<input type="radio" name="detailed_billing_type" value="hard"> Hard copy, send to this preffered address
			</div>
		</div>

		<div class="clr"></div>

		</br><p><strong>Bill Summary</strong></p></br>
		<p>Would you like to receive a bill summary?</p>

		<div>
			<div>
				<div>
					Yes <input type="radio" name="bill_summary_flag" value="1">
					No <input type="radio" name="bill_summary_flag" value="0">
				</div>
			</div>

			<div>
				<div>
					<strong>First Name</strong></br>
					<input type="text" name="fname">
				</div>
				<div>
					<strong>Last Name</strong></br>
					<input type="text" name="lname">
				</div>
				<div>
					<strong>Department</strong></br>
					<input type="text" name="department">
				</div>
			</div>

			<div>
				<div>
					<strong>Address</strong></br>
					<input type="text" name="address">
				</div>
			</div>

			<div>
				<div>
					<strong>Barangay</strong></br>
					<input type="text" name="fname">
				</div>
				<div>
					<strong>Municipality / Town</strong></br>
					<input type="text" name="lname">
				</div>
			</div>

			<div>
				<div>
					<strong>City / Province</strong></br>
					<input type="text" name="fname">
				</div>
				<div>
					<strong>Postal Code / Zip Code</strong></br>
					<input type="text" name="lname">
				</div>
			</div>


			<p>How would you like to receive the billing statement?</p>

		    <div>
				<div>
					<input type="radio" name="detailed_billing_type" value="soft"> Soft copy, email to this address
				</div>
				<div id="detailed_billing_email">
					<input type="text" name="detailed_billing_email">
				</div>
				<div>
					<input type="radio" name="detailed_billing_type" value="hard"> Hard copy, send to this preffered address
				</div>

				<div>
				<div>
					<strong>First Name</strong></br>
					<input type="text" name="fname">
				</div>
				<div>
					<strong>Last Name</strong></br>
					<input type="text" name="lname">
				</div>
				<div>
					<strong>Department</strong></br>
					<input type="text" name="department">
				</div>
			</div>

			<div>
				<div>
					<strong>Address</strong></br>
					<input type="text" name="address">
				</div>
			</div>

			<div>
				<div>
					<strong>Barangay</strong></br>
					<input type="text" name="fname">
				</div>
				<div>
					<strong>Municipality / Town</strong></br>
					<input type="text" name="lname">
				</div>
			</div>

			<div>
				<div>
					<strong>City / Province</strong></br>
					<input type="text" name="fname">
				</div>
				<div>
					<strong>Postal Code / Zip Code</strong></br>
					<input type="text" name="lname">
				</div>
			</div>
			</div>


		</div>

		<p class="textcenter"><button id="btnGetNewlineSubs" class="blue-btn">Continue</button></p>

    </div>

</div>
            
