<!-- name: Formations -->
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
		<div class='container-fluid' style='background: white'>
			<div style='display: flex; background-image: url(<?=$pilot->_the_page['image']?>); background-position: center; background-size: cover; height: 400px' class='bannerImage'>
				<h1 style='margin: auto; color: white'><?=$pilot->_the_page['name']?></h1>
			</div>
			
			<?php include($pilot->get_theme_path()."/breadcrumb.php");?>
			<?php
			$pages = $pilot->get_pages(array("parent" => $pilot->_the_page['ID'], "image" => "SD", "orderBy" => "orderID", "sort" => "ASC"));
			$pilot->execute_php($pilot->do_shortcode($pilot->_the_page['text']));
			$count = 0;
			foreach($pages as $page)
			{
			    //print_r($page);
			    if($count % 2 == 0)
			    {
			        ?>
			        <div class='container-fluid' style='padding-top: 50px; padding-bottom: 50px'>
        			    <div class='container formationBloc'>
        			        <div class='col-md-4' style=''>
        			           
        			            <img src='<?=$page['image']?>' style='width: 100%'/>
        			        </div>
        			        <div class='col-md-8'>
        			            <h2><img src='<?=$page['customFields']['picto']?>' style='height: 35px'/><a href='<?=$page['URL']?>'><?=$page['name']?></a></h2>
        			            <p><?=$page['description']?></p>
        			            <a class='callToAction' href='<?=$page['URL']?>#content'><?=$pilot->get_theme_options("call to action")?></a>
        			        </div>
        			    </div>
        			 </div>
    			    
    			    <?php
			    }
			    else{
			        
			        ?>
			        <div class='container-fluid' style='background: #e2e2e2; padding-top: 50px; padding-bottom: 50px'>
        			    <div class='container formationBloc'>
        			        <div class='col-md-8'>
        			            <h2><img src='<?=$page['customFields']['picto']?>' style='height: 35px'/> <a href='<?=$page['URL']?>'><?=$page['name']?></a></h2>
        			            <p><?=$page['description']?></p>
        			            <a class='callToAction' href='<?=$page['URL']?>#content'><?=$pilot->get_theme_options("call to action")?></a>
        			        </div>
        			        <div class='col-md-4' style=''>
        			           
        			            <img src='<?=$page['image']?>' style='width: 100%'/>
        			        </div>
        			        
        			    </div>
    			    </div>
    			    <?php
			    }
			    $count++;
			    //echo $page['nom']."<br/>";
			    
			}
			
				
			?>
			
		</div>
<?php 
	
	include($pilot->get_theme_path()."/footer.php");
	
?>