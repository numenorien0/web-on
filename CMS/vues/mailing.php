<!DOCTYPE html>
<html>
<head>
	<title>Mailing - CMS</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?=$includeJSAndCSS;?>

</head>
<body>
<div class='container-fluid'>
	<?php
		include("includes/menu.php");
	?>
	
	<div id='wrapper' class='col-sm-10'>
		<h2 class='cadre'><div class='container'>Newsletter</div></h2>
			<?php
				if(isset($_GET['action']) AND $_GET['action'] == "create")
				{
					
			?>
				<div class='col-sm-12' style='margin-top: 20px'>
				<iframe src='mailing/' width="100%" height="500px"></iframe>
		</div>
			<?php
				}
				else
				{
					
				
			?>
		<div class='colonneGauche col-sm-6 col-lg-5 col-lg-offset-1'>
			<div class='cadreContainer col-sm-12'>
				<div class='cadre'>
					<h3>Création</h3>
					<a class='edit' href='?action=create'>Vous n'avez pas de newsletter ? Créez la ici !</a>
				</div>
			</div>
		</div>
		
		<div class='colonneDroite col-sm-6 col-lg-5'>
			<div class='lesMessages cadreContainer col-sm-12'>
				<div class='cadre'>
					<h3 id='messageTitle'>Publication</h3>
				</div>
			</div>
		</div>
		<?php
			}	
		?>
	</div>
</div>
</body>
</html>

