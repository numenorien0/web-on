<!DOCTYPE html>
<html>
<head>
	<title>Connexion à Oh! Pilot</title>
	<?=$includeJSAndCSS;?>
</head>
<body>
<style>
#logo
{
	margin-top: -70px;
	margin-bottom: 20px;
}	
h1
{
	color: black;
	width: 100%;
	color: #bbbbbb;
	text-align: center;
	font-weight: bold;
	font-size: 30px;
	margin-bottom: 20px;
	margin-top: 0px;
}
#connect_btn
{
	background: #2ac652 !important;
	color: white;
	text-shadow: none;
}
</style>
<div class="container">
		<form class='col-sm-4 col-sm-offset-4' style='padding: 0' method="POST">
			<div id='logo' class='' style='margin-top: 15px; margin-bottom: 0px'><img src='images/<?=$logo?>' style='max-width: 100%; max-height: 200px'/></div>
			<h1 class='col-sm-12' style='color: #9f9f9f; font-size: 14px; margin: 0; margin-bottom: 30px'>Connexion</h1>
			<div class='col-sm-12'>
			<?php
				$install = new Install();
				$install->detectInstallation();
				$login = new Login();
				// $login->login();
			?>
			<input type='text' name='login' class='col-sm-10 col-sm-push-1' placeholder="Login"/><br/>
			<input type='password' class='col-sm-10 col-sm-push-1' name="password" placeholder="Votre mot de passe"/><br/>
			<input type='submit' class='col-sm-6 col-sm-push-3' style='margin-bottom: 30px' id='connect_btn' name='valider' value="Connexion"/><br/><br/>
			</div>
		</form>
</div>
</body>
</html>

