		<?php
			global $breadcrumbs_model; // to do - move this to model

			$breadcrumbs_model = array(
				1 => array('name'=>'ADD DEVICE','link'=>''),
				2 => array('name'=>'CHOOSE YOUR PLAN','link'=>'plan'),
				3 => array('name'=>'ADD-ONS','link'=>'addons'),
				4 => array('name'=>'SUBSCRIBERS INFO','link'=>'subscriber-info'),
				5 => array('name'=>'PAYMENT','link'=>'payment'),
			);

		?>

	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">

				<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>

				<a class="brand" href="<?php echo base_url(); ?>">Globe Estate</a>

				<div class="nav-collapse">

					<form action="#" class="navbar-search pull-right" method="post" accept-charset="utf-8">						<input type="text" name="term" class="search-query span2" placeholder="Search"/>
					</form>
					<ul class="nav pull-right">
						<li><a href="#">Products</a></li>
						<li><a href="#">Shop</a></li>
						<li><a href="#">Broadband</a></li>
						<li><a href="#">Business</a></li>
						<li><a href="#">Help &amp; Support</a></li>
						<!--<li><a href="http://localhost/iserver/projects/nhaus/globe-estate/secure/login">Login</a></li>
						<li><a href="http://localhost/iserver/projects/nhaus/globe-estate/cart/view_cart">Your cart is empty </a></li>-->
					</ul>
					<br />
					<div id="mobile-breadcrumbs">
						<ul class="nav pull-right">
						<?php for ($x=1; $x <= count($breadcrumbs_model); $x++){
							  $cls  = ($x <= $current_step) ? 'current' : '';
							  $href = ($x <= $current_step) ? base_url(). $breadcrumbs_model[$x]['link'] : 'javascript:void(0)';
							  $bullet = ($x <= $current_step) ? '<i class="icon-check icon-white"></i>' : $x.'.';
							?>
							<li><a id="bc_subnav_step<?php echo $x ?>" href="<?php echo $href ?>" class="<?php echo $cls ?>"><?php echo $bullet ?> <?php echo ucwords( $breadcrumbs_model[$x]['name'] ) ?></a>

						<?php } ?>
                       </ul>
					</div>

				</div>
			</div>
		</div>
	</div>


	<div class="row-fluid">
		<br />
		<div class="span7 divcenter sub-menu">
			<ul class="nav pull-right">
				<li class="consultation"><a href="javascript: void(0);">Plan Consultation</a></li>
				<li class="calculator"><a href="javascript: void(0);">Reset Calculator</a></li>
				<li class="info" style="margin-right:0"><a id="open_application_status" href="javascript: void(0);">Status</a></li>
			</ul>
		</div>
	</div>

	<?php // application status - gellie?>

	<div class="globe-dialog" id="dialog_application_status" title="My Application">
		<div class="span4 textleft noLeftMargin">
			<p><i class="icon-lock icon-3x fleft"></i>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.<br /> 					<span class="span4 textright">

			</p>
            <p><a id="open_resume_uncomp_transaction" href="javascript: void(0);">Resume Uncompleted Transaction</a></p>
        </div>
		<div class="span4">
        	<form id="refnum-verification" class="form-inline" onsubmit="return false">
				<fieldset>
				<div class="control-group ">
				<label class="control-label">Reference Number</label>
					<div class="controls">
						<input type="text" id="reference_number" name="reference_number" class="-medium">
						<button class="btn btn-primary">Submit</button>
					</div>
				</div>
				<div style="display:none" class="status alert textcenter"></div>
				</fieldset>
			</form>
            <p><a href="javascript: void(0);" id="lnk_forgot_refnum">Forgot Reference Number?</a></p>
        </div>
	</div>

	<div class="globe-dialog" id="dialog_resume_uncomp_transaction" title="Resume Uncompleted Transaction">
		<div class="span4 textleft noLeftMargin">
			<p><i class="icon-envelope icon-3x fleft"></i>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.<br />
			 	<span class="span4 textright">
			</p>
        </div>
		<div class="span4">
        	<form id="resume-uncomp-transaction" class="form-inline" onsubmit="return false">
				<fieldset>
				<div class="control-group ">
				<label class="control-label">Email</label>
					<div class="controls">
						<input type="text" id="email" name="email" class="-medium">
					</div>
				<label class="control-label">Enter characters you see</label>
				<p><img src="<?php echo base_url() ?>_assets/estate/_captcha/default.png" alt="" id="ut_captcha" class="captcha" />&nbsp; <a href="javascript:void(0)" id="refresh_code" style="font-size:11px;">Refresh Captcha</a></p>
					<div class="controls">
						<input class="fleft" id="code_id" name="code_id" type="text" autocomplete="false" />&nbsp;<!-- <button id="btn_resend_vcode" class="btn btn-primary">RESET</button> -->
						<button class="btn btn-primary">Submit</button>
					</div>
				</div>
				<div style="display:none" class="status alert textcenter"></div>
				</fieldset>
			</form>
        </div>
	</div>

	<div class="globe-dialog" id="dialog_saved_transaction_success" title="Thank You">
		<p id="msg-success"></p>
		<span id="ty-note" class="span4 textleft noLeftMargin" style="display: none; color:#888">
			<p class="note">NOTE: Kindly make sure to verify your email address. Validity of this link is within 24hours.</p>
		</span>
		<span id="resend-link-info" class="span4 textright" style="display: none;">
			<strong>Didn't receive the verification email?</strong> &nbsp;&nbsp;
			<a href="javascript: void(0);" id="resend_saved_transaction_lnk">Resend link</a>
		</span>
    </div>

    <div class="globe-dialog" id="dialog_forgot_refnum" title="Forgot reference number">
		<div class="span4 textleft noLeftMargin">
			<p><i class="icon-envelope icon-3x fleft"></i>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.<br />
			 	<span class="span4 textright">
			</p>
        </div>
		<div class="span4">
        	<form id="forgot-refnum" class="form-inline" onsubmit="return false">
				<fieldset>
				<div class="control-group ">
				<label class="control-label">Email</label>
					<div class="controls">
						<input type="text" id="email" name="email" class="-medium">
					</div>
				<label class="control-label">Enter characters you see</label>
				<p><img src="<?php echo base_url() ?>_assets/estate/_captcha/default.png" alt="" id="fr_captcha" class="captcha"/>&nbsp; <a href="javascript:void(0)" id="refresh_code" style="font-size:11px;">Refresh Captcha</a></p>
					<div class="controls">
						<input class="fleft" id="code_id" name="code_id" type="text" autocomplete="false" />&nbsp;<!-- <button id="btn_resend_vcode" class="btn btn-primary">RESET</button> -->
						<button class="btn btn-primary">Submit</button>
					</div>
				</div>
				<div style="display:none" class="status alert textcenter"></div>
				</fieldset>
			</form>
        </div>
	</div>
