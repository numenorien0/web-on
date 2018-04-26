<?php
	if(isset($_GET['type']) AND $_GET['type'] != null)
	{
		if($_GET['type'] == "video")
		{
			$titre = "Ajouter une vidéo";
		}
		if($_GET['type'] == "photo")
		{
			$titre = "Ajouter un album";
		}
		if($_GET['type'] == "fichier")
		{
			$titre = "Ajouter un fichier";
		}
	}
	else
	{
		header("location: listMedias.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Oh! Pilot - <?=$titre?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?=$includeJSAndCSS;?>
</head>
<body>
<div class='container-fluid'>
	<?php
		if(!isset($_GET['display']) AND $_GET['display'] != "included")
		{
			$size = "col-sm-10";
			$size2 = "col-lg-10 col-lg-offset-1";
			include("includes/menu.php");
		}
		else
		{
			$size = "col-sm-12";
			$size2 = "col-lg-12";
			?>
			<style>
				textarea, input[type=text]
				{
					width: 100%;
				}
				*::-webkit-scrollbar
				{
					width: 0px;
				}
			</style>
			<?php
		}
	?>
	<div id='wrapper' class='<?=$size?>'>
		<h2 class='cadre'><div class='container'><?=$titre?></div></h2>
		<div class='col-sm-12 <?=$size2?>'>
			<form method='POST' id='formulaireMedia' enctype='multipart/form-data' class='col-md-12'>
			<?php
				$medias = new addMedias($_GET['type']);
			?>
			</form>
		</div>
	</div>
</div>
</body>
</html>

