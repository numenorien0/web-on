<?php
include("controleurs/DB.class.php");

$db = new DB();

$db = $db->__construct();

$string ="<option>Pas de média</option>";
$string .= "<optgroup label='Albums photos'>";
$sql = "SELECT * FROM medias WHERE type='photo'";
$reponse = $db->query($sql);
while($donnees = $reponse->fetch())
{
	$string .= "<option value='".$donnees['ID']."'>".$donnees['nom']."</option>";
}
$string .= "<option>----> Ajouter un album</option></optgroup>";
$string .= "<optgroup label='Vidéos'>";
$sql = "SELECT * FROM medias WHERE type='video'";
$reponse = $db->query($sql);
while($donnees = $reponse->fetch())
{
	$string .= "<option value='".$donnees['ID']."'>".$donnees['nom']."</option>";
}

$string .= "<option>----> Ajouter une vidéo</option></optgroup>";
$string .= "<optgroup label='Fichiers'>";
$sql = "SELECT * FROM medias WHERE type='fichier'";
$reponse = $db->query($sql);
while($donnees = $reponse->fetch())
{
	$string .= "<option value='".$donnees['ID']."'>".$donnees['nom']."</option>";
}

$string .= "<option>----> Ajouter un fichier</option></optgroup>";
echo $string;
?>

