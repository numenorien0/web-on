<?php
class Projets extends DB
{
	private $_db;
	private $_nom;
	private $_description;
	private $_icone;
	private $_liste;
	private $_action;
	private $_titre;
	private $_texte;
	private $_auteur;

	public function __construct($nom)
	{
		$this->_auteur = $nom;
		$this->_db = parent::__construct();
		$this->_titre = "projet";
		$this->_action = "<input type='submit' value='Enregistrer' name='enregistrer'/>";
    	
    	$sql = "CREATE TABLE IF NOT EXISTS `projets_categories` (
				`ID` bigint(20) unsigned AUTO_INCREMENT PRIMARY KEY,
				`nom` varchar(255) NOT NULL,
				`icone` varchar(255) NOT NULL,
				`description` text NOT NULL,
				`actif` varchar(255) NOT NULL
				)";

		$reponse = $this->_db->exec($sql);
		
    	$sql = "CREATE TABLE IF NOT EXISTS `projets_projets` (
				`ID` int(10) unsigned AUTO_INCREMENT PRIMARY KEY,
				`nom` varchar(255) NOT NULL,
				`texte` text NOT NULL,
				`description` text NOT NULL,
				`image` varchar(255) NOT NULL,
				`auteur` varchar(255) NOT NULL,
				`date` varchar(255) NOT NULL,
				`categorie` varchar(255) NOT NULL
				)";

		$reponse = $this->_db->exec($sql);		
		
	}

	public function listAll()
	{
		$sql = "SELECT * from projets_projets";
		$reponse = $this->_db->query($sql);
		
		echo "<div class='col-sm-8 col-sm-push-2 cadre'>";
		echo "<h3>Liste de tous les projets</h3>";
		echo "<ul class='col-sm-12' id='listeAxes'>";
		
		$projetBamboost = file_get_contents('https://test.bamboost.org/delegate/rest/v1/boosterclubs/103682/projects?fields={"project":"tagline,description"}');
		$projetBamboost = json_decode($projetBamboost, TRUE);
		foreach($projetBamboost as $projet)
		{
			echo "<li class='row'>".$projet['name']."<a class='edit pull-right' href='".$_GET['tools']."&page=".$_GET['page']."&ID=".$projet['id']."'>Editer</a></li>";
		}
		echo "</ul>";
		echo "</div>";
	}

	public function utf8_converter($array)
	{
	    array_walk_recursive($array, function(&$item, $key){
	        if(!mb_detect_encoding($item, 'utf-8', true)){
	                $item = utf8_encode($item);
	        }
	    });
	 
	    return $array;
	}

	public function editProjet()
	{
		if(isset($_POST['enregistrer']))
		{
			$categorie = $_POST["categorie"];
			$categorie = addslashes(json_encode($categorie,JSON_FORCE_OBJECT|JSON_UNESCAPED_UNICODE));
			
			
			$sql = "UPDATE projets_projets SET categorie = '$categorie' WHERE ID = ".$_GET['ID'];
			$reponse = $this->_db->query($sql);
			
		}
	}

	public function afficherFormulaire()
	{
		$sql = "SELECT * FROM projets_categories";
		$reponse = $this->_db->query($sql);

		$categorie = "<label class='col-sm-4'>Axe stratégique</label><select id='selectCategorie' class='col-sm-6 categoriesSelect' name='categorie[]'>";
		$categorie .= "<option></option>";
		while($donnees = $reponse->fetch())
		{
			$categorie .= "<option>".$donnees['nom']."</option>";
		}
		$categorie .= "</select>";
		if(isset($_GET['ID']))
		{
			$ID = $_GET['ID'];

			$projetBamboost = file_get_contents('https://test.bamboost.org/delegate/rest/v1/boosterclubs/103682/projects?fields={"project":"tagline,description"}');
			$projetBamboost = json_decode($projetBamboost, TRUE);
			foreach($projetBamboost as $projet)
			{
				if($projet['id'] == $ID)
				{
					$this->_nom = $projet['name'];
					$this->_description = $projet['description']['defaultLanguageText'];				
				}
			}

			$sql = "SELECT * FROM projets_projets WHERE ID = $ID";
			$reponse = $this->_db->query($sql);
			
			if($reponse->rowCount() == 0)
			{
				$sql = "INSERT INTO projets_projets VALUES('$ID','','','','','','','')";
				$reponse = $this->_db->exec($sql);

				$sql = "SELECT * FROM projets_projets WHERE ID = $ID";
				$reponse = $this->_db->query($sql);				
			}

			while($donnees = $reponse->fetch())
			{
				$projetBamboostImage = 'https://test.bamboost.org/delegate/rest/v1/projects/'.$ID.'/mainImage';
				$this->_categorie = $donnees['categorie'];
			}
			$ajouterBtn = "";
			echo "<div class='col-sm-8 col-sm-offset-2 cadre'>";
			echo "<input type='hidden' value='".@$this->_categorie."' id='categorie'>";
			echo "<form class='col-sm-12' method='POST' action enctype='multipart/form-data'>
				<h3>".$this->_titre."</h3>
				".$this->_liste."
				<div class='row'><label class='col-sm-4' for='nom'>Nom</label><div id='inputDisabled' class='col-sm-6'>".$this->_nom."</div></div>
				<div class='row' style='padding: 30px'><img class='col-sm-6 col-sm-push-4' src='".$projetBamboostImage."'/></div>
				<div class='row'>
				".$categorie."
				</div>
				<div class='row'>
				<input type='button' id='addCategory' value='Ajouter un axe'/>
				</div>
				<div class='row'><label class='col-sm-12 col-xs-12' style='text-align: center' for='texte'>Texte</label></div><div class='row'><div id='textareaDisabled' disabled class='col-sm-10 col-sm-push-1'>".$this->_description."</div></div>
				<div class='row'>
					".$this->_action."
				</div>
				".$ajouterBtn."
			</form>";
			echo "</div>";
		}
	}
}
?>

