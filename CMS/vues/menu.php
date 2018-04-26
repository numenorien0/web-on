<!DOCTYPE html>
<html>
<head>
	<title>Oh! Pilot - Personnalisation du menu</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?=$includeJSAndCSS;?>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	
</head>
<body>
<div class="container-fluid">
	<?php
		include("includes/menu.php");
		$options = new Options();
	?>
	<div class='blackScreen'>
	</div>
	<div class='col-sm-10' id='wrapper'>
		
		<h2 class='cadre'><div class='container'>Personnalisation du menu</div></h2>
		<div class='colonneContainer col-sm-12 col-lg-12 col-lg-offset-0'>
			<?php 
				if($db->ecommerce_is_actived())
				{
			?>
			<div class='selectMenu col-sm-12 cadre' style='margin-bottom: 0'><h3>Type de menu</h3>Ordinaire <input type='checkbox' id='selectMenuType'> E-commerce</div>
			<?php
				}
				$menu = new Menu();	
			?>
		<div class='col-sm-12 optionCadre' style='padding: 0px; margin-top: 5px'>
			
			<div style='padding: 15px; margin-top: 5px' class='col-sm-12 optionCadre cadre'>
				<form method="POST" action id='formulaireGeneral' class='col-sm-12'>
			<?php
				echo $menu->display_all_language();
			?>
			
					<?php
						$menu->display_code();	
					?>
					
			</form>
				
			</div>
			
		</div>
		<div class='col-sm-12 optionCadre' style='padding: 0px; margin-top: 5px'>
			
			<div style='padding: 15px; margin-top: 5px' class='col-sm-12 optionCadre cadre topmenuoption'>
				<h3>Au dessus de votre menu</h3>
				<textarea id='tinyMCE' class='tinyMCE'></textarea>
			</div>
			
		</div>
		<div class='col-sm-6 colonneGauche colonne'>
			<div class='col-sm-12 optionCadre'>
				<form method="POST" style="overflow: hidden; height: 400px;" class='col-sm-12 cadre option'>
					<h3>Listes des pages principales<br/><span class='info'>Cliquez pour ajouter</span></h3>
					<?php
						$menu->list_main_pages();
					?>	
				</form>
			</div>
		</div>

		<div class='col-sm-6 colonneDroite colonne' style="padding-right: 5px">
			<div class='col-sm-12 optionCadre'>
				<form style="overflow: hidden; height: 400px" method="POST" action class='col-sm-12 cadre option'>
				<h3>Rechercher une page</h3>
				<input class='col-sm-12' type='text' id='searchPage' placeholder='Le nom de la page' />
				<div style="height: 270px;" class='col-sm-12 result'>
				</div>
				</form>
			</div>
		</div>
		<div style='display: none' class='col-sm-4 colonneDroite colonne'>
			<div class='col-sm-12 optionCadre'>
				<form style="overflow: hidden; height: 400px" method="POST" action class='col-sm-12 cadre option'>
				<h3>Disposition<br/><span class='info'>La disposition sera changée dans toutes les langues</span></h3>
					<?php
						$menu->get_wireframe_menu();
						$menu->get_current_wireframe_menu();	
					?>
					
				</form>
			</div>
		</div>
		<div style='padding: 0px; margin-top: 5px' class='col-sm-12 optionCadre'>
			<form method="POST" action  class='cadre col-sm-12 option'>
				<h3>Organigramme du menu<br/><span class='info'>Glissez pour changer la disposition</span></h3>
				<div style="overflow-x: auto"> 
					<div id='rendu'>
						<div class='column extra'>
						</div>				
					</div>
				</div>
			</form>
		</div>
		<div style='padding: 0px; margin-top: 5px' class='col-sm-12 optionCadre'>
		</div>

	</div>
</div>
</body>
</html>

