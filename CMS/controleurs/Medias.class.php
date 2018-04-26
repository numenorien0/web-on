<?php
class Medias extends DB
{
    private $_db;
    private $_response;
    private $_listThumb = [["1920", "HD"], ["800", "SD"], ["300", "intermediate"], ["150", "thumb"]];
    
    public function __construct()
    {
        $this->_db = parent::__construct();

        
    }
    
    public function get_medias($date, $size = "thumb")
    {
	    $dateFin = date("m/t/Y", $date);
		$dateFin = strtotime($dateFin);
        $sql = "SELECT * FROM images WHERE (type = :size OR type = 'video') AND time >= :date AND time <= :dateFin ORDER BY time DESC";
        $reponse = $this->_db->prepare($sql);
        $reponse->bindParam(":size", $size);
        $reponse->bindParam(":date", $date);
        $reponse->bindParam(":dateFin", $dateFin);
        $reponse->execute();
        if($reponse->rowCount() != 0)
        {
        	return $reponse->fetchAll(PDO::FETCH_ASSOC);
        }
        else
        {
	        return "none";
        }
    }
    
    public function get_filetype($file)
	{
	    $finfo = finfo_open(FILEINFO_MIME_TYPE);
		//echo finfo_file($finfo, "content/images/".$this->_image);
		return finfo_file($finfo, $file);
	}
    
    public function upload($name, $tmp)
    {
	    if(!file_exists("content/images/".date("Ym")))
	    {
		    mkdir("content/images/".date("Ym"));
	    }
	    if(move_uploaded_file($tmp, "content/images/".date("Ym")."/".$name))
	    {
	        $positionExtension = strrpos($name, ".");
		    $extension = substr($name, $positionExtension);
		    
		    $date = time();
		    $sql = "INSERT INTO images (file, time, type, resolution) VALUES (:file, :time, :type, :resolution)";
		    $reponse = $this->_db->prepare($sql);
		    $newname = "content/images/".date("Ym")."/".$name;
		    $sizeImage = getimagesize($newname);
		    $reponse->bindParam(":file", $newname);
		    
		    if(strpos($this->get_filetype($newname), "video") !== false)
		    {
		        //exit("video");
		        //echo $extension;
		        $type = "video";
		    }
		    else
		    {
		        $type = "full";
		    }
		    $reponse->bindParam(":time", $date);
		    $reponse->bindParam(":type", $type);
		    $res = $sizeImage[0]."x".$sizeImage[1];
		    $reponse->bindParam(":resolution", $res);
		    $reponse->execute();
		    $ID = $this->_db->lastInsertId();
		    
		    $sql = "UPDATE images SET parent = '$ID' WHERE ID = '$ID'";
		    $reponse = $this->_db->query($sql);
		    
		    
		    if($type === "full")
		    {
		    
    		    foreach($this->_listThumb as $size)
    		    {
    			    
    			    $width = $sizeImage[0]/intVal($size[0]);
    			    $height = $sizeImage[1]/$width;
    			    $height = number_format($height, 0, ",", "");
    			    //echo $height;
    			    $compressName = "content/images/".date("Ym")."/".$size[0]."x".$height."-".$name;
    			    parent::createThumbs($newname, $compressName, $size[0]);
    			    
    				    $sql = "INSERT INTO images (file, time, parent, resolution, type) VALUES (:file, :time, :parent, :resolution, :type)";
    				    $reponse = $this->_db->prepare($sql);
    				    $type = $size[1];
    				    $size = $size[0]."x".$height;
    				    $reponse->bindParam(":file", $compressName);
    				    $reponse->bindParam(":time", $date);
    				    $reponse->bindParam(":parent", $ID);
    				    $reponse->bindParam(":resolution", $size);
    				    $reponse->bindParam(":type", $type);
    				    $reponse->execute();
    				
    		    }
		    }
		    
		    
		    
		    
	    }
	    else
	    {
	        
	    }
    }
    
    public function get_file_details($id)
    {
	    $sql = "SELECT * FROM images WHERE ID = :id OR parent = :id";
	    $reponse = $this->_db->prepare($sql);
	    
	    $reponse->bindParam(":id", $id);
	    $reponse->execute();
	    $return = [];
	    $arrayReturned = $reponse->fetchAll(PDO::FETCH_ASSOC);
	    foreach($arrayReturned as $array)
	    {
		    $return[$array["type"]] = $array;
	    }
	    
	    return $return;
	    
    }
    
    public function delete($id)
    {
	    $sql = "SELECT * FROM images WHERE ID = :id OR parent = :id";
	    $reponse = $this->_db->prepare($sql);
	    
	    $reponse->bindParam(":id", $id);
	    
		$reponse->execute();
		while($donnees = $reponse->fetch())
		{
			@unlink($donnees['file']);
		}
		
		$sql = "DELETE FROM images WHERE ID = :id OR parent = :id";
		$reponse = $this->_db->prepare($sql);
	    
	    $reponse->bindParam(":id", $id);
	    
		$reponse->execute();
	    
    }
    
    public function changeMeta($data, $id)
    {
	    $data = json_decode($data, true);
	    $tableau = array();
	    foreach($data as $key => $lang)
	    {
		    foreach($lang as $name => $champs)
			{
				$tableau[$name][$key] = $champs;
			}
	    }
	    
	    $sql = "UPDATE images SET nom = :nom, description = :description, alt = :alt WHERE ID = :id OR parent = :id";
	    $reponse = $this->_db->prepare($sql);
	    print_r($tableau);
	    $nom = json_encode($tableau['imageName']);
	    $description = json_encode($tableau['imageDescription']);
	    $alt = json_encode($tableau['imageAlt']);
	    $reponse->bindParam(":nom", $nom);
	    $reponse->bindParam(":description", $description);
	    $reponse->bindParam(":alt", $alt);
	    $reponse->bindParam(":id", $id);
	    
	    $reponse->execute();
    }
    
    
    
    
    
}

?> 