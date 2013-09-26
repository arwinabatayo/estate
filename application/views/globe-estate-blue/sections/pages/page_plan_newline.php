								<?php if(!isset($_GET['subscriber_flag'])){ ?>
								<div class="order-type">
									<h2 class="fleft"><img src="<?php echo $assets_path ?>site-blue/images/icons/icon_phone.jpg" width="42" height="42" alt=""/>Get Additional Line</h2>
									
									<div class="ot-toplinks fright">
										<a href="<?php echo base_url() ?>plan?setOrderConfig=true&key=ordertype&val=renew">Renew Contract</a>
										<a href="<?php echo base_url() ?>plan?setOrderConfig=true&key=ordertype&val=reset">Reset</a>
									</div>
									
									<div class="clr"></div>
									
									<p class="ot-description">Vivamus a justo hendreit, vivera nibh eget, scelerisque est</p><br />
									
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
										<div id="order-type-new-line-section-footer" style="display:none;">										
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
												<option>>10</option>
											</select>
											<p class="textcenter"><button id="btnGetNewlineSubs" class="blue-btn">Continue</button></p>
										</div>
										<br />
										
										

									</div>
								</div>
								<?php } ?>
