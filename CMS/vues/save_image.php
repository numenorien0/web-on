<?php
print_r($_POST);
$data = $_POST['image'];

list($type, $data) = explode(';', $data);
list(, $data)      = explode(',', $data);
$data = base64_decode($data);

if($_POST['type'] != "miniature")
{
	if($_POST['type'] == "menu")
	{
		if(file_exists("wireframes/Menu/".$_POST['miniature']."/preview_2.png"))
		{
			@unlink("wireframes/Menu/".$_POST['miniature']."/preview_2.png");
		}
		$file = fopen("wireframes/Menu/".$_POST['miniature']."/preview_2.png", "w+");
		fputs($file, $data);	
	
	}
	else
	{
		if(file_exists("wireframes/Pages/".$_POST['miniature']."/preview_2.png"))
		{
			@unlink("wireframes/Pages/".$_POST['miniature']."/preview_2.png");
		}
		$file = fopen("wireframes/Pages/".$_POST['miniature']."/preview_2.png", "w+");
		fputs($file, $data);	
	}
}
else
{
	if(file_exists("wireframes/Miniatures/".$_POST['miniature']."/preview_2.png"))
	{
		@unlink("wireframes/Miniatures/".$_POST['miniature']."/preview_2.png");
	}
	$file = fopen("wireframes/Miniatures/".$_POST['miniature']."/preview_2.png", "w+");
	fputs($file, $data);
}
	
	echo "<img src='".$_POST['image']."'/>"; 
	echo "<br/><br/>Image générée.";
?>

