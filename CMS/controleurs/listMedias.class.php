<?php
class listMedias extends DB
{
	private $_db;

	public function __construct()
	{
		$this->_db = parent::__construct();
		if(isset($_GET['delete']) AND $_GET['delete'] != null)
		{
			$this->delete();
		}
	}

	public function listAllPhoto()
	{
		$sql = "SELECT * FROM medias WHERE type = 'photo' ORDER BY date DESC";
		$reponse = $this->_db->query($sql);

		if($reponse->rowCount() == 0)
		{
			echo "<div class='col-sm-12 notYet'>Pas encore d'album photo</div>";
		}
		else
		{
			while($donnees = $reponse->fetch())
			{
				$urlToDelete = "outils.php?tools=galerie&page=listMedias&delete=".$donnees['ID']."";
				$urlPhoto = "&id=".$donnees['ID']."&action=showMePhotos";
				echo "<div class='ligne row'><div class='col-sm-9 col-md-9 col-lg-9 titre'>".$donnees['nom']."</div><div class='actionPages col-sm-3 col-md-3 col-lg-3'><div class='col-sm-5'><div data-id='".$urlPhoto."' class='child2'>Photos</div></div><div class='col-sm-5 col-sm-offset-0'><div data-id='".$donnees['ID']."' class='edit'>&#x270E; Modifier</div></div> <div class='col-sm-2'><div data-id='".$urlToDelete."' class='delete'>&#10006;</div></div></div></div>";
			}
		}
	}

	public function delete()
	{
		$imageToDelete;
		$sql = "SELECT * FROM medias WHERE ID = ".$_GET['delete'];
		$reponse = $this->_db->query($sql);

		while($donnees = $reponse->fetch())
		{
			$imageToDelete = $donnees['image'];
			$fichierToDelete = $donnees['fichier'];
			@unlink("content/images/".$imageToDelete);
			@unlink("content/files/".$fichierToDelete);
		}
		$sql = "DELETE FROM medias WHERE ID = ".$_GET['delete'];
		$reponse = $this->_db->query($sql);

		$sql = "SELECT * FROM photos WHERE album = ".$_GET['delete'];
		$reponse = $this->_db->query($sql);

		while($donnees = $reponse->fetch())
		{
			@unlink($donnees['fichier']);
		}

		$sql = "DELETE FROM photos WHERE album = ".$_GET['delete'];
		$reponse = $this->_db->exec($sql);

	}

	public function listAllVideo()
	{
		$sql = "SELECT * FROM medias WHERE type = 'video' ORDER BY date DESC";
		$reponse = $this->_db->query($sql);

		if($reponse->rowCount() == 0)
		{
			echo "<div class='col-sm-12 notYet'>Pas encore de vidéo</div>";
		}
		else
		{
			while($donnees = $reponse->fetch())
			{
				$urlToDelete = "outils.php?tools=video&page=listMedias&delete=".$donnees['ID']."&type=video";
				echo "<div class='ligne row'><div class='col-sm-8 col-md-9 col-lg-10 titre'>".$donnees['nom']."</div><div class='actionPages col-sm-4 col-md-3 col-lg-2'><div class='col-sm-9 col-sm-offset-0'><div data-id='".$donnees['ID']."' class='edit'>&#x270E; Modifier</div></div> <div class='col-sm-3'><div data-id='".$urlToDelete."' class='delete'>&#10006;</div></div></div></div>";
			}
		}
	}
	public function listAllFichier()
	{
		$sql = "SELECT * FROM medias WHERE type = 'fichier' ORDER BY date DESC";
		$reponse = $this->_db->query($sql);

		if($reponse->rowCount() == 0)
		{
			echo "<div class='col-sm-12 notYet'>Pas encore de fichier</div>";
		}
		else
		{
			while($donnees = $reponse->fetch())
			{
				$urlToDelete = "outils.php?tools=file&page=listMedias&delete=".$donnees['ID']."";
				echo "<div class='ligne row'><div class='col-sm-8 col-md-9 col-lg-10 titre'>".$donnees['nom']."</div><div class='actionPages col-sm-4 col-md-3 col-lg-2'><div class='col-sm-9 col-sm-offset-0'><div data-id='".$donnees['ID']."' class='edit'>&#x270E; Modifier</div></div> <div class='col-sm-3'><div data-id='".$urlToDelete."' class='delete'>&#10006;</div></div></div></div>";
			}
		}
	}
}
?>

