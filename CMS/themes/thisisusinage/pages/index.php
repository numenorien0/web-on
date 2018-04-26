<!-- name:Page d'accueil -->
		<?php 
			
			include($pilot->get_theme_path()."/menu.php");
			
		?>
		<?php echo $pilot->do_shortcode($pilot->_the_page['text']); ?>

		<style>
		    body
		    {
		        background: #F1F1F1;
		    }
		</style>
		<div id='save' class='row footerSaveTheDate' style='display: flex; padding-bottom: 50px; padding-top: 50px; text-align: center; font-size: 20px; background: #fff'>
					<div class='col-md-4'><?=$pilot->get_theme_options("inscription_seance")?></div>
					<div class='col-md-4'><img src='<?=$pilot->get_theme_options("joinusimg")?>' style='max-width: 100%' /></div>
					<div class='col-md-4'><?=$pilot->get_theme_options("more_info")?></div>
					
				</div>
				
				
        <div class='container-fluid' style='border-bottom: 1px solid #dadada; background: #F1F1F1'>
		    <div class='container' style='padding: 50px 15px' >
		        <h1 style='padding-top: 0; margin-top: 0'><?=$pilot->get_theme_options("Rejoignez-nous")?></h1>
		        <?php 
		        
		        $formation = $pilot->get_page("formations");
		        //print_r($formation);
		        $formations = $pilot->get_pages(array("parent" => $formation['ID']));
		        //print_r($formations);
		        foreach($formations as $formation)
		        {
		            ?>
		            
		            <div class='col-md-4'>
		                <div class='row'>
		                    <div class='col-md-4 col-xs-6'><img src='<?=$formation['customFields']['picto']?>' style='float: left; margin-top: -15px; max-width: 100%'/></div>
		                    <div class='col-md-8'><a href='<?=$formation['URL']?>'><h3><?=$formation['name']?></h3></a></div>
		                </div>
		            </div>
		            
		            <?php
		        }
		        
		        
		        ?>
		    </div>
		</div>				
		<div class='info'>
			<div class='background'>
			
			<div style='text-align: center; padding: 50px 0px; ' class='container'>
				
				<h2 style='font-size: 40px'><?=$pilot->get_theme_options("Rejoignez-nous sous-titre")?></h2>
				<div class='circleContainer container' style='width: auto'>
				    <div style='display: block; margin: auto; width: 100%'>
				    <?php 
				        $date = array();
				        $date[] = $pilot->get_theme_options("date 1");
				        $date[] = $pilot->get_theme_options("date 2");
				        $date[] = $pilot->get_theme_options("date 3");
				        $date[] = $pilot->get_theme_options("date 4");
				        
				        foreach($date as $dat)
				        {
				            if($dat != null)
				            {
				                ?>
				                <div class='circleOne'>
    				                <div style='' class='circle'>
                    					<p><?=$dat?></p>
                    				</div>
                				</div>
				                <?php
				            }
				        }
				    ?>
				    </div>
				
				</div>
				<a class='callToAction' href='<?=$pilot->_current_lang?>/inscriptions-et-infos/'>Join us !</a>
			</div>
			</div>
		</div>
		<div id='' class='row footerSaveTheDate' style='display: flex; padding-bottom: 50px; padding-top: 50px; text-align: center; font-size: 20px; background: #fff; border-top: 1px solid #dadada'>
			<div class='col-md-4'><?=$pilot->get_theme_options("inscription_seance")?></div>
			<div class='col-md-4'><img src='<?=$pilot->get_theme_options("joinusimg")?>' style='max-width: 100%' /></div>
			<div class='col-md-4'><?=$pilot->get_theme_options("more_info")?></div>
		</div>
		<div class='container-fluid' style='display: block; filter: grayscale(0%) ; background: #F1F1F1; padding: 50px 0px;'>
			<div class='container' style='filter: blur(0px); text-align: center'>
			    <h2 style='font-size: 45px' ><?=$pilot->get_theme_options("Presentation usineur")?></h2>
				<h3 style='margin-bottom: 30px; border-bottom: 1px solid transparent; padding-bottom: 30px' ><?=$pilot->get_theme_options("Sous-titre usineur")?></h3>
				<div class='row'>
					<?php 
						
						foreach($pilot->get_pages(array("parent" => "151", "image" => "intermediate", "orderBy" => "orderID", "sort" => "DESC")) as $portrait)
						{
							$customField = $portrait['customFields'];
							
							?>
							
							<a href='<?=$portrait['URL']?>#content' style='position: relative; ' class='col-md-4 col-xs-6'>
								<div style='' class=''>
									
									<div style='display: inline-block;  position: relative'>
										<div style='position: absolute; right: 0; left: 0; bottom: 0px; padding: 15px; margin: auto; background: #ffffff'><img src='<?=$customField['entreprise']?>' style='width: 100px; '></div>
										<img src='<?=$portrait['image']?>' alt="<?=$portrait['alt']?>" style='max-width: 100%'/>
									</div>
									<div class='usineurs'><h3 style='font-size: 20px'><?=$portrait['name']?></h3><p class=''><?=$customField['fonction']?></p></div>
								</div>
							</a>
							
							<?php
						}
						
					?>
					
					
				</div>
			</div>
		</div>
		
		<div class='videoContainer' style='display: none; background: #dadada; padding: 100px 0px; '>
			<div class='container'>
				<div class='col-md-6'>
					<iframe width="560" height="315" src="https://www.youtube.com/embed/Fp6CkDhRbnA" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
				</div>
				<div class='col-md-6 presentation' style='display: flex; height: 315px'>
					<div style='margin: auto; padding: 15px; '>
						<h4 style='font-size: 2em; margin-bottom: 15px'>This is usinage</h4>
						<p style='text-transform: initial; color: #9f9f9f' >Dans plusieurs métiers, en particulier dans le secteur de l’Industrie, subsistent encore aujourd’hui des pénuries de main d’œuvre qualifiée. C’est le cas dans les métiers de l’usinage.<br/><br/>
Technifutur s’est associé avec les entreprises concernées par le problème, ainsi qu’avec le Forem, les partenaires sociaux et d’autres opérateurs de formation pour tenter d’apporter au plus vite une réponse à cette question qui handicape le développement économique et prive de nombreux demandeurs d’emploi d’un accès au travail. Pendant 3 ans, 4 formations originales, répondant au mieux aux attentes des employeurs, seront organisées chaque année et produiront des débouchés quasi garantis aux stagiaires qui iront au bout de la démarche.<br/><br/>
La première formation débute le 16 avril prochain.
Join us</p>
					</div>
				</div>
			</div>
		</div>
		
		<div class=''>
			
		</div>
<?php 
	
	include($pilot->get_theme_path()."/footer.php");
	
?>