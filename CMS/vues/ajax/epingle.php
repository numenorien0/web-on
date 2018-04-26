<?php

if(isset($_GET['action']) AND $_GET['action'] == "add")
{
    if(!file_exists("content/epingle.json"))
    {
        $array = json_encode([]);
        file_put_contents("content/epingle.json", $array);
        
    }
    
    $array = json_decode(file_get_contents("content/epingle.json"),true);
    $array[$_GET['name']] = $_GET['url'];
    $file = json_encode($array);
    file_put_contents("content/epingle.json", $file);
    
}

if(isset($_GET['action']) AND $_GET['action'] == "remove")
{
    
    $file = json_decode(file_get_contents("content/epingle.json"), true);
    unset($file[$_GET['name']]);
    $file = json_encode($file);
    file_put_contents("content/epingle.json", $file);
    
}


?>