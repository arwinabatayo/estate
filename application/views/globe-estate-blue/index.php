<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('ESTATE_THEME_BASEPATH', dirname(__FILE__));


if(isset($_GET['setOrderConfig'])){
	//ordertype
	$key = $this->input->get('key', TRUE);
	$val = $this->input->get('val', TRUE);
	
	$this->cart_model->set_order_config(array($key=>$val));
}

?>
 
<?php include('sections/meta_header.php'); ?>
 

<body class="<?php echo $current_method ?>">
<!-- Preloader -->
<div id="preLoader" class="opacity"><div id="status"><div class="text">We are processing your selection, Please wait...</div></div></div>

	
	<?php include('sections/main_nav.php'); ?>
	

	<?php include('sections/main_page.php'); ?>
	

	<?php include('sections/footer.php'); ?>

</body>
</html>
