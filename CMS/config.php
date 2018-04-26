<?php 

/////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////EN-TETE DES PAGES////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////

ini_set('display_errors','off');
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
$cssBootstrap = '<link rel="stylesheet" href="CSS/bootstrap.min.css">';
$cssGlobal = '<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,200,200italic,300,300italic,600,400italic,600italic,700,700italic,900,900italic" rel="stylesheet" type="text/css"><link rel="stylesheet" type="text/css" href="CSS/contextMenu.css"><link rel="icon" type="image/png" href="images/favicon.png" /><link rel="stylesheet" href="CSS/switchery.min.css"><link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet"><link href="https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,900italic,900,700italic,700,500italic,500,400italic" rel="stylesheet" type="text/css"><link rel="stylesheet" type="text/css" href="CSS/spectrum.css"><link rel="stylesheet" type="text/css" href="CSS/select2.min.css"><link rel="stylesheet" type="text/css" href="CSS/date.css"><link rel="stylesheet" type="text/css" href="CSS/global.css">';
$jsBootstrap = '<script src="JS/bootstrap.min.js"></script>';
$jsGlobal = '<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=places"></script><script type="text/javascript" src="JS/date.full.js"></script><script type="text/javascript" src="JS/location.js"></script><script src="JS/html2canvas.js"></script><script src="JS/canvas2image.js"></script><script src="JS/Chart.min.js"></script><script src="JS/go.js"></script><script src="JS/jquery-ui.min.js"></script><script src="JS/switchery.min.js"></script><script type="text/javascript" src="JS/contextMenu.js"></script><script src="JS/right.js"></script><script src="https://unpkg.com/scrollreveal@3.3.2/dist/scrollreveal.min.js"></script><script type="text/javascript" src="JS/global.js"></script>';
$nomDeLaPage = str_replace(".php","",$_GET['f']);
$cssDeLaPage = '<link rel="stylesheet" type="text/css" href="CSS/'.$nomDeLaPage.'.css">';
$APIGoogleMap = '<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyCjk5gRtdkvBJRb9vDc9uwpqNmERpRd-yc&libraries=places"></script>';
$jsDeLaPage = '<script src="JS/codemirror.js"></script><script src="JS/diff.js"></script><script src="JS/bootbox.min.js"></script><script src="JS/select2.full.min.js"></script><script src="JS/tinymce/tinymce.min.js"></script><script src="JS/cookie.js"></script><script src="JS/spectrum.js"></script><script type="text/javascript" src="JS/'.$nomDeLaPage.'.js"></script><script src="JS/activeSwitchery.js"></script>';
$jquery = '<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>';
$fontAwsome ='<link rel="stylesheet" href="CSS/fontawesome/css/fontawesome-all.min.css">';
$datatablesJS = '<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>';
$datatablesCSS = '<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">';
$jsSelect2 ='<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>';
$cssSelect2 ='<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />';
$includeJSAndCSS = $cssBootstrap.$cssGlobal.$cssDeLaPage.$jquery.$jsBootstrap.$jsGlobal.$jsSelect2.$cssSelect2.$jsDeLaPage.$fontAwsome.$datatablesCSS.$datatablesJS.$APIGoogleMap;
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////


?>