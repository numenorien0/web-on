<?php

class Preview extends DB
{
	
	private $_db;
	
	public function __construct()
	{
		$this->_db = parent::__construct();
		
		if(isset($_POST['nom']))
		{
			$_SESSION['nom'] = $_POST['nom'];
			$_SESSION['description'] = $_POST['description'];
			$_SESSION['texte'] = $_POST['texte'];
			$_SESSION['image'] = $_POST['image'];
			$_SESSION['display'] = $_POST['page'];
			$_SESSION['ID'] = $_POST['ID'];
		}
		else
		{
			$this->preview();
		}
	}
	
	public function get_data()
	{
		
		$this->_content['nom'] = $_SESSION['nom'];
		$this->_content['image'] = $_SESSION['image'];
		$this->_content['description'] = $_SESSION['description'];
		$this->_content['texte'] = $_SESSION['texte'];
		$this->_content['display'] = $_SESSION['display'];
		$this->_content['ID'] = $_SESSION['ID'];
		
		
		
		
		
		
	}
	
	
	public function get_lang()
	{
		$sql = "SELECT * FROM systeme WHERE nom = 'langue_principale'";
		$reponse = $this->_db->query($sql);
		$reponse = $reponse->fetchAll()[0]['valeur'];
		$this->_main_lang = $reponse;
		$this->_lang = $this->_main_lang;


		
		#echo $this->_lang;
	}


	public function get_onglet_menu()
	{
		$file = file_get_contents("content/menu/".$this->_lang."/code.json");
		$onglets = json_decode($file, true);
		
		foreach($onglets as $onglet)
		{
			if(isset($onglet[0]['nom']))
			{
				echo "<div class='nav col-xs-12' style=''><a class='nav-item' href='".$onglet[0]['link']."''>".$onglet[0]['nom']."</a><ul class='sub-menu'>";
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

	public function get_search_icon()
	{
		if(file_exists($this->_skin."/images/icon/search.png"))
		{
			$icone = $this->_skin."/images/icon/search.png";
		}
		else
		{
			$icone = "images/search.png";
		}
		
		//echo $this->_path."theme/".$this->_skin."/images/icon/search.png";
		return "<img src='".$icone."' style='max-height: 20px'/>";
	}



	public function get_page()
	{	
		$nom = $this->_content['nom'];
		#echo $this->_content['image'];
		if($this->_content['image'] != null)
		{
			$this->_content['image'] = $this->_content['image'];
		}
		else
		{
			$this->_content['image'] = "data:image/gif;base64,R0lGODlhAQABAAAAACwAAAAAAQABAAA=";
		}
		
		$description = $this->_content['description'];
		$texte = $this->_content['texte'];
		$widgets = json_decode($this->_content['medias'], true);
		
		if(@$widget != null)
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
							$sql2 = "SELECT * FROM photos WHERE album = ".$donnees['ID'];
							$reponse2 = $this->_db->query($sql2);
							
							while($donnees2 = $reponse2->fetch())
							{
								$this->_content['widgets'] .= "<a class='fancybox' rel='group' title=\"".$donnees2['description']."\" href='content/album/".$donnees2['fichier']."' style='background-image: url(content/thumbnail/".$donnees2['fichier'].")' data-lightbox=\"roadtrip\"></a>";
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
					$widget = $this->get_include_contents("plugins/".$widget[0]."/widgets/".$widget[1]);
					#echo $widget;
					$this->_content['widgets'] .= $widget;
				}
			}
		}
		
		$etiquette = json_decode($this->_content['keywords']);
		
		
		$wireframe = $this->_content['display'];
		$wireframe = file_get_contents("wireframes/Pages/$wireframe/code.template");
		$wireframe = eval(" ?>".$wireframe."<?php ");
		if($this->_content['commentaire'] == "on")
		{
			echo '<div class="container" style="text-align: center"><div class="fb-comments" data-width="600px" data-href="http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'].'" data-numposts="5"></div></div>';
		}	
		//echo $wireframe;	
		
		
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
		$logo = glob("content/logo/logo.*");
		#print_r($logo);
		return $logo[0];
	}	
	
	public function get_child($ID, $nombre = 20, $disposition, $offset = 0)
	{	
		if(isset($this->_content['ID']) AND $this->_content['ID'] != null)
		{
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
					
				}
				else
				{
					
					$sql = "SELECT * FROM contenu WHERE parent = $ID AND online = 'on' $conditionFilter ORDER BY orderID DESC LIMIT $nombre OFFSET $offset";
	
					$sqlPaginationTop = "SELECT * FROM contenu WHERE parent = $ID AND online = 'on' $conditionFilter ORDER BY orderID DESC LIMIT $nombre OFFSET $paginationVal";				
					
					
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
								$this->_child['style'][$key] = "color: ".$style.";";
							}
						}
					}
				}		
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
				$this->_child['image'] = "content/images/".$this->_child['image'];
				
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
				
				$wireframe = file_get_contents("wireframes/Miniatures/$miniatures/code.template");
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
		}
		
		
	}


	public function time_elapsed_string($datetime, $full = false) 
	{
		//echo $datetime;
	    $now = new DateTime();
	    $ago = new DateTime($datetime);
	    $diff = $now->diff($ago);
	
	    $diff->w = floor($diff->d / 7);
	    $diff->d -= $diff->w * 7;
	
	    $string = array(
	        'y' => 'année',
	        'm' => 'mois',
	        'w' => 'semaine',
	        'd' => 'jour',
	        'h' => 'heure',
	        'i' => 'minute',
	        's' => 'seconde',
	    );
	    foreach ($string as $k => &$v) {
	        if ($diff->$k) {
	            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
	        } else {
	            unset($string[$k]);
	        }
	    }
	
	    if (!$full) $string = array_slice($string, 0, 1);
	    return $string ? 'il y a '.implode(', ', $string) : 'à l\'instant';
	}

	
	public function preview()
	{
		$this->get_lang();
		$this->get_data();
		$this->get_header();
		$wireframe = file_get_contents("content/menu/disposition.txt", true);
		
		$wireframe = file_get_contents("wireframes/Menu/$wireframe/code.template", true);
		$wireframe = eval(" ?>".$wireframe."<?php ");	
		echo $wireframe;
		
		$this->get_page();
		include("content/footer/".$this->_lang."/footer.php");
		
		
				
		
		
		
		
	}
	
	public function get_header()
	{
		$meta = file_get_contents("content/menu/meta.txt");
		
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
		

		echo "<link rel='stylesheet' type='text/css' href='themes/bootstrap.min.css'/>";
		echo "<link rel='stylesheet' type='text/css' href='themes/lightbox.min.css'/>";
		echo "<link rel='stylesheet' type='text/css' href='themes/reset.css'/>";
		echo "<script src='themes/lightbox.js'></script>";
		echo "<script src='themes/script.js'></script>";
		echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
		$favicon = glob("content/logo/favicon.*");
		$sql = "SELECT * FROM systeme";
		$reponse = $this->_db->query($sql);
		
		while($donnees = $reponse->fetch())
		{
			
			if($donnees['nom'] == "titre")
			{
				$titre = $donnees['valeur']." - ";
			}
			if($donnees['nom'] == "skin")
			{
				$this->_skin = $donnees['valeur'];
				echo "<script src='themes/".$donnees['valeur']."/script.js'></script>";
				echo "<link rel='stylesheet' type='text/css' href='themes/".$donnees['valeur']."/style.css'/>";
				$customLibraries = file_get_contents("themes/".$donnees['valeur']."/constructor.json");
				$customLibraries = json_decode($customLibraries, TRUE);
				//print_r($customLibraries);
				foreach($customLibraries["header"]["css"] as $css)
				{
					echo "<link rel='stylesheet' type='text/css' href='themes/".$donnees['valeur']."/".$css."'/>";
				}
				foreach($customLibraries["header"]["javascript"] as $js)
				{
					echo "<script src='themes/".$donnees['valeur']."/".$js."'></script>";
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

		echo '<link rel="icon" type="image/png" href="'.$favicon[0].'" />';
		echo "<title>".$titre.$this->_content['nom']."</title>";
		echo "<meta name='description' content='$description' />";
		echo '<meta property="og:description" content="'.$description.'" />
		<meta property="og:title" content="'.$titre.$this->_content['nom'].'" />
		<meta property="og:url" content="http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'].'" />
		<meta property="og:image" content="'.$_SERVER['HTTP_HOST'].'/CMS/content/images/'.$this->_content['image'].'" />';
		echo '<div id="fb-root"></div><script>(function(d, s, id) { var js, fjs = d.getElementsByTagName(s)[0]; if (d.getElementById(id)) return; js = d.createElement(s); js.id = id; js.src = "//connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v2.8&appId=805932966216160"; fjs.parentNode.insertBefore(js, fjs); }(document, "script", "facebook-jssdk"));</script>';
	}

	public function cutString($string, $start, $length, $endStr = '[&hellip]')
	{
		if(strlen( $string ) <= $length ) return $string;

		$str = mb_substr( $string, $start, $length - strlen( $endStr ) + 1, 'UTF-8');
		return substr( $str, 0, strrpos( $str,' ') ).$endStr;
	}
	
}
	
?>

