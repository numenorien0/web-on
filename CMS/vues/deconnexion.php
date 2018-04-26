<?php
setcookie("weboncmslogin","",0, "/");
if(isset($_GET['redirect']))
{
	header("location: ".$_GET['redirect']);
}
else
{
	header("location: index.php");
}
?>

