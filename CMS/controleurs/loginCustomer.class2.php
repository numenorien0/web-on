<?php
class loginCustomer extends DB
{
	private $_db;
	public $_listeErreur = array();
	private $_erreur = 0;
	private $_login;
	public $_liste;
	private $_mdp;
	private $_souvenir;
	private $_idCusto;
	private $_prenom;
	private $_nom;
	private $_email;
	private $_encryptionKey = "HDQSDQSDHnfksdqsJJDbeR3dqsdqsd57&8hdqsdHIDDh";
	private $_encryptionMethod = "aes128";
	private $_emailNotif;
	private $_denoSociale;
	private $_id;
	private $_emailOubli;

	
	public function __construct()
	{
		$this->_db = parent::__construct();
		
		if(isset($_COOKIE['login']))
		{
			$this->verifCookie();
		}
		
		if(isset($_POST['login']) AND isset($_POST['pass']))
		{
			$this->verifLogin();
		}
		if(isset($_POST['email']) AND isset($_POST['password']) AND isset($_POST['nom']) AND isset($_POST['prenom']))
		{
			$this->verifSubscription();
		}
		
		if(isset($_POST['emailOubli']))
		{
			$this->newPassword();
		}

		
		if(isset($_GET['verif']))
		{
			$this->verifEmail();
		}
	}
	
	public function verifCookie()
	{
		if(isset($_GET['step']))
		{
			header("Location: checkout.php?step=delivery");
		}
		else
		{
			header("Location:monCompte.php");
		}
		
	}
	
	public function verifLogin()
	{
		
		$this->_login = str_replace("'", '', $_POST['login']);
		$this->_mdp = $_POST['pass'];
		$this->_souvenir = $_POST['souvenir'];
		
		if($this->_login == null)
		{
			$this->_listeErreur[] = "Veuillez entrer un identifiant";
			$this->_erreur++;
		}
		
		if($this->_mdp == null)
		{
			$this->_listeErreur[] = "Veuillez entrer un mot de passe";
			$this->_erreur++;
		}
		
		if($this->_erreur == 0)
		{
			$this->identifyUser();
		}
		else
		{
			$_SESSION['log'] = $this->_login;
			$fusionDesErreurs = implode("<br/>", $this->_listeErreur);
			$this->_listeErreur = $fusionDesErreurs;
		}
	}
	
	public function verifSubscription()
	{
		$this->_email = str_replace("'", '', $_POST['email']);
		$this->_mdp = $_POST['password'];
		$this->_nom = str_replace("'", '‘', $_POST['nom']);
		$this->_prenom = str_replace("'", '‘', $_POST['prenom']);
		
		$_SESSION['email'] = $this->_email;
		$_SESSION['nom'] = $this->_nom;
		$_SESSION['prenom'] = $this->_prenom;
		
		if($this->_email == null)
		{
			$this->_listeErreur[] = "Veuillez entrer une adresse e-mail valide";
			$this->_erreur++;
		}
		if($this->_nom == null)
		{
			$this->_listeErreur[] = "Veuillez entrer votre nom";
			$this->_erreur++;
		}
		if($this->_prenom == null)
		{
			$this->_listeErreur[] = "Veuillez entrer votre prénom";
			$this->_erreur++;
		}
		if($this->_mdp == null)
		{
			$this->_listeErreur[] = "Veuillez entrer un mot de passe";
			$this->_erreur++;
		}
		
		$verif = "SELECT email FROM clients WHERE email=:mail";
		$reponse2 = $this->_db->prepare($verif);
		$reponse2->bindParam(':mail', $this->_email);
		$reponse2->execute();
		if($reponse2->rowCount() != 0)
		{
			$this->_listeErreur[] = "Cette adresse e-mail est déjà utilisée<br />Veuillez entrer une autre adresse e-mail";
			$this->_erreur++;
		}
		
		if($this->_erreur == 0)
		{
			$this->SubscribeUser();
			$this->_listeErreur = "Un e-mail de confirmation vous a été envoyé";
		}
		else
		{
			$fusionDesErreurs = implode("<br/>", $this->_listeErreur);
			$this->_listeErreur = $fusionDesErreurs;
		}
	}
	
	public function identifyUser()
	{
		
		$verif = "SELECT * FROM clients WHERE email = :email";
		$reponse2 = $this->_db->prepare($verif);
		$reponse2->bindParam(':email', $this->_login);
		$reponse2->execute();
		if($reponse2->rowCount() != 0)
		{
			while($donnees2 = $reponse2->fetch())
			{
				if($donnees2['statut'] != "Vérifié")
				{
					$this->_listeErreur[] = "Votre compte n'est pas encore validé";
					$this->_erreur++;
				}
			
				if(isset($_COOKIE['login']))
				{
					if($this->_mdp != $donnees2['password'])
					{
						$this->_listeErreur[] = "mdp n'est pas valide";
						$this->_erreur++;
					}
				}
				else
				{
					if(hash('sha256',$this->_mdp) != $donnees2['password'])
					{
						$this->_listeErreur[] = "mdp n'est pas valide";
						$this->_erreur++;
					}
				}			
				
				if($this->_login != $donnees2['email'])
				{
					$this->_erreur++;
					$this->_listeErreur[] = "id n'est pas valide";
				}
				
				$this->_idCusto = $donnees2['id'];
			
			}
		}
		else
		{
			$this->_listeErreur[] = "Connais pas";
			$this->_erreur++;
		}
		
		if($this->_erreur == 0)
		{
			$this->setConnexion();
			$this->_listeErreur = "Merci pour votre inscription. Vérifiez vos mails pour confirmer votre inscription";
		}
		else
		{

			$fusionDesErreurs = implode("<br/>", $this->_listeErreur);
			$this->_listeErreur = $fusionDesErreurs;
			$_SESSION['log'] = $this->_login;
		}

	}
	
	public function SubscribeUser()
	{
		
		
		$verif = "INSERT INTO clients (nom, prenom, email, password, statut) VALUES (:nom, :prenom, :email, :password, 'En attente')";
		$reponse2 = $this->_db->prepare($verif);
		$reponse2->bindParam(':email', $this->_email);
		$reponse2->bindParam(':nom', $this->_nom);
		$reponse2->bindParam(':password', hash('sha256', $this->_mdp));
		$reponse2->bindParam(':prenom', $this->_prenom);
		$reponse2->execute();
		
		$sql3 = "SELECT deno_sociale, email FROM ecommerce_config WHERE id = 1";
		$reponse3 = $this->_db->query($sql3);
		while($donnees3 = $reponse3->fetch())
		{
			$this->_emailNotif = $donnees3['email'];
			$this->_denoSociale = $donnees3['deno_sociale'];
		}
			
		$encrypted = urlencode(@openssl_encrypt($this->_email, $this->_encryptionMethod, $this->_encryptionKey));
		
			$mail = new PHPMailer();
			$mail->AddAddress($this->_email);
			$mail->CharSet = 'UTF-8';
			$mail->SetFrom($this->_emailNotif, $this->_denoSociale);
			$mail->Subject = "Confirmation d'inscription • ".$_SERVER['HTTP_HOST'];
			$mail->IsHTML(true);
			$mail->Body = "<body style='font-family:Helvetica, sans-serif; background-color:#cecece; width: 100%;'>
								<table style='width:70%; margin: auto; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);' cellspacing='0'>
									<tr>
										<td style='background-color:#fff;'>
											<img src='http://www.ohmedias.be/CMS_3/images/email-header.png' width='100%'/>
										</td>
									</tr>
									<tr style='background-color:#fff;'>
										<td>
											
											<img style='margin: auto; margin-bottom:15px; display:block;'src='http://www.ohmedias.be/CMS_3/images/e-mail-logo.png' width='15%'/>
										</td>
									</tr>
									<tr style='background-color:#fff;'>
										<td>
											<h2 style='text-align:center;'>".$this->_denoSociale."</h2>
										</td>
									</tr>
									<tr style='background-color:#fff;'>
										<td>
											<div style='margin:30px 20px 0 20px;'>
												<h1 style=' font-weight:lighter; text-align:center;'>Confirmez votre inscription</h1>
											</div>
										</td>
									</tr>
									<tr style='background-color:#fff; text-align:justify;'>
										<td>
											<div style='margin:20px 20px 0px 20px;'>
												<p style=' font-weight:lighter;'>Bonjour ".$this->_prenom.",</p>
											</div>
										</td>
									</tr>
									<tr style='background-color:#fff; text-align:justify;'>
										<td>
											<div style='margin:20px 20px 0px 20px;'>
												<p style=' font-weight:lighter;'>Merci pour votre inscription</p>
												<p>Afin de confirmer votre isncription, veuillez confimrer votre compte en cliquant ci-dessous :</p>
											</div>
										</td>
									</tr>
									<tr style='background-color:#fff;'>
										<td>
											<div style='margin:0px 10px 50px 20px;'>
												<div style=' font-weight:lighter; text-align:center; margin-top: 30px;'>Vous pouvez consulter vos commandes en cliquant ci-dessous<br />
													<div style=' margin-top:50px;'><a href='http://ohmedias.com/CMS_3/loginCustomer.php?verif=".$encrypted."' style='padding:20px; background-color:#248C85; text-decoration:none; color:#fff;' title='Voir mes commandes'>Voir mes commandes</a></div>
												</div>
											</div>
										</td>
									</tr>
									<tr style='background-color:#000;'>
										<td style='color:#fff; text-align:center;'><small>Powered by Geronimo CMS</small></td>
									</tr>
							
								</table>
							</body>";
			
			try
			{
			    $mail->Send();
			    //echo "<div class='col-sm-12'><div class='col-sm-12' id='successForm'>Message envoyé !</div></div>";
			} catch(Exception $e){
			    //Something went bad
			    //echo "<div class='col-sm-12'><div class='col-sm-12' id='errorForm'></div></div>";
			}
	}
	
	
	
	public function setConnexion()
	{
		
		if($this->_souvenir == 'on')
		{
			$mdp = hash('sha256', $this->_mdp);
			setcookie("login", $this->_login.'<<__-->>'.$mdp, time() + 365*24*3600);
			setcookie("timeout", time() + 365*24*3600);
			
		}
		else
		{
			$mdp = hash('sha256', $this->_mdp);
			setcookie("login", $this->_login.'<<__-->>'.$mdp);
			setcookie("timeout", '');
		}
		
		if(isset($_GET['step']))
		{
			header("Location: checkout.php?step=delivery");
		}
		else
		{
			echo $this->_idCusto;

			header("Location: monCompte.php?tab=moncompte&id=".$this->_idCusto);
		}
	}
	
	public function verifEmail()
	{
		$decrypted = openssl_decrypt($_GET['verif'], $this->_encryptionMethod, $this->_encryptionKey);
		$id = "SELECT id, statut FROM clients WHERE email = :email1";
		$reponse = $this->_db->prepare($id);
		$reponse->bindParam(':email1', $decrypted);
		$reponse->execute();
		while($donnees = $reponse->fetch())
		{
			$this->_id = $donnees['id'];
			if($donnees["statut"] == 'Vérifié')
			{
				$this->_listeErreur = "Votre compte a déjà été vérifié";
			}
			else
			{
				$verif = "UPDATE clients SET email = :email, statut='Vérifié', date_inscription='".time()."', n_client='".time()."-".$this->_id."' WHERE email = :email";
				$reponse2 = $this->_db->prepare($verif);
				$reponse2->bindParam(':email', $decrypted);
				$reponse2->execute();
				echo $verif;
				echo $decrypted;
				$this->_listeErreur = "Votre inscrption est confirmée. Connectez-vous dès à présent !";
			}
			
		}
	}
	
	public function newPassword()
	{
		$this->_emailOubli = $_POST['emailOubli'];
		
		if($this->_emailOubli == null)
		{
			$this->_listeErreur[] = "Veuillez renseigner l'adresse e-mail de votre compte";
			$this->_erreur++;
		}
		
		$verif = "SELECT email FROM clients WHERE email = :email";
		$reponse2 = $this->_db->prepare($verif);
		$reponse2->bindParam(':email', $this->_emailOubli);
		$reponse2->execute();
		if($reponse2->rowCount() == 0)
		{
			$this->_listeErreur[] = "L'adresse est inconnue";
			$this->_erreur++;
		}
		
		if($reponse2->rowCount() != 0)
		{
			$chaine='abcdefghijklmnopqrstuvwxyz0123456789';
			$melange=str_shuffle($chaine);
			$pass=substr($melange, 0, 8);
			
			$sql2 = "UPDATE clients SET password=:mdp WHERE email=:email";
			$reponse = $this->_db->prepare($sql2);
			$reponse->bindParam(':mdp', hash('sha256',$pass));
			$reponse->bindParam(':email',$this->_emailOubli);
			$reponse->execute();
			
			$sql3 = "SELECT deno_sociale, email FROM ecommerce_config WHERE id = 1";
			$reponse3 = $this->_db->query($sql3);
			while($donnees3 = $reponse3->fetch())
			{
				$this->_emailNotif = $donnees3['email'];
				$this->_denoSociale = $donnees3['deno_sociale'];
			}
			
			$mail = new PHPMailer();
			$mail->AddAddress($this->_emailOubli);
			$mail->CharSet = 'UTF-8';
			$mail->SetFrom($this->_emailNotif, $this->_denoSociale);
			$mail->Subject = "Oubli de votre mot de passe • ".$_SERVER['HTTP_HOST'];
			$mail->IsHTML(true);
			$mail->Body = "<body style='font-family:Helvetica, sans-serif; background-color:#cecece; width: 100%;'>
								<table style='width:70%; margin: auto; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);' cellspacing='0'>
									<tr>
										<td style='background-color:#fff;'>
											<img src='http://www.ohmedias.be/CMS_3/images/email-header.png' width='100%'/>
										</td>
									</tr>
									<tr style='background-color:#fff;'>
										<td>
											
											<img style='margin: auto; margin-bottom:15px; display:block;'src='http://www.ohmedias.be/CMS_3/images/e-mail-logo.png' width='15%'/>
										</td>
									</tr>
									<tr style='background-color:#fff;'>
										<td>
											<h2 style='text-align:center;'>".$this->_denoSociale."</h2>
										</td>
									</tr>
									<tr style='background-color:#fff;'>
										<td>
											<div style='margin:30px 20px 0 20px;'>
												<h1 style=' font-weight:lighter; text-align:center;'>Oubli de votre mot de passe</h1>
											</div>
										</td>
									</tr>
									<tr style='background-color:#fff; text-align:justify;'>
										<td>
											<div style='margin:20px 20px 0px 20px;'>
												<p style=' font-weight:lighter;'>Bonjour ".$this->_prenom.",</p>
											</div>
										</td>
									</tr>
									<tr style='background-color:#fff; text-align:justify;'>
										<td>
											<div style='margin:20px 20px 0px 20px;'>
												<p>Vous avez demandé de changer votre mot de passe. Vous trouverez ci-dessous votre nouveau mot de passe.</p>
												<p>Vous pourrez le modifier une fois connecter à votre compte</p>
											</div>
										</td>
									</tr>
									<tr style='background-color:#fff;'>
										<td>
											<div style='margin:0px 10px 50px 20px;'>
												<div style=' font-weight:lighter; margin-top: 30px;'><strong>Nouveau mot de passe : </strong>".$pass."
													<div style=' margin-top:50px; text-align:center;'><a href='".$_SERVER['HTTP_HOST']."/CMS_3/loginCustomer.php' style='padding:20px; background-color:#248C85; text-decoration:none; color:#fff;' title='Se connecter'>Se connecter</a></div>
												</div>
											</div>
										</td>
									</tr>
									<tr style='background-color:#000;'>
										<td style='color:#fff; text-align:center;'><small>Powered by Geronimo CMS</small></td>
									</tr>
							
								</table>
							</body>";
			
			try
			{
			    $mail->Send();
			    //echo "<div class='col-sm-12'><div class='col-sm-12' id='successForm'>Message envoyé !</div></div>";
			} catch(Exception $e){
			    //Something went bad
			    //echo "<div class='col-sm-12'><div class='col-sm-12' id='errorForm'></div></div>";
			}
			
			
		}
	}
}
?>

