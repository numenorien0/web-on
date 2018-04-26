<!DOCTYPE html>
<html>
<head>
	<title>Geronimo - Liste des médias</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?=$includeJSAndCSS;?>
</head>
<body>
<div class='container-fluid'>
	<?php
		#include("includes/menu.php");
		$medias = new listMedias();
	?>
	<div id='wrapper' class='col-sm-12'>
<!-- 		<h2 class='cadre'><div class='container'>Liste des galeries</div></h2> -->
<!--
		<div class='col-sm-12 col-lg-10 col-lg-offset-1 ongletMedias'>
			<div class='onglet' data-link="photo"><a href='?type=photo'>Albums photos</a></div>
			<div class='onglet' data-link="video"><a href='?type=video'>Vidéos</a></div>
			<div class='onglet' data-link="fichier"><a href='?type=fichier'>Fichiers</a></div>
		</div>
-->

		
		<div class='listMedia colonneGauche col-sm-12 col-lg-10 col-lg-offset-1'>
			<div class='col-sm-12 cadre'>
			<h3>Liste des fichiers</h3>
				<div class='btnAdd'>	
					<a class='createPage' href='<?=$_GET['tools']?>&page=addMedias&type=fichier'>+ Ajouter un nouveau fichier</a>
				</div>
				<?php
					$medias->listAllFichier();
				?>
				
			</div>
		</div>
	</div>
</div>
</body>
</html>

