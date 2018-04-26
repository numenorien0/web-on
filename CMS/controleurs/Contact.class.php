<?php 
class Contact
{
	private $_nom;
	private $_email;
	private $_societe;
	private $_message;
	public $_listeErreur = array();
	private $_fusionDeTousLesChamps;
	private $_erreurNom;
	private $_erreurEmail;
	private $_erreurSociete;
	private $_erreurMessage;
	private $_sujet;
	
	public function __construct()
	{
		if(isset($_POST['envoyer']))
		{
			$this->_nom = $_POST['nom_prenom'];
			$this->_email = $_POST['email'];
			$this->_societe = $_POST['societe'];
			$this->_message = $_POST['message'];
			$this->_sujet = $_POST['sujet'];
			$this->verificationDesChamps();

		}
		if(isset($_GET['statut']) AND $_GET['statut'] == "envoi")
		{
			echo "<div class='cadre rapport col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3'><h3>Rapport</h3><div class='success'>Votre message a été envoyé avec succès. Merci de votre participation.<br/><br/>Redirection dans un instant...</div></div>";
		}	
	}

	public function verificationDesChamps()
	{
		if($this->_nom == "" OR $this->_nom == null)
		{
			$this->_listeErreur["nom"] = "Veuillez entrer votre nom et votre prénom";
			$this->_erreurNom = "Veuillez entrer votre nom et votre prénom";
		}
		if($this->_email == "" OR $this->_email == null)
		{
			$this->_listeErreur["email"] = "Veuillez entrer votre adresse email";
			$this->_erreurEmail = "Veuillez entrer votre adresse email";
		}
		else if($this->_email != "" AND $this->_email != null AND !filter_var($this->_email, FILTER_VALIDATE_EMAIL))
		{
			$this->_listeErreur["email"] = "L'adresse email que vous avez renseigné n'est pas valide";
			$this->_erreurEmail = "L'adresse email que vous avez renseigné n'est pas valide";
		}
		if($this->_societe == "" OR $this->_societe == null)
		{
			$this->_listeErreur["societe"] = "Merci de remplir le nom de votre société";
			$this->_erreurSociete = "Merci de renseigner le nom de votre société";
		}
		if($this->_message == "" OR $this->_message == null)
		{
			$this->_listeErreur["message"] = "Merci de renseigner votre message";
		}
		
		$this->_fusionDeTousLesChamps = implode("<br/>", $this->_listeErreur);
		if($this->_fusionDeTousLesChamps == "")
		{
			unset($_POST);
			$this->_message = $this->_nom."<br/>société:".$this->_societe."<br/>email: ".$this->_email."<br/><br/>Message : <br/><br/>".$this->_message;
			emailSite("quentin.vaneylen@gmail.com", $this->_message, "[Feedback][".$this->_sujet."]", "info@web-on.be", $this->_email);
			echo "<script>window.location.href = 'feedback.php?statut=envoi'</script>";
			
		}
		else
		{
			$this->affichageErreur();
		}
		
	}

	public function affichageErreur()
	{
		echo "<div class='cadre rapport col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3'><h3>Rapport</h3><div class='fail'>".$this->_fusionDeTousLesChamps."</div></div>";
	}
}
?>

