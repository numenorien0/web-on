<!DOCTYPE html>
<html>
<head>
	<title>Oh! Pilot - Gestion du site</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?=$includeJSAndCSS;?>
	<link rel="stylesheet" href="CSS/options.css"/>
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
				<form method="POST" action class='col-sm-12 cadre option'>
				<h3>Langue principale du site</h3>
					<?php
						$options->displayAllLanguage();
					?>
					<input type="submit" <?=$options->_disabled;?> class='col-lg-2 col-lg-offset-5 col-sm-6 col-sm-offset-3' name="changeLangage" value="Valider"/>
				</form>
			</div>
			<div class='col-sm-12 optionCadre'>
				<form method="POST" action class='addLanguageForm col-sm-12 cadre option'>
				<h3>Langues secondaires du site</h3>
					<?php
						$options->displayAdditionalLangages();
					?>
					<input type="submit" <?=$options->_disabled;?> class='col-lg-2 col-lg-offset-5 col-sm-6 col-sm-offset-3' id="addLangage"  name="addLangage" value="Valider"/>
				</form>
			</div>
			<div class='col-sm-12 optionCadre'>
				<form method="POST" action class='col-sm-12 cadre option' enctype="multipart/form-data">
					<h3>Favicon</h3>
					<div style='text-align: center'>
					<?php
						$options->favicon();
					?>	
					</div>
					<input type="submit" <?=$options->_disabled;?> class="col-lg-2 col-lg-offset-5 col-sm-6 col-sm-offset-3" name="favicon" value="Changer"/>
				</form>
			</div>

		</div>

		<div class='col-sm-6 colonneDroite colonne'>
			<div class='col-sm-12 optionCadre'>
				<form method="POST" action class='col-sm-12 cadre option'>
					<h3>Maintenance</h3>
					<?php
						$options->ReadStateMaintenance();
					?>	
					<input type="submit" class="col-lg-2 col-lg-offset-5 col-sm-6 col-sm-offset-3" name="maintenance" value="Changer"/>
				</form>
			</div>
			<div class='col-sm-12 optionCadre'>
				<form method="POST" action class='col-sm-12 cadre option' enctype="multipart/form-data">
					<h3>Logo du site</h3>
					<div style='text-align: center'>
					<?php
						$options->logo();
					?>	
					</div>
					<input type="submit" <?=$options->_disabled;?> class="col-lg-2 col-lg-offset-5 col-sm-6 col-sm-offset-3" name="logo" value="Changer"/>
				</form>
			</div>
			<div class='col-sm-12 optionCadre'>
				<form method="POST" action class='col-sm-12 cadre option' enctype="multipart/form-data">
					<h3>Titre du site</h3>
					<div style='text-align: center'>
					<?php
						$options->titre();
					?>	
					</div>
					<input type="submit" <?=$options->_disabled;?> class="col-lg-2 col-lg-offset-5 col-sm-6 col-sm-offset-3" name="titreSubmit" value="Changer"/>
				</form>
			</div>
			
			<div class='col-sm-12 optionCadre'>
				<form method="POST" action class='col-sm-12 cadre option' enctype="multipart/form-data">
					<h3>Réseaux sociaux du site</h3>
					<div style='text-align: center'>
					<?php
						$options->social();
					?>	
					</div>
					<input type="submit" class="col-lg-2 col-lg-offset-5 col-sm-6 col-sm-offset-3" name="socialSubmit" value="Changer"/>
				</form>
			</div>

		</div>
	</div>
</div>
</body>
</html>

