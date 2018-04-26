<?php

$dossier = scandir("wireframes/Miniatures/");
$array = array();
echo "<iframe width='1280px' height='1280px' style='' scrolling='no' id='generateMiniature' src=''></iframe>";
foreach($dossier as $fichier)
{
	if($fichier != "." AND $fichier != "..")
	{
		echo "<input type='text' value='".$fichier."' class='miniatures'>";
	}
}
$dossier = scandir("wireframes/Pages/");
$array = array();
foreach($dossier as $fichier)
{
	if($fichier != "." AND $fichier != "..")
	{
		echo "<input type='text' value='".$fichier."' class='pages'>";
	}
}	

$dossier = scandir("wireframes/Menu/");
$array = array();
foreach($dossier as $fichier)
{
	if($fichier != "." AND $fichier != "..")
	{
		echo "<input type='text' value='".$fichier."' class='menu'>";
	}
}	



	
?>
<?=$includeJSAndCSS?> 
<script>
	$(function(){
		
		<?php
			if($_GET['type'] == "miniature")
			{
		?>
		var time = 1000;
		
		$('.miniatures').each(function(){
	
			var actuel = $(this);
			var ID = $(this).val();
			setTimeout(function(){
				$("#generateMiniature").attr("src", "preview_bloc.php?miniature="+ID+"&type=miniature");
				
			}, time)
			
			time += 4000;
	
		})
		
		<?php
			}
			if($_GET['type'] == "pages")
			{
		?>
		var time = 1000;
		
		$('.pages').each(function(){
	
			var actuel = $(this);
			var ID = $(this).val();
			setTimeout(function(){
				$("#generateMiniature").attr("src", "preview_bloc.php?miniature="+ID+"&type=page&filter=ok");
				
			}, time)
			
			time += 4000;
	
		})	
		
		<?php
			}
			if($_GET['type'] == "menu")
			{
		?>
		var time = 1000;
		
		$('.menu').each(function(){
	
			var actuel = $(this);
			var ID = $(this).val();
			setTimeout(function(){
				$("#generateMiniature").attr("src", "preview_bloc.php?miniature="+ID+"&type=menu");
				
			}, time)
			
			time += 4000;
	
		})	
		
		<?php } ?>		
	});
</script>

