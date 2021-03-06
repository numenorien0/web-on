<!DOCTYPE html>
<html>
<head>
	<title>Installation de Oh! Pilot</title>
	<?=$includeJSAndCSS;?>
</head>
<body>
	<style>
		input[type=submit]
{
	border-radius: 15px !important;
	background: #52c3e5 url(https://pro.fontawesome.com/releases/v5.0.10/svgs/light/lock-alt.svg) !important;
	color: white !important;
	padding: 10px 25px !important;
	font-size: 16px;
	background-position: left center;
	background-size: 50px;
}
h4
{
	border-bottom: none;
	color: #9f9f9f;
}
		</style>
<div class="container">
		<?php
			if(file_exists("db.conf"))
			{
				header("location: index.php");
			}
		?>	
		<form class='col-sm-6 col-sm-offset-3' method="POST">
			
			<div class='row logoRow'>
				<h1 class='col-sm-12' style='text-align: center; font-weight: bold; color: #9f9f9f; font-size: 34px; margin: 0; margin-top: 30px; margin-bottom: 30px'>Installation</h1>
<!-- 				<h3>Installation</h3> -->
				<div id='logo' class='' style='margin-top: 15px; margin-bottom: 0px'><img src='images/<?=$logoBlack?>' style='max-width: 100%; max-height: 200px'/></div>
				
			</div>
			<?php 
				$install = new Install();
			?>
			<h4 class='col-sm-12'>Base de données</h4>
			<div class='row'><label for='dbname' class='col-sm-4'>Nom</label><input type='text' name='dbname' class='col-sm-6'/></div>
			<div class='row'><label for='create' class="col-sm-4">La créer?</label><input type="checkbox" name='create' class=''/></div>
			<div class='row'><label for='emplacement' class='col-sm-4'>Emplacement</label><input type='text' name='emplacement' placeholder='exemple: localhost' class='col-sm-6'/></div>
			<div class='row'><label for='user' class='col-sm-4'>Utilisateur</label><input type='text' name='user' class='col-sm-6'/></div>
			<div class='row'><label for='password' class='col-sm-4'>Mot de passe</label><input type='password' name='password' class="col-sm-6"/></div>
			<h4 class="col-sm-12">Utilisateur par défaut</h4>
			<div class='row'><label for='defaultUser' class='col-sm-4'>login</label><input type='text' name='defaultUser' class='col-sm-6'/></div>
			<div class='row'><label for='defaultPassword' class='col-sm-4'>Mot de passe</label><input type='password' name='defaultPassword' class="col-sm-6"/></div>
			<div class='row'><label for='defaultPassword' class='col-sm-4'>Confirmation</label><input type='password' name='defaultPasswordConfirm' class="col-sm-6"/></div>
			<div style='text-align: center' class='col-sm-12'>
				<input type='submit' name='install' value='Installer'/>
			</div>
		</form>
</div>
</body>
</html>

