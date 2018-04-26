<!DOCTYPE html>
<html>
<head>
	<title>Geronimo - Statistiques</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?=$includeJSAndCSS;?>
</head>
<body>
<style>
html, body, #wrapper
{
	overflow: hidden;
	padding: 0;
}
iframe::-webkit-scrollbar
{
	width: 0;
}
iframe
{
	margin: 0;
	padding: 0;
	border: none;
}
</style>
<div class='container-fluid'>
	<?php
		include("includes/menu.php");
		echo "<input id='dateHidden' type='hidden' value='".$_GET['date']."'>";
		echo "<input id='ongletHidden' type='hidden' value='".$_GET['onglet']."'>";
	?>
	<div id='wrapper' class='col-sm-10'>

		<h2 class='cadre'><div class='container'>Analytics</div></h2>
		<div id='loaderIframe'><iframe id='analytics' src="Analytics/admin.php" style='width: 100%; height: 100%; overflow: auto'></iframe></div>
	</div>
	
	
	
	
</div>
</body>
</html>

