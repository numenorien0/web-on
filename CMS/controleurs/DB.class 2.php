<?php 
class DB
{
	private $_db;
	private $_listAllLang;
	public function __construct()
	{
		#echo dirname($_SERVER['PHP_SELF'])."/db.conf";
		#if(file_exists(dirname($_SERVER['PHP_SELF'])."/db.conf"))
		#{
		// $dsn = "mysql:dbname=CMS;host=localhost;charset=utf8";
		// $login = "root";
		// $password = "y31TOGBRkc";
			
			if(file_exists("CMS/db.conf"))
			{
				$fichierParametre = file("CMS/db.conf");
			}
			else
			{
				if(file_exists("db.conf"))
				{
					$fichierParametre = file("db.conf");
				}
				else
				{
					header("location: installation.php");
				}
			}

			
			foreach($fichierParametre as &$ligne)
			{
				$ligne = str_replace("\n", "", $ligne);
			}
			$db_name = $fichierParametre[0];
			$dsn = "mysql:dbname=".$fichierParametre[0].";host=".$fichierParametre[1].";charset=".$fichierParametre[2];
			$login = $fichierParametre[3];
			$password = $fichierParametre[4];
			try 
			{
	            $this->_db = new PDO($dsn, $login, $password);
	            return $this->_db;
	        }
	        catch(PDOException $e)
	        {
	        	echo "erreur de connexion à la base de donnée";
	        }
	   # }
	   # else
	   # {
		    
	   # }

	}
	
	public function createThumbs( $pathToImages, $pathToThumbs, $thumbWidth ) 
	{
	    $info = pathinfo($pathToImages);
	    if ( strtolower($info['extension']) == 'jpg' OR strtolower($info['extension']) == 'jpeg' ) 
	    {

	      $img = imagecreatefromjpeg($pathToImages);
	      $width = imagesx( $img );
	      $height = imagesy( $img );
	
		  //if($width > $thumbWidth)
		  //{
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
	    if(strtolower($info['extension']) == "png")
	    {
		    //echo "ok";
	      $img = imagecreatefrompng($pathToImages);
	      $width = imagesx( $img );
	      $height = imagesy( $img );
	
		  //if($width > $thumbWidth)
		  //{
		      // calculate thumbnail size
		      $new_width = $thumbWidth;
		      $new_height = floor( $height * ( $thumbWidth / $width ) );
		
			  $im = ImageCreateFromPNG($pathToImages);

				$im_dest = imagecreatetruecolor ($new_width, $new_height);
				imagealphablending($im_dest, false);
				
				imagecopyresampled($im_dest, $im, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
				
				imagesavealpha($im_dest, true);
				imagepng($im_dest, $pathToThumbs);
		      // save thumbnail into a file
		      //imagepng( $tmp_img, $pathToThumbs);
		      //$this->convertPNGto8bitPNG($pathToImages, $pathToThumbs);
		  //}
		  //else
		  //{
			  //return false;
		  //}
	    }
	}
	
	public function listAllLang()
	{
		$array = array("fr" => "Français", "en" => "Anglais", "de" => "Allemand", "nl" => "Néerlandais", "es" => "Espagnol", "it" => "Italien", "pt" => "Portugais", "bg" => "Bulgare", "cs" => "Tchèque", "da" => "Danois", "et" => "Estonien", "el" => "Grec", "ga" => "Irlandais", "hr" => "Croate", "lv" => "Letton", "lt" => "Lituanien", "hu" => "Hongrois", "mt" => "Maltais", "pl" => "Polonais", "ro" => "Roumain", "sk" => "Slovaque", "sl" => "Slovène", "fi" => "Finnois", "sv" => "Suédois", "zh" => "Chinois", "ar" => "Arabe", "ja" => "Japonais");
		asort($array);
		return $array;
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
	
	public function ecommerce_is_actived()
	{
		$sql = "SELECT * FROM systeme WHERE nom = 'ecommerce'";
		$reponse = $this->_db->query($sql);
		
		while($donnees = $reponse->fetch())
		{	
			if($donnees['valeur'] == "on")
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	
	public function is_admin()
	{
		$ID = $_SESSION['ID'];
		$sql = "SELECT * FROM login WHERE ID = $ID";
		$reponse = $this->_db->query($sql);
		
		while($donnees = $reponse->fetch())
		{
			if($donnees['rang'] == "administrateur")
			{
				return true;
			}
			else
			{
				return false;
			}
			
			
		}
		
	}
	
	public function clean_url($texte) {
		//Suppression des espaces en début et fin de chaîne
		$texte = trim($texte);
	 
		//Suppression des accents
		$texte = strtr($texte,'ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËéèêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ','aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn');
	 
		//mise en minuscule
		$texte = strtolower($texte);
	 
		//Suppression des espaces et caracteres spéciaux
		$texte = str_replace(" ",'-',$texte);
		$texte = preg_replace('#([^a-z0-9-])#','-',$texte);
	 
		//Suppression des tirets multiples
		$texte = preg_replace('#([-]+)#','-',$texte);
	 
		//Suppression du premier caractère si c'est un tiret
		if($texte{0} == '-')
			$texte = substr($texte,1);
	 
		//Suppression du dernier caractère si c'est un tiret
		if(substr($texte, -1, 1) == '-')
			$texte = substr($texte, 0, -1);
	 
		return $texte;
	}	
	
}
?>

