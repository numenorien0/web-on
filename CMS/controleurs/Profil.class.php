<?php
class Profil extends DB
{
	private $_db;
	private $_image;
	private $_nom;
	private $_prenom;
	private $_email;
	private $_twitter;
	private $_login;
	private $_description;
	private $_fonction;

	public function __construct()
	{
		$this->_db = parent::__construct();
	}

	public function changePassword()
	{
		if(isset($_POST["changePassword"]))
		{
			$erreur = 0;
			$old = $_POST['passwordOld'];
			$new = $_POST['password'];
			$newConfirm = $_POST['passwordConfirm'];

			if($old == null)
			{
				$erreur++;
				echo "<div class='fail'>Merci de renseigner votre mot de passe actuel</div>";
			}
			else
			{
				$motDePasseCrypte = hash("sha256", $old);
				$sql = "SELECT * FROM login WHERE password = '$motDePasseCrypte'";
				$reponse = $this->_db->query($sql);

				if($reponse->rowCount() == 0)
				{
					$erreur++;
					echo "<div class='fail'>Votre mot de passe actuel n'est pas bon</div>";
				}
			}
			if($new == null)
			{
				$erreur++;
				echo "<div class='fail'>Merci de renseigner un nouveau mot de passe</div>";
			}
			if($newConfirm == null)
			{
				$erreur++;
				echo "<div class='fail'>Merci de confirmer votre nouveau mot de passe</div>";
			}
			if($newConfirm != $new)
			{
				$erreur++;
				echo "<div class='fail'>Les deux mot de passe ne correspondent pas.</div>";
			}

			if($erreur == 0)
			{
				$nouveauMotDePasse = hash("sha256", $new);
				$login = explode("<-_->", $_COOKIE['weboncmslogin']);
				$login = $login[0];
				$sql = "UPDATE login SET password = '$nouveauMotDePasse' WHERE login = '$login'";
				$reponse = $this->_db->exec($sql);
				echo "<div class='success'>Le mot de passe a été modifié avec succès</div>";
			}
		}
	}

	public function readDB()
	{
		$sql = "SELECT * FROM login WHERE login = '".$_SESSION['login']."'";
		$reponse = $this->_db->query($sql);

		while($donnees = $reponse->fetch())
		{
			$this->_nom = stripslashes(htmlspecialchars($donnees['nom'], ENT_QUOTES));
			$this->_prenom = stripslashes(htmlspecialchars($donnees['prenom'], ENT_QUOTES));
			$this->_image = $donnees['image'];
			$this->_twitter = stripslashes(htmlspecialchars($donnees['twitter'], ENT_QUOTES));
			$this->_login = stripslashes(htmlspecialchars($donnees['login'], ENT_QUOTES));
			$this->_email = stripslashes(htmlspecialchars($donnees['email'], ENT_QUOTES));
			$this->_description = stripslashes(htmlspecialchars($donnees['description'], ENT_QUOTES));
			$this->_fonction = stripslashes(htmlspecialchars($donnees['fonction'], ENT_QUOTES));

			if($this->_image == "")
			{
				$this->_image = "images/defaultAvatar.jpg";
			}
		}
	}

	public function formatageFile($texte)
	{
		$accent='ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËéèêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ';
		$noaccent='aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn';
		$texte = strtr($texte,$accent,$noaccent);
		$texte = str_replace(" ","_",$texte);

		$texte = preg_replace('/([^.a-z0-9]+)/i', '-', $texte);
		$texte = time().$texte;
		
		return $texte;
	}

	public function update()
	{
		if(isset($_POST['update']))
		{
			$this->_nom = str_replace("'", "''", $_POST['nom']);
			$this->_prenom = str_replace("'", "''", $_POST['prenom']);
			$this->_email = str_replace("'", "''", $_POST['email']);
			$this->_twitter = str_replace("'", "''", $_POST['twitter']);
			$this->_fonction = str_replace("'", "''", $_POST['fonction']);
			$this->_description = str_replace("'", "''", $_POST['description']);
			
			if(isset($_FILES['fichier']['name']) AND $_FILES['fichier']['name'] != "")
			{
				$sql2 = "SELECT * FROM login WHERE login = '".$_SESSION['login']."'";
				$reponse2 = $this->_db->query($sql2);
				while($donnees = $reponse2->fetch())
				{
					@unlink($donnees['image']);
				}
				$fichierFormate = "content/images/".$this->formatageFile($_FILES['fichier']['name']);
				move_uploaded_file($_FILES['fichier']['tmp_name'], $fichierFormate);
				$sql = "UPDATE login SET nom = '".$this->_nom."', prenom = '".$this->_prenom."', email = '".$this->_email."', twitter = '".$this->_twitter."', image = '".$fichierFormate."', fonction = '".$this->_fonction."', description = '".$this->_description."' WHERE login = '".$_SESSION['login']."'";
			}
			else
			{
				$sql = "UPDATE login SET nom = '".$this->_nom."', prenom = '".$this->_prenom."', email = '".$this->_email."', twitter = '".$this->_twitter."', fonction = '".$this->_fonction."', description = '".$this->_description."' WHERE login = '".$_SESSION['login']."'";
			}

			$reponse = $this->_db->query($sql);

			echo "<div class='success'>Profil édité avec succès</div>";
		}
	}

	public function profil()
	{
		$this->update();
		$this->readDB();
		echo "<form method='POST' action enctype='multipart/form-data'>";
		echo "<div class='col-sm-12'><div id='avatar' style='background-image: url(\"".$this->_image."\")'></div></div>";
		echo "<div class='col-sm-12' style='text-align: center'><label for='file' class='col-sm-4'>Changer</label><input type='button' class='col-sm-4' value='Parcourir' id='file_btn'/><input name='fichier' id='file' type='file'></div>";
		echo "<div class='col-sm-12'><label for='login' class='col-sm-4'>Identifiant</label><span class='login col-sm-6'>".$this->_login."</span></div>";
		echo "<div class='col-sm-12'><label for='nom' class='col-sm-4'>Nom</label><input class='col-sm-6' type='text' value='".$this->_nom."' name='nom'/></div>";
		echo "<div class='col-sm-12'><label for='prenom' class='col-sm-4'>Prénom</label><input class='col-sm-6' type='text' value='".$this->_prenom."' name='prenom'/></div>";
		echo "<div class='col-sm-12'><label for='email' class='col-sm-4'>E-mail</label><input class='col-sm-6' type='email' value='".$this->_email."' name='email'/></div>";
		echo "<div class='col-sm-12'><label for='twitter' class='col-sm-4'>Twitter</label><input class='col-sm-6' type='text' value='".$this->_twitter."' name='twitter'/></div>";
		echo "<div class='col-sm-12'><label for='fonction' class='col-sm-4'>Fonction</label><input class='col-sm-6' type='text' value='".$this->_fonction."' name='fonction'/></div>";
		echo "<div class='col-sm-12'><label for='description' class='col-sm-4'>Description</label><textarea class='col-sm-6' name='description' placeholder='Un petit mot sur vous?'>".$this->_description."</textarea></div>";
		echo "<div class='col-sm-12'><br/><input type='submit' class='col-sm-4 col-sm-offset-4' value='Mettre à jour' name='update'/></div>";
		echo "</form>";
	}
}
?>

