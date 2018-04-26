<!DOCTYPE html>
<html>
<head>
	<title>Geronimo - Options des pages</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?=$includeJSAndCSS;?>
</head>
<body>
<div class='container-fluid'>
	<?php
		include("includes/menu.php");
	?>
	<div id='wrapper' class='col-sm-10'>
		<h2 class='cadre'><div class='container'>Options des pages</div></h2>
		
		<div class='col-sm-8 col-sm-offset-2 cadre'>
		<h3>Liste des champs personnalisés</h3>
		<a class='createPage' href='listContent.php?parent=<?=$_GET['ID']?>'>Retour</a><br/><br/><br/>
		<?php
			$contenu = new optionsContent();
			$contenu->listAll();
		?>
		</div>
		
			<div class='col-sm-8 col-sm-offset-2 cadre' style="margin-top: 0px">
			<form method='POST' enctype='multipart/form-data' class=''>
			<h3>Ajouter un nouveau champs</h3>
			<?php
				$contenu->afficherFormulaire();
				
						
			?>
			</form>
			</div>
	</div>
</div>
</body>
</html>

