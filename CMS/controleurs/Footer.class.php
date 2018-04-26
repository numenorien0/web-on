<?php

class Footer extends DB
{
	private $_db;
	private $_language;
	private $_langue_principale;
	
	public function __construct()
	{
		$this->_db = parent::__construct();
		$this->_language = $this->list_all_language();
		$this->_langue_principale = $this->_language[0];	
		
		if(isset($_POST['submitFooter']))
		{
			$this->generateFooter();
		}
	}
	
	public function displayFormulaire()
	{
		echo "<label for='row'>Nombre de colonne</label>&nbsp&nbsp<select style='min-width: 150px' id='row' name='row'>
			<option value='no'>Sélectionnez</option>
			<option value='1'>1</option>
			<option value='2'>2</option>
			<option value='3'>3</option>
			<option value='4'>4</option>
			<option value='6'>6</option>
			<option value='12'>12</option>
		</select>";	
	}

	public function list_all_language()
	{
		$sql = "SELECT * FROM systeme WHERE nom = 'langue_principale'";
		$reponse = $this->_db->query($sql);
		
		$reponse = $reponse->fetchAll()[0];
		
		$langue_principale = $reponse['valeur'];
		$input = array();
		$input[] = $langue_principale;
		$sql = "SELECT * FROM systeme WHERE nom = 'langue_secondaire'";
		$reponse = $this->_db->query($sql);
		
		while($donnees = $reponse->fetch())
		{
			$input[] = $donnees['valeur'];
		}
		
		return $input;		
	}

	public function display_all_language()
	{
		//$liste_langue = array("fr" => "Français", "en" => "Anglais", "de" => "Allemand", "nl" => "Néerlandais", "es" => "Espagnol", "it" => "Italien", "po" => "Portugais");
		$liste_langue = parent::listAllLang();
		foreach($this->_language as $langue)
		{
			$input .= "<div data-lang='".$langue."' style='margin-bottom: 0px !important; margin-top: 10px' data-lang-name='".$liste_langue[$langue]."' class=' btn_lang'>".strtoupper($langue)."</div>";
		}
		return $input;
	}
	
	public function display_all_rendu()
	{
		foreach($this->_language as $key => $langue)
		{
			echo "<div class='rendu rendu-".$langue."'></div><div class='copyright copyright-".$langue."'><div data-number='copyrightCadre-".$langue."' class='copyrightCadre-".$langue." col-sm-12 cadreBootstrap'><p style='text-align: center'>Fièrement propulsé par Geronimo</p></div></div>";
		}
		
		
		
	}
	
	public function display_all_textarea()
	{
		foreach($this->_language as $key => $langue)
		{
			if(file_exists("content/footer/$langue/code.json"))
			{
				$contenu = file_get_contents("content/footer/$langue/code.json");
			}
			else
			{
				$contenu = "";
			}
			echo "<textarea name='code[$langue]' data-lang='$langue' style='display: none; width: 100%' class='row cadre code code-$langue'>$contenu</textarea>";
		}
	}
	
	
	public function generateFooter()
	{
		$code = $_POST['code'];
		foreach($code as $key => $codeParLangue)
		{
			if(!file_exists("content/footer"))
			{
				mkdir("content/footer");
			}
			if(!file_exists("content/footer/$key"))
			{
				mkdir("content/footer/$key");
			}
			$langue = $key;
			file_put_contents("content/footer/$key/code.json", $codeParLangue);
			$json = json_decode($codeParLangue, TRUE);
			$html = "<footer><div class='container'>";
			foreach($json as $key => $element)
			{
				if(strpos($element['classe'], 'copyright') !== false)
				{
					if($element['contenu'] == "")
					{
						$copyright = "";	
					}
					else
					{
						$copyright = "<div class='copyright'>".$element['contenu']."</div>";
					}
				}
				else
				{
					$html .= "<div class='colonneFooter ".$element['classe']."'>".$element['contenu']."</div>";
				}
			}
			$html .= "</div>";
			$html .= $copyright;
			$html .= "</footer>";
			file_put_contents("content/footer/$langue/footer.php", $html);
			
		}
		echo "<div class='row cadre'><div class='success' id='state_success'>Pied de page mis à jour avec succès</div></div>";
	}
	
	
	
}
	
?>

