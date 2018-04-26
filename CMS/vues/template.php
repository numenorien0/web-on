<!DOCTYPE html>
<html>
<head>
	<title>Oh! Pilot - Modèle de contenu</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?=$includeJSAndCSS;?>
</head>
<body>
<div class='container-fluid'>
	<?php
		include("includes/menu.php");
	?>
	<div id='wrapper' class='col-sm-10'>
		<h2 class='cadre'><div class='container'>Modèle de contenu</div></h2>

		<div class='col-sm-12 col-lg-10 col-lg-offset-1 cadre'>
			<h3>Liste de tous vos modèles</h3>
			<?php
				$template = new Template();
				$template->listAllTemplate();
			?>
			<br/><input type='button' value='Créer un nouveau Template' id='create'/>
		</div>
		
		<form method='POST' enctype='multipart/form-data' class='cadre col-sm-12 col-lg-10 col-lg-offset-1'>
		<h3>Editeur</h3>
			<input type='text' name='nom' placeholder="Le nom de votre modèle" id='nom' /><br/><br/>
			<textarea name="contenu" class='tinyMCE'></textarea><br/>
			<input type='submit' value="Sauvegarder" name="save"/>

		</form>
	</div>
</div>

</body>
</html>

