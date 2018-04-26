$(function(){

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
				$('.alert-success').hover(function(){
					$(this).html('En préparation')
				}).mouseout(function(){
					$(this).html('En attente')
					$(this).removeClass('alert-warning')
					$(this).addClass('alert-info')
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

	
});