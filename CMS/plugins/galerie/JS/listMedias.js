$(function(){
	$('.child, .edit').click(function(){
		window.location.href = 'outils.php?tools=galerie&page=editMedias&id='+$(this).attr('data-id');
	});

	$('.child2').click(function(){
		window.location.href = 'outils.php?tools=galerie&page=editMedias'+$(this).attr('data-id');
	});

	$('.delete').click(function(){

		var lienToDelete = $(this).attr('data-id');
		bootbox.confirm("Voulez-vous vraiment supprimer ce média?", function(result){
		if(result == true)
		{
			window.location.href = lienToDelete;
		}
		});

	});

	$('.toggle').click(function(){
/*
		if($(this).text() == "Afficher la liste")
		{
			$(this).text("Masquer la liste");
			$(this).parent().parent().children(".ligne").toggle();
		}
		else
		{
			$(this).text("Afficher la liste");
			$(this).parent().parent().children(".ligne").toggle();
		}
*/
	});
	
	var valeurType = $('#type').val();
	
	$('.onglet').each(function(){
		if($(this).attr('data-link') == valeurType)
		{
			$(this).addClass("active");
			//$(this).css({"text-decoration": "none","background-color": "#60c466","box-shadow":"0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24)"});
			//$(this).children("a").css({"color": "white !important"});
		}
	})

})