<!DOCTYPE html>
<html>
<head>
	<title>Oh! Pilot - Ajouter du contenu</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?=$includeJSAndCSS;?>
</head>
<body>
<div class='container-fluid'>

	<?php
		include("includes/menu.php");
	?>
	<div id='wrapper' class='col-sm-10'>
		<h2 class='cadre'><div class='container'><span class='h2titre'>Ajouter une page</span></div></h2>
		
		<div id='preview' class='col-md-12'>
		</div>
		<form id='formulaireGeneral' method='POST' enctype='multipart/form-data' class='col-md-12'>
		<?php
			$contenu = new addContent();
		?>
		</form>
	</div>
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
</body>
</html>

