<!DOCTYPE html>
<html>
<head>
	<title>Oh! Pilot - Gestion des utilisateurs</title>
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
				<form method="POST" action class='cadre col-sm-12 option'>
					<h3>Ajouter un nouvel utilisateur</h3>
					<?php 
						$options->newUser();
					?>
					<div class='row'><label class='col-lg-4 col-sm-4' for='passwordOld'>Nouveau login</label><input type="text" name="login" class='col-sm-6 col-lg-6' value='<?=@$_POST["login"]?>' /></div>
					<div class='row'><label class='col-lg-4 col-sm-4' for='passwordOld'>E-mail</label><input type="email" name="mail" class='col-sm-6 col-lg-6' value='<?=@$_POST["mail"]?>' placeholder="Entrez l'adresse mail" /></div><br/>
					<div class='row allPermissions'><label class='col-lg-6 col-sm-6' for='permission'>Toutes les autorisations ?</label><input type="checkbox" class='col-sm-2 col-lg-2' name='permission'/></div><br/>
					<div class='row'><label class='col-sm-4' for='rang'>Rang</label>
						<select name='rang' class='col-sm-6'>
							<option value='administrateur'>Administrateur</option>
							<option value='redacteur'>Rédacteur</option>
						</select> </div>
					<?=$options->_btnAddUser;?>
				</form>
			</div>
		</div>

		<div class='col-sm-6 colonneDroite colonne'>

			<div class='col-sm-12 optionCadre'>
				<form method="POST" class='col-sm-12 cadre option' action>
					<h3>Liste des utilisateurs</h3>
					<?php
						$options->deleteUser();
					?>

				</form>
			</div>
		</div>
	</div>
</div>
</body>
</html>

