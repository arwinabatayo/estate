    
    <!-- Exceed Limit -->
    <div id="exceed-limit" class="modal fade pop-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" style="display:none">
	<button type="button" class="close pop-close" data-dismiss="modal" aria-hidden="true">×</button>  	
		<div class="modal-body pop-content">
			<div class="o-i-icon"><img src="<?php echo $assets_path ?>site-blue/images/pop-modifyplan.png" width="150" height="150" alt="Exceed Limit"/></div>
			
			<p class="pop-txtblue-large">Exceed Limit</p>
			
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
			
			<a href="<?php echo base_url() ?>plan?setOrderConfig=true&plantype=package" class="blue-btn pull-left">Modify Your Plan</a>
			<!--<a class="blue-btn pull-right" data-toggle="modal" data-target="#modifyPlan2" data-dismiss="modal">Upload Financial Document</a>-->
			<a class="blue-btn pull-right" id="showUploadForm">Upload Financial Document</a>
			
			<div class="clr"></div>
		</div>
	</div> 


    <!-- Upload Financial Document -->
    <div id="modifyPlan2" class="modal fade pop-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" style="display:none">
      <button type="button" class="close pop-close" data-dismiss="modal" aria-hidden="true">×</button>  	
      <div class="pop-content">
      	<img src="<?php echo $assets_path ?>site-blue/images/pop-modifyplan.png" />
        <br/><br/>
        <span class="pop-txtblue-large">Upload Financial Document</span>
		<div class="modifyPlan-txt">
        	<span>Proof of financial capacity</span>
            <p class="form">
                <input type="text" id="path" />
                <label class="blue-btn add-photo-btn">Browse<span><input type="file" id="myfile" name="myfile" /></span>
            </label>
            </p>
        </div>
        <p>(Two-months credit card statement , ITR with BIR or Bank received stamp-Form 1700, W-2 or Form 2316, Certificate of Employment  and Compensation , One month  computerized payslip, Two months bank statement of account or passbook, three months certificate  of allotment plus employment contract)</p>
		<p id="uploading"></p>
        <p><button class="blue-btn" id="financialUpload">Upload</button></p>
        
      </div>
    </div> 
