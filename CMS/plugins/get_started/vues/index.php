<!DOCTYPE html>
<html>
<head>
	<title>Home - CMS</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div class='container-fluid' style='margin-top: 15px'>
	<div class='cadre col-sm-12 col-lg-10 col-lg-offset-1'>
		<h3>Votre premier plugin</h3>
		<?php
			#$get = new get_started();
		?>
		<h4 style='font-weight: bold; margin-bottom: 15px'>La structure</h4>
		<p>Pour développer un plugin, Il vous suffit de créer un dossier avec l'ID de votre plugin (le nom "informatique", sans espace et avec des underscores) et dans ce dernier une architecture de 6 sous-dossiers.</p><br/>
		<ul>
			<li>- controleurs</li>
			<li>- CSS</li>
			<li>- infos</li>
			<li>- images</li>
			<li>- JS</li>
			<li>- vues</li>
		</ul><br/>
		<p>Le dossier controleurs doit comporter toutes les classes PHP que vous utilisez dans le plugin. Elles sont incluent automatiquement par le CMS</p><br/>
		<p>Le dossier CSS contient toutes les feuilles CSS nécéssaires à votre plugin. Elles sont incluses automatiquement. Une feuille de style avec le nom de la page sera incluse automatiquement dans la page. En appellant une feuille de style par le nom du plugin suivi de "_global" sera ajouté dans toutes les pages du plugin</p><br/>
		<p>Le dossier infos contient un fichier XML de description de votre plugin. Nous y reviendrons juste en dessous</p><br/>
		<p>Le dossier JS contient tous les scripts nécéssaires pour le plugins. La méthode d'intégration est la même que pour les feuilles de styles</p><br/>
		<p>Le dossier vues contient toutes les pages HTML de votre plugin</p><br/>
		<p>
			<h4 style='font-weight: bold; margin-bottom: 15px'>Le fichier XML</h4>
			<p>Il ne doit comporter que 4 champs : l'id, le nom, une brève description ainsi que la liste des pages du plugins</p>
			<textarea style='width: 100%; height: 150px'>
<id>get_started</id> // le nom du plugin (sans espace). C'est le nom "informatique" du plugin. Il ne sera jamais affiché.
<name>développer un plugin pour Oh! CMS</name> // Il s'agit du nom du plugin qui sera affiché dans le CMS. 
<description>Apprenez dans ce document a développer un plugin pour Oh! CMS si vous êtes développeur.</description>
<state>enabled</state> // spécifie si le plugin est actif ou non. valeur possible : enabled/disabled.
<pages>
	<page>get_started</page>
</pages>
			</textarea>
		</p>
	</div>
</div>
</body>
</html>

