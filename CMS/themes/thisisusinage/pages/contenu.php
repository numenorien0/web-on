<!-- name: Contenu classique -->
<?php 
	
	include($pilot->get_theme_path()."/menu.php");
	
?>
		
		<div class='container-fluid' style='background: white'>
			<div style='display: flex; background-image: url(<?=$pilot->_the_page['image']?>); background-position: center; background-size: cover; height: 400px' class='bannerImage'>
				<h1 style='margin: auto; color: white'><?=$pilot->_the_page['name']?></h1>
			</div>
			<?php include($pilot->get_theme_path()."/breadcrumb.php");?>
			<div class='container' style='padding-top: 50px; padding-bottom: 50px'>
			<?php
				$pilot->execute_php($pilot->do_shortcode($pilot->_the_page['text']));
			?>
			</div>
		</div>
<?php 
	
	include($pilot->get_theme_path()."/footer.php");
	
?>