$(function(){
	
	$('#fakeButtonLogo').click(function(){
		$('#realButtonLogo').click();
	});
	
	$('#realButtonLogo').change(function(){
		var valeurFichierCache = $(this)[0].files[0].name;
		$('#fakeButtonLogo').val(valeurFichierCache);
	});
	
	$('#fakeButtonFavicon').click(function(){
		$('#realButtonFavicon').click();
	});
	
	$('#realButtonFavicon').change(function(){
		var valeurFichierCache = $(this)[0].files[0].name;
		$('#fakeButtonFavicon').val(valeurFichierCache);
	});	
	
	
})