<!DOCTYPE html>
<html>
<head>
	<title>Oh! Pilot - Modules</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?=$includeJSAndCSS;?>
</head>
<body>
<div class='container-fluid'>
	<?php
		if(!isset($_GET['display']) AND $_GET['display'] != "included")
		{
			include("includes/menu.php");
		}
		$outils = new Outils();
	?>
	<?php
		if(isset($_GET['tools']) AND $_GET['tools'] != null)
		{
			$page = file_get_contents("plugins/".$_GET['tools']."/infos/".$_GET['tools'].".xml");
			$page = new SimpleXMLElement($page);
			$nomDuPlugin = $page->id;
			$nomComplet = $page->name;
			echo "<link rel='stylesheet' href='plugins/".$_GET['tools']."/CSS/".$nomDuPlugin."_global.css'/>";
			echo "<script src='plugins/".$_GET['tools']."/JS/".$nomDuPlugin."_global.js'></script>";
			echo "<link rel='stylesheet' href='plugins/".$_GET['tools']."/CSS/".$_GET['page'].".css'/>";
			echo "<script src='plugins/".$_GET['tools']."/JS/".$_GET['page'].".js'></script>";
		}
	?>
	<div id='wrapper' class='col-sm-10'>
		<h2 class='cadre'><div class='container'><?=$nomComplet?></div></h2>
		<div class='col-sm-12 col-lg-10 col-lg-offset-1'>
			<?php
				if(!isset($_GET['tools']))
				{
					$outils->listAllPlugins();
				}
				else
				{
					echo "<div id='plugin'>";
					if(isset($_GET['page']) AND $_GET['page'] != null)
					{
						include("plugins/".$_GET['tools']."/vues/".$_GET['page'].".php");
					}
					else
					{
						include("plugins/".$_GET['tools']."/vues/index.php");
					}
					echo "</div>";
				}
			?>
		</div>
	</div>
</div>
</body>
</html>

