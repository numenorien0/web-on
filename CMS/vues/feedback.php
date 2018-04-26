<!DOCTYPE html>
<html>
<head>
	<title>Geronimo - Feedbacks</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?=$includeJSAndCSS;?>
</head>
<body>
<div class='container-fluid'>
	<?php
		include("includes/menu.php");
	?>
	
	<div id='wrapper' class='col-sm-10'>
		<h2 class='cadre'><div class='container'>Laissez-nous un message</div></h2>
		<?php
			include("includes/mail.php");
			$contact = new Contact();
		?>
		<div class='col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3 cadre'>
			<h3>Nouveau feedback</h3>
			<form method='POST' class='col-sm-12' action>
				<?php
					if(isset($_POST['sujet']))
					{
						echo "<input type='hidden' id='hiddenSujet' value='".$_POST['sujet']."'/>";
					}
				?>
				<label for="sujet" id='sujetLabel'>Sujet</label><select name='sujet'>
					<option>Rapport de bugs</option>
					<option>Suggestions</option>
					<option>Autre</option>
				</select>
				
				<label for='nom_prenom'>Nom et prénom</label><input type='text' value='<?=$_POST['nom_prenom']?>' name='nom_prenom' placeholder='Entrez vos nom et prénom'/>
				
				<br/><label for='email'>Adresse mail</label><input type='email' value='<?=$_POST['email']?>' name='email' placeholder='Entrez votre adresse email'/>
				
				<br/><label for='societe'>Société</label><input type='text' value='<?=$_POST['telephone']?>' name='societe' placeholder='Entrez le nom de la société'/>
				
				<br/><label for='message'>Message</label><textarea placeholder='Votre message' name='message'><?=$_POST['message']?></textarea>
				<br/><br/><input class='col-xs-12 col-sm-4 col-sm-push-4' type='submit' name='envoyer' value='Envoyer'/>
			</form>
		</div>
	</div>
</div>
</body>
</html>

