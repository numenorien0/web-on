<?php
class Rapports extends DB
{
	private $_db;
	private $_paiement;
	private $_livraison;
	private $_tempsPassation;
	private $_device;
	private $_format;
	public $_lang;
	public $_langName;
		
	public function __construct()
	{
		setlocale(LC_ALL, 'fr_FR.utf8','fra');
		$this->_db = parent::__construct();
	}
	
	public function verticalMenu()
	{
		echo "<div class='col-md-12 cadre'>";
			echo "<ul id='nav-tabs-wrapper' class='nav nav-pills nav-stacked'>";
				echo "<li><a href='?tab=vuedensemble'>Ventes</a></li>";
				echo "<li><a href='?tab=clients'>Clients</a></li>";
				echo "<li><a href='?tab=produits'>Produits</a></li>";
			echo "</ul>";
		echo "</div>";
	}
	
	public function dataDisplay()
	{
		$this->Recap();
		if(isset($_GET['tab']) AND $_GET['tab'] == 'vuedensemble'){
			echo "<div class='col-md-12 cadre content_wrapper options' style='overflow: visible'>";
				echo "<div class='content_headline' style='margin-bottom:40px; color:#2b4059;'>Statistiques de vente<br><span style='font-size: 12px'>Nombre de ventes</span><br></div>";
				echo "<div class='row buttonDate'><a href='#' class='btn_analytics' id='7daysSalesBtn'>7 jours précédents</a> <a href='#' class='btn_analytics' id='monthSalesBtn'>Ce mois</a>"; if(isset($_GET['startTime']) AND isset($_GET['endTime'])){echo"<a href='#' class='btn_analytics-selected' id='customSalesBtn'>Du ".date("j-m-y",strtotime($_GET['startTime']))." au ".date("j-m-y",strtotime($_GET['endTime']))."</a>"; } echo"<a href='#' class='btn_analytics' id='customSalesInputBtn'>Personnalisé</a>
				<form id='customSalesForm' class='ui-widget-content' action='rapports.php' method='GET'><h6 class='titleForm'>Sélection personnalisée<br><span class='dayDisplay'>Encodage par date décroissante.</span></h6><input type='hidden' value='vuedensemble' name='tab'/>Du <input id='startTime' name='startTime' type='date'> au <input id='endTime' name='endTime' type='date'><br><br>Afficher par mois <input type='checkbox' id='month' name='monthUnit' ><br><span class='dayDisplay'>Affichage par jour par défaut.</span><br><input type='submit' id='custoSalesSubmit' value='Valider'></form></div>";
				$this->SevenDaysSalesChart();
				$this->monthSalesChart();
				if(isset($_GET['startTime']) AND isset($_GET['endTime']))
				{
					$this->CustomSalesChart();
				}
			echo"</div>";
		}
		if(isset($_GET['tab']) AND $_GET['tab'] == 'clients'){
			echo "<div class='col-md-12 cadre options content_wrapper' style='overflow: visible'>";
				echo "<div class='content_headline' style='margin-bottom:80px; color:#2b4059;'>Statistiques clients inscrits<br><span style='font-size: 12px'>Apprenez en plus sur vos clients</span><br></div>";
				
				echo "<p class=' content-subtitle text-center'>Genres</p>";
				echo "<div class='row buttonDate'><a href='#' class='btn_analytics' id='allSexBtn'>Tout</a><a href='#' class='btn_analytics' id='7daysSexBtn'>7 jours précédents</a> <a href='#' class='btn_analytics' id='monthSexBtn'>Ce mois</a>"; if(isset($_GET['startTime']) AND isset($_GET['endTime'])){echo"<a href='#' class='btn_analytics' id='customSexBtn'>Du ".date("j-m-y",strtotime($_GET['startTime']))." au ".date("j-m-y",strtotime($_GET['endTime']))."</a>"; } echo"<a href='#' class='btn_analytics' id='customSexInputBtn'>Personnalisé</a>
				<form id='customSexForm' class='ui-widget-content' action='rapports.php' method='GET'><h6 class='titleForm'>Sélection personnalisée<br><span class='dayDisplay'>Encodage par date décroissante.</span></h6><br /><input type='hidden' value='clients' name='tab'/>Du <input id='startTime' name='startTime' type='date'> au <input id='endTime' name='endTime' type='date'><br><input type='submit' id='custoSexSubmit' value='Valider'></form></div>";
				$this->sexCustomers();
				$this->sex7daysCustomers();
				$this->sexMonthCustomers();
				$this->langData();
				if(isset($_GET['startTime']) AND isset($_GET['endTime']))
				{
					$this->CustomSexChart();
				}
					echo "<p class='content-subtitle text-center' style='padding-top:50px;'>Langues</p>";
					$this->languagesClientsChart();
			echo "</div>";	
		}
		
		if(isset($_GET['tab']) AND $_GET['tab'] == 'produits'){
			echo "<div class='col-md-12 cadre options content_wrapper' style='overflow: visible'>";
				echo "<div class='content_headline' style='margin-bottom:80px; color:#2b4059;'>Statistiques produits<br><span style='font-size: 12px'>Quels sont vos produits phares</span><br></div>";
				
				echo "<p class=' content-subtitle text-center'>Produits les plus vendus</p>";
				echo "<div class='row buttonDate'><a href='?tab=produits&from=' class='btn_analytics' id='allSexBtn'>Tout</a><a href='?tab=produits&from=".strtotime('-7days')."'class='btn_analytics' id='7daysSexBtn'>7 jours précédents</a> <a href='?tab=produits&from=".strtotime('-1month')."' class='btn_analytics' id='monthSexBtn'>Ce mois</a>"; if(isset($_GET['from']) AND isset($_GET['to'])){echo"<a href='#' class='btn_analytics' id='customSexBtn'>Du ".date("j-m-y",strtotime($_GET['from']))." au ".date("j-m-y",strtotime($_GET['to']))."</a>"; } echo"<a href='#' class='btn_analytics' id='customSexInputBtn'>Personnalisé</a>
				<form id='customSexForm' class='ui-widget-content' style='display:none' action='rapports.php' method='GET'><h6 class='titleForm'>Sélection personnalisée<br><span class='dayDisplay'>Encodage par date décroissante.</span></h6><br /><input type='hidden' value='clients' name='tab'/>Du <input id='from' name='from' type='date'> au <input id='to' name='to' type='date'><br><input type='submit' id='custoProdSubmit' value='Valider'></form></div>";
					$this->prVendus();
			echo "</div>";
		}
		
	
	}
	
	public function Recap()
	{
		$this->nbArticlesMoyens();
		print_r($this->_langName);
		echo"<div class='content_wrapper white cadre'>
			<div class='content_headline'>Vue d'ensemble<br><span style='font-size: 12px'>de la boutique e-commerce</span><br></div>

			<div class='main_analytics_item'>
				<div class='main_analytics_item_headline'>Nombre de clients<br>total</div>";
				$this->nbClients();
			echo"
			</div>
			<div class='main_analytics_item'>
				<div class='main_analytics_item_headline'>Nombre de commandes<br>ce mois</div>";
				$this->totalSales();
			echo"
			</div>
			<div class='main_analytics_item'>
				<div class='main_analytics_item_headline'>M-Commerce</div>
				<div class='main_analytics_item_value'>".$this->_device."%</div>
			</div>
			<div class='main_analytics_item'>
				<div class='main_analytics_item_headline'>Taux de <div class='help' explication='Le taux de conversion représente le pourcentage de visiteurs qui passent une commande par rapport au nombre de visite total.'>?</div><br>conversion</div>
				<div class='main_analytics_item_value'>0%</div>
			</div>
			<div class='main_analytics_item'>
				<div class='main_analytics_item_headline'>Taux d'abandon</div>
				<div class='main_analytics_item_value'>0%</div>
			</div>
			<div class='main_analytics_item'>
				<div class='main_analytics_item_headline'>Montant moyen<br />par commande</div>";
				$this->montantMoyenCommande();
			echo"
			</div>
			<div class='main_analytics_item'>
				<div class='main_analytics_item_headline'>Nombre moyen d'articles<br>par commande</div>
				<div class='main_analytics_item_value stat-count'>".$this->_format."</div>	
			</div>
			<div class='main_analytics_item'>
				<div class='main_analytics_item_headline'>Temps de<br>passation de commande</div>
				<div class='main_analytics_item_value'>± ".$this->_tempsPassation." sec</div>
			</div>
			<div class='main_analytics_item'>
				<div class='main_analytics_item_headline'>Moyen de livraison<br> le plus courant</div>
				<div class='main_analytics_item_value'>".ucfirst($this->_livraison)."</div>
			</div>
			<div class='main_analytics_item'>
				<div class='main_analytics_item_headline'>Moyen de paiement<br> le plus courant</div>
				<div class='main_analytics_item_value'>".ucfirst($this->_paiement)."</div>
			</div>
		</div>";
	}
	
	public function SevenDaysSalesChart()
	{
		echo "<div class='salesChart' id='7daysSalesChart'>";
			echo "<div class='col-md-12'><canvas id='myChart'></canvas></div>";
		echo"</div>";
	}
	
	public function CustomSalesChart()
	{
		echo "<div class='salesChart' id='customSalesChart'>";
			echo "<div class='col-md-12'><canvas id='customSalChart'></canvas></div>";
		echo"</div>";
	}
	
	public function monthSalesChart()
	{
		echo "<div class='salesChart' id='monthSalesChart'>";
			echo "<div class='col-md-12'><canvas id='MonthSalChart'></canvas></div>";
		echo "</div>";
	}
	
	public function languagesClientsChart()
	{
			echo "<div><canvas id='languagesClientsChart'></canvas></div>";
	}

	
	public function sexCustomers()
	{
			echo "<div><canvas class='sexChart' id='radarChart'></canvas></div>";
	}
	
	public function sex7daysCustomers()
	{		
			echo "<div><canvas class='sexChart' id='7daysSexChart'></canvas></div>";
	}
	
	public function sexMonthCustomers()
	{	
			echo "<div><canvas class='sexChart' id='monthSexChart'></canvas></div>";
	}
	
	public function CustomSexChart()
	{
			echo "<div><canvas class='sexChart' id='customSexChart'></canvas></div>";
	}
		
	public function nbClients()
	{
		$sql = "SELECT COUNT(id) FROM clients";
		$reponse = $this->_db->query($sql);
		while($donnees = $reponse->fetch())
		{	
			echo "<div class='main_analytics_item_value stat-count'>".$donnees['COUNT(id)']."</div>";
		}
	}
	
	public function prVendus()
	{
			echo "<div><canvas class='prodChart' id='produitsVendus'></canvas></div>";
	}
	
	
	public function load7Days()
	{	
		for ($i = 7; $i >= 1; $i--)
		{
			if($i<=7 AND $i != 1){
				echo "\"".strftime("%A %d", strtotime("-".$i." day"))."\",";
			}
			if($i == 1){
				echo "\"".strftime("%A %d", strtotime("-".$i." day"))."\"";
			}
							
		}		
	}
	
	public function loadCustom()
	{		
		if(isset($_GET['monthUnit'])){
		
			if((strtotime($_GET['endTime']." 23:59:59")) < (strtotime($_GET['startTime']." 00:00:00")))
			{
				$strEnd = strtotime($_GET['startTime']." 00:00:00");
				$strStart = strtotime($_GET['endTime']." 23:59:59");
			}
			else
			{
				$strStart = strtotime($_GET['startTime']." 00:00:00");
				$strEnd = strtotime($_GET['endTime']." 23:59:59");
			}
				$ecart = (((date("Y", $strEnd))-(date("Y", $strStart)))*12)+((date("m", $strEnd))-(date("m", $strStart)));
				for ($i = $ecart; $i >= 0; $i--)
				{
					if($i<=$ecart AND $i != 0)
					{
						echo "\"".strftime("%B %Y", strtotime($_GET['endTime']."-".$i." month"))."\",";
					}
					if($i == 0)
					{
						echo "\"".strftime("%B %Y", strtotime($_GET['endTime']."-".$i." month"))."\"";
					}					
				}
			
		}
		else
		{
			if((strtotime($_GET['endTime']." 23:59:59")) < (strtotime($_GET['startTime']." 00:00:00")))
			{
				$strEnd = strtotime($_GET['startTime']." 00:00:00");
				$strStart = strtotime($_GET['endTime']." 23:59:59");
			}
			else
			{
				$strStart = strtotime($_GET['startTime']." 00:00:00");
				$strEnd = strtotime($_GET['endTime']." 23:59:59");
			}
				$ecart = round(($strEnd-$strStart)/86400)-1;
				for ($i = $ecart; $i >= 0; $i--)
				{
					if($i<=$ecart AND $i != 0)
					{
						echo "\"".strftime("%A %d/%m/%g", strtotime($_GET['endTime']."-".$i." days"))."\",";
					}
					if($i == 0)
					{
						echo "\"".strftime("%A %d/%m/%g", strtotime($_GET['endTime']."-".$i." days"))."\"";
					}					
				}
		}		
	}
	
	public function loadMonth()
	{
		for ($i = date('j'); $i >= 0; $i--)
		{
			if($i<=date('j')-1 AND $i != 0){
				echo "\"".strftime("%A %d", strtotime("-".$i." day"))."\",";
			}
			if($i == 0){
				echo "\"".strftime("%A %d", strtotime("-".$i." day"))."\"";
			}
							
		}
	}
	
	public function dataSales7days()
	{
		$sql = "SELECT date FROM commandes WHERE date BETWEEN ".strtotime(" now -7days 00:00:00")." AND ".strtotime("now");
		$reponse = $this->_db->query($sql);
		$dateTab = array();

		for( $dt = strtotime(" now -7days 00:00:00"); $dt <= strtotime(" now 23:59:59")  ; $dt=strtotime( date( 'Y-m-d' , $dt ) . ' +1 days' ) )
		{
        	$dateTab[date('Ymd', $dt)] = array();
		}
		while($donnees = $reponse->fetch())
		{
				$dateTab[date('Ymd', $donnees['date'])][] = $donnees['date'];
		}
		$data = array();
		foreach($dateTab as $date)
		{
			$data[] = count($date);
		}
		echo implode(",", $data);
	}
	
	public function dataSalesCustom()
	{
		
		if((isset($_GET['startTime']) AND $_GET['startTime'] != null) AND (isset($_GET['endTime']) AND $_GET['endTime'] != null)) 
		{
			if(isset($_GET['monthUnit']) AND $_GET['monthUnit'] != null)
			{
				if((strtotime($_GET['endTime']." 23:59:59")) < (strtotime($_GET['startTime']." 00:00:00")))
				{
					$sql = "SELECT date FROM commandes WHERE date BETWEEN ".strtotime($_GET['endTime']." 00:00:00")." AND ".strtotime($_GET['startTime']." 23:59:59");
				}
				else
				{
					$sql = "SELECT date FROM commandes WHERE date BETWEEN ".strtotime($_GET['startTime']." 00:00:00")." AND ".strtotime($_GET['endTime']." 23:59:59");
				}
					$reponse = $this->_db->query($sql);
					$dateTab = array();
			
			
					
			
			
					for( $dt = strtotime($_GET['startTime']) ; $dt<strtotime($_GET['endTime']) ; $dt=strtotime( date( 'Y-m-d' , $dt ) . ' +1 month' ) )
					{
			        	$dateTab[date('Ym', $dt)] = array();
					}
					while($donnees = $reponse->fetch())
					{
							$dateTab[date('Ym', $donnees['date'])][] = $donnees['date'];
					}
					$data = array();
					foreach($dateTab as $date)
					{
						$data[] = count($date);
					}
					echo implode(",", $data);
			}
			else
			{
				if((strtotime($_GET['endTime']." 23:59:59")) < (strtotime($_GET['startTime']." 00:00:00")))
				{	
			    	$sql = "SELECT date FROM commandes WHERE date BETWEEN ".strtotime($_GET['endTime']." 00:00:00")." AND ".strtotime($_GET['startTime']." 23:59:59");

				}
				else
				{
					$sql = "SELECT date FROM commandes WHERE date BETWEEN ".strtotime($_GET['startTime']." 00:00:00")." AND ".strtotime($_GET['endTime']." 23:59:59");
				}	
					$reponse = $this->_db->query($sql);
					$dateTab = array();
			
					for( $dt = strtotime($_GET['startTime']) ; $dt<strtotime($_GET['endTime']) ; $dt=strtotime( date( 'Y-m-d' , $dt ) . ' +1 days' ) )
					{
			        	$dateTab[date('Ymd', $dt)] = array();
					}
					while($donnees = $reponse->fetch())
					{
							$dateTab[date('Ymd', $donnees['date'])][] = $donnees['date'];
					}
					$data = array();
					foreach($dateTab as $date)
					{
						$data[] = count($date);
					}
					echo implode(",", $data);	

			}
		}	 
	}
	
	public function totalSales()
	{
		$sql = "SELECT COUNT(date) FROM commandes";
		$reponse = $this->_db->query($sql);
		while($donnees = $reponse->fetch())
		{
			echo "<div class='main_analytics_item_value stat-count'>".$donnees['COUNT(date)']."</div>";
		}

		
	}
	
	public function dataSalesMonth()
	{
		$sql = "SELECT date FROM commandes WHERE date BETWEEN ".strtotime(" now -".(date('j')-1)."days 00:00:00")." AND ".strtotime("now");
		$reponse = $this->_db->query($sql);
		$dateTab = array();

		for( $dt = strtotime(" now -".(date('j')-1)."days 00:00:00"); $dt <= strtotime(" now 23:59:59")  ; $dt=strtotime( date( 'Y-m-d' , $dt ) . ' +1 days' ) )
		{
        	$dateTab[date('Ymd', $dt)] = array();
		}
		while($donnees = $reponse->fetch())
		{
				$dateTab[date('Ymd', $donnees['date'])][] = $donnees['date'];
		}
		$data = array();
		foreach($dateTab as $date)
		{
			$data[] = count($date);
		}
		echo implode(",", $data);
	}
		
	public function menSales7daysData(){
		
		$sql = "SELECT date FROM commandes WHERE date BETWEEN ".strtotime(" now -7days 00:00:00")." AND ".strtotime("now")." AND id_client IN (SELECT id FROM clients WHERE civilite='Monsieur')";
		$reponse = $this->_db->query($sql);
		$dateTab = array();

		for( $dt = strtotime(" now -7days 00:00:00"); $dt <= strtotime(" now 23:59:59")  ; $dt=strtotime( date( 'Y-m-d' , $dt ) . ' +1 days' ) )
		{
        	$dateTab[date('Ymd', $dt)] = array();
		}
		while($donnees = $reponse->fetch())
		{
				$dateTab[date('Ymd', $donnees['date'])][] = $donnees['date'];
		}
		$data = array();
		foreach($dateTab as $date)
		{
			$data[] = count($date);
		}
		echo implode(",", $data);

	}
	
	public function menSalesCustomData()
	{
		if((isset($_GET['startTime']) AND $_GET['startTime'] != null) AND (isset($_GET['endTime']) AND $_GET['endTime'] != null)) 
		{
			if(isset($_GET['monthUnit']) AND $_GET['monthUnit'] != null)
			{
				if((strtotime($_GET['endTime']." 23:59:59")) < (strtotime($_GET['startTime']." 00:00:00")))
				{
					$sql = "SELECT date FROM commandes WHERE date BETWEEN ".strtotime($_GET['endTime']." 00:00:00")." AND ".strtotime($_GET['startTime']." 23:59:59")." AND id_client IN (SELECT id FROM clients WHERE civilite='Monsieur')";
				}
				else
				{
					$sql = "SELECT date FROM commandes WHERE date BETWEEN ".strtotime($_GET['startTime']." 00:00:00")." AND ".strtotime($_GET['endTime']." 23:59:59")." AND id_client IN (SELECT id FROM clients WHERE civilite='Monsieur')";
				}
					$reponse = $this->_db->query($sql);
					$dateTab = array();
			
					for( $dt = strtotime($_GET['startTime']) ; $dt<strtotime($_GET['endTime']) ; $dt=strtotime( date( 'Y-m-d' , $dt ) . ' +1 month' ) )
					{
			        	$dateTab[date('Ym', $dt)] = array();
					}
					while($donnees = $reponse->fetch())
					{
							$dateTab[date('Ym', $donnees['date'])][] = $donnees['date'];
					}
					$data = array();
					foreach($dateTab as $date)
					{
						$data[] = count($date);
					}
					echo implode(",", $data);
			
			}
			else
			{
				if((strtotime($_GET['endTime']." 23:59:59")) < (strtotime($_GET['startTime']." 00:00:00")))
				{
					$sql = "SELECT date FROM commandes WHERE date BETWEEN ".strtotime($_GET['endTime']." 00:00:00")." AND ".strtotime($_GET['startTime']." 23:59:59")." AND id_client IN (SELECT id FROM clients WHERE civilite='Monsieur')";
				}
				else
				{
					$sql = "SELECT date FROM commandes WHERE date BETWEEN ".strtotime($_GET['startTime']." 00:00:00")." AND ".strtotime($_GET['endTime']." 23:59:59")." AND id_client IN (SELECT id FROM clients WHERE civilite='Monsieur')";
				}
			
					$reponse = $this->_db->query($sql);
					$dateTab = array();
			
					for( $dt = strtotime($_GET['startTime']) ; $dt<strtotime($_GET['endTime']) ; $dt=strtotime( date( 'Y-m-d' , $dt ) . ' +1 days' ) )
					{
			        	$dateTab[date('Ymd', $dt)] = array();
					}
					while($donnees = $reponse->fetch())
					{
							$dateTab[date('Ymd', $donnees['date'])][] = $donnees['date'];
					}
					$data = array();
					foreach($dateTab as $date)
					{
						$data[] = count($date);
					}
					echo implode(",", $data);
			
			}
		}
	}
	
	public function menSalesMonthData(){
		$sql = "SELECT date FROM commandes WHERE date BETWEEN ".strtotime(" now -".(date('j')-1)."days 00:00:00")." AND ".strtotime("now")." AND id_client IN (SELECT id FROM clients WHERE civilite='Monsieur')";
		$reponse = $this->_db->query($sql);
		$dateTab = array();
	
		for( $dt = strtotime(" now -".(date('j')-1)."days 00:00:00"); $dt <= strtotime(" now 23:59:59")  ; $dt=strtotime( date( 'Y-m-d' , $dt ) . ' +1 days' ) )
		{
	    	$dateTab[date('Ymd', $dt)] = array();
		}
		while($donnees = $reponse->fetch())
		{
				$dateTab[date('Ymd', $donnees['date'])][] = $donnees['date'];
		}
		$data = array();
		foreach($dateTab as $date)
		{
			$data[] = count($date);
		}
		echo implode(",", $data);
	}
	
	public function womenSales7daysData()
	{	
		$sql = "SELECT date FROM commandes WHERE date BETWEEN ".strtotime(" now -7days 00:00:00")." AND ".strtotime("now")." AND id_client IN (SELECT id FROM clients WHERE civilite='Madame' OR civilite = 'Mademoiselle')";
		$reponse = $this->_db->query($sql);
		$dateTab = array();

		for( $dt = strtotime(" now -7days 00:00:00"); $dt <= strtotime(" now 23:59:59")  ; $dt=strtotime( date( 'Y-m-d' , $dt ) . ' +1 days' ) )
		{
        	$dateTab[date('Ymd', $dt)] = array();
		}
		while($donnees = $reponse->fetch())
		{
				$dateTab[date('Ymd', $donnees['date'])][] = $donnees['date'];
		}
		$data = array();
		foreach($dateTab as $date)
		{
			$data[] = count($date);
		}
		echo implode(",", $data);
	}
	
	public function womenSalesCustomData()
	{
		if((isset($_GET['startTime']) AND $_GET['startTime'] != null) AND (isset($_GET['endTime']) AND $_GET['endTime'] != null)) 
		{

			if(isset($_GET['monthUnit']) AND $_GET['monthUnit'] != null)
			{
				if((strtotime($_GET['endTime']." 23:59:59")) < (strtotime($_GET['startTime']." 00:00:00")))
				{
					$sql = "SELECT date FROM commandes WHERE date BETWEEN ".strtotime($_GET['endTime']." 00:00:00")." AND ".strtotime($_GET['startTime']." 23:59:59")." AND id_client IN (SELECT id FROM clients WHERE civilite='Mademoiselle' OR civilite = 'Madame')";
				}
				else
				{
					$sql = "SELECT date FROM commandes WHERE date BETWEEN ".strtotime($_GET['startTime']." 00:00:00")." AND ".strtotime($_GET['endTime']." 23:59:59")." AND id_client IN (SELECT id FROM clients WHERE civilite='Mademoiselle' OR civilite = 'Madame')";
				}
					$reponse = $this->_db->query($sql);
					$dateTab = array();
			
			
					
			
			
					for( $dt = strtotime($_GET['startTime']) ; $dt<strtotime($_GET['endTime']) ; $dt=strtotime( date( 'Y-m-d' , $dt ) . ' +1 month' ) )
					{
			        	$dateTab[date('Ym', $dt)] = array();
					}
					while($donnees = $reponse->fetch())
					{
							$dateTab[date('Ym', $donnees['date'])][] = $donnees['date'];
					}
					$data = array();
					foreach($dateTab as $date)
					{
						$data[] = count($date);
					}
					echo implode(",", $data);

			
			}
			else
			{
			
				if((strtotime($_GET['endTime']." 23:59:59")) < (strtotime($_GET['startTime']." 00:00:00")))
				{
		        	$sql = "SELECT date FROM commandes WHERE date BETWEEN ".strtotime($_GET['endTime']." 00:00:00")." AND ".strtotime($_GET['startTime']." 23:59:59")." AND id_client IN (SELECT id FROM clients WHERE civilite='Madame' OR civilite='Mademoiselle')";
				}
				else
				{
					$sql = "SELECT date FROM commandes WHERE date BETWEEN ".strtotime($_GET['startTime']." 00:00:00")." AND ".strtotime($_GET['endTime']." 23:59:59")." AND id_client IN (SELECT id FROM clients WHERE civilite='Madame' OR civilite='Mademoiselle')";
				}	
					$reponse = $this->_db->query($sql);
					$dateTab = array();
			
					for( $dt = strtotime($_GET['startTime']) ; $dt<strtotime($_GET['endTime']) ; $dt=strtotime( date( 'Y-m-d' , $dt ) . ' +1 days' ) )
					{
			        	$dateTab[date('Ymd', $dt)] = array();
					}
					while($donnees = $reponse->fetch())
					{
							$dateTab[date('Ymd', $donnees['date'])][] = $donnees['date'];
					}
					$data = array();
					foreach($dateTab as $date)
					{
						$data[] = count($date);
					}
					echo implode(",", $data);
			}
		}
	}
	
	public function womenSalesMonthData()
	{
		$sql = "SELECT date FROM commandes WHERE date BETWEEN ".strtotime(" now -".(date('j')-1)."days 00:00:00")." AND ".strtotime("now")." AND id_client IN (SELECT id FROM clients WHERE civilite='Madame' OR civilite = 'Mademoiselle')";
		$reponse = $this->_db->query($sql);
		$dateTab = array();

		for( $dt = strtotime(" now -".(date('j')-1)."days 00:00:00"); $dt <= strtotime(" now 23:59:59")  ; $dt=strtotime( date( 'Y-m-d' , $dt ) . ' +1 days' ) )
		{
        	$dateTab[date('Ymd', $dt)] = array();
		}
		while($donnees = $reponse->fetch())
		{
				$dateTab[date('Ymd', $donnees['date'])][] = $donnees['date'];
		}
		$data = array();
		foreach($dateTab as $date)
		{
			$data[] = count($date);
		}
		echo implode(",", $data);		
	}
	
	public function sexData()
	{
		$sql = "SELECT COUNT(id) FROM clients WHERE civilite ='Monsieur'";
		$reponse = $this->_db->query($sql);
		while($donnees = $reponse->fetch())
		{
			echo $donnees['COUNT(id)'].",";
		}
		$sql2 = "SELECT COUNT(id) FROM clients WHERE civilite = 'Mademoiselle' OR civilite = 'Madame'";
		$reponse2 = $this->_db->query($sql2);
		while($donnees2 = $reponse2->fetch())
		{
			echo $donnees2['COUNT(id)'];
		}
	}
	
	public function sexMonthData()
	{
		$sql = "SELECT COUNT(id) FROM clients WHERE date_inscription BETWEEN ".strtotime(" now -".(date('j')-1)."days 00:00:00")." AND ".strtotime("now")." AND civilite='Monsieur'";
		$reponse = $this->_db->query($sql);

	
	
		while($donnees = $reponse->fetch())
		{
				echo $donnees['COUNT(id)'].",";
		}
		
		$sql2 = "SELECT COUNT(id) FROM clients WHERE date_inscription BETWEEN ".strtotime(" now -".(date('j')-1)."days 00:00:00")." AND ".strtotime("now")." AND civilite='Mademoiselle' OR civilite='Madame'";
		$reponse2 = $this->_db->query($sql2);
		while($donnees2 = $reponse2->fetch())
		{
				echo $donnees2['COUNT(id)'];
		}

	}
	
	public function sex7daysData()
	{
		$sql = "SELECT COUNT(id) FROM clients WHERE date_inscription BETWEEN ".strtotime(" now -7days 00:00:00")." AND ".strtotime("now")." AND civilite='Monsieur'";
		$reponse = $this->_db->query($sql);

	
	
		while($donnees = $reponse->fetch())
		{
				echo $donnees['COUNT(id)'].",";
		}
		
		$sql2 = "SELECT COUNT(id) FROM clients WHERE date_inscription BETWEEN ".strtotime(" now -7days 00:00:00")." AND ".strtotime("now")." AND civilite='Mademoiselle' OR civilite='Madame'";
		$reponse2 = $this->_db->query($sql2);
		while($donnees2 = $reponse2->fetch())
		{
				echo $donnees2['COUNT(id)'];
		}

	}
	
	public function sexCustomData()
	{
		if((isset($_GET['startTime']) AND $_GET['startTime'] != null) AND (isset($_GET['endTime']) AND $_GET['endTime'] != null))
		{ 
			$sql = "SELECT COUNT(id) FROM clients WHERE date_inscription BETWEEN ".strtotime($_GET['startTime']. " 00:00:00")." AND ".strtotime($_GET['endTime']." 23:59:59")." AND civilite='Monsieur'";
			$reponse = $this->_db->query($sql);
	
		
		
			while($donnees = $reponse->fetch())
			{
					echo $donnees['COUNT(id)'].",";
			}
			
			$sql2 = "SELECT COUNT(id) FROM clients WHERE date_inscription BETWEEN ".strtotime($_GET['startTime']. " 00:00:00")." AND ".strtotime($_GET['endTime']." 23:59:59")." AND civilite='Mademoiselle' OR civilite='Madame'";
			$reponse2 = $this->_db->query($sql2);
			while($donnees2 = $reponse2->fetch())
			{
					echo $donnees2['COUNT(id)'];
			}
		}

	}
	
	public function langData()
	{
	
		$this->_lang = array();
		$sql2 = "SELECT lang FROM clients";
		$reponse2 = $this->_db->query($sql2);
		while($donnees2 = $reponse2->fetch())
		{
				$this->_lang[]= '"'.$donnees2['lang'].'"';
		}
		$this->_langName = array_unique($this->_lang);
		$this->_langName = implode(",", $this->_langName);
		$this->_langName = strtoupper($this->_langName);

		$this->_lang=array_count_values($this->_lang);
		$this->_lang = implode(",", $this->_lang);
	}
	
	public function montantMoyenCommande()
	{
		$sql = "SELECT ROUND(AVG(total), 2) as arrondi FROM commandes";
		$reponse = $this->_db->query($sql);
		$sql2 = "SELECT sepa_deci, sepa_mill, devise, pos_devise FROM ecommerce_config";
		$reponse2 = $this->_db->query($sql2);
		while($donnees2 = $reponse2->fetch())
		{
			
			while($donnees = $reponse->fetch())
			{
				if($donnees['arrondi'] == null)
				{
					echo "<div class='main_analytics_item_value'><span>".$donnees2['devise']."</span> <span class='stat-count'>0</span></div>";
				}
				else
				{
					if($donnees2['pos_devise'] == "before-space"){
					echo "<div class='main_analytics_item_value'><span>".$donnees2['devise']."</span> <span class='stat-count'>".round($donnees['arrondi'],2)."</span></div>";
					}
					if($donnees2['pos_devise'] == "before"){
						echo "<div class='main_analytics_item_value'><span>".$donnees2['devise']."</span><span class='stat-count'>".round($donnees['arrondi'],2)."</span></div>";
					}
					if($donnees2['pos_devise'] == "after"){
						echo "<div class='main_analytics_item_value'><span class='stat-count'>".round($donnees['arrondi'],2)."</span><span>".$donnees2['devise']."</span></div>";
					}
					if($donnees2['pos_devise'] == "after-space"){
						echo "<div class='main_analytics_item_value'><span class='stat-count'>".round($donnees['arrondi'],2)."</span> <span>".$donnees2['devise']."</span></div>";
					}
				}

			}
		}
	}
	
	public function nbArticlesVendus()
	{
		$produits = array();
		$nombreProduits = array();
		$sql = "SELECT id_produit FROM commandes";
		$reponse = $this->_db->query($sql);
		while($donnees = $reponse->fetch())
		{
			$commandes = json_decode($donnees['id_produit'], true);
			
			foreach($commandes as $commande)
			{
				$produits[$commande]++;
			}
			
			$nombreProduits[] = count($commandes);
			
		}
		
// 		print_r($nombreProduits);
	//print_r($produits);
		
	}
	
	//Calcul du moyen de paiement le plus courant
	public function nbArticlesMoyens()
	{
		$produits = array();
		$nombreProduits = array();
		$this->_paiement = array();
		$this->_livraison = array();
		$this->_tempsPassation = array();
		$this->_device = array();
		$commandes = array();
		$sql = "SELECT id_produit, moyen_paiement, livraison, nom, temps_passation, device FROM commandes INNER JOIN livraison WHERE livraison=livraison.id";
		$reponse = $this->_db->query($sql);
		while($donnees = $reponse->fetch())
		{
			$commandes[] = json_decode($donnees['id_produit'], true);			
			$nombreProduits[] = count($commandes);
			$this->_paiement[$donnees['moyen_paiement']] = $donnees['moyen_paiement'];
			$this->_livraison[$donnees['nom']] = $donnees['livraison'];
			$this->_tempsPassation[]= $donnees['temps_passation'];
			$this->_device[] = $donnees['device'];
			
		}
		
		

		$this->_paiement = array_keys($this->_paiement, max($this->_paiement));
		$this->_paiement = implode("-",$this->_paiement);
		
		$this->_livraison = array_keys($this->_livraison, max($this->_livraison));
		$this->_livraison = implode("-",$this->_livraison);
		
		$this->_tempsPassation = round(array_sum($this->_tempsPassation) / count($this->_tempsPassation));
		
		$this->_device = array_count_values($this->_device);
		$sum = array_sum($this->_device);
		$this->_device = ($this->_device['Mobile']/$sum)*100;
		//print_r($this->_device);
		
		
		$moyenne = array();
		//print_r($commandes);
		foreach($commandes as $key => $nombre)
		{
			foreach($nombre as $prod)
			{
				$moyenne[$key] = $prod['quantite'];
			}
		}
		//print_r($moyenne);
		$moyenne = array_sum($moyenne)/count($moyenne);
		$this->_format = str_replace(",", ".", $moyenne);
		

		
	}
	
	public function produitsVendus()
	{
		$commandes = array();
		$data = array();
		$qtAll = array();
		$date = array();
		$this->_nom = array();
		$sql = "SELECT id_produit, date, id FROM commandes";
		$reponse = $this->_db->query($sql);
		while($donnees = $reponse->fetch())
		{
			$commandes = json_decode($donnees['id_produit'], true);
			

			//print_r($commandes);	
			//print_r($commandes);
			foreach($commandes as $details)
			{
				$date[$details['id']][$donnees['id']] = $donnees['date'];
				
				//print_r($details); echo'<br /><br />';
				
					$data[$details['id']][$donnees['id']]['quantite'] = 1 * $details['quantite'];
					$data[$details['id']][$donnees['id']]['nom']= $details['nom'];
					$data[$details['id']][$donnees['id']]['id']= $details['id'];
					$data[$details['id']][$donnees['id']]['variation'] = $details['variation'];
					
					$qt[$details['id']] = 1 * $details['quantite'];
					
					
					
					//$date[] = $details['date'];
					//echo 'ok';
				
/*
				else
				{
					$data[$details['id']][$donnees['id']]['quantite'] = $data[$details['id']]['quantite'] + (1 * $details['quantite']) ;
					$qt[$details['id']] = $qt[$details['id']] + 1 * $details['quantite'];
					
					//$data[$details['id']][]= $data[$details['nom']];
					//echo'ok';
					
				}
*/
				$data[$details['id']][$donnees['id']]['date'] = $donnees['date'];
				
				
				
				
					
				
			}
			
			
			
					
					
				
			
			
		}
		if((isset($_GET['from']) AND $_GET['from'] == '') OR !isset($_GET['from']))
		{
			foreach($data as $det)
			{
				//print_r($det);
				foreach($det as $ail)
				{
					//print_r($ail);
					if(!array_key_exists($ail['id'], $qtAll))
					{
						$qtAll[$ail['id']] = $ail['quantite'];
					}
					else
					{
						$qtAll[$ail['id']] = $qtAll[$ail['id']] + $ail['quantite'];
					}
					
				}
					
			}
			//print_r($data);
			arsort($qtAll);
			//print_r($qt);
			//$qt = rsort($qt);
			//print_r($qt);
			$maxValues = array_slice($qtAll, 0, 15, true);
			
			
			//exit;
			
			foreach($data as $key => $details)
			{
				foreach($maxValues as $cle => $value)
				{
					if($cle == $key)
					{
						foreach($details as $dt)
						{
							if($dt['id'] = $key)
							{
								//print_r($dt);
							$this->_nomAll[] = substr($dt['nom'], 0, 20);
							//$this->_label[] = $details['nom'];
							$this->_quantiteAll = $qtAll;
							}
							
						}
						
					}
				}
				
			}
			
			$this->_nomAll = '"' . implode('","', array_unique($this->_nomAll)) . '"';
			$this->_quantiteAll = '"' . implode('","', $this->_quantiteAll) . '"';
		//$this->_label = '"' . implode('","', $this->_label) . '"';
		}
		
		if(isset($_GET['from']) AND $_GET['from'] != '')
		{
			foreach($data as $det)
			{
				//print_r($det);
				foreach($det as $ail)
				{
					if($ail['date'] > $_GET['from'] AND $ail['date'] < time())
					{
					//print_r($ail);
						if(!array_key_exists($ail['id'], $qtAll))
						{
							$qtAll[$ail['id']] = $ail['quantite'];
						}
						else
						{
							$qtAll[$ail['id']] = $qtAll[$ail['id']] + $ail['quantite'];
						}
					}
					
				}
					
			}
			//print_r($data);
			arsort($qtAll);
			//print_r($qt);
			//$qt = rsort($qt);
			//print_r($qt);
			$maxValues = array_slice($qtAll, 0, 15, true);
			
			
			//exit;
			
			foreach($data as $key => $details)
			{
				foreach($maxValues as $cle => $value)
				{
					if($cle == $key)
					{
						foreach($details as $dt)
						{
							if($dt['id'] = $key)
							{
								if($dt['date'] > $_GET['from'] AND $dt['date'] < time())
								{
									$this->_nomAll[] = substr($dt['nom'], 0, 20);
									//$this->_label[] = $details['nom'];
									$this->_quantiteAll = $qtAll;
								}
								//print_r($dt);
							
							}
							
						}
						
					}
				}
				
			}
			print_r($data);
			
			$this->_nomAll = '"' . implode('","', array_unique($this->_nomAll)) . '"';
			$this->_quantiteAll = '"' . implode('","', $this->_quantiteAll) . '"';
		//$this->_label = '"' . implode('","', $this->_label) . '"';
		}
		
		if(isset($_GET['from']) AND $_GET['from'] != '' AND isset($_GET['to']) AND $_GET['to'] != '')
		{
			foreach($data as $det)
			{
				//print_r($det);
				foreach($det as $ail)
				{
					if($ail['date'] > $_GET['from'] AND $ail['date'] < $_GET['to'])
					{
					//print_r($ail);
						if(!array_key_exists($ail['id'], $qtAll))
						{
							$qtAll[$ail['id']] = $ail['quantite'];
						}
						else
						{
							$qtAll[$ail['id']] = $qtAll[$ail['id']] + $ail['quantite'];
						}
					}
					
				}
					
			}
			//print_r($data);
			arsort($qtAll);
			//print_r($qt);
			//$qt = rsort($qt);
			//print_r($qt);
			$maxValues = array_slice($qtAll, 0, 15, true);
			
			
			//exit;
			
			foreach($data as $key => $details)
			{
				foreach($maxValues as $cle => $value)
				{
					if($cle == $key)
					{
						foreach($details as $dt)
						{
							if($dt['id'] = $key)
							{
								if($dt['date'] > $_GET['from'] AND $dt['date'] < $_GET['to'])
								{
									$this->_nomAll[] = substr($dt['nom'], 0, 20);
									//$this->_label[] = $details['nom'];
									$this->_quantiteAll = $qtAll;
								}
								//print_r($dt);
							
							}
							
						}
						
					}
				}
				
			}
			print_r($data);
			
			$this->_nomAll = '"' . implode('","', array_unique($this->_nomAll)) . '"';
			$this->_quantiteAll = '"' . implode('","', $this->_quantiteAll) . '"';
		//$this->_label = '"' . implode('","', $this->_label) . '"';
		}
/*
		echo $this->_quantite;
		echo $this->_nom;
*/
	}
}

