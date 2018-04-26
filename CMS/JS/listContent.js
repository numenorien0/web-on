$(function(){

	
	var numberItem = $('#numberItem').val();
	
	$(".numberItemSelect select option").each(function(){
		if($(this).text() == numberItem)
		{
			$(this).prop('selected', true);
		}
	})
	
	$('.numberItemSelect select').change(function(){
		if($(this).val() != numberItem)
		{
			window.location.href = "listContent.php?parent="+$("#parentHidden").val()+"&numberItem="+$(this).val();
		}
	})
	
	
	
	$( "#containerLigne" ).sortable({
		start: function(event, ui){
			$(ui.item).css({"transform":"scale(1.02)", "box-shadow":"0px 0px 20px rgba(0,0,0,0.3)", "background-color":"white", "border-radius":"4px"});
			$(ui.item).children(".openRepertoire").css({"background-color":"white"});
		},
		stop: function(event, ui){
			//console.log(ui);
			$(ui.item).css({"transform":"scale(1)", "box-shadow":"0px 0px 0px rgba(0,0,0,0)", "background-color":"white", "border-radius":"4px"});
			var order = $(ui.item).next().attr('data-order');
			var parent = $(ui.item).next().attr('data-parent');
			var IDitem = $(ui.item).children(".openRepertoire").attr('data-alias');
			var tableauClassement = new Array();
			$('.ligne').each(function(){
				tableauClassement.push($(this).children(".openRepertoire").attr('data-alias'));
			})
			
			//console.log(tableauClassement);
			
			//console.log(ID);
			$.ajax({
				url: "changePlace.php",
				method: "POST",
				data: {'tableau': tableauClassement, 'parent': parent},
				success: function(html){
					console.log(html);
					window.location.reload(false);
				}
			})
		}
	});

	$('.openRepertoire').click(function(){
		
		window.location.href = 'editContent.php?id='+$(this).attr('data-id')
	});

	$('.delete').click(function(){

		var lienToDelete = $(this).attr('data-id');
		bootbox.confirm("Voulez-vous vraiment supprimer cette page?", function(result){
			if(result == true)
			{
				window.location.href = lienToDelete;
			}
		});
		
	});

	$('.edit').click(function(){
		var id = $(this).attr('data-id');
		window.location.href = 'listContent.php?parent='+id;
	});
	
	$('.view').click(function(){
		var id = $(this).attr('data-id');
		var win = window.open('../fr/'+id+'/', '_blank');
		win.focus();
	})
	
	
	var nombreDeLigneMin = 0;
	var nombreDeLigneMax = numberItem;
	$('.backMove, .nextMove').hide();
	var nombreLigne = 0;
	var nombreTotalLigne = $('.visiblePage').length - 1;

	function limiterAffichage()
	{
		nombreDeLigneMin = 0;
		nombreDeLigneMax = numberItem;
		$('.backMove, .nextMove').hide();
		nombreLigne = 0;
		nombreTotalLigne = $('.visiblePage').length - 1;

		//alert(nombreTotalLigne);

		if($('.visiblePage').length > numberItem)
		{
			$('.nextMove').show();
			$('.visiblePage').each(function(){
				if(nombreLigne >= nombreDeLigneMin && nombreLigne < nombreDeLigneMax)
				{
					$(this).show();
				}
				else
				{
					$(this).hide();
				}
				nombreLigne++;
			})
		}
	}

	if(numberItem != "Tous")
	{
		limiterAffichage();
	}
	
	$('.nextMove').click(function(){
		nextMove();
	})
	$('.backMove').click(function(){
		prevMove();
	})

	function nextMove()
	{
		$('.backMove').show();
		nombreDeLigneMin = nombreDeLigneMin+numberItem;
		nombreDeLigneMax = nombreDeLigneMax+numberItem;
		nombreLigne = 0;

		$('.visiblePage').each(function(){
			if(nombreLigne >= nombreDeLigneMin && nombreLigne < nombreDeLigneMax)
			{
				$(this).show();
			}
			else
			{
				$(this).hide();
			}
			nombreLigne++;
		})

			if($('.visiblePage').eq(nombreTotalLigne).css("display") != "none")
			{
				$('.nextMove').hide();
			}
	}

	function prevMove()
	{
		$('.nextMove').show();
		nombreDeLigneMin = nombreDeLigneMin-numberItem;
		nombreDeLigneMax = nombreDeLigneMax-numberItem;
		nombreLigne = 0;

		$('.visiblePage').each(function(){
			if(nombreLigne >= nombreDeLigneMin && nombreLigne < nombreDeLigneMax)
			{
				$(this).show();
			}
			else
			{
				$(this).hide();
			}
			nombreLigne++;
		})

			if($('.visiblePage').eq(0).css("display") != "none")
			{
				$('.backMove').hide();
			}
	}


})