<?php
class AnalyseDE extends DB
{
	private $_db;
	private $_time = "WHERE 1 ";
	public $_titre = "le début";
	private $_progression = array(0, 0);
	private $_sessionID;
	private $_moyenne;

	public function __construct()
	{
		$this->_db = parent::__construct();
		
		#echo $_SERVER['REQUEST_URI'];
		$this->_sessionID = $_GET['session_ID'];
		$this->_moyenne = "WHERE date > '".(time()-604800)."' ";
		$sql = "CREATE TABLE IF NOT EXISTS `tracking` (
			  `ID` bigint(20) unsigned AUTO_INCREMENT PRIMARY KEY,
			  `IP` varchar(255) NOT NULL,
			  `ville` varchar(255) NOT NULL,
			  `pays` varchar(255) NOT NULL,
			  `date` varchar(255) NOT NULL,
			  `navigateur` varchar(255) NOT NULL,
			  `referrer` varchar(255) NOT NULL,
			  `page` varchar(255) NOT NULL,
			  `session` varchar(255) NOT NULL,
			  `langue` varchar(255) NOT NULL,
			  `OS` varchar(255) NOT NULL	  
			)";

		$reponse = $this->_db->exec($sql);

	    $sql = "SELECT * FROM systeme WHERE nom = 'dateBigData'";
	    $reponse = $this->_db->query($sql);
	    
	    if($reponse->rowCount() == 0)
	    {
		    $time = time();
		    $time = $time+365*24*3600;
		    $sql = "INSERT INTO systeme VALUES('','dateBigData','".$time."')";
		    $reponse = $this->_db->query($sql);
	    }		

		$sql = "CREATE TABLE IF NOT EXISTS `tracking_follow` (
			  `ID` bigint(20) unsigned AUTO_INCREMENT PRIMARY KEY,
			  `ID_SESSION` varchar(255) NOT NULL,
			  `page` varchar(255) NOT NULL,
			  `time` varchar(255) NOT NULL,
			  `date` varchar(255) NOT NULL	  
			)";

		$reponse = $this->_db->exec($sql);
		if(isset($_GET['date']) AND $_GET['date'] != null)
		{
			switch($_GET['date'])
			{
				case "7": 
					$this->_time = "WHERE date > '".(time()-604800)."' ";
					$this->_titre = "les 7 derniers jours";
					$this->_progression[0] = time()-(2*604800);
					$this->_progression[1] = time()-604800;
				break;
				case "30": 
					$this->_time = "WHERE date > '".(time()-18144000)."' ";
					$this->_titre = "les 30 derniers jours";
					$this->_progression[0] = time()-(2*18144000);
					$this->_progression[1] = time()-18144000;
				break;
				case "24": 
					$this->_time = "WHERE date > '".(time()-86400)."' ";
					$this->_titre = "les dernières 24 heures";
					$this->_progression[0] = time()-(2*86400);
					$this->_progression[1] = time()-86400;
				break;
			}
		}

	}

	public function checkAbonnement()
	{
		$sql = "SELECT * FROM systeme WHERE nom = 'dateBigData'";
		$reponse = $this->_db->query($sql);
		
		while($donnees = $reponse->fetch())
		{
			if($donnees['valeur'] < time())
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		
	}



	public function comportement()
	{
/*
		echo "<div class='nombre col-sm-12 col-lg-10 col-lg-offset-1'>";
		echo "<div class='col-sm-12 cadre'>";
		echo "<h3>Nombre d'interactions</h3>";
		echo "<label for='Nombre'>Nombre d'interactions</label><input type='number' value='4' name='nombre'/>";
		echo "</div>";
		echo "</div>";
*/
		
		
		
		echo "<div class='comportement col-sm-12 col-lg-10 col-lg-offset-1'>";
		echo "<div class='col-sm-12 code cadre'><h3>Comportement des internautes</h3><br/>";
		
		$sql = "SELECT * FROM tracking_follow $this->_time ORDER BY ID_SESSION";
		$reponse = $this->_db->query($sql);
		$step = 10;
		$classementPage = array();
		$arrayComportement = array();
		
		while($donnees = $reponse->fetch())
		{
			$positionPremierSlash = strrpos($donnees['page'], "/");
			$page = substr($donnees['page'], $positionPremierSlash);
			
			$classementPage[$donnees['ID_SESSION']][] = str_replace("www.", "",$page);
			$arrayComportement[$donnees['ID_SESSION']][] = str_replace("www.", "",$page);
		}

		$i = 0;
		echo "<div class='containerDiv'>";
		echo "<div id='comportementDiv'>";
		while($i <= $step)
		{
			$ancienTotal = $totalConnexion;
			echo "<div class='step'>";
			$interaction = $i+1;
			$majoritePage = array();
			foreach($classementPage as $client)
			{
				$clientPage = $client[$i];
				$majoritePage[] = $clientPage;
			}
			$majoritePage = array_count_values($majoritePage);
			$cle = $majoritePage;
			
			
			$majoritePage = array_keys($majoritePage);
			sort($majoritePage);
			
			
			if($interaction == 1)
			{
				$interaction = "1ère page visitée";
			}
			else
			{
				$interaction = $interaction."ème page visitée";
			}
			
			$totalConnexion = 0;
			
			foreach($cle as $nombre)
			{
				$totalConnexion += $nombre;
			}
			
			$calculPerte = (($totalConnexion-$ancienTotal)/$ancienTotal)*100;
			//$calculPerte = $calculPerte*(-1);
			sort($cle);
			$cle = array_reverse($cle);
			//print_r($majoritePage);
			if($i == 0)
			{
				echo "<h6>Arrivée</h6><div class='pagePerte'>visiteurs : $totalConnexion </div>";
			}
			else
			{
				echo "<h6>".$interaction. "</h6>";
				echo "<div class='pagePerte'>visiteurs : $totalConnexion <span class='pourcentagePerte'>(".number_format($calculPerte, 2, ',',' ')." % &darr;)</span></div>";
			}
			$autrePage = 0;
			foreach($majoritePage as $key => $page)
			{
				$nombre = $key;
				//echo $majoritePage[$key];
				$calcul = ($cle[$key]/$totalConnexion)*100;			
				$newTabNext = array();
				$countInteractionNext = 0;
				foreach($arrayComportement as $userComportement)
				{
					if($page == $userComportement[$i])
					{
						$newTabNext[] = $userComportement[$i+1];
					}
				}
				$tabSansVide = array();
				foreach($newTabNext as $triage)
				{
					if($triage != "")
					{
						$tabSansVide[] = $triage;
					}
					else
					{
						$tabSansVide[] = "Déconnexion";
					}
				}
				//echo $countInteractionNext;
				$newTabNext = $tabSansVide;
				$countInteractionNext = count($newTabNext);
				$tableauTrie = array_count_values($newTabNext);
				//print_r($newTabNext);

				if($page == "/")
				{
					$page = "/index.php";
				}
				if($page == "/index.php")
				{
					$page = "Page d'accueil";
				}	
				
				$autre = 0;
				if($calcul > 5)
				{
					echo "<div data-height='".number_format($calcul, 2, '.',' ')."' class='pageInteraction'>".$page." <span class='pourcentage'>(".number_format($calcul, 2, ',',' ')."%)</span><div class='whatIsTheNextStep'> <span class='ensuite'>Ensuite?</span><br/><br/>";
					$trouve = false;
					arsort($tableauTrie);
					foreach($tableauTrie as $keys => $interactionSuivante)
					{
						
						//echo $countInteractionNext;
						$resultatMoyenne = $interactionSuivante/$countInteractionNext*100;
						if($resultatMoyenne > 5)
						{
							$trouve = true;
							if($keys == "/")
							{
								$keys = "la page d'accueil";
							}
							if($keys == "/index.php")
							{
								$keys = "la page d'accueil";
							}
							if($keys == "Déconnexion")
							{
								echo "<span class='nextVal deconnectEvent'><strong>".number_format($resultatMoyenne, 0)."%</strong> se déconnectent</span><br/>";
							}
							else
							{
								echo "<span class='nextVal'><strong>".number_format($resultatMoyenne, 0)."%</strong> vont sur ".$keys."</span><br/>";
							}
						}
						else
						{
							$autre += $resultatMoyenne;
						}
					}
					if($trouve == false)
					{
						#echo "<span class='nextVal'>déconnexion</span><br/>";
					}
					if($autre != 0)
					{
						echo "<span class='nextVal'><strong>".number_format($autre, 0)."%</strong> : autres pages</span><br/>";
					}				
					
					echo "</div>";
					echo "</div>";
				}
				else
				{
					$autrePage += $calcul;
				}
			}
			if($autrePage != 0)
			{
				echo "<div data-height='".number_format($autrePage, 2, '.',' ')."' class='pageInteraction'>Autres<span class='pourcentage'>(".number_format($autrePage, 2, ',',' ')."%)</span><div class='whatIsTheNextStep'></div></div>";				
			}
			
			$i++;
			echo "</div>";
			
		}
		echo "</div>";
		echo "</div>";
		//print_r($classementPage);
		
		
		echo "</div></div>";	
	}

	public function integration()
	{
		$url = base64_encode("http://".$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
		echo "<div class='codeTracking col-sm-12 col-lg-10 col-lg-offset-1'><div class='col-sm-12 code cadre'><h3>Code de tracking</h3><br/>Pour récolter des informations sur votre site copier/coller ce code dans l'en-tête de chacune de vos pages.<br/>jQuery est indispensable pour récupérer les données.
		<br/><br/><textarea disabled id='code' class='col-sm-6 col-sm-offset-3'><script type='text/javascript' src='http://".$_SERVER['HTTP_HOST']."/CMS/".$url."/analytics/'></script></textarea>
		</div></div>";		
	}

	public function writeNewConnection()
	{
		$urlDomaine = $_SERVER['HTTP_REFERER'];
		$urlDomaine = parse_url($urlDomaine);
		
		$domaineRequete = $urlDomaine['host'];
		$domaineRequete = str_replace("www.", "", $domaineRequete);
		//exit($domaineRequete);
		$monDomaine = $_SERVER['HTTP_HOST'];
		#echo $monDomaine;
		$trouve = false;
		
		$sql = "SELECT * FROM systeme WHERE nom = 'domaine'";
		$reponse = $this->_db->query($sql);
		
		while($donnees = $reponse->fetch())
		{
			if($domaineRequete == $monDomaine || $domaineRequete == $donnees['valeur'])
			{
				$trouve = true;
			}
		}
		
		if($trouve == false)
		{
			exit("Vous n'y êtes pas autorisé.");
		}
		
		$heure = time() - 3600;
		$sql = "SELECT * FROM tracking WHERE IP = '".$_GET['ip']."' AND date > '".$heure."' AND session = '".$_GET['session_ID']."'";
		$reponse = $this->_db->query($sql);

		if($reponse->rowCount() == 0)
		{
			$sql2 = "INSERT INTO tracking VALUES('','".$_GET['ip']."','".$_GET['ville']."','".$_GET['pays']."','".time()."','".$_GET['browser']."','".$_GET['referrer']."','".$_GET['page']."', '".$this->_sessionID."', '".$_GET['langue']."','".$_GET['OS']."')";
			$reponse2 = $this->_db->exec($sql2);
		}
		else
		{
			$sqlFollow = "SELECT * FROM tracking_follow WHERE ID_SESSION = '".$this->_sessionID."'";
			$reponseFollow = $this->_db->query($sqlFollow);
			
			while($donneesFollow = $reponseFollow->fetch())
			{
				$lastID = $donneesFollow['ID'];
				$lastPage = $donneesFollow['page'];
				$connexionTime = $donneesFollow['date'];
			}
			
			if($lastPage == $_GET['page'])
			{
				$sqlFollow2 = "UPDATE tracking_follow SET time = '".$_GET['time']."' WHERE ID_SESSION = '".$this->_sessionID."' AND ID = $lastID";
				$reponseFollow2 = $this->_db->query($sqlFollow2);
			}
			else
			{
				$sqlFollow2 = "INSERT INTO tracking_follow VALUES('','".$this->_sessionID."','".$_GET['page']."','0', '".time()."')";
				$reponseFollow2 = $this->_db->exec($sqlFollow2);
			}	
					
			while($donnees = $reponse->fetch())
			{
				exit($donnees['session']);
			}
		}
	}

	
	public function readStat()
	{
		$sql = "SELECT * FROM tracking $this->_time";
		$reponse = $this->_db->query($sql);

		$sqlPetiteDate = "SELECT MIN(ID), date FROM tracking WHERE 1";
		$reponsePetiteDate = $this->_db->query($sqlPetiteDate);

		while($donneesPetiteDate = $reponsePetiteDate->fetch())
		{
			$calcul = (time()-intval($donneesPetiteDate['date']))/3600/24;
			if($calcul < 1)
			{
				$calcul = 1;
			}
			
		}

		if(isset($_GET['date']) AND $_GET['date'] == "24")
		{
			$calcul = 1;
		}
		if(isset($_GET['date']) AND $_GET['date'] == "7")
		{
			$calcul = 7;
		}
		if(isset($_GET['date']) AND $_GET['date'] == "30")
		{
			$calcul = 30;
		}

		#echo $calcul;
		//$calcul = 1;
		$sqlMoyenne = "SELECT * FROM tracking $this->_time";
		$reponseMoyenne = $this->_db->query($sqlMoyenne);

		$moyenne = $reponseMoyenne->rowCount()/$calcul;

		$visiteTotale;
		if($reponse->rowCount() == 0)
		{
		}
		else
		{
			$visiteTotale = $reponse->rowCount();
			echo "<div class='colonneGauche col-sm-6 col-lg-5 col-lg-offset-1'>";
			echo "<div class='cadre col-sm-12'>";
			echo "<h3>En bref</h3>";

			$progression = "";
			if($this->_progression[0] != 0)
			{
				$sql2 = "SELECT * FROM tracking WHERE date > '".$this->_progression[0]."' AND date < '".$this->_progression[1]."'";
				$reponse2 = $this->_db->query($sql2);
				#&uarr;
				$progression = $reponse2->rowCount();
				if($progression != 0)
				{
					$progression = ($reponse->rowCount()-$reponse2->rowCount())/$reponse2->rowCount()*100;
					$progression = number_format($progression, 2, ',', ' ');
					if($progression >= 0)
					{
						$progression = '(<span class="augmente">+'.$progression.'% &uarr;</span>)';
					}
					else
					{
						$progression = '(<span class="diminue">'.$progression.'% &darr;</span>)';
					}
				}
				else
				{
					$progression = "";
				}
			}


			echo "<div class='ligneValeur'><span class='green'>".$reponse->rowCount()."</span> visites ".$progression."</div>";

			$sql10 = "SELECT * FROM tracking $this->_time GROUP BY IP";
			$reponse10 = $this->_db->query($sql10);
			$visiteUnique = $reponse10->rowCount();

			$pourcentageNouveau = $visiteUnique/$visiteTotale*100;
			$pourcentageRecurrent = 100-number_format($pourcentageNouveau, 2, ',', ' ');


			$sqlFollow = "SELECT * FROM tracking_follow $this->_time ORDER BY ID_SESSION ASC";
			$reponseFollow = $this->_db->query($sqlFollow);
			$tableauCompteur = array();
			$indexTableau = -1;
			$nombreDeSession = 0;
			$nombreResultat = 0;
			$tempsTotal = 0;
			
			while($donneesFollow = $reponseFollow->fetch())
			{
				$resultat++;
				if($tableauCompteur[$indexTableau][0] == $donneesFollow['ID_SESSION'])
				{
					$tableauCompteur[$indexTableau][1] = intval($tableauCompteur[$indexTableau][1])+intval($donneesFollow['time']);
					$tableauCompteur[$indexTableau][2]++;
				}
				else
				{
					
					$indexTableau++;
					
					$tableauCompteur[$indexTableau][0] = $donneesFollow["ID_SESSION"];
					$tableauCompteur[$indexTableau][1] = $donneesFollow["time"];
					$tableauCompteur[$indexTableau][2]++;	
				}
				
				$tempsTotal += $donneesFollow["time"];
				
			}
			
			$nombreDeSession = count($tableauCompteur);
			
			$moyenneTempsDeVisiteParSession = ($tempsTotal/$nombreDeSession);
// 			echo $moyenneTempsDeVisiteParSession;
			
			$sqlMoyennePageVisitee = "SELECT *, count(*) FROM tracking_follow $this->_time GROUP BY ID_SESSION";
			$reponseMoyennePageVisitee = $this->_db->query($sqlMoyennePageVisitee);
			
			while($donneesMoyennePageVisitee = $reponseMoyennePageVisitee->fetch())
			{
				$nombreTotalMoyennePage += $donneesMoyennePageVisitee['count(*)'];
			}
			$nombreDeSessionDifferente = $reponseMoyennePageVisitee->rowCount();
			
			$moyennePageVisiteeParSession = $nombreTotalMoyennePage/$nombreDeSessionDifferente;
			

			echo "<div class='ligneValeur'><span class='green'>".$reponse10->rowCount()."</span> personnes différentes</div>";
			echo "<div class='ligneValeur'><span class='green'>&#177; ".number_format($moyenne, 2, ',', ' ')."</span> visiteurs/jour </div>";
			echo "<div class='ligneValeur'><span class='green'>".$pourcentageRecurrent."%</span> de retours</div>";
			echo "<div class='ligneValeur'><span class='green'>".number_format($pourcentageNouveau, 2, ',', ' ')."%</span> de nouveaux visiteurs</div>";
			echo "<div class='ligneValeur'><span class='green'>&#177; ".number_format($moyenneTempsDeVisiteParSession, 2, ',', ' ')."</span> secondes/visite</div>";
			echo "<div class='ligneValeur'><span class='green'>&#177; ".number_format($moyennePageVisiteeParSession, 2, ',', ' ')."</span> pages visitées/connexion </div>";
			// $sql10 = "SELECT * FROM tracking WHERE date > '".(time()-604800)."'";
			// $reponse10 = $this->_db->query($sql10);
			// echo $reponse10->rowCount()." connexions ces 7 derniers jours";
			echo "</div>";

			echo "<div class='cadre col-sm-12'>";
			echo "<h3>Origines des visiteurs</h3>";
			$sql10 = "SELECT *, COUNT(*) FROM tracking $this->_time GROUP BY pays ORDER BY COUNT(*) DESC";
			$reponse10 = $this->_db->query($sql10);

			$total = $visiteTotale;
			while($donnees10 = $reponse10->fetch())
			{
				//echo $donnees10['COUNT(*)'];
				$pourcentage = ($donnees10['COUNT(*)']/$total)*100;
				$pourcentage = number_format($pourcentage, 2, ',', ' ');
				//echo $sql10;
				if($donnees10['ville'] == null) $ville = "";
				else $ville = $donnees10['ville'];
				if($donnees10['pays'] == null) $pays = "inconnu";
				else $pays = $donnees10['pays'];
				$resultatVilles = "";
				$sqlVilles = "SELECT *, COUNT(*) FROM tracking $this->_time AND pays = '".$pays."' GROUP BY ville ORDER BY COUNT(*) DESC";
				$reponseVilles = $this->_db->query($sqlVilles);

				$totalVilles = $reponseVilles->rowCount();
				//echo $totalVilles."<br>";
				while($donneesVilles = $reponseVilles->fetch())
				{
					//echo $donneesVilles['COUNT(*)'];
					$pourcentageVilles = ($donneesVilles['COUNT(*)']/$donnees10['COUNT(*)'])*100;
					$pourcentageVilles = number_format($pourcentageVilles, 2, ',', ' ');
					if($donneesVilles['ville'] == null) $ville = "inconnue";
					else $ville = $donneesVilles['ville'];
					$resultatVilles .= "<div class='ligneValeur'>- ".$ville." (<span class='blue'>".$pourcentageVilles."%</span>)</div>";
					//echo "<div class='ligneValeur'>".$ville." (<span class='green'>".$pourcentageVilles."%</span>)</div>";
				}
				$paysID = str_replace(" ", "_", $pays);
				echo "<div class='ligneValeur'><span data-data='".$paysID."' class='lienPays'>".$pays."</span> (<span class='green'>".$pourcentage."%</span>)</div>";
				echo "<div class='villesInfos' id='".$paysID."Info'>".$resultatVilles."</div>";
			}
			echo "</div>";
			echo "<div class='cadre col-sm-12'>";
			echo "<h3>Langues</h3>";
			$sql11 = "SELECT *, COUNT(*) FROM tracking $this->_time GROUP BY langue ORDER BY COUNT(*) DESC";
			$reponse11 = $this->_db->query($sql11);
			$totalBrowser = $visiteTotale;
			$totalLangue = $visiteTotale;
			while($donnees11 = $reponse11->fetch())
			{
				$pourcentageLangue = ($donnees11['COUNT(*)']/$totalBrowser)*100;
				$pourcentageLangue = number_format($pourcentageLangue, 2, ',', ' ');
				if($donnees11['langue'] == null) $langue = "inconnue";
				else{
					$langue = $donnees11['langue'];
					$langue = $langue{0}.$langue{1};
				} 


				echo "<div class='ligneValeur'>".ucfirst(Locale::getDisplayLanguage($langue, 'fr'))." (<span class='green'>".$pourcentageLangue."%</span>)</div>";
			}
			echo "</div>";

			echo "<div class='cadre col-sm-12'>";
			echo "<h3>Vos vidéos</h3>";

			$sqlVideo = "SELECT * FROM medias WHERE type = 'video' ORDER BY ID DESC";
			$reponseVideo = $this->_db->query($sqlVideo);

			while($donneesVideo = $reponseVideo->fetch())
			{
				$url = $donneesVideo['url'];
				// if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
				//     $video_id = $match[1];
				// }
				// if(preg_match('%(?:dailymotion(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/video/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)){
				// 	$video_idDailymotion = $match[1];
				// 	echo $video_idDailymotion;
				// }

				$link = $url;
				$media_url = "";
				$site = "";

				//YOUTUBE
				if(preg_match('#(?<=(?:v|i)=)[a-zA-Z0-9-]+(?=&)|(?<=(?:v|i)\/)[^&\n]+|(?<=embed\/)[^"&\n]+|(?<=(?:v|i)=)[^&\n]+|(?<=youtu.be\/)[^&\n]+#', $link, $videoid)){
				        if(strlen($videoid[0])) { $media_url = $videoid[0]; $site = "youtube";}
				}

				//DAILYMOTION
				preg_match('#<object[^>]+>.+?www.dailymotion.com/swf/video/([A-Za-z0-9]+).+?</object>#s', $link, $matches);
				if(!isset($matches[1])) {
				        preg_match('#www.dailymotion.com/video/([A-Za-z0-9]+)#s', $link, $matches);
				        if(!isset($matches[1])) {
				                preg_match('#www.dailymotion.com/embed/video/([A-Za-z0-9]+)#s', $link, $matches);
				                if(strlen($matches[1])){ $media_url = $matches[1]; $site = "dailymotion";}
				        }elseif(strlen($matches[1])){
				                $media_url = $matches[1];
				                $site = "dailymotion";
				        }
				}elseif(strlen($matches[1])){
				        if(strlen($matches[1])){ $media_url = $matches[1]; $site = "dailymotion";}
				}
				 
				//VIMEO
				if(preg_match('#(https?://)?(www.)?(player.)?vimeo.com/([a-z]*/)*([0-9]{6,11})[?]?.*#', $link, $videoid)){
				        if(strlen($videoid[5])) { $media_url = $videoid[5]; $site = "vimeo";}
				}

				if($site == "dailymotion")
				{
					$api = file_get_contents("https://api.dailymotion.com/video/".$media_url."?fields=views_total");
					$api = json_decode($api, true);
					$vueDailyMotion += $api['views_total'];
					$dailymotionInfo .= "<div class='ligneValeur'>- ".$donneesVideo['nom']." - <span class='green'>".number_format($api['views_total'], 0, ',', '.')." vues</span></div>";
				}
				if($site == "youtube")
				{
					$api = file_get_contents("https://www.googleapis.com/youtube/v3/videos?id=".$media_url."&key=AIzaSyDQAjJWIUqy9ZToky2SnPBfhN0uliuSh54&part=statistics");
					$api = json_decode($api, true);
					foreach($api["items"] as $item)
					{
						$vueYoutube += $item['statistics']['viewCount'];
						$youtubeInfo .= "<div class='ligneValeur'>- ".$donneesVideo['nom']." - <span class='green'>".number_format($item['statistics']['viewCount'], 0, ',', '.')." vues</span></div>";
					}
				}
				
			}
			
			
			echo "<div class='ligneValeur'><span data-data='youtube' class='lien'>Youtube</span> - <span class='green'>".number_format($vueYoutube, 0, ',', '.')." vues</span></div>";
			echo "<div class='detailsVideo' id='youtubeInfo'>$youtubeInfo</div>";
			echo "<div class='ligneValeur'><span data-data='dailymotion' class='lien'>Dailymotion</span> - <span class='green'>".number_format($vueDailyMotion, 0, ',', '.')." vues</span></div>";
			echo "<div class='detailsVideo' id='dailymotionInfo'>$dailymotionInfo</div>";
			echo "</div>";

			echo "</div>";

			echo "<div class='colonneDroite col-sm-6 col-lg-5'>";
			echo "<div class='cadre col-sm-12'>";
			echo "<h3>Navigateurs</h3>";
			$sql11 = "SELECT *, COUNT(*) FROM tracking $this->_time GROUP BY navigateur ORDER BY COUNT(*) DESC";
			$reponse11 = $this->_db->query($sql11);

			$totalBrowser = $visiteTotale;
			while($donnees11 = $reponse11->fetch())
			{
				$pourcentageBrowser = ($donnees11['COUNT(*)']/$totalBrowser)*100;
				$pourcentageBrowser = number_format($pourcentageBrowser, 2, ',', ' ');
				if($donnees11['navigateur'] == null) $navigateur = "Inconnu";
				else $navigateur = $donnees11['navigateur'];

				echo "<div class='ligneValeur'>".ucfirst($navigateur)." (<span class='green'>".$pourcentageBrowser."%</span>)</div>";
			}
			echo "</div>";	
			echo "<div class='cadre col-sm-12'>";
			echo "<h3>Système d'exploitation</h3>";
			$sql11 = "SELECT *, COUNT(*) FROM tracking $this->_time GROUP BY OS ORDER BY COUNT(*) DESC";
			$reponse11 = $this->_db->query($sql11);

			$totalOS = $visiteTotale;
			while($donnees11 = $reponse11->fetch())
			{
				$pourcentageOS = ($donnees11['COUNT(*)']/$totalOS)*100;
				$pourcentageOS = number_format($pourcentageOS, 2, ',', ' ');
				if($donnees11['OS'] == null) $OS = "Inconnu";
				else $OS = $donnees11['OS'];

				echo "<div class='ligneValeur'>".ucfirst($OS)." (<span class='green'>".$pourcentageOS."%</span>)</div>";
			}
			echo "</div>";

			echo "<div class='cadre col-sm-12'>";
			echo "<h3>Provenance</h3>";
			$sql11 = "SELECT *, COUNT(*) FROM tracking $this->_time GROUP BY referrer ORDER BY COUNT(*) DESC";
			$reponse11 = $this->_db->query($sql11);

			$array_social = array();
			$totalReferrer = $visiteTotale;
			while($donnees11 = $reponse11->fetch())
			{
				$url1 = parse_url($donnees11['referrer']);
				$url2 = parse_url($donnees11['page']);
				
				
				$site = str_replace("www.","",$url1['host']);
				$site = str_replace("m.", "", $site);
				
				if($donnees11['referrer'] != null)
				{
					if($url1['host'] == $url2['host'])
					{
						$LienDirect += $donnees11['COUNT(*)'];
					}
					else
					{
						if((strstr($url1['host'], "google") AND !strstr($url1['host'], "plus.url.google"))  OR strstr($url1['host'], "yahoo") OR strstr($url1['host'], "bing") OR strstr($url1['host'], "duckduckgo"))
						{
							
							$positionExtension = strrpos($site, ".");
							$site = substr($site, 0, $positionExtension);
							$array_search[] = $site;
							$search += $donnees11['COUNT(*)'];
						}
						else
						{
							if(strstr($url1['host'], "facebook") OR strstr($url1['host'], "twitter") OR strstr($url1['host'], "linkedin") OR strstr($url1['host'], "instagram") OR strstr($url1['host'], "youtube") OR strstr($url1['host'], "vimeo") OR strstr($url1['host'], "pinterest") OR strstr($url1['host'], "tumblr") OR strstr($url1['host'], "plus.url.google"))
							{	
								$positionExtension = strrpos($site, ".");
								$site = substr($site, 0, $positionExtension);
								if(strstr($url1['host'], "plus.url.google"))
								{
									$site = "Google plus";
								}
								$array_social[] = $site;
								$social += $donnees11['COUNT(*)'];
							}
							else
							{
								$other += $donnees11['COUNT(*)'];
								$array_other[] = $site;
								//echo $donnees11['navigateur'];
							}
						}
					}
				}
				else
				{
					$LienDirect += $donnees11['COUNT(*)'];
				}
				
			}
			
			#$array_social = array_unique($array_social);
			$pourcentageLienDirect = ($LienDirect/$totalReferrer)*100;
			$pourcentageLienDirect = number_format($pourcentageLienDirect, 2, ',', ' ');

			$pourcentageOther = ($other/$totalReferrer)*100;
			$pourcentageOther = number_format($pourcentageOther, 2, ',', ' ');

			$pourcentageSocial = ($social/$totalReferrer)*100;
			$pourcentageSocial = number_format($pourcentageSocial, 2, ',', ' ');

			$pourcentageSearch = ($search/$totalReferrer)*100;
			$pourcentageSearch = number_format($pourcentageSearch, 2, ',', ' ');
			echo "<div class='ligneValeur'>Lien direct (<span class='green'>".$pourcentageLienDirect."%</span>)</div>";
			echo "<div class='ligneValeur lienDetails'>Moteurs de recherche (<span class='green'>".$pourcentageSearch."%</span>)</div>";
			
			echo "<div class='detailsView'>";
			
			$array_search_doublons = $array_search;
			$array_search = array_unique($array_search);
			$occurance_search = array_count_values($array_search_doublons);
			$total_search = count($array_search_doublons);
			foreach($array_search as $search)
			{
				$moyenneSearch = ($occurance_search[$search]/$total_search)*100;
				$moyenneSearch = number_format($moyenneSearch, 2, ',',' ');
				echo "<div class='ligneValeurDetails'>- ".$search." (<span class='blue'>".$moyenneSearch."%</span>)</div>";
			}
			
			echo "</div>";
			
			echo "<div class='ligneValeur lienDetails'>Réseaux sociaux (<span class='green'>".$pourcentageSocial."%</span>)</div>";

			echo "<div class='detailsView'>";
			$array_social_doublons = $array_social;
			$array_social = array_unique($array_social);
			$occurance_social = array_count_values($array_social_doublons);
			$total_social = count($array_social_doublons);
			foreach($array_social as $social)
			{
				$moyenneSocial = ($occurance_social[$social]/$total_social)*100;
				$moyenneSocial = number_format($moyenneSocial, 2, ',',' ');
				echo "<div class='ligneValeurDetails '> - ".$social." (<span class='blue'>".$moyenneSocial."%</span>)</div>";
			}
			echo "</div>";
			
			echo "<div class='ligneValeur lienDetails'>Autres (<span class='green'>".$pourcentageOther."%</span>)</div>";
			
			echo "<div class='detailsView'>";
			
			$array_other_doublons = $array_other;
			$array_other = array_unique($array_other);
			$occurance_other = array_count_values($array_other_doublons);
			$total_other = count($array_other_doublons);
			foreach($array_other as $other)
			{
				$moyenneOther = ($occurance_other[$other]/$total_other)*100;
				$moyenneOther = number_format($moyenneOther, 2, ',',' ');
				echo "<div class='ligneValeurDetails'>- ".$other." (<span class='blue'>".$moyenneOther."%</span>)</div>";
			}
			
			echo "</div>";
			echo "</div>";

			echo "</div>";
				
		}	
		

	}
}
?>

