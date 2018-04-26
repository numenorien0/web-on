$(function(){
	
	if($('.superMenu').length)
	{
		var body = $("body").css("padding-top");
		//alert(body);
		$('body').css({"padding-top": parseInt(body)+50+"px"});
	}
	if($('#hiddenPageEdit').length > 0 && $('#hiddenPageEdit').val() == "category")
	{
		$('.disposition, .editPage').remove();	
	}
	if($('#hiddenPageEdit').length > 0 && $('#hiddenPageEdit').val() == "product")
	{
		$('.disposition, .editMode').remove();
		$('.editPage').text("Editer le produit").attr('data-id', $('#hiddenPageEdit').attr('data-id'));
			
	}
	
	var edition = false;
	$('.addChildHere').hide();
	
	$('.editMode').click(function(){
		if($(this).hasClass("active"))
		{
			$(this).removeClass("active");
			edition = false;
			$('.addChildHere').hide();
		}
		else
		{
			$(this).addClass("active");
			edition = true;
			$('.addChildHere').show();
		}
	})
	

	$('.miniature').hover(function(){
		if(edition == true)
		{
			$(this).css({"position":"relative"});
			$('<div class="editBtn" style="position: absolute; top: 10px"><div class="modifier" style="display: inline-block; padding: 7px; color: white; background: #699bf2; border-radius: 4px;">Modifier</div><div class="supprimer" style="padding: 7px; margin-left: 15px; color: white; background: #e05819; border-radius: 4px; display: inline-block;">Supprimer</div></div>').appendTo($(this));
			$(this).css({"box-shadow": "inset 0 0 0px 2px #71c3ff"});
			
			$(this).mouseleave(function(){
				$(this).children(".editBtn").detach();
				//alert($("editBtn").length);
				$(this).css({"box-shadow": "none"});
			})
			
			$('.miniature .supprimer').click(function(){
				//?delete=81
				
				var celuila = $(this).parent().parent();
				var id = $(this).parent().parent().attr('data-id');
				$.ajax({
					url: "CMS/listContent.php?delete="+id
				}).done(function(){
					$(celuila).parent().parent().remove();
					window.location.reload();
				})
				
			});
			
			
			
			$('.miniature .modifier').click(function(){
				$('.blackScreen').fadeIn();
				$('html, body').css({"overflow":"hidden"})
				var id = $(this).parent().parent().attr('data-id');
				$('#formulaireEditAddItems').attr('src', 'CMS/editContent.php?id='+id+'&embedded=true&edit=bloc');
				
				$('#formulaireEditAddItems').on("load", function(){
					$('#formulaireEditAddItems').fadeIn();
					$('#formulaireEditAddItems').animate({top: "5%"}, 1000)
					
					$(this).contents().find('#formulaireGeneral').submit(function() { 
					      $('#formulaireEditAddItems').animate({top :"100%"}, 1000, "linear", function(){
						  		$(this).hide();
						  		$('html, body').css({"overflow":"auto"})
						  		window.location.reload(false);
							})
					});				
					
					
				})
			
				
		})
		
		
		$('.blackScreen').click(function(){
			$(this).fadeOut();
			$('html, body').css({"overflow":"auto"})
			$('#formulaireEditAddItems').animate({top :"100%"}, 1000, "linear", function(){
				$(this).hide();
			})
		})		
		
		}
	});

	$('.produit').hover(function(){
		var href = $(this).attr('href');
		if(edition == true)
		{
			$(this).attr("href", "#");
			$(this).css({"position":"relative"});
			$('<div class="editBtn"><div class="modifier" style="display: inline-block; padding: 7px; color: white; background: #699bf2; border-radius: 4px;">Modifier</div><div class="supprimer" style="padding: 7px; margin-left: 15px; color: white; background: #e05819; border-radius: 4px; display: inline-block;">Supprimer</div></div>').appendTo($(this));
			$(this).css({"box-shadow": "inset 0 0 0px 2px #71c3ff"});
			
			$(this).mouseleave(function(){
				$(this).children(".editBtn").remove();
				//alert($("editBtn").length);
				$(this).css({"box-shadow": "none"});
				$(this).attr('href', href);
			})
			
			$('.produit .supprimer').click(function(){
				//?delete=81
				
				var celuila = $(this).parent().parent();
				var id = $(this).parent().parent().attr('data-id');
				$.ajax({
					url: "CMS/product.php?delete="+id
				}).done(function(){
					$(celuila).parent().parent().remove();
					window.location.reload();
				})
				
			});
			
			$('.produit .modifier').click(function(e){

				e.stopPropagation();
				e.preventDefault();
				
				$('.blackScreen').fadeIn();
				$('html, body').css({"overflow":"hidden"})
				var id = $(this).parent().parent().attr('data-id');
				$('#formulaireEditAddItems').attr('src', 'CMS/product.php?id='+id+'&embedded=true&edit=bloc');
				
				$('#formulaireEditAddItems').on("load", function(){
					$('#formulaireEditAddItems').fadeIn();
					$('#formulaireEditAddItems').animate({top: "5%"}, 1000)
					
					$(this).contents().find('#formulaireProduit').submit(function() { 
					      $('#formulaireEditAddItems').animate({top :"100%"}, 1000, "linear", function(){
						  		$(this).hide();
						  		$('html, body').css({"overflow":"auto"})
						  		window.location.reload(false);
							})
					});				
					
					
				})
			
				
		})
		
		
		$('.blackScreen').click(function(){
			$(this).fadeOut();
			$('html, body').css({"overflow":"auto"})
			$('#formulaireEditAddItems').animate({top :"100%"}, 1000, "linear", function(){
				$(this).hide();
			})
		})		
		
		}
	});	
	

$('menu').hover(function(){
		if(edition == true)
		{
			$(this).css({"position":"relative"});
			$('<div class="editBtn"><div class="modifier" style="display: inline-block; padding: 7px; color: white; background: #699bf2; border-radius: 4px;">Modifier</div></div>').appendTo($(this));
			$(this).css({"box-shadow": "inset 0 0 0px 2px #71c3ff"});
			
			$(this).mouseleave(function(){
				$(this).children(".editBtn").detach();
				//alert($("editBtn").length);
				$(this).css({"box-shadow": "none"});
			})
			
			$('menu .modifier').click(function(){
				$('.blackScreen').fadeIn();
				$('html, body').css({"overflow":"hidden"})
				var id = $(this).parent().parent().attr('data-id');
				$('#formulaireEditAddItems').attr('src', 'CMS/menu.php?embedded=true&edit=bloc');
				
				$('#formulaireEditAddItems').on("load", function(){
					$('#formulaireEditAddItems').fadeIn();
					$('#formulaireEditAddItems').animate({top: "5%"}, 1000)
					
					$(this).contents().find('#formulaireGeneral').submit(function() { 
					      $('#formulaireEditAddItems').animate({top :"100%"}, 1000, "linear", function(){
						  		$(this).hide();
						  		$('html, body').css({"overflow":"auto"})
						  		window.location.reload(false);
							})
					});				
					
					
				})
			
				
			})
		}
		$('.blackScreen').click(function(){
			$(this).fadeOut();
			$('html, body').css({"overflow":"auto"})
			$('#formulaireEditAddItems').animate({top :"100%"}, 1000, "linear", function(){
				$(this).hide();
			})
		})
})
$('footer').hover(function(){
		if(edition == true)
		{
			$(this).css({"position":"relative"});
			$('<div class="editBtn"><div class="modifier" style="display: inline-block; padding: 7px; color: white; background: #699bf2; border-radius: 4px;">Modifier</div></div>').appendTo($(this));
			$(this).css({"box-shadow": "inset 0 0 0px 2px #71c3ff"});
			
			$(this).mouseleave(function(){
				$(this).children(".editBtn").detach();
				//alert($("editBtn").length);
				$(this).css({"box-shadow": "none"});
			})
			
			$('footer .modifier').click(function(){
				$('.blackScreen').fadeIn();
				$('html, body').css({"overflow":"hidden"})
				var id = $(this).parent().parent().attr('data-id');
				$('#formulaireEditAddItems').attr('src', 'CMS/footer.php?embedded=true&edit=bloc');
				
				$('#formulaireEditAddItems').on("load", function(){
					$('#formulaireEditAddItems').fadeIn();
					$('#formulaireEditAddItems').animate({top: "5%"}, 1000)
					
					$(this).contents().find('#formulaireGeneral').submit(function() { 
					      $('#formulaireEditAddItems').animate({top :"100%"}, 1000, "linear", function(){
						  		$(this).hide();
						  		$('html, body').css({"overflow":"auto"})
						  		window.location.reload(false);
							})
					});				
					
					
				})
			
				
			})
		}
		$('.blackScreen').click(function(){
			$(this).fadeOut();
			$('html, body').css({"overflow":"auto"})
			$('#formulaireEditAddItems').animate({top :"100%"}, 1000, "linear", function(){
				$(this).hide();
			})
		})
})	
	
	$('.disposition').click(function(){
		$('html, body').css({"overflow":"hidden"})
		$('.blackScreen').fadeIn();
		var id = $(this).attr('data-id');
		$('#formulaireEditAddItems').attr('src', 'CMS/listContent.php?parent='+id+'&embedded=true&list=sort');
		
		$('#formulaireEditAddItems').on("load", function(){
			$('#formulaireEditAddItems').fadeIn();
			$('#formulaireEditAddItems').animate({top: "5%"}, 1000)
			$(this).contents().find('#formulaireGeneral').submit(function() { 
			      $('#formulaireEditAddItems').animate({top :"100%"}, 1000, "linear", function(){
				  		$(this).hide();
				  		window.location.reload(false);
					})
			});				
		})
		
		$('.blackScreen').click(function(){
			$('html, body').css({"overflow":"auto"})
			window.location.reload(false);	
		})
					
	})
	
	$('.editPage').click(function(){
		
		if($(this).text() == "Editer le produit")
		{
			$('html, body').css({"overflow":"hidden"})
			$('.blackScreen').fadeIn();
			var id = $(this).attr('data-id');
			$('#formulaireEditAddItems').attr('src', 'CMS/product.php?id='+id+'&embedded=true');
			
			$('#formulaireEditAddItems').on("load", function(){
				$('#formulaireEditAddItems').fadeIn();
				$('#formulaireEditAddItems').animate({top: "5%"}, 1000)
				$(this).contents().find('#formulaireProduit').submit(function() { 
				      $('#formulaireEditAddItems').animate({top :"100%"}, 1000, "linear", function(){
					  		$(this).hide();
					  		window.location.reload(false);
						})
				});				
			})			
		}
		else
		{
		
			$('html, body').css({"overflow":"hidden"})
			$('.blackScreen').fadeIn();
			var id = $(this).attr('data-id');
			$('#formulaireEditAddItems').attr('src', 'CMS/editContent.php?id='+id+'&embedded=true');
			
			$('#formulaireEditAddItems').on("load", function(){
				$('#formulaireEditAddItems').fadeIn();
				$('#formulaireEditAddItems').animate({top: "5%"}, 1000)
				$(this).contents().find('#formulaireGeneral').submit(function() { 
				      $('#formulaireEditAddItems').animate({top :"100%"}, 1000, "linear", function(){
					  		$(this).hide();
					  		window.location.reload(false);
						})
				});				
			})
		}
		
		$('.blackScreen').click(function(){
			$('html, body').css({"overflow":"auto"})
			window.location.reload(false);	
		})
					
	})
	
	$('.addChildHere').click(function(){
		if(edition == true)
		{
			$('.blackScreen').fadeIn();
			$('html, body').css({"overflow":"hidden"})
			var id = $(this).attr('data-id');
			$('#formulaireEditAddItems').attr('src', 'CMS/addContent.php?parent='+id+'&embedded=true&add=bloc');
			
			$('#formulaireEditAddItems').on("load", function(){
				$('#formulaireEditAddItems').fadeIn();
				$('#formulaireEditAddItems').animate({top: "5%"}, 1000)
				$(this).contents().find('#formulaireGeneral').submit(function() { 
				      $('#formulaireEditAddItems').animate({top :"100%"}, 1000, "linear", function(){
					  		$(this).hide();
					  		$('html, body').css({"overflow":"auto"})
					  		window.location.reload(false);
						})
				});				
			})	
		}	
	})
	
	$('.blackScreen').click(function(){
		$(this).fadeOut();
		$('html, body').css({"overflow":"auto"})
		$('#formulaireEditAddItems').animate({top :"100%"}, 1000, "linear", function(){
			$(this).hide();
		})
	})	
	
	

	

	
})