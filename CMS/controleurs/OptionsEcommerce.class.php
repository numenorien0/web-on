<?php
class OptionsEcommerce extends DB
{
	private $_db;
	private $_devise;
	private $_sepa_mill;
	private $_sepa_deci;
	private $_commentaire;
	private $_gestion_stocks;
	private $_email_notif;
	private $_pos_devise;
	private $_cgv;
	private $_pdf;
	private $_nomDuFichier;
	private $_nomCategorie;
	private $_parentCategorie;
	public $_listeErreur = array();
	public $_erreur = 0;
	private $_deleteCat;
	private $_deno;
	private $_email;
	private $_telephone;
	private $_tva;
	private $_adresse;
	private $_cp;
	private $_ville;
	private $_pays;
	private $_secretStripe;
	private $_publicStripe;
	private $_delais_retract;
	private $_unite_retract;
	private $_retract;
	private $_lg;
	private $_config;
	private $_thumb;
	
	public function __construct()
	{
		$this->_db = parent::__construct();
		$this->_language = $this->list_all_language();
		$this->_langue_principale = $this->_language[0];

		if(isset($_POST) AND $_POST != null)
		{
				$this->Verification();
		}
		
		if(isset($_GET['deleteCat']) AND $_GET['deleteCat'] != null){
			$this->deleteCat($_GET['deleteCat']);
		}
		
		if(isset($_POST['updateThumbProd']) OR isset($_POST['updateThumbCat']) OR isset($_POST['updateFiche']))
		{
			$this->updateDisplayShop();
		}
	}

	public function ReadStateMaintenance()
	{
		if(isset($_POST['maintenance']))
		{
			$this->changeMaintenance();
		}

		$sql = "SELECT * FROM systeme WHERE nom = 'maintenance'";
		$reponse = $this->_db->query($sql);

		while($donnees = $reponse->fetch())
		{
			if($donnees['valeur'] == "false")
			{
				echo "<input type='hidden' value='false' name='valeur'>";
				echo "<div class='success' style='padding-top: 12px'>Votre site est actuellement en ligne</div>";
			}
			else
			{
				echo "<input type='hidden' value='true' name='valeur'>";
				echo "<div class='fail' style='padding-top: 12px'>Votre site est actuellement en maintenance</div>";
			}
		}
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
		//$this->_language = array("fr" => "Français", "en" => "Anglais", "de" => "Allemand", "nl" => "Néerlandais", "es" => "Espagnol", "it" => "Italien", "pt" => "Portugais");
		$liste_langue = parent::listAllLang();
		//print_r($this->_language);
		foreach($this->_language as $key => $langue)
		{
			echo "<span data-lang='".$langue."' data-lang-name='".$liste_langue[$langue]."' class='btn_lang'>".strtoupper($langue)."</span>";
			$this->_lg[$langue] = $liste_langue[$langue];
		}
		
	
	}

	public function configShop()
	{
		$this->_config = array();
		$sql = "SELECT * FROM ecommerce_config";
		$reponse = $this->_db->query($sql);
		while($donnees = $reponse->fetch())
		{
			$this->_config = $donnees;
		}
			if($this->_config['gestion_stocks'] != ""){
				echo "<div class='row' style='margin-top:15px;'><label style='margin-top:0;' class='col-lg-6 col-sm-6' for='gestion-stocks'>Gestion des stocks</label><input type='checkbox' checked class='col-sm-2 col-lg-2' name='gestion_stocks' id='gestion-stocks'/></div>";
			}else{
				echo "<div class='row' style='margin-top:15px;'><label style='margin-top:0;' class='col-lg-6 col-sm-6' for='gestion-stocks'>Gestion des stocks</label><input type='checkbox' class='col-sm-2 col-lg-2' name='gestion_stocks' id='gestion-stocks'/></div>";
			}
			
			if($this->_config['commentaire'] != ""){
				echo "<div class='row' style='margin-top:15px;'><label style='margin-top:0;' class='col-lg-6 col-sm-6' for='commentaires'>Activer les commentaires sur les produits ?</label><input type='checkbox' checked class='col-sm-2 col-lg-2' name='commentaire' id='commentaires'/></div>";
			}else{
				echo "<div class='row' style='margin-top:15px;'><label style='margin-top:0;' class='col-lg-6 col-sm-6' for='commentaires'>Activer les commentaires sur les produits ?</label><input type='checkbox' class='col-sm-2 col-lg-2' name='commentaire' id='commentaires'/></div>";
			}
			
			echo "<div class='row' style='margin-top:15px;'>";
					echo "<label class='col-lg-6 col-sm-6'>Devise</label>
					<select name='devise'>";
						if($this->_config['devise'] == '')
						{
							$this->_config['devise'] = '€';
						}
						if($this->_config['devise'] == "€")
						{
							echo "
								<option value='&euro;' selected>&euro;</option>
								<option value='&#163;'>&#163;</option>
								<option value='$'>&#36;</option>
								<option value='CHF'>CHF</option>
							";
						}
						if($this->_config['devise'] == "$")
						{
							echo "
								<option value='&euro;'>&euro;</option>
								<option value='&#163;'>&#163;</option>
								<option value='&#36;' selected>&#36;</option>
								<option value='CHF'>CHF</option>
							";
						}
						if($this->_config['devise'] == "£")
						{
							echo "
								<option value='&euro;'>&euro;</option>
								<option value='&#163;' selected>&#163;</option>
								<option value='$'>&#36;</option>
								<option value='CHF'>CHF</option>
							";
						}
						if($cofig['devise'] == "CHF")
						{
							echo "
								<option value='&euro;'>&euro;</option>
								<option value='&#163;'>&#163;</option>
								<option value='$'>&#36;</option>
								<option value='CHF' selected>CHF</option>
							";
						}

						echo "
					</select>
				</div>";
			
			echo "<div class='row' style='margin-top:15px;'><label class='col-lg-6 col-sm-6'>Position devise</label><select name='pos_devise'>";
				if($this->_config['pos_devise'] == "before-space"){
					echo "<option value='before-space' selected>".$this->_config['devise']." 30.00</option>";
				}else{
					echo "<option value='before-space'>".$this->_config['devise']." 30.00</option>";
				}
				if($this->_config['pos_devise'] == "before"){
					echo "<option value='before' selected>".$this->_config['devise']."30.00</option>";
				}else{
					echo "<option value='before'>".$this->_config['devise']."30.00</option>";
				}
				if($this->_config['pos_devise'] == "after"){
					echo "<option value='after' selected>30.00".$this->_config['devise']."</option>";
				}else{
					echo "<option value='after'>30.00".$this->_config['devise']."</option>";
				}
				if($this->_config['pos_devise'] == "after-space"){
					echo "<option value='after-space' selected>30.00 ".$this->_config['devise']."</option>";
				}else{
					echo "<option value='after-space'>30.00 ".$this->_config['devise']."</option>";
				}
				
			echo "</select></div>";					
			echo" <div class='row'><label for='sepa_mill' class='col-lg-6 col-sm-6'>Séparateur milliers</label><input type='text' name='sepa_mill' value='".$this->_config['sepa_mill']."' /></div>";
			echo" <div class='row'><label for='sepa_deci' class='col-lg-6 col-sm-6'>Séparateur décimal</label><input type='text' name='sepa_deci' value='".$this->_config['sepa_deci']."' /></div>";
			echo" <div class='row'><label for='email_notif' class='col-lg-6 col-sm-6'>E-mail de notification</label><input type='email' name='email_notif' value='".$this->_config['email_notif']."' /></div>";
			echo" <div class='row'><label for='secret-stripe' class='col-lg-6 col-sm-6'>Clé secrète Stripe</label><input id='secret-stripe' type='text' name='secretStripe' value='".$this->_config['secret_stripe']."' /></div>";			
			echo" <div class='row'><label for='public-stripe' class='col-lg-6 col-sm-6'>Clé publique Stripe</label><input id='public-stripe' type='text' name='publicStripe' value='".$this->_config['public_stripe']."' /></div>";			
			
	}
	
	public function updateConfig()
	{
		$sql = "SELECT * FROM ecommerce_config";
		$reponse = $this->_db->query($sql);
		
		if($reponse->rowCount() == 0)
		{
			$sql2 = "INSERT INTO ecommerce_config ( public_stripe, secret_stripe, devise, pos_devise, sepa_mill, sepa_deci, sepa_mill, gestion_stocks, commentaire, email_notif') VALUES ('".$this->_publicStripe."', '".$this->_secretStripe."', '".$this->_devise."', '".$this->_pos_devise."', '".$this->_sepa_mill."', '".$this->_sepa_deci."', '".$this->sepa_mill."', '".$this->_gestion_stocks."', '".$this->_commentaire."', '".$this->_email_notif."')";
			$reponse2 = $this->_db->query($sql2);
		}
		else
		{
			$sql2 = "UPDATE ecommerce_config SET public_stripe='".$this->_publicStripe."', secret_stripe='".$this->_secretStripe."', devise='".$this->_devise."', pos_devise='".$this->_pos_devise."',sepa_mill='".$this->_sepa_mill."', sepa_deci='".$this->_sepa_deci."', sepa_mill='".$this->sepa_mill."', gestion_stocks='".$this->_gestion_stocks."', commentaire='".$this->_commentaire."', email_notif='".$this->_email_notif."'";
			$reponse2 = $this->_db->query($sql2);
		}
	}
	
	public function displayShop()
	{
		$file=array();
		$files1 = scandir('wireframes/produits');
		//print_r($files1);
		foreach($files1 as $produitsFiles)
		{
			if($produitsFiles != ".." AND $produitsFiles != ".")
			{
				$contentFile = scandir('wireframes/produits/'.$produitsFiles);
				$file[$produitsFiles] = $contentFile;
			}
			
		}
		#print_r($file);
		echo "<div class='col-md-10 col-md-offset-1' style='margin-bottom:20px; margin-top:-20px;'>";
			echo "<a href='menu.php' title='Personnaliser le menu' class='linkButton btn-action col-md-12'>Personnaliser le menu</a>";
		echo "</div>";
		echo "<div class='col-md-6'>";
			echo "<p class='text-center' style='margin-bottom:5px;'>Miniatures produits</p>";
			echo "<div class='col-sm-12 wireframe_page'><img src='wireframes/produits/".$this->_config['thumb_produit']."/preview_2.png' width='100%'></div>";
			echo "<div class='col-md-2 col-md-offset-4'><input type='button' data-action='#miniatureChoice' class='btn-action' value='Choisir' data-toggle='modal' data-target='#miniatureProduits'/></div>";
		echo "</div>";
		echo '<div class="modal fade bs-example-modal-lg" id="miniatureProduits" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog modal-lg" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="myModalLabel">Miniatures Produits</h4>
			      </div>
			      <div class="modal-body">';
					foreach($file as $key => $contentFile)
					{
						echo '<div class="col-lg-3 col-md-3 col-sm-4 ">';
						if($this->_config['thumb_produit'] == $key)
						{
							
							echo '<div data-id="'.$key.'" data-modal="1" class="wireframe_miniatures activeWireframe">';
						}
						else
						{
							
							echo '<div data-id="'.$key.'" data-modal="1" class="wireframe_miniatures">';
						}
									echo '
									
										<img style="width: 100%;" src="wireframes/produits/'.$key.'/'.$contentFile[3].'">
										<div style="display: none" class="desc"></div>
									</div>
								</div>';
					}			      
			      	echo '
			      </div>
			      <div class="modal-footer" style="clear:both;">
			      <form action method="POST">
			        <input type="hidden" id="thumbProd-1" name="thumbProd" value="'.$this->_config['thumb_produit'].'"/> 
			        <input type="submit" name="updateThumbProd" value="Sauvegarder" />
			       </form>
			      </div>
			    </div>
			  </div>
			</div>';
		
		$file=array();
		$files1 = scandir('wireframes/categories');
		//print_r($files1);
		foreach($files1 as $categoriesFiles)
		{
			if($categoriesFiles != ".." AND $categoriesFiles != ".")
			{
				$contentFile = scandir('wireframes/categories/'.$categoriesFiles);
				$file[$categoriesFiles] = $contentFile;
			}
			
		}
		
		echo "<div class='col-md-6'>";
			echo "<p class='text-center' style='margin-bottom:5px;'>Catalogue</p>";
			echo "<div class='col-sm-12 wireframe_page'><img src='wireframes/categories/".$this->_config['thumb_category']."/preview_2.png' width='100%'></div>";
			echo "<div class='col-md-2 col-md-offset-4'><input type='button' data-action='#miniatureChoice' class='btn-action' value='Choisir' data-toggle='modal' data-target='#miniatureCategories'/></div>";
		echo "</div>";
		echo '<div class="modal fade bs-example-modal-lg" id="miniatureCategories" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog modal-lg" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="myModalLabel">Affichage du catalogue</h4>
			      </div>
			      <div class="modal-body">';
					foreach($file as $key => $contentFile)
					{
						echo '<div class="col-lg-3 col-md-3 col-sm-4 ">';
						if($this->_config['thumb_category'] == $key)
						{
							
							echo '<div data-id="'.$key.'" data-modal="2" class="wireframe_miniatures activeWireframe">';
						}
						else
						{
							
							echo '<div data-id="'.$key.'" data-modal="2" class="wireframe_miniatures">';
						}
									echo '
									
										<img style="width: 100%;" src="wireframes/categories/'.$key.'/'.$contentFile[3].'">
										<div style="display: none" class="desc"></div>
									</div>
								</div>';
					}			      
			      	echo '
			      </div>
			      <div class="modal-footer" style="clear:both;">
			      <form action method="POST">
			        <input type="hidden" id="thumbProd-2" name="thumbProd" value="'.$this->_config['thumb_category'].'"/> 
			        <input type="submit" name="updateThumbCat" value="Sauvegarder" />
			       </form>
			      </div>
			    </div>
			  </div>
			</div>';
		
		$file=array();
		$files1 = scandir('wireframes/fiche_produit');
		//print_r($files1);
		foreach($files1 as $ficheFiles)
		{
			if($ficheFiles != ".." AND $ficheFiles != ".")
			{
				$contentFile = scandir('wireframes/fiche_produit/'.$ficheFiles);
				$file[$ficheFiles] = $contentFile;
			}
			
		}
		
		echo "<div class='col-md-6'>";
			echo "<p class='text-center' style='margin-bottom:5px;'>Fiches produits</p>";
			echo "<div class='col-sm-12 wireframe_page'><img src='wireframes/fiche_produit/".$this->_config['fiche_produit']."/preview_2.png' width='100%'></div>";
			echo "<div class='col-md-2 col-md-offset-4'><input type='button' data-action='#miniatureChoice' class='btn-action' value='Choisir' data-toggle='modal' data-target='#ficheProduit'/></div>";
		echo "</div>";
		echo '<div class="modal fade bs-example-modal-lg" id="ficheProduit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog modal-lg" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="myModalLabel">Fiches produit</h4>
			      </div>
			      <div class="modal-body">';
					foreach($file as $key => $contentFile)
					{
						echo '<div class="col-lg-3 col-md-3 col-sm-4 ">';
						if($this->_config['fiche_produit'] == $key)
						{
							
							echo '<div data-id="'.$key.'" data-modal="3" class="wireframe_miniatures activeWireframe">';
						}
						else
						{
							
							echo '<div data-id="'.$key.'" data-modal="3" class="wireframe_miniatures">';
						}
									echo '
									
										<img style="width: 100%;" src="wireframes/fiche_produit/'.$key.'/'.$contentFile[3].'">
										<div style="display: none" class="desc"></div>
									</div>
								</div>';
					}			      
			      	echo '
			      </div>
			      <div class="modal-footer" style="clear:both;">
			      <form action method="POST">
			        <input type="hidden" id="thumbProd-3" name="thumbProd" value="'.$this->_config['thumb_category'].'"/> 
			        <input type="submit" name="updateFiche" value="Sauvegarder" />
			       </form>
			      </div>
			    </div>
			  </div>
			</div>';
		
	}
	
	public function updateDisplayShop()
	{
		$this->_thumb = $_POST['thumbProd'];
		
		if($this->_thumb == null)
		{
			$this->_erreur++;
			$this->_listeErreur[] = "Une erreur est survenue";
		}
		
		if($this->_erreur == 0)
		{
			if(isset($_POST['updateThumbProd']))
			{
				$sql2 = "UPDATE ecommerce_config SET thumb_produit = '".$this->_thumb."'";
			}
			
			if(isset($_POST['updateThumbCat']))
			{
				$sql2 = "UPDATE ecommerce_config SET thumb_category = '".$this->_thumb."'";
			}
			
			if(isset($_POST['updateFiche']))
			{
				$sql2 = "UPDATE ecommerce_config SET fiche_produit = '".$this->_thumb."'";
			}
			//$sql2 = "UPDATE ecommerce_config SET thumb_produit = '".$this->_thumb."'";
			$reponse2 = $this->_db->query($sql2);
			$fusionDesErreurs = implode("<br/>", $this->_listeErreur);
			$this->_listeErreur = "<div class='rapport cadre col-sm-12 col-lg-12'>";
			$this->_listeErreur .= "<h3>Rapport</h3>";
			$this->_listeErreur .= "<div class='success'>L'affichage de la boutique à bien été modifié</div>";
			$this->_listeErreur .= "</div>";
			
		}else{

			$fusionDesErreurs = implode("<br/>", $this->_listeErreur);
			$this->_listeErreur = "<div class='rapport cadre col-sm-12 col-lg-12'>";
			$this->_listeErreur .= "<h3>Rapport</h3>";
			$this->_listeErreur .= "<div class='fail'>$fusionDesErreurs</div>";
			$this->_listeErreur .= "</div>";
		}
		
	}
	
	public function CGV()
	{
		$this->_config = array();
		$sql = "SELECT cgv, formulaire_retract, delais_retract FROM ecommerce_config";
		$reponse = $this->_db->query($sql);
		while($donnees = $reponse->fetch())
		{
			$this->_config = $donnees;
		}
		
		$retract = json_decode($this->_config['delais_retract'], true);
		echo "<div class='row'><label class='col-lg-12 col-sm-12' for='wysiwyg'>Conditions générales</label><textarea class='wysiwyg' name='cgv'>".$this->_config['cgv']."</textarea></div>";
		echo "<div class='row'><label class='col-lg-3' for=''>Délais rétractation</label><input type='number' name='delais_retract' value='".$retract['delais']."'/>
				<select name='unite_retract'>";
					if($retract['unite'] == 'days')
					{
						echo "<option value='days' selected>jours</option>";
					}
					else
					{
						echo "<option value='days'>jours</option>";
					}
					if($retract['unite'] == 'month')
					{
						echo "<option value='month' selected>mois</option>";
					}
					else
					{
						echo "<option value='month'>mois</option>";
					}
					if($retract['unite'] == 'year')
					{
						echo "<option value='year' selected>années</option>";
					}
					else
					{
						echo "<option value='year'>année</option>";
					}
					echo "
				</select>
				</div>";
		echo "<div class='col-sm-12' style='margin-top: 20px;'><label for='file' class='col-sm-6'>Formulaire de rétractation&nbsp&nbsp</label><input type='button' class='col-sm-4 btn-action' value='Parcourir' id='file_btn'/><input name='file' id='file' accept='application/pdf' type='file'></div>";
		echo "<div class='col-sm-12' style='margin-top: 20px; margin-bottom:20px;'>Formulaire de rétractation actuel : <a target='_blank' href='content/files/".$this->_config['formulaire_retract']."' title='Formulaire de rétractation actuel'>".$this->_config['formulaire_retract']."</a></div>";
	}
	
	public function formatageFile($texte)
	{
		$accent='ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËéèêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ';
		$noaccent='aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn';
		$texte = strtr($texte,$accent,$noaccent);
		$texte = str_replace(" ","_",$texte);

		$texte = preg_replace('/([^.a-z0-9]+)/i', '-', $texte);
		
		
		return $texte;
	}
	
	public function updateCGV()
	{
		if($_FILES['file']['name'] != "")
		{
			$sqlFile = "SELECT formulaire_retract FROM ecommerce_config";
			$reponseFile = $this->_db->query($sqlFile);
			while($donneesFile = $reponseFile->fetch())
			{
				unlink('content/files/'.$donneesFile['formulaire_retract']);
			}
			
			$sql2 = "UPDATE ecommerce_config SET cgv='".$this->_cgv."', formulaire_retract='".$this->_nomDuFichier."', delais_retract='".$this->_retract."'";
		}
		else
		{
			$sql2 = "UPDATE ecommerce_config SET cgv='".$this->_cgv."', delais_retract='".$this->_retract."'";
		}
		
		$reponse2 = $this->_db->query($sql2);
	}
	
	public function Verification()
	{
		if(isset($_POST['addCat']) AND $_POST['addCat'] != null)
		{
			
			$this->_nomCategorie = $_POST['addCat'];
			//$this->_nomCategorie = str_replace("'", "''", $this->_nomCategorie);
			$this->_nomCategorie = addslashes(json_encode($this->_nomCategorie,JSON_FORCE_OBJECT|JSON_UNESCAPED_UNICODE));
			
			$this->_parentCategorie = $_POST['idCtg'];
			
			if($this->_nomCategorie == null)
			{
				$this->_erreur++;
				$this->_listeErreur[] = "Merci de renseigner le nom de la catégorie";
			}
			
			if($this->_erreur == 0)
			{
				$this->insertCategorie();
				$fusionDesErreurs = implode("<br/>", $this->_listeErreur);
				$this->_listeErreur = "<div class='rapport cadre col-sm-12 col-lg-12'>";
				$this->_listeErreur .= "<h3>Rapport</h3>";
				$this->_listeErreur .= "<div class='success'>La catégorie a été ajoutée</div>";
				$this->_listeErreur .= "</div>";
			}
			else
			{

				$fusionDesErreurs = implode("<br/>", $this->_listeErreur);
				$this->_listeErreur = "<div class='rapport cadre col-sm-12 col-lg-12'>";
				$this->_listeErreur .= "<h3>Rapport</h3>";
				$this->_listeErreur .= "<div class='fail'>$fusionDesErreurs</div>";
				$this->_listeErreur .= "</div>";
			}
		}
		
		if(isset($_POST['editName']) AND $_POST['editName'] != null)
		{
			$this->_nomCategorie = $_POST['editName'];
			//$this->_nomCategorie = str_replace("'", "''", $this->_nomCategorie);
			$this->_nomCategorie = addslashes(json_encode($this->_nomCategorie,JSON_FORCE_OBJECT|JSON_UNESCAPED_UNICODE));
			
			if($this->_nomCategorie == null)
			{
				$this->_erreur++;
				$this->_listeErreur[] = "Merci de renseigner le nom de la catégorie";
			}
			
			if($this->_erreur == 0)
			{
				$this->updateCategory();
				$fusionDesErreurs = implode("<br/>", $this->_listeErreur);
				$this->_listeErreur = "<div class='rapport cadre col-sm-12 col-lg-12'>";
				$this->_listeErreur .= "<h3>Rapport</h3>";
				$this->_listeErreur .= "<div class='success'>La catégorie a été modifiée</div>";
				$this->_listeErreur .= "</div>";
			}
			else
			{

				$fusionDesErreurs = implode("<br/>", $this->_listeErreur);
				$this->_listeErreur = "<div class='rapport cadre col-sm-12 col-lg-12'>";
				$this->_listeErreur .= "<h3>Rapport</h3>";
				$this->_listeErreur .= "<div class='fail'>$fusionDesErreurs</div>";
				$this->_listeErreur .= "</div>";
			}
		}		
		
		
		if(isset($_POST['updateCGV']) AND $_POST['updateCGV'] != null)
		{
			$this->_cgv = $_POST['cgv'];
			$this->_pdf = $_FILES['file'];
			$this->_delais_retract = $_POST['delais_retract'];
			
			
			$this->_unite_retract = $_POST['unite_retract'];
			$this->_retract = array("delais" => $this->_delais_retract, "unite" => $this->_unite_retract);
			$this->_retract = json_encode($this->_retract, true);
			
			if($this->_pdf['name'] == null)
			{
				if($this->_cgv == null)
				{
					$this->_erreur++;
					$this->_listeErreur[] = "Merci de renseigner les conditions générales de ventes";
				}
				
				if($this->_delais_retract == null)
				{
					$this->_erreur++;
					$this->_listeErreur[] = "Merci de renseigner les délais de rétractation";
				}
				
				if($this->_unite_retract == null)
				{
					$this->_erreur++;
					$this->_listeErreur[] = "Merci de renseigner l'unité des délais de rétractation";
				}
				
				if($this->_unite_retract == 'days' AND $this->_delais_retract < 14)
				{
					$this->_erreur++;
					$this->_listeErreur[] = "Le délais de rétractation minimum légal est de 14 jours";
				}
				
				if($this->_erreur == 0)
				{
					$this->updateCGV();
					$fusionDesErreurs = implode("<br/>", $this->_listeErreur);
					$this->_listeErreur = "<div class='rapport cadre col-sm-12 col-lg-12'>";
					$this->_listeErreur .= "<h3>Rapport</h3>";
					$this->_listeErreur .= "<div class='success'>Les conditions générales de ventes ont été modifiées</div>";
					$this->_listeErreur .= "</div>";
				}
				else
				{
	
					$fusionDesErreurs = implode("<br/>", $this->_listeErreur);
					$this->_listeErreur = "<div class='rapport cadre col-sm-12 col-lg-12'>";
					$this->_listeErreur .= "<h3>Rapport</h3>";
					$this->_listeErreur .= "<div class='fail'>$fusionDesErreurs</div>";
					$this->_listeErreur .= "</div>";
				}
			}
			else
			{

				if($this->_pdf['name'] != "")
				{
					if($this->_pdf['type'] != "application/pdf")
					{
						$this->_erreur++;
						$this->_listeErreur[] = "Le format n'est pas supporté";
					}
					
					if($this->_cgv == null)
					{
						$this->_erreur++;
						$this->_listeErreur[] = "Merci de renseigner les conditions générales de ventes";
					}
					
					if($this->_delais_retract == null)
					{
						$this->_erreur++;
						$this->_listeErreur[] = "Merci de renseigner les délais de rétractation";
					}
					
					if($this->_unite_retract == null)
					{
						$this->_erreur++;
						$this->_listeErreur[] = "Merci de renseigner l'unité des délais de rétractation";
					}
					
					if($this->_unite_retract == 'days' AND $this->_delais_retract < 14)
					{
						$this->_erreur++;
						$this->_listeErreur[] = "Le délais de rétractation minimum légal est de 14 jours";
					}

					$this->_nomDuFichier = 'formulaire_retractation.pdf';
					$fichierTemporaire = $this->_pdf['tmp_name'];
		
					if(!move_uploaded_file($fichierTemporaire, "content/files/".$this->_nomDuFichier))
					{
						$this->_erreur++;
						$this->_listeErreur[] = "Upload impossible";
					}			
				}
				
				if($this->_erreur == 0)
				{
					$this->updateCGV();
					$fusionDesErreurs = implode("<br/>", $this->_listeErreur);
					$this->_listeErreur = "<div class='rapport cadre col-sm-12 col-lg-12'>";
					$this->_listeErreur .= "<h3>Rapport</h3>";
					$this->_listeErreur .= "<div class='success'>Les conditions générales de ventes ont été modifiées</div>";
					$this->_listeErreur .= "</div>";
				}
				else
				{
	
					$fusionDesErreurs = implode("<br/>", $this->_listeErreur);
					$this->_listeErreur = "<div class='rapport cadre col-sm-12 col-lg-12'>";
					$this->_listeErreur .= "<h3>Rapport</h3>";
					$this->_listeErreur .= "<div class='fail'>$fusionDesErreurs</div>";
					$this->_listeErreur .= "</div>";
				}
			}

		}
		
		if(isset($_POST['updateConfig']) AND $_POST['updateConfig'] != null)
		{
			$this->_devise = $_POST['devise'];
			$this->_sepa_mill = $_POST['sepa_mill'];
			$this->_sepa_deci = $_POST['sepa_deci'];
			$this->_commentaire = $_POST['commentaire'];
			$this->_gestion_stocks = $_POST['gestion_stocks'];
			$this->_email_notif = $_POST['email_notif'];
			$this->_pos_devise = $_POST['pos_devise'];
			$this->_secretStripe = $_POST['secretStripe'];
			$this->_publicStripe = $_POST['publicStripe'];
			
			if($this->_devise == null)
			{
				$this->_erreur++;
				$this->_listeErreur[] = "Merci de renseigner une devise";
			}
			
			if($this->_secretStripe == null)
			{
				$this->_erreur++;
				$this->_listeErreur[] = "Merci de renseigner votre clé secrète Stripe";
			}
			
			if($this->_publicStripe == null)
			{
				$this->_erreur++;
				$this->_listeErreur[] = "Merci de renseigner votre clé publique Stripe";
			}
			
			
			if($this->_email_notif == null)
			{
				$this->_erreur++;
				$this->_listeErreur[] = "Merci de renseigner un e-mail de notification";
			}
			
			if($this->_erreur == 0)
			{
				$this->updateConfig();
				$fusionDesErreurs = implode("<br/>", $this->_listeErreur);
				$this->_listeErreur = "<div class='rapport cadre col-sm-12 col-lg-12'>";
				$this->_listeErreur .= "<h3>Rapport</h3>";
				$this->_listeErreur .= "<div class='success'>La configuration à bien été modifiée</div>";
				$this->_listeErreur .= "</div>";
				
			}else{

				$fusionDesErreurs = implode("<br/>", $this->_listeErreur);
				$this->_listeErreur = "<div class='rapport cadre col-sm-12 col-lg-12'>";
				$this->_listeErreur .= "<h3>Rapport</h3>";
				$this->_listeErreur .= "<div class='fail'>$fusionDesErreurs</div>";
				$this->_listeErreur .= "</div>";
			}
		}

	}
		
	public function configTVA()
	{
		$sql = "SELECT * FROM tva";
			$reponse = $this->_db->query($sql);
			$count = $reponse->rowCount();
						
			echo "
				<table id='tabTVA' class='display' cellspacing='0' width='100%'>
			        <thead>
			            <tr>
			                <th>Pays</th>
			                <th>Standard (%)</th>
			                <th>Réduit (%)</th>
			                <th>Super réduit (%)</th>
			            </tr>
			        </thead>
			        <tfoot>
			            <tr>
			                <th>Pays</th>
			                <th>Standard</th>
			                <th>Réduit</th>
			                <th>Super réduit</th>
			            </tr>
			        </tfoot>
			        <tbody>";
						
						while($donnees = $reponse->fetch())
						{
							echo"
							<tr>
								<td>".$donnees['pays']."</td>
								<td>".$donnees['standard']."</td>
								<td>".$donnees['reduit']; if($donnees['reduit'] != $donnees['reduit_alt']){echo "/".$donnees['reduit_alt'];} echo"</td>
								<td>".$donnees['super_reduit']."</td>
							</tr>
							";
						}
			echo "</tbody></table>";
	}
	
	public function configLivraison()
	{
		echo "
			<div>
				<ul class='nav nav-tabs' role='tablist'>
			    	<li role='presentation' class='active'><a href='#nationale' aria-controls='home' role='tab' data-toggle='tab'>Nationale</a></li>
					<li role='presentation'><a href='#internationale' aria-controls='messages' role='tab' data-toggle='tab'>Internationale</a></li>
					<li role='presentation'><a href='#point-de-vente' aria-controls='settings' role='tab' data-toggle='tab'>Point de vente</a></li>
				</ul>
			
				<div class='tab-content'>
					<div role='tabpanel' class='tab-pane active' id='nationale'>
						<div class='row text-center' style='margin-bottom:15px; margin-top:15px;'>
							<div class='col-md-4'><strong>Nom</strong></div>
							<div class='col-md-4'><strong>Montant min.</strong></div>
							<div class='col-md-4'><strong>Prix</strong></div>
						</div>";
						$sql2 = "SELECT devise, sepa_deci, sepa_mill, pos_devise FROM ecommerce_config";
						$reponse2 = $this->_db->query($sql2);
						while($donnees2 = $reponse2->fetch())
						{
							$deci=$donnees2['sepa_deci'];
							$mill=$donnees2['sepa_mill'];
							$devise=$donnees2['devise'];
							$pos=$donnees2['pos_devise'];
						}
						$sql = "SELECT * FROM livraison WHERE type='nationale'";
						$reponse = $this->_db->query($sql);
						while($donnees = $reponse->fetch())
						{
							echo "
								<div class='row text-center liste'>
									<div class='col-md-4'><a href='deliveryMethod.php?id=".$donnees['id']."' title='Modifier le moyen de livraison ".$donnees['nom']."' class='delivery-name'>".$donnees['nom']."</a></div>
									<div class='col-md-4'>"; if($pos == 'before-space'){echo $devise.' ';} if($pos == 'before'){echo $devise;} echo number_format($donnees['montant_min'], 2 , $deci, $mill); if($pos == 'after-space'){echo ' '.$devise;} if($pos == 'after'){echo $devise;} echo"</div><div class='col-md-4'>"; if($pos == 'before-space'){echo $devise.' ';} if($pos == 'before'){echo $devise;} echo number_format($donnees['prix_pourcent'], 2 , $deci, $mill); if($pos == 'after-space'){echo ' '.$devise;} if($pos == 'after'){echo $devise;} echo"</div>
								</div>";
						}
					echo 
					"</div>
					<div role='tabpanel' class='tab-pane' id='internationale'>";

						echo"
						<div class='row text-center' style='margin-bottom:15px; margin-top:15px;'>
							<div class='col-md-4'><strong>Nom</strong></div>
							<div class='col-md-4'><strong>Montant min.</strong></div>
							<div class='col-md-4'><strong>Prix</strong></div>
						</div>";
						$sql3 = "SELECT * FROM livraison WHERE type='internationale'";
						$reponse3 = $this->_db->query($sql3);
						while($donnees3 = $reponse3->fetch())
						{
							echo "
								<div class='row text-center liste'>
									<div class='col-md-4'><a href='deliveryMethod.php?id=".$donnees3['id']."' title='Modifier le moyen de livraison ".$donnees3['nom']."' class='delivery-name'>".$donnees3['nom']."</a></div>
									<div class='col-md-4'>"; if($pos == 'before-space'){echo $devise.' ';} if($pos == 'before'){echo $devise;} echo number_format($donnees3['montant_min'], 2 , $deci, $mill); if($pos == 'after-space'){echo ' '.$devise;} if($pos == 'after'){echo $devise;} echo"</div><div class='col-md-4'>"; if($pos == 'before-space'){echo $devise.' ';} if($pos == 'before'){echo $devise;} echo number_format($donnee3['prix_pourcent'], 2 , $deci, $mill); if($pos == 'after-space'){echo ' '.$devise;} if($pos == 'after'){echo $devise;} echo"</div>
								</div>";
						}
		

					echo " </div>
					<div role='tabpanel' class='tab-pane' id='point-de-vente'>";
						echo"
						<div class='row text-center' style='margin-bottom:15px; margin-top:15px;'>
							<div class='col-md-4'><strong>Nom</strong></div>
							<div class='col-md-4'><strong>Montant min.</strong></div>
							<div class='col-md-4'><strong>Prix</strong></div>
						</div>";
						$sql4 = "SELECT * FROM livraison WHERE type='point-de-vente'";
						$reponse4 = $this->_db->query($sql4);
						while($donnees4 = $reponse4->fetch())
						{
							echo "
								<div class='row text-center liste'>
									<div class='col-md-4'><a href='deliveryMethod.php?id=".$donnees4['id']."' title='Modifier le moyen de livraison ".$donnees4['nom']."' class='delivery-name'>".$donnees4['nom']."</a></div>
									<div class='col-md-4'>"; if($pos == 'before-space'){echo $devise.' ';} if($pos == 'before'){echo $devise;} echo number_format($donnees4['montant_min'], 2 , $deci, $mill); if($pos == 'after-space'){echo ' '.$devise;} if($pos == 'after'){echo $devise;} echo"</div><div class='col-md-4'>"; if($pos == 'before-space'){echo $devise.' ';} if($pos == 'before'){echo $devise;} echo number_format($donnees4['prix_pourcent'], 2 , $deci, $mill); if($pos == 'after-space'){echo ' '.$devise;} if($pos == 'after'){echo $devise;} echo"</div>
								</div>";
						}
						echo"
					</div>
				</div>
			</div>
		";
	}
	
	public function configCategories()
	{
			echo '<div class="col-md-12"><input type="button" class="btn-action" data-toggle="modal" data-target="#popupCategories" value="Ajouter catégories"/></div>';
			echo "<div class='col-md-12 listeCategory'>";
					$sql5 = "SELECT nom, description, parent, id, image FROM categories ORDER BY id DESC";
					$reponse5 = $this->_db->query($sql5);
					echo "<a href='#' class='retour'>Retour</a>";
					echo "<input type='hidden' value='' id='hideID' />";
					while($donnees5 = $reponse5->fetch())
					{
						$nom = json_decode($donnees5['nom'], true);
						$description = json_decode($donnees5['description'], true);
						//print_r($donnees5);
						echo "<div class='arborescence col-sm-12 visiblePage' data-name=\"".$nom."\" data-description=\"".@$donnees5['description']."\" data-image=\"".@$donnees5['image']."\" data-id='".$donnees5['id']."' data-parent='".$donnees5['parent']."'><span class='col-sm-9 nomCategory'>".$nom['fr']."</span><span class='hidden'><input id='".$donnees5['id']."'type='checkbox' value='".$donnees5['id']."' name='categories[]'></span><button type='button' data-toggle='modal' data-target='.modal-".$donnees5['id']."' class='btn btn-primary col-md-1 editBtn btn-action' data-parent='".$donnees5['parent']."'><i class='fa fa-pencil' aria-hidden='true'></i></button><a class='col-md-1 delBTN' data-parent='".$donnees5['parent']."' href='?deleteCat=".$donnees5['id']."'>✖</a></div>";
						
		echo '<div id="popupEditCategories" class="modal modal-'.$donnees5['id'].' fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
  <form method="POST" action enctype="multipart/form-data">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Editer une catégorie</h4>
        
      
      
      </div>
      <div class="modal-body col-sm-12">';
        echo "<div class='col-sm-12'>".$this->display_all_language()."<br/><br/></div>";
        echo '
      		<input type="hidden" value="'.$donnees5['id'].'" id="editID" name="editID" />
      		';
      		
      		foreach($this->_lg as $key=>$langue)
			{
				echo '<div class="row"><div class="col-sm-12"><input class="col-md-6 lang name-cat-'.$key.'" style="margin-top: -5px" type="text" id="editCat" name="editName['.$key.']" placeholder="Nom de la catégorie" value="'.$nom[$key].'"/></div></div>';
			}
      		
      		#echo '<div class="row"><label class="col-md-4">Nom</label><input class="col-md-6" type="text" id="editName" name="editName" value="'.$nom['fr'].'"/></div>
      		echo '<div class="row"><label class="col-md-12" style="text-align: center">Photo de catégorie</label></div>
      		<div class=""><div style="border: 1px solid #dadada; margin: 10px 0px; height: 300px; text-align: center; line-height: 300px" class="photoCat">';
      			if($donnees5['image'] == '')
      			{
	      			echo '<h3>Pas d\'image</h3>';
      			}
      			else
      			{
      				echo '<img src="content/products/categories/'.$donnees5['image'].'" style="max-height: 100%; max-width: 100%">';     			
      			}
      		echo '
      		</div></div>
      		<div class="row"><label class="col-md-4">Changer la photo</label><input class="col-md-8" name="fileCat" type="file" id="fileCat"/></div>';
      		
			foreach($this->_lg as $key=>$langue)
			{
				echo "<div class=''><textarea class='col-md-12 lang desc-cat-".$key."' id='descCat' name='editDescription[".$key."]' placeholder='Description de la catégorie'>".$description[$key]."</textarea></div>";
				 
			}
      		
      		echo '
      </div>
      <div class="modal-footer">
        <input type="submit" id="editCategorieButton" class="btn-action" value="Sauvegarder"/>
      </div>
      </div><!-- /.modal-content -->
      </form>
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->';						
						
					
					}
					
					echo "
				</div>";
				
				
				
				$this->addCategory();
				//$this->editCategory();
	}
	
	public function addCategory()
	{
		echo 
		'<div id="popupCategories" class="modal fade" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<form id="configCat" method="POST" enctype="multipart/form-data">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title">Ajouter une catégorie</h4>
						</div>
						<div class="modal-body">
							<div class="col-sm-12" style="margin-bottom:10px; padding-left: 0">';
								$this->display_all_language();
								echo "
							</div>
							<div class='row'>
								<div class='col-md-12'>";
									foreach($this->_lg as $key=>$langue)
									{
										echo "<input class='col-md-6 lang name-cat name-cat-".$key."' data-lang='".$key."' style='margin-top: -5px' type='text' id='addCat' name='addCat[".$key."]' placeholder='Nom de la catégorie'/>";
									}
									echo "
									<input class='col-md-6' type='file' name='imgCat' id='imgCat'><br/>";
									foreach($this->_lg as $key=>$langue)
									{
										echo "<textarea class='col-md-12 lang desc-cat-".$key."' id='descCat' name='descCat[".$key."]' placeholder='Description de la catégorie'></textarea>";
										 
									}
									echo "
								</div>";
								$sqlID = "SELECT MAX(id) FROM categories"; 
								$reponseID = $this->_db->query($sqlID); 
								while($donneesID = $reponseID->fetch())
								{
									echo "<input type='hidden' value='".($donneesID['MAX(id)']+1)."' id='laID'>";
								} 
								echo"<input id='idCtg' name='idCtg' type='hidden' value=''><input type='submit' id='envoyer' value='Envoyer' class='hidden' name='addCatBtn'/>
							</div>";
							echo 
						'</div>
						<div class="modal-footer">
							<input type="submit" id="addCategorieButton" data-dismiss="modal" class="btn-action" value="Sauvegarder">
						</div>
					</form><!-- /.modal-content -->
				</div>
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->';

		
	
	}
	
	
	public function editCategory()
	{
		echo '<div id="popupEditCategories" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
  <form method="POST" action enctype="multipart/form-data">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Editer une catégorie</h4>
      </div>
      <div class="modal-body">
      		<input type="hidden" value="" id="editID" name="editID" />
      		<div class="row"><label class="col-md-4">Nom</label><input class="col-md-6" type="text" id="editName" name="editName" value=""/></div>
      		<div class="row"><label class="col-md-12" style="text-align: center">Photo de catégorie</label></div>
      		<div class="col-md-12"><div style="border: 1px solid #dadada; margin: 10px 0px; height: 300px; text-align: center; line-height: 300px" class="photoCat col-md-12">
      		</div></div>
      		<div class="row"><label class="col-md-4">Changer la photo</label><input class="col-md-8" name="fileCat" type="file" id="fileCat"/></div>
      		<div class="row"><label class="col-md-4">Description</label><textarea class="col-md-6" name="editDescription" id="editDescription"></textarea></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
        <input type="submit" id="editCategorieButton" class="btn-action" value="Sauvegarder">
      </div>
      </div><!-- /.modal-content -->
      </form>
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->';		
	}
	
	public function deleteCat($id){
		
		$this->_deleteCat = $id;	

		$sql = "SELECT * FROM categories WHERE parent = ".$this->_deleteCat;
		$reponse = $this->_db->query($sql);
		
		$sqlDelCat = "DELETE FROM categories WHERE id=".$this->_deleteCat;
		$this->_db->exec($sqlDelCat);
		
		if($reponse->rowCount() != 0)
		{
			while($donnees = $reponse->fetch())
			{
				$this->deleteCat($donnees['id']);
			}
		}
		

	}

	public function updateFacturation()
	{
		if(isset($_POST['updateFacturation']))
		{
			$this->_deno = $_POST['nom'];
			$this->_email = $_POST['email'];
			$this->_tva = $_POST['TVA'];
			$this->_adresse = $_POST['adresse'];
			$this->_cp = $_POST['code_postal'];
			$this->_ville = $_POST['ville'];
			$this->_pays = $_POST['pays'];
			
			$sql = "SELECT * FROM ecommerce_config";
			$reponse = $this->_db->query($sql);
			
			if($reponse->rowCount() == 0)
			{
				$sql = "INSERT INTO ecommerce_config (deno_sociale, email, tva, adresse, code_postal, ville, pays) VALUES ('".$this->_deno."', '".$this->_email."', '".$this->_tva."', '".$this->_adresse."', '".$this->_cp."', '".$this->_ville."', '".$this->_pays."')";
				$reponse = $this->_db->exec($sql);
			}
			else
			{
				$sql = "UPDATE ecommerce_config SET deno_sociale = '".$this->_deno."', email = '".$this->_email."', tva = '".$this->_tva."', adresse = '".$this->_adresse."', code_postal = '".$this->_cp."', ville = '".$this->_ville."', pays = '".$this->_pays."'";
				$reponse = $this->_db->exec($sql);
			}
			
			
			
		}
	}

	public function updateCategory()
	{
		if($_FILES['fileCat']['name'] != "")
		{
			$image = $this->formatageFile($_FILES['fileCat']['name']);
			$tmpName = $_FILES['fileCat']['tmp_name'];
			if(!file_exists("content/products/categories"))
			{
				mkdir("content/products/categories", 777);
			}
			if(move_uploaded_file($tmpName, "content/products/categories/".$image))
			{
				echo "ok";
			}	
			else
			{
				echo "error";
			}
			$request = ", image = '$image' ";
		}
		else
		{
			$image = "";
			$request = "";
		}
		
		$descCat = str_replace("'","''", $_POST['editDescription']);
		$descCat = addslashes(json_encode($descCat,JSON_FORCE_OBJECT|JSON_UNESCAPED_UNICODE));
		$descCat = str_replace("'", "''", $descCat);

				
		$sql = "UPDATE categories SET nom = '".$this->_nomCategorie."', description = '".$descCat."' $request WHERE ID = ".$_POST['editID'];
		$reponse = $this->_db->query($sql);		
		
	}
	
	public function insertCategorie()
	{
		
		
		if($_FILES['imgCat']['name'] != "")
		{
			$image = $this->formatageFile($_FILES['imgCat']['name']);
			$tmpName = $_FILES['imgCat']['tmp_name'];
			if(!file_exists("content/products/categories"))
			{
				mkdir("content/products/categories", 777);
			}
			move_uploaded_file($tmpName, "content/products/categories/".$image);	
		}
		else
		{
			$image = "";
		}
		
		$descCat = $_POST['descCat'];
		$descCat = json_encode($descCat,JSON_FORCE_OBJECT|JSON_UNESCAPED_UNICODE);
		$descCat = str_replace("'","''", $descCat);
		
		if($this->_parentCategorie != null)
		{
			$sql ="SELECT * FROM categories WHERE id = '".$this->_parentCategorie."'";
			$reponse = $this->_db->query($sql);
			while($donnees = $reponse->fetch()){
				$sql = "INSERT INTO categories (nom, description, parent, image) VALUES ('".$this->_nomCategorie."', '".$descCat."','".$donnees['id']."', '".$image."')";
				$this->_db->exec($sql);
				
				$lastID = $this->_db->lastInsertId();
				
				$tableauNewChild = json_decode($donnees['child']);
				$tableauNewChild[] = $lastID;
				$sql = "UPDATE categories SET child = '".json_encode($tableauNewChild)."' WHERE ID = ".$donnees['id'];
				$reponse = $this->_db->query($sql);
				
			}	
			
			
			
		}else{
			$sql = "INSERT INTO categories (nom, description, image) VALUES ('".$this->_nomCategorie."', '".$descCat."', '".$image."')";
			$this->_db->exec($sql);
		}
		
		
		
	}

	public function displayFacturation()
	{
		$this->_config = array();
		$sql = "SELECT * FROM ecommerce_config";
		$reponse = $this->_db->query($sql);
		while($donnees = $reponse->fetch())
		{
			$this->_config = $donnees;
		}
			$this->_deno = $this->_config['deno_sociale'];
			$this->_email = $this->_config['email'];
			$this->_telephone = $this->_config['telephone'];
			$this->_tva = $this->_config['tva'];
			$this->_adresse = $this->_config['adresse'];
			$this->_cp = $this->_config['code_postal'];
			$this->_ville = $this->_config['ville'];
			$this->_pays = $this->_config['pays'];
			
			echo "<div class='row'><label class='col-lg-4 col-sm-4' for='nom'>Dénomination sociale</label><input type=\"text\" name=\"nom\" class='col-sm-6 col-lg-6' value='".$this->_deno."' /></div>
						<div class='row'><label class='col-lg-4 col-sm-4' for='email'>E-mail</label><input type=\"email\" name=\"email\" class='col-sm-6 col-lg-6' value='".$this->_email."' /></div>
						<div class='row'><label class='col-lg-4 col-sm-4' for='TVA'>N° TVA</label><input type=\"text\" name=\"TVA\" class='col-sm-6 col-lg-6' value='".$this->_tva."' /></div>
						<div class='row'><label class='col-lg-4 col-sm-4' for='adresse'>Adresse</label><input type=\"text\" name=\"adresse\" class='col-sm-6 col-lg-6' value='".$this->_adresse."' /></div>
						<div class='row'><label class='col-lg-4 col-sm-4' for='code_postal'>Code Postal</label><input type=\"text\" name=\"code_postal\" class='col-sm-6 col-lg-6' value='".$this->_cp."' /></div>
						<div class='row'><label class='col-lg-4 col-sm-4' for='ville'>Ville</label><input type=\"text\" name=\"ville\" class='col-sm-6 col-lg-6' value='".$this->_ville."' /></div>
						<div class='row'><label class='col-lg-4 col-sm-4' for='pays'>Pays</label><input type=\"text\" name=\"pays\" class='col-sm-6 col-lg-6' value='".$this->_pays."' /></div>
					";
		
	}
	
}
?>

