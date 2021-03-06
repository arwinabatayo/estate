<div id="order-type-section" class="textcenter" style="display:none;">
	<div id="order-type-section-head">
		<div id="order-type-section-breadcrumbs">
			<a href="#">Renew Contract</a> | 
			<a href="#">Get Additional Line</a> |
			<a href="#">Reset</a> |
		</div>
		<h2>Get Additional Line</h2>
	</div>


	<div id="order-type-section-footer">
		<div>
			How many additional line would you like to get?
			<select id="additional-line-selection">
				<option>1</option>
				<option>2</option>
				<option>3</option>
			</select>
		</div>
		<div>
			<button id="additional-line-back" class="btn-large ui-button-success ">&laquo; Back</button>
			<button id="additional-line-continue" class="btn-large ui-button-success ">Continue</button>
			
		</div>

		<div class="globe-dialog" id="dialog_enter_mobile" title="Thank You!">
			<div class="span5 ">
				<p>An email has been successfully sent to Business/Platinum Account Manager for your applications approval. </p>
				<p>Kindly check your email for the link back to this site. Use the reference number we sent to check the status of your application.</p>
            </div>
            

        </div>

	</div>
</div>
<!-- New Line -->
<?php if($new_line_flag){ ?>
<div id="order-type-new-line-section" class="textcenter">
	<div id="order-type-section-head">
		<h2>Get a New Line</h2>
	</div>


	<div id="order-type-section-footer">
		<div>
			<p>Nullam suscipit ultrices enim.</p>
		</div>
		<br/>
		<br/>
		<br/>
		<div style="padding-bottom: 10px;">
			<input type="radio" name="new-line-non-globe-option" value="1">Business
			<input type="radio" name="new-line-non-globe-option" value="2">Personal
		</div>

		<div id="order-type-new-line-section-footer" style="display:none; padding: 87px; background-color: #515151; color: #FFF;">
			<div>
				How many additional line would you like to get?
				<select id="additional-line-selection">
					<option>1</option>
					<option>2</option>
					<option>3</option>
				</select>
			</div>
			<div>
				<button id="new-line-continue" class="btn-large ui-button-success ">Continue</button>
				
			</div>

			<div class="globe-dialog" id="dialog_enter_mobile" title="Thank You!">
				<div class="span5 ">
					<p>An email has been successfully sent to Business/Platinum Account Manager for your applications approval. </p>
					<p>Kindly check your email for the link back to this site. Use the reference number we sent to check the status of your application.</p>
	            </div>
	            

	        </div>

		</div>

	</div>
</div>
<?php } ?>
