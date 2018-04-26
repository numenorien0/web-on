<!DOCTYPE html>
<html>
<head>
	<title>Oh! Pilot - Options du système</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="JS/codemirror.js"></script>
	<script src="JS/css.js"></script>
	<script src="JS/show-hint.js"></script>
	<script src="JS/css-hint.js"></script>
	<link rel="stylesheet" type="text/css" href="CSS/codemirror.css"/>
	<link rel="stylesheet" type="text/css" href="CSS/show-hint.css"/>
	<?=$includeJSAndCSS;?>
	
</head>
<body>
<div class="container-fluid">
	<?php
	include("includes/menu.php");	
	?>
	<div class='col-sm-10' id='wrapper'>
		<h2 class='cadre'><div class='container'>Thèmes</div></h2>
		<div class='col-lg-12 col-lg-offset-0'>
			
			<?php
				$theme = new Themes();
				#$theme->get_all_themes();
				
/*
				$parser = new CssParser();
				$file = file_get_contents("themes/".$maj->_skin."/style.css");
				$parser->load_string($file);
				$parser->parse();
				
				$parsed = $parser->parsed["main"];
				
				foreach($parsed as $key => $element)
				{
					echo "<br/><br/>$key : <br/>";
					foreach($element as $parametre => $valeur)
					{
						echo "<label>".$parametre." : </label><input type='text' value='$valeur'/><br/>";
					}
				}
*/
				
			?>
		</div>
	</div>
</div>
</body>
</html>

