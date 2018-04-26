<?php

class Preview_bloc extends DB
{
	private $_db;
	private $_lang = "fr";
	private $_langue = "fr";
	private $_child;
	private $_rowed;
	private $_displayed;
	private $_langue_secondaire;
	private $_main_lang = "fr";
	private $_skin;
	
	public function __construct()
	{
		$this->_db = parent::__construct();
	}

	public function get_onglet_menu()
	{
		$file = file_get_contents("content/menu/".$this->_lang."/code.json");
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
	
	public function get_filters($ID, $display = "block")
	{
		$url = "";
		$filtre = array();
		$filter = array("etiquette 1", "etiquette 2", "etiquette 3", "etiquette 4");
		if($display == "block")
		{
			$filtre[] = "<a style='display: $display' href='".$url."' class='filter'>Tout</a>";
		}
		foreach($filter as $etiquette)
		{

			$filtre[] = "<a style='display: $display' href='".$url."?filter=$etiquette' class='filter'>".$etiquette."</a>";
			$filterReturn[] = $etiquette;
		}


		$this->_child['filter'] = $filtre;
		
		
		#$this->_child['filter'] = array_reverse($this->_child['filter']);
		#$filterReturn = array_reverse($filterReturn);
		return $filterReturn;		
		
	}
	
	public function get_page()
	{	
		$this->_content['nom'] = "C'est le titre de ma page";
		$this->_content['description'] = "C'est la description de ma page. Je peux y mettre tout ce que je veux. Il peut s'agir d'une accroche ou d'un texte un peu plus long pour inciter les gens à cliquer sur le bouton.";
		$this->_content['texte'] = "C'est le texte de ma page. Je peux y mettre tout ce que je veux. Il peut s'agir d'une accroche ou d'un texte un peu plus long pour inciter les gens à cliquer sur le bouton. Il peut être beaucoup plus long que la description. C'est ce qui constitue le corps de votre page.";
		$this->_content['widgets'] = "<div style='width: 100%; height: 150px; border: 2px solid #dadada; text-align: center; display: flex'><p style='text-align: center; margin: auto'>WIDGETS</p></div>";
		$this->_content['image'] = "template.jpg";
		$this->_content['display'] = $_GET['miniature'];
		$this->_content['date'] = time();
		
		$nom = $this->_content['nom'];
		$image = $this->_content['image'];
		if($this->_content['image'] != null)
		{
			$this->_content['image'] = "images/".$this->_content['image'];
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


	
	public function get_header()
	{
		echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>';
		

		echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">';
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
	
	public function cutString($string, $start, $length, $endStr = '[&hellip]')
	{
		if(strlen( $string ) <= $length ) return $string;

		$str = mb_substr( $string, $start, $length - strlen( $endStr ) + 1, 'UTF-8');
		return substr( $str, 0, strrpos( $str,' ') ).$endStr;
	}	

	public function get_social()
	{
		$this->_social = json_decode($this->_social, true);
		
		foreach($this->_social as $key => $social)
		{
			if($social != null)
			{
				if(file_exists("themes/".$this->_skin."/images/icon/".$key.".png"))
				{
					$icone = "themes/".$this->_skin."/images/icon/".$key.".png";
				}
				else
				{
					$icone = "images/social/$key.png";
				}
				echo "<div class='socialIcon' style='display: block; float: right; width: 30px; height: 30px'><a href='$social' target='_blank'><img src='$icone' style='max-width: 100%'/></a></div>";
			}
		}
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
		//$logo = glob("content/logo/logo.*");
		$logo = "images/logoTemplate.png";
		#print_r($logo);
		return $logo;
	}

	public function get_search_icon()
	{
		if(file_exists("themes/".$this->_skin."/images/icon/search.png"))
		{
			$icone = "themes/".$this->_skin."/images/icon/search.png";
		}
		else
		{
			$icone = "/images/search.png";
		}
		
		//echo $this->_path."theme/".$this->_skin."/images/icon/search.png";
		return "<img src='".$icone."' style='max-height: 20px'/>";
	}
	
	public function get_menu()
	{
		if($this->_langue_secondaire != null)
		{
			$this->_langue_secondaire[] = $this->_main_lang;
			$this->_langue .= "<select id='language_select'>";
			foreach($this->_langue_secondaire as $language)
			{
				if($language == $this->_main_lang)
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
		if(file_exists("content/menu/".$this->_lang."/topmenu.php"))
		{
			$topmenu = file_get_contents("content/menu/".$this->_lang."/topmenu.php");
			echo "<div id='topmenu'><div class='container'>$topmenu</div></div>";
		}
		$wireframe = file_get_contents("content/menu/disposition.txt", true);
		$wireframe = $_GET['miniature'];
		$wireframe = file_get_contents("wireframes/Menu/$wireframe/code.template", true);
		$wireframe = eval(" ?>".$wireframe."<?php ");	
		echo $wireframe;
				
		//$this->get_logo();
		//$this->get_onglet_menu();
	}	
		
	public function get_child($post, $nombre = 3, $disposition = "blog_01", $offset  = 0)
	{
		$post = $_POST;
		$boucle = 0;
		if($nombre != 1)
		{
			while($boucle < $nombre - 1)
			{
				$boucle++;
				$this->get_child($post, 1, $disposition , 0);
				
			}
		}
		#print_r($post);
		$reponse = $post;	
		$this->_child = $post;
		#print_r($this->_child);
#		foreach($reponse as $this->_child)
#		{
			$this->_child['style']['background_link'] = "#3683c3";
			$this->_child['style']['color_link'] = "white";
			$this->_child['image'] = "images/template.jpg";
			$this->_child['nom'] = "C'est le titre de votre article/page/bloc";
			$this->_child['description'] = "C'est la description de votre contenu. Vous pouvez y mettre n'importe quoi. En général on l'utilise pour mettre un court slogan ou une phrase d'accroche pour inciter à cliquer.";
			$this->_child['texte'] = "<br/><br/>C'est le corps de votre page. le champs \"texte\". Il est totalement libre de style et donc, vous pouvez y mettre ce que vous voulez ! Il n'y a aucune restriction.<br/><br/>";
			$this->_child['lien'] = "Votre lien";
			$this->_child['date'] = time();
/*		
			$this->_child['nom'] = $this->_child['nom']["fr"];
			$this->_child['description'] = $this->_child['description']["fr"];
			$this->_child['lien'] = $this->_child['lien']["fr"];
*/
			#echo $this->_child['nom'];
			$this->_child['date'] = time();
			$this->_child['formated_date'] = $this->time_elapsed_string(date("d-m-Y", intval($this->_child['date'])), false);
			#echo $this->_child['formated_date'];
			$this->_child['date'] = strftime("%d %B %Y", intval($this->_child['date']));
			
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
				$this->_child['link'] = "test.html";
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
				#$this->_child['image'] = "content/images/".$this->_child['image'];
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
			
			$wireframe = file_get_contents("wireframes/Miniatures/$miniatures/code.template");
			
			
			if(strstr($wireframe, "container = 'container'") !== false OR strstr($wireframe, "container = 'container-fluid'") !== false)
			{
				#echo $this->_container;
				$numberOfSquare = preg_match('#col-sm-(.*)( |\')#', $wireframe, $result);
				#print_r($result);
				$resultat = $result[1];
				
				#echo $resultat;
				
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
					
					
					
					#echo $row;
// 					$wireframe = str_replace("", "", $wireframe);
					$wireframe = eval(" ?>".$wireframe."<?php ");
					#echo $closeRow;
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
				//echo "ok";
				$boostrap = 0;

				if($this->_displayed == true)
				{
					echo "</div></div>";
					$this->_displayed = false;
				}
				$paire++;
// 				echo $wireframe;
				$wireframe = eval(" ?>".$wireframe."<?php ");
				
			}
			
	
		if($displayed == true)
		{
			echo "</div>";
			$displayed = false;
		}		

		
				
	}
	
}
	
?>

