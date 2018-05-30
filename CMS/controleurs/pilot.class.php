<?php 
class pilot extends DB
{
	private $_db;
	private $_skin;
	public $_the_page;
	public $_current_lang;
	public $_breadCrumb = array();
	public $_connected = false;
    public function __construct()
	{
	    $this->_db = parent::__construct();
	    if(!isset($_GET['lang']) OR $_GET['lang'] == "redirect")
	    {
	        $this->_current_lang = $this->get_main_language();
	        header('location: ./'.$this->_current_lang."/");
	    }
	    else
	    {
	        
	        $this->_current_lang = $_GET['lang'];
	    }
	    
	    $this->isConnected();
	    
	}
	
	
	public function compressImage( $pathToImages, $thumbWidth ) 
	{
	    $info = pathinfo($pathToImages);
	    
	    if ( strpos(strtolower($info['extension']), "jpg") !== false OR strpos(strtolower($info['extension']), "jpeg") !== false) 
	    {
			
			$img = imagecreatefromjpeg($pathToImages);
			$width = imagesx( $img );
			$height = imagesy( $img );
	
			$new_width = $thumbWidth;
			$new_height = floor( $height * ( $thumbWidth / $width ) );

			$tmp_img = imagecreatetruecolor( $new_width, $new_height );

			imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
			
			ob_start();

			imagejpeg( $tmp_img, "php://output", 100);
			
			$image_data = ob_get_contents();
			ob_end_clean();
			$image_data = 'data:image/jpg;base64,'.base64_encode($image_data);
			return $image_data;
		      

	    }
	    if(strpos(strtolower($info['extension']), "png") !== false)
	    {
			$img = imagecreatefrompng($pathToImages);
			$width = imagesx( $img );
			$height = imagesy( $img );

			$new_width = $thumbWidth;
			$new_height = floor( $height * ( $thumbWidth / $width ) );
			
			$im = ImageCreateFromPNG($pathToImages);
			
			$im_dest = imagecreatetruecolor ($new_width, $new_height);
			imagealphablending($im_dest, false);
			
			imagecopyresampled($im_dest, $im, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
			
			imagesavealpha($im_dest, true);
			ob_start();
			imagepng($im_dest);
			$image_data = ob_get_contents();
			ob_end_clean();
			$image_data = 'data:image/png;base64,'.base64_encode($image_data);
			return $image_data;

	    }
	}
	
	
	public function isConnected()
	{
		$trouve = false;
		if(isset($_COOKIE['weboncmslogin']) AND $_COOKIE['weboncmslogin'] != null)
		{
			$sql = "SELECT * FROM login";
			$reponse = $this->_db->query($sql);

			$separationDesChampsDuCookie = explode("<-_->", $_COOKIE['weboncmslogin']);
			$login = $separationDesChampsDuCookie[0];
			$password = $separationDesChampsDuCookie[1];

			while($donnees = $reponse->fetch())
			{
				if($donnees['login'] == $login AND $donnees['password'] == $password)
				{
					$_SESSION['login'] = $login;
					$_SESSION['ID'] = $donnees['ID'];
					$trouve = true;
					#ecriture de la nouvelle date de connexion
					$time = time();
					$sql2 = "UPDATE login set connexion = :date_time WHERE login = :login";
					$reponse2 = $this->_db->prepare($sql2);
					$reponse2->bindParam(':date_time', $time);
					$reponse2->bindParam(':login', $login);
					$reponse2->execute();
					
					$this->_connecte = true;
					return true;
				}
			}

			if($trouve == false)
			{
				$this->_connecte = false;
				return false;
			}
		}
		else
		{
			$this->_connecte = false;
		    return false;
		    
		}
	}
	
	
	public function get_filetype($file)
	{
	    $finfo = finfo_open(FILEINFO_MIME_TYPE);
		return finfo_file($finfo, $file);
	}
	
	public function get_favicon()
	{
	    $favicon = glob("CMS/content/logo/favicon.*");
	    return $favicon[0];
	}
	
	public function get_base()
	{
	    return "<base href='http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."'/>";
	}
	
	public function get_theme_path()
	{
	    return "CMS/themes/".$this->_skin."/";
	}
	
	public function get_featured_image($id)
	{
		if(!$id)
		{
		   return $this->_the_page['image'];
		}
		else
		{
		    return "CMS/".$this->get_pages(array("ID" => $id))[0]['image'];
		}

		
	}
	
	public function get_id()
	{

	    return $this->_the_page['ID'];

	}
	
	public function get_main_language()
	{
	    if($_COOKIE['mainLanguage'] != null)
	    {
	        return $_COOKIE['mainLanguage'];
	    }
	    else
	    {
	        $sql = "SELECT * FROM systeme WHERE nom = 'langue_principale'";
	        $reponse = $this->_db->query($sql);
	        $lang = $reponse->fetchAll()[0]['valeur'];
	        setcookie("mainLanguage", $lang, time() + 24*3600, "/");
	        return $lang;
	
	    } 
	 }
	
	public function get_topbar()
	{
	    $file = file_get_contents("CMS/content/menu/".$this->_current_lang."/topmenu.php");
	    
	    return $file;
	    
	}
	
	public function get_social()
	{
	    $sql = "SELECT * FROM systeme WHERE nom = 'social'";
	    $reponse = $this->_db->prepare($sql);
	    $reponse->execute();
	    
	    return json_decode($reponse->fetchAll()[0]['valeur'], true);
	}
	
	public function get_site_title()
	{
	    $sql = "SELECT * FROM systeme WHERE nom = 'titre'";
	    $reponse = $this->_db->prepare($sql);
	    $reponse->execute();
	    
	    return $reponse->fetchAll()[0]['valeur'];
	}
	
	public function get_skin()
    {
        $sql = "SELECT * FROM systeme WHERE nom = 'skin'";
        $reponse = $this->_db->query($sql);

		while($donnees = $reponse->fetch())
		{
			$skin = $donnees['valeur'];
		}
		$this->_skin = $skin;
		return $skin;
    }
	
	public function get_logo()
	{
	    $logo = glob("CMS/content/logo/logo.*");
		return $logo[0];
	}
	
	public function get_id_from_slug($slug)
	{
	    if($slug== null OR $slug == "homepageRedirect")
        {
            $sql = "SELECT ID from contenu WHERE homepage = 'on'";
            
            $reponse = $this->_db->query($sql);
            
            $id = $reponse->fetchAll()[0]['ID'];
        }
        else
        {
            $sql = "SELECT ID from contenu WHERE nameURL = '".$slug."'";
            $reponse = $this->_db->query($sql);
            
            $id = $reponse->fetchAll()[0]['ID'];
        }
        
        return $id;
	}
	
	public function execute_php($content)
	{
	    return eval(" ?>".$content."<?php ");
	}
	
	public function do_shortcode($content)
	{

	    $widget = array();
	    if (preg_match("/\[shortcode(.+?)?\](?:(.+?)?\[\/shortcode\])?/", $content, $matches, PREG_OFFSET_CAPTURE)) {
	        $shortcode = $matches[1];
	        $position = $matches[0];
	            $key = 0;
	            $shortcode = $shortcode[0];
	            if($shortcode != null)
	            {
    	            $argument = explode(" ", $shortcode);
    	            
    	            foreach($argument as $arg)
    	            {
    	                if($arg != null)
    	                {
    	                    $arg = str_replace("'", "", $arg);
    	                    $arg = str_replace('"',"", $arg);
    	                    $arg = explode("=", $arg);
    	                    $widget[$key][$arg[0]] = $arg[1];
    	                    $widget[$key]['position'] = $position[1];
    	                    $widget[$key]['longueur'] = strlen($position[0]);
    	                }
    	                
    	                
    	                
    	            }
	            }

	        $condition = false;
	        foreach($widget as $w)
	        {
	            if($w["plugin"] == "galerie")
	            {
	                $return = "";
                    $sql = "SELECT * FROM medias WHERE ID = :id";
                    $reponse = $this->_db->prepare($sql);
                    $reponse->bindParam(":id", $w["id"]);
                    
                    $reponse->execute();
                    $display = $reponse->fetchAll()[0]['display'];
                    
                    $sql = "SELECT * FROM photos WHERE album = :id";
                    $reponse = $this->_db->prepare($sql);
                    $reponse->bindParam(":id", $w["id"]);
                    $reponse->execute();
                    if($display == "mosaique")
                    {
                        $return .= "<div class='carousel' style='width: 100%; height: ".$w["height"]."''>";
                        while($donnees = $reponse->fetch(PDO::FETCH_ASSOC))
                        {
                            $return .= "<div class='miniature' style='display: flex; float: left; width: 100px; height: 100px'><img style='margin: auto; max-width: 100%; max-height: 100%' data-fichier='CMS/content/album/".$donnees['fichier']."' src='CMS/content/thumbnail/".$donnees['fichier']."' alt='".$donnees['description']."' /></div>";
                        }
                        $return .= "</div>";
                    }
                    if($display == "slider")
                    {
                        #$return .= "<div class='container'>";
                        $return .= "<div class='carousel' style='width: 100%; height: ".$w["height"]."'>";
                        while($donnees = $reponse->fetch(PDO::FETCH_ASSOC))
                        {
                            $return .= "<div class='slider' style='display: block; width: 100%; position: absolute'><div class='sliderTitle'>".$donnees['description']."</div><img style='margin: auto; width: 100%' src='CMS/content/album/".$donnees['fichier']."' alt='".$donnees['description']."' /></div>";
                        }
                       $return .= "</div>";
                    }
                    
                    $content = substr_replace($content, $return, $w["position"], $w['longueur']);
	            }
	            elseif($w["plugin"] == "video")
	            {
	                $return = "";
	                $sql = "SELECT * FROM medias WHERE ID = :id";
                    $reponse = $this->_db->prepare($sql);
                    $reponse->bindParam(":id", $w["id"]);
                    
                    $reponse->execute();
                    $return .= $reponse->fetchAll()[0]['url'];
                    //echo $return;
                    $content = substr_replace($content, $return, $w["position"], $w['longueur']);
	            }
	            else
	            {
	                $return = "";
	                $get = array();
	                foreach($w as $key => $argu)
	                {
	                    $get[] = $key."=".$argu;
	                }
	                $get = implode("&", $get);

	                $return = file_get_contents("CMS/plugins/".$w["plugin"]."/widgets/".$w['id']);
	                if(preg_match_all('/\$\_PLUGIN\[(.+)\]/', $return, $match))
	                {
	                    foreach($match[0] as $key => $valeurGet)
	                    {
	                        $get = str_replace('"', '', str_replace("'", "",$match[1][$key]));
	                        $return = str_replace($valeurGet, $w[$get], $return);
	                    }
	                }

	                $content = substr_replace($content, $return, $w["position"], $w['longueur']);
	            }
	        }
	        $retour = $content;
	        if(preg_match("/\[shortcode(.+?)?\](?:(.+?)?\[\/shortcode\])?/", $content)) {

	            return $this->do_shortcode($content);
	            $condition = false;
    	    }
    	    else
    	    {
    	        $condition = true;
    	        //echo $content;
    	        return $content;
    	    }
	    }
	    else
	    {
	        return $content;
	    }

	}
	
	
	
	public function get_breadcrumb($ID, $bread = array())
	{
	    $currentPage = $this->get_page();
	    
	    if(!$ID)
	    {
	        $ID = $currentPage['parent'];
	    }
	    
	    $return = $this->get_pages(array("ID" => $ID))[0];
        
        
        
	    if($return['parent'] != null )
	    {
			
	        $bread[] = array("URL" => $return['URL'], "name" => $return['name']);
	        return $this->get_breadcrumb($return['parent'], $bread);
	    }
	    else
	    {
	        if($currentPage['parent'] != null AND $return['homepage'] != "on")
	        {
                $bread[] = array("URL" => $return['URL'], "name" => $return['name']);
	        }
	        
            $bread = array_reverse($bread);
            $bread[] = array("URL" => $currentPage['URL'], "name" => $currentPage['name']);
	        return $bread;
	    }
	    
	}
	
	public function get_pages($opt)
	{
	    
	    if(isset($_GET['lang']) AND $_GET['lang'] != $this->get_main_language() AND $_GET['lang'] != null)
	    {
	        $sql = "SELECT 
	        contenu.ID, 
		    contenu_traduction.nom as name, 
		    contenu_traduction.description, 
		    contenu_traduction.texte as text, 
		    contenu.parent, 
		    contenu.auteur as author, 
		    contenu.date,
		    contenu.image,
		    contenu.online,
		    contenu.commentaire,
		    contenu.update_auteur,
		    contenu.update_date,
		    contenu.keywords,
		    contenu.orderID,
		    contenu_traduction.champsPerso as customFields,
		    contenu.nameURL as permalink,
		    contenu.homepage,
		    contenu.display,
		    contenu.SEO_description,
            images.files,
			images.fileKeys,
	        images.resolution,
	        images.type,
	        images.nom as image_name,
	        images.description as image_description,
	        images.alt
	        FROM contenu 
			LEFT JOIN (select *, GROUP_CONCAT(file SEPARATOR '<--->' ) as files, GROUP_CONCAT(type SEPARATOR '<--->' ) as fileKeys from images GROUP BY parent) as images 
	        ON images.files LIKE concat('%',contenu.image,'%')
	        INNER JOIN contenu_traduction ON contenu.ID = contenu_traduction.contenu 
	        WHERE contenu_traduction.langue = :lang AND contenu.online = 'on' ";
	    }
	    else
	    {
	        //select *, GROUP_CONCAT(file SEPARATOR '---' ), GROUP_CONCAT(type SEPARATOR '---' ) from images WHERE 1 GROUP BY parent
	        $sql = "SELECT 
	            contenu.ID, 
			    contenu.nom as name, 
			    contenu.description, 
			    contenu.texte as text, 
			    contenu.parent, 
			    contenu.auteur as author, 
			    contenu.date,
			    contenu.image,
			    contenu.online,
			    contenu.commentaire,
			    contenu.update_auteur,
			    contenu.update_date,
			    contenu.keywords,
			    contenu.orderID,
			    contenu.champsPerso as customFields,
			    contenu.nameURL as permalink,
			    contenu.homepage,
			    contenu.display,
			    contenu.SEO_description,
			    images.files,
			    images.fileKeys,
			    images.resolution,
	            images.type,
	            images.nom as image_name,
	            images.description as image_description,
	            images.alt
	        FROM contenu 
	        LEFT JOIN (select *,  GROUP_CONCAT(file SEPARATOR '<--->' ) as files, GROUP_CONCAT(type SEPARATOR '<--->' ) as fileKeys FROM images GROUP BY parent) as images 
	        ON images.files LIKE concat('%',contenu.image,'%')
	        WHERE contenu.online = 'on' ";
	    }

	    
	    if($opt['name'] != null)
	    {
	        $sql .= "AND contenu.nom = :nom ";
	    }
	    if($opt['ID'] != null)
	    {
	        $sql .= "AND contenu.ID = :ID ";
	    }
	    if($opt['keywords'] != null)
	    {
	        
	        $sql .= "AND contenu.keywords LIKE :keywords ";
	    }
	    if($opt['parent'] != null)
	    {
	        $sql .= "AND contenu.parent = :parent ";
	    }
	    if($opt['orderBy'] == null) $opt['orderBy'] = "ID";
	    if($opt['sort'] == null) $opt['sort'] = "ASC";
	    if($opt['offset'] == null) $opt['offset'] = 0;
	    if($opt['limit'] == null) $opt['limit'] = 100000;
	    //if($opt['limit'] == null) $opt['limit'] = 100000;
	    
	    
	    //$sql .= " GROUP BY images.parent";
	    $sql .= "ORDER BY contenu.".$opt['orderBy']." ".$opt['sort']." LIMIT ".$opt['limit']." OFFSET ".$opt['offset'];
	    //$sql .= " GROUP BY images.file";
	   //echo $sql;
	    $reponse = $this->_db->prepare($sql);
	    if(isset($_GET['lang']) AND $_GET['lang'] != $this->get_main_language() AND $_GET['lang'] != null)
	    {
	        $reponse->bindParam(":lang", $this->_current_lang);
	    }
	    if($opt['name'] != null)
	    {
	        $reponse->bindParam(":nom", $opt['name']);
	    }
	    if($opt['ID'] != null)
	    {
		    if(!is_numeric($opt['ID']))
		    {
			    $opt['ID'] = $this->get_id_from_slug($opt['ID']);
		    }
	        $reponse->bindParam(":ID", $opt['ID']);
	    }
	    if($opt['keywords'] != null)
	    {
	        $keywords = "%".$opt['keywords']."%";
	        
	        $reponse->bindParam(":keywords", $keywords);
	    }
	    if($opt['parent'] != null)
	    {
		    if(!is_numeric($opt['parent']))
		    {
			    $opt['parent'] = $this->get_id_from_slug($opt['parent']);
		    }
		    
	        $reponse->bindParam(":parent", $opt['parent']);
	    }
	    //exit($opt['parent']);
	    $reponse->execute();
	    
	    $reponse = $reponse->fetchAll(PDO::FETCH_ASSOC);
	    //print_r($this->_db->errorInfo());
	    $return = array();
	    
	    foreach($reponse as $page)
	    {
					    
	        if($page['image'] != "null")
	        {
		        if($opt['image'] == null OR $opt['image'] == "full" OR $page["type"] == "video")
		        {
			        
		            $page['image'] = "CMS/".$page['image'];
		        }
		        else
		        {
		            $imageKey = explode("<--->", $page['fileKeys']);
		            $typeDeFichier = $imageKey;
		            
		            $imageKey = array_search($opt['image'], $imageKey);
		            $images = explode("<--->", $page['files']);
		            
		            
		            $page['image'] = "CMS/".$images[$imageKey];
		            $page['type'] = $typeDeFichier[$imageKey];
		        }
			}
			else
			{
				$page['image'] = "";
			}
			
	        $page['alt'] = json_decode($page['alt'], true)[$this->_current_lang];
	        $page['image_name'] = json_decode($page['image_name'], true)[$this->_current_lang];
	        $page['image_description'] = json_decode($page['image_description'], true)[$this->_current_lang];
	        $page['URL'] = $this->_current_lang."/".$page['permalink']."/";
	        $page["customFields"] = json_decode($page["customFields"], true);
	        
	        foreach($page["customFields"] as $key => $champsPerso)
	        {
	            if(file_exists("CMS/".$champsPerso) AND $champsPerso != null)
	            {
	                $page['customFields'][$key] = "CMS/$champsPerso";
	            }
	        }
	        //}
	        $return[] = $page;
	    }
	    
	    return $return;
	    
	}
	
	
	public function list_all_language()
	{
	    $liste_langue = parent::listAllLang();
	    
		$sql = "SELECT * FROM systeme WHERE nom = 'langue_principale'";
		$reponse = $this->_db->query($sql);
		
		$reponse = $reponse->fetchAll()[0];
		
		$langue_principale = $reponse['valeur'];
		$input = array();
		$input[$langue_principale] = $liste_langue[$langue_principale];
		$sql = "SELECT * FROM systeme WHERE nom = 'langue_secondaire'";
		$reponse = $this->_db->query($sql);
		
		while($donnees = $reponse->fetch())
		{
			$input[$donnees['valeur']] = $liste_langue[$donnees['valeur']];
		}
		
		return $input;		
	}
	
	public function get_page($id)
	{
	    $sql = "SELECT * FROM systeme WHERE nom = 'maintenance'";
	    $reponse = $this->_db->query($sql);
	    $reponse = $reponse->fetchAll()[0];
	    if($reponse['valeur'] == "true")
	    {
	        return "maintenance";
	    }
	    if(!$id)
	    {
	        $id = $_GET['f'];
	    }
        //echo $id;
        if(!is_int($id))
	    {
	        $id = $this->get_id_from_slug($id);
	    }
        //echo $id;
        if(isset($_GET['lang']) AND $_GET['lang'] != $this->get_main_language() AND $_GET['lang'] != null)
		{
			$sql = "SELECT 
			contenu.ID, 
		    contenu_traduction.nom as name, 
		    contenu_traduction.description, 
		    contenu_traduction.texte as text, 
		    contenu.parent, 
		    contenu.auteur as author, 
		    contenu.date,
		    contenu.online,
		    contenu.commentaire,
		    contenu.image,
		    contenu.update_auteur,
		    contenu.update_date,
		    contenu.keywords,
		    contenu.orderID,
		    contenu_traduction.champsPerso as customFields,
		    contenu.nameURL as permalink,
		    contenu.homepage,
		    contenu.display,
		    contenu.SEO_description,
		    images.alt,
		    images.type,
		    images.resolution
			FROM contenu 
			LEFT JOIN  (SELECT * FROM images GROUP BY parent, ID) as images ON images.file = contenu.image
			INNER JOIN contenu_traduction ON contenu.ID = contenu_traduction.contenu 
			WHERE contenu_traduction.langue = :lang AND contenu.ID = :id AND contenu.online = 'on'";
			
		    $reponse = $this->_db->prepare($sql);
			$reponse->bindParam(':lang', $_GET['lang']);
			$reponse->bindParam(':id', $id);
			$reponse->execute();
            $reponse = $reponse->fetchAll(PDO::FETCH_ASSOC);
            
		}
		else
		{
		    //SELECT * FROM images WHERE parent = (SELECT parent FROM images WHERE file = '$src') OR ID = (SELECT ID FROM images WHERE file = '$src')
			$sql = "SELECT 
			    contenu.ID, 
			    contenu.nom as name, 
			    contenu.description, 
			    contenu.texte as text, 
			    contenu.parent, 
			    contenu.auteur as author, 
			    contenu.date,
			    contenu.online,
			    contenu.commentaire,
			    contenu.image,
			    contenu.update_auteur,
			    contenu.update_date,
			    contenu.keywords,
			    contenu.orderID,
			    contenu.champsPerso as customFields,
			    contenu.nameURL as permalink,
			    contenu.homepage,
			    contenu.display,
			    contenu.SEO_description,
			    images.alt,
			    images.type,
			    images.resolution
			    FROM contenu
			    LEFT JOIN (SELECT * FROM images GROUP BY parent, ID) as images ON images.file = contenu.image
			    WHERE contenu.ID = :id AND contenu.online = 'on' GROUP BY images.parent";
			    //echo $sql;
			$reponse = $this->_db->prepare($sql);
			$reponse->bindParam(':id', $id);
			$reponse->execute();
            $reponse = $reponse->fetchAll(PDO::FETCH_ASSOC);
		}
		//echo $id;
		//echo $sql;
        $reponse[0]["imageFile"] = $reponse[0]["image"];
        $reponse[0]["image"] = "CMS/".$reponse[0]["image"];
        $reponse[0]['URL'] = $this->_current_lang."/".$reponse[0]['permalink']."/";
        $reponse[0]['customFields'] = json_decode($reponse[0]["customFields"], true);
        $reponse[0]['alt'] = json_decode($reponse[0]['alt'], true)[$this->_current_lang];
        //print_r($reponse[0]);
        //$this->get_image($reponse[0]['image']);
        if(count($reponse) == 0)
        {
            #ON DOIT RENVOYER VERS L'ERREUR 404;
        }
        else
        {
            return $reponse[0];
        }

	}
	
	public function get_theme_options($name)
	{
	    $fichier = file_get_contents("CMS/themes/".$this->_skin."/options/".$this->_current_lang.".json");
	    $fichier = json_decode($fichier, true);
	    
	    //print_r($fichier);
	    if($fichier[$name]['type'] == "image" || $fichier[$name]['type'] == "video")
	    {
	        $fichier[$name]['value'] = "CMS/".$fichier[$name]['value'];
	    }
	    return $fichier[$name]['value'];
	}
	

	
	public function get_image($src)
	{
	    $sql = "SELECT * FROM images WHERE parent = (SELECT parent FROM images WHERE file = '$src') OR ID = (SELECT parent FROM images WHERE file = '$src')";
	   
	    $reponse = $this->_db->query($sql);
	    
	    $data = $reponse->fetchAll(PDO::FETCH_ASSOC);
	    $return;
	    foreach($data as $key => $donnees)
	    {
	        $donnees['image'] = "CMS/".$donnees['file'];
	        $donnees['alt'] = json_decode($donnees['alt'], true)[$this->_current_lang];
	        $return[$donnees['type']] = $donnees;
	        //$data[$key][$donnees]['file'] = "CMS/".$data[$key][$donnees]['file'];
	    }
	    return $return;
	    //print_r($reponse->fetchAll());
	}
	

	
	public function get_meta()
	{
	    $file = file_get_contents("CMS/content/menu/meta.txt");
	    return $file;
	}
	
	public function get_analytics()
	{
	    return "<script id='geronimo_analytics' src='CMS/Analytics/analytics.js'></script>";
	}
	
	public function get_menu()
	{
	    $menu = file_get_contents("CMS/content/menu/".$this->_current_lang."/code.json");
	    $menu = json_decode($menu, true);
	    $return = array();
	    foreach($menu as $item)
	    {
	        if($item != "")
	        {
	            $return[] = $item;
	        }
	    }
	    return $return;
	}
	
	public function get_footer()
	{
	    $footer = file_get_contents("CMS/content/footer/".$this->_current_lang."/code.json");
	    $footer = json_decode($footer, true);
	    
	    return $footer;
	}
	

	public function get_title($id)
	{
	   if(!$id)
	   {
	       return $this->_the_page['name'];
	   }
	   else{
	        return $this->get_pages(array("ID" => $id))[0]['name'];
	   }

		
	}
	
	public function get_content($id)
	{

        if(!$id)
	    {
	        return $this->_the_page['text'];
	    }
	    else{
	        return $this->get_pages(array("ID" => $id))[0]['text'];
	    }
		
	}
	
	public function get_description($id)
	{
        if(!$id)
	    {
	        return $this->_the_page['description'];
	    }
	    else{
	        return $this->get_pages(array("ID" => $id))[0]['description'];
	    }
		
	}
	
	public function get_author($id)
	{
        if(!$id)
	    {
	        return $this->_the_page['author'];
	    }
	    else{
	        return $this->get_pages(array("ID" => $id))[0]['author'];
	    }
	}
	
	public function get_date_time($id)
	{
        if(!$id)
	    {
	        return $this->_the_page['date'];
	    }
	    else{
	        return $this->get_pages(array("ID" => $id))[0]['date'];
	    }
	}


}    