$(function(){
	$('#getUpdate').click(function(){
		$('#infoUpdate').text("Mise à jour en cours, ne pas rafraichir...");
		$('#infoUpdate').css({"color":"green"});
		
		$.ajax({
			url: 'update.php',
			type: 'GET',
			data: {getUpdate: 'true'},
		})
		.done(function() {
			alert("Votre CMS a été mis à jour!");
			var link = 'options.php?updateDB=true';
			window.location.href = link;
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {

		});
		
	})
	
	$('.deleteDomaine').click(function(){
		var domaineASupprimer = $(this).attr('data-id');
		
		bootbox.confirm("Voulez-vous vraiment supprimer ce nom de domaine?", function(result){
		if(result == true)
		{
			window.location.href = "options.php?deleteDomaine="+domaineASupprimer;
		}
		})
			
	});
	
	$('.whatsnews').click(function(e){
		e.stopPropagation();
		$('.whatsnewsContainer').fadeIn();
		$('.blackScreen').fadeIn();
		
		$('html').click(function(){
			$('.whatsnewsContainer, .blackScreen').fadeOut();	
		});
		$('.whatsnewsContainer').click(function(e){
			e.stopPropagation();
		})	
	});
	
	$('.langueSelect').change(function(){
		$('.addLanguageForm').submit();
	});
	
})