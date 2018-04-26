<?php
include("controleurs/DB.class.php");
$db = new DB();
$db = $db->__construct();


if($_GET['type'] == "get")
{
	$sql = "SELECT * FROM message ORDER BY date DESC limit 0, 40";
	$reponse = $db->query($sql);
	#echo "<div id='messageContainer'>";
	$tableauMessage = array();
	while($donnees = $reponse->fetch())
	{
		$sqlAuteur = "SELECT * FROM login WHERE login = '".$donnees['auteur']."'";
		$reponseAuteur = $db->query($sqlAuteur);
		while($donneesAuteur = $reponseAuteur->fetch())
		{
			$imageAuteur = $donneesAuteur['image'];
			if($imageAuteur == null)
			{
				$imageAuteur = "images/defaultAvatar.jpg";
			}
		}
		if($donnees['auteur'] == $_SESSION['login'])
		{
			$auteur = "AuteurMoi";
		}
		else
		{
			$auteur = "AuteurOther";
		}
		$tableauMessage[] = "<div class='author' style='background-image: url(".$imageAuteur.")'></div><div class='".$auteur." message'><div class='triangleMessage'></div><h6>Posté par ".$donnees['auteur']."<span class='date'> le ".date("d/m/Y à H:i", $donnees['date'])."</h6></h6>".$donnees['texte']."</div><br/>";
	}
	$tableauMessage = array_reverse($tableauMessage);
	$tableauMessage = implode(" ", $tableauMessage);
	echo $tableauMessage;
	#echo "</div>";	
}
else
{
	$message = str_replace("'","''", $_POST['message']);
	$message = str_replace("\n", "<br/>", $message);

	$time = time();
	
	$sql = "SELECT * FROM message WHERE date = $time";
	$reponse = $db->query($sql);
	if($reponse->rowCount() == 0)
	{
		$sql = "INSERT INTO message VALUES('','".$message."', '".$_SESSION['login']."', '".$time."')";
		$reponse = $db->query($sql);
	}
}
?>

