<?php

$fichier = $_FILES['file']['name'];
$fichierTmp = $_FILES['file']['tmp_name'];

if(move_uploaded_file($fichierTmp, "plugins/".$fichier))
{

	//copy($fichier, "plugins/");
	$zip = new ZipArchive;
	$res = $zip->open("plugins/".$fichier);
	if ($res === TRUE) {
	  $zip->extractTo("plugins/");
	  $zip->close();
	} else {
		echo "erreur";
	}

	unlink("plugins/".$fichier);
	effacer("plugins/__MACOSX");
}


	function effacer($fichier) {
		if (file_exists($fichier)) {
			if (is_dir($fichier)) {
				$id_dossier = opendir($fichier); 
				while($element = readdir($id_dossier)) {
		       		if ($element != "." && $element != "..") {
		       			effacer($fichier."/".$element);
					}
		   		}
		   		closedir($id_dossier);
		   		rmdir($fichier);
		   	} else {
				unlink($fichier);
			}
		}
	}

?>

