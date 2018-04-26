<?php
class Outils extends DB
{
	private $_db;
	private $_count = 0;
	private $_advanced;

	public function __construct()
	{
		$this->_db = parent::__construct();
		if(isset($_GET['update']) AND $_GET['update'] != null)
		{
			$this->update($_GET['update']);
		}
	}

	public function update($plugin)
	{
		$fichierXML = file_get_contents("plugins/".$plugin."/infos/".$plugin.".xml");
		$elementAAfficher = new SimpleXMLElement($fichierXML);
		$source = $elementAAfficher->downloadVersionAt;
		$destination = "$plugin.zip";
		if(copy($source, $destination))
		{
			//exit("ok");
		}
		else
		{
			//exit("pas ok");
		}
		
		mkdir("extract_path");
		$zip = new ZipArchive;
		$res = $zip->open("$plugin.zip");
		if ($res === TRUE) {
		  $zip->extractTo("extract_path");
		  $zip->close();
		  $this->copy_dir("extract_path/$plugin-master/", "plugins/$plugin/");
		  unlink("$plugin.zip");
		  $this->effacer("extract_path");
			header("location: outils.php");
		} else {
			echo "erreur";
		}
		// $elementATelecharger = fopen("http://www.web-on.be/update.zip", "r");
		// $elementACreerALaRacine = fopen("update.zip", "w+");
		// fwrite($elementACreerALaRacine, $elementATelecharger);
	}

	public function copy_dir($dir2copy,$dir_paste) {
		// On vérifie si $dir2copy est un dossier
		if (is_dir($dir2copy)) {

		// Si oui, on l'ouvre
			if ($dh = opendir($dir2copy)) {     
			// On liste les dossiers et fichiers de $dir2copy
				while (($file = readdir($dh)) !== false) {
				// Si le dossier dans lequel on veut coller n'existe pas, on le créé
					if (!is_dir($dir_paste)) mkdir ($dir_paste, 0777);

				// S'il s'agit d'un dossier, on relance la fonction rÃ©cursive
					if(is_dir($dir2copy.$file) && $file != '..'  && $file != '.' && $file != "content" && $file != "analytics" && $file != "plugins") $this->copy_dir( $dir2copy.$file.'/' , $dir_paste.$file.'/' );     
				// S'il sagit d'un fichier, on le copue simplement
					elseif($file != '..'  && $file != '.' && $file != "db.conf" && $file != "domaines.conf") copy ( $dir2copy.$file , $dir_paste.$file );                                       
				}

			// On ferme $dir2copy
			closedir($dh);
			}
		}
	}

	public function effacer($fichier) {
		if (file_exists($fichier)) {
			if (is_dir($fichier)) {
				$id_dossier = opendir($fichier); 
				while($element = readdir($id_dossier)) {
		       		if ($element != "." && $element != "..") {
		       			$this->effacer($fichier."/".$element);
					}
		   		}
		   		closedir($id_dossier);
		   		rmdir($fichier);
		   	} else {
				unlink($fichier);
			}
		}
	}

	public function listAllPlugins()
	{
		$liste = scandir("plugins");
		foreach($liste as $vue)
		{
			if($vue != "." AND $vue != ".." AND $vue != "get_started")
			{
				$this->_count++;
				$fichier = str_replace(".php", "", $vue);
				$fichierXML = str_replace(".php", "", $vue).".xml";
				if(file_exists("plugins/".$vue."/infos/".$fichierXML))
				{
					$fichierXML = file_get_contents("plugins/".$vue."/infos/".$fichierXML);
					$elementAAfficher = new SimpleXMLElement($fichierXML);
					$nom = $elementAAfficher->name;
					$version = $elementAAfficher->version;
					if(!$version)
					{
						$version = "1.0";
					}
					$new_version = file_get_contents($elementAAfficher->checkVersionAt);
					//echo $version.$new_version."<br/>";
					if(floatval($version) < floatval($new_version))
					{
						$update = "<a href='?update=$vue'>Mise à jour disponible !</a>";
					}
					else
					{
						$update = "Version $version";
					}
					#print_r($elementAAfficher);
					#echo "<br/><br/><br/>";
					$page = $elementAAfficher->pages->page;
					
					$icone = "plugins/".$vue."/images/".$elementAAfficher->icone;
					$description = $elementAAfficher->description;

					
					if($elementAAfficher->state != "disabled")
					{
						echo "<div class='col-sm-3 toolsPadding'><div class='cadre col-md-12'>";
						echo "<div class='iconeAppContainer' style='background-image: url($icone)'></div>";
						echo "
									<a class='tools' href='?tools=".$vue."&page=".$page."'>
										<div style='padding: 0px' class=' col-sm-12'>";
						
						echo "<h3 class='appName'>".$nom."</h3>";
						echo "<p class='notYet'>".$description."</p></a>";
						echo "<p style='text-align: center'>$update</p>";
						echo "</div></div></div>";
					}
					else
					{
						$this->_count--;
					}
				}
			}
		}

		if($this->_count == 0)
		{
			echo "<div class='col-sm-12 oops'>Oops!</div><div class='col-sm-12 explicationsOops'>Pas encore de plugin</div>";				
		}

		$vue = "get_started";
		//$fichier = str_replace(".php", "", $vue);
		$fichierXML = $vue.".xml";
		if(file_exists("plugins/".$vue."/infos/".$fichierXML))
		{
			$fichierXML = file_get_contents("plugins/".$vue."/infos/".$fichierXML);
			$elementAAfficher = new SimpleXMLElement($fichierXML);
			$nom = $elementAAfficher->name;
			$description = $elementAAfficher->description;
			
			#echo "<a class='toolsTuto' href='?tools=".$vue."'><div class='cadre col-sm-12'>";
			#echo "<h3>".$nom."</h3>";
			#echo "<p class='notYet2'>".$description."</p>";
			#echo "</div></a>";
		}
		$this->advancedMod();
		
		if($this->_advanced == "true")
		{
			echo "
			<div class='col-sm-12' id='dropfile'>
				<div class='col-sm-12 explicationUpload'>Glissez pour installer un module</div>
			</div>";
		}
	}
	
	public function advancedMod()
	{
		$sql = "SELECT * FROM systeme WHERE nom = 'advanced_mod'";
		$reponse = $this->_db->query($sql);

		while($donnees = $reponse->fetch())
		{
			$this->_advanced = $donnees['valeur'];
		}
	}
}
?>

