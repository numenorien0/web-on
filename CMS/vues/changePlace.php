<?php
include("controleurs/DB.class.php");
$main = new DB();
$db = $main->__construct();

/*
if(!isset($_POST['parent']))
{
	$parent = $_POST['parent'];
}
else
{
	$parent = "";
}
*/
$tableau = $_POST['tableau'];
// print_r($tableau);
//$tableau = json_decode($tableau, TRUE);
$key = 1;
$tableau = array_reverse($tableau);
// print_r($tableau);
foreach($tableau as $ligne)
{
	echo $ligne;
	$sql = "UPDATE contenu SET orderID = $key WHERE ID = $ligne";
	$reponse = $db->query($sql);
	$key++;
}


	
?>

