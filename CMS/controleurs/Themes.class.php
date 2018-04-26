<?php

class Themes extends DB
{
	private $_db;
	private $_rang;
	private $_language;
	private $_main_language;
	
	public function __construct()
	{
		$this->_db = parent::__construct();
		$this->_rang = parent::is_admin();
		$this->_language = $this->list_all_language();
		if(isset($_POST['saveOption']))
		{
		    $this->saveOption();
		}
		if(isset($_POST['customize']))
		{
			$this->edit();
		}
		if(isset($_POST['miniaturesSubmit']))
		{
			$this->editMiniatures();
		}
		if(isset($_GET['changeSkin']))
		{
			$this->changeSkin();
		}
		if(isset($_GET['skin']) AND $_GET['skin'] != null)
		{
			$this->customizeSkin();
		}
		else
		{
			$this->get_all_themes();
		}
		
		if(isset($_POST['code']) AND isset($_POST['fichier']))
		{
			$this->save();
		}
	}
	
	public function save()
	{
		$code = $_POST['code'];
		$nom = $_POST['fichier'];
		
		file_put_contents($nom, $code);
		
		
		
	}
	
	public function editMiniatures()
	{
		$min = json_encode($_POST['miniatures'], JSON_PRETTY_PRINT);
		file_put_contents("themes/".$_GET['skin']."/miniatures.json", $min);
	}
	
	public function edit()
	{
		#echo "<pre>";
		$element = json_encode($_POST['valeur'], JSON_PRETTY_PRINT);
		
		
		file_put_contents("themes/".$_GET['skin']."/config.json", $element);
		
		#echo "</pre>";
		
		
		
	}
	
	public function list_all_language()
	{
		$sql = "SELECT * FROM systeme WHERE nom = 'langue_principale'";
		$reponse = $this->_db->prepare($sql);
		$reponse->execute();
		$reponse = $reponse->fetchAll()[0];
		
		$langue_principale = $reponse['valeur'];
		$this->_main_language = $langue_principale;
		$input = array();
		$input[] = $langue_principale;
		$sql = "SELECT * FROM systeme WHERE nom = 'langue_secondaire'";
		$reponse = $this->_db->prepare($sql);
		$reponse->execute();
		while($donnees = $reponse->fetch())
		{
			$input[] = $donnees['valeur'];
		}
		
		return $input;		
	}

	
	public function display_all_lang()
	{
	    $liste_langue = parent::listAllLang();
	   
		foreach($this->_language as $langue)
		{
			$input .= "<div data-lang='".$langue."' data-lang-name='".$liste_langue[$langue]."' class=' btn_lang'>".strtoupper($langue)."</div>";
		}
		
		return $input;
	}
	
	public function get_all_themes()
	{
		$dossiers = scandir("themes");
		$sql = "SELECT * FROM systeme WHERE nom = 'skin'";
		$reponse = $this->_db->query($sql);
		$skin = $reponse->fetchAll()[0]['valeur'];
		
		
		foreach($dossiers as $dossier)
		{
			if(is_dir("themes/".$dossier) AND $dossier != "." AND $dossier != "..")
			{
				if($skin == $dossier)
				{
					$name = "<h6 style='margin: auto; color: white; background-color: #5497ff; padding: 15px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);'>Activé</h6>";
					$selected = "style='box-shadow: 0px 0px 0px 5px #5497ff inset'";
				}
				else
				{
					$name = "";
					$selected = "";
				}
				
				if($this->_rang)
				{
					
					$action = "";
					$linkSelect = "?changeSkin=$dossier";
					$linkPerso = "?skin=".str_replace(" ","%20", $dossier);
				}
				else
				{
					$action = "disabled";
					
					$linkSelect = "#";
					$linkPerso = "#";
				}
				$info = file_get_contents("themes/$dossier/info.txt");
				echo "<div class='col-sm-6'>
					
					<div class='col-sm-12 cadre' $selected>
						<div style='margin-bottom: 15px; height: 300px; display: flex; background-image: url(themes/".str_replace(" ","%20", $dossier)."/preview.png); background-size: cover; background-position: center' class='col-sm-6'>
							$name
						</div>
						<div class='col-sm-6' style='height: 300px; margin-bottom: 15px; overflow: hidden'>
							<h5 style='text-align: center; margin-bottom: 15px; margin-top: 20px; text-transform: capitalize; font-size: 20px;'>$dossier</h5>$info
						</div>
						
						<a style='margin-top: 0px; display: block' class='select linkButton col-sm-5 col-sm-offset-0 $action'  href='$linkSelect'>Sélectionner</a><a style='margin-top: 0px; display: block' class='customize linkButton col-sm-5 col-sm-offset-2 $action'  href='$linkPerso'>Personnaliser</a>						
					</div>
					
				</div>";
			}
		}
		
		
	}
	
	public function changeSkin()
	{
		
		$skin = $_GET['changeSkin'];
		
		$sql = "UPDATE systeme SET valeur = '$skin' WHERE nom = 'skin'";
		$reponse = $this->_db->query($sql);
		header("location: design.php");
		
	}
	public function get_filetype($file)
	{
	    $finfo = finfo_open(FILEINFO_MIME_TYPE);
		//echo finfo_file($finfo, "content/images/".$this->_image);
		return finfo_file($finfo, $file);
	}
	public function saveOption()
	{
	    //$_POST['input'] = array_merge($_POST['input'], $_FILES);
	    //print_r($_FILES);
	    //exit();
	    foreach($_POST['input'] as $lang => $input)
	    {
	        $tableau = array();
	        foreach($input as $key => $categories)
	        {
	            foreach($categories as $cle => $champs)
	            {
	                if($champs == "onchange")
	                {
	                    
	                    //exit($_FILES['input'][$lang][$key][$cle]['name']);
	                    //exit("content/images/".$_FILES['file']['name'][$lang]['image']);
	                    $type = $_POST['type'][$lang][$key][$cle];
	                    $fileName = "content/images/".$_FILES['file']['name'][$lang][$cle];
	                    $tmpFile = $_FILES['file']['tmp_name'][$lang][$cle];
	                    if(!move_uploaded_file($tmpFile, $fileName))
	                    {
	                        //exit("erreur");
	                    }
	                    $champs = $fileName;
	                    //exit($champs);
	                }
	                $tableau[$cle] = array("value" => $champs, "categorie" => $key, "type" => $_POST['type'][$lang][$key][$cle], "label" => $_POST['label'][$lang][$key][$cle]);
	                //echo $champs."<br/>";
	            }
	            
	        }
	        
	        $tableau = json_encode($tableau, JSON_PRETTY_PRINT);
	        file_put_contents("themes/".$_GET['skin']."/options/".$lang.".json", $tableau);
	           //print_r($tableau);
	    }
	    
	}
	
	public function customizeSkin()
	{
	    echo "<div class='col-sm-12'>";
	    echo "<div class='cadre col-sm-12' style='padding-top: 30px'>".$this->display_all_lang()."</div>";
	    echo "</div>";
		echo "<div class='col-sm-4'><form method='POST' class='col-sm-12 cadre' enctype='multipart/form-data'>";
		echo "<h3>Paramètre du thème</h3>";
		$theme = $_GET['skin'];
		
		$file = "themes/$theme/options/".$this->_main_language.".json";
		$file = json_decode(file_get_contents($file), true);
	    $options = array();
	    foreach($file as $key => $line)
	    {
	        $options[$line['categorie']][$key] = $line;
	        //echo "<div class='themeOption col-sm-12'>$key</div>";
	    }
		
		foreach($this->_language as $lang)
		{
		    echo "<div class='langOption' data-lang='$lang'>";
		    $file = "themes/$theme/options/$lang.json";
		    $file = json_decode(file_get_contents($file), true);
		    
		    foreach($options as $key => $categories)
		    {
		        echo "<h3 class='col-md-12' style='padding: 15px;border-bottom: 1px solid #dadada; padding-bottom: 15px; font-size: 30px; margin-bottom: 15px; margin-top: 15px !important'>$key <span class='deve'>Développer</span></h3>";
		        echo "<div class='cat'>";
		        foreach($categories as $cle => $champs)
		        {
			        if(!isset($champs['label']) OR $champs['label'] == null)
			        {
				        $champs['label'] = $cle;
			        }
		            if($champs['type'] == "image")
		            {
			            if(strpos($this->get_filetype($file[$cle]['value']), "video") !== false)
			            {
				            $value = "<video autoplay loop muted controls src='".htmlentities($file[$cle]['value'])."' style='max-width: 100%; max-height: 100%'></video>";
			            }
			            else
			            {
				            $value = "<img src='".htmlentities($file[$cle]['value'])."' style='max-width: 100%; max-height: 100%'/>";
			            }
		                echo "<label class='col-md-12'>".$champs['label']."</label><input class='col-md-12' style='padding: 0; margin-bottom: 15px' type='file' name='file[$lang][$cle]'/><input type='hidden' value='".htmlentities($file[$cle]['value'])."' name='input[$lang][$key][$cle]'/>";
		                echo "<div class='col-md-12' style='padding: 0; max-height: 300px'>$value</div>";
		                
		            }
		            if($champs['type'] == "video")
		            {
		                echo "<label class='col-md-12'>".$champs['label']."</label><input class='col-md-12' style='padding: 0; margin-bottom: 15px;' type='file' name='file[$lang][$cle]'/><input type='hidden' value='".htmlentities($file[$cle]['value'])."' name='input[$lang][$key][$cle]'/>";
		                echo "<video class='col-md-12' muted autoplay loop style='padding: 0; max-height: 300px' src='".htmlentities($file[$cle]['value'])."'></video>";
		                
		            }
		            if($champs['type'] == "text")
		            {
		                echo "<label class='col-md-12'>".$champs['label']."</label><input class='col-md-12' type='text' value=\"".htmlentities($file[$cle]['value'])."\" name='input[$lang][$key][$cle]'/>";
		            }
		            if($champs['type'] == "bool")
		            {
			            
			            if(htmlentities($file[$cle]['value']) === "on")
			            {
				            $checked = "<option value='on' selected>Oui</option><option value='off'>Non</option>";
			            }
			            else
			            {
				            $checked = "<option value='on'>Oui</option><option selected value='off'>Non</option>";
			            }
		                echo "<label class='col-md-12'>".$champs['label']."</label><select class='col-md-12' type='checkbox' name='input[$lang][$key][$cle]'>$checked</select>";
		            }
		            if($champs['type'] == "textarea")
		            {
		                echo "<label class='col-md-12'>".$champs['label']."</label><textarea class='col-md-12' name='input[$lang][$key][$cle]'>".htmlentities($file[$cle]['value'])."</textarea>";
		            }
		            if($champs['type'] == "email")
		            {
		                echo "<label class='col-md-12'>".$champs['label']."</label><input class='col-md-12' type='email' value=\"".htmlentities($file[$cle]['value'])."\" name='input[$lang][$key][$cle]'/>";
		            }
		            if($champs['type'] == "color")
		            {
		                echo "<label class='col-md-12'>".$champs['label']."</label><input class='col-md-12' type='color' value=\"".htmlentities($file[$cle]['value'])."\" name='input[$lang][$key][$cle]'/>";
		            }
		            
		            echo "<input type='hidden' value='".$champs['type']."' name='type[$lang][$key][$cle]'/>";
		            echo "<input type='hidden' value=\"".$champs['label']."\" name='label[$lang][$key][$cle]'/>";
		            
		        }
		        echo "</div>";
		    }
		    echo "</div>";
		}
		echo "<input type='submit' value='sauvegarder' name='saveOption'/>";
		echo "</form></div>";
		echo "<div class='col-sm-8'><form method='POST' class='col-sm-12 cadre'>";
		echo "<h3>Aperçu</h3>";
		echo "<input type='hidden' name='fichier' id='fichier' />";	
		echo "<iframe src='http://".$_SERVER['HTTP_HOST'].dirname(dirname($_SERVER['PHP_SELF']))."/' style='width: 100%; height: 80vh; border: none;'></iframe>";
		#echo "<input type='submit' name='saveCode' id='save' value='Sauvegarder'/>";
		echo "</form></div>";
		
	}
	
	
}
	
?>


