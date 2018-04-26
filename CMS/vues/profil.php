<!DOCTYPE html>
<html>
<head>
	<title>Oh! Pilot - Profil</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?=$includeJSAndCSS;?>
</head>
<body>
<div class='container-fluid'>
	<?php
		include("includes/menu.php");
		$profil = new Profil();
	?>
	<div id='wrapper' class='col-sm-10'>
		<h2 class='cadre'><div class='container'>Profil</div></h2>

		<div class='col-sm-6 col-lg-5 col-lg-offset-1 colonneGauche'>
			<div class='col-sm-12 cadre'>
				<h3>Votre profil</h3>
				<?php
					$profil->profil();
				?>
			</div>
		</div>
		<div class='col-sm-6 col-lg-5 colonneDroite'>
			<div class='col-sm-12 cadre optionCadre'>

				<form method="POST" class='col-sm-12 option' action>
					<h3>Changer de mot de passe</h3>
					<?php
						$profil->changePassword();
					?>
					<label class='col-lg-5 col-sm-6' for='passwordOld'>Mot de passe actuel</label><input type="password" class='col-sm-4 col-lg-6' name="passwordOld" />
					<label class='col-lg-5 col-sm-6' for='password'>Nouveau mot de passe</label><input type="password" class='col-sm-4 col-lg-6' name="password"/>
					<label class='col-lg-5 col-sm-6' for='passwordConfirm'>Confirmer</label><input type="password" class='col-sm-4 col-lg-6' name="passwordConfirm" />
					<br/><br/><input class='col-lg-2 col-lg-offset-5 col-sm-4 col-sm-offset-4' type="submit" name="changePassword" value="valider"/>
				</form>

			</div>
		</div>

	</div>
</div>
</body>
</html>

