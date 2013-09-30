
			  $('form#personal-info button').click(function() {
					if ( $("input[name='sns_id']:checked").val() == 'facebook' ) {
				      // $( '#confim_onbehalf' ).dialog( "open" );
				    }else{
						
					}
					
					window.location.href=base_url+'payment/plan_summary';
			  });







			  $("#btnSubmitPersonalInfo").click(function(){
			  		var fname = $("#fname").val();
			  		var lname = $("#lname").val();
			  		var mname = $("#mname").val();
			  		var gender = $("#gender").val();
			  		var bday = $("#bday").val();
			  		var civil_status = $("#civil_status").val();
			  		var mfname = $("#mfname").val();
			  		var mlname = $("#mlname").val();
			  		var mmname = $("#mmname").val();
			  		var citizenship = $("#citizenship").val();
			  		var government_id = $("#government_id").val();
			  		var government_id_type = $("#government_id_type").val();
			  		//var email = $("#email").val();
			  		//var phone = $("#phone").val();
			  		var network_carrier = $("#network_carrier").val();
			  		var sns_username = $("#sns_username").val();
			  		var sns_type = $("#sns_type").val();

			  		$.ajax({
						url: base_url+'subscriber/saveCompanyPersonalInfo?info_type=personal',
						data: { 
							"fname" : fname,
							"lname" : lname,
							"mname" : mname,
							"gender" : gender,
							"bday" : bday,
							"civil_status" : civil_status,
							"mfname" : mfname,
							"mlname" : mlname,
							"mmname" : mmname,
							"citizenship" : citizenship,
							"government_id" : government_id,
							"government_id_type" : government_id_type,
							"network_carrier" : network_carrier,
							"sns_username" : sns_username,
							"sns_type" : sns_type
						},
						type:'post',
						success: function(response){
							$("#billing-info-personal-btn").click();
						},
						error: function(){
							alert('Some error occured or the system is busy. Please try again later');
						}
					});

			  });
				

				$('.radio-btn input').iCheck({
					checkboxClass: 'icheckbox_flat-red',
					radioClass: 'iradio_flat-blue'
				});
	

