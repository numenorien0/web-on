
<!DOCTYPE html>
<html>
<head>
	<title>Geronimo - <?=$titre?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?=$includeJSAndCSS;?>
</head>
<body>
<div class='container-fluid'>
	<?php
		if(!isset($_GET['display']) AND $_GET['display'] != "included")
		{
			$size = "col-sm-12";
			$size2 = "col-lg-12";
			#include("includes/menu.php");
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
		<?php
			if(!isset($_GET['display']) AND $_GET['display'] != "included")
			{
		?>
		<div style='padding: 7px; margin-bottom: 15px;' class='col-sm-6 col-sm-offset-3'>
			<a style='' href='<?=$_GET['tools']?>&page=listMedias' class='linkButton'>&#x21e6; Retour</a>
		</div>
			<?php } ?>
		<div class='col-sm-12 <?=$size2?>'>
			<form method='POST' id='formulaireMedia' enctype='multipart/form-data' class='col-md-12'>
			<?php
				$medias = new addMedias("video");
			?>
			</form>
		</div>
	</div>
</div>
</body>
</html>

