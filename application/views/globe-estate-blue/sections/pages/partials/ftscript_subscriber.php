
			  $('form#personal-info button').click(function() {
                          
				if ( $("input[name='sns_id']:checked").val() == 'facebook' ) {
                                        <?php if(FACEBOOK_ON == TRUE) { ?> 
                                                    <?php if($this->session->userdata('fb_success') == FALSE) { ?>
                                                    $.get(base_url+'subscriber/fb', function(data){
                                                             if(data.status == 'redirect') {
                                                                     window.location = data.url;
                                                             }

                                                             if(data.status == 'success') {
                                                                     window.location.href=base_url+'payment/plan_summary';
                                                             }
                                                    }, "json");
                                                    <?php } else {?>
                                                    window.location.href=base_url+'payment/plan_summary';
                                                    <?php } ?>
                                            <?php } else { ?>
                                                    window.location.href=base_url+'payment/plan_summary';
                                       <?php } ?>
                                
                                        
				      // $( '#confim_onbehalf' ).dialog( "open" );
				    }else{
					window.location.href=base_url+'payment/plan_summary';
					}
					
					
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
				
				
			$("#btnSubmitBillingPersonalInfo").click(function(){

				var house_no = $("#house_no").val();
				var street = $("#street").val();
				var barangay = $("#barangay").val();
				var municipality = $("#municipality").val();
				var province = $("#province").val();
				var postal_code = $("#postal_code").val();
				var mobile_number = $("#mobile_number").val();
				var landline_number = $("#landline_number").val();



				$.ajax({
					url: base_url+'subscriber/saveBillingInfo?info_type=personal',
					data: { 
						"house_no" : house_no,
						"street" : street,
						"barangay" : barangay,
						"municipality" : municipality,
						"province" : province,
						"postal_code" : postal_code,
						"mobile_number" : mobile_number,
						"landline_number" : landline_number
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

			$("#btnSubmitCompanyBillingInfo").click(function(){
				var detailed_billing_type = $("input[name=detailed_billing_type]").val();
				var detailed_billing_email = $("#detailed_billing_email").val();
				var fname = $("#fname").val();
				var lname = $("#lname").val();
				var department = $("#department").val();
				var address = $("#address").val();
				var barangay = $("#barangay").val();
				var municipality = $("#municipality").val();
				var city = $("#city").val();
				var postal = $("#postal").val();
				var bill_summary_flag = $("input[name=bill_summary_flag]").val();
				var bill_summary_type = $("input[name=bill_summary_type]").val();
				var bill_email = $("#bill_email").val();
				var bfname = $("#bfname").val();
				var blname = $("#blname").val();
				var bdepartment = $("#bdepartment").val();
				var baddress = $("#baddress").val();
				var bbarangay = $("#bbarangay").val();
				var bmunicipality = $("#bmunicipality").val();
				var bcity = $("#bcity").val();
				var bpostal = $("#bpostal").val();

				$.ajax({
					url: base_url+'subscriber/saveBillingInfo?info_type=company',
					data: { 
						"detailed_billing_type" : detailed_billing_type,
						"detailed_billing_email" : detailed_billing_email,
						"fname" : fname,
						"lname" : lname,
						"department" : department,
						"address" : address,
						"barangay" : barangay,
						"municipality" : municipality,
						"city" : city,
						"postal" : postal,
						"bill_summary_flag" : bill_summary_flag,
						"bill_summary_type" : bill_summary_type,
						"bill_email" : bill_email,
						"bfname" : bfname,
						"blname" : blname,
						"bdepartment" : bdepartment,
						"baddress" : baddress,
						"bbarangay" : bbarangay,
						"bmunicipality" : bmunicipality,
						"bcity" : bcity,
						"bpostal" : bpostal
					},
					type:'post',
					success: function(response){
						//$("#billing-info-personal-btn").click();
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
