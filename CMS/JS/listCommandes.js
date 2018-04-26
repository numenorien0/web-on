$(function(){
	
	$('.return-number').hide();
	$('.fa-exclamation-circle').hover(function(){
		var ID = $(this).attr('data-id');
		$('.return-number-'+ID).show();
		
		$(this).mouseout(function(){
			$('.return-number').hide();
		})
	})
	
	$('.selectRefund').click(function(){
		
		var FOR = $(this).attr('data-for');
		var id = $(this).attr('data-id');
		var refundAmount = $(this).attr('data-price');
		var amount = $('.valueRefund').val()
		var id_produit = $(this).attr('data-product');
		var produit = $('.products-'+id).val();
		
		if($('.this-'+id+"-"+FOR).hasClass('selected'))
		{
			$('.this-'+id+"-"+FOR).removeClass("selected")
			$('.valueRefund').val(Math.round((parseFloat(amount)*100)-(parseFloat(refundAmount)*100),-1)/100)
			var split = produit.split("-");
			var newPP = split.splice($.inArray(id_produit, split),1);
			var implode = split.join('-')
			$('.products-'+id).val(implode);
			
			
		}
		else
		{
			if($('.products-'+id).val() == '')
			{
				$('.products-'+id).val(id_produit)
			}
			else
			{
				$('.products-'+id).val(id_produit+'-'+produit)
			}
			$('.this-'+id+"-"+FOR).addClass("selected")
			$('.valueRefund').val(Math.round((parseFloat(amount)*100)+(parseFloat(refundAmount)*100),-1)/100);
			$('.partialRefund').prop("checked", true);
			//alert(Math.round(parseFloat(amount)+parseFloat(refundAmount),-1))
		}
		
	})
	
	if($('#hiddenIDEtiquette').length > 0)
	{
		var valueToPrint = $('#hiddenIDEtiquette').val();
		valueToPrint = valueToPrint.split("-");
		$("<div id='groupToPrint' style='display: none'></div>").insertAfter(".menuEcommerce");
		console.log(valueToPrint);
		$.each(valueToPrint, function(i,v){
			console.log("ok");
			//$('#com-'+v).show().appendTo("#groupToPrint");
			var element = $('#com-'+v).clone();
			$(element).appendTo("#groupToPrint").removeAttr("id").css({"display":"block"});
		})		
		
		printContent("groupToPrint")
		
	}
/*
	
	$('input[name=refundType]').change(function(){
		if(this.value == "partiel")
		{
			$('.valueRefund').focus();
			$('.valueRefund').val('');
		} 
		
		
	})
*/
	
/*
	$('#valueRefund').focus(function(){
		$( "#partialRefund" ).prop( "checked", true );
	})
*/
	
	
	var table = $('#tabCommandes').DataTable({
    	"language": {
			"url": "https://cdn.datatables.net/plug-ins/1.10.13/i18n/French.json"
		},
		"lengthMenu": [[50, 100, 200, -1], [50, 100, 200, "All"]]
	});
	
	function obtenirParametre (sVar) {
		return unescape(window.location.search.replace(new RegExp("^(?:.*[&\\?]" + escape(sVar).replace(/[\.\+\*]/g, "\\$&") + "(?:\\=([^&]*))?)?.*$", "i"), "$1"));
	}

	if(obtenirParametre("filter") != '')
	{
		table.search(obtenirParametre("filter")).draw();
	}
	
	$('.statut-filtre').click(function(){
		$('.statut-filtre').removeClass("active");
		$(this).addClass("active");
		var filtre = $(this).attr('id');
		table.search( filtre ).draw();
		
	})
	
	var generateEnabled = false;
	var allID = new Array();
	$('.checkCommandes').change(function(){
		allID = new Array();
		$('.checkCommandes').each(function(){
			if($(this).is(":checked"))
			{
				allID.push($(this).attr('data-id'))
			}
		});
		
		allID = allID.join("-");
		
		$('.export').attr('data-link', allID);
	
		if($('#tabCommandes input:checkbox:checked').length > 0)
		{
			$('#generateAllTicket').show();
		}
		else
		{
			$("#generateAllTicket").hide();
		}		
	});
	
	$('.export').click(function(e){
		e.preventDefault();
		window.location.href = $(this).attr('href')+"&id="+$(this).attr('data-link');
	})
	
	$('.alert-warning.statut').hover(function(){
		$(this).removeClass('alert-warning')
		$(this).addClass('alert-success');	
		$(this).html('<i class="fa fa-arrow-right" aria-hidden="true"></i> Expédiée')
	}).mouseout(function(){
		$(this).addClass('alert-warning')
		$(this).removeClass('alert-success');
		$(this).html('En préparation')
	})
	
	$('.alert-info.statut').hover(function(){
		$(this).removeClass('alert-info')
		$(this).addClass('alert-warning');	
		$(this).html('<i class="fa fa-arrow-right" aria-hidden="true"></i> En préparation')
	}).mouseout(function(){
		$(this).addClass('alert-info');
		$(this).removeClass('alert-warning')
		$(this).html('En attente')
	})
	
	$('.alert-danger.statut').hover(function(){
		$(this).removeClass('alert-danger')
		$(this).addClass('alert-info');	
		$(this).html('<i class="fa fa-arrow-right" aria-hidden="true"></i> En attente')
	}).mouseout(function(){
		$(this).addClass('alert-danger');
		$(this).removeClass('alert-info')
		$(this).html('Annulée')
	})
	

	$('.alert.statut').click(function(){
		var stat = $(this).attr('data-statut');
		var celuici = $(this);
		var id = $(this).attr('data-id');
		var total = $(this).attr('data-total');
		var produit = $(this).attr('data-produit');
		var num = $(this).attr('data-num');

		//alert(produit);

		 $.ajax({
		    	url: "ecommerce.php", // Le nom du fichier indiqué dans le formulaire
		        type: "POST", // La méthode indiquée dans le formulaire (get ou post)
		        data: {
			    	statut: stat,
			    	id: id, 
			    	total: total,
			    	produit: produit,
			    	num: num
			    }
		})


		
			
			if(stat == 'expédiée')
			{
				
				$(celuici).removeClass('alert-warning');
				$(celuici).addClass('alert-success');	
				$(celuici).html('Expédiée');
				$(celuici).attr('data-statut', 'expédiée');
				$('.alert-success').hover(function(){
					$(this).html('Expédiée')
				}).mouseout(function(){
					$(this).html('Expédiée')
					$(this).removeClass('alert-warning')
					$(this).addClass('alert-success')
				})
			}
			

			if(stat == 'en attente')
			{
				
				$(celuici).removeClass('alert-danger');
				$(celuici).addClass('alert-info');	
				$(celuici).html('En attente');
				$(celuici).attr('data-statut', 'en préparation');
				
				$('.alert-info').hover(function(){
					$(this).removeClass('alert-info')
					$(this).addClass('alert-warning');	
					$(this).html('<i class="fa fa-arrow-right" aria-hidden="true"></i> En préparation')
				}).mouseout(function(){
					$(this).addClass('alert-info')
					$(this).removeClass('alert-warning');
					$(this).removeClass('alert-danger');
					$(this).html('En attente')
				})
			}

			
			if(stat == 'en préparation')
			{
				
				$(celuici).removeClass('alert-info');
				$(celuici).addClass('alert-warning');	
				$(celuici).html('En préparation');
				$(celuici).attr('data-statut', 'expédiée');
				
				$('.alert-warning').hover(function(){
					$(this).removeClass('alert-warning')
					$(this).addClass('alert-success');	
					$(this).html('<i class="fa fa-arrow-right" aria-hidden="true"></i> Expédiée')
				}).mouseout(function(){
					$(this).addClass('alert-warning')
					$(this).removeClass('alert-success');
					$(this).removeClass('alert-info');
					$(this).html('En préparation')
				})
			}
			
		
		
		    
	})
	
	
	
	$('.test').click(function(){
		var id = $(this).attr('data-id');
		
	});

})
function printContent(div) 
{
	var divToPrint= document.getElementById(div);
	
	var newWin=window.open('','Print-Window');
	
	newWin.document.open();
	
	newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
	
	newWin.document.close();
	
	setTimeout(function(){newWin.close();},10);

}