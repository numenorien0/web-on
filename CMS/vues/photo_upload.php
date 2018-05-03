<?php
session_start();
function GenerateSafeFileName($texte) {
    $accent='ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËéèêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ';
    $noaccent='aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn';
    $texte = strtr($texte,$accent,$noaccent);
    $texte = str_replace(" ","_",$texte);

    $texte = preg_replace('/([^.a-z0-9]+)/i', '-', $texte);
    $texte = time().$texte;
    
    return $texte;
}

	function createThumbs( $pathToImages, $pathToThumbs, $thumbWidth ) 
	{
	    $info = pathinfo($pathToImages);
	    if ( strtolower($info['extension']) == 'jpg' ) 
	    {

	      $img = imagecreatefromjpeg($pathToImages);
	      $width = imagesx( $img );
	      $height = imagesy( $img );
	
		  if($width > 1920 OR $thumbWidth < 500)
		  {
		      // calculate thumbnail size
		      $new_width = $thumbWidth;
		      $new_height = floor( $height * ( $thumbWidth / $width ) );
		
		      // create a new temporary image
		      $tmp_img = imagecreatetruecolor( $new_width, $new_height );
		
		      // copy and resize old image into new image 
		      imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
		
		      // save thumbnail into a file
		      imagejpeg( $tmp_img, $pathToThumbs, 70);
		   }
	    }
	    if(strtolower($info['extension']) == "png")
	    {
	      $img = imagecreatefrompng($pathToImages);
	      $width = imagesx( $img );
	      $height = imagesy( $img );
	
		  if($width > 1920 OR $thumbWidth < 500)
		  {
		      // calculate thumbnail size
		      $new_width = $thumbWidth;
		      $new_height = floor( $height * ( $thumbWidth / $width ) );
		
		      // create a new temporary image
		      $tmp_img = imagecreatetruecolor( $new_width, $new_height );
		
		      // copy and resize old image into new image 
		      imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
		
		      // save thumbnail into a file
		      imagepng( $tmp_img, $pathToThumbs);
		      convertPNGto8bitPNG($pathToThumbs, $pathToThumbs);
		  }
	    }
	}
	function convertPNGto8bitPNG($sourcePath, $destPath) {
		$srcimage = imagecreatefrompng($sourcePath);
		list($width, $height) = getimagesize($sourcePath);
		$img = imagecreatetruecolor($width, $height);
		$bga = imagecolorallocatealpha($img, 0, 0, 0, 127);
		imagecolortransparent($img, $bga);
		imagefill($img, 0, 0, $bga);
		imagecopy($img, $srcimage, 0, 0, 0, 0, $width, $height);
		imagetruecolortopalette($img, false, 255);
		imagesavealpha($img, true);
		imagepng($img, $destPath);
		imagedestroy($img);
	}



include("controleurs/DB.class.php");
$db = new DB();
$db = $db->__construct();

if(isset($_POST['demand']) AND $_POST['demand'] == "description")
{
	$id = $_POST['id'];
	$description = $_POST['description'];
	echo $id." ".$description;
	$description = str_replace("'", "''", $description);
	$sql = "UPDATE photos SET description = '$description' WHERE ID = $id";
	$reponse = $db->query($sql);
}
if(!isset($_GET['demand']) AND !isset($_POST['demand']))
{
	    $fileName = $_FILES["file"]["name"]; // The file name
	    $fileTmpLoc = $_FILES["file"]["tmp_name"]; // File in the PHP tmp folder
	    $fileType = $_FILES["file"]["type"]; // The type of file it is
	    $fileSize = $_FILES["file"]["size"]; // File size in bytes
	    $fileErrorMsg = $_FILES["file"]["error"]; // 0 for false... and 1 for true
	    if (!$fileTmpLoc) { // if file not chosen
	        echo "ERROR: Please browse for a file before clicking the upload button.";
	        exit();
	    }
	    if($fileType != "image/jpg" AND $fileType != "image/jpeg" AND $fileType != "image/png" AND $fileType != "image/gif")
	    {
	    }
	    else
	    {
		    if(!file_exists("content/thumbnail"))
		    {
			    mkdir("content/thumbnail", 0777);
		    }
			if(!file_exists("content/album"))
		    {
			    mkdir("content/album", 0777);
		    }
		    $file = GenerateSafeFileName($fileName);
	        if(move_uploaded_file($fileTmpLoc, "content/album/".$file))
	        {
	            $fichier = "content/album/".$file;
	           
	            $thumbnail = "content/thumbnail/".$file;
	            copy($fichier, $thumbnail);
	            
	            createThumbs($thumbnail, $thumbnail, 200);
	            createThumbs($fichier, $fichier, 1920);
	            
	            $sql = "INSERT INTO photos VALUES('','','','".$file."','".$_POST['album']."')";
	            $reponse = $db->query($sql);
	            //echo $thumbnail;

	            
	            //echo $thumbnail;
	        } 
	        else 
	        {
	            echo "erreur, fonction non disponible";
	        }
	    }
}
else
{
    if($_GET['demand'] == "list")
    {
        $sql = "SELECT * FROM photos WHERE album = ".$_GET['id']." ORDER BY ID DESC";
        $reponse = $db->query($sql);

        while($donnees = $reponse->fetch())
        {
            echo "<div class='photo col-sm-3 col-lg-2'><div class='col-sm-12' data-id='".$donnees['ID']."' style='background: url(content/thumbnail/".$donnees['fichier']."); background-size: cover; background-position: center'></div><div class='blackHover'><img data-img='content/album/".$donnees['fichier']."' class='fullscreen' src='images/fullscreen.png'><img data-id='".$donnees['ID']."' class='editIcon' src='images/pencil.png'><img data-id='".$donnees['ID']."' class='deleteIcon' src='images/delete.png'></div><div style='height: auto' class='descriptionForm cadre'><h3>Description</h3><input type='hidden' value='".$donnees['ID']."' class='hiddenIDDescription'/><label class='col-sm-12' for='description'>Légende</label><textarea class='descriptionValue col-sm-12'>".$donnees['description']."</textarea><input style='margin-top: 20px' type='button' class='submitDescription' value='Enregistrer'/></div></div>";
        }
    }
    if($_GET['demand'] == "delete")
    {
        $sql = "SELECT * FROM photos WHERE ID = ".$_GET['id'];
        $reponse = $db->query($sql);

        while($donnees = $reponse->fetch())
        {
            $fichierASupprimer = $donnees['fichier'];
            @unlink("content/album/".$fichierASupprimer);
            @unlink("content/thumbnail/".$fichierASupprimer);
            $sql2 = "DELETE FROM photos WHERE ID = ".$_GET['id'];
            $reponse2 = $db->exec($sql2);
        }
    }
}
?>

