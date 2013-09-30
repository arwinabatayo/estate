		$('button#create').click(function(e) {
			e.preventDefault();
			window.location="<?php echo base_url() ?>plan?setOrderConfig=<?php echo $_GET['setOrderConfig']?>&plantype=<?php echo $_GET['plantype']?>&bundles=combos";
		});
		$('button#combos').click(function(e) {
			e.preventDefault();
			window.location="<?php echo base_url() ?>plan?setOrderConfig=<?php echo $_GET['setOrderConfig']?>&plantype=<?php echo $_GET['plantype']?>&bundles=boosters";
		});
		$('button#boosters').click(function(e) {
			e.preventDefault();
			window.location="<?php echo base_url() ?>addons";
		});
		
		$("#backPlans,#backCombos").click(function(e) {
			var goto = $(this).attr('data-goto');
			window.location="<?php echo base_url() ?>plan?setOrderConfig=<?php echo $_GET['setOrderConfig']?>"+goto;
		});
		
		$(".create_add_this_plan").click(function(e) {
			e.preventDefault();

			var basketPlan    = $('#PlanCartWidget');
			
			var itemid    = $(this).attr('data-id');
			var itemname  = $(this).attr('data-name');
			var plan_pv   = $(this).attr('data-pv');
			var plan_cashout = $(this).attr('data-plan-cashout');
			
			$.ajax({
				url: base_url+'cart/addtocart',
				data: 'product_type=plan&product_id='+itemid+'&plan='+itemid+'&plan_cashout='+plan_cashout+'&device=1',
				type:'post',
				success: function(response) {
					//alert(response);
					var resp = jQuery.parseJSON(response);

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
		});
		
		
		// COMBOS
		$(".create_add_this_combos").click(function(e) {
			var basket    = $('#CombosCartWidget');
			
			var plan_pv = $("#PlanCartWidget div.item").attr('data-pv');
			var plan_cashout = $("#PlanCartWidget div.item").attr('data-cashout');
			
			// if above values not exist automatically add to cashout value
			// if back to plan then select, put the calculations
			
			var itemid    = $(this).attr('data-id');
			var itemname  = $(this).attr('data-name');
			var item_pv   = $(this).attr('data-pv');
			
			
			$.ajax({
				url: base_url+'cart/addtocart',
				data: 'product_type=combos&product_id='+itemid+'&current_cashout='+plan_cashout+'&planpv='+plan_pv+'&combopv='+item_pv,
				type:'post',
				success: function(response){
					var resp = jQuery.parseJSON(response);
					var isnewrow = false;
					$('div.item',basket).each(function(e) {
						var combosList = $(this).attr('id').split('-');
						if(combosList[2] == resp.rowid) {
							isnewrow = true;
						}
					})
					
					if(resp.status == 'success' && resp.rowid) {
						if(isnewrow == false) {
							var cartItem = '<div data-prod-type="combos" id="prod-item-'+resp.rowid+'" class="item" style="display:none" data-cashout="'+resp.price+'">'+
								'<div class="fleft">'+
									'<span class="productName block">'+itemname+'</span>'+
									'<span class="price block arial italic">x'+resp.combos_qty+'</span>'+
								'</div>'+
								'<span class="icoDelete">'+
									'<a data-amount="'+resp.price+'" data-pv="'+resp.this_pv_value+'" data-id="'+resp.product_id+'" href="javascript:void(0)" class="btnDeleteCombos" id="'+resp.rowid+'" rel="'+itemname+'">'+
										'<i class="icon-remove">&nbsp;X&nbsp;</i>'+
									'</a>'+
								'</span>'+
								'<br class="clear" />'+
							'</div>\n';
							basket.prepend(cartItem);
							$('#prod-item-'+resp.rowid).show();
						} else {
							$('#prod-item-'+resp.rowid+' span.price').html("x"+resp.combos_qty);
						}
						
						$('#prod-item-'+resp.rowid).animate({backgroundColor: '#fff267'}, 'fast', function(){
							$('#prod-item-'+resp.rowid).animate({backgroundColor: 'transparent'}, 'fast');
						});
						
						$('#pesovalueLabel').html(resp.total_remaining_pv);
						$('#cashoutLabel').html(resp.total);
					} else if(resp.status == 'coexist') {
						var coex_rowid = resp.rowid;
						
						var confirmCoexist = confirm("You are already subscribed to "+resp.product_name+". Do you wish to continue?");
						
						if(confirmCoexist == true) {
							$.ajax({
								url: base_url+'cart/addtocart',
								data: 'tag=replace_cart_item&product_type=combos&product_id='+itemid+'&current_cashout='+plan_cashout+'&planpv='+plan_pv+'&combopv='+item_pv+'&remove_keyid='+resp.rowid+'&remove_product_id='+resp.product_id,
								type:'post',
								success: function(response) {
									var resp2 = jQuery.parseJSON( response );
									var cartItem = '<div id="prod-item-'+resp2.rowid+'" class="item" style="display:none" data-cashout="'+resp2.price+'">'+
													'<div class="fleft">'+
														'<span class="productName block">'+resp2.name+'</span>'+
														'<span class="price block arial italic">x'+resp2.combos_qty+'</span>'+
													'</div>'+
													'<span class="icoDelete">'+
														'<a data-amount="'+resp2.price+'" data-pv="'+resp2.this_pv_value+'" data-id="'+resp2.product_id+'" href="javascript:void(0)" class="btnDeleteCombos" id="'+resp2.rowid+'" rel="'+resp2.name+'">'+
															'<i class="icon-remove">&nbsp;X&nbsp;</i>'+
														'</a>'+
													'</span>'+
													'<br class="clear" />'+
												'</div>\n';
								
									if(resp2.status == 'success' && resp2.rowid) {
										$('#prod-item-'+coex_rowid).remove();
										basket.prepend(cartItem);
										$('#prod-item-'+resp2.rowid).show();
										
										$('#pesovalueLabel').html(resp2.total_remaining_pv);
										$('#cashoutLabel').html(resp2.total);
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
		
		
		
		// BOOSTERS
		$(".create_add_this_boosters").click(function(e) {
			var basket    = $('#BoostersCartWidget');
			
			var plan_pv = $("#PlanCartWidget div.item").attr('data-pv');
			var plan_cashout = $("#PlanCartWidget div.item").attr('data-cashout');
			
			// if above values not exist automatically add to cashout value
			// if back to plan then select, put the calculations
			
			var itemid    = $(this).attr('data-id');
			var itemname  = $(this).attr('data-name');
			var item_amount   = $(this).attr('data-amount');
			
			
			$.ajax({
				url: base_url+'cart/addtocart',
				data: 'product_type=boosters&product_id='+itemid+
						'&current_cashout='+plan_cashout+
						'&amount='+item_amount,
				type:'post',
				success: function(response){
					var resp = jQuery.parseJSON(response);
					
					if(resp.msg == "duplicateentry") {
						alert("Duplicate Entry "+itemname);
					} else {
						if(resp.status == 'success' && resp.rowid) {
							
							var cartItem = '<div data-prod-type="boosters" id="prod-item-'+resp.rowid+'" class="item" style="display:none" data-cashout="'+resp.price+'">'+
								'<div class="fleft">'+
									'<span class="productName block">'+itemname+'</span>'+
									'<span class="price block arial italic">'+resp.price+'</span>'+
								'</div>'+
								'<span class="icoDelete">'+
									'<a data-amount="'+resp.price+'" data-pv="'+resp.this_pv_value+'" data-id="'+resp.product_id+'" href="javascript:void(0)" class="btnDeleteCombos" id="'+resp.rowid+'" rel="'+itemname+'">'+
										'<i class="icon-remove">&nbsp;X&nbsp;</i>'+
									'</a>'+
								'</span>'+
								'<br class="clear" />'+
							'</div>\n';
							basket.prepend(cartItem);
							$('#prod-item-'+resp.rowid).show();
							$('#prod-item-'+resp.rowid).animate({backgroundColor: '#fff267'}, 'fast', function(){
								$('#prod-item-'+resp.rowid).animate({backgroundColor: 'transparent'}, 'fast');
							});
							
							$('#pesovalueLabel').html(resp.total_remaining_pv);
							$('#cashoutLabel').html(resp.total);
						} else if(resp.status == 'coexist') {
							var coex_rowid = resp.rowid;
							
							var confirmCoexist = confirm("You are already subscribed to "+resp.product_name+". Do you wish to continue?");
							
							if(confirmCoexist == true) {
								$.ajax({
									url: base_url+'cart/addtocart',
									data: 'tag=replace_cart_item&product_type=boosters&product_id='+itemid+
											'&remove_keyid='+resp.rowid+
											'&remove_product_id='+resp.product_id+
											'&amount='+item_amount,
									type:'post',
									success: function(response) {
										var resp2 = jQuery.parseJSON( response );
										var cartItem = '<div id="prod-item-'+resp2.rowid+'" class="item" style="display:none" data-cashout="'+resp2.price+'">'+
														'<div class="fleft">'+
															'<span class="productName block">'+resp2.name+'</span>'+
															'<span class="price block arial italic">'+resp2.price+'</span>'+
														'</div>'+
														'<span class="icoDelete">'+
															'<a data-amount="'+resp2.price+'" data-pv="'+resp2.this_pv_value+'" data-id="'+resp2.product_id+'" href="javascript:void(0)" class="btnDeleteCombos" id="'+resp2.rowid+'" rel="'+resp2.name+'">'+
																'<i class="icon-remove">&nbsp;X&nbsp;</i>'+
															'</a>'+
														'</span>'+
														'<br class="clear" />'+
													'</div>\n';
									
										if(resp2.status == 'success' && resp2.rowid) {
											$('#prod-item-'+coex_rowid).remove();
											basket.prepend(cartItem);
											$('#prod-item-'+resp2.rowid).show();
											
											$('#pesovalueLabel').html(resp.total_remaining_pv);
											$('#cashoutLabel').html(resp2.total);
										}
	
									}, 
									error: function(){
										alert('Some error occured or the system is busy. Please try again later');	
									}
								});
							}
						}
					}
					
				}, 
				error: function(){
					alert('Some error occured or the system is busy. Please try again later');	
				}
			});
		});
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		

		// go next for boosters --robert
		$("#goBoosters").click(function(e) {

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

		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		// delete/deduct combo qty -- robert
		$(document).on('click', '.cartWidget a.btnDeleteCombos, .cartWidget a.btnDeleteBoosters', function(){
				var rowid = $(this).attr('id');
				var prodName = $(this).attr('rel');
				
				var prodId = $(this).attr("data-id");
				var prodPv = $(this).attr("data-pv");
				var amount = $(this).attr("data-amount");
				var product_type = $(this).parent().parent().attr("data-prod-type");
				
				var plan_pv = $("#PlanCartWidget div.item").attr('data-pv');
				var plan_cashout = $("#PlanCartWidget div.item").attr('data-cashout');
				
				if( !confirm('Are you sure you want to delete "'+prodName+'"?')) return;
				
				$.ajax({
					url: base_url+'cart/update_qty_of_cart',
					data: 'keyid='+rowid+
							'&product_type='+product_type+
							'&product_id='+prodId+
							'&product_pv='+prodPv+
							'&product_amount='+amount+
							'&plan_cashout='+plan_cashout+
							'&plan_pv='+plan_pv,
					type:'post',
					success: function(response) {
						
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
								$('#prod-item-'+resp.rowid+' span.price').html("<b>x"+resp.combos_qty+"</b>");
								$('#prod-item-'+resp.rowid+' span.price').show('slow');
							}
						}
						
						$('#pesovalueLabel').html(resp.total_remaining_pv).show();
						$('#cashoutLabel').html(resp.total).show();
					}, 
					error: function(){
						alert('Some error occured or the system is busy. Please try again later');	
					}
				});
		});
		// set dialog for application status - gellie
		$('a#open_application_status').on('click', function(){
			$( '#dialog_application_status' ).dialog( "open" );
		});
