<?php

class Recovery extends DB
{
	
	private $_db; 
	private $_html;
	
	public function __construct()
	{
		$this->_db = parent::__construct();
	}
	
	public function addVersion()
	{
		
		$this->_html = str_replace("'","''", $_POST['html']);
		$date = time();
		$auteur = "";
		$ID = $_POST['ID'];
		
		$sql = "SELECT * FROM contenu_recovery WHERE page = $ID ORDER BY date DESC";
		$reponse = $this->_db->query($sql);
		
		$count = 0;
		
		while($donnees = $reponse->fetch())
		{
			$count++;
			
			if($count >= 2)
			{
				$sqlDelete = "DELETE FROM contenu_recovery WHERE ID = ".$donnees['ID'];
				$reponseDelete = $this->_db->exec($sqlDelete);
			}
		}
		
		$sql = "INSERT INTO contenu_recovery VALUES('', '$ID', '".$this->_html."', '', $date)";
		$reponse = $this->_db->query($sql);
		
	}
	
	
	
	
	
}


	
?>

