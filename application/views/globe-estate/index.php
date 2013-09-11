<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//echo $assets_url;

?>

<?php include('sections/meta_header.php'); ?>


<body class="<?php echo $current_method ?>">
<!-- Preloader -->
<div id="preLoader" class="opacity">
    <div id="status">
		<div class="text">
			We are processing your selection, Please wait...
		</div>
	</div>
</div>

	<?php include('sections/main_nav.php'); ?>
	
	<div class="container">
		<br />

		<p id="doc"></p>
		
		<?php 
		include('sections/breadcrumbs_desktop.php'); ?>
		
		<div class="row-fluid">
			<?php 
			
			    if($current_controller != 'home' && ($current_step < 5) ){
					include('sections/sidebar_panel.php');
				}
							
				if(file_exists( dirname(__FILE__) . '/sections/pages/page_'.$page.'.php')){
					include('sections/pages/page_'.$page.'.php'); 
				}else{
					echo 'Template file not exist: <strong>'.$page.'</strong>';
				}
			
			
			?>
		</div>
        <!--#END .row -->
 
		<br />
		<br />	
	</div>
	 <!--#END .container -->
	 
	 <div class="row">
			<div class="span10 divcenter">
				<div class="span3 textleft ">
					<p style="font-size:20px">Need Help</p>
					<p>Do you want us to assist you?</p>
					<p><a href="#" style="font-size:12px;text-decoration:underline">Click here for help</a></p>
				</div>
				<div class="span3 fright">
					<div style="padding-top:35px;" class="textright">
						<a href="#" style="font-size:12px;">Contact Us</a>&nbsp;&nbsp;|&nbsp;&nbsp;
						<a href="#" style="font-size:12px;">Live Chat</a>
					</div>
				</div>
				<br class="clear" />
			</div>
			<br />
	 </div>
	 

	<?php include('sections/footer.php'); ?>

</body>
</html>
