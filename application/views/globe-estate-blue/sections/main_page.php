
    
    <?php 
   
	if($page== 'landing'){ 
		
		@include('pages/page_landing.php'); 
	
	}else{ 
		
		
		
	
	?>
    
   <div class="row-fluid content flow" >
        <div class="container">
		<?php
		
			global $breadcrumbs_model; // to do - move this to model

			$breadcrumbs_model = array(
				1 => array('name'=>'<span class="txt">ADD A<br/>DEVICE</span>','link'=>''),
				2 => array('name'=>'<span class="txt">CHOOSE YOUR<br/>PLAN</span>','link'=>'plan'),
				3 => array('name'=>'<span class="txt">ADD-ONS /<br/>ACCESSORIES</span>','link'=>'addons'),
				4 => array('name'=>'<span class="txt">SUBSCRIBER’S<br/>INFO</span>','link'=>'subscriber-info'),
				5 => array('name'=>'<span class="txt">YOUR<br/>PAYMENT</span>','link'=>'payment'),
			);

			
			include('breadcrumbs_desktop.php'); 
				
						
			if(file_exists( dirname(__FILE__) . '/pages/page_'.$page.'.php')){

				include('pages/page_'.$page.'.php'); 
			}else{
				echo 'Template file not exist: <strong>'.$page.'</strong>';
			}
					
			?>
			
            <!--<div class="row-fluid link-bottom">
                <a class="pull-left" href="<?php echo base_url() ?>">Go to Homepage</a>
            </div>-->
			<div class="row-fluild link-bottom">
				<div class="pull-left need-help">
					<span>Need Assistance?</span><br />
					<small>Get in touch with us on<br /> Twitter at <a href="http://twitter.com/talk2globe" target="_blank">@talk2GLOBE</a></small><br /><br />
				</div>
				
				<ul class="pull-right">
					<li><a>Contact Us</a></li>
					<li>|</li>
					<li><a>Live Chat</a></li>
				</ul>	
			</div>
			
			<div class="clr"></div>
		</div>
	</div>

	<?php } ?>
