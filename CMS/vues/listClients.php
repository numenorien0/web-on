<!DOCTYPE html>
<html>
<head>
	<title>Liste des clients - CMS</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?=$includeJSAndCSS;?>
</head>
<body>
<div class='container-fluid'>
	<?php
		include("includes/menu.php");
	?>
	<div id='wrapper' class='col-sm-10'>
		<h2 class='cadre'><div class='container'>Liste des clients</div></h2>
		<?php include('includes/ecommerceMenu.php')?>
		<form method='POST' enctype='multipart/form-data' class='col-sm-12 col-lg-10 col-lg-offset-1'>
		<?php
			$clients = new listClients();
		?>
	
		</form>
	</div>
</div>

</body>
</html>

