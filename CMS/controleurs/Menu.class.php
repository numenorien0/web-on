<?php

class Menu extends DB
{
	private $_db;
	private $_language;
	private $_langue_principale;
	private $_currentLang;
	private $_wireframe;
	
	public function __construct()
	{
		$this->_db = parent::__construct();
		$this->_language = $this->list_all_language();
		$this->_langue_principale = $this->_language[0];
		if(!isset($_GET['lang']))
		{
			$this->_currentLang = $this->_langue_principale;
		}	
		else
		{
			$this->_currentLang = $_GET['lang'];
		}
		if(isset($_POST['submitMenu']))
		{
			$this->save();
		}
		if(file_get_contents("content/menu/disposition.txt"))
		{
			$this->_wireframe = file_get_contents("content/menu/disposition.txt");
		}
		else
		{
			$this->_wireframe = "1";
		}
		
		if(parent::ecommerce_is_actived())
		{
			if(file_exists("content/menu/type.txt"))
			{
				$type = file_get_contents("content/menu/type.txt");
				if($type == "ecommerce")
				{
					if($_GET['action'] == "change")
					{
						
					}
					else
					{
						header("location: menuEcommerce.php");
					}
				}
			}
		}
		file_put_contents("content/menu/type.txt", "classique");
	}

	public function get_wireframe_menu()
	{
		echo "<div id='wireframe'>";
		echo "<h3 style='margin-left: 0; margin-top: 0'>Liste de toutes les disposition de menu disponibles</h3>";
		
		echo "<div class='wireListe'>";
		$repertoire = "wireframes/Menu/";
		
		$repertoire = scandir($repertoire);
		
		foreach($repertoire as $dossier)
		{
			
			if($dossier != "." AND $dossier != "..")
			{
				
				$image = "wireframes/Menu/".$dossier."/preview_2.png";
				$description = file_get_contents("wireframes/Menu/$dossier/info.txt");
				echo "<div class='col-lg-4 col-md-4 col-sm-4'><div data-id='$dossier' class='wireframe_page'><img style='width: 100%;' src='$image'><div style='display: none' class='desc'>$description</div></div></div>";
			}
		}
		echo "</div>";
		echo "</div>";
		
	}
	
	public function get_current_wireframe_menu()
	{
		$image = "wireframes/Menu/".$this->_wireframe."/preview_2.png";
		$description = file_get_contents("wireframes/Menu/".$this->_wireframe."/info.txt");		
		#echo "<input type='hidden' id='display' name='display' value='".$wireframe."'/>";
		echo "<div class='wireframe_page'><img class='wireframe_image' style='width: 100%;' src='$image'><br/><br/></div><div class=''><div class='wireframe_description'>$description</div><br/><br/><a id='changeWireframePage' class='linkButton'>Changer</a></div>";		
	}
	
	public function save()
	{	
		if(!file_exists("content/menu"))
		{
			mkdir("content/menu");
		}
		if(!file_exists("content/menu/".$this->_currentLang));
		{
			mkdir("content/menu/".$this->_currentLang);
		}	
		
		#fopen("custom/menu/".$this->_currentLang."/code.json", "w+");
		//$code = json_decode($_POST['code'], true);
		$code = $_POST['code'];
		$topmenu = $_POST['top-menu'];
		$wireframe = $_POST['display'];
		$customField = $_POST['customField'];
		file_put_contents("content/menu/meta.txt", $customField);
		file_put_contents("content/menu/disposition.txt", $wireframe);
		#echo $code;
		file_put_contents("content/menu/".$this->_currentLang."/code.json", $code);
		if($topmenu == null){
			@unlink("content/menu/".$this->_currentLang."/topmenu.php");
		}
		else
		{
			file_put_contents("content/menu/".$this->_currentLang."/topmenu.php", $topmenu);
		}
		echo "<div class='col-sm-12 cadre' style='margin-bottom: 0px'><div class='success' id='state_success'>Menu mis à jour avec succès</div></div>";
		header("location: menu.php");
	}
	
	public function listAllByKeyword()
	{
		if($_GET['lang'] != null)
		{
			$sql = "SELECT * FROM contenu INNER JOIN contenu_traduction ON contenu.ID = contenu_traduction.contenu WHERE contenu_traduction.nom LIKE '%".$_GET['key']."%' AND contenu_traduction.langue = '".$this->_currentLang."'";
		}
		else
		{
			$sql = "SELECT * FROM contenu WHERE contenu.nom LIKE '%".$_GET['key']."%'";
		}
		
		$reponse = $this->_db->query($sql);
		echo "<ul style='height: 250px; overflow: auto' id='listePageMenu'>";
		while($donnees = $reponse->fetch())
		{
			$link = $this->_currentLang."/".$donnees['nameURL']."/";
			echo "<li data-link='".$link."' data-id='".$donnees['ID']."' class='main-page'>".$donnees['nom']."</li>";
			
			
		}
		echo "</ul>";		
	}	
	
	public function list_main_pages()
	{
		
		if($_GET['lang'] != null)
		{
			$sql = "SELECT * FROM contenu INNER JOIN contenu_traduction ON contenu.ID = contenu_traduction.contenu WHERE contenu_traduction.nom != '' AND contenu.parent = '' AND contenu_traduction.langue = '".$this->_currentLang."'";
		}
		else
		{
			$sql = "SELECT * FROM contenu WHERE parent = ''";
		}
		
		$reponse = $this->_db->query($sql);
		echo "<ul style='height: 300px; overflow-y: auto; overflow-x: hidden' id='listePageMenu'>";
		#echo "<li style='width: 45%; text-align: center; background-color: #4fd06b; color: white' data-link='choice_lang' data-id='' class='main-page'>+ Bouton langues</li>";
		while($donnees = $reponse->fetch())
		{
			if($_GET['lang'] != null)
			{
				$id = $donnees['contenu'];
			}
			else
			{
				$id = $donnees['ID'];
			}
			$link = $this->_currentLang."/".$donnees['nameURL']."/";
			echo "<li data-link='".$link."' data-id='".$donnees['ID']."' class='main-page'>".$donnees['nom']."</li>";
			
			
		}
		echo "</ul>";
		
	}

	public function list_all_language()
	{
		$sql = "SELECT * FROM systeme WHERE nom = 'langue_principale'";
		$reponse = $this->_db->query($sql);
		
		$reponse = $reponse->fetchAll()[0];
		
		$langue_principale = $reponse['valeur'];
		$input = array();
		$input[] = $langue_principale;
		$sql = "SELECT * FROM systeme WHERE nom = 'langue_secondaire'";
		$reponse = $this->_db->query($sql);
		
		while($donnees = $reponse->fetch())
		{
			$input[] = $donnees['valeur'];
		}
		
		return $input;		
	}	
	
	public function display_all_language()
	{
		$input = "<input type='hidden' id='currentLang' value='".$_GET['lang']."'/>";
		//$liste_langue = array("fr" => "Français", "en" => "Anglais", "de" => "Allemand", "nl" => "Néerlandais", "es" => "Espagnol", "it" => "Italien", "po" => "Portugais");
		$liste_langue = parent::listAllLang();
		foreach($this->_language as $langue)
		{
			if($langue == $this->_langue_principale)
			{
				$main = "data-main='true'";
			}
			else
			{
				$main = "data-main='false'";
			}
			$input .= "<div data-lang='".$langue."' ".$main." style='margin-bottom: 0px !important; margin-top: 10px' data-lang-name='".$liste_langue[$langue]."' class=' btn_lang'>".strtoupper($langue)."</div>";
		}
		return $input;
	}
	
	public function display_code()
	{
		if(file_exists("content/menu/".$this->_currentLang."/code.json"))
		{
			$contenu = file_get_contents("content/menu/".$this->_currentLang."/code.json");
		}
		else
		{
			$contenu = "[]";
		}
		if(file_exists("content/menu/".$this->_currentLang."/topmenu.php"))
		{
			$topmenu = file_get_contents("content/menu/".$this->_currentLang."/topmenu.php");
		}
		else
		{
			$topmenu = "";
		}
		$customField = file_get_contents("content/menu/meta.txt");
		
		echo "<input type='hidden' id='display' name='display' value='".$this->_wireframe."'/>";
		echo '<textarea name="code" style="width: 100%" id="code">
						'.$contenu.'
					</textarea>';
		echo "<textarea id='topmenu' style='display: none' name='top-menu'>".$topmenu."</textarea>";			
		echo "<input type='submit' value='enregistrer' name='submitMenu' style='float: right'/>";
		echo "<a href='#' id='custom-meta' style='float: right; background: #5195c5; margin-right: 15px; margin-top: 5px' class='linkButton'>Metas personnalisées</a>&nbsp&nbsp";
		echo "<textarea style='width: 100%' placeholder='renseignez ici vos métas personnalisées' name='customField' id='custom-meta-field'>$customField</textarea>";	
	}	
		
}	
?>

