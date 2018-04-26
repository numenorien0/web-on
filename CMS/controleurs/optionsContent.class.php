<?php

class optionsContent extends DB
{
	
	private $_db;
	
	public function __construct()
	{
		$this->_db = parent::__construct();
		if(isset($_POST['save']))
		{
			$this->addInput();
		}
		if(isset($_GET['delete']))
		{
			$this->delete();
		}
	}
	
	public function formatageFile($texte)
	{
		$texte = str_replace("é", "e", $texte);
		$texte = str_replace("è", "e", $texte);
		$texte = str_replace("ê", "e", $texte);
		$texte = str_replace("à", "a", $texte);
		$texte = str_replace("ù", "u", $texte);
		$texte = str_replace("î", "i", $texte);
		
		
		return $texte;
	}	
	
	public function delete()
	{
		$id = $_GET['delete'];
		
		$sql = "DELETE FROM contenu_perso WHERE ID = $id";
		$reponse = $this->_db->query($sql);
		
		//$sql = "SELECT * FROM "
		
		echo "<script>window.location.href = 'listContenuSettings.php?ID=".$_GET['ID']."'</script>";
	}
	
	public function addInput()
	{
		$label = str_replace("'","''", $_POST['label']);
		$label = $this->formatageFile($label);
		$label = strtolower($label);
		$type = $_POST['type'];
		
		$sql = "INSERT INTO contenu_perso VALUES('','".$label."','".$type."','".$_GET['ID']."')";
		$reponse = $this->_db->exec($sql);
		
		echo "<script>window.location.href = 'listContenuSettings.php?ID=".$_GET['ID']."';</script>";
	}
	
	public function listAll()
	{
		$sql = "SELECT * FROM contenu_perso WHERE page = '".$_GET['ID']."'";
		$reponse = $this->_db->query($sql);
		
		if($reponse->rowCount() == 0)
		{
			echo "<div class='notYet'>Pas encore de contenu ici.</div>";	
		}
		else
		{
			echo "<ul>";
			while($donnees = $reponse->fetch())
			{
				echo "<li>".$donnees['label']." - <span class='type'>".$donnees['valeur']."</span><a href='?ID=".$_GET['ID']."&delete=".$donnees['ID']."'class='deleteInput'>Supprimer</a></li>";
			}
			echo "</ul>";
		}
		
	}
	
	public function afficherFormulaire()
	{
		echo "<div class='row'><label class='col-sm-4' for='label'>Label</label><input class='col-sm-6' type='text' name='label'/></div>";
		echo "<div class='row'><label class='col-sm-4' for='type'>Type de champs</label><select class='col-sm-6' name='type'>
			<option>Texte</option>
			<option>Zone de texte</option>
			<option>Couleur</option>
			<option>Image</option>
			<option>Carte</option>
		</select></div>";
		echo "<div class='row'><input class='col-sm-4 col-sm-offset-4' type='submit' value='Enregistrer' name='save'></div>";
	}
	
}	
?>

