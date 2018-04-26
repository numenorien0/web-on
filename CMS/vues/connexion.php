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
	filter: drop-shadow(0px 0px 10px rgba(0,0,0,0.2));
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
form
{
	background: rgba(0,0,0,0.3);
	box-shadow: none;
	border-radius: 5px;
	-webkit-backdrop-filter: blur(4px);
}
input[type=text], input[type=password]
{
	border-radius: 15px;
	background: rgba(255,255,255, 0.4);
	border: none;
	padding: 10px 25px !important;
}
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
input::placeholder
{
	color: white;
}
</style>
<div style='position: fixed; left: 0; top: 0; width: 100vw; height: 100vh; background-color: rgba(0,0,0,0.5)'>
<div class="container">
		<form class='col-sm-4 col-sm-offset-4' style='padding: 0' method="POST">
			<div id='logo' class='' style='margin-top: 15px; margin-bottom: 0px'><img src='images/<?=$logoBlack?>' style='max-width: 100%; max-height: 200px'/></div>
			
			<div class='col-sm-12'>
			<?php
				$install = new Install();
				$install->detectInstallation();
				$login = new Login();
				// $login->login();
			?>
			<div class='col-sm-12' style='display: none; text-align: center; color: #52c3e5; font-size: 40px'>
				<i class="fal fa-lock-alt"></i>
			</div>
			<input autocomplete='off' type='text' name='login' class='col-sm-10 col-sm-push-1' placeholder="Login"/><br/>
			<input type='password' class='col-sm-10 col-sm-push-1' name="password" placeholder="Votre mot de passe"/><br/>
			<input type='submit' class='fa-input col-sm-10 col-sm-push-1' style='margin-bottom: 30px; background: #52c3e5 url(https://pro.fontawesome.com/releases/v5.0.10/svgs/light/lock-alt.svg) !important' id='connect_btn' name='valider' value="Connexion"/><br/><br/>
			</div>
		</form>
</div>
</div>
</body>
</html>

