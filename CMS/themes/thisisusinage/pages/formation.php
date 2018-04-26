<!-- name: Formation -->
<?php 
	
	include($pilot->get_theme_path()."/menu.php");
	
?>
		<style>
		    h2
		    {
		        margin-bottom: 7px; padding-bottom: 7px;
		    }
		    .formationBloc
		    {
		        margin-bottom: 45px;
		    }
		    p
		    {
		        text-transform: initial;
		    }
		</style>
		<?php 
		
		$parent = $pilot->get_pages(array("ID" => $pilot->_the_page['parent'], "image" => "HD"))[0];
		
		?>
		<div class='container-fluid' style='background: white'>
			<div style='display: flex; background-image: url(<?=$parent['image']?>); background-position: center; background-size: cover; height: 400px' class='bannerImage'>
				<h1 style='margin: auto; color: white'><?=$parent['name']?></h1>
			</div>
			
			<?php include($pilot->get_theme_path()."/breadcrumb.php");?>
			
			<div id="content" class='container' style='padding-top: 50px; padding-bottom: 50px'>
    			<div class='col-md-4'>
    			    <?php $image = $pilot->get_image($pilot->_the_page['imageFile'])['SD'];
    			    //print_r($image);
    			    ?>
    			    <img alt="<?=$image['alt']?>" src='<?=$image['image']?>' style='width: 100%'/>
    			</div>
    			<div class='col-md-8'>
    			    <h2><?=$pilot->_the_page['name']?></h2>
    			    <div style='text-transform: initial'>
    			    <?php 
    			    
    			    $pilot->execute_php($pilot->do_shortcode($pilot->_the_page['text']));
    			    
    			    ?>
    			    </div>
    			</div>
    	    </div>
			<div id='save' class='row footerSaveTheDate' style='display: flex; padding-bottom: 50px; padding-top: 50px; text-align: center; font-size: 20px; background: #dadada'>
					<div class='col-md-4'><?=$pilot->get_theme_options("inscription_seance")?></div>
					<div class='col-md-4'><img src='<?=$pilot->get_theme_options("joinusimg")?>' style='max-width: 100%' /></div>
					<div class='col-md-4'><?=$pilot->get_theme_options("more_info")?></div>
					
				</div>
			
		</div>
<?php 
	
	include($pilot->get_theme_path()."/footer.php");
	
?>