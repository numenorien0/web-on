<?php
class Login extends DB
{
	private $_db;
	private $_connecte = false;

	public function __construct()
	{
		$this->_db = parent::__construct();

		if(isset($_POST['valider']) AND $_POST['valider'] == "Connexion")
		{
			if($this->verificationAvantLogin())
			{
				$this->login();
			}
		}

		if($_GET['f'] == "connexion.php")
		{
			$this->verificationPageConnexion();
			if($this->_connecte == true)
			{
				header("location: index.php");
			}
		}
	}

	public function verificationPageConnexion()
	{
		$trouve = false;
		if(isset($_COOKIE['weboncmslogin']) AND $_COOKIE['weboncmslogin'] != null)
		{
			$sql = "SELECT * FROM login";
			$reponse = $this->_db->prepare($sql);
			$reponse->execute();

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
				}
			}

			if($trouve == false)
			{
				$this->_connecte = false;
			}
		}
		else
		{
			$this->_connecte = false;
		}		
	}

	public function verificationConnecte()
	{
		if(!file_exists("db.conf"))
		{
			header("location: installation.php");
		}
		
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
				}
			}

			if($trouve == false)
			{
				header("location: connexion.php");
				echo "<script>window.location.href = 'connexion.php'</script>";
				$this->_connecte = false;
			}
		}
		else
		{
			header("location: connexion.php");
			echo "<script>window.location.href = 'connexion.php'</script>";
			$this->_connecte = false;
		}
	}

	public function verificationAvantLogin()
	{
		$sql = "SELECT * FROM systeme WHERE nom = 'security_force_brute'";
		$reponse = $this->_db->prepare($sql);
		$reponse->execute();
		while($donnees = $reponse->fetch())
		{
			$security = $donnees['valeur'];
		}

		if($security == "true")
		{
			$ip = $_SERVER['SERVER_ADDR'];
			$date = time();
			$nombreDeConnexion = 0;
			$derniereConnexion = 0;
			$tempsDeSecurite = 3600;

			$sql = "SELECT * FROM security_brute_force WHERE IP = :ip ORDER BY date ASC";
			$reponse = $this->_db->prepare($sql);
			$reponse->bindParam(':ip', $ip);
			$reponse->execute();

			$nombreDeConnexion = $reponse->rowCount();
			while($donnees = $reponse->fetch())
			{
				$derniereConnexion = $donnees['date'];
			}

			if($derniereConnexion > time() - $tempsDeSecurite AND $nombreDeConnexion >= 10)
			{
				exit("trop de connexion. rééssayez dans 1heure");
				return false;
			}
			else
			{
				if($derniereConnexion < time() - $tempsDeSecurite)
				{
					$sql = "DELETE FROM security_brute_force WHERE IP = :ip";
					$reponse = $this->_db->prepare($sql);
					$reponse->bindParam(':ip', $ip);
				}
				return true;
			}
		}
		else
		{
			return true;
		}
	}

	public function login()
	{
		$sql = "INSERT INTO security_brute_force VALUES('', :ip, :date_time)";
		$reponse = $this->_db->prepare($sql);
		$reponse->bindParam(':ip', $ip);
		$reponse->bindParam(':date_time', $date);
		$reponse->execute();

		$login = $_POST['login'];
		$password = hash("sha256", $_POST['password']);
		$trouve = false;
		$sql = "SELECT * FROM login";
		$reponse = $this->_db->prepare($sql);
		$reponse->execute();

		while($donnees = $reponse->fetch())
		{
			if($login == $donnees['login'] AND $password == $donnees['password'])
			{
				$trouve = true;
				$sql = "DELETE FROM security_brute_force WHERE IP = :ip";
				$reponse = $this->_db->prepare($sql);
				$reponse->bindParam(':ip',$ip);
				setcookie("weboncmslogin", $login."<-_->".$password, time()+365*3600*24, "/");
				header("location: index.php");
			} 
		}
	}
}
?>

