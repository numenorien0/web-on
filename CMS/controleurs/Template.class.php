<?php

class Template extends DB
{
	
	private $_db;
	
	public function __construct()
	{
		$this->_db = parent::__construct();
		if(isset($_POST['save']) AND $_POST['nom'] != null)
		{
			$this->saveTemplate();
		}
		if(isset($_GET['delete']) AND $_GET['delete'] != null)
		{
			
			$this->deleteTemplate();
			
		}
	}
	
	public function listAllTemplate()
	{
		$fichiers = scandir("content/templates/");
		$count = 0;
		foreach($fichiers as $fichier)
		{
			if($fichier != ".." AND $fichier != ".")
			{
				$count++;
				$fichier = str_replace(".txt", "", $fichier);
				echo "<div class='template'><span class='nom'>$fichier</span><a class='deleteTemplate' href='?delete=$fichier'>Supprimer</a></div>";
			}
		}
		
		if($count == 0)
		{
			echo "<h4 style='color: #dadada; font-weight: bold' >Pas encore de modèle ici</h4>";
		}
	}
	
	public function clean($string)
	{
		$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
		return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

	public function saveTemplate()
	{
		$nom = $_POST['nom'];
		$contenu = $_POST['contenu'];
		
		$nom = $this->clean($nom);
		
		if(file_exists("content/templates/$nom.txt"))
		{
			file_put_contents("content/templates/$nom.txt", $contenu);
		}
		else
		{
			file_put_contents("content/templates/$nom.txt", $contenu);
		}
		
		unset($_POST);
		#header("location: template.php");
	}

	public function deleteTemplate()
	{
		
		$fichier = $_GET['delete'];
		
		unlink("content/templates/$fichier.txt");
		
		//header("location: template.php");
		
		
	}

}
	
?>

