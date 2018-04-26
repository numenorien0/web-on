<?php
class Categories extends DB
{
	private $_db;
	private $_nom;
	private $_description;
	private $_icone;
	private $_liste;
	private $_action;
	private $_titre;
	private $_actif;

	public function __construct()
	{
		$this->_db = parent::__construct();
		if(isset($_GET['ID']) AND $_GET['ID'] != null)
		{
			if(isset($_GET['action']) AND $_GET['action'] == "delete")
			{
				$this->delete();
			}
			$this->_action = "<input type='submit' value='Editer' name='editer'/>";
			$this->_titre = "Editer un axe stratégique";
		}
		else
		{
			$this->_titre = "Ajouter un nouvel axe stratégique";
			$this->_action = "<input type='submit' value='Enregistrer' name='enregistrer'/>";
		}
		
		
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

	public function delete()
	{
		$ID = $_GET['ID'];
		$sql = "SELECT * FROM projets_categories WHERE ID = $ID";
		$reponse = $this->_db->query($sql);

		while($donnees = $reponse->fetch())
		{
			$fichierASupprimer = $donnees['icone'];
			$nomCategorie = $donnees['nom'];
		}

		if(@unlink($fichierASupprimer))
		{
			$sql = "DELETE FROM projets_categories WHERE ID = $ID";
			$reponse = $this->_db->exec($sql);

			$sql2 = "SELECT * FROM projets_projets";
			$reponse2 = $this->_db->query($sql2);
			
			while($donnees2 = $reponse2->fetch())
			{
				$categorieTest = $donnees2['categorie'];
				$categorieTest = json_decode($categorieTest, TRUE);
				
				$IDTemp = $donnees2['ID'];
				
				$nouveauTableau = array();
				foreach($categorieTest as $categorieIntoDB)
				{
					if($categorieIntoDB == $nomCategorie)
					{
						//$nouveauTableau[] = $this->_nom;
					}
					else
					{
						$nouveauTableau[] = $categorieIntoDB;
					}
					
				}
				
				$nouveauTableau = addslashes(json_encode($nouveauTableau, JSON_FORCE_OBJECT|JSON_UNESCAPED_UNICODE));
				$sql3 = "UPDATE projets_projets SET categorie = '$nouveauTableau' WHERE ID = $IDTemp";
				$reponse3 = $this->_db->query($sql3);
				
			}

			$this->_liste = "<div id='success'>Axe stratégique supprimé avec succès</div>";
			header("location: ?".$_GET['tools']."&page=categories");
		}
		else
		{
			$this->_liste = "<div id='error'>Erreur lors de la suppression</div>";
		}
	}

	public function transfoTexte($texte)
	{
		$accent='ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËéèêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ';
		$noaccent='aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn';
		$texte = strtr($texte,$accent,$noaccent);
		$texte = str_replace(" ","_",$texte);

		$texte = preg_replace('/([^.a-z0-9]+)/i', '-', $texte);
		$texte = time().$texte;

		return $texte;
	}

	public function listAll()
	{
		$sql = "SELECT * from projets_categories";
		$reponse = $this->_db->query($sql);
		
		echo "<div class='col-sm-8 col-sm-offset-2 cadre'>";
		echo "<ul class='col-sm-12' id='listeAxes'>";
		echo "<h3>Liste de tous les axes stratégiques</h3>";
		if($reponse->rowCount() == 0)
		{
			echo "<li style='text-align: center'>Pas encore d'axe stratégique</li>";
		}
		while($donnees = $reponse->fetch())
		{
			if($donnees['actif'] == "true")
			{
				$actif = " - Actif";
			}
			else
			{
				$actif = "";
			}
			echo "<li>".$donnees['nom']."<span class='actif'>".@$actif."</span> <a href='?ID=".$donnees['ID']."&action=delete' class='delete pull-right'>Supprimer</a><a class='edit pull-right' href='".$_GET['tools']."&page=".$_GET['page']."&ID=".$donnees['ID']."'>Editer</a></li>";
		}
		echo "</ul>";
		echo "</div>";
	}

	public function editCategorie()
	{
		if(isset($_POST['editer']))
		{
			$OldCategory = $_POST['OldCategory'];
			$ID = $_GET['ID'];
			$this->_nom = str_replace('"', "''''", str_replace("'","''", $_POST['nom']));
			$this->_icone = $_FILES['icone']['name'];
			$this->_description = str_replace("'","''", $_POST['description']);
			$erreur = 0;
			$erreurListe = array();
			@$this->_actif = $_POST['actif'];
			if($this->_nom == null)
			{
				$erreur++;
				$erreurListe[] = "Merci de remplir un nom";
			}
			if($this->_description == null)
			{
				$erreur++;
				$erreurListe[] = "Merci d'entrer une description de votre axe stratégique";
			}
			if($this->_actif == null)
			{
				$this->_actif = "false";
			}
			else
			{
				$this->_actif = "true";
			}
			if($this->_icone != null)
			{

				$sql = "SELECT * FROM projets_categories WHERE ID = $ID";
				$reponse = $this->_db->query($sql);

				while($donnees = $reponse->fetch())
				{
					$fichierASupprimer = $donnees['icone'];
					if(unlink($fichierASupprimer))
					{
						if(move_uploaded_file($_FILES['icone']['tmp_name'], "plugins/".$_GET['tools']."/images/".$this->transfoTexte($this->_icone)))
						{
							$sql = "UPDATE projets_categories SET nom = '".$this->_nom."', icone = 'plugins/".$_GET['tools']."/images/".$this->transfoTexte($this->_icone)."', description= '".$this->_description."', actif = '".$this->_actif."' WHERE ID = ".$ID;
						}
						else
						{
							$erreur++;
							$erreurListe[] = "Impossible d'envoyer le fichier sur notre serveur, réessayez plus tard";
						}
					}
					else
					{
						$erreur++;
						$erreurListe[] = "Impossible de changer l'image, réessayez plus tard";
					}
				}
			}
			if($this->_icone == null)
			{
				$sql = "UPDATE projets_categories SET nom = '".$this->_nom."', description= '".$this->_description."', actif = '".$this->_actif."' WHERE ID = ".$ID;
			}


			$sql2 = "SELECT * FROM projets_projets";
			$reponse2 = $this->_db->query($sql2);
			
			while($donnees2 = $reponse2->fetch())
			{
				$categorieTest = $donnees2['categorie'];
				$categorieTest = json_decode($categorieTest, TRUE);
				
				$IDTemp = $donnees2['ID'];
				
				$nouveauTableau = array();
				foreach($categorieTest as $categorieIntoDB)
				{
					if($categorieIntoDB == $OldCategory)
					{
						$nouveauTableau[] = $this->_nom;
					}
					else
					{
						$nouveauTableau[] = $categorieIntoDB;
					}
					
				}
				
				$nouveauTableau = addslashes(json_encode($nouveauTableau, JSON_FORCE_OBJECT|JSON_UNESCAPED_UNICODE));
				$sql3 = "UPDATE projets_projets SET categorie = '$nouveauTableau' WHERE ID = $IDTemp";
				$reponse3 = $this->_db->query($sql3);
				
			}
			//$sql2 = "UPDATE projets SET categorie = '".$this->_nom."' WHERE categorie = '".$OldCategory."'";
			//$reponse2 = $this->_db->exec($sql2);

			if($erreur == 0)
			{
				$reponse = $this->_db->query($sql);
				$this->_nom = "";
				$this->_icone = "";
				$this->_description = "";
				$this->_liste = "<div id='success'>modifications éffectuées avec succès</div>";
			}
			else
			{
				$liste = implode("<br/>", $erreurListe);
				$this->_liste = "<div id='error'>$liste</div>";
			}
			//$sql = "UPDATE projets SET categorie = '".$this->_nom."' WHERE categorie = '".$OldCategory."'";
			//$reponse = $this->_db->exec($sql);

		}		
	}
	public function addNewCategorie()
	{
		if(isset($_POST['enregistrer']))
		{
			@$this->_actif = $_POST['actif'];
			$this->_nom = str_replace('"', "''''", str_replace("'","''", $_POST['nom']));
			$this->_icone = $_FILES['icone']['name'];
			$this->_description = str_replace("'","''", $_POST['description']);
			$erreur = 0;
			$erreurListe = array();
			if($this->_nom == null)
			{
				$erreur++;
				$erreurListe[] = "Merci de remplir un nom";
			}
			if($this->_actif == null)
			{
				$this->_actif = "false";
			}
			else
			{
				$this->_actif = "true";
			}
			if($this->_icone == null)
			{
				$erreur++;
				$erreurListe[] = "Merci de choisir un fichier";
			}
			if($this->_description == null)
			{
				$erreur++;
				$erreurListe[] = "Merci d'entrer une description de votre axe stratégique";
			}

			if($erreur == 0)
			{
				if(move_uploaded_file($_FILES['icone']['tmp_name'], "plugins/".$_GET['tools']."/images/".$this->transfoTexte($this->_icone)))
				{
					$sql = "INSERT INTO projets_categories VALUES('','".$this->_nom."', 'plugins/".$_GET['tools']."/images/".$this->transfoTexte($this->_icone)."', '".$this->_description."', '".$this->_actif."')";
					$reponse = $this->_db->query($sql);
					$this->_nom = "";
					$this->_icone = "";
					$this->_description = "";
					$this->_actif = "";
					$this->_liste = "<div id='success'>Ajout éffectué avec succès</div>";
				}
			}
			else
			{
				$liste = implode("<br/>", $erreurListe);
				$this->_liste = "<div id='error'>$liste</div>";
			}

		}
	}

	public function afficherFormulaire()
	{
		if(isset($_GET['ID']))
		{
			$ID = $_GET['ID'];
			$sql = "SELECT * FROM projets_categories WHERE ID = $ID";
			$reponse = $this->_db->query($sql);

			while($donnees = $reponse->fetch())
			{
				$photo = $donnees['icone'];
				$this->_nom = $donnees['nom'];
				$this->_description = $donnees['description'];
				$this->_actif = $donnees['actif'];
				if($this->_actif == null)
				{
					$this->_actif = "false";
				}
			}
			echo "<div class='col-sm-offset-2 col-sm-8 cadre'>";
			$ajouterBtn = "<a style='display: block; margin-top: 10px' href='".$_GET['tools']."&page=".$_GET['page']."'>... ou ajouter un nouvel axe stratégique</a>";
			echo "<form class='col-sm-12' method='POST' action enctype='multipart/form-data'>
				<h3>".$this->_titre."</h3>
				".$this->_liste."
				<input type='hidden' id='actifHidden' value='".$this->_actif."'/>
				<div class='row'><label class='col-sm-4' for='nom'>Nom</label><input value=\"".$this->_nom."\" class='col-sm-6' type='text' name='nom'/></div>
				<input type='hidden' name='OldCategory' value=\"".$this->_nom."\">
				<div class='row'><label class='col-sm-4' for='actif'>Actif?</label><input class='col-sm-8' style='margin-top: 10px' type='checkbox' id='actif' name='actif'/></div>
				<div class='row illustration' style='padding: 30px'><div class='imgContainer'><img src='".$photo."'/></div></div>
				<div class='row'><label class='col-sm-4' for='icone'>icône</label><input class='col-sm-3' type='button' id='fileDisplay' value='Changer'><input id='fileHidden' type='file' name='icone'/></div>
				<div class='row'><label style='text-align: center' class='col-sm-12 col-xs-12' for='description'>Description</label></div><div class='row'><textarea id='wysiwyg' class='col-sm-10 col-sm-push-1' name='description'>".$this->_description."</textarea></div>
				<div class='row'>
					".$this->_action."
				</div>
				".$ajouterBtn."
			</form>";
			echo "</div>";
		}
		else
		{
			$ajouterBtn = "";
			echo "<div class='col-sm-8 col-sm-offset-2 cadre'>";
			echo "<form class='col-sm-12' method='POST' action enctype='multipart/form-data'>
				<h3>".$this->_titre."</h3>
				".$this->_liste."
				<input type='hidden' id='actifHidden' value='".$this->_actif."'/>
				<div class='row'><label class='col-sm-4' for='nom'>Nom</label><input value=\"".$this->_nom."\" class='col-sm-6' type='text' name='nom'/></div>
				<div class='row'><label class='col-sm-4' for='actif'>Actif?</label><input class='col-sm-8' style='margin-top: 10px' type='checkbox' id='actif' name='actif'/></div>
				<div class='row'><label class='col-sm-4' for='icone'>icône</label><input class='col-sm-3' type='button' id='fileDisplay' value='Choisir un fichier'><input id='fileHidden' type='file' name='icone'/></div>
				<div class='row'><label class='col-sm-12 col-xs-12' style='text-align: center' for='description'>Description</label></div><div class='row'><textarea id='wysiwyg' class='col-sm-10 col-sm-push-1' name='description'>".$this->_description."</textarea></div>
				<div class='row'>
					".$this->_action."
				</div>
				".$ajouterBtn."
			</form>";
			echo "</div>";			
		}



		// if(!isset())
		// echo "<form method='POST' action enctype='multipart/form-data'>
		// 	<h2>Ajouter un nouvel axe stratégique</h2>
		// 	<div class='row'><label class='col-sm-4' for='nom'>Nom</label><input class='col-sm-6' type='text' name='nom'/></div>
		// 	<div class='row'><label class='col-sm-4' for='icone'>icone</label><input class='col-sm-6' type='button' id='fileDisplay' value='fichier'><input id='fileHidden' type='file' name='icone'/></div>
		// 	<div class='row'><label class='col-sm-4 col-xs-12' for='description'>Description</label></div><div class='row'><textarea class='col-sm-10 col-sm-push-1' name='description'></textarea></div>
		// 	<div class='row'>
		// 		<input type='submit' value='enregistrer' name='enregistrer'/>
		// 	</div>
		// </form>";
	}
}
?>

