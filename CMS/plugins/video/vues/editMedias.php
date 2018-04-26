<!DOCTYPE html>
<html>
<head>
	<title>Geronimo - Editer</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- 	<?=$includeJSAndCSS;?> -->
</head>
<body>
<div class='container-fluid'>
	<?php
		#include("includes/menu.php");
		if(isset($_GET['action']) AND $_GET['action'] == "showMePhotos")
		{
			echo "<input type='hidden' id='actionHidden' value='ok'/>";
		}
	?>
	<div id='wrapper' class='col-sm-12'>
			<div style='padding: 0; margin-bottom: 15px' class='col-sm-6 col-sm-offset-3'>
				<a href='<?=$_GET['tools']?>&page=listMedias' class='linkButton'>&#x21e6; Retour</a>
			</div>
<!-- 		<h2 class='cadre'><div class='container'>Edition de médias</div></h2> -->
		<form method='POST' action='outils.php?tools=video&page=editMedias&id=<?=$_GET['id']?>' enctype='multipart/form-data' class='col-md-12'>
		<?php
			$media = new editMedias();
		?>
		</form>

		<div id='blackScreen'>
			
		</div>
		<div id='containerPhoto'>
			<div class='col-sm-12'>
			<h3>Liste de vos photos pour cet album</h3>
				<?php
					$media->listAllPhoto();
				?>
			</div>
			<div id='fullscreen'>
				<img src="#" id='fullscreenImage'/><br/>
				<input type='button' value='fermer' id='closeImg'>		
			</div>
		</div>
	</div>
</div>
</body>
</html>

