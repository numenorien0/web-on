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
		include("includes/menu.php");
		$medias = new listMedias();
		;
		if($_GET['type'] == "")
		{
			$valeurPage = "photo";
		}
		else
		{
			$valeurPage = $_GET['type'];
		}
		echo "<input type='hidden' value='".$valeurPage."' id='type'/>";
	?>
	<div id='wrapper' class='col-sm-10'>
		<h2 class='cadre'><div class='container'>Liste des médias</div></h2>
		<div class='col-sm-12 col-lg-10 col-lg-offset-1 ongletMedias cadre'>
			<div class='onglet' data-link="photo"><a href='?type=photo'>Albums photos</a></div>
			<div class='onglet' data-link="video"><a href='?type=video'>Vidéos</a></div>
			<div class='onglet' data-link="fichier"><a href='?type=fichier'>Fichiers</a></div>
		</div>
		
		<?php
		
		if($_GET['type'] == "photo" OR !isset($_GET['type']))
		{
			
		?>
		
		<div class='listMedia colonneGauche col-sm-12 col-lg-10 col-lg-offset-1'>
			<div class='col-sm-12 cadre'>
			<h3>Liste des albums Photos</h3>
				<div class='btnAdd'>	
					<a class='createPage' href='addMedias.php?type=photo'>+ Ajouter un nouvel album</a>
				</div>
				<?php
					$medias->listAllPhoto();
				?>
				
			</div>
		</div>

		<?php
		}
		if($_GET['type'] == "video")
		{	
		?>

		<div class='listMedia colonneDroite col-sm-12 col-lg-10 col-lg-offset-1'>
			<div class='col-sm-12 cadre'>
			<h3>Liste des vidéos</h3>
				<div class='btnAdd'>
					<a class='createPage' href='addMedias.php?type=video'>+ Ajouter une nouvelle vidéo</a>
				</div>
				<?php
					$medias->listAllVideo();
				?>
				
			</div>
		</div>
		<?php
		}
		if($_GET['type'] == "fichier")	
		{
		?>
		<div class='listMedia colonneDroite col-sm-12 col-lg-10 col-lg-offset-1'>
			<div class='col-sm-12 cadre'>
			<h3>Liste des fichiers</h3>
				<div class='btnAdd'>
					<a class='createPage' href='addMedias.php?type=fichier'>+ Ajouter un nouveau fichier</a>
				</div>
				<?php
					$medias->listAllFichier();
				?>
				
			</div>
		</div>		
		<?php
		}
		?>
	</div>
</div>
</body>
</html>

