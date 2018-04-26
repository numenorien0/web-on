<?php

if(isset($_GET['key']))
{
	if($_GET['key'] == null)
	{
		
	}
	else
	{
		$menu = new Menu();
		$menu->listAllByKeyword();
	}
}
	
?>

