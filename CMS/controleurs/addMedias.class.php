<?php
class addMedias extends DB
{
	private $_db;
	private $_nom;
	private $_description;
	private $_auteur;
	private $_date;
	private $_type;
	private $_image;
	private $_fichier;
	private $_url;
	private $_listeErreur = array();
	private $_erreur = 0;
	private $_nomDuFichier;
	private $_lastID;
	private $_display;

	public function __construct($type)
	{
		if(isset($_GET['type']))
		{
			$this->_type = $_GET['type'];
		}
		else
		{
			$this->_type = $type;
		}
		
		$this->_db = parent::__construct();
		if($type == "photo")
		{
			if(isset($_POST['valider']))
			{
				$this->verificationPhoto();
			}
			$this->affichagePhoto();
		}
		if($type == "video")
		{
			if(isset($_POST['valider']))
			{
				$this->verificationVideo();
			}
			$this->affichageVideo();
		}
		if($type == "fichier")
		{
			if(isset($_POST['valider']))
			{
				$this->verificationFichier();
			}
			$this->affichageFichier();
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
		
		      // create a new temporary image
		      $tmp_img = imagecreatetruecolor( $new_width, $new_height );
		
		      // copy and resize old image into new image 
		      imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
		
		      // save thumbnail into a file
		      imagepng( $tmp_img, $pathToThumbs);
		      $this->convertPNGto8bitPNG($pathToThumbs, $pathToThumbs);
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

	public function verificationPhoto()
	{
		$this->_nom = str_replace("'","''",$_POST['nom']);
		$this->_description = str_replace("'","''",$_POST['description']);
		$this->_image = $_FILES['file'];
		$this->_date = time();
		$this->_auteur = $_SESSION['login'];
		$this->_display = $_POST['display'];
		//$this->_type = $_GET['type'];

		if($this->_nom == null)
		{
			$this->_erreur++;
			$this->_listeErreur[] = "Merci de renseigner un nom à votre album photo";
		}

		if($this->_erreur == 0)
		{
			$this->addPhoto();
		}
	}

	public function verificationFichier()
	{
		$this->_nom = str_replace("'","''",$_POST['nom']);
		$this->_description = str_replace("'","''",$_POST['description']);
		$this->_fichier = $_FILES['file'];
		$this->_date = time();
		$this->_auteur = $_SESSION['login'];
		//$this->_type = $_GET['type'];

		if($this->_nom == null)
		{
			$this->_erreur++;
			$this->_listeErreur[] = "Merci de renseigner un nom à votre album photo";
		}
		if($this->_fichier['name'] == null)
		{
			$this->_erreur++;
			$this->_listeErreur[] = "Merci de renseigner un fichier à uploader";
		}

		if($this->_erreur == 0)
		{
			$this->addFichier();
		}
	}


	public function verificationVideo()
	{
		$this->_nom = str_replace("'","''",$_POST['nom']);
		$this->_description = str_replace("'","''",$_POST['description']);
		$this->_image = $_FILES['file'];
		$this->_date = time();
		$this->_auteur = $_SESSION['login'];
		//$this->_type = $_GET['type'];
		$this->_url = str_replace("'","''",$_POST['url']);

		if($this->_nom == null)
		{
			$this->_erreur++;
			$this->_listeErreur[] = "Merci de renseigner un nom à votre vidéo";
		}
		if($this->_url == null)
		{
			$this->_erreur++;
			$this->_listeErreur[] = "Merci de remplir le code d'intégration de la vidéo";
		}
		if($this->_erreur == 0)
		{
			$this->addVideo();
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

	public function addFichier()
	{
		$this->_nomDuFichier = $this->formatageFile($this->_fichier['name']);
		$fichierTemporaire = $this->_fichier['tmp_name'];

		if($_FILES['file']['name'] == "")
		{
			$sql = "INSERT INTO medias VALUES('','".$this->_nom."','".$this->_description."','".$this->_auteur."','".$this->_date."', '', '".$this->_type."', '', '', '')";
			$this->_db->exec($sql);
		}
		else
		{
			if(move_uploaded_file($fichierTemporaire, "content/files/".$this->_nomDuFichier))
			{
				$sql = "INSERT INTO medias VALUES('','".$this->_nom."','".$this->_description."','".$this->_auteur."','".$this->_date."', '', '".$this->_type."', '".$this->_nomDuFichier."', '', '')";
				$this->_db->exec($sql);
				//$this->createThumbs( "content/files/".$this->_nomDuFichier, "content/files/".$this->_nomDuFichier, 1920);
			}
			else
			{
				$this->_erreur++;
				$this->_listeErreur[] = "impossible d'uploader le fichier, réessayez";
			}
		}

		$this->_lastID = $this->_db->lastInsertId();
		$this->_nom = "";
		$this->_description = "";
		$this->_fichier = "";
		$this->_auteur = "";
		$this->_date = "";
	}

	public function addPhoto()
	{
		//echo "ok";
		$this->_nomDuFichier = $this->formatageFile($this->_image['name']);
		$fichierTemporaire = $this->_image['tmp_name'];

		if($_FILES['file']['name'] == "")
		{
			//echo "okkk";
			$sql = "INSERT INTO medias VALUES('','".$this->_nom."','".$this->_description."','".$this->_auteur."','".$this->_date."', '', '".$this->_type."', '', '', '".$this->_display."')";
			$this->_db->exec($sql);
		}
		else
		{
			if(move_uploaded_file($fichierTemporaire, "content/images/".$this->_nomDuFichier))
			{
				$sql = "INSERT INTO medias VALUES('','".$this->_nom."','".$this->_description."','".$this->_auteur."','".$this->_date."', '".$this->_nomDuFichier."', '".$this->_type."', '', '', '".$this->_display."')";
				$this->_db->exec($sql);
				$this->createThumbs( "content/images/".$this->_nomDuFichier, "content/images/".$this->_nomDuFichier, 1920);
			}
			else
			{
				$this->_erreur++;
				$this->_listeErreur[] = "impossible d'uploader l'image, réessayez";
			}
		}
		
		
		add_shortcode($this->_nom, "[shortcode plugin=galerie id=".$this->_db->lastInsertId()." height=500]", "");
		$this->_lastID = $this->_db->lastInsertId();
		$this->_nom = "";
		$this->_description = "";
		$this->_image = "";
		$this->_auteur = "";
		$this->_date = "";
	}

	public function addVideo()
	{
		$this->_nomDuFichier = $this->formatageFile($this->_image['name']);
		$fichierTemporaire = $this->_image['tmp_name'];

		if($_FILES['file']['name'] == "")
		{
			$sql = "INSERT INTO medias VALUES('','".$this->_nom."','".$this->_description."','".$this->_auteur."','".$this->_date."', '', '".$this->_type."', '', '".$this->_url."', '')";
			$this->_db->exec($sql);
		}
		else
		{
			if(move_uploaded_file($fichierTemporaire, "content/images/".$this->_nomDuFichier))
			{
				$sql = "INSERT INTO medias VALUES('','".$this->_nom."','".$this->_description."','".$this->_auteur."','".$this->_date."', '".$this->_nomDuFichier."', '".$this->_type."', '', '".$this->_url."', '')";
				$this->_db->exec($sql);
				$this->createThumbs( "content/images/".$this->_nomDuFichier, "content/images/".$this->_nomDuFichier, 1920);
			}
			else
			{
				$this->_erreur++;
				$this->_listeErreur[] = "impossible d'uploader l'image, réessayez";
			}
		}
		add_shortcode($this->_nom, "[shortcode plugin=video id=".$this->_db->lastInsertId()."]", "");
		$this->_lastID = $this->_db->lastInsertId();
		$this->_nom = "";
		$this->_description = "";
		$this->_image = "";
		$this->_auteur = "";
		$this->_date = "";
		$this->_url = "";
	}

	public function affichagePhoto()
	{
		if(isset($_POST['valider']))
		{
			if($this->_erreur != 0)
			{
				$fusionDesErreurs = implode("<br/>", $this->_listeErreur);
				echo "<div class='rapport cadre col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3'>";
				echo "<h3>Rapport</h3>";
				echo "<div class='fail'>$fusionDesErreurs</div>";
				echo "</div>";
			}
			else
			{
				echo "<div class='rapport cadre col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3'>";
				echo "<h3>Rapport</h3>";
				echo "<div class='success'>Album créé avec succès<br/><br/><a href='galerie&page=editMedias&id=".$this->_lastID."&action=showMePhotos'>Cliquez ici pour y ajouter des photos</a></div>";
				echo "</div>";
			}
		}

		echo "<div class='cadre col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3'>";
		echo "<h3>Contenu</h3>";
		echo "<div class='col-sm-12'><label for='nom' class='col-md-2 labelLeft'>Nom&nbsp&nbsp</label><input type='text' class='col-sm-12 col-md-8' value='".stripslashes(htmlspecialchars($this->_nom, ENT_QUOTES))."' placeholder='Nom du contenu (obligatoire)' name='nom' maxlength='250'></div>";
		echo "<div class='col-sm-12'><label for='file' class='col-md-2 labelLeft'>Illustration&nbsp&nbsp</label><input type='file' id='file' name='file'/><input type='button' class='col-sm-12 col-md-5' value='Photo' id='file_btn'/></div>";
		echo "<div class='col-sm-12'><label for='description' class='col-md-2 labelLeft'>Description&nbsp&nbsp</label><textarea class='col-sm-12 col-md-8' name='description' placeholder='Description de votre contenu'>".$this->_description."</textarea></div>";
		
		echo "<div class='col-sm-12'><label for='display' class='col-md-6 labelLeft'>Mise en page de votre album&nbsp&nbsp</label><select name='display'><option class='col-md-6' value='mosaique'>Mosaïque</option><option value='slider'>Slider</option></select></div>";
		
		echo "</div>";
		echo "<div class='validerBtn col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3'><input type='submit' name='valider' id='valider' value='Sauvegarder'/></div>";
	}
	
	
	public function affichageFichier()
	{
		if(isset($_POST['valider']))
		{
			if($this->_erreur != 0)
			{
				$fusionDesErreurs = implode("<br/>", $this->_listeErreur);
				echo "<div class='rapport cadre col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3'>";
				echo "<h3>Rapport</h3>";
				echo "<div class='fail'>$fusionDesErreurs</div>";
				echo "</div>";
			}
			else
			{
				echo "<div class='rapport cadre col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3'>";
				echo "<h3>Rapport</h3>";
				echo "<div id='fichierEnvoye' class='success'>Fichier envoyé avec succès</div>";
				echo "</div>";
			}
		}

		echo "<div class='cadre col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3'>";
		echo "<h3>Contenu</h3>";
		echo "<div class='col-sm-12'><label for='nom' class='col-md-2 labelLeft'>Nom&nbsp&nbsp</label><input type='text' class='col-sm-12 col-md-8' value='".stripslashes(htmlspecialchars($this->_nom, ENT_QUOTES))."' placeholder='Nom du fichier (obligatoire)' name='nom' maxlength='250'></div>";
		echo "<div class='col-sm-12'><label for='file' class='col-md-2 labelLeft'>Fichier&nbsp&nbsp</label><input type='file' id='file' name='file'/><input type='button' class='col-sm-12 col-md-5' value='Parcourir' id='file_btn'/></div>";
		echo "<div class='col-sm-12'><label for='description' class='col-md-2 labelLeft'>Description&nbsp&nbsp</label><textarea class='col-sm-12 col-md-8' name='description' placeholder='Description de votre contenu'>".$this->_description."</textarea></div>";
		echo "</div>";
		echo "<div class='validerBtn col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3'><input type='submit' name='valider' id='valider' value='Sauvegarder'/></div>";
	}

	public function affichageVideo()
	{
		if(isset($_POST['valider']))
		{
			if($this->_erreur != 0)
			{
				$fusionDesErreurs = implode("<br/>", $this->_listeErreur);
				echo "<div class='rapport cadre col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3'>";
				echo "<h3>Rapport</h3>";
				echo "<div class='fail'>$fusionDesErreurs</div>";
				echo "</div>";
			}
			else
			{
				echo "<div class='rapport cadre col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3'>";
				echo "<h3>Rapport</h3>";
				echo "<div class='success'>Vidéo ajoutée avec succès</div>";
				echo "</div>";
			}
		}

		echo "<div class='cadre col-xs-12 col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3'>";
		echo "<h3>Contenu</h3>";
		echo "<div class='col-sm-12'><label for='nom' class='col-md-2 labelLeft'>Nom&nbsp&nbsp</label><input type='text' class='col-sm-12 col-md-8' value='".stripslashes(htmlspecialchars($this->_nom, ENT_QUOTES))."' placeholder='Nom du contenu (obligatoire)' name='nom' maxlength='250'></div>";
		echo "<div class='col-sm-12'><label for='file' class='col-md-2 labelLeft'>Illustration&nbsp&nbsp</label><input type='file' id='file' name='file'/><input type='button' class='col-sm-12 col-md-5' value='Photo' id='file_btn'/></div>";
		echo "<div class='col-sm-12'><label for='description' class='col-md-2 labelLeft'>Description&nbsp&nbsp</label><textarea class='col-sm-12 col-md-8' name='description' placeholder='Description de votre contenu (obligatoire)'>".$this->_description."</textarea></div>";
		echo "<div class='col-sm-12'><label for='url' class='col-md-2 labelLeft'>Vidéo&nbsp&nbsp</label><textarea class='col-sm-12 col-md-8' name='url' placeholder='".stripslashes(htmlspecialchars("Code d'intégration de la vidéo Youtube, Vimeo ou autre (obligatoire) Il commence généralement par \"<iframe...\"", ENT_QUOTES))."'>".stripslashes(htmlspecialchars($this->_url, ENT_QUOTES))."</textarea></div>";
		echo "</div>";
		echo "<div class='row validerBtn col-xs-12 col-sm-12 col-lg-6 col-lg-offset-3'><input type='submit' name='valider' id='valider' value='Sauvegarder'/></div>";
	}
}
?>

