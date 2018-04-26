$(function(){
	var card
	var bct
	var cash
	var total = 0;
	var global = 0;
	var tableauJson = new Array();
	$("#ean").focus();

	
	
	$("#ean").keydown(function(e){
		if(e.keyCode == "13")
		{
			var qt = $("#qt").val();
			$.ajax({
				url: "ajax/caisse.php",
				type: "POST",
				data: {
					ean : $('#ean').val(),
					qt: qt
				}
			}).done(function(html){
				if(html != null)
				{
					if(html == "Plus de stock")
					{
						alert("Plus de stock pour ce produit");
					}
					else
					{
						if(html == "Introuvable")
						{
							alert("Produit inconnu");
						}
						else
						{
							html = $.parseJSON(html);
							var tab = "<div class='col-xs-12 ligne'>";
							nom = $.parseJSON(html.nom);
							tab += "<div class='col-xs-6'>"+qt+"x "+nom['fr']+"</div>";
							tab += "<div class='col-xs-3'>"+((html.prix)*(1+html.Tauxtva/100)).toFixed(2)+" €</div>";
							tab += "<div class='col-xs-3'>"+(qt*(html.prix*(1+html.Tauxtva/100))).toFixed(2)+" €</div>";
							html.quantite = qt;
							html.nom = nom['fr'];
							html.prixTVA = html.prix*(1+html.Tauxtva/100);
							tableauJson.push(html);
							var pretty = JSON.stringify(tableauJson);
							$("#listItem").val(pretty);
							total += qt*html.prix*(1+html.Tauxtva/100);
							//total = total.toFixed(2);
							global += qt*html.prix*(1+html.Tauxtva/100);
							//global = global.toFixed(2);
							$('.totalNumber').html(total.toFixed(2));
							$('.sommeGlobale').html(global.toFixed(2));
							tab += "</div>";
							
							$('.ticketContainer').append(tab);
							
							$('#ean').val("");
							$('#qt').val(1);
						}
					}
				}
			})
		}
	});
	
	$('#blackScreen').click(function(){
		$(this).fadeOut();
		$('#formRemiseEur, #formRemisePourcent, #formPaiementCash, #formPaiementCard, #formPaiementBancontact').fadeOut();
	})
	$('#remisePourcent').click(function(){
		$('#blackScreen').fadeIn();
		$('#formRemisePourcent').fadeIn();
	})
	$('#remiseEur').click(function(){
		$('#blackScreen').fadeIn();
		$('#formRemiseEur').fadeIn();
	});
	
	$("#paiementCash").click(function(){
		$("#blackScreen").fadeIn();
		$('#formPaiementCash').fadeIn();
		$("#valueCash").val(total.toFixed(2)).focus();
	})
	
	$("#paiementCard").click(function(){
		$("#blackScreen").fadeIn();
		$('#formPaiementCard').fadeIn();
		$("#valueCard").val(total.toFixed(2)).focus();
	})
	
	$("#paiementBancontact").click(function(){
		$("#blackScreen").fadeIn();
		$('#formPaiementBancontact').fadeIn();
		$("#valueBancontact").val(total.toFixed(2)).focus();
	})

	$('#formRemisePourcent').children("input").keydown(function(e){
		if(e.keyCode == "13")
		{
			$('#formRemisePourcent').children("button").click();
		}	
	})
	$('#formRemisePourcent').children("button").click(function(){
		$('#blackScreen').fadeOut();
		$('#formRemisePourcent').fadeOut();
		
		var value = parseFloat($('#formRemisePourcent').children("input").val());
		value = value.toFixed(2);
		var tab = "<div class='col-xs-12 ligne'>";
		tab += "<div style='font-weight: bold' class='col-xs-6'>Remise (%)</div><div style='font-weight: bold' class='col-xs-6'> - "+value+" %</div>";
		var pourcentage = (total/100)*value;
		var obj = new Object();
		obj.nom = "Remise (%)";
		obj.id = "###";
		obj.quantite = "1";
		obj.prix = -pourcentage;
		obj.type = "unique";
		obj.tva = "0";
		tableauJson.push(obj);
		var pretty = JSON.stringify(tableauJson);
		$("#listItem").val(pretty);
		
		
		total = total - pourcentage;
		//total = total.toFixed(2);
		global = global - pourcentage;
		//global = global.toFixed(2);
		$('.totalNumber').html(total.toFixed(2));
		$('.sommeGlobale').html(global.toFixed(2));
		tab += "</div>";
		$('.ticketContainer').append(tab);
	})
	
	$('#formRemiseEur').children("input").keydown(function(e){
		if(e.keyCode == "13")
		{
			$('#formRemiseEur').children("button").click();
		}	
	})
	$('#formRemiseEur').children("button").click(function(){
		$('#blackScreen').fadeOut();
		$('#formRemiseEur').fadeOut();
		
		var value = parseFloat($('#formRemiseEur').children("input").val());
		value = value.toFixed(2);
		var tab = "<div class='col-xs-12 ligne'>";
		tab += "<div style='font-weight: bold' class='col-xs-6'>Remise (€)</div><div style='font-weight: bold' class='col-xs-6'> - "+value+" €</div>";
		var pourcentage = value;
		total = total - pourcentage;

		var obj = new Object();
		obj.nom = "Remise (€)";
		obj.id = "###";
		obj.quantite = "1";
		obj.prix = -pourcentage;
		obj.tva = "0";
		obj.type = "unique";
		tableauJson.push(obj);
		var pretty = JSON.stringify(tableauJson);
		$("#listItem").val(pretty);
		
		//total = total.toFixed(2);
		global = global - pourcentage;
		//global = global.toFixed(2);
		$('.totalNumber').html(total.toFixed(2));
		$('.sommeGlobale').html(global.toFixed(2));
		tab += "</div>";
		$('.ticketContainer').append(tab);
	})	
	
	$('#formPaiementCash').children("input").keydown(function(e){
		if(e.keyCode == "13")
		{
			$('#formPaiementCash').children("button").click();
		}	
	})
	$('#formPaiementCash').children("button").click(function(){
		$('#blackScreen').fadeOut();
		$('#formPaiementCash').fadeOut();
		
		var value = parseFloat($('#formPaiementCash').children("input").val());

		value = value.toFixed(2);
		
		cash = value;
		var tab = "<div class='col-xs-12 ligne'>";
		tab += "<div style='font-weight: bold' class='col-xs-6'>Cash</div><div style='font-weight: bold' class='col-xs-6'> - "+value+" €</div>";
		var pourcentage = value;
		total = total - pourcentage;
		//total = total.toFixed(2);
/*
		global = global - pourcentage;
		global = global.toFixed(2);
*/
		$('.totalNumber').html(total.toFixed(2));
		tab += "</div>";
		$('.ticketContainer').append(tab);
		if(total <= 0)
		{
			register_ticket();
		}
	})
	
	$('#formPaiementCard').children("input").keydown(function(e){
		if(e.keyCode == "13")
		{
			$('#formPaiementCard').children("button").click();
		}	
	})

	$('#formPaiementCard').children("button").click(function(){
		$('#blackScreen').fadeOut();
		$('#formPaiementCard').fadeOut();
		
		var value = parseFloat($('#formPaiementCard').children("input").val());
		value = value.toFixed(2);
		card = value;
		//alert(card)
		var tab = "<div class='col-xs-12 ligne'>";
		tab += "<div style='font-weight: bold' class='col-xs-6'>Carte de crédit</div><div style='font-weight: bold' class='col-xs-6'> - "+value+" €</div>";
		var pourcentage = value;
		total = total - pourcentage;
		//total = total.toFixed(2);
		$('.totalNumber').html(total.toFixed(2));
		tab += "</div>";
		$('.ticketContainer').append(tab);
		if(total <= 0)
		{
			register_ticket();
		}
	})
	
	$('#formPaiementBancontact').children("input").keydown(function(e){
		if(e.keyCode == "13")
		{
			$('#formPaiementBancontact').children("button").click();
		}	
	})
	$('#formPaiementBancontact').children("button").click(function(){
		$('#blackScreen').fadeOut();
		$('#formPaiementBancontact').fadeOut();
		
		var value = parseFloat($('#formPaiementBancontact').children("input").val());
		value = value.toFixed(2);
		bct = value;
		var tab = "<div class='col-xs-12 ligne'>";
		tab += "<div style='font-weight: bold' class='col-xs-6'>Bancontact</div><div style='font-weight: bold' class='col-xs-6'> - "+value+" €</div>";
		var pourcentage = value;
		total = total - pourcentage;
		//total = total.toFixed(2);
		$('.totalNumber').html(total.toFixed(2));
		tab += "</div>";
		$('.ticketContainer').append(tab);
		if(total <= 0)
		{
			register_ticket();
		}
		
		
	})
	
    function PrintElem(elem, numero)
    {
        Popup($(elem).html(), numero);
    }

    function Popup(data, numero)
    {
	    var today = new Date();
	    var dd = today.getDate();
		var mm = today.getMonth()+1; //January is 0!
		var yyyy = today.getFullYear();
		if(dd<10) {
		    dd='0'+dd
		}
		if(mm<10) {
		    mm='0'+mm
		}
		today = dd+'/'+mm+'/'+yyyy;
        var mywindow = window.open('', 'new div', 'height=1000,width=800');
 
 		
 
        
        mywindow.document.write('<html><head><title>my div</title>');
        mywindow.document.write('<link rel="stylesheet" href="CSS/bootstrap.min.css" type="text/css" /><link rel="stylesheet" href="CSS/caisse_print.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write("<img src='content/logo/logo.png' style='max-width: 100%; max-height: 100px; display: block; margin: auto'/>");
        mywindow.document.write("<p style='font-size: 10px; margin-top: 10px; margin-bottom: 10px;'>LC BY Letizia Cirri<br/>Chaussée de Tongres 382<br/>4450 Juprelle<br/>Belgique</p><p style='font-size: 10px;'>ticket #"+numero+"<br/>"+today+"</p>");
        mywindow.document.write(data);
        mywindow.document.write("<div class='col-xs-12 ligne' style='margin-bottom: 20px; border-top: 1px solid black'><div class='col-xs-6'>Total</div><div class='col-xs-6'>"+global.toFixed(2)+"</div></div>")
        mywindow.document.write("<p style='margin-top: 30px; margin-bottom: 30px; font-size: 14px; font-weight: bold; text-align: center' >Merci de votre visite et à bientôt !</p><br/><p style='font-size: 10px; text-align: center'>Retrouvez-nous sur notre site web<br/>www.letiziacirri.be<br/><br/><br/></p>");
        mywindow.document.write('</body></html>');

		setTimeout(function(){
			mywindow.print();
			//window.location.reload(true);
			mywindow.close();
			window.location.reload(true);			
		}, 1000)


        return true;
    }	
	
	if($('#printAllTicket').length >= 1)
	{
		var mywindow = window.open('', 'new div', 'height=1000,width=800');
		mywindow.document.write('<link rel="stylesheet" href="CSS/caisse_print.css" type="text/css" />');
		mywindow.document.write($('#printAllTicket').html());
		
		setTimeout(function(){
			mywindow.print();
			//window.location.reload(true);
			mywindow.close();
			window.location.href = "caisse.php";			
		}, 1000)		
		
	}
	
	function register_ticket()
	{
		if(total <= 0)
		{
			total = total * -1;
		}
 		$('#blackScreen').fadeIn();
 		var tab = "<div class='col-xs-12 ligne'>";
 		tab += "<div style='font-weight: bold' class='col-xs-6'>Rendu</div><div style='font-weight: bold' class='col-xs-6'>"+total.toFixed(2)+" €</div>";
		tab += "</div>";
		$('.ticketContainer').append(tab);
		//$('#formEnded').fadeIn();
		//$('.rendu').html(total.toFixed(2));
		
		
/*

		alert(card)
		alert(bct)
		alert(cash)
*/

		$.ajax({
			url: "ajax/caisse.php",
			type: "POST",
			data: {
				produits: $('#listItem').val(),
				caissier: $('#caissier').val(),
				caisse: "1",
				action: "save",
				ticket: $('#printableArea').html(),
				total: $('.sommeGlobale').text(),
				card : card,
				bct : bct,
				cash: cash
			}
		}).done(function(html){
			PrintElem("#printableArea", html);
		});


		
			
		
		
	}
	
	
	
})