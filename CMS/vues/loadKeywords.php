<?php
$limit = 10;
$count = 0;
if(isset($_GET['key']))
{
		echo "<ul class='keywordsItems'>";
		$keyword = strtolower($_GET['key']); 
		
		if($fichierKeyword = file_get_contents("content/keywords/keywords.txt"))
		{
			
		}
		else
		{
			$fichierKeyword = fopen("content/keywords/keywords.txt", "w+");
		}
		$fichierKeyword = explode(";\n", $fichierKeyword);
		
		foreach($fichierKeyword as $mot)
		{
			
			if(strrpos(strtolower($mot), $keyword) !== false)
			{
				if($count < $limit)
				{
					$count++;
					echo "<li class='keywordsItem'>".$mot."</li>";	
				}
			}
		}
		

		
		echo "</ul>";
}
	
?>

