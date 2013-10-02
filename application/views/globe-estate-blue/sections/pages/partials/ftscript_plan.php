			$(function () {
				Grid.init();
				
				$(".jq-accordion").accordion({
					header: "h3",
					navigation: true, 
					heightStyle: "content",
					//event: false,
					icons: { header: "ui-icon-circle-plus", activeHeader: "ui-icon-circle-minus"}, 
				});
				$("#og-grid li div.plan-tile-option3").click(function() {
					$(this).addClass('selected-plan-tile current');
					$('.plan-tile-option3').not(this).removeClass('selected-plan-tile');
					$('.icon-peso-selected').addClass('icon-peso').removeClass('icon-peso-selected');
					$('.icon-coins-selected').addClass('icon-coins').removeClass('icon-coins-selected');
					$('.icon-peso', this).removeClass('icon-peso').addClass('icon-peso-selected');
					$('.icon-coins', this).removeClass('icon-coins').addClass('icon-coins-selected');
					//$('.arrow-point-up').not(this).hide();
					//$('.arrow-point-up', this).show();
					
				});

			});

			$('button#btnGetNewline').click(function() {

			    	$.ajax({
						url: base_url+'plan/send_newline_request',
						data: 'task=send_newline_request',
						type:'post',
						success: function(response){
								$('#order-thankyou').modal('show');
						}, 
						error: function(){
							alert('Email is not sent. System error');	
						}
					});
				
			});
			
			$('button#btnGetNewlineSubs').click(function() {
					//TODO - call ajax here to send email to OM
					//$('#order-thankyou').modal('show');
				var industry_id = ($("#s-industry").val() != 0) ? $("#s-industry").val() : $("#e-industry").val();
				var number_line = $("#number_line").val();
				//alert(base_url+'order/save_order');
		    	$.ajax({
					url: base_url+'order/save_order',
					data: {
						'order_number' 				: "",
						'account_id' 				: "",
						'status' 					: 2,
						'status_comments' 			: "",
						'shipping_address_id' 		: "",
						'billing_address_id' 		: "",
						'shipping_fee' 				: "",
						'tax' 						: "",
						'total' 					: "",
						'subtotal' 					: "",
						'peso_value' 				: "",
						'order_type' 				: 4,
						'peso_value' 				: "",
						'industry_id' 				: industry_id,
						'total_line' 				: number_line,
						'lock_in_period' 			: "",
						'payment_info' 				: "",
						'tracking_id' 				: "",
						'delivery_type' 			: ""
					},
					type:'post',
					success: function(response){

						window.location = "subscriber/companyPersonalInfo";

					}, 
					error: function(){
						alert('Some error occured or the system is busy. Please try again later');	
					}
				});


			});
			
			//ORDER TYPE
		    $('#acc-order-type  button').click(function() { 
	            //showPreloader();
		        //create ajax call here - add to cart order type
	        
		        var btnIndex = $('#acc-order-type  button').index(this);

		        $(this).parent().parent().parent().children("div.header").children("div.price-wrapper").children("h4").each(function(){
		        	if($(this).text() == "GET ADDITIONAL LINE"){
				        $("#acc-order-type .option-wrapper").slideUp();

				        $("#order-type-section").show('slow');

				        //$("#plantype-options").show();


				        $("a.btnAddPlan").parent().parent().hide();

				        $("#goCombos").parent().hide();
				        $("#goPackagePlanCombos").parent().show();

				        $("a.btnAddPackagePlan:eq(0)").parent().parent().hide();

				        $("#cashoutBox").show();


				        $("#goPackagePlanCombos").click(function(){
				        	window.location.href = base_url+"addons"
				        })
				    }

		        });
		        
		        //RENEW CONTRACT is selected
		        if( btnIndex==0 ){
					$("#plantype-table").removeClass('[class^="totalcol"]').addClass('totalcol2');
					$("#plan-type-1").hide();

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
						$( "#plantype-options h4" ).html(title);
						$( ".ui-accordion h3:eq(2) a" ).html(title);
						$( "#plantype-options" ).slideDown();
					}else{
						$( "#retain-plan" ).slideDown();
						$( ".ui-accordion h3:eq(2) a" ).html('Retain Current Plan - 3799');
					}
					closePreloader();
				},500)
				
				$("#combo-type").hide();


				$(this).parent().parent().parent().children("div.header").children("div.price-wrapper").children("h4").each(function(){
		        	if($(this).text() == "Package Plan"){
				        //$("#acc-order-type .option-wrapper").slideUp();

				        //$("#order-type-section").show('slow');

				        //$("#plantype-options").show();


				        $("a.btnAddPlan").parent().parent().hide();

				        $("#goCombos").parent().hide();
				        $("#goPackagePlanCombos").parent().show();

				        $("a.btnAddPackagePlan:eq(0)").parent().parent().hide();

				        $("#cashoutBox").show();

				        $( "#siderbar-panel" ).accordion( "option", "active", 2 );

				        // showing only package plan in sidebar panel
				        $( "#siderbar-panel h3.ui-state-active" ).parent().children().not("h3").children().not("div#package-plan-items").hide()
				        $("div#package-plan-items").show();


				        $("#goPackagePlanCombos").click(function(){
				        	window.location.href = base_url+"addons"
				        })
				    }

		        });


			});
			//toggle button
			$('.btn-show-plantype').click(function() {
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
			
				$("a.btnAddPackagePlan").click(function(i){
					var that = $(this);

					$.ajax({
						url: base_url+'plan/getpackageplancombos',
						data: {'plan_id' : parseInt($(this).children("div").eq(0).text()) },
						type:'post',
						success: function(response){

							var resp = jQuery.parseJSON( response );
							//console.log(resp)
							for(var ctr = 0; ctr < resp.length; ctr++){
								//console.log(resp[ctr]['combo_type']);
								var combo_type = resp[ctr]['category'].toLowerCase();

								$(".combo-type-" + combo_type + "-desc").text(resp[ctr]['description']);
								$(".combo-type-" + combo_type).css('display', 'block')

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


					$.ajax({
						url: base_url + 'plan/getpackageplangadgetcashout',
						data: {'plan_id' : parseInt($(this).children("div").eq(0).text()), 'gadget_id' : 7},
						type: 'post',
						success: function(response){
							var resp = jQuery.parseJSON( response );

							console.log(resp);

							$(".dispalyTable ").eq(2).children("div").eq(1).text("CASHOUT " + resp[0].cashout_val)
						},
						error: function(){
							alert('Some error occured or the system is busy. Please try again later');
						}

					});


					//add to cart functionality for additional and new line

					var itemid    = $(this).attr('data-id');
					//var itemname    = $(this).find("a").attr('data-name');
					var plan_pv    = $(this).attr('data-pv');
					
					//alert(itemid + " " + itemname + " " + plan_pv);
					
					$.ajax({
						url: base_url+'cart/addtocart',
						data: 'product_type=package_plan&product_id='+itemid+'&plan='+itemid+'&device=7',
						type:'post',
						success: function(response) {
							var resp = jQuery.parseJSON(response);

							console.log(resp);

							var cartItem = '<div data-prod-type="plan" id="prod-item-'+resp.rowid+'" class="item" style="display:none" data-cashout="'+resp.price+'" data-pv="'+resp.this_pv_value+'">'+
										'<div class="fleft">'+
											'<span class="productName block">'+itemname+'</span>'+
										'</div>'+
										'<span class="icoDelete">'+
											'<a class="btnDelete" href="javascript:void(0)" id="'+resp.rowid+'">'+
												'<i class="icon-remove">&nbsp;X&nbsp;</i>'+
											'</a>'+
										'</span>'+
										'<br class="clear" />'+
									'</div>\n';
						
							if(resp.status == 'success' && resp.rowid) {
								$("#PlanCartWidget .item").remove();
								$("#PlanCartWidget").prepend(cartItem);
								$('#prod-item-'+resp.rowid).show();

								$("#plan_name").html(itemname);
								$("#planid").attr('data-id',itemid);
								$("#planid").attr('data-cashout',resp.total);
								$('#prod-item-'+resp.rowid).show();
								
								$('#prod-item-'+resp.rowid).animate({backgroundColor: '#fff267'}, 'fast', function(){
									$('#prod-item-'+resp.rowid).animate({backgroundColor: 'transparent'}, 'fast');
								});
								
								$('#pesovalueLabel').html(resp.total_remaining_pv);
								$('#cashoutLabel').html(resp.total);
								$('#cashoutBox').animate({backgroundColor: '#fff267'}, 'fast', function(){
									$('#cashoutBox').animate({backgroundColor: '#F4F4F4'}, 'fast');
								});
							}
							
							
						}, 
						error: function(){
							alert('Some error occured or the system is busy. Please try again later');	
						}
					});

					// end of add to cart functionality
				});


			//jez
				$("input[name=new-line-non-globe-option]").each(function(){
					$(this).click(function(){

						$("#industry-section-text").text("").css("display", "none");

						if(parseInt($(this).val()) == 1){
							//$("#order-type-new-line-section-footer").slideDown();
							//$( "#plan-order-page" ).accordion( "option", "active", 0 );
							$("#btnSmallIndustry").show();
							$("#btnEnterpriseIndustry").show();
							$("#industry-section").slideDown();
							document.getElementById("s-industry").selectedIndex = 0;
							document.getElementById("e-industry").selectedIndex = 0;
						}else if(parseInt($(this).val()) == 2){

							$("#select-plan-order-type").click();

							$("#order-type-new-line-section-footer").slideUp();
							//$( "#plan-order-page" ).accordion( "option", "active", 1 );
							$("#industry-section").slideUp();
						}

					});
				});

				$("#btnSmallIndustry").click(function(){
					$("#s-industry").show();
					$("#e-industry").hide();
				});

				$("#btnEnterpriseIndustry").click(function(){
					$("#s-industry").hide();
					$("#e-industry").show();
				});

				$("#s-industry").change(function(){
					var txt = $("#btnSmallIndustry").text();
					var stxt = $("#s-industry option:selected").text();
					$("#industry-section-text").text(txt + " - " + stxt).css("display", "block");
					$("#order-type-new-line-section-footer").slideDown();
					$(this).hide();
					$("#btnSmallIndustry").hide();
					$("#btnEnterpriseIndustry").hide();
				});

				$("#e-industry").change(function(){
					var txt = $("#btnEnterpriseIndustry").text();
					var stxt = $("#e-industry option:selected").text();
					$("#industry-section-text").text(txt + " - " + stxt).css("display", "block");
					$("#order-type-new-line-section-footer").slideDown();
					$(this).hide();
					$("#btnSmallIndustry").hide();
					$("#btnEnterpriseIndustry").hide();
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

			$("#get-prepaid").popover({
				trigger: 'manual',
				html:true,
				content: function(){
					alert();
					return $('#get-prepaid-content').html();
				}
			}).click(function (e) {$(this).popover('toggle');});

			$('a#get-prepaid-kit').click(function(){
				// show bubble info where add to cart link is present
				$('#tooltip-prepaid-kit').dialog("open");
			});
			

			$('button#retain').click(function(){
				var subs_flag = $("#subs_flag").val();
				window.location = base_url+'addons'+subs_flag;

			});

			$('button#retain, button#package').click(function(){
				var subs_flag = $("#subs_flag").val();
				window.location = base_url+'addons'+subs_flag;
			});

			$(document).on('click', '.cartWidget a.btnDelete', function(){
				var rowid = $(this).attr('id');
				var prodName = $(this).attr('rel');

				if( !confirm('Are you sure you want to delete "'+prodName+'"?')) return;

				$.ajax({
					url: base_url+'cart/delete',
					data: 'keyid='+rowid+'&type',
					type:'post',
					success: function(response){

						var resp = jQuery.parseJSON( response );

						if(resp.status == 'success'){
							$('#prod-item-'+rowid).slideUp('slow', function(){ $(this).remove() });
							$('#cashoutLabel').html(resp.total);
						}else{
							alert(resp.msg);
						}
					},
					error: function(){
						alert('Some error occured or the system is busy. Please try again later');
					}
				});

		});



