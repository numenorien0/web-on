<?php

class Abonnement extends DB
{
	private $_db;
	
	public function __construct()
	{
		$this->_db = parent::__construct();
	}
	
	public function curlData($url)
	{
		$postData = array("key" => "AZERTYUIO", "HOST" => str_replace("www.", "", $_SERVER['HTTP_HOST']));
		$ch = curl_init();
		curl_setopt_array($ch, array(
		    CURLOPT_URL => $url,
		    CURLOPT_RETURNTRANSFER => true,
		    CURLOPT_POST => true,
		    CURLOPT_POSTFIELDS => $postData,
		    CURLOPT_FOLLOWLOCATION => true
		));
		
		$output = curl_exec($ch);
		return $output;
	}
	
	public function verification()
	{
/*
		#echo "<a href='http://www.ohmedias.com/CMS/plugins/CMS_Manager/data/demande.php'>link</a>";
		$file = $this->curlData("http://www.ohmedias.com/CMS/plugins/CMS_Manager/vues/demande.php");
		file_put_contents("controleurs/Analyse.class.php", $file);
*/
		
	}
	
	
	public function displayInfo()
	{
		//echo $this->curlData("http://www.ohmedias.com/CMS/plugins/CMS_Manager/vues/solde.php");
	}
	
	public function checkAbonnement()
	{
		//echo $this->curlData("http://www.ohmedias.com/CMS/plugins/CMS_Manager/vues/check.php");
	}
}

	
?>

