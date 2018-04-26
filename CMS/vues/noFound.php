<!DOCTYPE html>
<html>
	<head>
		<meta charset='utf-8'/>
		<title>Oops! Page non répertoriée</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?=$includeJSAndCSS;?>
	</head>
	<body>
		<style>
			html, body
			{
				width: 100%;
				height: 100%;
				background: url("images/space.jpg");
				background-size: cover;
			}
			#message
			{
				margin-top: 15%;
				background-color: white;
				color: black;
				box-shadow: 0px 0px 100px 1px rgba(0,0,0,0.5);
				padding: 50px;
				border-radius: 4px;
				padding-top: 20px;
				padding-bottom: 20px;
				text-align: center;
			}
			h3
			{
				font-weight: bold;
				border-bottom: 1px solid #AFAFAF;
				padding-bottom: 15px;
			}
			h4
			{
				color: #AFAFAF;
				font-size: 18px;
				font-weight: Bold;
			}
		</style>
		<div id='message' class='col-sm-4 col-sm-offset-4'>
			<h3 class='col-sm-12'>Erreur 404</h3>
			<img class='col-sm-10 col-sm-offset-1' id='logo' src='images/<?=$logoBlack?>'/>
			<h4 class='col-sm-12'>Oops! Page non trouvée!</h4>
		</div>
	</body>
</html>

