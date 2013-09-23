
    
    <?php 
   
	if($page== 'landing'){ 
		
		@include('pages/page_landing.php'); 
	
	}else{ ?>
    
    <div class="row-fluid content flow">
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
				
		    if($current_controller != 'home' && ($current_step < 5) ){
				//include('sections/sidebar_panel.php');
			}
						
			if(file_exists( dirname(__FILE__) . '/pages/page_'.$page.'.php')){
				include('pages/page_'.$page.'.php'); 
			}else{
				echo 'Template file not exist: <strong>'.$page.'</strong>';
			}
					
			?>
			
            <div class="row-fluid link-bottom">
                <a class="pull-left">Go to Homepage</a>
                <ul class="pull-right">
                    <li><a>Contact Us</a></li>
                    <li>|</li>
                    <li><a>Live Chat</a></li>
                </ul>
            </div>  
		</div>
	</div>

	<?php } ?>