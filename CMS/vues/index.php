
<!DOCTYPE html>
<html>
<head>
	<title>Oh! Pilot - Accueil</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?=$includeJSAndCSS;?>
	
</head>
<body>

<div class='container-fluid'>
	<?php
		include("includes/menu.php");
		$dashboard = new dashboard();
		
		$heure = date("G");
		if($heure > 18 OR $heure < 3)
		{
			$bonjour = "Bonsoir, ".$_SESSION['login']." !";
		}
		else
		{
			$bonjour = "Bonjour, ".$_SESSION['login']." !";
		}
	
	?>
	
	<div id='wrapper' class='col-sm-10'>
		<div class='col-sm-12 menuDate col-lg-10 col-lg-offset-1'>
			



<!--
			<div class="onglet">
				<a data-filter="data" href='index.php'>Accueil</a>
			</div>
			<div class="onglet">
				<a data-filter="data" href='statistic.php'>Statistiques</a>
			</div>
			<div class='onglet'>
				<a data-filter="comportement" href="statistic.php?onglet=comportement">Comportement</a>
			</div>
			<div class='onglet'>
				<a data-filter="integration" href="statistic.php?onglet=integration">Intégration</a>
			</div>
-->
			<div class='cadre liensDate col-sm-12'>
				<?=$bonjour?>
			</div>
		</div>
		<h2 class='cadre'><div class='container'>Tableau de bord</div></h2>
			<?php
				$dashboard->note_service();
			?>
			
		<div class='colonneGauche col-sm-6 col-lg-5 col-lg-offset-1'>
			<div class='cadreContainer col-sm-12'>
				<div class='cadre col-sm-12'>
					<h3>Les dernières connexions</h3>
					<?php 
						$dashboard->afficherDernieresConnexion();
					?>
				</div>
			</div>
			<div style='margin-top: 15px' class='lesMessages cadreContainer col-sm-12'>
				<div class='cadre'>
					<h3 id='messageTitle'>Message de l'équipe</h3>
					<?php
						$dashboard->message();
					?>
					<form method='POST' class='row'>
					<div class='formMessage col-sm-12'>
						<div class='col-sm-9'><textarea placeholder='Votre message' id='yourMessage' style='height: 40px' class='col-sm-12' name='message'></textarea></div><div class='col-sm-3'><input type='button' id='sendMessage' class='col-sm-12' value='Envoyer' name='envoyer'/></div>
					</div>
					</form>
				</div>
			</div>

			<?php
			if(disk_total_space())
			{
			?>
			<div class='cadreContainer col-sm-12'>
				<div class='col-sm-12 cadre'>
				<h3>Espace disque</h3>
				<div class="col-sm-6">
	                <div class="progress-pie-chart" data-percent="67"><!--Pie Chart -->
	                    <div class="ppc-progress">
	                        <div class="ppc-progress-fill"></div>
	                    </div>
	                    <div class="ppc-percents">
	                    <div class="pcc-percents-wrapper">
	                        <span>%</span>
	                    </div>
	                    </div>
	                </div>
				</div>
	                <div class='infoStorage col-sm-6'>
	                	<?php
		                	$dashboard->storage();	
		                ?>
	                </div>
				</div>
			</div>
			<?php
				}
			?>
		</div>
		
		<div class='colonneDroite col-sm-6 col-lg-5'>
			<div class='cadreContainer col-sm-12' style='margin-top: 0;'>
				<div class='col-sm-12 cadre'>
					<h3>En bref</h3>
					<?php 
						$dashboard->afficherEnBref();
					?>
				</div>
			</div>
			<div class='cadreContainer col-sm-12' style='margin-top: 7px;'>
				<div class='col-sm-12 cadre'>
					<h3>Activité récente</h3>
					<?php 
						$dashboard->get_log();
					?>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>

