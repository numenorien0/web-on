<?php
class Install
{
	private $_db;

	public function __construct()
	{
		if(isset($_POST['install']))
		{
			$this->verificationLogin();
		}
	}

	public function detectInstallation()
	{
		if(!file_exists("db.conf"))
		{
			header("location: installation.php");
		}
	}

	public function verificationLogin()
	{
		$erreur = 0;
		if($_POST['defaultUser'] == null)
		{
			$erreur++;
			echo "<div class='fail'>Merci de remplir un login par défaut</div>";
		}
		if($_POST['defaultPassword'] == null)
		{
			$erreur++;
			echo "<div class='fail'>Merci de remplir un mot de passe</div>";
		}
		if($_POST['defaultPasswordConfirm'] == null)
		{
			$erreur++;
			echo "<div class='fail'>Merci de confirmer votre mot de passe</div>";
		}

		if($_POST['defaultPassword'] != $_POST['defaultPasswordConfirm'])
		{
			$erreur++;
			echo "<div class='fail'>Les mots de passe sont différents</div>";
		}

		if($erreur == 0)
		{
			$this->verification();
		}
	}

	public function verification()
	{
		if(isset($_POST['create']) AND $_POST['create'] != "")
		{
			$dsn = "mysql:host=".$_POST['emplacement'].";charset=utf8";
		}
		else
		{
			$dsn = "mysql:dbname=".$_POST['dbname'].";host=".$_POST['emplacement'].";charset=utf8";
		}
		$login = $_POST["user"];
		$password = $_POST["password"];
		$nom = $_POST['dbname'];

		$user = $_POST['defaultUser'];
		$passwd = $_POST['defaultPassword'];

		try 
		{
            $this->_db = new PDO($dsn, $login, $password);

            if(isset($_POST['create']) AND $_POST['create'] != "")
            {
            	$sql = "CREATE DATABASE IF NOT EXISTS `$nom`";
				$reponse = $this->_db->exec($sql);

				$dsn = "mysql:dbname=".$nom.";host=".$_POST['emplacement'].";charset=utf8";
				$login = $_POST["user"];
				$password = $_POST["password"];
				$this->_db = new PDO($dsn, $login, $password);
            }


            	$sql = "CREATE TABLE IF NOT EXISTS `contenu` (
						`ID` bigint(20) unsigned AUTO_INCREMENT PRIMARY KEY,
						`nom` varchar(255) NOT NULL,
						`description` text NOT NULL,
						`texte` text NOT NULL,
						`parent` varchar(255) NOT NULL,
						`child` varchar(255) NOT NULL,
						`auteur` varchar(255) NOT NULL,
						`date` varchar(255) NOT NULL,
						`online` varchar(255) NOT NULL,
						`commentaire` varchar(255) NOT NULL,
						`important` varchar(255) NOT NULL,
						`image` varchar(255) NOT NULL,
						`medias` varchar(255) NOT NULL,
						`update_auteur` varchar(255) NOT NULL,
						`update_date` varchar(255) NOT NULL,
						`autorisations` text NOT NULL,
						`keywords` text NOT NULL,
						`orderID` bigint(20) unsigned NOT NULL,
						`champsPerso` text NOT NULL,
						`nameURL` varchar(255) NOT NULL,
						`copyOf` varchar(255) NOT NULL,
						`homepage` varchar(255) NOT NULL,
						`display` varchar(255) NOT NULL,
						`miniatures` varchar(255) NOT NULL,
						`SEO_description` varchar(255) NOT NULL,
						`lien` varchar(255) NOT NULL,
						`style` text NOT NULL,
						`baseMiniature` VARCHAR(255) NOT NULL, 
						`baseStyle` TEXT NOT NULL
						)";

				$reponse = $this->_db->exec($sql);
				
				
            	$sql = "CREATE TABLE IF NOT EXISTS `contenu_traduction` (
						`ID` bigint(20) unsigned AUTO_INCREMENT PRIMARY KEY,
						`nom` varchar(255) NOT NULL,
						`description` text NOT NULL,
						`texte` longtext NOT NULL,
						`champsPerso` text NOT NULL,
						`contenu` varchar(255) NOT NULL,
						`langue` varchar(255) NOT NULL,
						`SEO_description` varchar(255) NOT NULL,
						`lien` varchar(255) NOT NULL						
						)";

				$reponse = $this->_db->exec($sql);
				
            	$sql = "CREATE TABLE IF NOT EXISTS `contenu_recovery` (
						`ID` bigint(20) unsigned AUTO_INCREMENT PRIMARY KEY,
						`page` varchar(255) NOT NULL,
						`contenu` longtext NOT NULL,
						`auteur` varchar(255) NOT NULL,
						`date` varchar(255) NOT NULL					
						)";

				$reponse = $this->_db->exec($sql);

				$sql = "CREATE TABLE IF NOT EXISTS `login` (
					  `ID` int(10) unsigned AUTO_INCREMENT PRIMARY KEY,
					  `login` varchar(255) NOT NULL,
					  `password` varchar(255) NOT NULL,
					  `connexion` varchar(255) NOT NULL,
					  `email` varchar(255) NOT NULL,
					  `image` varchar(255) NOT NULL,
					  `twitter` varchar(255) NOT NULL,
					  `nom` varchar(255) NOT NULL,
					  `prenom` varchar(255) NOT NULL,
					  `fonction` varchar(255) NOT NULL,
					  `description` text NOT NULL,
					  `rang` varchar(255) NOT NULL
					)";

				$reponse = $this->_db->exec($sql);

				$passwd = hash("sha256", $passwd);
				$sql = "INSERT INTO login VALUES ('','$user','$passwd','','','','','','','','','administrateur')";

				$reponse = $this->_db->exec($sql);

				$sql = "CREATE TABLE IF NOT EXISTS `medias` (
					  `ID` bigint(20) unsigned AUTO_INCREMENT PRIMARY KEY,
					  `nom` varchar(255) NOT NULL,
					  `description` text NOT NULL,
					  `auteur` varchar(255) NOT NULL,
					  `date` varchar(255) NOT NULL,
					  `image` varchar(255) NOT NULL,
					  `type` varchar(255) NOT NULL,
					  `fichier` varchar(255) NOT NULL,
					  `url` text NOT NULL, 
					  `display` varchar(255) NOT NULL
					)";

				$reponse = $this->_db->exec($sql);

				$sql = "CREATE TABLE IF NOT EXISTS `message` (
					  `ID` bigint(20) unsigned AUTO_INCREMENT PRIMARY KEY,
					  `texte` text NOT NULL,
					  `auteur` varchar(255) NOT NULL,
					  `date` varchar(255) NOT NULL
					)";

				$reponse = $this->_db->exec($sql);

				$sql = "CREATE TABLE IF NOT EXISTS `photos` (
						  `ID` bigint(20) AUTO_INCREMENT PRIMARY KEY,
						  `nom` varchar(255) NOT NULL,
						  `description` text NOT NULL,
						  `fichier` varchar(255) NOT NULL,
						  `album` bigint(20) NOT NULL
						)";
				

				$reponse = $this->_db->exec($sql);

                $sql = "CREATE TABLE `images` (
                          `ID` bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                          `nom` varchar(255) NOT NULL,
                          `description` text NOT NULL,
                          `resolution` varchar(255) NOT NULL,
                          `time` varchar(255) NOT NULL,
                          `auteur` varchar(255) NOT NULL,
                          `parent` varchar(255) NOT NULL,
                          `file` varchar(255) NOT NULL,
                          `type` varchar(255) NOT NULL,
                          `alt` varchar(255) NOT NULL
                        )";
                $reponse = $this->_db->query($sql);
                
                $sql = "CREATE TABLE `log_system` (
                      `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
                      `auteur` varchar(255) NOT NULL,
                      `action` text NOT NULL,
                      `date` varchar(255) NOT NULL";
                
                $reponse = $this->_db->query($sql);
                
				$sql = "CREATE TABLE IF NOT EXISTS `security_brute_force` (
						  `ID` bigint(20) unsigned AUTO_INCREMENT PRIMARY KEY,
						  `IP` varchar(255) NOT NULL,
						  `date` varchar(255) NOT NULL
						)";
				$reponse = $this->_db->exec($sql);
				$sql = "CREATE TABLE IF NOT EXISTS `systeme` (
						  `ID` int(10) unsigned AUTO_INCREMENT PRIMARY KEY,
						  `nom` varchar(255) NOT NULL,
						  `valeur` varchar(255) NOT NULL
						)";
            	$reponse = $this->_db->exec($sql);
				
				$sql = "CREATE TABLE IF NOT EXISTS `contenu_perso` (
					  `ID` int(10) unsigned AUTO_INCREMENT PRIMARY KEY,
					  `label` varchar(255) NOT NULL,
					  `valeur` varchar(255) NOT NULL,
					  `page` varchar(255) NOT NULL	  
					)";
					
				$reponse = $this->_db->query($sql);
				
				
            	$sql = "INSERT INTO systeme VALUES ('','maintenance','false')";
            	$reponse = $this->_db->exec($sql);
            	$sql = "INSERT INTO systeme VALUES ('','security_force_brute','true')";
            	$reponse = $this->_db->exec($sql);
            	$sql = "INSERT INTO systeme VALUES ('','advanced_mod','true')";
            	$reponse = $this->_db->exec($sql);
            	$sql = "INSERT INTO systeme VALUES ('','domaine','".$_SERVER['HTTP_HOST']."')";
            	$reponse = $this->_db->exec($sql);
            	$sql = "INSERT INTO systeme VALUES ('','langue_principale','fr')";
            	$reponse = $this->_db->exec($sql);
            	$sql = "INSERT INTO systeme VALUES ('','titre','')";
            	$reponse = $this->_db->exec($sql);
				$sql = "INSERT INTO systeme VALUES ('','social','')";
            	$reponse = $this->_db->exec($sql);
            	$sql = "INSERT INTO systeme VALUES ('','skin','default')";
            	$reponse = $this->_db->exec($sql);
            	$sql = "INSERT INTO systeme VALUES ('','ecommerce','off')";
            	$reponse = $this->_db->exec($sql);
            	






            	
            	//unlink("db.conf");
            	$fichierDB = $nom."\n".$_POST['emplacement']."\n"."utf8"."\n".$_POST['user']."\n".$_POST['password'];
            	file_put_contents("db.conf", $fichierDB);
            	header("location: index.php");


        }
        catch(PDOException $e)
        {
        	echo "<div class='fail'>Erreur de connexion à la base de données.</div>";
        }


	}
}
?>

