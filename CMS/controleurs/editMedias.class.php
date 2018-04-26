<?php
class editMedias extends DB
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
	public function __construct()
	{
		$this->_db = parent::__construct();
		$this->determineType();
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
			}
			else
			{
				$new_width = $width;
				$new_height = $height;
			}
			  // create a new temporary image
			  $tmp_img = imagecreatetruecolor( $new_width, $new_height );
			
			  // copy and resize old image into new image 
			  imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
			
			  // save thumbnail into a file
			  imagejpeg( $tmp_img, $pathToThumbs, 70);
			
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
			}
			else
			{
				$new_width = $width;
				$new_height = $height;
			}
		      
		
			  $im = ImageCreateFromPNG($pathToImages);

				$im_dest = imagecreatetruecolor ($new_width, $new_height);
				imagealphablending($im_dest, false);
				
				imagecopyresampled($im_dest, $im, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
				
				imagesavealpha($im_dest, true);
				imagepng($im_dest, $pathToThumbs);
		  
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



	public function determineType()
	{
		if(isset($_GET['id']) AND $_GET['id'] != null)
		{
			$sql = "SELECT * FROM medias WHERE ID = ".$_GET['id'];
			$reponse = $this->_db->query($sql);

			if($reponse->rowCount() == 0)
			{
				header("location: listMedias.php");
			}
			else
			{
				while($donnees = $reponse->fetch())
				{
					$this->_type = $donnees['type'];
				}

				if(isset($_GET['action']) AND $_GET['action'] == "deleteImage")
				{
					$this->deleteImage();
				}

				$this->lectureDansLaBDD();

				if($this->_type == "photo")
				{
					if(isset($_POST['valider']))
					{
						$this->verificationPhoto();
					}
					$this->affichagePhoto();
				}
				if($this->_type == "fichier")
				{
					if(isset($_POST['valider']))
					{
						$this->verificationFichier();
					}
					$this->affichageFichier();
				}
				if($this->_type == "video")
				{
					if(isset($_POST['valider']))
					{
						$this->verificationVideo();
					}
					$this->affichageVideo();
				}
			}
		}
		else
		{
			header("location: listMedias.php");
		}
	}

	public function deleteImage()
	{
		$sql = "SELECT * FROM medias WHERE ID = ".$_GET['id'];
		$reponse = $this->_db->query($sql);
			
		
		
		while($donnees = $reponse->fetch())
		{
			delete_shortcode($donnees['nom']);
			$imageASupprimer = "content/images/".$donnees['image'];
			unlink($imageASupprimer);
			$sql2 = "UPDATE medias SET image = '' WHERE ID = ".$_GET['id'];
			$reponse2 = $this->_db->query($sql2);
			header("location: editMedias.php?id=".$_GET['id']);
		}
	}

	public function verificationVideo()
	{
		$this->_nom = str_replace("'","''",$_POST['nom']);
		$this->_description = str_replace("'","''",$_POST['description']);
		$this->_image = $_FILES['file'];
		$this->_date = time();
		$this->_auteur = $_SESSION['login'];
		$this->_type = $_GET['type'];
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
			$this->editVideo();
		}
	}

	public function verificationFichier()
	{
		$this->_nom = str_replace("'","''",$_POST['nom']);
		$this->_description = str_replace("'","''",$_POST['description']);
		$this->_fichier = $_FILES['file'];
		$this->_date = time();
		$this->_auteur = $_SESSION['login'];
		$this->_type = $_GET['type'];

		if($this->_nom == null)
		{
			$this->_erreur++;
			$this->_listeErreur[] = "Merci de renseigner un nom à votre album photo";
		}

		if($this->_erreur == 0)
		{
			$this->editFichier();
		}
	}

	public function verificationPhoto()
	{
		$this->_nom = str_replace("'","''",$_POST['nom']);
		$this->_description = str_replace("'","''",$_POST['description']);
		$this->_image = $_FILES['file'];
		$this->_auteur = $_SESSION['login'];
		$this->_type = $_GET['type'];
		$this->_display = $_POST['display'];

		if($this->_nom == null)
		{
			$this->_erreur++;
			$this->_listeErreur[] = "Merci de renseigner un nom à votre album photo";
		}

		if($this->_erreur == 0)
		{
			$this->editAlbum();
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

	public function editFichier()
	{
		$sql = "UPDATE medias SET nom = '".$this->_nom."', description = '".$this->_description."' WHERE ID = ".$_GET['id'];
		$this->_db->exec($sql);
		
		$this->_nom = "";
		$this->_description = "";
		$this->_image = "";
		$this->_fichier = "";
		$this->_auteur = "";
		$this->_date = "";
	}


	public function editAlbum()
	{
		$this->_nomDuFichier = $this->formatageFile($this->_image['name']);
		$fichierTemporaire = $this->_image['tmp_name'];

		$sql = "SELECT * FROM medias WHERE ID = ".$_GET['ID'];
		$reponse = $this->_db->query($sql);
		
		$reponse = $reponse->fetchAll()[0];
		delete_shortcode($reponse['nom']);

		if($_FILES['file']['name'] == "")
		{
			$sql = "UPDATE medias SET nom = '".$this->_nom."', description = '".$this->_description."', display = '".$this->_display."' WHERE ID = ".$_GET['id'];
			$this->_db->exec($sql);
		}
		else
		{

			$sql10 = "SELECT * FROM medias WHERE ID = ".$_GET['id'];
			$reponse10 = $this->_db->query($sql10);
			while($donnees10 = $reponse10->fetch())
			{
				@unlink("content/images/".$donnees10['image']);
			}

			if(move_uploaded_file($fichierTemporaire, "content/images/".$this->_nomDuFichier))
			{
				$sql = "UPDATE medias SET nom = '".$this->_nom."', description = '".$this->_description."', image = '".$this->_nomDuFichier."', type_album = '".$this->_display."' WHERE ID = ".$_GET['id'];
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
		$this->_nom = "";
		$this->_description = "";
		$this->_image = "";
		$this->_auteur = "";
		$this->_date = "";
	}

	public function editVideo()
	{
		$this->_nomDuFichier = $this->formatageFile($this->_image['name']);
		$fichierTemporaire = $this->_image['tmp_name'];

		$sql = "SELECT * FROM medias WHERE ID = ".$_GET['ID'];
		$reponse = $this->_db->query($sql);
		
		$reponse = $reponse->fetchAll()[0];
		delete_shortcode($reponse['nom']);
		
		if($_FILES['file']['name'] == "")
		{
			$sql = "UPDATE medias SET nom = '".$this->_nom."', description = '".$this->_description."', url = '".$this->_url."' WHERE ID = ".$_GET['id'];
			$this->_db->exec($sql);
		}
		else
		{

			$sql10 = "SELECT * FROM medias WHERE ID = ".$_GET['id'];
			$reponse10 = $this->_db->query($sql10);
			while($donnees10 = $reponse10->fetch())
			{
				@unlink("content/images/".$donnees10['image']);
			}

			if(move_uploaded_file($fichierTemporaire, "content/images/".$this->_nomDuFichier))
			{
				$sql = "UPDATE medias SET nom = '".$this->_nom."', description = '".$this->_description."', image = '".$this->_nomDuFichier."', url = '".$this->_url."' WHERE ID = ".$_GET['id'];
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
		$this->_nom = "";
		$this->_description = "";
		$this->_image = "";
		$this->_auteur = "";
		$this->_date = "";
		$this->_url = "";
	}

	public function lectureDansLaBDD()
	{
		$sql = "SELECT * FROM medias WHERE ID = ".$_GET['id'];
		$reponse = $this->_db->query($sql);

		while($donnees = $reponse->fetch())
		{
			$this->_nom = stripslashes(htmlspecialchars($donnees['nom']));
			$this->_description = stripslashes(htmlspecialchars($donnees['description']));
			$this->_image = $donnees['image'];
			$this->_auteur = $donnees['auteur'];
			$this->_date = $donnees['date'];
			$this->_url = $donnees['url'];
			$this->_fichier = $donnees['fichier'];
			$this->_display = $donnees['display'];
		}	
	}

	public function affichageFichier()
	{
		if(isset($_POST['valider']))
		{
			if($this->_erreur != 0)
			{
				$fusionDesErreurs = implode("<br/>", $this->_listeErreur);
				echo "<div class='rapport cadre col-sm-12 col-lg-6 col-lg-offset-3'>";
				echo "<h3>Rapport</h3>";
				echo "<div class='fail'>$fusionDesErreurs</div>";
				echo "</div>";
			}
			else
			{
				echo "<div class='rapport cadre col-sm-12 col-lg-6 col-lg-offset-3'>";
				echo "<h3>Rapport</h3>";
				echo "<div class='success'>Fichier édité avec succès<br/>redirection dans <span id='decompte'>5 secondes</span></div>";
				echo "</div>";
			}
		}

		echo "<div id='formulaire'>";
		echo "<div class='cadre col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3'>";
		echo "<h3>Contenu</h3>";
		echo "<div class='col-sm-12'><label for='url' class='col-md-2 labelLeft'>Lien&nbsp&nbsp</label><input type='text' disabled class='col-sm-12 col-md-8' value='http://www.".$_SERVER['HTTP_HOST']."/CMS/content/files/".$this->_fichier."'></div>";
		echo "<div class='col-sm-12'><label for='nom' class='col-md-2 labelLeft'>Nom&nbsp&nbsp</label><input type='text' class='col-sm-12 col-md-8' value='".stripslashes(htmlspecialchars($this->_nom, ENT_QUOTES))."' placeholder='Nom du fichier (obligatoire)' name='nom' value=''></div>";
		echo "<div class='col-sm-12'><label class='col-md-2 labelLeft'>Fichier</label><input class='col-sm-12 col-md-8' type='text' disabled value='".$this->_fichier."'/></div>";
		echo "<div class='col-sm-12'><label for='description' class='col-md-2 labelLeft'>Description&nbsp&nbsp</label><textarea class='col-sm-12 col-md-8' name='description' placeholder='Description de votre contenu'>".$this->_description."</textarea></div></div>";
		echo "<div class='validerBtn col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3'><input type='submit' name='valider' id='valider' value='Sauvegarder'/></div>";
		//echo "</div>";		
	}

	public function affichageVideo()
	{
		if(isset($_POST['valider']))
		{
			if($this->_erreur != 0)
			{
				$fusionDesErreurs = implode("<br/>", $this->_listeErreur);
				echo "<div class='rapport cadre col-sm-12 col-lg-6 col-lg-offset-3'>";
				echo "<h3>Rapport</h3>";
				echo "<div class='fail'>$fusionDesErreurs</div>";
				echo "</div>";
			}
			else
			{
				echo "<div class='rapport cadre col-sm-12 col-lg-6 col-lg-offset-3'>";
				echo "<h3>Rapport</h3>";
				echo "<div class='success'>Contenu édité avec succès<br/>redirection dans <span id='decompte'>5 secondes</span></div>";
				echo "</div>";
			}
		}

		if($this->_image != "")
		{
			$image = "<img class='imageEdit col-sm-4 col-sm-offset-2' src='content/images/".$this->_image."'>";
			$valuePhoto = "Changer";
			$delete = "<a class='col-md-2 col-sm-12 deleteImage' href='&action=deleteImage'>Supprimer</a>";
		}
		else
		{
			$image = "<p class='col-sm-4 col-sm-offset-2 PasDePhotos'>Pas de photo</p>";
			$valuePhoto = "Ajouter";
			$delete = "";
		}

		echo "<div id='formulaire'>";
		echo "<div class='cadre col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3'>";
		echo "<h3>Contenu</h3>";
		echo "<div class='col-sm-12'><label for='nom' class='col-md-2 labelLeft'>Nom&nbsp&nbsp</label><input type='text' class='col-sm-12 col-md-8' value='".stripslashes(htmlspecialchars($this->_nom, ENT_QUOTES))."' placeholder='Nom du contenu (obligatoire)' name='nom' value=''></div>";
		echo "<div class='col-sm-12'>".$image."</div>";
		echo "<div class='col-sm-12'><label for='file' class='col-md-2 labelLeft'>Illustration&nbsp&nbsp</label><input type='file' id='file' name='file'/><input type='button' class='col-sm-12 col-md-5' value='".$valuePhoto."' id='file_btn'/>".$delete."</div>";
		echo "<div class='col-sm-12'><label for='description' class='col-md-2 labelLeft'>Description&nbsp&nbsp</label><textarea class='col-sm-12 col-md-8' name='description' placeholder='Description de votre contenu'>".$this->_description."</textarea></div>";
		echo "<div class='col-sm-12'><label for='url' class='col-md-2 labelLeft'>Vidéo&nbsp&nbsp</label><textarea class='col-sm-12 col-md-8' name='url' placeholder='".stripslashes(htmlspecialchars("Code d'intégration de la vidéo Youtube, Vimeo ou autre (obligatoire)", ENT_QUOTES))."'>".stripslashes(htmlspecialchars($this->_url, ENT_QUOTES))."</textarea></div>";		
		echo "<div class='col-sm-8 col-sm-offset-2'><div class='laVideo'>La vidéo</div><div class='iframeVideo'>$this->_url</div></div>";
		echo "<div class='shortCode col-sm-12'>[shortcode plugin=video id=".$_GET['id']."]</div>";
		echo "</div>";
		
		echo "<div class='validerBtn col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3'><input type='submit' name='valider' id='valider' value='Sauvegarder'/></div>";
		echo "</div>";		
	}

	public function affichagePhoto()
	{
		if(isset($_POST['valider']))
		{
			if($this->_erreur != 0)
			{
				$fusionDesErreurs = implode("<br/>", $this->_listeErreur);
				echo "<div class='rapport cadre col-sm-12 col-lg-6 col-lg-offset-3'>";
				echo "<h3>Rapport</h3>";
				echo "<div class='fail'>$fusionDesErreurs</div>";
				echo "</div>";
			}
			else
			{
				echo "<div class='rapport cadre col-sm-12 col-lg-6 col-lg-offset-3'>";
				echo "<h3>Rapport</h3>";
				echo "<div class='success'>Contenu édité avec succès<br/>redirection dans <span id='decompte'>5 secondes</span></div>";
				echo "</div>";
			}
		}

		if($this->_image != "")
		{
			$image = "<img class='imageEdit col-sm-4 col-sm-offset-2' src='content/images/".$this->_image."'>";
			$valuePhoto = "Changer";
			$delete = "<a class='col-md-2 col-sm-12 deleteImage' href='&action=deleteImage'>Supprimer</a>";
		}
		else
		{
			$image = "<p class='col-sm-4 col-sm-offset-2 PasDePhotos'>Pas de photo</p>";
			$valuePhoto = "Ajouter";
			$delete = "";
		}

		echo "<div id='formulaire'>";
		echo "<div class='cadre col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3'>";
		echo "<h3>Contenu</h3>";
		echo "<div class='col-sm-12'><label for='nom' class='col-md-2 labelLeft'>Nom&nbsp&nbsp</label><input type='text' class='col-sm-12 col-md-8' value='".stripslashes(htmlspecialchars($this->_nom, ENT_QUOTES))."' placeholder='Nom du contenu (obligatoire)' name='nom' value=''></div>";
		echo "<div class='col-sm-12'>".$image."</div>";
		echo "<div class='col-sm-12'><label for='file' class='col-md-2 labelLeft'>Illustration&nbsp&nbsp</label><input type='file' id='file' name='file'/><input type='button' class='col-sm-12 col-md-5' value='".$valuePhoto."' id='file_btn'/>".$delete."</div>";
		echo "<div class='col-sm-12'><label for='description' class='col-md-2 labelLeft'>Description&nbsp&nbsp</label><textarea class='col-sm-12 col-md-8' name='description' placeholder='Description de votre contenu'>".$this->_description."</textarea></div>";
		echo "<div class='shortCode col-sm-12'>[shortcode plugin=galerie id=".$_GET['id']." height=500px]</div>";
		echo "<div class='col-sm-12'><label for='display' class='col-md-6 labelLeft'>Mise en page de votre album&nbsp&nbsp</label><select name='display'><option class='col-md-6' value='mosaique'>Mosaïque</option><option value='slider'>Slider</option></select></div>";
		echo "<input type='hidden' value='".$this->_display."' class='hiddenDisplay'/>";
		echo "<script>$(function(){
			$('select[name=display]').val($('.hiddenDisplay').val()); 
		});</script>";
		echo "</div>";
		echo "<div class='validerBtn col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3'><input type='submit' name='valider' id='valider' value='Sauvegarder'/><input type='button' id='addPhotos' value='Gérer les photos'/></div>";
		echo "</div>";
	}

	public function listAllPhoto()
	{
		$sql = "SELECT * from photos WHERE album = ".$_GET['id'];
		$reponse = $this->_db->query($sql);

		if($reponse->rowCount() == 0)
		{
			#echo "<div class='notYet col-sm-12'>Pas encore de photo</div>";
		}

		echo "<form class='formPhotos col-sm-8 col-sm-offset-2' enctype='multipart/form-data' action method='POST'>";
		echo "<input type='hidden' id='albumHidden' value='".$_GET['id']."'>";
		echo "<div id='dropfile'><div id='explicationUpload'>Glissez vos fichiers ici<br/><br/>ou<br/>";
		echo "<input type='file' id='file_photo' multiple name='file_photo'/><input type='button' value='Parcourir' id='buttonPhoto'/></div>";
		echo "<div class='row'><h5 class='col-sm-12' style='margin-top: 20px; text-align: center' id='status'>&nbsp</h5></div>
				<div class='row'><progress style='margin-top: 5px; margin-bottom: 15px;' id='progressBar' value='0' max='100' class='col-sm-10 col-sm-push-1'></progress></div>";
		echo "</div>";
		echo "</form>";
		echo "<div class='col-sm-12' id='listPhoto'>";
		// while($donnees = $reponse->fetch())
		// {
		// 	echo "ok";
		// }	
		echo "</div>";

	}

}
?>

