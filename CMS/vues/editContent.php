<!DOCTYPE html>
<html>
<head>
	<title>Oh! Pilot - Editer votre contenu</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src='JS/codemirror.js'></script>
	<?=$includeJSAndCSS;?>
</head>
<body>
<div class='container-fluid'>

	<?php
		include("includes/menu.php");
	?>
	
	<div id='wrapper' class='col-sm-10'>
		<?php
		$contenu = new editContent();	
		?>
		<h2 class='cadre'><div class='container'><span class='h2titre'>Editer votre page</span> <?=$contenu->contenu_recovery();?></div></h2>
		<div id='preview' class='col-md-12'>
		</div>
		<?php
			
			if(!isset($_GET['previous']))
			{
				echo "<input type='hidden' value='backup' id='backup'/>";
			}	
			
		?>
		<form id="formulaireGeneral" method='POST' action='editContent.php?id=<?=$_GET['id']?>' enctype='multipart/form-data' class='col-md-12'>
		
		<?php
			
			if(!isset($_GET['previous']))
			{
				$contenu->afficher();
			}
			else
			{
				$contenu->previousVersion();
			}
		?>
		</form>
	</div>
	
	<script>
	function parseJSONresponse(response, lang)
{
	var parsed;
	//alert(response);
	try{
		parsed = $.parseJSON(response)[lang];
		//alert($.parseJSON(response));
	}
	catch(e){
		
	}
	
	if(typeof parsed !== 'undefined')
	{
		return parsed;
	}
	else
	{
		return "";
	}
}
	    
	</script>
	
	
	
</div>
</body>
</html>

