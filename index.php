<?php
	//INIT VIEWS OF PILOT 2.Oh!
	//fatman
ini_set('display_errors','off');
error_reporting(E_ALL);
	function __autoload($class_name) {
		include_once "CMS/controleurs/".$class_name . ".class.php";
	}	

    $pilot = new pilot();
    if(!$pilot->_the_page = $pilot->get_page($_GET['f']))
    {
        include("CMS/themes/".$pilot->get_skin()."/pages/404.php");
    }
    else{
        if($pilot->_the_page == "maintenance")
        {
            include("CMS/themes/".$pilot->get_skin()."/pages/maintenance.php");
        }
        else
        {
	        if(!$pilot->_the_page['display'])
	        {
		        include("CMS/themes/".$pilot->get_skin()."/pages/404.php");
	        }
	        else{
		        include("CMS/themes/".$pilot->get_skin()."/pages/".$pilot->_the_page["display"]);
	        }
            
    
        }    
    }
    //print_r($pilot->list_all_language());
    #echo "/CMS/themes/".$pilot->get_skin()."/pages/".$pilot->get_page($_GET['ID'])["display"];
    
    
?>