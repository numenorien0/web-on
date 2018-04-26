$(function(){
	$('#file_btn').click(function(){
		$('#file').click();
	});
	
	if($('#fichierEnvoye').length != 0)
	{
			Notification.requestPermission( function(status) {
			  console.log(status); // les notifications ne seront affichées que si "autorisées"
			  var n = new Notification("Pilot", {body: "Votre fichier a été téléchargé", icon: "images/favicon.png"}); // this also shows the notification
			});
	}


	$("#formulaireMedia").submit(function(){
		$("#valider").val("Envoi en cours...");
		bootbox.alert("Merci de patienter pendant le téléchargement de votre fichier. Ne rafraichissez pas la page.")
	})
		//e.preventDefault();
		//$("#valider").val("Envoi en cours...");
		//alert("Merci de patienter pendant le téléchargement de votre fichier. Ne rafraichissez pas la page.")
		
	
})