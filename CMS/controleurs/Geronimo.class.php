<?php

class Geronimo extends DB
{
	private $_db;
	private $_content;
	private $_ID;
	private $_lang;
	private $_main_lang;
	private $_child;
	private $_social;
	public $_skin;
	private $_path;
	private $_langue_secondaire;
	private $_langue;
	private $_container = "";
	private $_displayed = false;
	private $_rowed = false;
	private $_admin = false;
	private $_superMenu;
	public $_eshop;
	
	
	public function __construct($path)
	{
		$this->_path = $path;
		$this->_db = parent::__construct();
		$this->_admin = $this->verificationPageConnexion();
		$this->get_lang();
		
		setlocale(LC_TIME, 'fr_FR.utf8','fra'); 
	}

	public function verificationPageConnexion()
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
					$sql2 = "UPDATE login set connexion = '$time' WHERE login = '$login'";
					$reponse2 = $this->_db->exec($sql2);
					return true;
				}
			}

			if($trouve == false)
			{
				return false;
			}
		}
		else
		{
			return false;
		}		
	}
	public function get_onglet_menu_ecommerce()
	{
		$file = file_get_contents("CMS/content/menuEcommerce/".$this->_lang."/code.json");
		$onglets = json_decode($file, true);
		
		foreach($onglets as $onglet)
		{
			if(isset($onglet[0]['nom']))
			{
				if($onglet[0]['link'] == "choice_lang")
				{
					$return[] = array("link" => "#", "nom" => $this->_langue);
				}
				else
				{

					$return[] = $onglet[0];					
/*
					echo "<div class='nav col-xs-12' style=''><a class='nav-item' href='".$onglet[0]['link']."'>".$onglet[0]['nom']."</a><ul class='sub-menu'>";
					
					if($child == true)
					{
						foreach($onglet as $key => $submenu)
						{
							if($key != 0)
							{
								echo "<li><a class='nav-item' href='".$submenu['link']."'>".$submenu[nom]."</a></li>";
							}
						}
					}
					echo "</ul></div>";	
*/				
				}

			}
			
			
		}	
		
		return $return;	
	}
	public function get_onglet_menu()
	{
		$file = file_get_contents("CMS/content/menu/".$this->_lang."/code.json");
		$onglets = json_decode($file, true);
		
		foreach($onglets as $onglet)
		{
			if(isset($onglet[0]['nom']))
			{
				if($onglet[0]['link'] == "choice_lang")
				{
					echo $this->_langue;
				}
				else
				{
					echo "<div class='nav col-xs-12' style=''><a class='nav-item' href='".$onglet[0]['link']."'>".$onglet[0]['nom']."</a><ul class='sub-menu'>";
					foreach($onglet as $key => $submenu)
					{
						if($key != 0)
						{
							echo "<li><a class='nav-item' href='".$submenu['link']."'>".$submenu[nom]."</a></li>";
						}
					}
					echo "</ul></div>";					
				}

			}
			
			
		}
		
		
		
		
	}
	
	public function get_search_icon()
	{
		if(file_exists($this->_path."themes/".$this->_skin."/images/icon/search.png"))
		{
			$icone = $this->_path."themes/".$this->_skin."/images/icon/search.png";
		}
		else
		{
			$icone = $this->_path."/images/search.png";
		}
		
		//echo $this->_path."theme/".$this->_skin."/images/icon/search.png";
		return "<img src='".$icone."' style='max-height: 20px'/>";
	}
	
	public function get_menu()
	{
		$typeDeMenu = file_get_contents("CMS/content/menu/type.txt");
		
		if($typeDeMenu == "classique")
		{
			$cheminMenu = "menu";
			$cheminWireframe = "Menu";
		}
		if($typeDeMenu == "ecommerce")
		{
			$cheminMenu = "menuEcommerce";
			$cheminWireframe = "Menu_ecommerce";
		}
		echo $this->_superMenu;
		if($this->_langue_secondaire != null)
		{
			$this->_langue_secondaire[] = $this->_main_lang;
			$this->_langue .= "<select id='language_select'>";
			foreach($this->_langue_secondaire as $language)
			{
				if($language == $_GET['lang'])
				{
					$selected = "selected";
				}
				else
				{
					$selected = "";
				}
				$this->_langue .= "<option $selected >$language</option>";
			}
			$this->_langue .= "</select>";
		}
		if(file_exists("CMS/content/$cheminMenu/".$this->_lang."/topmenu.php"))
		{
			$topmenu = file_get_contents("CMS/content/$cheminMenu/".$this->_lang."/topmenu.php");
			echo "<div id='topmenu'><div class='container'>$topmenu</div></div>";
		}
		$wireframe = file_get_contents("CMS/content/$cheminMenu/disposition.txt", true);
		
		$wireframe = file_get_contents("CMS/wireframes/$cheminWireframe/$wireframe/code.template", true);
		$wireframe = eval(" ?>".$wireframe."<?php ");	
		echo $wireframe;
				
		//$this->get_logo();
		//$this->get_onglet_menu();
	}
	
	public function get_logo()
	{
		#if(file_exists("content/logo/logo.png"))
		#{
		#	$logo = $this->_path."content/logo/logo.png";
		#}
		#if(file_exists("content/logo/logo.jpg"))
		#{
		#	$logo = $this->_path."content/logo/logo.jpg";
		#}
		$logo = glob("CMS/content/logo/logo.*");
		#print_r($logo);
		return $logo[0]."?v=".time();
	}
	
	public function get_lang()
	{
		$sql = "SELECT * FROM systeme WHERE nom = 'langue_principale'";
		$reponse = $this->_db->query($sql);
		$reponse = $reponse->fetchAll()[0]['valeur'];
		$this->_main_lang = $reponse;
		
		if(isset($_GET['lang']) AND $_GET['lang'] != "")
		{
			$this->_lang = $_GET['lang'];
		}
		else
		{
			header("location: ./".$this->_main_lang);
			$this->_lang = $this->_main_lang;
		}
		
		#echo $this->_lang;
	}
	
	public function get_data()
	{
		$this->_eshop = new Eshop($this->_path);
		if(isset($_GET['eshopType']))
		{
			
			if($_GET['eshopType'] == "categorie")
			{
				$this->_content = $this->_eshop->get_data("categories", $_GET['ID'], $this->_lang);
			}
			if($_GET['eshopType'] == "product")
			{
				$this->_content = $this->_eshop->get_data("produit", $_GET['ID'], $this->_lang);
			}
			if($_GET['eshopType'] == "search")
			{
				$this->_content = $this->_eshop->get_data("search", 0, $this->_lang);
			}
		}
		else
		{
			if(isset($_GET['ID']))
			{
				
				
				$sql = "SELECT * FROM contenu WHERE ID = ".$_GET['ID'];
				$reponse = $this->_db->query($sql);
				
				if(@$reponse->rowCount() == 0)
				{
					echo "Erreur 404";
				}
				$reponse = $reponse->fetchAll()[0];
				
				if($reponse['copyOf'] != null)
				{
					$ID = $reponse['copyOf'];
				}
				else
				{
					$ID = $_GET['ID'];
				}
	
	
				if(isset($_GET['lang']) AND $_GET['lang'] != $this->_main_lang AND $_GET['lang'] != null)
				{
					$sql = "SELECT * FROM contenu INNER JOIN contenu_traduction ON contenu.ID = contenu_traduction.contenu WHERE contenu_traduction.langue = '".$this->_lang."' AND contenu.ID = ".$ID." AND contenu.online = 'on'";
				}
				else
				{
					$sql = "SELECT * FROM contenu WHERE ID = ".$ID." AND online = 'on'";
				}
				
				$reponse = $this->_db->query($sql);
			}
			else
			{
				
				if(isset($_GET['lang']) AND $_GET['lang'] != $this->_main_lang AND $_GET['lang'] != null)
				{
					
					$sql = "SELECT * FROM contenu INNER JOIN contenu_traduction ON contenu.ID = contenu_traduction.contenu WHERE contenu_traduction.langue = '".$this->_lang."' AND contenu.homepage = 'on' AND contenu.online = 'on'";
				}
				else
				{
					
					$sql = "SELECT * FROM contenu WHERE homepage = 'on' AND online = 'on'";
				}
				
				$reponse = $this->_db->query($sql);
			}
			$this->_content = $reponse->fetchAll()[0];
			if(isset($this->_content['contenu']))
			{
				$this->_content['ID'] = $this->_content['contenu'];
			}
			$this->_content['date'] = strftime("%d %B %Y", $this->_content['date']);
	

		}		
		if($this->_admin)
		{
			
			$this->_superMenu .= "<div style='position: fixed; display: none; left: 0; top: 0; width: 100vw; height: 100vh; background-color: rgba(0,0,0,0.6); z-index: 11100000;' class='blackScreen'><img src='CMS/images/throb.gif' style='display: block; position: fixed; left: 0; bottom: 0; top: 0; right: 0; margin: auto; width: 100px'></div><iframe id='formulaireEditAddItems' src='' style='z-index: 1000000000; height: 90vh; display: none; position: fixed; top: 100%; left: 0; width: 90vw; min-width: 1000px; right: 0; margin: auto' ></iframe>";
			$this->_superMenu .= "<div class='superMenu'><div class='geronimoLogo' style='margin-top: auto; margin-bottom: auto; height: 80%; padding-left: 20px'><img style='height: 100%;' src='CMS/images/logoGeronimo.png'></div><div style='display: inline-block; float: right; margin-top: auto; margin-bottom: auto; margin-left: auto; padding-right: 20px'>".$_SESSION['login']."<a class='deconnexion' style='display: inline-block; float: right; margin-left: 15px; margin-top: 5px; font-size: 10px' href='CMS/deconnexion.php?redirect=http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."'>Déconnexion &rsaquo;</a><button data-id='".$this->_content['ID']."' class='disposition'>Ordre des blocs</button><button class='editMode'>Editer les blocs</button><button data-id='".$this->_content['ID']."' class='editPage'>Editer la page</button></div></div>";
			
			#echo "<div class='listOrder'><h3>Ordre des blocs</h3></div>";
		}		
	}

	public function time_elapsed_string($datetime, $full = false) 
	{
		date_default_timezone_set('Europe/Brussels');
		//echo $datetime;
	    $now = new DateTime();
	    $ago = new DateTime($datetime);
	    $diff = $now->diff($ago);
	
	    $diff->w = floor($diff->d / 7);
	    $diff->d -= $diff->w * 7;
	
	    $string = array(
	        'y' => 'année',
	        'm' => 'mois',
	        'w' => 'semaines',
	        'd' => 'jour',
	        'h' => 'heure',
	        'i' => 'minute',
	        's' => 'seconde',
	    );
	    foreach ($string as $k => &$v) {
	        if ($diff->$k AND $v != 'm') {
	            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
	            
	        } else {
	            unset($string[$k]);
	        }
	    }
		
	    if (!$full) $string = array_slice($string, 0, 1);
	    $string = str_replace("moiss", "mois", $string);
	    return $string ? 'il y a '.implode(', ', $string) : 'à l\'instant';
	}

	
	public function get_header()
	{
		$meta = file_get_contents("CMS/content/menu/meta.txt");
		
		echo $meta;
		if($this->_content['SEO_description'] == "")
		{
			$description = $this->_content['description'];
		}
		else
		{
			$description = $this->_content['SEO_description'];
		}
		echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>';
		
		echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">';
		#echo '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>';
		#echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">';
		#echo "<link rel='stylesheet' type='text/css' href='CMS/CSS/bootstrap.min.css'/>";
		echo "<link rel='stylesheet' type='text/css' href='CMS/themes/lightbox.min.css'/>";
		echo "<link rel='stylesheet' type='text/css' href='CMS/themes/jquery.bxslider.min.css'/>";
		echo "<link rel='stylesheet' type='text/css' href='CMS/themes/reset.css'/>";
		echo "<link rel='stylesheet' type='text/css' href='CMS/CSS/font-awesome/css/font-awesome.min.css'/>";
		echo "<script src='CMS/themes/star.js'></script>";
		echo "<script src='CMS/themes/fittext.js'></script>";
		echo "<script src='CMS/themes/jquery.bxslider.min.js'></script>";
		echo "<script src='CMS/themes/lightbox.js'></script>";
		echo "<script src='CMS/themes/script.js'></script>";
		echo "<script src='CMS/JS/jquery-ui.min.js'></script>";
		echo "<script src='CMS/themes/admin.js'></script>";
		
		echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
		$favicon = glob("CMS/content/logo/favicon.*");
		$sql = "SELECT * FROM systeme";
		$reponse = $this->_db->query($sql);
		
		while($donnees = $reponse->fetch())
		{
			if($donnees['nom'] == "langue_secondaire")
			{
				$this->_langue_secondaire[] = $donnees['valeur'];
			}
			if($donnees['nom'] == "titre")
			{
				$titre = $donnees['valeur']." - ";
			}
			if($donnees['nom'] == "skin")
			{
				$this->_skin = $donnees['valeur'];
				echo "<script src='CMS/themes/".$donnees['valeur']."/script.js'></script>";
				
				echo "<link rel='stylesheet' type='text/css' href='CMS/themes/".$donnees['valeur']."/style.css'/>";
				$customLibraries = file_get_contents("CMS/themes/".$donnees['valeur']."/constructor.json");
				$customLibraries = json_decode($customLibraries, TRUE);
				//print_r($customLibraries);
				foreach($customLibraries["header"]["css"] as $css)
				{
					echo "<link rel='stylesheet' type='text/css' href='CMS/themes/".$donnees['valeur']."/".$css."'/>";
				}
				foreach($customLibraries["header"]["javascript"] as $js)
				{
					echo "<script src='CMS/themes/".$donnees['valeur']."/".$js."'></script>";
				}
			}
			if($donnees['nom'] == "social")
			{
				$this->_social = $donnees['valeur'];
			}
			if($donnees['nom'] == "maintenance" AND $donnees['valeur'] == "true" AND !isset($_COOKIE['weboncmslogin']))
			{
				exit("Site actuellement en maintenance");
			}
		}
		#echo "<style rel='stylesheet' href='CMS/CSS/fontawesome/web-fonts-with-css/css/fontawesome-all.min.css'/>";
		echo '<link rel="icon" type="image/png" href="'.$favicon[0].'" />';
		echo '<link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet">';
		echo "<title>".$titre.$this->_content['nom']."</title>";
		echo '<script src="https://unpkg.com/scrollreveal/dist/scrollreveal.min.js"></script>';
		$description = strip_tags(str_replace("<br/>", "", $description));
		echo "<meta name='description' content='$description' />";
		echo '<meta property="og:description" content="'.$description.'" />
		<meta property="og:title" content="'.$titre.$this->_content['nom'].'" />
		<meta property="og:url" content="http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'].'" />
		<meta property="og:image" content="'.$_SERVER['HTTP_HOST'].'/CMS/content/images/'.$this->_content['image'].'" />';
		echo '<div id="fb-root"></div><script>(function(d, s, id) { var js, fjs = d.getElementsByTagName(s)[0]; if (d.getElementById(id)) return; js = d.createElement(s); js.id = id; js.src = "//connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v2.8&appId=805932966216160"; fjs.parentNode.insertBefore(js, fjs); }(document, "script", "facebook-jssdk"));</script>';	
		echo "<script id='geronimo_analytics' src='CMS/Analytics/analytics.js'></script>";	
	}
	
	public function get_footer()
	{
		//echo $this->_path."content/footer/".$this->_lang."/footer.php";
		include("CMS/content/footer/".$this->_lang."/footer.php");
	}
	
	public function get_social()
	{
		$this->_social = json_decode($this->_social, true);
		
		foreach($this->_social as $key => $social)
		{
			if($social != null)
			{
				if(file_exists($this->_path."themes/".$this->_skin."/images/icon/".$key.".png"))
				{
					$icone = $this->_path."themes/".$this->_skin."/images/icon/".$key.".png";
				}
				else
				{
					$icone = $this->_path."images/social/$key.png";
				}
				echo "<div class='socialIcon' style='display: block; float: right; width: 30px; height: 30px'><a href='$social' target='_blank'><img src='$icone' style='max-width: 100%'/></a></div>";
			}
		}
	}
	
	public function cutString($string, $start, $length, $endStr = '[&hellip]')
	{
		if(strlen( $string ) <= $length ) return $string;

		$str = mb_substr( $string, $start, $length - strlen( $endStr ) + 1, 'UTF-8');
		return substr( $str, 0, strrpos( $str,' ') ).$endStr;
	}	
	
	public function get_include_contents($filename) 
	{
		if(is_file($filename)) 
		{
			ob_start();
			include $filename;
			$contents = ob_get_contents();
			ob_end_clean();
			return $contents;
	    }
	    return false;
	}	
	
	public function search($ID, $nombre = 20, $disposition = "02", $offset = 0)
	{
		echo "<div class='search-result'>";
		if(isset($_GET['page']) AND $_GET['page'] != null AND $_GET['page'] > 0)
		{
			$offset = $nombre * ($_GET['page']-1);
			$page = $_GET['page'];
		}
		else
		{
			$page = 1;
		}
		$paginationVal = $nombre + $offset;
		//echo $pagination;
		$filter = array();	
		if(isset($_GET['filter']) AND $_GET['filter'] != null)
		{
			$conditionFilterMultilingue = "AND contenu.keywords LIKE '%".$_GET['filter']."%' ";
			$conditionFilter = "AND keywords LIKE '%".$_GET['filter']."%' ";	
		}
		else
		{
			$conditionFilter = "";
			$conditionFilterMultilingue = "";
		}
		if($nombre)
		{
			
			if(isset($_GET['lang']) AND $_GET['lang'] != $this->_main_lang AND $_GET['lang'] != null)
			{
				$sql = "SELECT * FROM contenu INNER JOIN contenu_traduction ON contenu.ID = contenu_traduction.contenu OR contenu.copyOf = contenu_traduction.contenu WHERE contenu_traduction.langue = '".$this->_lang."' AND contenu.nom LIKE '%".$ID."%' AND contenu.online = 'on' ".$conditionFilterMultilingue." ORDER BY contenu.orderID DESC LIMIT $nombre OFFSET $offset";
				
				$sqlPaginationTop = "SELECT * FROM contenu INNER JOIN contenu_traduction ON contenu.ID = contenu_traduction.contenu WHERE contenu_traduction.langue = '".$this->_lang."' AND contenu.parent = ".$ID." AND contenu.online = 'on' ".$conditionFilterMultilingue." ORDER BY contenu.orderID DESC LIMIT $nombre OFFSET $paginationVal";
				
			}
			else
			{
				
				$sql = "SELECT * FROM contenu WHERE nom LIKE '%$ID%' AND online = 'on' $conditionFilter ORDER BY orderID DESC LIMIT $nombre OFFSET $offset";
				
				$sqlPaginationTop = "SELECT * FROM contenu WHERE nom LIKE '%$ID%' AND online = 'on' $conditionFilter ORDER BY orderID DESC LIMIT $nombre OFFSET $paginationVal";				
				
				
			}

			$reponsePaginationTop = $this->_db->query($sqlPaginationTop);
			#echo $reponsePaginationTop->rowCount();
			if($reponsePaginationTop->rowCount() != 0)
			{
				#echo $reponsePaginationTop->rowCount();
				$pagination = true;
			}
			if($nombre < 20)
			{
				$pagination = false;
			}			
			
		}
		
		
		
		$reponse = $this->_db->query($sql);
		$displayed = false;
		$paire = 0;	
		foreach($reponse as $this->_child)
		{
			
			$this->_child['formated_date'] = $this->time_elapsed_string(date("d-m-Y", intval($this->_child['date'])), false);
			#echo $this->_child['formated_date'];
			$this->_child['date'] = strftime("%d %B %Y", intval($this->_child['date']));
			
			
			
			if($this->_child['copyOf'] != null)
			{
				
				if(isset($_GET['lang']) AND $_GET['lang'] != $this->_main_lang)
				{
					
					$sql2 = "SELECT * FROM contenu INNER JOIN contenu_traduction ON contenu.ID = contenu_traduction.contenu WHERE contenu_traduction.langue = '".$this->_lang."' AND contenu.ID = ".$this->_child['copyOf']." ORDER BY contenu.orderID DESC";
					
				}
				else
				{
					$sql2 = "SELECT * FROM contenu WHERE ID = ".$this->_child['copyOf']." AND online = 'on' ORDER BY orderID DESC";
				}	
				
				$reponse2 = $this->_db->query($sql2);
				$this->_child = $reponse2->fetchAll()[0];			
			}
			$this->_child['18'] = str_replace("''", "'", $this->_child['18']);
			$this->_child['champsPerso'] = json_decode($this->_child['18'], true);
			
			$this->_child['style'] = "";
		
			if(!isset($this->_child['lien']) OR $this->_child['lien'] == null)
			{

			}
			else
			{
				$this->_child['link'] = $this->_lang."/".$this->_child['ID']."/".$this->clean_url($this->_child['nom']).".html";
				$this->_child['lien'] = "<div class='col-sm-12 callToActionContainer'><a style='".$this->_child['style']['background_link'].$this->_child['style']['color_link']."' class='callToAction' href='".$this->_child['link']."'>".$this->_child['lien']."</a></div>";
			}
			
			if(isset($_GET['lang']) AND $_GET['lang'] != $this->_main_lang)
			{
				$this->_child['ID'] = $this->_child['contenu'];
			}
			if($this->_child['image'] != null)
			{
				$this->_child['image'] = "CMS/content/images/".$this->_child['image'];
			}
			else
			{
				$this->_child['image'] = "";
			}
			//if(isset($_))
			//echo $this->_child['ID']."<br/>";
			if(!@$disposition)
			{
				$miniatures = $this->_child['miniatures'];
				//echo $this->_child['miniatures'];
			}
			else
			{
				$miniatures = $disposition;
			}
			
			$wireframe = file_get_contents("CMS/wireframes/Miniatures/blog_02/code.template");
			#echo "<textarea>".$wireframe."</textarea>";
			if(strstr($wireframe, "container = 'container'") !== false OR strstr($wireframe, "container = 'container-fluid'") !== false)
			{
				if($displayed == false)
				{
					$paire++;
					if(strstr($wireframe, "container = 'container'") !== false)
					{
						
						echo "<div class='container'>";
					}
					else
					{
						echo "<div class='container-fluid'>";
					}
					$displayed = true;
					$wireframe = eval(" ?>".$wireframe."<?php ");
				}
				else
				{
					$wireframe = eval(" ?>".$wireframe."<?php ");
				}
				
			}
			else
			{
				//echo "ok";
				if($displayed == true)
				{
					echo "</div>";
					$displayed = false;
				}
				$paire++;
// 				echo $wireframe;
				$wireframe = eval(" ?>".$wireframe."<?php ");
				
			}
		}
		
		/////////PAGINATION/////////

			echo "<div class='col-sm-12 paginationContainer'>";
			if(isset($_GET['filter']))
			{
				$lien = "$url?filter=".$_GET['filter']."&";
			}
			else
			{
				$lien = "$url?";
			}
			
			if(isset($_GET['page']) AND $_GET['page'] > 1)
			{
				if($_GET['page'] - 1 == 1)
				{
					echo "<a class='pagination previous' href='".$lien."'>Précédent</a>";
				}
				else
				{
					echo "<a class='pagination previous' href='".$lien."page=".($_GET['page']-1)."'>Précédent</a>";
				}
			}
			
			if(@$pagination == true OR isset($_GET['page']))
			{
				echo "<span class='pagination'>".$page."</span>";
			}
		
			if(@$pagination == true)
			{
				echo "<a class='pagination next' href='".$lien."page=".($page+1)."'>Suivant</a>";
			}
			echo "</div>";
		
		
		
		///////////////////////////
		
		
		if($displayed == true)
		{
			echo "</div>";
			$displayed = false;
		}
		echo "</div>";
	}
	
	public function get_page()
	{	
		if(isset($_GET['eshopType']))
		{
			if($_GET['eshopType'] == "categorie")
			{
				
				$this->_eshop->get_page("categorie", $_GET['ID'],$this->_lang);	
			}
			if($_GET['eshopType'] == "product")
			{
				
				$this->_eshop->get_page("produit", $_GET['ID'],$this->_lang);	
			}
			if($_GET['eshopType'] == "search")
			{
				
				$this->_eshop->get_page("search", 0, $this->_lang);	
			}
		}
		else
		{
			$nom = $this->_content['nom'];
			$image = $this->_path."CMS/content/images/".$this->_content['image'];
			if($this->_content['image'] != null)
			{
				$this->_content['image'] = "CMS/content/images/".$this->_content['image'];
			}
			else
			{
				$this->_content['image'] = "data:image/gif;base64,R0lGODlhAQABAAAAACwAAAAAAQABAAA=";
			}
			
			$description = $this->_content['description'];
			$texte = $this->_content['texte'];
			$widgets = json_decode($this->_content['medias'], true);
	
			if($widgets != null)
			{
				
				foreach($widgets as $widget)
				{
		// 			echo $widget;
					if(is_numeric($widget))
					{
						
						$sql = "SELECT * FROM medias WHERE ID = $widget";
						$reponse = $this->_db->query($sql);
						
						while($donnees = $reponse->fetch())
						{
							if($donnees['type'] == "photo")
							{
								$type = $donnees['display'];
								$sql2 = "SELECT * FROM photos WHERE album = ".$donnees['ID'];
								$reponse2 = $this->_db->query($sql2);
								if($type == "slider")
								{
									$this->_content['widgets'] .= "<ul class='bxslider'>";
								}
								while($donnees2 = $reponse2->fetch())
								{
									
									if($type == "mosaique")
									{
										$this->_content['widgets'] .= "<a class='fancybox' rel='group' title=\"".$donnees2['description']."\" href='CMS/content/album/".$donnees2['fichier']."' style='background-image: url(CMS/content/thumbnail/".$donnees2['fichier'].")' data-lightbox=\"roadtrip\"></a>";
									}
									if($type == "slider")
									{
										$this->_content['widgets'] .= "<li><img src='CMS/content/album/".$donnees2['fichier']."' title=\"".$donnees2['description']."\"/></li>";
									}
								}
								if($type == "slider")
								{
									echo "</ul>";
								}
								
							}
							else
							{
								if($donnees['type'] == "video")
								{
									$this->_content['widgets'] .= $donnees['url'];
								}
								else
								{
									$this->_content['widgets'] .= $donnees['fichier'];
								}
								
							}
						}
					}
					else
					{
						
						$widget = explode("-_-", $widget);
						#print_r($widget);
						$widget = $this->get_include_contents("CMS/plugins/".$widget[0]."/widgets/".$widget[1]);
						#echo $widget;
						$this->_content['widgets'] .= $widget;
					}
				}
			}
			$etiquette = json_decode($this->_content['keywords']);
			
			
			$wireframe = $this->_content['display'];
			$wireframe = file_get_contents("CMS/wireframes/Pages/$wireframe/code.template");
			$wireframe = eval(" ?>".$wireframe."<?php ");
			if($this->_content['commentaire'] == "on")
			{
				echo '<div class="container" style="text-align: center"><div class="fb-comments" data-width="600px" data-href="http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'].'" data-numposts="5"></div></div>';
			}	
		
		}
		//echo $wireframe;	
		
		
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
	
	public function get_filters($ID, $display = "block")
	{
		$filter = array();	
		if(isset($_GET['filter']) AND $_GET['filter'] != null)
		{
			$conditionFilterMultilingue = "AND contenu.keywords LIKE '%".$_GET['filter']."%' ";
			$conditionFilter = "AND keywords LIKE '%".$_GET['filter']."%' ";	
		}
		else
		{
			$conditionFilter = "";
			$conditionFilterMultilingue = "";
		}
		$sql = "SELECT * FROM contenu WHERE ID = $ID";
		$reponse = $this->_db->query($sql);
		$reponse = $reponse->fetchAll()[0];
		if($reponse['copyOf'] != null)
		{
			$ID = $reponse['copyOf'];
		}
		else
		{
			$ID = $ID;
		}
		if(isset($_GET['lang']) AND $_GET['lang'] != $this->_main_lang AND $_GET['lang'] != null)
		{
			$sql = "SELECT * FROM contenu INNER JOIN contenu_traduction ON contenu.ID = contenu_traduction.contenu WHERE contenu_traduction.langue = '".$this->_lang."' AND contenu.parent = ".$ID." AND contenu.online = 'on' ORDER BY contenu.orderID DESC";
			//echo $sql;
		}
		else
		{
			
			$sql = "SELECT * FROM contenu WHERE parent = $ID AND online = 'on' ORDER BY orderID DESC";
		}
		
	
		$reponse = $this->_db->query($sql);
		$displayed = false;
		$paire = 0;
	
	////////FILTRE//////////	
		
		$reponse = $reponse->fetchAll();
		
		foreach($reponse as $filters)
		{
			$filters = explode(", ", $filters['keywords']);
			foreach($filters as $etiquette)
			{
				$filter[] = $etiquette;
			}
			

		}
		
		$filter = array_unique($filter);
		$url = strtok($_SERVER["REQUEST_URI"],'?');
		
		#$filtre = "<div class='filters'>";
		$filterReturn = array();
		if($display == "block")
		{
			$filtre[] = "<a style='display: $display' href='".$url."' class='filter'>Tout</a>";
		}
		foreach($filter as $etiquette)
		{
			if($etiquette == $_GET['filter'])
			{
				$filtre[] = "<a style='display: $display' href='".$url."?filter=$etiquette' class='filter active'>".$etiquette."</a>";
			}
			else
			{
				$filtre[] = "<a style='display: $display' href='".$url."?filter=$etiquette' class='filter'>".$etiquette."</a>";
			}
			$filterReturn[] = $etiquette;
		}
		#$filtre .= "</div>";
		
	////////////////////////
	
		foreach($reponse as $this->_child)
		{
			$this->_child['filter'] = $filtre;
		}
		
		#$this->_child['filter'] = array_reverse($this->_child['filter']);
		#$filterReturn = array_reverse($filterReturn);
		return $filterReturn;
	}
	
	public function get_child($ID, $nombre = 50, $disposition, $offset = 0, $childred = "false")
	{	
		$boostrap = 0;
		if(isset($_GET['page']) AND $_GET['page'] != null AND $_GET['page'] > 0)
		{
			$offset = $nombre * ($_GET['page']-1);
			$page = $_GET['page'];
		}
		else
		{
			$page = 1;
		}
		$paginationVal = $nombre + $offset;
		//echo $pagination;
		$filter = array();	
		if(isset($_GET['filter']) AND $_GET['filter'] != null)
		{
			$conditionFilterMultilingue = "AND contenu.keywords LIKE '%".$_GET['filter']."%' ";
			$conditionFilter = "AND keywords LIKE '%".$_GET['filter']."%' ";	
		}
		else
		{
			$conditionFilter = "";
			$conditionFilterMultilingue = "";
		}
		if($nombre)
		{
			
			if(isset($_GET['lang']) AND $_GET['lang'] != $this->_main_lang AND $_GET['lang'] != null)
			{
				$sql = "SELECT * FROM contenu INNER JOIN contenu_traduction ON contenu.ID = contenu_traduction.contenu OR contenu.copyOf = contenu_traduction.contenu WHERE contenu_traduction.langue = '".$this->_lang."' AND contenu.parent = ".$ID." AND contenu.online = 'on' ".$conditionFilterMultilingue." ORDER BY contenu.orderID DESC LIMIT $nombre OFFSET $offset";
				
				$sqlPaginationTop = "SELECT * FROM contenu INNER JOIN contenu_traduction ON contenu.ID = contenu_traduction.contenu WHERE contenu_traduction.langue = '".$this->_lang."' AND contenu.parent = ".$ID." AND contenu.online = 'on' ".$conditionFilterMultilingue." ORDER BY contenu.orderID DESC LIMIT $nombre OFFSET $paginationVal";
				
				$sqlNombreItem = "SELECT * FROM contenu INNER JOIN contenu_traduction ON contenu.ID = contenu_traduction.contenu WHERE contenu_traduction.langue = '".$this->_lang."' AND contenu.parent = ".$ID." AND contenu.online = 'on' ".$conditionFilterMultilingue." ORDER BY contenu.orderID DESC";
				
			}
			else
			{
				
				$sql = "SELECT * FROM contenu WHERE parent = $ID AND online = 'on' $conditionFilter ORDER BY orderID DESC LIMIT $nombre OFFSET $offset";

				$sqlPaginationTop = "SELECT * FROM contenu WHERE parent = $ID AND online = 'on' $conditionFilter ORDER BY orderID DESC LIMIT $nombre OFFSET $paginationVal";				
				
				$sqlNombreItem = "SELECT * FROM contenu WHERE parent = $ID AND online = 'on' $conditionFilter ORDER BY orderID DESC";
			}

			$reponsePaginationTop = $this->_db->query($sqlPaginationTop);
			#echo $reponsePaginationTop->rowCount();
			if($reponsePaginationTop->rowCount() != 0)
			{
				#echo $reponsePaginationTop->rowCount();
				$pagination = true;
			}
			if($nombre < 50)
			{
				$pagination = false;
			}			
			//echo $reponsePaginationTop->rowCount();
		}
		else
		{
			
			$sql = "SELECT * FROM contenu WHERE ID = $ID";
			$reponse = $this->_db->query($sql);
			$reponse = $reponse->fetchAll()[0];
			if($reponse['copyOf'] != null)
			{
				$ID = $reponse['copyOf'];
			}
			else
			{
				$ID = $ID;
			}
			if(isset($_GET['lang']) AND $_GET['lang'] != $this->_main_lang AND $_GET['lang'] != null)
			{
				$sql = "SELECT * FROM contenu INNER JOIN contenu_traduction ON contenu.ID = contenu_traduction.contenu WHERE contenu_traduction.langue = '".$this->_lang."' AND contenu.parent = ".$ID." AND contenu.online = 'on' ".$conditionFilterMultilingue." ORDER BY contenu.orderID DESC";
				//echo $sql;
			}
			else
			{
				
				$sql = "SELECT * FROM contenu WHERE parent = $ID AND online = 'on' $conditionFilter ORDER BY orderID DESC";
			}
			
		}
		
		
		
		$reponse = $this->_db->query($sql);
		$displayed = false;
		$paire = 0;
	
	////////FILTRE//////////	
		$nombreElement = $this->_db->query($sqlNombreItem);
		$nombreElement = $nombreElement->rowCount();
		$nombreElement = ceil($nombreElement/$nombre);
		$limitePage = 5;
		if($nombreElement > $limitePage)
		{
			//$nombreElement = $limitePage;
		}
		#echo $sql;
		$reponse = $reponse->fetchAll();
		
		foreach($reponse as $filters)
		{
			$filters = explode(", ", $filters['keywords']);
			foreach($filters as $etiquette)
			{
				$filter[] = $etiquette;
			}
			

		}
		
		$filter = array_unique($filter);
		$url = strtok($_SERVER["REQUEST_URI"],'?');
		$filtre = "<div class='filters'>";
		foreach($filter as $etiquette)
		{
			$filtre .= "<a href='".$url."?filter=$etiquette' class='filter'>".$etiquette."</a><br/>";
		}
		$filtre .= "</div>";
		
	////////////////////////	
		foreach($reponse as $this->_child)
		{
			
			$this->_child['filter'] = $filtre;
			$this->_child['formated_date'] = $this->time_elapsed_string(date("d-m-Y", intval($this->_child['date'])), false);
			#echo $this->_child['formated_date'];
			$this->_child['date'] = strftime("%d %B %Y", intval($this->_child['date']));
			
			
			
			if($this->_child['copyOf'] != null)
			{
				
				if(isset($_GET['lang']) AND $_GET['lang'] != $this->_main_lang)
				{
					
					$sql2 = "SELECT * FROM contenu INNER JOIN contenu_traduction ON contenu.ID = contenu_traduction.contenu WHERE contenu_traduction.langue = '".$this->_lang."' AND contenu.ID = ".$this->_child['copyOf']." ORDER BY contenu.orderID DESC";
					
				}
				else
				{
					$sql2 = "SELECT * FROM contenu WHERE ID = ".$this->_child['copyOf']." AND online = 'on' ORDER BY orderID DESC";
				}	
				
				$reponse2 = $this->_db->query($sql2);
				$this->_child = $reponse2->fetchAll()[0];			
			}
			$this->_child['18'] = str_replace("''", "'", $this->_child['18']);
			$this->_child['champsPerso'] = json_decode($this->_child['18'], true);
			
			$this->_child['style'] = json_decode($this->_child['style'], true);
			
			if(isset($this->_child['style']) AND $this->_child['style'] != null)
			{
				foreach($this->_child['style'] as $key => $style)
				{
					if($style != null)
					{
						if(strstr($key, "background") !== false)
						{
							$this->_child['style'][$key] = "background: ".$style.";";
						}
						else
						{
							if($key != "url")
							{
								$this->_child['style'][$key] = "color: ".$style.";";
							}
						}
					}
				}
			}		
			if(!isset($this->_child["style"]['url']) OR $this->_child["style"]['url'] == null)
			{
				$this->_child['link'] = $this->_lang."/".$this->_child['ID']."/".$this->clean_url($this->_child['nom']).".html";
				$this->_child['lien'] = "<div class='col-sm-12 callToActionContainer'><a style='".$this->_child['style']['background_link'].$this->_child['style']['color_link']."' class='callToAction' href='".$this->_child['link']."'>".$this->_child['lien']."</a></div>";			
			}
			else
			{
				$this->_child['link'] = $this->_child["style"]['url'];
				$this->_child['lien'] = "<div class='col-sm-12 callToActionContainer'><a style='".$this->_child['style']['background_link'].$this->_child['style']['color_link']."' class='callToAction' href='".$this->_child['link']."'>".$this->_child['lien']."</a></div>";					

			}
			
			if(isset($_GET['lang']) AND $_GET['lang'] != $this->_main_lang)
			{
				$this->_child['ID'] = $this->_child['contenu'];
			}
			if($this->_child['image'] != null)
			{
				$this->_child['image'] = "CMS/content/images/".$this->_child['image'];
			}
			else
			{
				$this->_child['image'] = "";
			}
			//if(isset($_))
			//echo $this->_child['ID']."<br/>";
			if(!@$disposition)
			{
				$miniatures = $this->_child['miniatures'];
				//echo $this->_child['miniatures'];
			}
			else
			{
				$miniatures = $disposition;
			}
			
			$wireframe = file_get_contents("CMS/wireframes/Miniatures/$miniatures/code.template");
			
			//echo $size;

				#echo "ok22";
				if((strstr($wireframe, "container = 'container'") !== false OR strstr($wireframe, "container = 'container-fluid'") !== false) AND $childred == "false")
				{
					#echo "ok";
					#echo $this->_container;
					$numberOfSquare = preg_match('#col-sm-(.*)( |\')#', $wireframe, $result);
					#print_r($result);
					$resultat = $result[1];
					
					#echo $resultat;
					//echo $size;
					$boostrap += $resultat;
	
	
					if($size == 0)
					{
						$this->_rowed = true;
						#echo "ooooooooo";
						$row = "<div class='row'>";
					}
					else
					{
						$row = "";
					}
	
					if($boostrap >= 12)
					{
						$this->_rowed = false;
						$closeRow = "</div>";
						//echo "ok";
						$boostrap = 0;
						$size = 0;
					}
					else
					{
						#$this->_rowed = true;
						$closeRow = "";
					}
					#echo $boostrap;	
	
					
					$size = $boostrap;			
	/*
					if($this->_displayed == false)
					{
	*/
						
						$paire++;
						if(strstr($wireframe, "container = 'container'") !== false)
						{
							
							#echo "okkk";
							if($this->_container == "container-fluid")
							{
								echo "</div>";
								$this->_displayed = false;
							}
							
							$this->_container = "container";
							
							if($this->_displayed == false)
							{
								
								echo "<div style='padding-top: 15px' class='container'>";
							}
							
							$this->_displayed = true;
						}
						else
						{
							#echo "okdqsdqsdqsd";
							if($this->_container == "container")
							{
								
								echo "</div>";
								$this->_displayed = false;
								
								
							}
							
							$this->_container = "container-fluid";
							
							if($this->_displayed == false)
							{
								echo "<div style='padding-top: 15px' class='container-fluid'>";
							}
							$this->_displayed = true;
						}
						
						
						
						echo $row;
						$wireframe = eval(" ?>".$wireframe."<?php ");
						echo $closeRow;
						
	/*
					}
					else
					{
						#echo $resultat;
						echo $row;
						$wireframe = eval(" ?>".$wireframe."<?php ");
						echo $closeRow;
						
					}
	*/
					
				}
				else
				{
					if($childred == "false")
					{
						//echo "ok";
						$boostrap = 0;
						if($this->_rowed == true)
						{
							echo "</div>";
							
						}
						if($this->_displayed == true)
						{
							echo "</div>";
							$this->_displayed = false;
						}
						$paire++;
					}
	// 				echo $wireframe;
					$wireframe = eval(" ?>".$wireframe."<?php ");
					
				}
			
		}

		if($childred == "false")
		{
			if($this->_rowed == true)
			{
				echo "</div>";
			}
			if($this->_displayed == true)
			{
				echo "</div>";
				$displayed = false;
				$this->_displayed = false;
				
			}
		}
				
		
		/////////PAGINATION/////////

/*
			if($pagination == true)
			{
*/
				echo "<div class='row paginationContainer'>";
				if(isset($_GET['filter']))
				{
					$lien = "$url?filter=".$_GET['filter']."&";
				}
				else
				{
					$lien = "$url?";
				}
				

					if(isset($_GET['page']) AND $_GET['page'] > 1)
					{
						
							if($_GET['page'] - 1 == 1)
							{
								echo "<a class='pagination previous' href='".$lien."'>«</a>";
							}
							else
							{
								echo "<a class='pagination previous' href='".$lien."page=".($_GET['page']-1)."'>«</a>";
							}
						
					}
				
				
				if(@$pagination == true OR isset($_GET['page']))
				{
						$i = $page;
						while($i <= $nombreElement)
						{
							if($page == $i)
							{
								$start = floor($limitePage/2); // = 2
// 								$start = $page
								//echo $start;
								for($e = $start; $e >= 1; $e--)
								{
									if($page-$e > 0)
									{
										echo "<a href='".$lien."page=".($page-$e)."' class='pagination'>".($page-$e)."</a>";
									}
								}
								echo "<span class='pagination active'>".$page."</span>";
								
								for($e = 1; $e <= $start; $e++)
								{
									if($page+$e <= $nombreElement)
									{
										echo "<a href='".$lien."page=".($page+$e)."' class='pagination'>".($page+$e)."</a>";
									}
								}
							}
							else
							{
								#echo $offsetPage;
								
								
							}
							$i++;
						}
				}
			
				if(@$pagination == true)
				{
					echo "<a class='pagination next' href='".$lien."page=".($page+1)."'>»</a>";
				}
				echo "</div>";
// 			}
		
		
		
		///////////////////////////
		
		
		if($displayed == true)
		{
			echo "</div>";
			$displayed = false;
		}
		
		if($this->_admin)
		{
			echo "<div class='addChildHere' data-id='".$ID."' style='display: flex; height: 200px; border: 2px solid #dadada; width: 90%; margin-left: 5%;'><span style='display: inline-block; margin: auto;' class=''>Ajouter un bloc ici</span></div>";
		}
		
		
	}
	
}
	
?>

