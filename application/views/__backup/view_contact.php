<div class="cn_body">
<div class="g_inner">
	
	<div class="cn_label">Contact Us</div>
	
	<div id="map" class="cn_map"></div>
	
	<div class="cn_left">
	<div class="inner">
		
		<div class="item">
			<div class="label">Address:</div>
			<img src="<?php echo base_url(); ?>_assets/images/contact/address.png" />
			<div class="content">138 Atlantis Ln Kingsport Illinois 121164</div>
			<div class="h_clearboth"></div>
		</div>
		
		<div class="item">
			<div class="label">Phones:</div>
			<div class="h_clearboth"></div>
			
			<img src="<?php echo base_url(); ?>_assets/images/contact/phone.png" />
			<div class="content">+1 800 559 6580</div>
			<div class="h_clearboth"></div>
			
			<img src="<?php echo base_url(); ?>_assets/images/contact/fax.png" />
			<div class="content">+1 504 889 9898</div>
			<div class="h_clearboth"></div>
		</div>
		
		<div class="item">
			<div class="label">E-mail:</div>
			<img src="<?php echo base_url(); ?>_assets/images/contact/email.png" />
			<div class="content">mail@demolink.org</div>
			<div class="h_clearboth"></div>
		</div>
		
		<div class="h_clearboth"></div>
		
	</div>
	</div>
	
	<div class="cn_right">
		<div class="text">
			<div class="header">MISCELLANEOUS INFORMATION:</div>
			<div class="content">
				Thank you for your interest in Sitemee and our services. Please fill out the form below or e-mail us at info@sitemee.com and we will get back to you promptly regarding your request.
				<span>Send an email. All fields with an * are required.</span>
			</div>
		</div>
		
		<form class="cn_form" id="form_contact">
			<div class="item">
				<label>Name *</label>
				<input type="text" value="" name="from_name" data-required="1" />
			</div>
			<div class="item">
				<label>Email *</label>
				<input type="text" value="" name="from" data-required="1" data-email="1" />
			</div>
			<div class="item">
				<label>Subject *</label>
				<input type="text" value="" name="subject" data-required="1" />
			</div>
			<div class="item">
				<label>Message *</label>
				<textarea name="message" data-required="1"></textarea>
			</div>
			
			<input type="hidden" name="to" value="jeri@filamentco.com" />
			
			<div id="contact_message_error"></div>
			<div id="contact_message_success"></div>
			
			<div class="send_wrapper">
				<span>Send copy to yourself </span>
				<input type="checkbox" name="copy" checked="checked" />
				<a href="javascript:void(0);" class="btn_send">Send Email</a>
				<div class="h_clearboth"></div>
			</div>
		</form>
	</div>
	
	<div class="h_clearboth"></div>
	
</div>
</div>

<script type="text/javascript" language="javascript">
var map;
function initialize() {
	var mapOptions = {
		zoom: 15,
		scrollwheel: false,
		center: new google.maps.LatLng(14.558403, 121.019166),
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	
	map = new google.maps.Map(document.getElementById('map'), mapOptions);
	var latlng = new google.maps.LatLng(14.558403, 121.019166);
	
	var myMarker = new google.maps.Marker({
		position: latlng,
		map: map,
		title:"Sitemee Headquarters"
	});
}

google.maps.event.addDomListener(window, 'load', initialize);

$(".btn_send").click(function(e){
	e.stopPropagation();
	$("#contact_message_success").html('Validating...');

	if (validate_form("form_contact")) {
		$.ajax({
			url: "<?php echo base_url(); ?>services/email",
			type: "POST",
			data: $("#form_contact").serialize(),
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#contact_message_error").html('');
					$("#contact_message_success").html('Email successfully sent to info@sitemee.com');
					$("#form_contact input[type=text], #form_contact textarea").val("");
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				$("#contact_message_success").html('');
				$("#contact_message_error").html('Oops, something went wrong. Your action may or may not have been completed.');
			}
		});
	} 
	else 
	{
		$("#contact_message_success").html('');
	}
});
</script>