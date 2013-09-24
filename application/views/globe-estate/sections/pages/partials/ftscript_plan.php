	//ORDER TYPE
			$("#packageplantype-options").hide();
			$("#plantype-options").hide();
			//$("#package-plan-combos").hide();

		    $('#acc-order-type  button').click(function() {
	            //showPreloader();
		        //create ajax call here - add to cart order type

		        var btnIndex = $('#acc-order-type  button').index(this);

		        $(this).parent().parent().parent().children("div.header").children("div.price-wrapper").children("h4").each(function(){
		        	if($(this).text() == "GET ADDITIONAL LINE"){
				        $("#acc-order-type .option-wrapper").slideUp();

				        $("#order-type-section").show('slow');

				        $("a.btnAddPlan").parent().parent().hide();

				        $("#goCombos").parent().hide();
				        $("#goPackagePlanCombos").parent().show();

				        //$("a.btnAddPackagePlan:eq(0)").parent().parent().hide();

				        $("#cashoutBox").show();

				        $("#goPackagePlanCombos").click(function(){
				        	window.location.href = base_url+"addons"
				        })
				    }

		        });

		        //RENEW CONTRACT is selected
		        //console.log(btnIndex);
		         if( btnIndex==1 ){
				     $("#plantype-table").removeClass('[class^="totalcol"]').addClass('totalcol2');
				     $("#plan-type-1").hide();

			    }


			    if( btnIndex==0){

					$( "#plan-order-page" ).accordion( "option", "active", 1 );
					$( "#siderbar-panel" ).accordion( "option", "active", 2 );
			    }

		    });

		    //click continue button in get additional line
		    $("#additional-line-continue").click(function(){

		    	//$( '#dialog_enter_mobile' ).dialog( "close" );
		    	$.ajax({
					url: base_url+'plan/sendEmail',
					data: {'email' : "mhaark29@gmail.com" },
					type:'post',
					success: function(response){

						$( '#dialog_enter_mobile' ).dialog( "open" );
						$( "#plan-order-page" ).accordion( "option", "active", 1 );
						$( "#siderbar-panel" ).accordion( "option", "active", 2 );
					},
					error: function(){
						alert('Some error occured or the system is busy. Please try again later');
					}
				});


		    	$( "#plan-order-page" ).accordion( "option", "active", 1 );
		        $( "#siderbar-panel" ).accordion( "option", "active", 2 );
		    });

		    $("#additional-line-back").click(function(){

				$( "#order-type-section" ).slideUp();
				$("#acc-order-type .option-wrapper").slideDown();

			});

		    //PLAN TYPE
		    $( "#plantype-options" ).hide();
			$( "#plantype-combos" ).hide(); // Robert

		    $('#plantype-table  button').click(function() {


				var title = $(this).attr('rel');

				var id = $(this).attr('id'); // Robert
				if(id == 3) {// Robert
					$( "#siderbar-panel" ).accordion( "option", "active", 2 );// Robert
				}// Robert

				var btnIndex = $('#plantype-table  button').index(this);

				showPreloader();

				setTimeout(function(){ //simulate ajax request
					$( "#plantype-table" ).slideUp();

					if(btnIndex > 0){
						// Create You Own Plan
						if(btnIndex == 2){
							$( "#plantype-options h4" ).html(title);
							$( ".ui-accordion h3:eq(2) a" ).html(title);
							$( "#plantype-options" ).slideDown();
						}else if(btnIndex == 1){
							$( "#packageplantype-options h4" ).html(title);
							$( ".ui-accordion h3:eq(2) a" ).html(title);
							$( "#packageplantype-options" ).slideDown();
						}
					}else{
						$( "#retain-plan" ).slideDown();
						$( ".ui-accordion h3:eq(2) a" ).html('Retain Current Plan - 3799');
					}
					closePreloader();
				},500)

				$("#combo-type").hide();


			});

			$("#goPackagePlanCombos").click(function(){
	        	window.location.href = base_url+"addons"
	        })

		    $(this).parent().parent().parent().children("div.header").children("div.price-wrapper").children("h4").each(function(){
		        	if($(this).text() == "Package Plan"){
				        //$("#acc-order-type .option-wrapper").slideUp();

				        //$("#order-type-section").show('slow');

				        //$("#plantype-options").show();


				        //$("a.btnAddPlan").parent().parent().hide();

				        $("#goCombos").parent().hide();
				        $("#goPackagePlanCombos").parent().show();

				        //$("a.btnAddPackagePlan:eq(0)").parent().parent().hide();

				        $("#cashoutBox").show();

				        $("#packageplantype-options").show();

				        $('#plantype-table').hide()

				        $( "#siderbar-panel" ).accordion( "option", "active", 2 );

				        // showing only package plan in sidebar panel
				        $( "#siderbar-panel h3.ui-state-active" ).parent().children().not("h3").children().not("div#package-plan-items").hide()
				        $("div#package-plan-items").show();


				        $("#goPackagePlanCombos").click(function(){
				        	window.location.href = base_url+"addons"
				        })
				    }

		        });



			//toggle button
			$('.btn-show-plantype').click(function() {
				$( "#plantype-table" ).slideDown();
				$("#PackagePlanCartWidget").slideUp();
				$( this ).closest('div').slideUp();

			});
			$('.btn-show-packageplantype').click(function() {
				$( "#plantype-table" ).slideDown();
				$("#PackagePlanCartWidget").slideUp();
				$( this ).closest('div').slideUp();

			});
			$('.btn-show-plans').click(function() {
				$( "#plantype-options" ).slideDown();
				$( this ).closest('div').slideUp();

			});
			$('.btn-show-plancombos').click(function() {
				$( "#plantype-combos" ).slideDown();
				$( this ).closest('div').slideUp();

			});
			// jez
			$("a.btnAddPackagePlan").parent().parent().each(function(){

				$(this).click(function(i){
					var that = $(this);
					$.ajax({
						url: base_url+'plan/getpackageplancombos',
						data: {'plan_id' : parseInt($(this).children("div.my-plan-id").text()) },
						type:'post',
						success: function(response){

							var resp = jQuery.parseJSON( response );
							//console.log(resp)
							for(var ctr = 0; ctr < resp.length; ctr++){
								//console.log(resp[ctr]['combo_type']);
								var combo_type = resp[ctr]['category'].toLowerCase();

								$("#combo-type-" + combo_type + "-desc").text(resp[ctr]['description']);
								$("#combo-type-" + combo_type).css('display', 'block')

							}

							$("#combo-type").show();

							var plan_payment = that.find("a").text().split("Plan ")[1];

							//$("#PackagePlanCartWidget").html("<br /><p><b>Plan:</b> " + plan_payment + "</p><p><b>Monthly Payment:</b> " + plan_payment + "</p><p><b>Text:</b> " + $("#combo-type-text-desc").text() + "</p><p><b>Call:</b> " + $("#combo-type-call-desc").text() + "</p><p><b>Surf:</b> " + $("#combo-type-surf-desc").text() + "</p><p><b>IDD:</b> " + $("#combo-type-idd-desc").text() + "</p>");
							//$("#PackagePlanCartWidget").slideDown();

						},
						error: function(){
							alert('Some error occured or the system is busy. Please try again later');
						}
					});


					//add to cart functionality for additional and new line

					var itemid    = $(this).find("a").attr('data-id');
					var itemname    = $(this).find("a").attr('data-name');
					var plan_pv    = $(this).find("a").attr('data-pv');



					//alert(itemid + " " + itemname + " " + plan_pv);

					$.ajax({
						url: base_url+'cart/addtocart',
						data: 'product_type=package_plan&product_id='+itemid+'&plan='+itemid+'&device=1',
						type:'post',
						success: function(response) {
							// alert(response);
							var resp = jQuery.parseJSON(response);

							var package_plan_combos = "";
							for(var a = 0; a < resp.package_plan_combos.length; a++){
								package_plan_combos += "<span class=\"productName block\"><b>"+resp.package_plan_combos[a].category+
							": </b> " + resp.package_plan_combos[a].description  + "</span>"
							}


							var cartItem = '<div id="prod-item-'+resp.rowid+'" class="itemPlan" style="display:none">'+
							'<div class="fleft"><span class="productName block"><b>'+itemname+
							'</b></span><span class="productName block"><b>Monthly Payment: </b>'+itemname.split(" ")[1]+
							'</span>' + package_plan_combos + '</div><span class="icoDelete"> <a class="btnDelete" href="javascript:void(0)" id="'+resp.rowid+'">'+
							'<i class="icon-remove"></i></a> </span><br class="clear" /></div>\n';


							if(resp.status == 'success' && resp.rowid){
								$("#PackagePlanCartWidget .itemPlan").remove();
								$("#PackagePlanCartWidget").prepend(cartItem);
								$('#prod-item-'+resp.rowid).show('slow');


								$("#cashoutLabel").html(resp.total).show('slow');
								$("#pesovalLabel").attr('data-pv',resp.this_pv_value).html(resp.this_pv_value).show('slow');

								$('#cashoutBox,#pesovalBox').animate({backgroundColor: '#fff267'}, 'fast', function(){
									$('#cashoutBox,#pesovalBox').animate({backgroundColor: '#F4F4F4'}, 'fast');
								});
								$("#plan_name").html(itemname);
								$("#planid").attr('data-id',itemid);
								$("#planid").attr('data-cashout',resp.total);
								$('#prod-item-'+resp.rowid).show('slow');
							} else if (resp.status == 'exceeds_limit') {
								$('#dialog-exceed-limit').dialog("open");

								$('a#retain-current-plan').click(function(){
									$('#dialog-exceed-limit').dialog("close");
									$('#packageplantype-options').hide();
									$('#plantype-options').hide();
									$('#ui-accordion-plan-order-page-header-1').click();
									$('#plantype-table button#1').click();
								});

								$('a#other-plan').click(function(){
									$('#dialog-exceed-limit').dialog("close");
									$('#packageplantype-options button').click();
								});
							}

						},
						error: function(){
							alert('Some error occured or the system is busy. Please try again later');
						}
					});

					// end of add to cart functionality
				});
			});

			//jez
			if($("#order-type-new-line-section").length != 0){
				$("input[name=new-line-non-globe-option]").each(function(){
					$(this).click(function(){

						showPreloader();


							if(parseInt($(this).val()) == 1){
								$("#order-type-new-line-section-footer").slideDown();
								$( "#plan-order-page" ).accordion( "option", "active", 0 );
							}else if(parseInt($(this).val()) == 2){
								$("#order-type-new-line-section-footer").slideUp();
								$( "#plan-order-page" ).accordion( "option", "active", 1 );
							}


						closePreloader();
					});
				});


				$("#new-line-continue").click(function(){

			    	//$( '#dialog_enter_mobile' ).dialog( "close" );
			    	$.ajax({
						url: base_url+'plan/sendEmail',
						data: {'email' : "xerenader@gmail.com" },
						type:'post',
						success: function(response){

							$( '#dialog_enter_mobile' ).dialog( "open" );
							//$( "#plan-order-page" ).accordion( "option", "active", 1 );
							//$( "#siderbar-panel" ).accordion( "option", "active", 2 );
						},
						error: function(){
							alert('Some error occured or the system is busy. Please try again later');
						}
					});


			    	//$( "#plan-order-page" ).accordion( "option", "active", 1 );
			        //$( "#siderbar-panel" ).accordion( "option", "active", 2 );

			        //$("#plantype-options").show();
			        $("a.btnAddPackagePlan").parent().parent().show();
			    });

			}

			$('a#get-prepaid-kit').click(function(){
				// show bubble info where add to cart link is present
				$('#tooltip-prepaid-kit').dialog("open");
			});

			$('a#add-prepaid-to-cart').click(function(){
				$.ajax({
					url: base_url+'cart/addprepaidtocart',
					success: function(response){

						var resp = jQuery.parseJSON( response );

						if (resp.status == 'success') {
					       window.location = resp.cart_url;
						} else {
							alert(resp.msg);
						}

					},
					error: function(){
						alert('Some error occured or the system is busy. Please try again later');
					}
				});

			});
