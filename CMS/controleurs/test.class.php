<?php
class test extends DB
{
	private $_db;
	private $_prix;
	private $_tva;
	private $_id;


	public function __construct()
	{
		$this->_db = parent::__construct();
		
		$this->displayProduit();
		
		if(isset($_POST['addProduct']))
		{
			$this->Cookie();
		}
	}
	
	public function displayProduit()
	{
		$sql3 = "SELECT * FROM produits WHERE id = 24";
		$reponse3 = $this->_db->query($sql3);
		while($donnees3 = $reponse3->fetch())
		{
			$this->_id = $donnees3['id'];
			$ip = $_SERVER['REMOTE_ADDR'];
			$info = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
			echo $info->country;
 			$sqlTVA = "SELECT * FROM tva WHERE iso = '".$info->country."'";
 			echo $sqlTVA;
			$reponseTVA = $this->_db->query($sqlTVA);
			while($donneesTVA = $reponseTVA->fetch())
			{
				if($donnees3['tva'] == 1)
				{
					$this->_tva = $donneesTVA['standard'];
				}
				if($donnees3['tva'] == 2)
				{
					$this->_tva = $donneesTVA['reduit'];
				}
				if($donnees3['tva'] == 3)
				{
					$this->_tva = $donneesTVA['reduit_alt'];
				}
				if($donnees3['tva'] == 4)
				{
					$this->_tva = $donneesTVA['super_reduit'];
				}
			}
			if($donnees3['reduction'] == null)
			{
				$this->_prix = $donnees3['prix']*(($this->_tva/100)+1);

			}
			else
			{
				if($donnees3['unite_reduc'] != 'on')
				{
					$this->_prix = $donnees3['prix']-($donnees3['prix']*($donnees3['reduction']/100));
				}
				else
				{
					$this->_prix = $donnees3['prix']-$donnees3['reduction'];
				}
				 
			}
			echo $donnees3["nom"]."<br />".$this->_prix."<br />
			<form acton method='POST'><input type='hidden' value='".$donnees3['id']."' name='idProd'><button type='submit' class='btn btn-primary' name='addProduct'>Ajouter au panier</button></form>";
		}
	}
	
	public function Cookie()
	{	
		if(isset($_COOKIE['panier']))
		{
			setcookie('panier', $_COOKIE['panier'].";".$this->_id, time()+3600*24*24, "/");
		}
		else
		{
			setcookie('panier', $this->_id, time()+3600*24*24, "/");
		}
		
	}
}
?>