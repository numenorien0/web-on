<?php

	$abonnement = new Abonnement();
	$abonnement->verification();

	$analyse = new Analyse();
	if(isset($_GET['ip']) AND $_GET['ip'] != null)
	{
		$analyse->writeNewConnection();
	}	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Geronimo - Statistiques</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?=$includeJSAndCSS;?>
</head>
<body>
<div id='blackscreen'></div>
<div class='cadre' id='info'>
	<h3>Détails</h3>	
</div>
<div class='container-fluid'>
	<?php
		include("includes/menu.php");
		echo "<input id='dateHidden' type='hidden' value='".$_GET['date']."'>";
		echo "<input id='ongletHidden' type='hidden' value='".$_GET['onglet']."'>";
	?>
	<div id='wrapper' class='col-sm-10'>
<div id="chart-1-container"></div>
<div id="chart-2-container"></div>
		<h2 class='cadre'><div class='container'>Outils d'analyse (depuis <?php echo $analyse->_titre; ?>)</div></h2>
		<div class='col-sm-12 menuDate col-lg-10 col-lg-offset-1'>
<!--
			<div class="onglet">
				<a data-filter="data" href='index.php'>Accueil</a>
			</div>
-->
			<div class="onglet">
				<a data-filter="data" href='statistic.php'>Statistiques</a>
			</div>
			<div class='onglet'>
				<a data-filter="comportement" href="?onglet=comportement">Comportement</a>
			</div>
			<div class='onglet'>
				<a data-filter="integration" href="?onglet=integration">Intégration</a>
			</div>
			<div class='cadre liensDate col-sm-12'>
				<div class='col-sm-3'><a class='linkDate col-sm-12' href='statistic.php?onglet=<?=$_GET['onglet']?>'>Tout</a></div><div class='col-sm-3'><a class='linkDate col-sm-12' data-date='24' href='?date=24&onglet=<?=$_GET['onglet']?>'>Les dernières 24 heures</a></div><div class='col-sm-3'><a class='linkDate col-sm-12' data-date='7' href='?date=7&onglet=<?=$_GET['onglet']?>'>Les 7 derniers jours</a></div><div class='col-sm-3'><a class='linkDate col-sm-12' data-date='30' href='?date=30&onglet=<?=$_GET['onglet']?>'>Les 30 derniers jours</a></div>
			</div>
		</div>
		<?php
			if(isset($_GET['onglet']) AND $_GET['onglet'] != null)
			{
					if($_GET['onglet'] == "integration")
					{
						$analyse->integration();
					}
					if($_GET['onglet'] == "comportement")
					{
						$analyse->comportement();
					}
				
			}
			else
			{
				echo "<div id='toExport'>";
				$analyse->readStat();
				echo "</div>";
			}
		?>
<!-- 		<input type='button' id='export' value='Exporter'/> -->
	</div>
	
</div>
</body>
</html>

