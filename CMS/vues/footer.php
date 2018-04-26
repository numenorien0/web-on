<!DOCTYPE html>
<html>
<head>
	<title>Geronimo - Personnalisation du footer</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?=$includeJSAndCSS;?>
</head>
<body>
<div class='container-fluid'>
	<?php
		include("includes/menu.php");
	?>
	<div id='wrapper' class='col-sm-10'>
		<h2 class='cadre'><div class='container'>Personnalisation du pied de page</div></h2>

		
		<form method='POST' id='formulaireGeneral' enctype='multipart/form-data' class='col-sm-12 col-lg-10 col-lg-offset-1'>

			<?php
				$footer = new Footer();		
			?>
			<div class='cadre row'>
			<?php
				echo $footer->display_all_language();
			?>
				<input type='submit' value='enregistrer' name='submitFooter' style='float: right'/>
			</div>

			<div class='row cadre'>
				<h3>Sélectionnez le nombre de colonne à afficher dans le footer</h3>
				<?php					
					
					$footer->displayFormulaire();	
				?>
			</div>
			<div class='row cadre' id='apercu'>
				<h3>Aperçu</h3>
				<?php
					$footer->display_all_rendu();	
				?>
			</div>
			<div class='row cadre'>
				<h3>Editeur</h3>
				<textarea id="tinyMCE" class='tinyMCE'></textarea>
			</div>
			<?php
				$footer->display_all_textarea();	
			?>
		</form>
	</div>
</div>

</body>
</html>

