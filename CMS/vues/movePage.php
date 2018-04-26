<?php

include("controleurs/DB.class.php");
$db = new DB();
$db = $db->__construct();
$IDduplicate = $_GET['ID'];
$parent = $_GET['parent'];
#echo "fichier avec la reference ".$_GET['ID']." a bouger dans le parent ".$_GET['parent'];

if($_GET['action'] == "move")
{
	if(!$_GET['parent'] OR $_GET['parent'] == null)
	{
		$sql = "UPDATE contenu SET parent = NULL WHERE ID = ".$_GET['ID'];
	}
	else
	{
		$sql = "UPDATE contenu SET parent = ".$_GET['parent']." WHERE ID = ".$_GET['ID'];
	}
	#$sql = "UPDATE contenu SET parent = ".$parent." WHERE ID = ".$_GET['ID'];
	$reponse = $db->query($sql);
}
if($_GET['action'] == "raccourci")
{
	$sql = "INSERT INTO contenu(parent, orderID, copyOf) values('".$_GET['parent']."','100000','".$_GET['ID']."')";
	$reponse = $db->query($sql);
}

if($_GET['action'] == "duplicate")
{
	duplicate($IDduplicate, $parent, $db);
}

function duplicate($ID, $parent, $db)
{
	$sql = "SELECT * FROM contenu WHERE ID = $ID";
	$reponse = $db->query($sql);
	
	while($donnees = $reponse->fetch())
	{
		$nom = str_replace("'","''", $donnees['nom']);
		$description = str_replace("'","''", $donnees['description']);
		$texte = str_replace("'","''", $donnees['texte']);
		$auteur = str_replace("'","''", $donnees['auteur']);
		$date = $donnees['date'];
		$online = $donnees['online'];
		$commentaire = $donnees['commentaire'];
		$important = $donnees['important'];
		$medias = str_replace("'","''", $donnees['medias']);
		$permission = $donnees['autorisations'];
		$keywords = $donnees['keywords'];
		$lastOrder = $donnees['orderID'];
		$champsPerso = str_replace("'","''", $donnees['champsPerso']);
		$numeroAleatoire = rand(1, 999);
		$image = $donnees['image'];
		$newImage = $numeroAleatoire.$image;
		$homepage = $donnees['homepage'];
		$display = $donnees['display'];
		$miniatures = $donnees['miniatures'];
		$SEO_description = $donnees['SEO_description'];
		$style = $donnees['style'];
		$lien = $donnees['lien'];
		$baseMiniature = $donnees['baseMiniature'];
		$baseStyle = $donnees['baseStyle'];
		echo $image." ".$newImage;
		if($image != "")
		{
			copy("content/images/$image", "content/images/$newImage");
		}
		else
		{
			$newImage = "";
		}
		
		$parent = $parent;
		$ID = $ID;
		
		$sqlDuplicate = "INSERT INTO contenu VALUES('','".$nom."','".$description."','".$texte."','".$parent."','','".$auteur."','".$date."','".$online."','".$commentaire."','".$important."','".$newImage."','".$medias."','','','".$permission."','".$keywords."','".$lastOrder."','".$champsPerso."','','','".$homepage."','".$display."','".$miniatures."', '".$SEO_description."', '".$lien."', '".$style."', '".$baseMiniature."', '".$baseStyle."')";
		$reponseDuplicate = $db->exec($sqlDuplicate);
		
		$parent = $db->lastInsertId();
		
		
		
		$sql2 = "SELECT * FROM contenu WHERE parent = $ID";
		$reponse2 = $db->query($sql2);
		
		if($reponse2->rowCount() != 0)
		{
			
			while($donnees2 = $reponse2->fetch())
			{
				duplicate($donnees2['ID'], $parent, $db);
			}
		}
	}
}
	
?>

