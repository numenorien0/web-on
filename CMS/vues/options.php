<!DOCTYPE html>
<html>
<head>
	<title>Oh! Pilot - Options du système</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?=$includeJSAndCSS;?>
</head>
<body>
<div class="container-fluid">
	<?php
		include("includes/menu.php");
		include("includes/mail.php");
		$options = new Options();
		$update = new Update();
	?>
	<div class='blackScreen'>
	</div>
	<div class='whatsnewsContainer'>
		<?php
			$options->listFeature();
		?>
	</div>
	<div class='col-sm-10' id='wrapper'>
		<h2 class='cadre'><div class='container'>Options</div></h2>
		<div class='colonneContainer col-sm-12 col-lg-10 col-lg-offset-1'>
		<div class='col-sm-6 colonneGauche colonne'>
			<div class='col-sm-12 optionCadre'>
				<form method="POST" class='col-sm-12 cadre option'>
					<h3>Mise à jour</h3>
					<?php
						if($update->checkUpdate())
						{
							echo "<div class='fail' id='infoUpdate'>Une mise à jour est disponible</div>";
							echo '<input type="button" id="getUpdate" class="col-lg-2 col-lg-offset-5 col-sm-6 col-sm-offset-3" value="Mettre à jour"/>';
						}
						else
						{
							echo "<div class='success'>Votre CMS est à jour</div>";
							echo "<a class='whatsnews' href='#'>Liste des nouveautés de la version ".$_SESSION['version']."</a>";
						}
					?>	
				</form>
			</div>


			<div class='col-sm-12 optionCadre'>
				<form method="POST" class='col-sm-12 cadre option' action>
					<h3>Activer le mode avancé</h3>
					<?php
						$options->advancedMod();
					?>
					<input type="submit" class='col-lg-2 col-lg-offset-5 col-sm-6 col-sm-offset-3' name="advancedModChange" value="Valider"/>
				</form>
			</div>
			<div style='display: none' class='col-sm-12 optionCadre'>
				<form method="POST" class='col-sm-12 cadre option' action>
					<h3>E-commerce</h3>
					<?php
						//$options->ecommerce();
					?>
					<input type="submit" class='col-lg-2 col-lg-offset-5 col-sm-6 col-sm-offset-3' name="changeEcommerce" value="Valider"/>
				</form>
			</div>
		</div>

		<div class='col-sm-6 colonneDroite colonne'>
			<div class='col-sm-12 optionCadre'>
				<form method="POST" action class='col-sm-12 cadre option'>
				<h3>Protection contre force brute (hacking)</h3>
					<?php
						$options->security_force_brute();
					?>
					<input type="submit" <?=$options->_disabled;?> class='col-lg-2 col-lg-offset-5 col-sm-6 col-sm-offset-3' name="forceBruteChange" value="Valider"/>
				</form>
			</div>
			<div class='col-sm-12 optionCadre'>

				<form method="POST" class='col-sm-12 cadre option' action>
					<h3>Domaines</h3>
					<span class='col-sm-12 explications'><img src='images/caution2.png'/><span class='col-sm-10'>L'ajout d'un nom de domaine vous permettra d'autoriser ce nom de domaine à collecter des statistiques</span></span>
					<?php
						$options->Domaine();
					?>
					<label class='col-lg-4 col-sm-6' for='passwordOld'>Ajouter un domaine</label><input type="text" class='col-sm-4 col-lg-6' name="addDomain" />
					<input class='col-lg-2 col-lg-offset-5 col-sm-6 col-sm-offset-3' type="submit" name="domaine" <?=$options->_disabled;?> value="valider"/>
				</form>

			</div>
		</div>
	</div>
</div>
</body>
</html>

