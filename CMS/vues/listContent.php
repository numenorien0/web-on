<!DOCTYPE html>
<html>
<head>
	<title>Oh! Pilot - Liste du contenu</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?=$includeJSAndCSS;?>
</head>
<body>
<div class='container-fluid'>
	<?php
		include("includes/menu.php");
	?>
	<div id='wrapper' class='col-sm-10'>
		<h2 class='cadre'><div class='container'>Liste des pages</div></h2>
		
		<form method='POST' enctype='multipart/form-data' class='col-sm-12 col-lg-10 col-lg-offset-1'>
		<?php
			$contenu = new listContent();
			
		?>
		
		<div class='col-sm-1 backMove'>Précédent</div><div class='col-sm-1 pull-right nextMove'>Suivant</div>
		</form>
	</div>
</div>

</body>
</html>

