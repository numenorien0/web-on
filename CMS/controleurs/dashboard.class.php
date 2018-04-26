<?php
class dashboard extends DB
{
	private $_db;

	public function __construct()
	{
		$this->_db = parent::__construct();
		if(isset($_POST['envoyer']))
		{
			$this->addMessage();
		}
	}

	public function note_service()
	{
		#echo "ok2";
		$fichierXML = file_get_contents("http://www.web-on.be/CMS/note_service.xml");
		$fichierXML = new SimpleXMLElement($fichierXML);
		#echo "ok";
		#print_r($fichierXML);
		if($fichierXML->state == "online")
		{
			echo "<div class='messageService col-sm-12 col-lg-10 col-lg-offset-1' style='padding: 0px; margin-top: 7px; margin-bottom: 7px'>";
			echo "<div class='cadre col-sm-12'>";
			echo "<h3><img src='images/caution2.png' id='caution'>Message public</h3>";
			echo $fichierXML->message;
			echo "</div></div>";
		}
		else
		{
		}
	}

	public function get_log()
	{
		
		$sql = "SELECT * FROM log_system ORDER BY date DESC LIMIT 15 ";
		$reponse = $this->_db->query($sql);
		
		while($donnees = $reponse->fetch())
		{
			$date = " le ".date("d/m/Y à H:i", $donnees['date']);
			echo "<div style='padding-top: 5px; padding-bottom: 5px'>".$donnees['auteur']." ".$donnees['action'].$date."</div>";
		}
		
	}

	public function afficherEnBref()
	{
		$sql = "SELECT * FROM contenu";
		$reponse = $this->_db->query($sql);
		$sql2 = "SELECT * FROM medias WHERE type = 'photo'";
		$reponse2 = $this->_db->query($sql2);
		$sql3 = "SELECT * FROM medias WHERE type = 'video'";
		$reponse3 = $this->_db->query($sql3);

		echo "<div class='col-sm-12 chiffreLigne'>Vous avez <span class='chiffre'>".$reponse->rowCount()."</span> pages</div>";
		echo "<div class='col-sm-12 chiffreLigne'>Vous avez <span class='chiffre'>".$reponse2->rowCount()."</span> albums photos</div>";
		echo "<div class='col-sm-12 chiffreLigne'>Vous avez <span class='chiffre'>".$reponse3->rowCount()."</span> vidéos</div>";

	}

	public function afficherDernieresConnexion()
	{
		$sql = "SELECT * FROM login ORDER BY connexion DESC";
		$reponse = $this->_db->query($sql);
		while($donnees = $reponse->fetch())
		{
			if($donnees['connexion'] != "")
			{
				$derniereConnexion = "le ".date("d/m/Y à H:i", $donnees['connexion']);
			}
			else
			{
				$derniereConnexion = "jamais";
			}
			
			echo "<div class='col-sm-12 connected'><span class='loginConnected'>".$donnees['login']." </span><span class='loginDate pull-right'>".$derniereConnexion."</span></div>";
		}
	}

	public function addMessage()
	{
		$message = str_replace("'","''", $_POST['message']);

		$sql = "INSERT INTO message VALUES('','".$message."', '".$_SESSION['login']."', '".time()."')";
		$reponse = $this->_db->query($sql);
	}

	public function message()
	{
		$sql = "SELECT * FROM message ORDER BY date DESC limit 0, 40";
		$reponse = $this->_db->query($sql);
		echo "<div id='messageContainer'>";
		$tableauMessage = array();
		while($donnees = $reponse->fetch())
		{
			$sqlAuteur = "SELECT * FROM login WHERE login = '".$donnees['auteur']."'";
			$reponseAuteur = $this->_db->query($sqlAuteur);
			while($donneesAuteur = $reponseAuteur->fetch())
			{
				$imageAuteur = $donneesAuteur['image'];
				if($imageAuteur == null)
				{
					$imageAuteur = "images/defaultAvatar.jpg";
				}
			}
			if($donnees['auteur'] == $_SESSION['login'])
			{
				$auteur = "AuteurMoi";
			}
			else
			{
				$auteur = "AuteurOther";
			}
			$tableauMessage[] = "<div class='author' style='background-image: url(".$imageAuteur.")'></div><div class='".$auteur." message'><div class='triangleMessage'></div><h6>Posté par ".$donnees['auteur']."<span class='date'> le ".date("d/m/Y à H:i", $donnees['date'])."</h6></h6>".$donnees['texte']."</div><br/>";
		}
		$tableauMessage = array_reverse($tableauMessage);
		$tableauMessage = implode(" ", $tableauMessage);
		echo $tableauMessage;
		echo "</div>";
	}
	
	public function storage()
	{
		$espaceLibre;
		$espaceTotal;
		$espaceUtilise;
		
	    $bytes = disk_free_space("."); 
	    $si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
	    $base = 1024;
	    $class = min((int)log($bytes , $base) , count($si_prefix) - 1);
	    echo "<input type='hidden' id='freeSpaceOctet' value='".$bytes."' />";
	    echo "<input type='hidden' id='freeSpace' value='".sprintf('%1.2f' , $bytes / pow($base,$class)) . ' ' . $si_prefix[$class] . "' />";
	    $espaceLibre = sprintf('%1.2f' , $bytes / pow($base,$class)) . ' ' . $si_prefix[$class];
	
		echo "<div class='row'><span class='ligneStorage col-sm-12'>Espace libre : <span class='green'>".$espaceLibre."</span>.</span></div>";

		
	    $bytes2 = disk_total_space("/");
	    //$bytes2 = $this->foldersize("");
	    //echo $bytes2; 
	    $si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
	    $base = 1024;
	    $class = min((int)log($bytes2 , $base) , count($si_prefix) - 1);
	    echo "<input type='hidden' id='TotalSpaceOctet' value='".$bytes2."' />";
	    echo "<input type='hidden' id='TotalSpaceGB' value='".sprintf('%1.2f' , $bytes2 / pow($base,$class)) . ' ' . $si_prefix[$class] . "' />";
	    
	    $espaceUtilise = sprintf('%1.2f' , $bytes2 / pow($base,$class)) - sprintf('%1.2f' , $bytes / pow($base,$class)). ' ' . $si_prefix[$class];
	    
	    $espaceTotal = sprintf('%1.2f' , $bytes2 / pow($base,$class)) . ' ' . $si_prefix[$class];
		echo "<div class='row'><span class='ligneStorage col-sm-12'>Espace total : <span class='green'>".$espaceTotal."</span>.</span></div>";
		echo "<div class='row'><span class='ligneStorage col-sm-12'>Espace utilisé : <span class='green'>".$espaceUtilise."</span>.</span></div>";
	}


}
?>

