<?php
class Update extends DB
{
	private $_db;
	public $_skin;

	public function __construct()
	{
		$this->_db = parent::__construct();
		if(isset($_GET['updateDB']) AND $_GET['updateDB'] == "true")
		{
			$this->updateDB();
		}
		if(isset($_GET['getUpdate']) AND $_GET['getUpdate'] == "true")
		{
			$this->update();
		}
		
		$sql = "SELECT * FROM systeme WHERE nom = 'skin'";
		$reponse = $this->_db->query($sql);
		$reponse = $reponse->fetchAll()[0];
		echo "<input type='hidden' value='".$reponse['valeur']."' id='skin'/>";
		$this->_skin = $reponse['valeur'];
	}

	public function checkUpdate()
	{
		$fichierDeVersionGenerique = floatVal(file_get_contents("https://raw.githubusercontent.com/numenorien0/pilot/master/CMS/version.txt"));
		//exit($fichierDeVersionGenerique);
		$fichierDeNotreVersion = floatVal(file_get_contents("version.txt"));
		if($fichierDeNotreVersion < $fichierDeVersionGenerique)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function update()
	{
		$source = "https://github.com/numenorien0/pilot/archive/master.zip";
		$destination = "pilot.zip";
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
		$res = $zip->open('pilot.zip');
		if ($res === TRUE) {
		  $zip->extractTo("extract_path");
		  $zip->close();
		  $this->copy_dir("extract_path/pilot-master/", "../");
		  unlink("pilot.zip");
		  $this->effacer("extract_path");
			#header("location: update.php?updateDB=true");
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
					if(is_dir($dir2copy.$file) && $file != '..'  && $file != '.' && $file != "themes" && $file != "content" && $file != "analytics" && $file != "plugins") $this->copy_dir( $dir2copy.$file.'/' , $dir_paste.$file.'/' );     
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
	
	public function updateDB()
	{
		header("location: options.php");
	}
 
}
?>

