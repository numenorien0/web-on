<!-- name: Entreprises -->
<?php 
	
	include($pilot->get_theme_path()."/menu.php");
	
?>
		<style>
		    h2
		    {
		        margin-bottom: 7px; padding-bottom: 7px;
		    }
		    
		    p
		    {
		        text-transform: initial;
		    }
		    h4
		    {
		        text-align: center;
		    }
		</style>
		<div class='container-fluid' style='background: white'>
			<div style='display: flex; background-image: url(<?=$pilot->_the_page['image']?>); background-position: center; background-size: cover; height: 400px' class='bannerImage'>
				<h1 style='margin: auto; color: white'><?=$pilot->_the_page['name']?></h1>
			</div>
			<?php include($pilot->get_theme_path()."/breadcrumb.php");?>
			<div class='container' style='padding-top: 50px; padding-bottom: 50px'>
			
			<?php
			$pages = $pilot->get_pages(array("parent" => $pilot->_the_page['ID'], "orderBy" => "orderID", "sort" => "DESC","image" => "SD"));
			$pilot->execute_php($pilot->do_shortcode($pilot->_the_page['text']));
			
			foreach($pages as $page)
			{
			    	//print_r($page);
			        ?>
			        
        			    <div class='col-md-3 '>
        			        <a href='<?=$page['URL']?>#content'>
        			        <div class='col-md-12' style='height: 250px; display: flex'>
        			            <img src='<?=$page['image']?>' style='display: block; margin: auto; width: 100%'/>
        			        </div>
        			        <div class='col-md-12'>
<!--         			            <h4><?=$page['name']?></h4> -->
        			            <p><?=$page['description']?></p>
        			        </div>
        			        </a>
        			    </div>
        			 
    			    
    			    <?php
			   
			    //echo $page['nom']."<br/>";
			    
			}
			
				
			?>
			</div>
		</div>
<?php 
	
	include($pilot->get_theme_path()."/footer.php");
	
?>