<?php
class Options extends DB
{
	private $_db;
	public $_btnAddUser;
	public $_disabled;

	public function __construct()
	{
		$this->_db = parent::__construct();
		if(parent::is_admin())
		{
			$this->_btnAddUser = "<input type='submit' class='col-lg-2 col-lg-offset-5 col-sm-6 col-sm-offset-3' name='nouvelUtilisateur' value='Valider'/>";
			$this->_disabled = "";
		}
		else
		{
			$this->_btnAddUser = "<input type='submit' disabled='disabled' class='col-lg-2 col-lg-offset-5 col-sm-6 col-sm-offset-3' name='nouvelUtilisateur' value='Valider'/>";
			$this->_disabled = "disabled='disabled'";
		}
	}

	public function ReadStateMaintenance()
	{
		if(isset($_POST['maintenance']))
		{
			$this->changeMaintenance();
		}

		$sql = "SELECT * FROM systeme WHERE nom = 'maintenance'";
		$reponse = $this->_db->query($sql);

		while($donnees = $reponse->fetch())
		{
			if($donnees['valeur'] == "false")
			{
				echo "<input type='hidden' value='false' name='valeur'>";
				echo "<div class='success' style='padding-top: 12px'>Votre site est actuellement en ligne</div>";
			}
			else
			{
				echo "<input type='hidden' value='true' name='valeur'>";
				echo "<div class='fail' style='padding-top: 12px'>Votre site est actuellement en maintenance</div>";
			}
		}
	}

	public function social()
	{
		if(isset($_POST['socialSubmit']))
		{
			//print_r($_POST);
			$social = json_encode($_POST['social']);
			//echo $social;
			$sql = "UPDATE systeme SET valeur = '$social' WHERE nom = 'social'";
			//echo $sql;
			$reponse = $this->_db->exec($sql);
		}
		
		$sql = "SELECT * FROM systeme WHERE nom = 'social'";
		$reponse = $this->_db->query($sql);
		
		while($donnees = $reponse->fetch())
		{
			$social = json_decode($donnees['valeur'], true);
		}
		
		echo "<label for='facebook'><img class='socialIcon' src='images/social/facebook.png'/>&nbsp&nbsp&nbsp</label><input type='text' class='urlSocial' name=\"social[facebook]\" value='".$social['facebook']."' placeholder='url de votre page facebook'><br/>";
		echo "<label for='twitter'><img class='socialIcon' src='images/social/twitter.png'/>&nbsp&nbsp&nbsp</label><input type='text' class='urlSocial' name=\"social[twitter]\" value='".$social['twitter']."' placeholder='url de votre page twitter'><br/>";
		echo "<label for='instagram'><img class='socialIcon' src='images/social/instagram.png'/>&nbsp&nbsp&nbsp</label><input type='text' class='urlSocial' name=\"social[instagram]\" value='".$social['instagram']."' placeholder='url de votre page instagram'><br/>";
		echo "<label for='Google plus'><img class='socialIcon' src='images/social/gplus.png'/>&nbsp&nbsp&nbsp</label><input type='text' class='urlSocial' name=\"social[gplus]\" value='".$social['gplus']."' placeholder='url de votre page Google plus'><br/>";
		echo "<label for='Linkedin'><img class='socialIcon' src='images/social/linkedin.png'/>&nbsp&nbsp&nbsp</label><input type='text' class='urlSocial' name=\"social[linkedin]\" value='".$social['linkedin']."' placeholder='url de votre page linkedin'><br/>";
		echo "<label for='Pinterest'><img class='socialIcon' src='images/social/pinterest.png'/>&nbsp&nbsp&nbsp</label><input type='text' class='urlSocial' name=\"social[Pinterest]\" value='".$social['Pinterest']."' placeholder='url de votre page Pinterest'><br/>";
		
		
	}

	public function titre()
	{
		if(isset($_POST['titreSubmit']))
		{
			$titre = str_replace("'", "''", $_POST['titre']);
			$sql = "UPDATE systeme SET valeur = '".$titre."' WHERE nom = 'titre'";
			$reponse = $this->_db->exec($sql);
		}
		$sql = "SELECT * FROM systeme WHERE nom = 'titre'";
		$reponse = $this->_db->query($sql);
		
		while($donnees = $reponse->fetch())
		{
			echo "<label for='titre'>Titre du site web</label>&nbsp&nbsp<input type='text' name='titre' value='".$donnees['valeur']."'/>";
		}
		
		
	}

	public function logo()
	{
		if(!file_exists("content/logo"))
		{
			mkdir("content/logo");
		}
		
		if(isset($_POST['logo']) AND $_POST['logo'] == "Changer" AND $_FILES['file']['name'] != "")
		{
			$file = $_FILES['file']['name'];
			$file_tmp = $_FILES['file']['tmp_name'];
			$logo = glob("content/logo/logo.*");
			$ext = end((explode(".", $file)));
			
			@unlink($logo[0]);
			
			move_uploaded_file($file_tmp, "content/logo/logo.".$ext);
		}
		$logo = glob("content/logo/logo.*");
		if(file_exists($logo[0]))
		{
			echo "<img src='".$logo[0]."?v=".time()."' style='max-width: 100%; max-height: 400px'>";
		}
		echo "<div class='row'><input type='file' id='realButtonLogo' style='display: none;' name='file'/><input value='Choisir' type='button' id='fakeButtonLogo'/></div>";
	}

	public function favicon()
	{
		if(!file_exists("content/logo"))
		{
			mkdir("content/logo");
		}
		
		if(isset($_POST['favicon']) AND $_POST['favicon'] == "Changer" AND $_FILES['file']['name'] != "")
		{
			$file = $_FILES['file']['name'];
			$file_tmp = $_FILES['file']['tmp_name'];
			$logo = glob("content/logo/favicon.*");
			$ext = end((explode(".", $file)));
			
			@unlink($logo[0]);
			
			move_uploaded_file($file_tmp, "content/logo/favicon.".$ext);
		}
		$logo = glob("content/logo/favicon.*");
		if(file_exists($logo[0]))
		{
			echo "<img src='".$logo[0]."' style='max-width: 100%; max-height: 400px'>";
		}
		echo "<div class='row'><input type='file' id='realButtonFavicon' style='display: none;' name='file'/><input value='Choisir' type='button' id='fakeButtonFavicon'/></div>";
	}

	public function listFeature()
	{
		
		echo "<h6>Liste des nouveautés de la version ".$_SESSION['version']."</h6>";
		$fichier = file_get_contents("whatnews.txt");
		$fichier = str_replace("\n", "<br/>", $fichier);
		
		echo $fichier;
	}

	public function domaine()
	{
		if(isset($_POST['domaine']))
		{
			$domaine = str_replace("www.", "", $_POST['addDomain']);
			$domaine = str_replace("http://", "", $domaine);
			
			$sqlVerif = "SELECT * FROM systeme WHERE nom = 'domaine' AND valeur = '".$domaine."'";
			$reponseVerif = $this->_db->query($sqlVerif);
			if($reponseVerif->rowCount() == 0)
			{
				$sql = "INSERT INTO systeme VALUES('','domaine','".$domaine."')";
				$reponse = $this->_db->query($sql);
			}
			else
			{
				echo "<div class='fail'>Le nom de domaine que vous avez ajouté existe déjà</div>";
			}
		}
		if(isset($_GET['deleteDomaine']))
		{
			$sql = "SELECT * FROM systeme WHERE ID = ".$_GET['deleteDomaine'];
			$reponse = $this->_db->query($sql);
			
			while($donnees = $reponse->fetch())
			{
				if($donnees['valeur'] == $_SERVER['HTTP_HOST'])
				{
					echo "<div class='fail'>Impossible de supprimer le nom de domaine du CMS</div>";
				}
				else
				{
					$sqlDelete = "DELETE FROM systeme WHERE ID = ".$_GET['deleteDomaine'];
					$reponseDelete = $this->_db->query($sqlDelete);	
				}
			}		
		}
		$sql = "SELECT * FROM systeme WHERE nom = 'domaine'";
		$reponse = $this->_db->query($sql);
		
		if($reponse->rowCount() == 0)
		{
			$sql2 = "INSERT INTO systeme VALUES('','domaine','".$_SERVER['HTTP_HOST']."')";
			$reponse2 = $this->_db->exec($sql2);
		}
		
		$sql = "SELECT * FROM systeme WHERE nom = 'domaine'";
		$reponse = $this->_db->query($sql);
		
		while($donnees = $reponse->fetch())
		{
			if(parent::is_admin())
			{
				$deleteDomain = "<span data-id='".$donnees['ID']."' class='deleteDomaine pull-right col-sm-2 delete'>Supprimer</span>";
			}
			else
			{
				
			}
			echo "<div class='ligne col-sm-12'><span class='col-sm-10 domaine'>".$donnees['valeur']."</span>$deleteDomain</div>";
		}
		
	}

	public function changeMaintenance()
	{
		if($_POST['valeur'] == "false")
		{
			$sql = "UPDATE systeme SET valeur = 'true' WHERE nom = 'maintenance'";
		}
		else
		{
			$sql = "UPDATE systeme SET valeur = 'false' WHERE nom = 'maintenance'";
		}

		$reponse = $this->_db->exec($sql);
		
	}

	public function deleteUser()
	{
		if(isset($_GET['deleteAccount']))
		{
			$name = $_GET['deleteAccount'];
			$erreur = 0;

			$sql = "SELECT * FROM login where login = '$name'";
			$reponse = $this->_db->query($sql);
			if($reponse->rowCount() == 0)
			{
				$erreur++;
				echo "<div class='fail'>L'utilisateur renseigné n'existe pas</div>";
			}
			else
			{
				while($donnees = $reponse->fetch())
				{
					if($donnees['login'] == "root")
					{
						$erreur++;
						echo "<div class='fail'>Impossible de supprimer l'utilisateur 'root'</div>";
					}
				}
			}
			if($erreur == 0)
			{
				$sql = "DELETE FROM login WHERE login = '$name'";
				$reponse = $this->_db->query($sql);
				echo "<div class='success'>L'utilisateur a été supprimé avec succès</div>";
			}
		}
		if(isset($_GET['changeUser']))
		{
			$user = $_GET['changeUser'];
			$rang = $_GET['rang'];
			
			$sql = "UPDATE login SET rang = '$rang' WHERE ID = $user";
			$reponse = $this->_db->query($sql);
			
			echo "<div class='success'>L'utilisateur a été modifié.</div>";
			
		}
		$sql = "SELECT * FROM login";
		$reponse = $this->_db->query($sql);
		
		echo "<table style='width: 100%;'>";
		echo "<thead><tr><td>Login</td><td>Prénom</td><td>Nom</td><td>Rang</td><td>Action</td></tr></thead>";
		echo "<tbody>";
		while($donnees = $reponse->fetch())
		{
			if($donnees['rang'] == "administrateur")
			{
				$switch = "redacteur";
			}
			else
			{
				$switch = "administrateur";
			}
			if(parent::is_admin())
			{
				$action = "<a href='?deleteAccount=".$donnees['login']."'>Supprimer</a><br/><a href='?changeUser=".$donnees['ID']."&rang=$switch'>Mettre $switch</a>";
			}
			else
			{
				$action = "limité";
			}
			echo "<tr><td>".$donnees['login']."</td><td>".$donnees['prenom']."</td><td>".$donnees['nom']."</td><td>".$donnees['rang']."</td><td class='action'>".$action."</td></tr>";
		}
		echo "</tbody>";
		echo "</table>";
		
	}

	public function updateFacturation()
	{
		if(isset($_POST['updateFacturation']))
		{
			
		}
	}

	public function curlData()
	{
		$postData = array("key" => "AZERTYUIO", "HOST" => str_replace("www.", "", $_SERVER['HTTP_HOST']));
		$ch = curl_init();
		curl_setopt_array($ch, array(
		    CURLOPT_URL => 'http://www.ohmedias.com/CMS/plugins/CMS_Manager/vues/lireStat.php',
		    CURLOPT_RETURNTRANSFER => true,
		    CURLOPT_POST => true,
		    CURLOPT_POSTFIELDS => $postData,
		    CURLOPT_FOLLOWLOCATION => true
		));
		
		$output = curl_exec($ch);
		return $output;
	}

	public function displayFacturation()
	{
		
		$fichier = $this->curlData();
		$fichier = json_decode($fichier, true);
		
// 		echo $fichier;
//print_r($fichier);
		//foreach($fichier as $cms)
		//{
			//echo $_SERVER['HTTP_HOST'];
			if($fichier["url"] == str_replace("www.", "" ,$_SERVER['HTTP_HOST']))
			{
				$user = $fichier;
			}
		//}
		
		if($user == "")
		{
			$nom = "";
			$email = "";
			$TVA = "";
			$adresse = "";
			$code_postal = "";
			$ville = "";
			$pays = "";
		}
		else
		{
			$nom = $user['nom'];
			$email = $user['email'];
			$TVA = $user['TVA'];
			$adresse = $user['adresse'];
			$code_postal = $user['code_postal'];
			$ville = $user['ville'];
			$pays = $user['pays'];			
		}
		
		echo "<input type='hidden' name='host' value='".str_replace("www.", "", $_SERVER['HTTP_HOST'])."'/>";
		echo "<div class='row'><label class='col-lg-4 col-sm-4' for='nom'>Dénomination sociale</label><input type=\"text\" name=\"nom\" class='col-sm-6 col-lg-6' value='$nom' /></div>
					<div class='row'><label class='col-lg-4 col-sm-4' for='email'>E-mail</label><input type=\"email\" name=\"email\" class='col-sm-6 col-lg-6' value='$email' /></div>
					<div class='row'><label class='col-lg-4 col-sm-4' for='TVA'>N° TVA</label><input type=\"text\" name=\"TVA\" class='col-sm-6 col-lg-6' value='$TVA' /></div>
					<div class='row'><label class='col-lg-4 col-sm-4' for='adresse'>Adresse</label><input type=\"text\" name=\"adresse\" class='col-sm-6 col-lg-6' value='$adresse' /></div>
					<div class='row'><label class='col-lg-4 col-sm-4' for='code_postal'>Code Postal</label><input type=\"text\" name=\"code_postal\" class='col-sm-6 col-lg-6' value='$code_postal' /></div>
					<div class='row'><label class='col-lg-4 col-sm-4' for='ville'>Ville</label><input type=\"text\" name=\"ville\" class='col-sm-6 col-lg-6' value='$ville' /></div>
					<div class='row'><label class='col-lg-4 col-sm-4' for='pays'>Pays</label><input type=\"text\" name=\"pays\" class='col-sm-6 col-lg-6' value='$pays' /></div>";
		$urlBack = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
		echo "<input type='hidden' name='back' value='".$urlBack."'/>";
	}

	public function ecommerce()
	{
		if(isset($_POST['changeEcommerce']))
		{
			if(isset($_POST['ecommerce']) AND $_POST['ecommerce'] == "on")
			{
				$valeur = "on";
			}
			else
			{
				$valeur = "off";
			}
			
			$sql = "UPDATE systeme SET valeur = '$valeur' WHERE nom = 'ecommerce'";
			$reponse = $this->_db->query($sql);
			header("location: options.php");
		}
		
		$sql = "SELECT * FROM systeme WHERE nom = 'ecommerce'";
		$reponse = $this->_db->query($sql);
		
		while($donnees = $reponse->fetch())
		{
			
			if($donnees['valeur'] == "on")
			{
				$checked = "checked";
			}
			else
			{
				$checked = "";
			}
			
			echo "<div class='row' style='text-align: center'><input type='checkbox' name='ecommerce' $checked/><label class='labelLeft'>Activer l'ecommerce</label><br/><br/></div>";
			
		}
		
		
	}

	public function displayAdditionalLangages()
	{
		
		if(isset($_POST['langue_secondaire']))
		{
			foreach($_POST['langue_secondaire'] as $key => $langue)
			{
				$error = false;
				if($langue == "delete")
				{
					$sql = "DELETE FROM systeme WHERE ID = ".$_POST['hiddenID'][$key];
				}
				else
				{
					if($langue != "choice")
					{

						if(!isset($_POST['hiddenID'][$key]))
						{
							$sqlCheck = "SELECT * FROM systeme WHERE nom = 'langue_secondaire' AND valeur = '".$langue."'";
							$reponseCheck = $this->_db->query($sqlCheck);
							if($reponseCheck->rowCount() == 0)
							{
								$sql = "INSERT INTO systeme VALUES('','langue_secondaire', '".$langue."')";
							}
							
						}
						else
						{
							$sqlCheck = "SELECT * FROM systeme WHERE nom = 'langue_secondaire' AND valeur = '".$langue."'";
							$reponseCheck = $this->_db->query($sqlCheck);
							if($reponseCheck->rowCount() == 0)
							{
								$sql = "UPDATE systeme SET valeur = '".$langue."' WHERE ID = ".$_POST['hiddenID'][$key];
							}
							
						}
					}
				}
				
				
					$reponse = $this->_db->query($sql);
				
			}
		}
		$liste_langue = array("delete" => "Supprimer", "fr" => "Français", "en" => "Anglais", "de" => "Allemand", "nl" => "Néerlandais", "es" => "Espagnol", "it" => "Italien", "po" => "Portugais");
		$liste_langue = array("delete" => "Supprimer");
		$liste_langue2 = parent::listAllLang();
		$liste_langue = array_merge($liste_langue, $liste_langue2);
		$sql = "SELECT * FROM systeme WHERE nom = 'langue_secondaire'";
		$reponse = $this->_db->query($sql);

		while($donnees = $reponse->fetch())
		{
			$langue_secondaire = $donnees['valeur'];
			echo "<div class='row'><select class='col-sm-4 col-sm-offset-4 langueSelect' name='langue_secondaire[]'>";
			foreach($liste_langue as $key => $langue)
			{
				if($key == $langue_secondaire)
				{
					$selected = "selected";
				}
				else
				{
					$selected = "";
				}
				echo "<option ".$selected." value='".$key."'>".$langue."</option>";
			}
			echo "</select></div>";
			echo "<input type='hidden' value='".$donnees['ID']."' name='hiddenID[]'/>";
		}
		//$liste_langue = array("choice" => "Choisissez une langue à installer", "fr" => "Français", "en" => "Anglais", "de" => "Allemand", "nl" => "Néerlandais", "es" => "Espagnol", "it" => "Italien", "po" => "Portugais");
		$liste_langue = array("choice" => "Choisissez une langue à installer");
		$liste_langue2 = parent::listAllLang();
		$liste_langue = array_merge($liste_langue, $liste_langue2);
		
		echo "<div class='row'><select class='col-sm-6 col-sm-offset-3 langueSelect' name='langue_secondaire[]'>";
		foreach($liste_langue as $key => $langue)
		{
			echo "<option ".$selected." value='".$key."'>".$langue."</option>";
		}
		echo "</select></div>";		
		//echo "<div class='row' style='text-align: center'><br/><a href='#' class='addLangage'>Ajouter une langue</a><br/><br/></div>";
	}

	public function displayAllLanguage()
	{
		if(isset($_POST['changeLangage']))
		{
			$sql = "UPDATE systeme SET valeur = '".$_POST['langue_principale']."' WHERE nom = 'langue_principale'";
			$reponse = $this->_db->query($sql);	
		}
		$sql = "SELECT * FROM systeme WHERE nom = 'langue_principale'";
		$reponse = $this->_db->query($sql);
		
		$reponse = $reponse->fetchAll();
		
		$langue_principale = $reponse[0]['valeur'];
		
		//$liste_langue = array("fr" => "Français", "en" => "Anglais", "de" => "Allemand", "nl" => "Néerlandais", "es" => "Espagnol", "it" => "Italien", "pt" => "Portugais");
		$liste_langue = parent::listAllLang();
		
		echo "<div class='row'><select class='col-sm-4 col-sm-offset-4' name='langue_principale'>";
		foreach($liste_langue as $key => $langue)
		{
			if($key == $langue_principale)
			{
				$selected = "selected";
			}
			else
			{
				$selected = "";
			}
			echo "<option ".$selected." value='".$key."'>".$langue."</option>";
		}
		echo "</select></div>";
		
		
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
				echo "<div class='success'>Le mot de passe a été motifié avec succès</div>";
			}
		}
	}

	public function advancedMod()
	{
		if(isset($_POST['advancedModChange']))
		{
			if(isset($_POST['advanced']) AND $_POST['advanced'] != null)
			{
				$security = "true";
			}
			else
			{
				$security = "false";
			}
			$sql = "UPDATE systeme SET valeur = '$security' WHERE nom = 'advanced_mod'";
			$reponse = $this->_db->query($sql);
			echo "<div class='success'>Changement effectué</div>";
		}

		$sql = "SELECT * FROM systeme WHERE nom = 'advanced_mod'";
		$reponse = $this->_db->query($sql);

		while($donnees = $reponse->fetch())
		{
			$resultat = $donnees['valeur'];
		}

		if($resultat == "true")
		{
			$checked = "checked";
			$mot = "Activé";
		}
		else
		{
			$checked = "";
			$mot = "désactivé";
		}

		echo "<div class='col-sm-12 checkbox'><input type='checkbox' class='js-switch' $checked name='advanced'> $mot<br/></div><br/><br/>";
	}

	public function security_force_brute()
	{
		if(isset($_POST['forceBruteChange']))
		{
			if(isset($_POST['security']) AND $_POST['security'] != null)
			{
				$security = "true";
			}
			else
			{
				$security = "false";
			}
			$sql = "UPDATE systeme SET valeur = '$security' WHERE nom = 'security_force_brute'";
			$reponse = $this->_db->query($sql);
			echo "<div class='success'>le système de sécurité a été motifié avec succès</div>";
		}

		$sql = "SELECT * FROM systeme WHERE nom = 'security_force_brute'";
		$reponse = $this->_db->query($sql);

		while($donnees = $reponse->fetch())
		{
			$resultat = $donnees['valeur'];
		}

		if($resultat == "true")
		{
			$checked = "checked";
			$mot = "Activée (par défaut)";
		}
		else
		{
			$checked = "";
			$mot = "désactivée";
		}

		echo "<div class='col-sm-12 checkbox'><input type='checkbox' class='' $checked name='security'> $mot<br/></div><br/><br/>";

	}
	public function newUser()
	{
		if(isset($_POST['nouvelUtilisateur']))
		{
			$erreur = 0;
			$nom = $_POST['login'];
			$mail = $_POST['mail'];
			$permission = $_POST['permission'];
			$rang = $_POST['rang'];
			


			if($nom == null)
			{
				echo "<div class='fail'>Merci de renseigner un login</div>";
				$erreur++;
			}
			else
			{	
				$sql = "SELECT * FROM login WHERE login = '$nom'";
				$reponse = $this->_db->query($sql);
				if($reponse->rowCount() != 0)
				{
					echo "<div class='fail'>Ce login existe déjà, merci d'en choisir un autre</div>";
					$erreur++;
				}
			}
			if($mail == null)
			{
				echo "<div class='fail'>Merci de renseigner un email</div>";
				$erreur++;
			}
			else
			{
				if(!filter_var($mail, FILTER_VALIDATE_EMAIL))
				{
					echo "<div class='fail'>L'email que vous avez renseigné n'est pas valide</div>";
					$erreur++;
				}
			}

			if($erreur == 0)
			{
				//$date = time();
				$sql = "INSERT INTO login VALUES('','$nom','4813494d137e1631bba301d5acab6e7bb7aa74ce1185d456565ef51d737677b2','','$mail','','','','','','','$rang')";
				$reponse = $this->_db->exec($sql);
				
				$lastID = $this->_db->lastInsertId();
				
				if($permission == "on")
				{
					$sql = "SELECT * FROM contenu";
					$reponse = $this->_db->query($sql);
					
					while($donnees = $reponse->fetch())
					{
						$ID_contenu = $donnees['ID'];
						$ID = $lastID;
						$autorisation[$ID] = "on";
						$readAutorisation = json_decode($donnees['autorisations'],TRUE);
						$readAutorisation['editionPermission'][$ID] = "on";
						$readAutorisation['suppressionPermission'][$ID] = "on";
						$readAutorisation = json_encode($readAutorisation);
						
						
						$sql2 = "UPDATE contenu SET autorisations = '$readAutorisation' WHERE ID = $ID_contenu";
						$reponse2 = $this->_db->query($sql2);
					}
						
				}
				
				if($erreur == 0)
				{
					echo "<div class='success'>L'utilisateur a été ajouté avec succès</div>";
					$message_externe = "Bonjour, <br/>Quelqu'un vous a ajouté dans l'administration du site internet. <br/><br/>Votre login : $nom<br/>Votre mot de passe : root<br/> Vous pouvez bien entendu changer votre mot de passe après vous être connecté une première fois.<br/> Merci.<br/><br/>URL de l'espace d'administration : ".$_SESSION['urlSiteWeb'];
					$sujet = "administration Geronimo";
					$emailSiteWeb = "contact@web-on.be";
					$emailClient = "";
					emailSite($mail, $message_externe, $sujet, $emailSiteWeb, $emailClient);
				}

			}
		}
	}
}
?>

