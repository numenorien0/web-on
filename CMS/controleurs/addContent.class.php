<?php
class addContent extends DB
{
	private $_db;
	private $_listeErreur = array();
	private $_erreur = 0;
	private $_nom;
	private $_description;
	private $_image;
	private $_medias;
	private $_texte;
	private $_child;
	private $_parent;
	private $_online;
	private $_important;
	private $_commentaire;
	private $_auteur;
	private $_date;
	private $_nomDuFichier;
	private $_titre;
	private $_keywords;
	private $_champsPerso;
	private $_language;
	private $_langue_principale;
	private $_homepage;
	private $_lien;
	private $_SEO_description;
	private $_miniatures_default;
	private $_style;
	private $_baseMiniature;
	private $_baseStyle;
	private $_skin;
	
	public function __construct()
	{
		$this->_db = parent::__construct();
		$this->_language = $this->list_all_language();
		$this->_langue_principale = $this->_language[0];
		$this->get_skin();
		if(isset($_GET['parent']) and $_GET['parent'] != null)
		{
			$this->_parent = $_GET['parent'];
		}
		if(isset($_POST['valider']) AND $_POST['valider'] != null)
		{
			$this->verification();
		}
		
		$this->afficher();
		
	}
	
	public function generateSlug($phrase, $maxLength)
    {
        $result = strtolower($phrase);
    
        $result = preg_replace("/[^a-z0-9\s-]/", "", $result);
        $result = trim(preg_replace("/[\s-]+/", " ", $result));
        $result = trim(substr($result, 0, $maxLength));
        $result = preg_replace("/\s/", "-", $result);
        $sql = "SELECT ID FROM contenu WHERE nameURL = '".$result."'";
        $reponse = $this->_db->query($sql);
        //$reponse = $reponse->fetchAll();
        $nombre = $reponse->rowCount();
        if($nombre > 0)
        {
            return $result."-".($nombre);
        }
        else
        {
            return $result;
    
        } 
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
    
	public function createThumbs( $pathToImages, $pathToThumbs, $thumbWidth ) 
	{
	    $info = pathinfo($pathToImages);
	    if ( strtolower($info['extension']) == 'jpg' ) 
	    {

	      $img = imagecreatefromjpeg($pathToImages);
	      $width = imagesx( $img );
	      $height = imagesy( $img );
	
		  if($width > 1920)
		  {
		      // calculate thumbnail size
		      $new_width = $thumbWidth;
		      $new_height = floor( $height * ( $thumbWidth / $width ) );
		
		      // create a new temporary image
		      $tmp_img = imagecreatetruecolor( $new_width, $new_height );
		
		      // copy and resize old image into new image 
		      imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
		
		      // save thumbnail into a file
		      imagejpeg( $tmp_img, $pathToThumbs, 70);
		   }
	    }
	    if(strtolower($info['extension']) == "png")
	    {
	      $img = imagecreatefrompng($pathToImages);
	      $width = imagesx( $img );
	      $height = imagesy( $img );
	
		  if($width > 1920)
		  {
		      // calculate thumbnail size
		      $new_width = $thumbWidth;
		      $new_height = floor( $height * ( $thumbWidth / $width ) );
		
			  $im = ImageCreateFromPNG($pathToImages);

				$im_dest = imagecreatetruecolor ($new_width, $new_height);
				imagealphablending($im_dest, false);
				
				imagecopyresampled($im_dest, $im, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
				
				imagesavealpha($im_dest, true);
				imagepng($im_dest, $pathToThumbs);
	        }   
	    }
	}
	public function convertPNGto8bitPNG($sourcePath, $destPath) {
		$srcimage = imagecreatefrompng($sourcePath);
		list($width, $height) = getimagesize($sourcePath);
		$img = imagecreatetruecolor($width, $height);
		$bga = imagecolorallocatealpha($img, 0, 0, 0, 127);
		imagecolortransparent($img, $bga);
		imagefill($img, 0, 0, $bga);
		imagecopy($img, $srcimage, 0, 0, 0, 0, $width, $height);
		imagetruecolortopalette($img, false, 255);
		imagesavealpha($img, true);
		imagepng($img, $destPath);
		imagedestroy($img);
	}


	public function verification()
	{
		$langue_principale = $this->_language[0];
		$champs_perso = array();
		
		foreach($_FILES['customFile'] as $name => $customFieldFile)
        {
            foreach($customFieldFile as $lang => $field)
            {
                foreach($field as $nom => $champs)
                {
                    if($champs != null)
                    {
                        if(move_uploaded_file($_FILES['customFile']['tmp_name'][$lang][$nom], "content/images/".$_FILES['customFile']['name'][$lang][$nom]))
                        {
                            $_POST['input'][$lang][$nom] = $_FILES['customFile']['name'][$lang][$nom];
                    
                        }    
                    }
                }
            }
        
        }
		
		
		foreach($_POST['input'] as $input => $key)
		{
			$champs_perso[$input] = str_replace("'","''",$key);
			//echo $input." ".$key."<br/>";
		}
		//$champs_perso = addslashes(json_encode($champs_perso,JSON_FORCE_OBJECT|JSON_UNESCAPED_UNICODE));
		$this->_champsPerso = $champs_perso;
		
		$this->_keywords = str_replace("'","''",$_POST['keywords']);
		
		foreach($_POST['texte'] as $key => $texte)
		{
			$this->_texte[$key] = str_replace("'","''",$texte);
		}

		foreach($_POST['description'] as $key => $description)
		{
			$description = str_replace("\n", "<br/>", $description);
			$this->_description[$key] = str_replace("'","''",$description);
		}
		
		foreach($_POST['lien'] as $key => $lien)
		{
			$this->_lien[$key] = str_replace("'","''",$lien);
		}
		
		foreach($_POST['SEO_description'] as $key => $SEO_description)
		{
			$this->_SEO_description[$key] = str_replace("'", "''", $SEO_description);
		}
		foreach($_POST['nom'] as $key => $nom)
		{
			$this->_nom[$key] = str_replace("'","''",$nom);
		}
		
		
		if($_POST['nameURL'] != null)
		{
		    $this->_nameURL = $_POST['nameURL'];
		}
		else
		{
		    $this->_nameURL = $this->_nom[$this->_langue_principale];
		}
		
		$this->_style = $_POST['style'];
		$this->_style = addslashes(json_encode($this->_style,JSON_FORCE_OBJECT|JSON_UNESCAPED_UNICODE));
		
		
		if(isset($_POST['imposedStyle']))
		{
			$this->_baseMiniature = $_POST['miniatures'];
			$this->_baseStyle = $this->_style;
		}
		//print_r($this->_description);
		
		$this->_image = $_POST['realImage'];
		if($this->_image == null)
		{
			$this->_image == "null";
		}
		$this->_commentaire = @$_POST['commentaire'];
		$this->_online = @$_POST['online'];
		$this->_auteur = $_SESSION['login'];
		$this->_date = time();
		$this->_child = "";
		$this->_important = @$_POST['important'];
		$this->_medias = @$_POST['medias'];
		$this->_homepage = @$_POST['homepage'];
		/*if($this->_image['name'] != "")
		{
			if($this->_image['type'] != "image/jpg" AND $this->_image['type'] != "image/jpeg" AND $this->_image['type'] != "image/png" AND $this->_image['type'] != "image/gif" AND $this->_image['type'] != "video/mp4")
			{
				$this->_erreur++;
				$this->_listeErreur[] = "Le format n'est pas supporté";
			}
		}*/
		
		if($this->verificationPermissionsEdition() == false)
		{
			$this->_erreur++;
			$this->_listeErreur[] = "Vous n'avez pas la permission de créer une page ici";			
		}
		
		if($this->_nom[$this->_langue_principale] == null)
		{
			$this->_erreur++;
			$this->_listeErreur[] = "Merci de renseigner un nom";
		}
		/*if($this->_description == null)
		{
			$this->_erreur++;
			$this->_listeErreur[] = "Merci de renseigner une description";
		}*/

		if(!isset($this->_online))
		{
			$this->_online = "off";
		}
		else
		{
			$this->_online = "on";
		}
		if(!isset($this->_important))
		{
			$this->_important = "off";
		}
		else
		{
			$this->_important = "on";
		}
		if(!isset($this->_homepage))
		{
			$this->_homepage = "off";
		}
		else
		{
			$this->_homepage = "on";
		}
		if(!isset($this->_commentaire))
		{
			$this->_commentaire = "off";
		}
		else
		{
			$this->_commentaire = "on";
		}
// 		echo $this->_baseMiniature." OK";

		if($this->_erreur == 0)
		{
			$this->ajouter();
		}
	}

	public function listAllMedias()
	{
		$string ="<option>Aucun</option>";
		$string .= "<optgroup label='Albums photos'>";
		$sql = "SELECT * FROM medias WHERE type='photo'";
		$reponse = $this->_db->prepare($sql);
		$reponse->execute();
		while($donnees = $reponse->fetch())
		{
			$string .= "<option value='".$donnees['ID']."'>".$donnees['nom']."</option>";
		}
		$string .= "<option>----> Ajouter un album</option></optgroup>";
		$string .= "<optgroup label='Vidéos'>";
		$sql = "SELECT * FROM medias WHERE type='video'";
		$reponse = $this->_db->prepare($sql);
		$reponse->execute();
		while($donnees = $reponse->fetch())
		{
			$string .= "<option value='".$donnees['ID']."'>".$donnees['nom']."</option>";
		}

		$string .= "<option>----> Ajouter une vidéo</option></optgroup>";
		
		
		
		$plugins = scandir("plugins");
		
		foreach($plugins as $plugin)
		{
			//echo $plugin."widgets <br/>";
			if(file_exists("plugins/".$plugin."/widgets"))
			{
				$plugin = file_get_contents("plugins/".$plugin."/infos/".$plugin.".xml");
				$plugin = new SimpleXMLElement($plugin);
				$nomDuPlugin = $plugin->id;
				$nomComplet = $plugin->name;
				$string .= "<optgroup label='$nomComplet'>";
				$widgets = scandir("plugins/".$nomDuPlugin."/widgets");
				
				foreach($widgets as $widget)
				{
					if($widget != "." AND $widget != ".." AND !strstr($widget, ".json") !== false)
					{
						$string .= "<option value='".$nomDuPlugin."-_-".$widget."'>".str_replace(".php", "", $widget)."</option>";
					}
				}
			}	
				
			
		}
		
		
		
		
		
		
		return $string;
	}
	
	public function get_wireframe_page()
	{
		//echo "<div id='wireframe'>";
		//echo "<h3>Liste de toutes les dispositions de page disponible</h3>";
		$sql = "SELECT baseStyle FROM contenu WHERE ID = '".$_GET['parent']."'";
		$reponse = $this->_db->query($sql);
		
		$style = $reponse->fetchAll()[0]['baseStyle'];
		//echo "<div class='wireListe col-sm-8'>";
		$repertoire = "themes/".$this->_skin."/pages/";
		$directory = $repertoire;
		//echo $repertoire;
		echo "<label>Squelette de la page : </label> &nbsp;&nbsp;<select name='display'>";
		$repertoire = scandir($repertoire);
		if(!isset($_POST['display']))
		{
			if($style != null)
			{
				$wireframe = $style;
			}
			else{
				$wireframe = "01";
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
		echo "</select><br/><br/>";
		
	}
	
	public function get_wireframe_miniatures()
	{
		echo "<div id='miniaturesChoice'>";
		echo "<h3>Liste de toutes les dispositions de miniatures disponibles</h3>";
		
		echo "<div class='wireListe col-sm-8'>";
		$repertoire = "wireframes/Miniatures/";
		
		$repertoire = scandir($repertoire);
		
		$arrayType = array();
		$wireframeListe = array();

		if(!isset($_POST['miniatures']))
		{
			$wireframe = "blog_01";
		}
		else
		{
			$wireframe = $_POST['miniatures'];
		}
		
		$arrayType[] = "<a href='#' class='active filter_miniatures'>Tout</a>";
		$arrayFilter = array();
		
		foreach($repertoire as $dossier)
		{	
			$type = explode("_", $dossier);
			$type = $type[0];
			$type_formatted = str_replace(" ", "-", $type);
			
			if(in_array($type, $arrayFilter) == 0 AND $type != "." AND $type != "..")
			{
				$arrayFilter[] = $type;
				$arrayType[] = "<a class='filter_miniatures' data-filter='$type_formatted' href='#'>".ucfirst($type)."</a>";
				
			}
			
			if($dossier != "." AND $dossier != "..")
			{
				if($wireframe == $dossier)
				{
					$checked = "activeWireframe";
				}
				else
				{
					$checked = "";
				}
				$image = "wireframes/Miniatures/".$dossier."/preview_2.png";

				$description = file_get_contents("wireframes/Miniatures/$dossier/info.txt");
				$wireframeListe[] = "<div data-filter='filter-$type_formatted' class='col-lg-3 col-md-3 col-sm-4'><div data-id='$dossier' class='$checked wireframe_miniatures'><img src='$image' style='max-width: 100%; max-height: 100%'/><div style='display: none' class='desc'>$description</div></div></div>";
			}
		}
		//print_r($wireframeListe);
		echo "<div class='wireframe_filtre'>".implode("", $arrayType)."</div>";
		echo implode("", $wireframeListe);
		echo "</div>";
		$source = "wireframes/Miniatures/$wireframe/preview_2.png";
	
		echo "<div class='apercuWireframe col-sm-4'><h3>Aperçu</h3><div class='apercuContent'><img src='$source' style='max-width: 100%; max-height: 100%'/></div></div>";
		echo "</div>";
		
	}	
	
	public function get_current_wireframe_miniatures()
	{
	
		if(!isset($_POST['miniatures']))
		{
			if(isset($_GET['parent']) AND $_GET['parent'] != null)
			{
				$sql = "SELECT * FROM contenu WHERE ID = :id_parent";
				$reponse = $this->_db->prepare($sql);
				$reponse->bindParam(':id_parent', $_GET['parent']);
				$reponse->execute();
				
				while($donnees = $reponse->fetch())
				{
					if($donnees['baseMiniature'] != "")
					{
						$wireframe = $donnees['baseMiniature'];
					}
					else
					{
						$wireframe = "blog_01";
					}
				}
			}
			else
			{
				$wireframe = "blog_01";
			}
		}
		else
		{
			$wireframe = $_POST['miniatures'];
		}	
		
		#echo $wireframe;
		
		if(!isset($_POST['miniatures']))
		{
			$image = "wireframes/Miniatures/$wireframe/preview_2.png";
			$description = file_get_contents("wireframes/Miniatures/blog_01/info.txt");
			echo "<input type='hidden' id='miniatures' name='miniatures' value='$wireframe'/>";	
			echo "<div class='col-sm-6 wireframe_page'><img class='miniatures_image' style='width: 100%;' src='$image'><br/><br/></div><div class='col-sm-6 '><div class='miniatures_description'>$description</div><br/><br/><a id='changeWireframeMiniature' class='linkButton'>Changer</a></div>";		
		}
		else
		{
			if($wireframe == "")
			{
				$wireframe = "blog_01";
			}
			$image = "wireframes/Miniatures/$wireframe/preview_2.png";
			$description = file_get_contents("wireframes/Miniatures/$wireframe/info.txt");		
			echo "<input type='hidden' id='miniatures' name='miniatures' value='".$wireframe."'/>";
			echo "<div class='col-sm-6 wireframe_page'><img class='miniatures_image' style='width: 100%;' src='$image'><br/><br/></div><div class='col-sm-6 '><div class='miniatures_description'>$description</div><br/><br/><a id='changeWireframeMiniatures' class='linkButton'>Changer</a></div>";		
		}		
	}
	
	public function get_current_wireframe_page()
	{
	    $this->get_wireframe_page();
		/*if(!isset($_POST['display']))
		{
			$image = "wireframes/Pages/01/preview_2.png";
			$description = file_get_contents("wireframes/Pages/01/info.txt");
			echo "<input type='hidden' id='display' name='display' value='01'/>";	
			echo "<div class='col-sm-6 wireframe_page'><img class='wireframe_image' style='width: 100%;' src='$image'><br/><br/></div><div class='col-sm-6 '><div class='wireframe_description'>$description</div><br/><br/><a id='changeWireframePage' class='linkButton'>Changer</a></div>";		
		}
		else
		{
			$wireframe = $_POST['display'];
			$image = "wireframes/Pages/$wireframe/preview_2.png";
			$description = file_get_contents("wireframes/Pages/$wireframe/info.txt");		
			echo "<input type='hidden' id='display' name='display' value='".$_POST['display']."'/>";
			echo "<div class='col-sm-6 wireframe_page'><img class='wireframe_image' style='width: 100%;' src='$image'><br/><br/></div><div class='col-sm-6 '><div class='wireframe_description'>$description</div><br/><br/><a id='changeWireframePage' class='linkButton'>Changer</a></div>";		
		}*/
	}
	
	public function listAllFichier()
	{
		echo "<div class='listFichiers'>";
		
		echo "<h4>Liste des fichiers</h4>";
		echo "<div class='col-sm-12' style='text-align: center'><select class='fichierSelect' name='fichierSelect'>";
		$sql = "SELECT * FROM medias WHERE type='fichier' ORDER BY date DESC";
		$reponse = $this->_db->query($sql);
		while($donnees = $reponse->fetch())
		{
			$path = $_SESSION['img_path']."/content/files/".$donnees['fichier'];
			echo "<option value='".$path."'>".$donnees['nom']."</option>";
		}
		echo "</select>";
		echo "<input id='addFile' type='button' value='Ajouter'></div>";
		echo "</div>";
	}
	
	public function ListParent($parent)
	{
		$sql2 = "SELECT * FROM contenu WHERE ID = :parent";
		$reponse2 = $this->_db->prepare($sql2);
		$reponse2->bindParam(':parent', $parent);
		$reponse2->execute();

		if($reponse2->rowCount() == 0)
		{
			$this->_titre = "./";
		}

		while($donnees2 = $reponse2->fetch())
		{
			$this->_titre[] = $donnees2['nom'];
			if($donnees2['parent'] != "")
			{
				$this->listParent($donnees2['parent']);
			}
			else
			{

				$this->_titre[] = ".";
				$this->_titre = array_reverse($this->_titre);
				$numeroASupprimer = count($this->_titre);
				$this->_titre[$numeroASupprimer] = "";
				$this->_titre = implode(" / ", $this->_titre);
			}
		}
	}

	public function afficherPermission()
	{
		$sql = "SELECT * FROM login";
		$reponse = $this->_db->prepare($sql);
		$reponse->execute();
		#echo "<h4 class='permissionsTitle'><a class='afficherPermissions'>Afficher <strong>&darr;</strong></a></h4>";
		echo "<div class='permissionsContainer'>";
		echo "<div class='legendNom col-sm-4'>Nom</div><div class='legendEdit col-sm-1 pull-right'><img src='images/editPermissions.png'/></div><!--<div class='legendSuppr col-sm-1 pull-right'><img src='images/deletePermissions.png'/></div>-->";
		while($donnees = $reponse->fetch())
		{
			$checkedDelete = "checked";
			$checkedEdit = "checked";

			
			
			if(isset($_GET['parent']) AND $_GET['parent'] != null AND !isset($_POST['valider']))
			{
				$sqlPermissionParent = "SELECT * FROM contenu WHERE ID = ".$_GET['parent'];
				$reponseParent = $this->_db->query($sqlPermissionParent);
				
				while($donneesPermission = $reponseParent->fetch())
				{
					$permission = @$donneesPermission['autorisations'];
				}
				
				$permission = json_decode($permission, TRUE);
				
				$permissionEdit = @$permission['editionPermission'][$donnees['ID']];
				$permissionSuppr = @$permission['suppressionPermission'][$donnees['ID']];
			}

			if(isset($_POST['valider']))
			{
				$permissionEdit = @$_POST['permissionEdit'];
				$permissionEdit = @$permissionEdit[$donnees['ID']];
	
				$permissionSuppr = @$_POST['permissionDelete'];
				$permissionSuppr = @$permissionSuppr[$donnees['ID']];
			}
			
			
			if(isset($_GET['parent']) AND $_GET['parent'] != null OR isset($_POST['valider']))
			{
				if(isset($permissionSuppr) AND $permissionSuppr != null)
				{
					$checkedDelete = "checked";
				}
				if($permissionSuppr == "")
				{
					$checkedDelete = "";
				}
				if(isset($permissionEdit) AND $permissionSuppr != null)
				{
					$checkedEdit = "checked";
				}
				if($permissionEdit == "")
				{
					$checkedEdit = "";
				}
			}	
			echo "<div class='col-sm-12 liste userPermission'>";
			echo "<div class='labelPermissions col-sm-10'>".$donnees['login']."</div>";
			echo "<input type='checkbox' class='checkboxPermissions col-sm-1 pull-right' ".$checkedEdit." name='permissionEdit[".$donnees['ID']."]'/><input ".$checkedDelete." class='deleteCheckBox col-sm-1 pull-right checkboxPermissions' type='checkbox' name='permissionDelete[".$donnees['ID']."]'/>";
			echo "</div>";
		}
		echo "<div class='checkAll col-sm-12'><div class='col-sm-10 labelPermissions'>Tout cocher/décocher</div><input checked='true' class='col-sm-1 pull-right' type='checkbox' id='allCheck'></div>";
		echo "</div>";
		
	}

	public function verificationPermissionsEdition()
	{
		if(isset($_GET['parent']) AND $_GET['parent'] != null)
		{
			$sql = "SELECT * FROM contenu WHERE ID = ".$_GET['parent'];
			$reponse = $this->_db->query($sql);
			//$reponse->bindParam(':id_parent', $_GET['parent']);
			
			
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

	public function list_all_language()
	{
		$sql = "SELECT * FROM systeme WHERE nom = 'langue_principale'";
		$reponse = $this->_db->prepare($sql);
		$reponse->execute();
		$reponse = $reponse->fetchAll()[0];
		
		$langue_principale = $reponse['valeur'];
		$input = array();
		$input[] = $langue_principale;
		$sql = "SELECT * FROM systeme WHERE nom = 'langue_secondaire'";
		$reponse = $this->_db->prepare($sql);
		$reponse->execute();
		while($donnees = $reponse->fetch())
		{
			$input[] = $donnees['valeur'];
		}
		
		return $input;		
	}

	public function display_description_fields()
	{

		foreach($this->_language as $langue)
		{
			//print_r($this->_description);
			$input .= "<textarea class='description-".$langue." descriptionField col-sm-12 col-md-8' name='description[".$langue."]' placeholder='Description de votre contenu'>".str_replace("<br/>", "\n", $this->_description[$langue])."</textarea>";
		}		
		
		return $input;
		
	}
	
	public function display_SEO_description_fields()
	{

		foreach($this->_language as $langue)
		{
			//print_r($this->_description);
			$input .= "<textarea class='SEO_description-".$langue." SEO_descriptionField col-sm-12 col-md-12' max-length='160' name='SEO_description[".$langue."]' placeholder='Description de votre contenu'>".$this->_SEO_description[$langue]."</textarea>";
		}		
		
		return $input;
		
	}

	public function display_name_fields()
	{
		foreach($this->_language as $langue)
		{
			//print_r($this->_description);
			$input .= "<input type='text' class='nameField name-".$langue." col-sm-12 col-md-8' value='".stripslashes(htmlspecialchars($this->_nom[$langue], ENT_QUOTES))."' placeholder='Nom du contenu (obligatoire)' name='nom[".$langue."]' maxlength='250' >";
		}		
		
		return $input;		
	}
	
	public function display_lien_fields()
	{
		foreach($this->_language as $langue)
		{
			//print_r($this->_description);
			if($this->_lien[$langue] == null)
			{
				$this->_lien[$langue] = "Voir";
			}
			$input .= "<input type='text' class='lienField lien-".$langue." col-sm-12 col-md-8' value='".stripslashes(htmlspecialchars($this->_lien[$langue], ENT_QUOTES))."' placeholder='texte du bouton' name='lien[".$langue."]' value='Lire' maxlength='250' >";
		}		
		
		return $input;		
	}

	public function display_text_fields()
	{
		foreach($this->_language as $langue)
		{
			//print_r($this->_description);
			$input .= "<div class='wysiwygContainer text-".$langue." col-sm-12 col-md-12'><textarea name='texte[".$langue."]' id='wysiwyg-".$langue."' class='tinyMCE' placeholder='Votre contenu'>".$this->_texte[$langue]."</textarea></div>";
		}		
		
		return $input;		
	}

	public function display_all_language()
	{
		
		//$liste_langue = array("fr" => "Français", "en" => "Anglais", "de" => "Allemand", "nl" => "Néerlandais", "es" => "Espagnol", "it" => "Italien", "pt" => "Portugais");
		$liste_langue = parent::listAllLang();
		foreach($this->_language as $langue)
		{
			$input .= "<div data-lang='".$langue."' data-lang-name='".$liste_langue[$langue]."' class=' btn_lang'>".strtoupper($langue)."</div>";
		}
		return $input;
	}

	public function afficher()
	{
		$template = "<option>Sélectionner</option>";
		$fichiers = scandir("content/templates/");
		foreach($fichiers as $fichier)
		{
			if($fichier != ".." AND $fichier != ".")
			{
				$fichier = str_replace(".txt", "", $fichier);
				$template .= "<option>$fichier</option>";
			}
		}
		
		$this->listAllFichier();
		if(isset($_POST['valider']))
		{
			if($this->_erreur != 0)
			{
				$fusionDesErreurs = implode("<br/>", $this->_listeErreur);
				echo "<div class='rapport cadre col-sm-12 col-lg-10 col-lg-push-1'>";
				echo "<h3>Rapport</h3>";
				echo "<div class='fail'>$fusionDesErreurs</div>";
				echo "</div>";
			}
			else
			{
				echo "<div class='rapport cadre col-sm-12 col-lg-10 col-lg-push-1'>";
				echo "<h3>Rapport</h3>";
				echo "<div class='success' data-link='".$_POST['parent']."' id='state_success'>Contenu créé avec succès</div>";
				echo "</div>";
				#header("location: listContent.php?parent=".$_POST['parent']);
			}
		}

		if($this->_medias[0] != "")
		{
			foreach($this->_medias as $media)
			{
				@$hiddenSelect .= "<input type='hidden' class='mediasHidden' value='".$media."'/>";
			}
		}
		else
		{

		}
		
		//$this->get_wireframe_page();
		$this->get_wireframe_miniatures();
		echo "<div style='padding: 0' class='col-sm-7 col-lg-6 col-lg-offset-1'>";
		echo "<div class='col-md-12 cadre'>";
		echo "<h3>Description</h3>";
		echo $this->display_all_language();
		echo "<div style='padding-left: 0px' class='col-sm-12'><div class='demandTranslate'>Traduction automatique</div></div>";
		echo "<span class='col-sm-12 placePage'>Votre contenu sera créé dans : </span>";
		echo "<div class='col-sm-12 arborescenceCadre'>".@$this->ListParent($_GET['parent']).$this->_titre."</div>";
		echo "<input type='hidden' value='".$this->_parent."' name='parent'>";
		echo "<div class='col-sm-12'><label for='nom' class='col-md-2 labelLeft'>Nom&nbsp&nbsp</label>".$this->display_name_fields()."</div>";
		echo "<div class='col-sm-12'><label for='URL' class='col-md-2 labelLeft' style='margin-top: 32px'>URL&nbsp&nbsp</label><span style='color: #dadada; font-style: italic; font-size: 12px'>http://".$_SERVER['HTTP_HOST'].dirname(dirname(dirname(__FILE__)))."/fr/</span><input class='col-sm-8' type='text' value='".$this->_nameURL."' name='nameURL'/></div>";
		echo "<div class='col-sm-12 imagePrev' id='imagePrev'><p style='color: #dadada; font-weight: bold; text-align: center' class='col-sm-4 col-sm-offset-2 PasDePhotos'>Pas d'image</p></div>";
		echo "<div class='col-sm-12'><label for='file' class='col-md-2 labelLeft'>Illustration&nbsp&nbsp</label><input type='file' id='file' name='file'/><input data-preview='imagePrev' type='button' class='col-sm-12 col-md-5 addImage' value='Ajouter une image' id=''/><input type='hidden' name='realImage' value='".$this->_image."' id='votre_image'/><input type='hidden' class='col-sm-12 col-md-5' value='".$valuePhoto."' id='file_btn'/>".$delete."</div>";
		//echo "<div class='col-sm-12'><label for='file' class='col-md-2 labelLeft'>Illustration&nbsp&nbsp</label><input type='file' id='file' name='file'/><input type='button' class='col-sm-12 col-md-5' value='Photo' id='file_btn'/></div>";
		//echo "<div class='col-md-2' id='mediasLabel'><label class='labelLeft col-sm-12 col-md-12' for='medias'>Widget</label></div>";
		//echo @$hiddenSelect;
		//echo "<div class='col-md-5 mediaContainer' ><select value='' name='medias[]' class='medias col-sm-12 col-md-12'>".$this->listAllMedias()."</select></div>";
		//echo "<div class='col-sm-12'><input type='button' id='addMedias' class='col-md-5 col-md-offset-2' value='Ajouter'></div>";
		// done : ajouter des étiquettes
		echo "<div class='col-sm-12'><input type='hidden' class='col-sm-12 col-md-8' value='".stripslashes(htmlspecialchars($this->_keywords, ENT_QUOTES))."' placeholder='Mots-clés (séparés par une virgule)' id='realKeywords' name='keywords' maxlength='255'></div>";
		echo "<div class='col-sm-12'><label class='col-md-2 labelLeft'>&nbsp&nbsp</label><div class='col-md-8' id='keywordsList' style='min-height: 30px; paddding: 7px'></div></div>";
		echo "<div class='col-sm-12'><label for='keywords' class='col-md-2 labelLeft'>Etiquettes&nbsp&nbsp</label><input type='text' class='col-sm-12 col-md-8' id='keywordsField' value='' placeholder='Ajouter des mots clés' maxlength='255'></div>";
		echo "<div id='keylist'></div>";
		echo "<div class='col-sm-12'><label for='description' class='col-md-2 labelLeft'>Description&nbsp&nbsp</label>".$this->display_description_fields()."</div>";
		
		echo "</div>";
		
		echo "<div style='margin-top: 0' class='col-md-12 cadre'>";
		echo "<h3>Contenu de la page</h3>";
		echo "<div class='col-sm-12' style='margin-bottom: 15px' ><label style='text-align: left' for='template' class='col-md-12 labelLeft' >Template&nbsp&nbsp</label><select class='col-md-5' id='template'>$template</select></div>";
		echo "<div class='col-sm-12'>".$this->display_text_fields()."</div>";
		echo "</div>";
		
		echo "</div>";
		
		echo "<div class='col-sm-5 col-lg-4 parametre parametreCadre'>";
		echo "<div class='col-sm-12 cadre'><div class='validerBtn col-sm-12 col-lg-12'><input type='submit' name='valider' id='valider' class='' value='Sauvegarder'/>";
		if(!isset($_GET['add']) OR $_GET['add'] != "bloc")
		{
			echo "<a class='preview'>Prévisualisation</a>";
		}
		echo "<br/><br/></div></div>";
		echo "<div class='col-sm-12 cadre optionPage' style='padding-bottom: 20px'>";
		echo "<h3>Paramètres</h3>";
		echo "<input type='hidden' id='onlineHidden' value='".$this->_online."'/><input type='hidden' id='commentaireHidden' value='".$this->_commentaire."'/><input type='hidden' id='homepageHidden' value='".$this->_homepage."'/><input type='hidden' id='importantHidden' value='".$this->_important."'/>";
		echo "<div class='col-sm-12 liste'><label class='col-sm-9 col-md-9' for='online'>En faire la page d'accueil ?</label><input type='checkbox' id='homepage' class='col-sm-12 col-md-1 pull-right' name='homepage'></div>";
		#echo "<div class='col-sm-12 liste'><label class='col-sm-9 col-md-9' for='important'>En-tête ?</label><input type='checkbox' class='col-sm-12 col-md-1 pull-right' id='important' name='important'></div>";
		echo "<div class='col-sm-12 liste'><label class='col-sm-9 col-md-9' for='commentaire'>Activer les commentaires ? </label><input type='checkbox' class='col-sm-12 col-md-1 pull-right' id='commentaire' name='commentaire'></div>";
		echo "<div class='col-sm-12 liste'><label class='col-sm-9 col-md-9' for='online'>En ligne ? </label><input type='checkbox' id='online' class='col-sm-12 col-md-1 pull-right' name='online'></div>";
		#echo "<div class='col-sm-12 liste'>".$this->afficherPermission()."</div>";

		echo "</div>";
		// todo : Ajouter disposition
		echo "<div class='col-sm-12 cadre parametreAccordeon'>";
		#echo "<div style='padding: 0; margin: 0; height: 15px !important; box-shadow: 0px 0px 0px transparent !important' class='cadre'>";
		echo "<h3 class='titleArborescence'>Permissions&nbsp &nbsp<a class='afficherPermissions'>Afficher <strong>&darr;</strong></a></h3>";
		echo $this->afficherPermission();
		#echo "</div>";
		echo "</div>";	
		
		
		echo "<div class='col-sm-12 cadre parametreAccordeon'>";
		#echo "<div style='padding: 0; margin: 0; height: 15px !important; box-shadow: 0px 0px 0px transparent !important' class='cadre'>";
		echo "<h3 class='titleArborescence'>Affichage de la page</h3>";
		echo $this->get_current_wireframe_page();
		#echo "</div>";
		echo "</div>";
		
		echo "<div style='display: none' class='col-sm-12 cadre parametreAccordeon'>";
		#echo "<div style='padding: 0; margin: 0; height: 15px !important; box-shadow: 0px 0px 0px transparent !important' class='cadre'>";
		echo "<h3 class='titleArborescence'>Affichage du bloc</h3>";
		echo $this->get_current_wireframe_miniatures();
		echo "<div class='col-sm-12'><label for='lien' class='col-md-4 labelLeft'>texte du lien&nbsp&nbsp</label>".$this->display_lien_fields()."</div>";
		echo "<div id='style' class='col-sm-12'>";
		echo "<h4>Style</h4>";
		echo "<div id='styleContainer'>";
		$this->displayStyle();
		echo "</div>";
		echo "<div class='col-sm-12'><label for='imposedStyle'>Appliquer ce style aux autres miniatures</label><input name='imposedStyle' type='checkbox'></div>";
		echo "</div>";
		#echo "</div>";
		echo "</div>";	

		echo "<div class='col-sm-12 cadre parametreAccordeon'>";
		#echo "<div style='padding: 0; margin: 0; height: 15px !important; box-shadow: 0px 0px 0px transparent !important' class='cadre'>";
		echo "<h3 class='titleArborescence'>Paramètre référencement</h3>";
		echo $this->display_SEO_description_fields();
		#echo "</div>";
		echo "</div>";
		
		$this->afficherChampsPerso();
		
		echo "</div>";



		

		//echo "<div class='validerBtn col-sm-12 col-lg-6 col-lg-offset-1'><input type='submit' name='valider' id='valider' class='' value='Sauvegarder'/></div>"; 
	}

	public function displayStyle()
	{
	    
		if(isset($_POST['input']))
		{
		    
			$this->_champsPerso = $_POST['input'];
			foreach($this->_champsPerso as $key => $champsPerso)
			{
				foreach($champsPerso as $label => $input)
				{
					switch($key)
					{
						case "texte" : $input = "<label class='labelLeft col-md-4'>".$label."&nbsp&nbsp</label><input type='text' value=\"".$input."\" name=\"input[$key][$label]\" class='col-sm-8'>";
						break;
						case "textarea" : $input = "<label class='labelLeft col-md-4'>".$label."&nbsp&nbsp</label><textarea name=\"input[$key][$label]\" class='col-sm-8'>$input</textarea>";
						break;
						case "color" : $input = "<label class='labelLeft col-md-4'>".$label."&nbsp&nbsp</label><input type='color' value=\"".$input."\" name=\"input[$key][$label]\" class='col-sm-8'>";
						break;
						case "datetime" : $input = "<label class='labelLeft col-md-4'>".$label."&nbsp&nbsp</label><input type='datetime' value=\"".$input."\" name=\"input[$key][$label]\" class='col-sm-8'>";
						break;
						case "map" : 
						$coord = explode(", ", $input);
						$input = "<div class='mapContainer'><input type='button' value='Coordonnées' style='margin-top: 10px' class='col-sm-12 mapButton'><input type='hidden' value='".$input."' placeholder='glissez le marqueur pour déterminer une position géographique' name=\"input[$key][$label]\" class='inputMap col-sm-12'><div style='' data-lat='".$coord[0]."' data-lng='".$coord[1]."' class='mapPicker col-sm-12'></div></div>";
						break;
					}
					echo $input;
				}
			}			
		}
		else
		{
		    
			foreach($this->_champsPerso as $key => $champsPerso)
			{
			   
				foreach($champsPerso as $label => $input)
				{
					switch($key)
					{
						case "texte" : $input = "<label class='labelLeft col-md-4'>".$label."&nbsp&nbsp</label><input type='text' value=\"".$input."\" name=\"input[$key][$label]\" class='col-sm-8'>";
						break;
						case "textarea" : $input = "<label class='labelLeft col-md-4'>".$label."&nbsp&nbsp</label><textarea name=\"input[$key][$label]\" class='col-sm-8'>$input</textarea>";
						break;
						case "color" : $input = "<label class='labelLeft col-md-4'>".$label."&nbsp&nbsp</label><input type='color' value=\"".$input."\" name=\"input[$key][$label]\" class='col-sm-8'>";
						break;
						case "datetime" : $input = "<label class='labelLeft col-md-4'>".$label."&nbsp&nbsp</label><input type='datetime' value=\"".$input."\" name=\"input[$key][$label]\" class='col-sm-8'>";
						break;
						case "map" : 
						$coord = explode(", ", $input);
						$input = "<div class='mapContainer'><input type='button' value='Coordonnées' style='margin-top: 10px' class='col-sm-12 mapButton'><input type='hidden' value='".$input."' placeholder='glissez le marqueur pour déterminer une position géographique' name=\"input[$key][$label]\" class='inputMap col-sm-12'><div style='' data-lat='".$coord[0]."' data-lng='".$coord[1]."' class='mapPicker col-sm-12'></div></div>";
						break;
					}
					echo $input;
				}
			}	
		}
		if(isset($_POST['style']))
		{
/* 			if(isset($_POST['style']['background']))  */echo "<div class='styleInput col-sm-12'><label class='labelLeft col-md-6'>Arrière plan&nbsp&nbsp</label><input class='colorPicker' value='".$_POST['style']['background']."' type='text' name='style[background]'/></div>";
/* 			if(isset($_POST['style']['cadre']))  */echo "<div class='styleInput col-sm-12'><label class='labelLeft col-md-6'>Couleur du cadre&nbsp&nbsp</label><input class='colorPicker' value='".$_POST['style']['background_cadre']."' type='text' name='style[background_cadre]'/></div>";
/* 			if(isset($_POST['style']['color']))  */echo "<div class='styleInput col-sm-12'><label class='labelLeft col-md-6'>Couleur du texte&nbsp&nbsp</label><input class='colorPicker' value='".$_POST['style']['color']."' type='text' name='style[color]'/></div>";
/* 			if(isset($_POST['style']['color_title']))  */echo "<div class='styleInput col-sm-12'><label class='labelLeft col-md-6'>Couleur du titre&nbsp&nbsp</label><input class='colorPicker' value='".$_POST['style']['color_title']."' type='text' name='style[color_title]'/></div>";
			
		}
		else
		{
			
			if(isset($_GET['parent']) AND $_GET['parent'] != null)
			{
				$parent = $_GET['parent'];
			}
			else
			{
				$parent = "0";
			}
			
			$sql = "SELECT * FROM contenu WHERE ID = $parent";
			$reponse = $this->_db->prepare($sql);
			$reponse->execute();
			if($reponse->rowCount() == 0)
			{
				
				echo "<div class='styleInput col-sm-12'><label class='labelLeft col-md-6'>Arrière plan&nbsp&nbsp</label><input class='colorPicker' value='' type='text' name='style[background]'/></div>";
				echo "<div class='styleInput col-sm-12'><label class='labelLeft col-md-6'>Couleur du cadre&nbsp&nbsp</label><input class='colorPicker' value='' type='text' name='style[background_cadre]'/></div>";
				echo "<div class='styleInput col-sm-12'><label class='labelLeft col-md-6'>Couleur du texte&nbsp&nbsp</label><input class='colorPicker' value='' type='text' name='style[color]'/></div>";
				echo "<div class='styleInput col-sm-12'><label class='labelLeft col-md-6'>Couleur du titre&nbsp&nbsp</label><input class='colorPicker' value='' type='text' name='style[color_title]'/></div>";
				
				echo "<div class='styleInput col-sm-12'><label class='labelLeft col-md-6'>Couleur du bouton&nbsp&nbsp</label><input class='colorPicker' value='".$_POST['style']['background_link']."' type='text' name='style[background_link]'/></div>";
				echo "<div class='styleInput col-sm-12'><label class='labelLeft col-md-6'>Couleur du texte du bouton&nbsp&nbsp</label><input class='colorPicker' value='".$_POST['style']['color_link']."' type='text' name='style[color_link]'/></div>";
				echo "<div class='styleInput col-sm-12'><label style='margin-top: 15px' class='labelLeft col-md-6'>Url du bouton&nbsp&nbsp</label><input placeholder='Remplissez si lien externe' value='".$this->_style['url']."' type='text' name='style[url]'/></div>";				
			}
			else
			{
				while($donnees = $reponse->fetch())
				{
					//echo "ok";
					$donnees['baseStyle'] = json_decode($donnees['baseStyle'], true);
/* 					if(isset($donnees['baseStyle']['background']))  */echo "<div class='styleInput col-sm-12'><label class='labelLeft col-md-6'>Arrière plan&nbsp&nbsp</label><input class='colorPicker' value='".$donnees['baseStyle']['background']."' type='text' name='style[background]'/></div>";
/* 					if(isset($donnees['baseStyle']['cadre'])) */ echo "<div class='styleInput col-sm-12'><label class='labelLeft col-md-6'>Couleur du cadre&nbsp&nbsp</label><input class='colorPicker' value='".$donnees['baseStyle']['background_cadre']."' type='text' name='style[background_cadre]'/></div>";
/* 					if(isset($donnees['baseStyle']['color'])) */ echo "<div class='styleInput col-sm-12'><label class='labelLeft col-md-6'>Couleur du texte&nbsp&nbsp</label><input class='colorPicker' value='".$donnees['baseStyle']['color']."' type='text' name='style[color]'/></div>";
/* 					if(isset($donnees['baseStyle']['color_title'])) */ echo "<div class='styleInput col-sm-12'><label class='labelLeft col-md-6'>Couleur du titre&nbsp&nbsp</label><input class='colorPicker' value='".$donnees['baseStyle']['color_title']."' type='text' name='style[color_title]'/></div>";
				}			
			}
	


		}
		
	}

	public function formatageFile($texte)
	{
		$accent='ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËéèêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ';
		$noaccent='aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn';
		$texte = strtr($texte,$accent,$noaccent);
		$texte = str_replace(" ","_",$texte);

		$texte = preg_replace('/([^.a-z0-9]+)/i', '-', $texte);
		$texte = time().$texte;
		
		return $texte;
	}

	public function afficherChampsPerso()
	{
	    /*
	    foreach($this->_language as $langue)
		{
			//print_r($this->_description);
			$input .= "<input type='text' class='nameField name-".$langue." col-sm-12 col-md-8' value='".stripslashes(htmlspecialchars($this->_nom[$langue], ENT_QUOTES))."' placeholder='Nom du contenu (obligatoire)' name='nom[".$langue."]' maxlength='250' >";
		}
	    */
	    
		if(isset($_GET['parent']) AND $_GET['parent'] != null)
		{
			$parent = $_GET['parent'];
		}
		else
		{
			$parent = "";
		}
		$sql = "SELECT * FROM contenu_perso WHERE page = :parent";
		$reponse = $this->_db->prepare($sql);
		$reponse->bindParam(':parent', $parent);
		$reponse->execute();
		if($reponse->rowCount() == 0)
		{
			
		}
		else
		{
			echo "<div class='cadre col-sm-12 parametre'>";
			#echo "<div class='cadre'>";
			echo "<h3>Champs personnalisés</h3>";
			$donneesData = $reponse->fetchAll();
			foreach($this->_language as $langue)
			{
			    //print_r($donneesData);
    			echo "<div class='customField custom-".$langue."'>";
    			foreach($donneesData as $donnees)
    			{
    				$input;
    				$lb = $donnees['label'];
    				$value = $_POST["input"][$lb];
    				switch($donnees['valeur'])
    				{
    					case "Texte" : $input = "<input type='text' value='".$value."' name=\"input[$langue][".$donnees['label']."]\" class=' col-sm-6'>";
    					break;
    					case "Zone de texte" : $input = "<textarea name=\"input[$langue][".$donnees['label']."]\" class='col-sm-6'>$value</textarea>";
    					break;
    					case "Couleur" : $input = "<input type='color' value='".$value."' name=\"input[$langue][".$donnees['label']."]\" class=' col-sm-6'>";
    					break;
    					case "Image" : $input = "<div class='col-sm-8 input-".$langue."-".$donnees['label']."' style=''></div><input type='button' data-preview=\"input-".$langue."-".$donnees['label']."\" value='Ajouter une image' class='addImage' style='display: block'/><input type='hidden' value=\"".$value."\" name=\"input[$langue][".$donnees['label']."]\" class='col-sm-8'>";
    					break;
    					case "Carte" : $input = "<div class='mapContainer'><input type='button' value='Coordonnées' style='margin-top: 10px' class='col-sm-8 mapButton'><input type='hidden' value='".$value."' placeholder='glissez le marqueur pour déterminer une position géographique' name=\"input[$langue][".$donnees['label']."]\" class='inputMap col-sm-12'><div style='' class='mapPicker col-sm-12'></div></div>";
    					break;
    				}
    				
    				echo "<label class='labelLeft col-sm-4' for=''>".$donnees['label']."&nbsp&nbsp</label>".$input;
    			}
    			echo "</div>";
			}
			#echo "</div>";
			echo "</div>";
		}
		
	}

	public function formatagePermission()
	{
		if(isset($_POST['valider']))
		{
			$nouveauTableauEdit = array();
			foreach(@$_POST['permissionEdit'] as $key => $permissionEdit)
			{
				$nouveauTableauEdit[$key] = @$permissionEdit;
			}
			$nouveauTableauDelete = array();
			foreach(@$_POST['permissionDelete'] as $key => $permissionSuppr)
			{
				$nouveauTableauDelete[$key] = @$permissionSuppr;
			}
			$tableauPermission['editionPermission'] = $nouveauTableauEdit;
			$tableauPermission['suppressionPermission'] = $nouveauTableauDelete;
			
			$returnValue = json_encode($tableauPermission, TRUE);
			return $returnValue;
		}
	}


	public function ajouter()
	{
		$this->_nomDuFichier = $this->formatageFile($this->_image['name']);
		$fichierTemporaire = $this->_image['tmp_name'];
		
		
		
		$this->_medias = json_encode($this->_medias);
		$sql = "SELECT * FROM contenu WHERE parent = :parent";
		$reponse = $this->_db->prepare($sql);
		$reponse->bindParam(':parent', $_GET['parent']);
		$reponse->execute();
		$this->_keywords = strtolower($this->_keywords);

		$wireframe = $_POST['display'];
		$miniature = $_POST['miniatures'];
		
		$lastOrder = $reponse->rowCount();
		
		if($this->_homepage == "on")
		{
			$sql = "UPDATE contenu SET homepage = 'off' WHERE homepage = 'on'";
			$reponse = $this->_db->prepare($sql);
			$reponse->execute();
		}
		
		#echo $lastOrder;
		$lastOrder = intval($lastOrder) + 1;
		//print_r($this->_champsPerso);
		$customFields = json_encode($this->_champsPerso[$this->_langue_principale], true);
		$permission = $this->formatagePermission();
		if(1)
		{
		/*	$sql = "INSERT INTO contenu VALUES('', :nom, :description, :texte, :parent, '', :auteur, :date_time, :online, :commentaire, '','', :medias,'','', :permission, :keywords, :last_order, :champs_perso,'','', :homepage, :wireframe, :miniature, :seo_desc, :lien, :style,'','')";
			$reponse = $this->_db->prepare($sql);
			$reponse->bindParam(':nom', $this->_nom[$this->_langue_principale]);
			$reponse->bindParam(':description', $this->_description[$this->_langue_principale]);
			$reponse->bindParam(':texte', $this->_texte[$this->_langue_principale]);
			$reponse->bindParam(':parent', $this->_parent);
			$reponse->bindParam(':auteur', $this->_auteur);
			$reponse->bindParam(':date_time', $this->_date);
			$reponse->bindParam(':online', $this->_online);
			$reponse->bindParam(':commentaire', $this->_commentaire);
			#$reponse->bindParam(':important', $this->_important);
			$reponse->bindParam(':medias', $this->_medias);
			$reponse->bindParam(':permission', $permission);
			$reponse->bindparam(':keywords', $this->_keywords);
			$reponse->bindParam(':last_order', $lastOrder);
			$reponse->bindParam(':champs_perso', $customFields);
			$reponse->bindParam(':homepage', $this->_homepage);
			$reponse->bindParam(':wireframe', $wireframe);
			$reponse->bindParam(':miniature', $miniature);
			$reponse->bindParam(':seo_desc', $this->_SEO_description[$this->_langue_principale]);
			$reponse->bindParam(':lien', $this->_lien[$this->_langue_principale]);
			$reponse->bindParam(':style', $this->_style);
			$reponse->execute();
			*/
			$sql = "INSERT INTO contenu VALUES('','".$this->_nom[$this->_langue_principale]."','".$this->_description[$this->_langue_principale]."','".$this->_texte[$this->_langue_principale]."','".$this->_parent."','','".$this->_auteur."','".$this->_date."','".$this->_online."','".$this->_commentaire."','".$this->_important."','".$this->_image."','".$this->_medias."','','','".$this->formatagePermission()."','".$this->_keywords."','".$lastOrder."','".$customFields."','".$this->generateSlug($this->_nameURL, 255)."','','".$this->_homepage."','".$wireframe."','".$miniature."','".$this->_SEO_description[$this->_langue_principale]."', '".$this->_lien[$this->_langue_principale]."', '".$this->_style."','','')";
			$this->_db->exec($sql);
			//print_r($this->_db->errorInfo());
			//exit();
			$lastID = $this->_db->lastInsertId();
			if(count($this->_description) > 1)
			{
				$count = 0;
				foreach($this->_nom as $key => $nom)
				{
					if($count != 0)
					{
						$customFields = json_encode($this->_champsPerso[$key]);
						$sql = "INSERT INTO contenu_traduction VALUES('', :nom, :description, :texte, :customField, :last_id, :key, :seo_desc, :lien)";
						$reponse = $this->_db->prepare($sql);
						$reponse->bindParam(':nom', $this->_nom[$key]);
						$reponse->bindParam(':description', $this->_description[$key]);
						$reponse->bindParam(':texte', $this->_texte[$key]);
						$reponse->bindParam(':customField', $customFields);
						$reponse->bindParam(':last_id', $lastID);
						$reponse->bindParam(':key', $key);
						$reponse->bindParam(':seo_desc', $this->_SEO_description[$key]);
						$reponse->bindParam(':lien', $this->_lien[$key]);
						$reponse->execute();
						
					}
					$count++;
				}
			}
			
		}
		else
		{
			if(move_uploaded_file($fichierTemporaire, "content/images/".$this->_nomDuFichier))
			{
				$sql = "INSERT INTO contenu VALUES('','".$this->_nom[$this->_langue_principale]."','".$this->_description[$this->_langue_principale]."','".$this->_texte[$this->_langue_principale]."','".$this->_parent."','','".$this->_auteur."','".$this->_date."','".$this->_online."','".$this->_commentaire."','".$this->_important."','".$this->_nomDuFichier."','".$this->_medias."','','','".$this->formatagePermission()."','".$this->_keywords."','".$lastOrder."','".$this->_champsPerso."','".$this->generateSlug($this->_nom[$this->_langue_principale], 255)."','','".$this->_homepage."','".$wireframe."','".$miniature."','".$this->_SEO_description[$this->_langue_principale]."', '".$this->_lien[$this->_langue_principale]."', '".$this->_style."','','')";
				$this->_db->exec($sql);
				$this->createThumbs( "content/images/".$this->_nomDuFichier, "content/images/".$this->_nomDuFichier, 1920);
				$lastID = $this->_db->lastInsertId();
				if(count($this->_description) > 1)
				{
					$count = 0;
					foreach($this->_nom as $key => $nom)
					{
						if($count != 0)
						{
							$customFields = json_encode($this->_champsPerso[$key]);
							$sql = "INSERT INTO contenu_traduction VALUES('','".$this->_nom[$key]."','".$this->_description[$key]."','".$this->_texte[$key]."','".$customFields."','".$lastID."','".$key."', '".$this->_SEO_description[$key]."', '".$this->_lien[$key]."')";
							$reponse = $this->_db->exec($sql);
							
						}
						$count++;
					}
				}

			}
			else
			{
				$this->_erreur++;
				$this->_listeErreur[] = "impossible d'uploader l'image, réessayez";
			}
		}

        
		
		$sql = "INSERT INTO log_system VALUES('','".$this->_auteur."','<a href='editContent.php?id=".$lastID."''>a ajouté une page</a>', '".time()."')";
		
		$reponse = $this->_db->query($sql);
		
		$this->_keywords = explode(", ", $this->_keywords);
		
		if($fichierKeyword = file_get_contents("content/keywords/keywords.txt"))
		{
			
		}
		else
		{
			@mkdir("content/keywords");
			$fichierKeyword = fopen("content/keywords/keywords.txt", "w+");
		}
		$fichierKeyword = str_replace("\n", "", $fichierKeyword);
		foreach($this->_keywords as $keyword)
		{
			$keyword = str_replace("''","'", $keyword);
			if(strrpos($fichierKeyword, $keyword.";") !== false)
			{
				
			}
			else
			{
				$fichierKeyword .= $keyword.";";
			}
		}
		
		file_put_contents("content/keywords/keywords.txt", str_replace(";",";\n",$fichierKeyword));
		
		#echo ;

		if($_GET['parent'] != null AND $this->_baseMiniature != null AND $_POST['imposedStyle'] == "on")
		{
			$sql = "UPDATE contenu SET baseMiniature = '".$this->_baseMiniature."', baseStyle = '".$this->_baseStyle."' WHERE ID = ".$_GET['parent'];
			$reponse = $this->_db->query($sql);
		}

		
		$this->_nom = "";
		$this->_texte = "";
		$this->_description = "";
		$this->_SEO_description = "";
		$this->_image = "";
		$this->_commentaire = "";
		$this->_online ="";
		$this->_auteur = "";
		$this->_date = "";
		$this->_parent = "";
		$this->_child = "";
		$this->_important = "";
		$this->_medias = "";
		$this->_keywords = "";
		$this->_style = "";
	}
}
?>

