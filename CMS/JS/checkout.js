$(function(){

	$('.paymentMethod').hide();
	$('.quantite').change(function(){
		var quantite = $(this).val();
		var id = $(this).attr('data-id');
		var total = $(this).attr('data-total');
		$.ajax({
	    	url: "checkout.php", // Le nom du fichier indiqué dans le formulaire
	        type: "POST", // La méthode indiquée dans le formulaire (get ou post)
	        data: {
		    	qt: quantite,
		    	idProd: id,
		    	tot : total
		    }
		}).done(function(){
			window.location.reload(true);
		})
	})
	
	$('.pay').click(function(e){
		e.preventDefault();
		if($('#acceptCGV').is(":checked"))
		{
			$('.pay').attr('href','loginCustomer.php?step=paiement');
			$('.pay').hide();
			$('#acceptCGV').hide();
			$('.breadcrumb li').removeClass('active');
			$('li.paiement').addClass('active');
			$('a.recapi').attr('href','?step=recapitulatif')
			$('div.recap').hide();
			$('.paymentMethod').show('slow');
		}
		else
		{
			alert('Veuillez accepter les conditions générales de ventes pour passer votre commande')
		}
		
		
	})
	
	$('.adresseFact').click(function(e){
		e.stopPropagation();
		var ID = $(this).attr('data-id');
		var pays = $(this).attr('data-pays');
		$('.fact').css("border","")
		$('.fact-'+ID).css({"transform":"scale(1.05)", "box-shadow": "0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24)"})
		document.cookie = "adresseFacturation="+ID+"-"+pays+"; expires=Thu, 18 Dec 2017 12:00:00 UTC";
		var deli = document.cookie.indexOf( "deliveryMethod=" );
		var fact = document.cookie.indexOf( "adresseFacturation=" );
		var livr = document.cookie.indexOf( "adresseLivraison=" );
		if( deli > 0 && fact > 0 && livr > 0 )
		{
			if ( $( ".btnContinuer" ).length )
			{
			}
			else
			{
				var continuer = "<div class='col-md-12'><a class='btn btn-info btnContinuer col-md-offset-11' href='?step=recapitulatif'>Continuer</a></div>";				
				$(continuer).prependTo('#resultat');
			}
		}
	})
	
	$("#bancoLogo").click(function(){
		$("#banco").click()
	})
	
	$('.thisAddress').click(function(e){
		e.stopPropagation();
		var ID = $(this).attr('data-id');
		var pays = $(this).attr('data-pays');
		$('.livr').css("border","")
		$('.livr-'+ID).css("border","solid 3px blue")
		var country = $('.country-'+ID).text();
		document.cookie = "adresseLivraison="+ID+"-"+pays+"; expires=Thu, 18 Dec 2017 12:00:00 UTC";
		$.ajax({
	    	url: "ajax/findAdresse.php", // Le nom du fichier indiqué dans le formulaire
	        type: "POST", // La méthode indiquée dans le formulaire (get ou post)
	        data: {
		    	pays: country
		    },
		    success: function(data){
			    if(data == "telechargeable")
			    {
					var exdate=new Date();
					exdate.setDate(exdate.getDate() + 30);
					document.cookie = "deliveryMethod=download; expires="+exdate.toUTCString();
					var deli = document.cookie.indexOf( "deliveryMethod=" );
					var fact = document.cookie.indexOf( "adresseFacturation=" );
					var livr = document.cookie.indexOf( "adresseLivraison=" );
				    var continuer = "<div class='col-md-12'><a class='btn btn-info btnContinuer col-md-offset-11' href='?step=recapitulatif'>Continuer</a></div>";
					$(continuer).prependTo('#resultat');
			    }
			    else
			    {
				    $('#resultat').html(data);
				    $(".price_table_heading").fitText(0.8);
				    $('.btn-delivery-choice').click(function(){
						var id = $(this).attr('data-id');
						var price = $(this).attr('data-price');
						var date = $(this).attr('data-date');
						var nom = $(this).attr('data-name');
						$('.delivery').css("border","")
						$('.delivery-'+id).css("border","solid 3px blue");
						var exdate=new Date();
						exdate.setDate(exdate.getDate() + 30);
						document.cookie = "deliveryMethod="+id+"-"+price+"-"+date+"-"+nom+"; expires="+exdate.toUTCString();
						var deli = document.cookie.indexOf( "deliveryMethod=" );
						var fact = document.cookie.indexOf( "adresseFacturation=" );
						var livr = document.cookie.indexOf( "adresseLivraison=" );
						if( deli > 0 && fact > 0 && livr > 0 )
						{
							if ( $( ".btnContinuer" ).length )
							{
							}
							else
							{
								var continuer = "<div class='col-md-12'><a class='btn btn-info btnContinuer col-md-offset-11' href='?step=recapitulatif'>Continuer</a></div>";
								$(continuer).prependTo('#resultat');
							}
						   
						}
					})
				}
			    
		    }
		})

	})
	
	
	

});
