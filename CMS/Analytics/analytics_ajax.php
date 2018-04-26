<?php
header("Access-Control-Allow-Origin: *");
	
	$visitor_url = $_GET['url'];
	
	$visitor_current_base = str_replace('www.', '', str_replace('http://', '', str_replace('<!-- ', '', str_replace(' -->', '', $visitor_url))));
		
	$visitor_current_url = substr($visitor_current_base,0,strpos($visitor_current_base, "/"));
	$visitor_current_page = str_replace($visitor_current_url, '', $visitor_current_base);
	$visitor_current_page = rtrim($visitor_current_page, '/');
	$visitor_current_page = substr($visitor_current_page,strpos($visitor_current_page, "/")+1);
	if($visitor_current_page == "")
	{
		$visitor_current_page = "index.php";
	}
	
	$visitedPage = file_get_contents("analytics/time/".$visitor_current_page);
	$visitedPage = $visitedPage + 3;
	$visitor_ip = $_SERVER['REMOTE_ADDR'];
	
	//touch("analytics/realtime/visitors/".$visitor_ip);
	if (!file_exists("analytics/time/")) 
	{
		mkdir("analytics/time/", 0777, true);
	}	
	
	file_put_contents("analytics/time/".$visitor_current_page, $visitedPage);
	
?>