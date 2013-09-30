		
		
		// delete/deduct combo qty -- robert
		$(document).on('click', '.cartWidget a.btnDeleteCombos, .cartWidget a.btnDeleteBoosters', function(){
				var rowid = $(this).attr('id');
				var prodName = $(this).attr('rel');
				
				var selectedPlanCashOut = $(".btnAddCombo").attr("data-cashout");
				var comboID = $(this).attr("data-id");
				var comboNAME = $(this).attr("data-name");
				var comboPV = $(this).attr("data-pv");
				var planPV = $(this).attr("data-planpv");
				var amount = $(this).attr("data-amount");
				var product_type = $(this).attr("data-product-type");
				
				if( !confirm('Are you sure you want to delete "'+prodName+'"?')) return;
				
				$.ajax({
					url: base_url+'cart/update_qty_of_cart',
					data: 'keyid='+rowid+'&product_type='+product_type+'&product_id='+comboID+'&current_cashout='+selectedPlanCashOut+'&planpv='+planPV+'&combopv='+comboPV,
					type:'post',
					success: function(response){
						var resp = jQuery.parseJSON( response );
						if(product_type == "boosters") {
							if(resp.qty <= 0) {
								$('#prod-item-'+rowid).slideUp('slow', function(){ $(this).remove() });
								$('#prod-item-'+rowid).remove();
								
							}
						} else {
							if(resp.combos_qty <= 0) {
								$('#prod-item-'+rowid).slideUp('slow', function(){ $(this).remove() });
								$('#prod-item-'+rowid).remove();
								
							} else {
								$('#prod-qty-'+resp.rowid).html("<b>x"+resp.combos_qty+"</b>");
								$('#prod-item-'+resp.rowid).show('slow');
							}
						}

						$("#cashoutLabel").html(resp.total).show('slow');
						$("#pesovalLabel").attr('data-pv',resp.total_remaining_pv).html(resp.total_remaining_pv).show('slow');
						
						$('#cashoutBox,#pesovalBox').animate({backgroundColor: '#fff267'}, 'fast', function(){
							$('#cashoutBox,#pesovalBox').animate({backgroundColor: '#F4F4F4'}, 'fast');
						});
					}, 
					error: function(){
						alert('Some error occured or the system is busy. Please try again later');	
					}
				});
		});

		// add plan --robert
		$('a.btnAddPlan').click(function(e){
			e.preventDefault();
			
			var itemid    = $(this).attr('data-id');
			var itemname    = $(this).attr('data-name');
			var plan_pv    = $(this).attr('data-pv');
			
			
			$.ajax({
				url: base_url+'cart/addtocart',
				data: 'product_type=plan&product_id='+itemid+'&plan='+itemid+'&device=7',
				type:'post',
				success: function(response) {
					//alert(response);
					var resp = jQuery.parseJSON(response);


					var cartItem = '<div id="prod-item-'+resp.rowid+'" class="itemPlan" style="display:none">'+
					'<div class="fleft"><span class="productName block"><b>'+itemname+
					'</b></span></div><span class="icoDelete"> <a class="btnDelete" href="javascript:void(0)" id="'+resp.rowid+'">'+
					'<i class="icon-remove"></i></a> </span><br class="clear" /></div>\n';
				
					if(resp.status == 'success' && resp.rowid){
						$("#PlanCartWidget .itemPlan").remove();
						$("#PlanCartWidget").prepend(cartItem);
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
					}
					
					
				}, 
				error: function(){
					alert('Some error occured or the system is busy. Please try again later');	
				}
			});
		});

		// go next for combos --robert
		$("#goCombos").click(function(e) {
			e.preventDefault();
			//var selectedPlanId = $(".btnAddCombo").attr("data-id");
			var selectedPlanCashOut = $(".btnAddCombo").attr("data-cashout");
			//var planPV = $(".btnAddCombo").attr("data-pv");
			
			$( "#plantype-options" ).slideUp();
			$( "#plantype-combos" ).slideDown();

			$('a.btnAddCombo').click(function(e) {
				e.preventDefault();
				var comboID = $(this).attr("data-id");
				var comboNAME = $(this).attr("data-name");
				var comboPV = $(this).attr("data-pv");
				var planPV = $(this).attr("data-planpv");

				$.ajax({
					url: base_url+'cart/addtocart',
					data: 'product_type=combos&product_id='+comboID+'&current_cashout='+selectedPlanCashOut+'&planpv='+planPV+'&combopv='+comboPV,
					type:'post',
					success: function(response){
						var resp = jQuery.parseJSON( response );
						
						if(resp.status == 'success' && resp.rowid){
							if( resp.product_type == 'combos'){
								$("#CombosCartWidget #prod-item-"+resp.rowid).remove();
								$("#CombosCartWidget").append('<div id="prod-item-'+resp.rowid+'" class="item" style="display:none">'+
										'<div class="fleft" style="width:95%;">'+
										'<span class="productName block fleft"><b>'+comboNAME+'</b></span>'+
										'<span class="productName block fleft" id="prod-qty-'+resp.rowid+'" style="margin-left:15px;"  data-id="'+resp.product_id+'" data-name="'+resp.name+'" data-pv="'+resp.this_pv_value+'" data-product-type="'+resp.product_type+'" data-cashout="" data-planpv="" ></span>'+
									'</div>'+
									'<span class="icoDelete">'+
									'<a href="javascript:void(0)" class="btnDeleteCombos" data-id="'+resp.product_id+'" data-name="'+resp.name+'" data-pv="'+resp.this_pv_value+'" data-cashout="" data-planpv="" data-product-type="'+resp.product_type+'"  id="'+resp.rowid+'" rel="'+resp.name+'">'+
									'<i class="icon-remove"></i></a> </span><br class="clear" /></div>\n');
							} else {
							    basket.append(resp.name);
							}

							$("#cashoutLabel").html(resp.total).show('slow');
							$("#pesovalLabel").attr('data-pv',resp.total_remaining_pv).html(resp.total_remaining_pv).show('slow');
							
							$('#cashoutBox,#pesovalBox').animate({backgroundColor: '#fff267'}, 'fast', function(){
								$('#cashoutBox,#pesovalBox').animate({backgroundColor: '#F4F4F4'}, 'fast');
							});
							$('#prod-qty-'+resp.rowid).html("<b>x"+resp.combo_qty+"</b>");
							$('#prod-item-'+resp.rowid).show('slow');
						} else if(resp.status == 'coexist') {
							var confirmCoexist = confirm("You are already subscribed to "+resp.product_name+". Do you wish to continue?");

							if(confirmCoexist == true) {
								
								$.ajax({
									url: base_url+'cart/addtocart',
									data: 'tag=replace_cart_item&product_type=combos&product_id='+comboID+'&current_cashout='+selectedPlanCashOut+'&planpv='+planPV+'&combopv='+comboPV+'&remove_keyid='+resp.rowid+'&remove_product_id='+resp.product_id,
									type:'post',
									success: function(response) {
										
										var resp2 = jQuery.parseJSON( response );
										var cartItem = '<div id="prod-item-'+resp2.rowid+'" class="item" style="display:none">'+
										'<div class="fleft" style="width:95%;">'+
											'<span class="productName block fleft"><b>'+comboNAME+'</b></span>'+
											'<span class="productName block fleft" id="prod-qty-'+resp2.rowid+'" style="margin-left:15px;"  data-id="'+resp2.product_id+'" data-name="'+resp2.name+'" data-pv="'+resp2.pv+'" data-cashout="" data-planpv="" >'+
												
											'</span>'+
										'</div>'+
										'<span class="icoDelete">'+
										'<a href="javascript:void(0)" class="btnDeleteCombos" data-id="'+resp2.product_id+'" data-name="'+resp2.name+'" data-pv="'+resp2.pv+'" data-cashout="" data-planpv=""  id="'+resp2.rowid+'" rel="'+resp2.name+'">'+
										'<i class="icon-remove"></i></a> </span><br class="clear" /></div>\n';
									
										if(resp2.status == 'success' && resp2.rowid){
											$('#prod-item-'+resp.rowid).remove();
											if( resp2.product_type == 'combos'){
												$("#CombosCartWidget").append(cartItem);
											} else {
											    basket.append(resp2.name);
											}

											$("#cashoutLabel").html(resp2.total).show('slow');
											$("#pesovalLabel").attr('data-pv',resp2.total_remaining_pv).html(resp2.total_remaining_pv).show('slow');
											
											$('#cashoutBox,#pesovalBox').animate({backgroundColor: '#fff267'}, 'fast', function(){
												$('#cashoutBox,#pesovalBox').animate({backgroundColor: '#F4F4F4'}, 'fast');
											});
											$('#prod-qty-'+resp2.rowid).html("<b>x"+resp2.qty+"</b>");
											$('#prod-item-'+resp2.rowid).show('slow');
											
										}

									}, 
									error: function(){
										alert('Some error occured or the system is busy. Please try again later');	
									}
								});
							}
						}
					}, 
					error: function(){
						alert('Some error occured or the system is busy. Please try again later');	
					}
				});
			});
		});

		// go next for boosters --robert
		$("#goBoosters").click(function(e) {
			e.preventDefault();
			var selectedPlanCashOut = $(".btnAddBooster").attr("data-cashout");
			
			$( "#plantype-combos" ).slideUp();
			$( "#plantype-boosters" ).slideDown();

			$('a.btnAddBooster').click(function(e) {
				e.preventDefault();
				
				var id = $(this).attr("data-id");
				var name = $(this).attr("data-name");
				var amount = $(this).attr("data-amount");

				$.ajax({
					url: base_url+'cart/addtocart',
					data: 'product_type=boosters&product_id='+id+'&current_cashout='+selectedPlanCashOut+'&amount='+amount,
					type:'post',
					success: function(response){
						var resp = jQuery.parseJSON( response );
						
						if(resp.status == 'success' && resp.rowid) {
							$("#BoostersCartWidget #prod-item-"+resp.rowid).remove();
							$("#BoostersCartWidget").append('<div id="prod-item-'+resp.rowid+'" class="item" style="display:none">'+
									'<div class="fleft">'+
									'<span class="productName block" style="max-width:199px;"><b>'+resp.name+'</b></span>'+
									'</span>'+
								'</div>'+
								'<span class="icoDelete">'+
								'<a href="javascript:void(0)" class="btnDeleteCombos" data-id="'+resp.product_id+'" data-name="'+resp.name+'" data-pv="'+resp.this_pv_value+'" data-cashout="" data-planpv=""  id="'+resp.rowid+'" rel="'+resp.name+'">'+
								'<i class="icon-remove"></i></a> </span><br class="clear" /></div>\n');
							
							$("#cashoutLabel").html(resp.total).show('slow');
							$("#pesovalLabel").attr('data-pv',resp.total_remaining_pv).html(resp.total_remaining_pv).show('slow');
							
							$('#cashoutBox,#pesovalBox').animate({backgroundColor: '#fff267'}, 'fast', function(){
								$('#cashoutBox,#pesovalBox').animate({backgroundColor: '#F4F4F4'}, 'fast');
							});
							$('#prod-qty-'+resp.rowid).html("<b>x"+resp.combo_qty+"</b>");
							$('#prod-item-'+resp.rowid).show('slow');
						} else if(resp.status == 'coexist') {
							var confirmCoexist = confirm("You are already subscribed to "+resp.product_name+". Do you wish to continue?");
							if(confirmCoexist == true) {
								$.ajax({
									url: base_url+'cart/addtocart',
									data: 'tag=replace_cart_item&product_type=boosters&product_id='+id+'&remove_keyid='+resp.rowid+'&remove_product_id='+resp.product_id,
									type:'post',
									success: function(response) {
										
										var resp2 = jQuery.parseJSON( response );
										
										var cartItem = '<div id="prod-item-'+resp2.rowid+'" class="item" style="display:none">'+
										'<div class="fleft">'+
											'<span class="productName block" style="max-width:199px;"><b>'+name+'</b></span>'+
											'</span>'+
										'</div>'+
										'<span class="icoDelete">'+
										'<a href="javascript:void(0)" class="btnDeleteCombos" data-id="'+resp2.product_id+'" data-name="'+resp2.name+'" data-pv="'+resp2.pv+'" data-cashout="" data-planpv=""  id="'+resp2.rowid+'" rel="'+resp2.name+'">'+
										'<i class="icon-remove"></i></a> </span><br class="clear" /></div>\n';
									
										if(resp2.status == 'success' && resp2.rowid){
											$('#prod-item-'+resp.rowid).remove();
											$("#BoostersCartWidget").append(cartItem);
											
											$("#cashoutLabel").html(resp2.total).show('slow');
											$("#pesovalLabel").attr('data-pv',resp2.total_remaining_pv).html(resp2.total_remaining_pv).show('slow');
											
											$('#cashoutBox,#pesovalBox').animate({backgroundColor: '#fff267'}, 'fast', function(){
												$('#cashoutBox,#pesovalBox').animate({backgroundColor: '#F4F4F4'}, 'fast');
											});
											$('#prod-qty-'+resp2.rowid).html("<b>x"+resp2.qty+"</b>");
											$('#prod-item-'+resp2.rowid).show('slow');
										}

									}, 
									error: function(){
										alert('Some error occured or the system is busy. Please try again later');	
									}
								});
							}
						}
					}, 
					error: function(){
						alert('Some error occured or the system is busy. Please try again later');	
					}
				});
				
			});
		});

		// set dialog for application status - gellie
		$('a#open_application_status').on('click', function(){
			$( '#dialog_application_status' ).dialog( "open" );
		});
