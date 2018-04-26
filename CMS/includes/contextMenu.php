<script>

$(function(){
	$('.clickToCut').click(function(){
		var elementACopier = localStorage.getItem("elementClicked");
		
		$('.log').html("Element avec la référence \"#"+elementACopier+"\" coupé !").fadeIn().delay(4000).fadeOut();
		localStorage.setItem("elementIntoTheClipboard", elementACopier);
		localStorage.setItem("actionClipBoard", "cut");
	});
	
	$('.clickToCopy').click(function(){
		var destination = $('#parentHidden').val();
		$('.log').html("Séquençage de l'ADN de la page...<br/>Clonage de la page...").fadeIn().delay(10000).fadeOut();
			
		var fichier = localStorage.getItem("elementClicked");
		
		bootbox.confirm("Voulez-vous vraiment cloner cette page et tous les éléments \"enfants\" ? ", function(result){
			if(result == true)
			{
				$.ajax({
					url: "movePage.php?action=duplicate&ID="+fichier+"&parent="+destination,
					type: "GET",
					success: function(html){
						window.location.reload();
					}
					
				})	
			}
		});
		
	})
	
	$('.clickToDelete').click(function(){
		var elementASupprimer = localStorage.getItem("elementClicked");


		var destination = $('#parentHidden').val();
		if(destination == "")
		{
			var lienToDelete = "?delete="+elementASupprimer;
		}
		else
		{
			var lienToDelete = "?parent="+$('#parentHidden').val()+"&delete="+elementASupprimer;
		}
		
		bootbox.confirm("Voulez-vous vraiment supprimer cette page?", function(result){
			if(result == true)
			{
				window.location.href = lienToDelete;
			}
		});

	})
	
	$('.createAnAlias').click(function(){
		var element = localStorage.getItem("elementClicked");
		
		var destination = $('#parentHidden').val();
		
		if(destination == "")
		{
			var lienToDelete = "?alias="+element;
		}
		else
		{
			var lienToDelete = "?parent="+$('#parentHidden').val()+"&alias="+element;
		}
		
		bootbox.confirm("Voulez-vous vraiment créer un alias de cette page?", function(result){
			if(result == true)
			{
				window.location.href = lienToDelete;
			}
		});		
		
	})
	
	$('.clickToEdit').click(function(){
		var elementACopier = localStorage.getItem("elementClicked");
		window.location.href = 'editContent.php?id='+elementACopier;
	})
	
	$('.clickToPaste').click(function(){
		if(!localStorage.getItem("elementIntoTheClipboard"))
		{
			$('.log').html("Il n'y a rien à copier !").fadeIn().delay(4000).fadeOut();
		}
		else
		{
			if(localStorage.getItem("actionClipBoard") == "cut")
			{
				var destination = $('#parentHidden').val();
				var value = "";
				if(destination == "")
				{
					value = "";
				}
				else
				{
					value = destination;
				}
				var fichier = localStorage.getItem("elementIntoTheClipboard");
				//alert(fichier);
				if(fichier == destination)
				{
					$('.log').html("Vous ne pouvez pas copier un fichier dans lui-même.").fadeIn().delay(4000).fadeOut();
				}
				else
				{
					$.ajax({
						url: "movePage.php?action=move&ID="+fichier+"&parent="+value,
						type: "GET",
						success: function(html){
							window.location.reload(false);
						}
						
					})
				}
			}
			if(localStorage.getItem("actionClipBoard") == "copy")
			{
				$('.log').html("Fonction pas encore disponible").fadeIn().delay(4000).fadeOut();
			}	
			
		}
		
		localStorage.removeItem("actionClipBoard");
		localStorage.removeItem("elementIntoTheClipboard");
		localStorage.removeItem("elementClicked");
		
	})
	
})	
	
	
</script>
<menu id="contextListe" type="context" style="display:none">  
    <command label="coller" class='clickToPaste' icon="paste">
<!--     <command label="ne pas utiliser" onclick="alert('resize')" icon="images/door.png"> -->
</menu>
<menu id="contextAlias" type="context" style="display:none">  
    <command label="Couper" class='clickToCut' icon="cut">
<!--     <command label="ne pas utiliser" onclick="alert('resize')" icon="images/door.png"> -->
</menu>
<menu id="contextOpenRepertoire" type="context" style="display:none">  
    <command label="Dupliquer" class='clickToCopy' icon="copy">
    <command label="Couper" class='clickToCut' icon="cut">
     <hr>
    <command label="Créer un alias" class='createAnAlias' icon="copy">
    <hr>
<!--     <command label="Editer" class="clickToEdit" icon="edit"> -->
<!--     <hr> -->
    <command label="Supprimer" class="clickToDelete" icon="delete">
</menu>

