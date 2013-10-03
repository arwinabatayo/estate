								 <!-- Lawrence 10-02-2013 -->
								<?php if($biz_line_flag){ ?>
                                  
                                <div class="order-type">
                                    <h2 class="fleft"><img src="<?php echo $assets_path ?>site-blue/images/icons/icon_phone.jpg" width="42" height="42" alt=""/>Get Additional Lines</h2>
                                    
                                    
                                    <div class="clr"></div>
                                    
                                    <p class="ot-description">Vivamus a justo hendreit, vivera nibh eget, scelerisque est</p><br />
                                    
                                    
                                    <div class="yellow-box">
                                        <p class="fleft ot-description">New line type</p>
                                        
                                        <p class="textcenter">
                                            <input type="radio" name="new-line-biz-globe-option" value="1">Business
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="radio" name="new-line-biz-globe-option" value="2">Personal
                                        </p>
                                        
                                        <div class="clr"></div>
                                        <br /><br /><br />
                                        <div id="order-type-biznew-line-section-footer" style="display:none;">										
                                            <p class="fleft ot-description">How many additional line would  you like to get?</p>
                                            <select id="id_select" class="selectpicker fright" style="width:92px">
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                                <option>6</option>
                                                <option>7</option>
                                                <option>8</option>
                                                <option>9</option>
                                                <option>10</option>
                                            </select>
                                            <p class="textcenter"><button id="btnBizGetNewlineSubs" class="blue-btn">Continue</button></p>
                                        </div>
                                        
                                        <div id="order-type-biznew-line-section-button" style="display:none;">
                                          <p class="textcenter"><button id="btnBizGetNewline" class="blue-btn">Continue</button></p>
                                        </div>
                                        <br />
                                        
                                        
                        
                                    </div>
                                </div>
                                <!-- End Update By Lawrence -->
								<?php } elseif(!isset($_GET['subscriber_flag'])){ ?>
								<div class="order-type">
									<h2 class="fleft"><img src="<?php echo $assets_path ?>site-blue/images/icons/icon_phone.jpg" width="42" height="42" alt=""/>Get Additional Line</h2>
									
									<div class="ot-toplinks fright">
										<a href="<?php echo base_url() ?>plan?setOrderConfig=true&ordertype=renew">Renew Contract</a>
										<a href="<?php echo base_url() ?>plan?setOrderConfig=true&ordertype=reset">Reset</a>
									</div>
									
									<div class="clr"></div>
									
									<p class="ot-description">APPLY FOR AN ADDITIONAL LINE Please complete the following forms to apply for a new line.</p><br />
									
									<div class="yellow-box">
										
										<p class="fleft ot-description">How many additional line would  you like to get?</p>
										
										<select id="id_select" class="selectpicker fright" style="width:92px">
											<option>1</option>
											<option>2</option>
											<option>3</option>
											<option>4</option>
											<option>5</option>
											<option>6</option>
											<option>7</option>
											<option>8</option>
											<option>9</option>
											<option>10</option>
										</select>
										
										
										<div class="clr"></div>
										<br />	
										
										<p class="textcenter"><button id="btnGetNewline" class="blue-btn">Continue</button></p>

									</div>
								</div>
								
								<?php }else{ ?>
								<div class="order-type">
									<h2 class="fleft"><img src="<?php echo $assets_path ?>site-blue/images/icons/icon_phone.jpg" width="42" height="42" alt=""/>Get New Line</h2>
									
									
									<div class="clr"></div>
									
									<p class="ot-description">Vivamus a justo hendreit, vivera nibh eget, scelerisque est</p><br />
									
									
									<div class="yellow-box">
										<p class="fleft ot-description">New line type</p>
										
										<p class="textcenter">
											<input type="radio" name="new-line-non-globe-option" value="1">Business
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="radio" name="new-line-non-globe-option" value="2">Personal
										</p>
										
										<div class="clr"></div>
										<br /><br /><br />
										<div id="industry-section" style="display:none;">
											<p class="textcenter">
												<button id="btnSmallIndustry" class="blue-btn blue-btn-flat">Small / Medium Industry</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												<button id="btnEnterpriseIndustry" class="blue-btn blue-btn-flat">Enterprise Industry</button>
											</p>
											<p class="textcenter">
												<select id="s-industry" style="display:none;">
													<option value="0">Select type of industry</option>
													<?php for($ctrS = 0 ; $ctrS < count($s_industry); $ctrS++){ ?>
														<option value="<?php echo $s_industry[$ctrS]['industry_id']; ?>"><?php echo $s_industry[$ctrS]['industry_name']; ?></option>
													<?php } ?>
												</select>
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												<select id="e-industry" style="display:none;">
													<option value="0">Select type of industry</option>
													<?php for($ctrE = 0 ; $ctrE < count($e_industry); $ctrE++){ ?>
														<option value="<?php echo $e_industry[$ctrE]['industry_id']; ?>"><?php echo $e_industry[$ctrE]['industry_name']; ?></option>
													<?php } ?>
												</select>
											</p>
										</div>

										<div class="clr"></div>

										<div id="industry-section-text" style="display:none;"></div>

										<div class="clr"></div>

										<div id="order-type-new-line-section-footer" style="display:none;">										
											<p class="fleft ot-description">How many additional line would  you like to get?</p>
											<select id="number_line" class="selectpicker fright" style="width:92px">
												<option>1</option>
												<option>2</option>
												<option>3</option>
												<option>4</option>
												<option>5</option>
												<option>6</option>
												<option>7</option>
												<option>8</option>
												<option>9</option>
												<option>10</option>
											</select>
											<p class="textcenter"><button id="btnGetNewlineSubs" class="blue-btn">Continue</button></p>
										</div>
										<br />
										
										

									</div>
								</div>
								<?php } ?>
