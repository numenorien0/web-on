<?php
class listContent extends DB
{
	private $_db;
	private $_parent = "";
	private $_mainTitre = "<a href='listContent.php'>Pages principales</a>";
	private $_titre = "";
	private $_advanced;
	private $_display;

	public function __construct()
	{
		
		$this->_db = parent::__construct();
		if(isset($_GET['alias']) AND $_GET['alias'] != null)
		{
			$this->createAlias();
		}
		if(isset($_GET['delete']) AND $_GET['delete'] != null)
		{
			$this->delete();
		}
		if(isset($_POST['changeDisplayForChildren']))
		{
		    $this->changeDisplayForChildren();
		}
		$_SESSION['arborescence'] = $_GET['parent'];
		//echo $_SESSION['itemPerPage'];
		if(!isset($_SESSION['itemPerPage']))
		{
			 
			//session_start();
			$_SESSION['itemPerPage'] = 20;
			header("location: listContent.php?parent=".$_GET['parent']);
		}
		if(isset($_GET['numberItem']))
		{
			$_SESSION['itemPerPage'] = $_GET['numberItem'];
		}
		echo "<input type='hidden' id='numberItem' value='".$_SESSION['itemPerPage']."'>";
		$this->listAll();
	}

    public function changeDisplayForChildren()
    {
        $sql = "UPDATE contenu SET display = '".$_POST['display']."' WHERE parent = '".$_GET['parent']."'";
        $reponse = $this->_db->query($sql);
        $sql = "UPDATE contenu SET baseStyle = '".$_POST['display']."' WHERE ID = '".$_GET['parent']."'";
        $reponse = $this->_db->query($sql);
    }

    public function get_skin()
    {
        $sql = "SELECT * FROM systeme WHERE nom = 'skin'";
        $reponse = $this->_db->query($sql);

		while($donnees = $reponse->fetch())
		{
			$this->_skin = $donnees['valeur'];
		}
    }

    public function get_wireframe_page($wireframe)
	{
		//echo "<div id='wireframe'>";
		//echo "<h3>Liste de toutes les dispositions de page disponible</h3>";
		$this->get_skin();
		//echo "<div class='wireListe col-sm-8'>";
		#$repertoire = "wireframes/Pages/";
	    $repertoire = "themes/".$this->_skin."/pages/";
	    $directory = $repertoire;
		echo "<form style='margin-top: 30px; border-top: 1px solid #dadada' method='POST' action><label>Squelette des pages du dossier : </label> &nbsp;&nbsp;<select style='min-width: 100px !important; margin-right: 30px; width: 200px !important' name='display'>";
		$repertoire = scandir($repertoire);
		
		if(!isset($_POST['display']))
		{
			if(isset($wireframe))
    		{
    		    $wireframe = $wireframe;
    		}
    		else
    		{
    		    $wireframe = "";
    		}
		}
		else
		{
			$wireframe = $_POST['display'];
		}		
		foreach($repertoire as $dossier)
		{
			
			if($dossier != "." AND $dossier != "..")
			{
				if($wireframe == $dossier)
				{
					$checked = "selected";
				}
				else
				{
					$checked = "";
				}
				$file = file_get_contents($directory.$dossier);
				$name = $dossier;
				if(preg_match("/\<\!\-\- name:(.+?)\-\-\>/", $file, $match)){
				    $name = $match[1];    
				}
				
				//$image = "wireframes/Pages/".$dossier."/preview_2.png";
				//$description = file_get_contents("wireframes/Pages/$dossier/info.txt");
				//echo "<div class='col-lg-3 col-md-3 col-sm-4'><div data-id='$dossier' class='$checked wireframe_page'><img style='width: 100%;' src='$image'><div style='display: none' class='desc'>$description</div></div></div>";
			    echo "<option value='$dossier' $checked >$name</option>";
			    
			}
		}
		echo "</select><input type='submit' value='Changer' name='changeDisplayForChildren' />";

		
	}

	public function createAlias()
	{
		$sql = "SELECT * FROM contenu WHERE ID = ".$_GET['alias'];
		$reponse = $this->_db->query($sql);
		
		while($donnees = $reponse->fetch())
		{
			$nom = str_replace("'", "''", $donnees['nom']);
			$ID = $donnees['ID'];
			$permissions = $donnees['autorisations'];
			$parent = $donnees['parent'];
			$order = $donnees['orderID'];
			$online = $donnees['online'];
			
			$sql2 = "INSERT INTO contenu(nom, parent, online, autorisations, orderID, copyOf) VALUES('$nom', '".$_GET['parent']."','$online', '$permissions', '$order', '$ID')";
			$reponse2 = $this->_db->exec($sql2);
		}
		
		header("location: listContent.php?parent=".$_GET['parent']);
		
		
	}

	public function advancedMod()
	{
		$sql = "SELECT * FROM systeme WHERE nom = 'advanced_mod'";
		$reponse = $this->_db->query($sql);

		while($donnees = $reponse->fetch())
		{
			$this->_advanced = $donnees['valeur'];
		}
	}

	public function delete()
	{
		if($this->verificationPermissionsSuppression($_GET['delete']) == true)
		{
			$sql = "SELECT * FROM contenu WHERE parent = ".$_GET['delete'];
			$reponse = $this->_db->query($sql);
	
			if($reponse->rowCount() != 0)
			{
				echo "<div class='row cadre'>";
				echo "<div class='fail'>Impossible de supprimer une page/un bloc qui possède des sous-pages</div>";
				echo "</div>";
			}
			else
			{
				$sql = "SELECT * FROM contenu WHERE ID = ".$_GET['delete'];
				$reponse = $this->_db->query($sql);
	
				while($donnees = $reponse->fetch())
				{
					if(@unlink("content/images/".$donnees['image']) OR $donnees['image'] == "" OR !file_exists("content/images/".$donnees['image']))
					{
						$sql2 = "DELETE FROM contenu WHERE ID = ".$_GET['delete'];
						$reponse2 = $this->_db->exec($sql2);
	
						$sql2 = "DELETE FROM contenu_traduction WHERE contenu = ".$_GET['delete'];
						$reponse2 = $this->_db->exec($sql2);
						
						$sql2 = "DELETE FROM contenu WHERE copyOf = ".$_GET['delete'];
						$reponse2 = $this->_db->exec($sql2);						
						
						$sql2 = "DELETE FROM contenu_recoveru WHERE page = ".$_GET['delete'];
						$reponse2 = $this->_db->exec($sql2);
						
						echo "<div class='row cadre'>";
						echo "<div class='success'>Page supprimée avec succès</div>";
						echo "</div>";
	
					}
					else
					{
						echo "<div class='row cadre'>";
						echo "<div class='fail'>Erreur lors de la suppression de l'image de la page</div>";
						echo "</div>";
					}
				}
			}
		}
		else
		{
			echo "<div class='row cadre'>";
			echo "<div class='fail'>Vous n'avez pas la permission de supprimer cette page</div>";
			echo "</div>";		
		}
	}

	public function ListParent($parent)
	{
		$sql2 = "SELECT * FROM contenu WHERE ID = '$parent'";
		$reponse2 = $this->_db->query($sql2);

		while($donnees2 = $reponse2->fetch())
		{
			$this->_titre = " > "."<a href='listContent.php?parent=".$donnees2['ID']."'>".$donnees2['nom']."</a>".$this->_titre;
			if($donnees2['parent'] != "")
			{
				$this->listParent($donnees2['parent']);
			}
		}
	}

	public function verificationPermissionsEdition()
	{
		if(isset($_GET['parent']) AND $_GET['parent'] != null)
		{
			$sql = "SELECT * FROM contenu WHERE ID = ".$_GET['parent'];
			$reponse = $this->_db->query($sql);
			
			while($donnees = $reponse->fetch())
			{
				$permissions = $donnees['autorisations'];
				$permissions = json_decode($permissions, TRUE);
	
				$id = $_SESSION['ID'];
				//echo $permissions['editionPermission'][$id];
				if(!isset($permissions['editionPermission'][$id]))
				{
					#echo "<div class='col-sm-12 cadre fail'>vous n'avez pas la permission d'éditer cette page</div>";
					return false;
				}
				else
				{
					return true;
				}
			}
		}
		else
		{
			return true;
		}
	}
	
	public function verificationPermissionsSuppression($id)
	{
		$sql = "SELECT * FROM contenu WHERE ID = ".$id;
		$reponse = $this->_db->query($sql);
		
		while($donnees = $reponse->fetch())
		{
			$permissions = $donnees['autorisations'];
			$permissions = json_decode($permissions, TRUE);

			$id = $_SESSION['ID'];
			//echo $permissions['editionPermission'][$id];
			if(!isset($permissions['suppressionPermission'][$id]))
			{
				
				#echo "<div class='col-sm-12 cadre fail'>vous n'avez pas la permission d'éditer cette page</div>";
				return false;
			}
			else
			{
				return true;
			}
		}
	}


	public function ListAll()
	{
		echo "<input type='hidden' value='".$_GET['parent']."' id='parentHidden'/>";
		
		if(!isset($_GET['list']) OR $_GET['list'] != "sort")
		{
		    
			echo "<div class='cadre row numberItemSelect'>Nombre de ligne à afficher <select>
				<option>1</option>
				<option>5</option>
				<option>10</option>
				<option>20</option>
				<option>30</option>
				<option>40</option>
				<option>50</option>
				<option>100</option>
				<option>200</option>
				<option>Tous</option>
			</select>
			<a href='listContenuSettings.php?ID=".$_GET['parent']."' id='logoSettings'>Champs personnalisés</a><a href='template.php' style='margin-right: 15px' id='logoSettings'>Modèle de contenu</a></div>";
		}
		else
		{
			echo "<style>.actionPages{display: none} .visiblePage:hover{cursor: all-scroll}</style>";
		}
		if(parent::is_admin())
		{
			$menu = "<a href='menu.php' class='personnaliser' type='button'>Personnaliser</a>";
		}
		else
		{
			$menu = "";
		}
		
		if(!isset($_GET['list']) OR $_GET['list'] != "sort")
		{
			echo "<div class='cadre row' style='padding-bottom: 0'>";
			echo "<h3 id='menuHelp' style='margin-bottom: 0px !important'>Menu$menu</h3>";
			echo "";
			echo "</div>";
		}
		
		
		if(isset($_GET['parent']))
		{
			$this->_parent = $_GET['parent'];
			$parentForButton = "?parent=".$this->_parent;
			$this->ListParent($this->_parent);
			$editThisOne = "<a class='createPage' style='margin-top: -7px; font-size: 10px; text-transform: none; padding: 5px !important; height: auto; margin-left: 10px;' href='editContent.php?id=".$_GET['parent']."'>Editer cette page</a>"; 
		}
		else
		{
			$this->_mainTitre = "Pages principales";
			$this->_titre = "";
			$parentForButton = "";
			$editThisOne = "";
		}

		$this->_titre = $this->_mainTitre.$this->_titre;
		
		$sql = "SELECT * FROM contenu WHERE parent = '".$this->_parent."' ORDER BY orderID DESC";
		$reponse = $this->_db->query($sql);

		$this->advancedMod();


		echo "<div class='cadre row' id='listeDesPages' contextmenu='contextListe'>";
		echo "<h3 id='listeDuContenu' style='margin-bottom: 0px !important'>$this->_titre $editThisOne</h3>";
		
		#echo "<span class='col-sm-12 explicationArborescence'><img src='images/caution2.png' class='caution'>Cliquez sur le nom de la page pour afficher les sous-pages ou articles de la page.</span>";
		if($reponse->rowCount() == 0)
		{
			echo "<div class='PasDePage ligne row'><div class='col-sm-12'>Pas encore de bloc</div></div>";
		}
		if( ( $this->_advanced == "true" OR $parentForButton != "" ) AND $this->verificationPermissionsEdition() == true)
		{
			echo "<div class='createPageContainer'><a class='createPage' href='addContent.php$parentForButton'><strong>+ Ajouter une page/bloc</strong></a></div>";
		}
		echo "<div id='containerLigne'>";
		$compteurPaire = 0;
		while($donnees = $reponse->fetch())
		{	
		    $this->_display = $donnees['display'];
			if($donnees['homepage'] == "on")
			{
				$homepage = "<span class='homepageTitle'> (Page d'accueil)</span>";
			}
			else
			{
				$homepage = "";
			}
			$compteurPaire++;
			if($compteurPaire%2 == 0)
			{
				$classe = "paire";
			}
			else
			{
				$classe = "";
			}
			$sqlX = "SELECT * FROM contenu WHERE parent = ".$donnees['ID'];
			$reponseX = $this->_db->query($sqlX);
			
			if($reponseX->rowCount() == 0)
			{
				$iconeBefore = "<img src='images/file.png' class='iconeBefore'/>";
			}
			else
			{
				$iconeBefore = "<img src='images/folder.png' class='iconeBefore'/>";
			}
			if(isset($donnees['copyOf']) AND $donnees['copyOf'] != null)
			{
				$IDAction = $donnees['copyOf'];	
				$alias = "<span class='homepageTitle'> (Alias)</span>";
				$iconeBefore = "<img src='images/shortcut.png' class='iconeBefore'/>";
				$classeAlias = "alias";
				$IDAlias = "data-alias='".$donnees['ID']."'";
				$context = "contextAlias";
			}
			else
			{
				$IDAction = $donnees['ID'];
				$alias = "";
				$classeAlias = "";
				$IDAlias = "data-alias='".$donnees['ID']."'";
				$context = "contextOpenRepertoire";
			}			
			if(isset($_GET['parent']) AND $_GET['parent'] != null)
			{
				$urlToDelete = "?parent=".$this->_parent."&delete=".$donnees['ID'];
				$deleteBtn = "<div class='btnDel'><div data-id='".$urlToDelete."' class='delete'>&#10006;</div></div>";
			}
			else
			{
				$urlToDelete = "?delete=".$donnees['ID'];
				if($this->_advanced == "true")
				{
					$deleteBtn = "<div class='btnDel'><div data-id='".$urlToDelete."' class='delete'>&#10006;</div></div>";
				}
				else
				{
					$deleteBtn = "";
				}
			}
			if($donnees['online'] == "on")
			{
				$online = "<div class='online'></div>";
			}
			else
			{
				$online = "<div class='offline'></div>";
			}
			$viewBtn = "<div class='btnDel' style='display: inline-block; float: left'><div data-id='".$donnees['nameURL']."' class='view' style='line-height: 0px; margin-top: 2px; padding: 2px !important'><img style='height: 20px; margin-top: 2px;' src='images/eye.png'/></div></div>";
			echo "<div data-order='".$donnees['orderID']."' data-parent='".$donnees['parent']."' class='$classe ligne visiblePage row'><div ".$IDAlias." data-id='".$IDAction."' contextmenu='$context' class='$classeAlias openRepertoire col-sm-9 col-md-9 col-lg-9 titre'>".$online.$iconeBefore.strip_tags($donnees['nom']).$homepage.$alias."</div><div class='actionPages col-sm-3 col-md-3 col-lg-3'>".$viewBtn."<div class='col-sm-7'><div data-id='".$IDAction."' class='edit'>Afficher les blocs</div></div><div class='col-sm-4 hidden'><div data-id='".$donnees['ID']."' class='child'>Répertoire</div></div>".$deleteBtn."</div></div>";
		}
		
		echo "</div></div>";
		$this->get_wireframe_page($this->_display);
		
		if(!isset($_GET['list']) OR $_GET['list'] != "sort")
		{
			echo "<div class='cadre row'  style='padding-bottom: 0'>";
			
			if(parent::is_admin())
			{
				$footer = "<a href='footer.php' class='personnaliser' type='button'>Personnaliser</a>";
			}
			else
			{
				$footer = "";
			}		
			
			echo "<h3 id='footerHelp' style='margin-bottom: 0px !important'>Pied de page$footer</h3>";
			echo "";
			echo "</div>";
		}
	}
}
?>

