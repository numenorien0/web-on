<?php
	ob_start();
	$logo = "kindoo.svg";
	$logoBlack = "kindoo-light.svg";
	$size = "50%";
	$margin = "30px";
function translate($from_lan, $to_lan, $text){
    $json = json_decode(file_get_contents('https://translate.yandex.net/api/v1.5/tr.json/translate?key=trnsl.1.1.20161119T170438Z.9dd752e92c368855.756b63a63f048233e0b1fd1165c12edf764624f3&text=Salut%20%C3%A0%20tous&lang=en'));
    //print_r($json);

    
}


$fichierDB = file("db.conf");

if($fichierDB[5] === "kindoo")
{
	$logo = "logoBlack.svg";
	$size = "80%";
	$logoBlack = "logoLight.svg";
	$margin = "0px";
}


	#translate();
if(!file_exists(".htaccess"))
{
	$fichierHtAccess = file_get_contents("htaccess.txt");
	file_put_contents(".htaccess", $fichierHtAccess);
	header("location: index.php");
}
if(isset($_GET['f']) AND $_GET['f'] != NULL)
{
	
	session_start();
	$chemin = $_SERVER['SCRIPT_FILENAME'];
	$positionFichier = strrpos($chemin, "/");
	$_SESSION['path'] = substr($chemin, 0, $positionFichier+1);
	$path = $_SESSION['path'];
	
	$_SESSION['urlSiteWeb'] = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$positionDossier = strrpos($_SESSION['urlSiteWeb'], "/");
	
	$_SESSION['urlSiteWeb'] = substr($_SESSION['urlSiteWeb'], 0, $positionDossier);
	$search = $_SERVER['DOCUMENT_ROOT'];
	$_SESSION['img_path'] = str_replace($search, "", $path);
	header('Content-Type: text/html; charset=utf-8');
	include("config.php");
	if(!file_exists("vues/".$_GET['f']))
	{
		include("vues/noFound.php");
	}
	else
	{
		include_once("controleurs/stripe/init.php");
		include_once("controleurs/fpdf/fpdf.php");
		function __autoload($class_name) {
    		include_once "controleurs/".$class_name . ".class.php";
    		if(isset($_GET['tools']) AND $_GET['tools'] != null)
    		{
    			//$dossiers = scandir("plugins");
    			$dossier = $_GET['tools'];
				//foreach($dossiers as $dossier)
				//{
    				if(file_exists("plugins/".$dossier."/controleurs/".$class_name.".class.php"))
					{
	    				include_once("plugins/".$dossier."/controleurs/".$class_name.".class.php");
	    			}
    			//}
    		}
		}

		include("vues/".$_GET['f']);
	}
}
?>
