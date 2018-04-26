<?php
	$begin_time = microtime(true);

	
	session_start();

	if (!isset($_SESSION['admin_online']))
	{
		header('HTTP/1.0 404 Not Found');
		exit;
	}
	
	include('main.php');
	
	
	
	
	
	// Functions
	
	function filecount($path) 
	{
    	$size = 0;
    	$ignore = array('.','..','cgi-bin','.DS_Store');
    	$files = scandir($path);
    	foreach($files as $t) 
    	{
        	if(in_array($t, $ignore)) continue;
        	if (is_dir(rtrim($path, '/') . '/' . $t)) 
        	{
           	 	$size += filecount(rtrim($path, '/') . '/' . $t);
        	} 
        	else 
        	{
            	$size++;
        	}   
    	}
    	return $size;
	}
	
	
	
	
	
	
	
	
	
	if(!isset($_GET['video']))
	{
	
	
	date_default_timezone_set($timezone);
	
	$current_time = time();
	
	$dateMonth = array(
		date('Ym'),
		date("Ym", strtotime("-1 month")),
		date("Ym", strtotime("-2 month")),
		date("Ym", strtotime("-3 month")),
		date("Ym", strtotime("-4 month")),
		date("Ym", strtotime("-5 month")),
		date("Ym", strtotime("-5 month")),
		date("Ym", strtotime("-6 month")),
		date("Ym", strtotime("-7 month")),
		date("Ym", strtotime("-8 month")),
		date("Ym", strtotime("-9 month")),
		date("Ym", strtotime("-10 month")),
		date("Ym", strtotime("-11 month")),
		date("Ym", strtotime("-12 month")),
		date("Ym", strtotime("-13 month")),
		date("Ym", strtotime("-14 month")),
		date("Ym", strtotime("-15 month")),
		date("Ym", strtotime("-16 month")),
		date("Ym", strtotime("-17 month")),
		date("Ym", strtotime("-18 month")),
		date("Ym", strtotime("-19 month")),
		date("Ym", strtotime("-20 month")),
		date("Ym", strtotime("-21 month")),
		date("Ym", strtotime("-22 month")),
		date("Ym", strtotime("-23 month")),
		date("Ym", strtotime("-24 month")),
		date("Ym", strtotime("-25 month")),
		date("Ym", strtotime("-26 month")),
		date("Ym", strtotime("-27 month")),
		date("Ym", strtotime("-28 month")),
		date("Ym", strtotime("-29 month"))
	);

	$dateLabelMonth = array(
		date("m/y"),
		date("m/y", strtotime("-1 month")),
		date("m/y", strtotime("-2 month")),
		date("m/y", strtotime("-3 month")),
		date("m/y", strtotime("-4 month")),
		date("m/y", strtotime("-5 month")),
		date("m/y", strtotime("-6 month")),
		date("m/y", strtotime("-7 month")),
		date("m/y", strtotime("-8 month")),
		date("m/y", strtotime("-9 month")),
		date("m/y", strtotime("-10 month")),
		date("m/y", strtotime("-11 month")),
		date("m/y", strtotime("-12 month")),
		date("m/y", strtotime("-13 month")),
		date("m/y", strtotime("-14 month")),
		date("m/y", strtotime("-15 month")),
		date("m/y", strtotime("-16 month")),
		date("m/y", strtotime("-17 month")),
		date("m/y", strtotime("-18 month")),
		date("m/y", strtotime("-19 month")),
		date("m/y", strtotime("-20 month")),
		date("m/y", strtotime("-21 month")),
		date("m/y", strtotime("-22 month")),
		date("m/y", strtotime("-23 month")),
		date("m/y", strtotime("-24 month")),
		date("m/y", strtotime("-25 month")),
		date("m/y", strtotime("-26 month")),
		date("m/y", strtotime("-27 month")),
		date("m/y", strtotime("-28 month")),
		date("m/y", strtotime("-29 month"))
	);

	
	$date = array(
		date('Ymd'),
		date('Ymd', strtotime("-1 days")),
		date('Ymd', strtotime("-2 days")),
		date('Ymd', strtotime("-3 days")),
		date('Ymd', strtotime("-4 days")),
		date('Ymd', strtotime("-5 days")),
		date('Ymd', strtotime("-6 days")),
		date('Ymd', strtotime("-7 days")),
		date('Ymd', strtotime("-8 days")),
		date('Ymd', strtotime("-9 days")),
		date('Ymd', strtotime("-10 days")),
		date('Ymd', strtotime("-11 days")),
		date('Ymd', strtotime("-12 days")),
		date('Ymd', strtotime("-13 days")),
		date('Ymd', strtotime("-14 days")),
		date('Ymd', strtotime("-15 days")),
		date('Ymd', strtotime("-16 days")),
		date('Ymd', strtotime("-17 days")),
		date('Ymd', strtotime("-18 days")),
		date('Ymd', strtotime("-19 days")),
		date('Ymd', strtotime("-20 days")),
		date('Ymd', strtotime("-21 days")),
		date('Ymd', strtotime("-22 days")),
		date('Ymd', strtotime("-23 days")),
		date('Ymd', strtotime("-24 days")),
		date('Ymd', strtotime("-25 days")),
		date('Ymd', strtotime("-26 days")),
		date('Ymd', strtotime("-27 days")),
		date('Ymd', strtotime("-28 days")),
		date('Ymd', strtotime("-29 days"))
	);
	
	$dateLabel = array(
		date("d/m"),
		date("d/m", strtotime("-1 days")),
		date("d/m", strtotime("-2 days")),
		date("d/m", strtotime("-3 days")),
		date("d/m", strtotime("-4 days")),
		date("d/m", strtotime("-5 days")),
		date("d/m", strtotime("-6 days")),
		date("d/m", strtotime("-7 days")),
		date("d/m", strtotime("-8 days")),
		date("d/m", strtotime("-9 days")),
		date("d/m", strtotime("-10 days")),
		date("d/m", strtotime("-11 days")),
		date("d/m", strtotime("-12 days")),
		date("d/m", strtotime("-13 days")),
		date("d/m", strtotime("-14 days")),
		date("d/m", strtotime("-15 days")),
		date("d/m", strtotime("-16 days")),
		date("d/m", strtotime("-17 days")),
		date("d/m", strtotime("-18 days")),
		date("d/m", strtotime("-19 days")),
		date("d/m", strtotime("-20 days")),
		date("d/m", strtotime("-21 days")),
		date("d/m", strtotime("-22 days")),
		date("d/m", strtotime("-23 days")),
		date("d/m", strtotime("-24 days")),
		date("d/m", strtotime("-25 days")),
		date("d/m", strtotime("-26 days")),
		date("d/m", strtotime("-27 days")),
		date("d/m", strtotime("-28 days")),
		date("d/m", strtotime("-29 days"))
	);
	
	//print_r($dateLabel);
	
	
	
	
	// Analytics database directories
	
	$realtime_analytics_folder = $analytics_folder . '/realtime/';
	
	$realtime_analytics_visitors_folder = $realtime_analytics_folder . 'visitors/';
	$realtime_analytics_pageviews_folder = $realtime_analytics_folder . 'pageviews/';
	
	$visitors_analytics_folder = $analytics_folder . '/visitors/';
	$pageviews_analytics_folder = $analytics_folder . '/pageviews/';
	$stats_analytics_folder = $analytics_folder . '/stats/';
	
	$stats_analytics_visitors_folder = $stats_analytics_folder . 'visitors/';
	$stats_analytics_visitors_ip_folder = $stats_analytics_folder . 'IP/';
	$stats_analytics_pageviews_folder = $stats_analytics_folder . 'pageviews/';
	
	$stats_analytics_pages_folder = $stats_analytics_folder . 'pages/';
	$stats_analytics_pages_total_folder = $stats_analytics_pages_folder . 'total/';
	
	$stats_analytics_referrers_folder = $stats_analytics_folder . 'referrers/';
	$stats_analytics_referrers_total_folder = $stats_analytics_referrers_folder . 'total/';
	
	$stats_analytics_countries_folder = $stats_analytics_folder . 'countries/';
	$stats_analytics_countries_total_folder = $stats_analytics_countries_folder . 'total/';
	
	$stats_analytics_cities_folder = $stats_analytics_folder . 'cities/';
	$stats_analytics_cities_total_folder = $stats_analytics_cities_folder . 'total/';
	
	$stats_analytics_devices_folder = $stats_analytics_folder . 'devices/';
	$stats_analytics_devices_total_folder = $stats_analytics_devices_folder . 'total/';
	
	$stats_analytics_oss_folder = $stats_analytics_folder . 'oss/';
	$stats_analytics_oss_total_folder = $stats_analytics_oss_folder . 'total/';
	
	$stats_analytics_browsers_folder = $stats_analytics_folder . 'browsers/';
	$stats_analytics_browsers_total_folder = $stats_analytics_browsers_folder . 'total/';
	
	$stats_analytics_lang_folder = $stats_analytics_folder . 'lang/';
	$stats_analytics_lang_total_folder = $stats_analytics_lang_folder . 'total/';
	
	
	
	
	$analytics_content = "";
	
	
	
	
	
	
	// Compute analytics
	
	
	
	
	
	// Realtime analytics
	
	$realtime_visitors = glob($realtime_analytics_visitors_folder . '*');
	
	$current_online_visitor_count = 0;
	
	$current_realtime_visitor_count = 0;
	$one_minute_realtime_visitor_count = 0;
	$two_minutes_realtime_visitor_count = 0;
	$three_minutes_realtime_visitor_count = 0;
	$four_minutes_realtime_visitor_count = 0;
	$five_minutes_realtime_visitor_count = 0;
	$six_minutes_realtime_visitor_count = 0;
	$seven_minutes_realtime_visitor_count = 0;
	$eight_minutes_realtime_visitor_count = 0;
	$nine_minutes_realtime_visitor_count = 0;

  	foreach ($realtime_visitors as $visitor)
  	{
    	if (is_file($visitor))
    	{
    		if (($current_time - filemtime($visitor)) < 180)
      		{
        		$current_online_visitor_count += 1;
        	}
        	
      		if (($current_time - filemtime($visitor)) < 60)
      		{
        		$current_realtime_visitor_count += 1;
        	}
        	
        	if ((($current_time - filemtime($visitor)) >= 60) && (($current_time - filemtime($visitor)) < 120))
      		{
        		$one_minute_realtime_visitor_count += 1;
        	}
        	
        	if ((($current_time - filemtime($visitor)) >= 120) && (($current_time - filemtime($visitor)) < 180))
      		{
        		$two_minutes_realtime_visitor_count += 1;
        	}
        	
        	if ((($current_time - filemtime($visitor)) >= 180) && (($current_time - filemtime($visitor)) < 240))
      		{
        		$three_minutes_realtime_visitor_count += 1;
        	}
        	
        	if ((($current_time - filemtime($visitor)) >= 240) && (($current_time - filemtime($visitor)) < 300))
      		{
        		$four_minutes_realtime_visitor_count += 1;
        	}
        	
        	if ((($current_time - filemtime($visitor)) >= 300) && (($current_time - filemtime($visitor)) < 360))
      		{
        		$five_minutes_realtime_visitor_count += 1;
        	}
        	
        	if ((($current_time - filemtime($visitor)) >= 360) && (($current_time - filemtime($visitor)) < 420))
      		{
        		$six_minutes_realtime_visitor_count += 1;
        	}
        	
        	if ((($current_time - filemtime($visitor)) >= 420) && (($current_time - filemtime($visitor)) < 480))
      		{
        		$seven_minutes_realtime_visitor_count += 1;
        	}
        	
        	if ((($current_time - filemtime($visitor)) >= 480) && (($current_time - filemtime($visitor)) < 540))
      		{
        		$eight_minutes_realtime_visitor_count += 1;
        	}
        	
        	if ((($current_time - filemtime($visitor)) >= 540) && (($current_time - filemtime($visitor)) < 600))
      		{
        		$nine_minutes_realtime_visitor_count += 1;
        	}
        	
        	if (($current_time - filemtime($visitor)) >= 600)
      		{
        		unlink($visitor);
        	}
        }
    }
    
    
    
    
    
    $realtime_pageviews = glob($realtime_analytics_pageviews_folder . '*');
	
	$current_realtime_pageviews_count = 0;
	$one_minute_realtime_pageviews_count = 0;
	$two_minutes_realtime_pageviews_count = 0;
	$three_minutes_realtime_pageviews_count = 0;
	$four_minutes_realtime_pageviews_count = 0;
	$five_minutes_realtime_pageviews_count = 0;
	$six_minutes_realtime_pageviews_count = 0;
	$seven_minutes_realtime_pageviews_count = 0;
	$eight_minutes_realtime_pageviews_count = 0;
	$nine_minutes_realtime_pageviews_count = 0;

  	foreach ($realtime_pageviews as $pageviews)
  	{
    	if (is_file($pageviews))
    	{
      		if (($current_time - filemtime($pageviews)) < 60)
      		{
        		$current_realtime_pageviews_count += 1;
        	}
        	
        	if ((($current_time - filemtime($pageviews)) >= 60) && (($current_time - filemtime($pageviews)) < 120))
      		{
        		$one_minute_realtime_pageviews_count += 1;
        	}
        	
        	if ((($current_time - filemtime($pageviews)) >= 120) && (($current_time - filemtime($pageviews)) < 180))
      		{
        		$two_minutes_realtime_pageviews_count += 1;
        	}
        	
        	if ((($current_time - filemtime($pageviews)) >= 180) && (($current_time - filemtime($pageviews)) < 240))
      		{
        		$three_minutes_realtime_pageviews_count += 1;
        	}
        	
        	if ((($current_time - filemtime($pageviews)) >= 240) && (($current_time - filemtime($pageviews)) < 300))
      		{
        		$four_minutes_realtime_pageviews_count += 1;
        	}
        	
        	if ((($current_time - filemtime($pageviews)) >= 300) && (($current_time - filemtime($pageviews)) < 360))
      		{
        		$five_minutes_realtime_pageviews_count += 1;
        	}
        	
        	if ((($current_time - filemtime($pageviews)) >= 360) && (($current_time - filemtime($pageviews)) < 420))
      		{
        		$six_minutes_realtime_pageviews_count += 1;
        	}
        	
        	if ((($current_time - filemtime($pageviews)) >= 420) && (($current_time - filemtime($pageviews)) < 480))
      		{
        		$seven_minutes_realtime_pageviews_count += 1;
        	}
        	
        	if ((($current_time - filemtime($pageviews)) >= 480) && (($current_time - filemtime($pageviews)) < 540))
      		{
        		$eight_minutes_realtime_pageviews_count += 1;
        	}
        	
        	if ((($current_time - filemtime($pageviews)) >= 540) && (($current_time - filemtime($pageviews)) < 600))
      		{
        		$nine_minutes_realtime_pageviews_count += 1;
        	}
        	
        	if (($current_time - filemtime($pageviews)) >= 600)
      		{
        		unlink($pageviews);
        	}
        }
    }
    
	
	
	
	
	$first = scandir($stats_analytics_visitors_folder);
	$first = $first[2];
	$first = strtotime($first);
	$displayButton = "<a class='all' href='admin.php?from=now&to=".$first."&displayBy=month&filter=all#buttonDate'>Tout</a><a class='Sevendays' href='?from=now&to=".strtotime('-6 days', time())."&displayBy=day&filter=Sevendays#buttonDate'>7 derniers jours</a><a class='month' href='?from=now&to=".strtotime(date("01-m-Y"))."&displayBy=day&filter=month#buttonDate'>Ce mois</a><a class='year' href='?from=now&to=".strtotime(date("01-01-Y"))."&displayBy=month&filter=year#buttonDate'>Cette année</a><span class='custom' href='#buttonDate'>Personnalisé</span><form id='customForm' style='margin-top: 40px; position: absolute; z-index: 20; padding: 15px; background-color: white !important; border-radius: 4px; display: none; box-shadow: 0px 0px 20px rgba(0,0,0,0.2); font-family: Helvetica-Light' action method='GET'><h6 class='titleForm'>Sélection personnalisée<br/><span class='dayDisplay'>Encodage par date décroissante.</span></h6>Du <input id='au' type='date'> au <input id='du' type='date'><br/><br/>Afficher par mois <input type='checkbox' id='month'><br/><span class='dayDisplay'>Affichage par jour par défaut.</span><br/><input type='button' id='submit' value='Valider'></form>";


	
	$filter = $_GET['filter'];
	$title = "";
	switch($filter)
	{
		case "all": $title = "Statistiques depuis le début.";
		break;
		case "Sevendays": $title = "Statistiques sur les 7 derniers jours.";
		break;
		case "month": $title = "Statistiques sur le mois.";
		break;
		case "year": $title = "Statistiques de l'année";
		break;
		case "custom" : $title = "Statistiques du ".date("d/m/Y", $_GET['from'])." au ".date("d/m/Y", $_GET['to']).".";
	}
	
	echo "<style>";
	echo ".$filter";
	echo "{border: 1px solid black !important; color: black !important;}";
	echo "</style>";
	// Visitor analytics
	
	if(isset($_GET['from']) AND isset($_GET['to']))
	{

		
		$to = $_GET['to'];
		$to = date("Ymd", $to);
		$toLabel = date("d/m/Y", $_GET['to']);
		$count = 0;
		$currentMonth = date("m");
		if($_GET['from'] == "now")
		{
			$now = date("Ymd");
			$nowTime = time();
		}
		else
		{
			$now = date("Ymd", $_GET['from']);
			$nowTime = $_GET['from'];
			//echo $now;
		}
		$datum = array();
		$month = array();
		$labelVisitorFromTo = "Depuis le: $toLabel";
		$labelPageFromTo = "Depuis le: $toLabel";
		#echo $now."<br/>".$to."<br/>";
		#echo date("Ymd", strtotime("+$count days", $to))."<br/>";
		while($to < $now)
		{
			$label = date("d/m/Y", strtotime("-$count days", $nowTime));
			$now = date("Ymd", strtotime("-$count days", $nowTime));
			$month[] = date("m", strtotime("-$count days", $nowTime));
			#echo $to."<br/>";
			$count++;
			$datum[] = $now;
			$datumLabel[] = $label;
			
		}
		
		
		$datum = array_reverse($datum);
		$datumLabel = array_reverse($datumLabel);
		$month = array_reverse($month);

    	if($_GET['displayBy'] == "month")
    	{
	    	$datumLabel = [];
    	}
		
		//print_r($datumLabel);
		//print_r($datum);
		//VISITORS
		$visitors = array();
		$thirty_days_visitors = 0;
		$valeur = 0;
// 		print_r($month);
		$currentMonth = $month[0];
		//echo $currentMonth;
		foreach($datum as $d)
		{
			$thisMonth = substr($d, 4, 2);
			$thisYear = substr($d, 0, 4);
			#echo $thisMonth."<br/>";
			
			$value = file($stats_analytics_visitors_folder . $d);
			#echo $d." ".$value[0]."<br/>";
			if($_GET['displayBy'] == "month")
			{
				$labelVisitorFromToday = "Ce mois ci";
				#if(file_exists($stats_analytics_visitors_folder . $d))
				#{
					
				#}
				if($currentMonth != $thisMonth)
				{
					$datumLabel[] = $currentMonth."/".$thisYear;
					$visitors[] = $valeur;
					//echo $currentMonth;
					$currentMonth = $thisMonth;
					$valeur = $value[0];
					//echo "<strong>".$currentMonth." ".$valeur."</strong><br/>";
					
					
				}
				else
				{
					//echo $valeur."<br/>";
					$valeur += $value[0];
				}
			}
			else
			{
				$labelVisitorFromToday = "Aujourd'hui";
				if(file_exists($stats_analytics_visitors_folder . $d))
				{
    				array_push($visitors, $value[0]);
    			}
				else
				{
    				array_push($visitors, 0);
    			}
    		}
    		#echo $value[0]."<br/>";
    		$thirty_days_visitors += $value[0];
    		
    	}
    	
    	
    	if($_GET['displayBy'] == "month")
    	{
			$datumLabel[] = $currentMonth."/".$thisYear;
			$visitors[] = $valeur;    	
    	}
    	//print_r($visitors);
		$pageviews = array();
		$thirty_days_pageviews = 0;
		$currentMonth = $month[0];
		$valeur = 0;
		foreach($datum as $d)
		{
			$value = file($stats_analytics_pageviews_folder . $d);
			$thisMonth = substr($d, 4, 2);
			if($_GET['displayBy'] == "month")
			{
				
				$labelVisitorFromToday = "Ce mois ci";
				if($thisMonth != $currentMonth)
				{
					
					$pageviews[] = $valeur;
				
					$currentMonth = $thisMonth;
					$valeur = $value[0];
					
					
					
				}
				else
				{
					//echo $valeur."<br/>";
					$valeur += $value[0];
				}
			}
			else
			{
				if(file_exists($stats_analytics_pageviews_folder . $d))
				{
	    			array_push($pageviews, $value[0]);
	    		}
				else
				{
	    			array_push($pageviews, 0);
	    		}
    		}
    		$thirty_days_pageviews += $value[0];
			
    	}
		
		if($_GET['displayBy'] == "month")
    	{
			$pageviews[] = $valeur;   	
    	}
		
		
		foreach($pageviews as $key => $pageview)
		{
			$labelsGraphPageviews[] = "'".$datumLabel[$key]."'";
			$valueGraphPageviews[] = $pageview;		
		}
		$labelsGraphPageviews = implode(",", $labelsGraphPageviews);
		$valueGraphPageviews = implode(",", $valueGraphPageviews);
		foreach($visitors as $key => $visitor)
		{
			$labelsGraphVisitors[] = "'".$datumLabel[$key]."'";
			$valueGraphVisitors[] = $visitor;		
		}
		$labelsGraphVisitors = implode(",", $labelsGraphVisitors);
		$valueGraphVisitors = implode(",", $valueGraphVisitors);
		
		
		
		#echo $lengthVisitors;
	}
	else
	{
		header("location: admin.php?from=now&to=".strtotime(date("01-m-Y"))."&displayBy=day&filter=month");
		echo "<script>window.location.href = 'admin.php?from=now&to=".strtotime(date("01-m-Y"))."&displayBy=day&filter=month'</script>";
	}	
	
	
	// Pages analytics
	
	$pages_list = glob($stats_analytics_pages_folder . 'total/' . '*');
	
	
	foreach($pages_list as $pagename)
	{
		//$pagename = str_replace('_slash_', '/', $pagename);
		$total_pages[str_replace($stats_analytics_pages_folder . 'total/', '', $pagename)] = 0;	
		
	}
	
	$to = $_GET['to'];
	$to = date("Ymd", $to);
	
	$count = 0;
	
		if($_GET['from'] == "now")
		{
			$now = date("Ymd");
			$nowTime = time();
		}
		else
		{
			$now = date("Ymd", $_GET['from']);
			$nowTime = $_GET['from'];
			//echo $now;
		}
	
	while($to < $now)
	{
		$label = date("d/m/Y", strtotime("-$count days", $nowTime));
		$now = date("Ymd", strtotime("-$count days", $nowTime));
		$count++;
		foreach($total_pages as $key => $pagefile)
		{
			//echo $now."<br/>";
			$value = file($stats_analytics_pages_folder.$now."/".$key);
			//echo $value[0];
			$total_pages[$key] += $value[0];
		}
	}

	
	arsort($total_pages);
	
	//print_r($total_pages);
	
	foreach($pages_list as $pagename)
	{
		#$pagename = str_replace('_slash_', '/', $pagename); 
		$pagename = str_replace($stats_analytics_pages_folder . 'total/', '', $pagename);
		$today_pages[$pagename] = (($value = file($stats_analytics_pages_folder . $date[0] . '/' .$pagename)) ? $value[0] : 0);
	}
	
	arsort($today_pages);
	
	
	$total_pages_keys = array_keys($total_pages);
	$today_pages_keys = array_keys($today_pages);
		
	$total_pages_page = array();
	$total_pages_count = array();
	$today_pages_page = array();
	$today_pages_count = array();
	
	for ($i = 0; $i <= 9; $i++)
	{
		array_push($total_pages_page,array_key_exists($i,$total_pages_keys) ? $total_pages_keys[$i] : '');
		array_push($today_pages_page,array_key_exists($i,$today_pages_keys) ? $today_pages_keys[$i] : '');
		
		array_push($total_pages_count,array_key_exists($total_pages_keys[$i],$total_pages) ? $total_pages[$total_pages_keys[$i]] : 0);
		array_push($today_pages_count,array_key_exists($today_pages_keys[$i],$today_pages) ? $today_pages[$today_pages_keys[$i]] : 0);
	}
	
	
	
	// Language analytics
	
	$lang_list = glob($stats_analytics_lang_folder . 'total/' . '*');
	

	





	


	foreach($lang_list as $langname)
	{
		$langname = str_replace('_slash_', '/', $langname);
		
		$total_lang[str_replace($stats_analytics_lang_folder . 'total/', '', $langname)] = 0; //(($value = file($langname)) ? $value[0] : 0)	
	
	}

	$to = $_GET['to'];
	$to = date("Ymd", $to);
	
	$count = 0;
	
	if($_GET['from'] == "now")
	{
		$now = date("Ymd");
		$nowTime = time();
	}
	else
	{
		$now = date("Ymd", $_GET['from']);
		$nowTime = $_GET['from'];
		//echo $now;
	}
	
	while($to < $now)
	{
		$label = date("d/m/Y", strtotime("-$count days", $nowTime));
		$now = date("Ymd", strtotime("-$count days", $nowTime));
		$count++;
		foreach($total_lang as $key => $langfile)
		{
			
			$value = file($stats_analytics_lang_folder.$now."/".$key);
			$total_lang[$key] += $value[0];
		}
	}
	
	//print_r($total_lang);
	arsort($total_lang);

	$total_lang_label = array_flip($total_lang);

	
	
	
	foreach($lang_list as $langname)
	{
		$langname = str_replace('_slash_', '/', $langname);
		$langname = str_replace($stats_analytics_lang_folder . 'total/', '', $langname);
		$today_lang[$langname] = (($value = file($stats_analytics_lang_folder . $date[0] . '/' .$langname)) ? $value[0] : 0);
	}
	
	arsort($today_lang);
	
	
	
	
	$total_lang_keys = array_keys($total_lang);
	$today_lang_keys = array_keys($today_lang);
		
	$total_lang_page = array();
	$total_lang_count = array();
	$today_lang_page = array();
	$today_lang_count = array();
	
	
	for ($i = 0; $i <= 9; $i++)
	{
		array_push($total_lang_lang,array_key_exists($i,$total_lang_keys) ? $total_lang_keys[$i] : '');
		array_push($today_lang_lang,array_key_exists($i,$today_lang_keys) ? $today_lang_keys[$i] : '');
		
		array_push($total_lang_count,array_key_exists($total_lang_keys[$i],$total_lang) ? $total_lang[$total_lang_keys[$i]] : 0);
		array_push($today_lang_count,array_key_exists($today_lang_keys[$i],$today_lang) ? $today_lang[$today_lang_keys[$i]] : 0);
	}	
	
	//print_r($total_lang);
	
	//print_r($total_lang_count);
	
	
	
	
	
	// Referrer analytics
	
	$referrers_list = glob($stats_analytics_referrers_folder . 'total/' . '*');
	
	
	
	$referrer_category = array();
	$social = 0;
	$search = 0;
	$linkDirect = 0;
	$other = 0;
	
	//$newList = array();
	foreach($referrers_list as $key => $referrername)
	{
		$referrername = str_replace($stats_analytics_referrers_folder."total/", "", $referrername);
		$total_referrers[$referrername] = 0;
		
		
	}
	//print_r($total_referrers);
/*
		$referrerValue = (($value = file($referrername)) ? $value[0] : 0);
		
		$referrername = str_replace($stats_analytics_referrers_folder . 'total/', '', $referrername);
		
		if(strstr($referrername, "facebook") OR strstr($referrername, "linkedin") OR strstr($referrername, "twitter") OR strstr($referrername, "instagram") OR strstr($referrername, "tumblr") OR strstr($referrername, "youtube") OR strstr($referrername, "vimeo") OR strstr($referrername, "pinterest"))
		{
			$referrer_category[$referrername] = "Social";
			$social = $social + $referrerValue;
		}
		elseif(strstr($referrername, "google") OR strstr($referrername, "bing") OR strstr($referrername, "duckduckgo") OR strstr($referrername, "yahoo"))
		{
			$referrer_category[$referrername] = "Search engine";
			$search = $search + $referrerValue;
		}
		elseif(strstr($referrername, "Lien direct"))
		{
			$referrer_category[$referrername] = "Lien direct";
			$linkDirect = $linkDirect + $referrerValue;
		}
		else
		{
			$referrer_category[$referrername] = "Autre";
			$other = $other + $referrerValue;
		}
*/
		
/*
		if(strstr($referrername, "list-manage.com")){$referrername = "Newsletter (mailchimp)";}
		elseif(strstr($referrername, "tpc.googlesyndication")){$referrername = "Google Adsense";}						
		elseif(strstr($referrername, "aclk") OR strstr($referrername, "gclid")){$referrername = "Google Adwords";}
		elseif(strstr($referrername, "images.google")){$referrername = "Google images";}
		elseif(strstr($referrername, "googleads.g.doubleclick")){$referrername = "Google Adsense";}	
*/
		
				
			
			
/*
		$total_referrers[$referrername] = 0;
		$totalReferrer += $value[0];
	}
*/
	
	//arsort($total_referrers);
	
	

	
	$to = $_GET['to'];
	$to = date("Ymd", $to);
	
	$count = 0;
	
	if($_GET['from'] == "now")
	{
		$now = date("Ymd");
		$nowTime = time();
	}
	else
	{
		$now = date("Ymd", $_GET['from']);
		$nowTime = $_GET['from'];
		//echo $now;
	}
	
	$totalReferrer = 0;
	$totalSocial = array();
	$totalSearch = array();
	$totalOther = array();
	$totalDirect = array();
	
	$totalSocialCount = 0;
	$totalSearchCount = 0;
	$totalDirectCount = 0;
	$totalOtherCount = 0;
	
	while($to < $now)
	{
		#echo "<br/><br/>";
		$label = date("d/m/Y", strtotime("-$count days", $nowTime));
		$now = date("Ymd", strtotime("-$count days", $nowTime));
		$count++;
		foreach($total_referrers as $referrername => $referrersfile)
		{
			//echo $now."<br/>";
			$value = file($stats_analytics_referrers_folder.$now."/".$referrername);
			$totalReferrer += $value[0];
			#echo "<br/>".$referrername."<br/>";
			if(strstr($referrername, "google"))
			{
				
				if(strstr($referrername, "tpc.googlesyndication")){$referrername = "Google Adsense"; $category = "search";}						
				elseif(strstr($referrername, "aclk") OR strstr($referrername, "gclid")){$referrername = "Google Adwords"; $category = "search";}
				elseif(strstr($referrername, "images.google")){$referrername = "Google images"; $category = "search";}
				elseif(strstr($referrername, "googleads.g.doubleclick")){$referrername = "Google Adsense"; $category = "search";}	
				else
				{
					$referrername = "Google Search";
					$category = "Moteurs de recherche";
				}			
			}
			elseif(strstr($referrername, "bing"))
			{
				$referrername = "Bing search";
				$category = "Moteurs de recherche";
			}
			elseif(strstr($referrername, "duckduckgo"))
			{
				$referrername = "Duckduckgo search";
				$category = "Moteurs de recherche";
			}
			elseif(strstr($referrername, "yahoo"))
			{
				$referrername = "Yahoo search";
				$category = "Moteurs de recherche";
			}
			elseif(strstr($referrername, "list-manage.com"))
			{
				$referrername = "Newsletter (mailchimp)";
				$category = "Autres";
			}
			elseif(strstr($referrername, "facebook") OR strstr($referrername, "linkedin") OR strstr($referrername, "lnkd.in") OR strstr($referrername, "twitter") OR strstr($referrername, "instagram") OR strstr($referrername, "tumblr") OR strstr($referrername, "youtube") OR strstr($referrername, "vimeo") OR strstr($referrername, "pinterest") OR strstr($referrername, "t.co"))
			{
				$category =  "Reseaux sociaux";
				$referrername = $referrername;
				if(strstr($referrername, "facebook"))
				{
					$referrername = "Facebook";
				}
				if(strstr($referrername, "t.co"))
				{
					$referrername = "Twitter";
				}
				if(strstr($referrername, "lnkd.in") OR strstr($referrername, "linkedin"))
				{
					$referrername = "Linkedin";
				}
				//$social = $social + $referrerValue;
			}
			elseif(strstr($referrername, "Lien direct"))
			{
				$referrername = "Lien direct";
				$category = "Lien direct";
			}
			else
			{
				$category = "Autres";
				$referrername = $referrername;
			}
			
			//echo $category;
			if($category == "Autres")
			{
				$total_referrer_new["Autres"] += $value[0];
				$totalOther[$referrername] += $value[0];
				$totalOtherCount += $value[0];
			}
			if($category == "Moteurs de recherche")
			{
				$total_referrer_new["Moteurs de recherche"] += $value[0];
				$totalSearch[$referrername] += $value[0];
				$totalSearchCount += $value[0];
			}
			if($category == "Reseaux sociaux")
			{
				$total_referrer_new["Reseaux sociaux"] += $value[0];
				$totalSocial[$referrername] += $value[0];
				$totalSocialCount += $value[0];
			}
			if($category == "Lien direct")
			{
				$total_referrer_new["Lien direct"] += $value[0];
				$totalDirect[$referrername] += $value[0];
				$totalDirectCount += $value[0];
			}
			//$total_referrers[$key] += $value[0];
		}
	}
	$total_referrers = $total_referrer_new;
	#print_r($total_referrers);
	arsort($totalDirect);
	arsort($totalSearch);
	arsort($totalSocial);
	arsort($totalOther);
	
	$linkIndex = array();
	arsort($total_referrers);
	foreach($total_referrers as $key => $ref)
	{
		#echo $key;
		$class = "";
		if($key == "Lien direct")
		{
			$class = "directLink";
		}
		if($key == "Reseaux sociaux")
		{
			$class = "socialLink";
		}
		if($key == "Moteurs de recherche")
		{
			$class = "searchLink";
		}
		if($key == "Autres")
		{
			$class = "otherLink";
		}
		
		$linkIndex[] = $class;
	}
	#print_r($linkIndex);
	//DISPLAY BY CATEGORIES OF REFERRERS
	
	//OTHER
	$counter = 0;
	echo "<div id='OtherSub'>";
	#echo "<span class='back'>< Retour</span>";
	foreach($totalOther as $key => $other)
	{
		//echo "ok";
		echo "  <div class=\"tripple_chart_item\">
					<div class=\"tripple_chart_item_huge\">" . $key . "</div>
					<div class=\"tripple_chart_item_small\">" . round(($other/$totalOtherCount)*100) . "%</div>
				</div>";
		
		$counter++;
				
	}
	echo "</div>";
	
	//Search
	$counter = 0;
	echo "<div id='SearchSub'>";
	#echo "<span class='back'>< Retour</span>";
	foreach($totalSearch as $key => $search)
	{
		//echo "ok";
		echo "  <div class=\"tripple_chart_item\">
					<div class=\"tripple_chart_item_huge\">" . $key . "</div>
					<div class=\"tripple_chart_item_small\">" . round(($search/$totalSearchCount)*100) . "%</div>
				</div>";
		
		$counter++;
				
	}
	echo "</div>";
	
	//Social
	$counter = 0;
	echo "<div id='SocialSub'>";
	#echo "<span class='back'>< Retour</span>";
	foreach($totalSocial as $key => $social)
	{
		//echo "ok";
		echo "  <div class=\"tripple_chart_item\">
					<div class=\"tripple_chart_item_huge\">" . $key . "</div>
					<div class=\"tripple_chart_item_small\">" . round(($social/$totalSocialCount)*100) . "%</div>
				</div>";
		
		$counter++;
				
	}
	echo "</div>";
	
	//Direct

	$counter = 0;
	#echo "<div id='DirectSub'>";
	foreach($totalDirect as $key => $direct)
	{
		//echo "ok";
		echo "  <div class=\"tripple_chart_item\">
					<div class=\"tripple_chart_item_huge\">" . $key . "</div>
					<div class=\"tripple_chart_item_small\">" . round(($direct/$totalDirectCount)*100) . "%</div>
				</div>";
		
		$counter++;
				
	}
	echo "</div>";

	
	
	
	
// 	print_r($total_referrers);
	arsort($total_referrers);
	arsort($today_referrers);
	
	
	$total_referrers_keys = array_keys($total_referrers);
	$today_referrers_keys = array_keys($today_referrers);
		
	$total_referrers_referrer = array();
	$total_referrers_count = array();
	$today_referrers_referrer = array();
	$today_referrers_count = array();
	
	for ($i = 0; $i <= 9; $i++)
	{
		
		array_push($total_referrers_referrer,array_key_exists($i,$total_referrers_keys) ? $total_referrers_keys[$i] : '');
		array_push($today_referrers_referrer,array_key_exists($i,$today_referrers_keys) ? $today_referrers_keys[$i] : '');
		
		array_push($total_referrers_count,array_key_exists($total_referrers_keys[$i],$total_referrers) ? $total_referrers[$total_referrers_keys[$i]] : 0);
		array_push($today_referrers_count,array_key_exists($today_referrers_keys[$i],$today_referrers) ? $today_referrers[$today_referrers_keys[$i]] : 0);
	}
	
	
	//echo $total_referrers;
	
	
	
	
	
	/*
		if(strstr($referrername, "tpc.googlesyndication")){$referrername = "Google Adsense";}						
		elseif(strstr($referrername, "aclk") OR strstr($referrername, "gclid")){$referrername = "Google Adwords";}
		elseif(strstr($referrername, "list-manage.com")){$referrername = "Newsletter (Mailchimp)";}
		elseif(strstr($referrername, "images.google")){$referrername = "Google images";}
		elseif(strstr($referrername, "googleads.g.doubleclick")){$referrername = "Google Adsense";}
*/
	
	
	
	
	// Country analytics
	
	$countries_list = glob($stats_analytics_countries_folder . 'total/' . '*');
	
	
	foreach($countries_list as $countryname)
	{
		$total_countries[str_replace($stats_analytics_countries_folder . 'total/', '', $countryname)] = 0;	
	}
	
	arsort($total_countries);
	
	
	foreach($countries_list as $countryname)
	{
		$countryname = str_replace($stats_analytics_countries_folder . 'total/', '', $countryname);
		$today_countries[$countryname] = 0;;
	}
	
	$to = $_GET['to'];
	$to = date("Ymd", $to);
	
	$count = 0;
	
	if($_GET['from'] == "now")
	{
		$now = date("Ymd");
		$nowTime = time();
	}
	else
	{
		$now = date("Ymd", $_GET['from']);
		$nowTime = $_GET['from'];
		//echo $now;
	}
	
	while($to < $now)
	{
		$label = date("d/m/Y", strtotime("-$count days", $nowTime));
		$now = date("Ymd", strtotime("-$count days", $nowTime));
		$count++;
		foreach($total_countries as $key => $pagefile)
		{
			//echo $now."<br/>";
			$value = file($stats_analytics_countries_folder.$now."/".$key);
			//echo $value[0];
			$total_countries[$key] += $value[0];
		}
	}
	arsort($total_countries);
	arsort($today_countries);
	
	
	$total_countries_keys = array_keys($total_countries);
	$today_countries_keys = array_keys($today_countries);
		
	$total_countries_country = array();
	$total_countries_count = array();
	$today_countries_country = array();
	$today_countries_count = array();
	
	for ($i = 0; $i <= 9; $i++)
	{
		array_push($total_countries_country,array_key_exists($i,$total_countries_keys) ? $total_countries_keys[$i] : '');
		array_push($today_countries_country,array_key_exists($i,$today_countries_keys) ? $today_countries_keys[$i] : '');
		
		array_push($total_countries_count,array_key_exists($total_countries_keys[$i],$total_countries) ? $total_countries[$total_countries_keys[$i]] : 0);
		array_push($today_countries_count,array_key_exists($today_countries_keys[$i],$today_countries) ? $today_countries[$today_countries_keys[$i]] : 0);
	}
	
	
	// CITIES analytics
	
	$cities_list = glob($stats_analytics_cities_folder . 'total/' . '*');
	
	
	foreach($cities_list as $cityname)
	{
		$total_cities[str_replace($stats_analytics_cities_folder . 'total/', '', $cityname)] = 0;	
	}
	
	arsort($total_cities);
	
	
	foreach($cities_list as $cityname)
	{
		$cityname = str_replace($stats_analytics_cities_folder . 'total/', '', $cityname);
		$today_cities[$cityname] = 0;;
	}
	
	$to = $_GET['to'];
	$to = date("Ymd", $to);
	
	$count = 0;
	
	if($_GET['from'] == "now")
	{
		$now = date("Ymd");
		$nowTime = time();
	}
	else
	{
		$now = date("Ymd", $_GET['from']);
		$nowTime = $_GET['from'];
		//echo $now;
	}
	
	while($to < $now)
	{
		$label = date("d/m/Y", strtotime("-$count days", $nowTime));
		$now = date("Ymd", strtotime("-$count days", $nowTime));
		$count++;
		foreach($total_cities as $key => $pagefile)
		{
			//echo $now."<br/>";
			$value = file($stats_analytics_cities_folder.$now."/".$key);
			//echo $value[0];
			$total_cities[$key] += $value[0];
		}
	}
	arsort($total_cities);
	arsort($today_cities);
	
	
	$total_cities_keys = array_keys($total_cities);
	$today_cities_keys = array_keys($today_cities);
		
	$total_cities_country = array();
	$total_cities_count = array();
	$today_cities_country = array();
	$today_cities_count = array();
	
	$countListe = count($total_cities);
	//echo $countListe;
	for ($i = 0; $i <= $countListe; $i++)
	{
		array_push($total_cities_country,array_key_exists($i,$total_cities_keys) ? $total_cities_keys[$i] : '');
		array_push($today_cities_country,array_key_exists($i,$today_cities_keys) ? $today_cities_keys[$i] : '');
		
		array_push($total_cities_count,array_key_exists($total_cities_keys[$i],$total_cities) ? $total_cities[$total_cities_keys[$i]] : 0);
		array_push($today_cities_count,array_key_exists($today_cities_keys[$i],$today_cities) ? $today_cities[$today_cities_keys[$i]] : 0);
	}	
	
	
	
	
	
	
	// Devices analytics
	
	
	$total_devices = array( "Desktop" => (($value = file($stats_analytics_devices_folder . 'total/Desktop')) ? $value[0] : 0), "Phone" => (($value = file($stats_analytics_devices_folder . 'total/Phone')) ? $value[0] : 0),"Tablet" => (($value = file($stats_analytics_devices_folder . 'total/Tablet')) ? $value[0] : 0),"Server" => (($value = file($stats_analytics_devices_folder . 'total/Server')) ? $value[0] : 0),"Other" => (($value = file($stats_analytics_devices_folder . 'total/Other')) ? $value[0] : 0),"Unknown Device" => (($value = file($stats_analytics_devices_folder . 'total/Unknown Device')) ? $value[0] : 0));
	
	
	foreach($total_devices as $key => $pagefile)
	{
		$total_devices[$key] = 0;	
	}
	
	//print_r($total_browsers);
	$to = $_GET['to'];
	$to = date("Ymd", $to);
	
	$count = 0;
	
	if($_GET['from'] == "now")
	{
		$now = date("Ymd");
		$nowTime = time();
	}
	else
	{
		$now = date("Ymd", $_GET['from']);
		$nowTime = $_GET['from'];
		//echo $now;
	}
	
	while($to < $now)
	{
		$label = date("d/m/Y", strtotime("-$count days", $nowTime));
		$now = date("Ymd", strtotime("-$count days", $nowTime));
		$count++;
		foreach($total_devices as $key => $pagefile)
		{
			
			$value = file($stats_analytics_devices_folder.$now."/".$key);
			#echo $value[0];
			$total_devices[$key] += $value[0];
		}

	}
/*
	foreach($total_devices as $key => $pagefile)
	{
		
		$value = file($stats_analytics_devices_folder.$to."/".$key);
		//echo $value[0];
		$total_devices[$key] += $value[0];
	}
*/
	$total_devices = array_values($total_devices);	
	
	
	
	// Oss analytics
	
	
	$total_oss = array("Windows" => (($value = file($stats_analytics_oss_folder . 'total/Windows')) ? $value[0] : 0),"Mac OS" => (($value = file($stats_analytics_oss_folder . 'total/Mac OS')) ? $value[0] : 0),"Linux" => (($value = file($stats_analytics_oss_folder . 'total/Linux')) ? $value[0] : 0), "iOS" => (($value = file($stats_analytics_oss_folder . 'total/iOS')) ? $value[0] : 0), "Android" => (($value = file($stats_analytics_oss_folder. 'total/Android')) ? $value[0] : 0), "Unknown OS" => (($value = file($stats_analytics_oss_folder . 'total/Unknown OS')) ? $value[0] : 0));
	

	foreach($total_oss as $key => $pagefile)
	{
		$total_oss[$key] = 0;	
	}
	
	//print_r($total_browsers);
	$to = $_GET['to'];
	$to = date("Ymd", $to);
	
	$count = 0;
	
	if($_GET['from'] == "now")
	{
		$now = date("Ymd");
		$nowTime = time();
	}
	else
	{
		$now = date("Ymd", $_GET['from']);
		$nowTime = $_GET['from'];
		//echo $now;
	}
	
	while($to < $now)
	{
		$label = date("d/m/Y", strtotime("-$count days", $nowTime));
		$now = date("Ymd", strtotime("-$count days", $nowTime));
		$count++;
		foreach($total_oss as $key => $pagefile)
		{
			
			$value = file($stats_analytics_oss_folder.$now."/".$key);
			//echo $value[0];
			$total_oss[$key] += $value[0];
		}
	}
	$total_oss = array_values($total_oss);
	
	
	// Browsers analytics
	
	
	$total_browsers = array("Chrome" => (($value = file($stats_analytics_browsers_folder . 'total/Chrome')) ? $value[0] : 0), "Firefox" => (($value = file($stats_analytics_browsers_folder . 'total/Firefox')) ? $value[0] : 0), "Safari" => (($value = file($stats_analytics_browsers_folder . 'total/Safari')) ? $value[0] : 0), "Internet Explorer" => (($value = file($stats_analytics_browsers_folder . 'total/Internet Explorer')) ? $value[0] : 0), "Mobile" => (($value = file($stats_analytics_browsers_folder . 'total/Mobile')) ? $value[0] : 0), "Opera" => (($value = file($stats_analytics_browsers_folder . 'total/Opera')) ? $value[0] : 0), "Edge" => (($value = file($stats_analytics_browsers_folder . 'total/Edge')) ? $value[0] : 0), "Unknown Browser" => (($value = file($stats_analytics_browsers_folder . 'total/Unknown Browser')) ? $value[0] : 0));
	
	foreach($total_browsers as $key => $pagefile)
	{
		$total_browsers[$key] = 0;	
	}
	
	//print_r($total_browsers);
	$to = $_GET['to'];
	$to = date("Ymd", $to);
	
	$count = 0;
	
	if($_GET['from'] == "now")
	{
		$now = date("Ymd");
		$nowTime = time();
	}
	else
	{
		$now = date("Ymd", $_GET['from']);
		$nowTime = $_GET['from'];
		//echo $now;
	}
	
	while($to < $now)
	{
		$label = date("d/m/Y", strtotime("-$count days", $nowTime));
		$now = date("Ymd", strtotime("-$count days", $nowTime));
		$count++;
		foreach($total_browsers as $key => $pagefile)
		{
			
			$value = file($stats_analytics_browsers_folder.$now."/".$key);
			//echo $value[0];
			$total_browsers[$key] += $value[0];
		}
	}
	$total_browsers = array_values($total_browsers);
	//print_r($total_browsers);
	
	
	$most_popular_browser = "Aucun";
	
	if (($total_browsers[0] > $total_browsers[1]) && ($total_browsers[0] > $total_browsers[2]) && ($total_browsers[0] > $total_browsers[3]) && ($total_browsers[0] > $total_browsers[4]))
	{
		$most_popular_browser = "Chrome";
	}
	if (($total_browsers[1] > $total_browsers[0]) && ($total_browsers[1] > $total_browsers[2]) && ($total_browsers[1] > $total_browsers[3]) && ($total_browsers[1] > $total_browsers[4]))
	{
		$most_popular_browser = "Firefox";
	}
	if (($total_browsers[2] > $total_browsers[0]) && ($total_browsers[2] > $total_browsers[1]) && ($total_browsers[2] > $total_browsers[3]) && ($total_browsers[2] > $total_browsers[4]))
	{
		$most_popular_browser = "Safari";
	}
	if (($total_browsers[3] > $total_browsers[0]) && ($total_browsers[3] > $total_browsers[1]) && ($total_browsers[3] > $total_browsers[2]) && ($total_browsers[3] > $total_browsers[4]))
	{
		$most_popular_browser = "Internet Explorer";
	}
	if (($total_browsers[4] > $total_browsers[0]) && ($total_browsers[4] > $total_browsers[1]) && ($total_browsers[4] > $total_browsers[2]) && ($total_browsers[4] > $total_browsers[3]))
	{
		$most_popular_browser = "Mobile";
	}
	
	
	
	// Main analytics
	
	$seven_days_visitors = $visitors[0] + $visitors[1] + $visitors[2] + $visitors[3] + $visitors[4] + $visitors[5] + $visitors[6];
	$seven_days_pageviews = $pageviews[0] + $pageviews[1] + $pageviews[2] + $pageviews[3] + $pageviews[4] + $pageviews[5] + $pageviews[6];
	
/*
	$thirty_days_visitors = $visitors[0] + $visitors[1] + $visitors[2] + $visitors[3] + $visitors[4] + $visitors[5] + $visitors[6] + $visitors[7] + $visitors[8] + $visitors[9] + $visitors[10] + $visitors[11] + $visitors[12] + $visitors[13] + $visitors[14] + $visitors[15] + $visitors[16] + $visitors[17] + $visitors[18] + $visitors[19] + $visitors[20] + $visitors[21] + $visitors[22] + $visitors[23] + $visitors[24] + $visitors[25] + $visitors[26] + $visitors[27] + $visitors[28] + $visitors[29];
	$thirty_days_pageviews = $pageviews[0] + $pageviews[1] + $pageviews[2] + $pageviews[3] + $pageviews[4] + $pageviews[5] + $pageviews[6] + $pageviews[7] + $pageviews[8] + $pageviews[9] + $pageviews[10] + $pageviews[11] + $pageviews[12] + $pageviews[13] + $pageviews[14] + $pageviews[15] + $pageviews[16] + $pageviews[17] + $pageviews[18] + $pageviews[19] + $pageviews[20] + $pageviews[21] + $pageviews[22] + $pageviews[23] + $pageviews[24] + $pageviews[25] + $pageviews[26] + $pageviews[27] + $pageviews[28] + $pageviews[29];
*/
	
	$total_visitors = ($value = file($stats_analytics_visitors_folder . 'total')) ? $value[0] : 0;
	$total_visitors_unique = count(scandir($stats_analytics_visitors_ip_folder . 'total'))-2;
	if($total_visitors_unique == -1){$total_visitors_unique = 0;};
	$total_pageviews = ($value = file($stats_analytics_pageviews_folder . 'total')) ? $value[0] : 0;
	
	$desktop_visitor_count = ($value = file($stats_analytics_devices_total_folder . 'desktop')) ? $value[0] : 0;
	$mobile_visitor_count = ($value = file($stats_analytics_devices_total_folder . 'mobile')) ? $value[0] : 0;
	
	$desktop_visitor_percentage = round((($desktop_visitor_count/($desktop_visitor_count + $mobile_visitor_count))*100));
	$mobile_visitor_percentage = 100-$desktop_visitor_percentage;
	
	
	$windows_percentage = round(($total_oss[0]/$total_visitors)*100); 
	$macos_percentage = round(($total_oss[1]/$total_visitors)*100);
	$linux_percentage = round(($total_oss[2]/$total_visitors)*100);
	$ios_percentage = round(($total_oss[3]/$total_visitors)*100);
	$android_percentage = round(($total_oss[4]/$total_visitors)*100);
	
	
	
	$internetexplorer_percentage = round(($total_browsers[0]/$total_visitors)*100);
	$firefox_percentage = round(($total_browsers[1]/$total_visitors)*100);
	$safari_percentage = round(($total_browsers[2]/$total_visitors)*100);
	$chrome_percentage = round(($total_browsers[3]/$total_visitors)*100);
	$mobile_percentage = round(($total_browsers[4]/$total_visitors)*100);
	
	
	
	
	// time total
	
	$dossierTime = "analytics/time/";
	$dossierTime = scandir($dossierTime);
	$totalTime = 0;
	
	foreach($dossierTime as $key => $pageTime)
	{
		
// 		echo $pageTime;
		if($pageTime != "." AND $pageTime != "..")
		{
			//echo $dossierTime[$key].$pageTime;
			$content = file_get_contents("analytics/time/".$pageTime);
			//echo $content;
			$totalTime = $totalTime + intval($content);
		}
	}
	
	$tempsParPage = number_format(($totalTime/$total_pageviews), 2);


	if($tempsParPage > 60)
	{
		$minute = floor($tempsParPage/60);
		$seconds = $tempsParPage - ($minute*60);
		$seconds = number_format($seconds, 0);
		if($seconds < 10)
		{
		
			$seconds = "0".$seconds;
		}
		$tempsParPage = $minute.":".$seconds." min";
	}
	else
	{
		$tempsParPage = $tempsParPage." sec";
	}
		//echo $totalTime;
	$totalTime = number_format($totalTime/($total_visitors), 2);
	
	if($totalTime > 60)
	{
		$minute = floor($totalTime/60);
		$seconds = $totalTime - ($minute*60);
		$seconds = number_format($seconds, 0);
		if($seconds < 10)
		{
			
			$seconds = "0".$seconds;
		}
		$totalTime = $minute.":".$seconds." min";
	}
	else
	{
		$totalTime = $totalTime." sec";
	}
	
	
	$bounceRateHelp = "Le taux de rebond est un outil qui permet de mesurer le pourcentage d'internautes qui sont entrés sur une page Web et qui ont quitté le site après, sans consulter d'autres pages.\n

Un taux de rebond élevé peut révéler l'insatisfaction des visiteurs due à un mauvais ciblage, un contenu de mauvaise qualité, une mise en page étouffante. Il peut cependant aussi indiquer que ceux-ci ont trouvé immédiatement ce qu'ils cherchaient.";
	
	// Add Analytics to content
	
	// Main analytics
	
	$analytics_content .= "
<div class=\"content_headline\" style=\"margin-bottom:30px; color:#2b4059; margin-top: 30px;\">Analyse de votre trafic en bref<br/><span style=\"font-size: 12px\">Globalement</span></div>
							<div class=\"content_wrapper white\">
							
    							<div class=\"main_analytics_item\">
									<div class=\"main_analytics_item_headline\">Visiteurs<br>Total</div>
									<div class=\"main_analytics_item_value\">" . $total_visitors . "</div>
								</div>
								<div class=\"main_analytics_item\">
									<div class=\"main_analytics_item_headline\">Visiteurs <br>uniques</div>
									<div class=\"main_analytics_item_value\">" . $total_visitors_unique . "</div>
								</div>
								<div class=\"main_analytics_item\">
									<div class=\"main_analytics_item_headline\">Pages vues<br>Total</div>
									<div class=\"main_analytics_item_value\">" . $total_pageviews . "</div>
								</div>
								<div class=\"main_analytics_item\">
									<div class=\"main_analytics_item_headline\">Taux de <div class='help' explication=\"".$bounceRateHelp."\">?</div><br>rebond</div>
									<div class=\"main_analytics_item_value\">" . number_format(($total_visitors/$total_pageviews)*100, 0) . "%</div>
								</div>
								<div class=\"main_analytics_item\">
									<div class=\"main_analytics_item_headline\">Ordinateur</div>
									<div class=\"main_analytics_item_value\">" . $desktop_visitor_percentage . "%</div>
								</div>
								<div class=\"main_analytics_item\">
									<div class=\"main_analytics_item_headline\">Mobiles</div>
									<div class=\"main_analytics_item_value\">" . $mobile_visitor_percentage . "%</div>
								</div>
								<div class=\"main_analytics_item\">
									<div class=\"main_analytics_item_headline\">Temps par<br>page</div>
									<div class=\"main_analytics_item_value\">&plusmn; " . $tempsParPage . "</div>
								</div>
								<div class=\"main_analytics_item\">
									<div class=\"main_analytics_item_headline\">Temps par<br>session</div>
									<div class=\"main_analytics_item_value\">&plusmn; " . $totalTime . "</div>
								</div>
								<div class=\"main_analytics_item\">
									<div class=\"main_analytics_item_headline\">Pays le plus<br>Courant</div>
									<div class=\"main_analytics_item_value\">" . $total_countries_country[0] . "</div>
								</div>
								<div class=\"main_analytics_item\">
									<div class=\"main_analytics_item_headline\">Navigateur le <br> plus Courant</div>
									<div class=\"main_analytics_item_value\">" . $most_popular_browser . "</div>
								</div>
							</div>
	";
	
	
	if(isset($_GET['embed']))
	{
		exit($analytics_content);
	}
	// Realtime analytics
	
	$analytics_content .= "<iframe id=\"realtime_content\" src=\"realtime/admin.php\" style=\"position:relative; left:0; top:0; width:100%; height:600px; overflow:hidden; border:none; outline:none; box-sizing:border-box;\" width=\"100%\" height=\"600px\" scrolling=\"no\"></iframe>";
	
	
	
	// Visitor analytics
	$moyenne = 0;
	$displayByDay = "par jour";
	if($_GET['displayBy'] == "month")
	{
		$displayByDay = "par mois";
	}
	$moyenneTab = explode(",",$valueGraphVisitors);
	foreach($moyenneTab as $visitorCountForToday)
	{
		$moyenne += $visitorCountForToday;
	}
	#$moyenne = 1000000;
	$fontSize = "100";
	if($moyenne > 999)
	{
		$fontSize = "50";	
	}
	
	
	$moyenne = "<div style='line-height: ".($fontSize/2)."px; position: absolute; left: 50px; top: 50px; width: 30% !important; display: inline-block !important;'>".round($moyenne/(count($moyenneTab)))."<div style='font-size: 15px'>visiteurs ".$displayByDay."</div></div>";
	
	#$analytics_content .= ;
	$divMoyenne = "<div style='margin-bottom: 0px; font-family: open sans, sans serif; color: #ececec; font-size: ".$fontSize."px; font-weight: bold'>".$moyenne."</div>";
	
	$analytics_content .= "
    						<div class=\"content_wrapper white\" style=\"padding:0; height:600px; position: relative\">
    							<div class=\"content_headline\" style=\"margin-bottom:40px; color:#2b4059;\">Visiteurs et nombre de pages vues<br/><span style=\"font-size: 12px\">".$title."</span><br/></div><div id='buttonDate'>".$displayButton."</div>$divMoyenne
    							<div class=\"sub_analytics_holder\">
    								<div class=\"sub_analytics_item\">
    									<div class=\"sub_analytics_item_headline\">Visiteurs<br>$labelVisitorFromToday</div>
    									<div class=\"sub_analytics_item_value\">" . end($visitors) . "</div>
    								</div>
    								<div class=\"sub_analytics_item\">
    									<div class=\"sub_analytics_item_headline\">Visiteurs<br>".$labelVisitorFromTo."</div>
    									<div class=\"sub_analytics_item_value\">" . $thirty_days_visitors . "</div>
    								</div>
    								<div class=\"sub_analytics_item\">
    									<div class=\"sub_analytics_item_headline\">Visiteurs<br>Total</div>
    									<div class=\"sub_analytics_item_value\">" . $total_visitors . "</div>
    								</div>
    								<div class=\"sub_analytics_item\">
    									<div class=\"sub_analytics_item_headline\">Pages vues <br>$labelVisitorFromToday</div>
    									<div class=\"sub_analytics_item_value\">" . end($pageviews) . "</div>
    								</div>
    								<div class=\"sub_analytics_item\">
    									<div class=\"sub_analytics_item_headline\">Pages vues<br>".$labelPageFromTo."</div>
    									<div class=\"sub_analytics_item_value\">" . $thirty_days_pageviews . "</div>
    								</div>
    								<div class=\"sub_analytics_item\">
    									<div class=\"sub_analytics_item_headline\">Pages vues<br>Total</div>
    									<div class=\"sub_analytics_item_value\">" . $total_pageviews . "</div>
    								</div>
    							</div>
    							<div class=\"chart_holder\" id=\"visitors_chart_holder\">
    								<canvas id=\"visitors_chart\" style=\"position:relative; float:left; width:100%; height:100%;\"></canvas>
    							</div>
    							<div class=\"chart_mesh\">
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    								</div>
    							</div>
    						</div>
    						
    						<script>
    						
	    					
								    
							    var dateLabel = new Array();
							    for(var i = 0; i < 31; i++)
							    {
								    var dat = new Date();
								    dat.setDate(dat.getDate() - i);
								    var mois = dat.getMonth()+1;
								    var jour = dat.getDate();
								    var annee = dat.getFullYear();	
								    if(jour < 10)
								    {
									    jour = '0'+jour;
									}
									if(mois < 10)
									{
										mois = '0'+mois;
									}					    
								    dateLabel.push(jour+'/'+mois);
								} 						
    						
    							var visitors_data = 
    							{
    								labels: [".$labelsGraphPageviews."],
    								datasets: 
    								[
    									{
          									backgroundColor: \"rgba(111, 183, 220, 0.2)\",
           									borderColor: \"rgba(111, 183, 220, 0.5)\",
           									pointBackgroundColor: \"rgba(111, 183, 220, 0.5)\",
           									pointBorderWidth: 2,
            								pointHighlightStroke: \"rgba(220,220,220,1)\",
            								pointHighlightFill: \"#fff\",
            								label: \"Pages vues\",
            								data: [".$valueGraphPageviews."]
        								},
        								{
          									backgroundColor: \"rgba(102,178,69,0.2)\",
           									borderColor: \"rgba(102, 178, 69, 0.5)\",
           									pointBackgroundColor: \"rgba(102, 178, 69, 0.5)\",
            								pointHighlightStroke: \"rgba(220,220,220,1)\",
            								pointBorderWidth: 2,
            								pointHighlightFill: \"#fff\",
            								label: \"Visiteurs\",
            								data: [".$valueGraphVisitors."]
        								}
  									]
								}
								
								document.getElementById('visitors_chart').width = document.getElementById('visitors_chart_holder').offsetWidth;
								document.getElementById('visitors_chart').height = document.getElementById('visitors_chart_holder').offsetHeight-70;
								
    							var visitors_chart = document.getElementById('visitors_chart').getContext('2d');
    							new Chart(visitors_chart, 
    								{
    									type: \"line\", 
    									data: visitors_data, 
    									
    									options:{
	    									
    										scaleLineColor: \"rgba(0,0,0,0)\", 
    										scaleShowGridLines : true, 
    										scaleShowLabels: true, 
    										scaleFontSize: 16, 
    										scales: {
												xAxes: [{
													display: false,
												}],
												yAxes: [{
													display: true,
														
												}]
											}
										}
									});
    						</script>
    
    ";

	
    
     
    
    
	
	
	// Pages analytics
	$buttonLast2Year = strtotime("-2 year", time());
	$buttonLast2Year = "<a href='#'>".date("Y", $buttonLast2Year)."</a>";
	
	$buttonLastYear = strtotime("-1 year", time());
	$buttonLastYear = "<a href='#'>".date("Y", $buttonLastYear)."</a>";
	
	#$analytics_content .= "<div style='padding: 15px; font-family: \"Open Sans\", sans-serif;' class='filter_last_category'>".$buttonLast2Year." ".$buttonLastYear."</div>";
	$analytics_content .= "
							<div class=\"content_container_up dark\" style=\"border-bottom:1px solid rgba(255,255,255,0.1);\">
							<div class=\"content_tripple_wrapper\">
    							<div class=\"darken\"></div>
    							<div class=\"content_headline\" style=\"margin:50px 0 30px 0;\">Pages</div>
    							<div class=\"content_inner_tripple_wrapper_inner\">
    								<div class=\"bar_chart_holder\">
    									<div class=\"bar_chart\">
    										<div class=\"bar_chart_bar\">
    											<div class=\"bar_chart_bar_value\" style=\"height:" . round(($total_pages_count[0]/$thirty_days_pageviews)*100) . "%;\"></div>
    										</div>
    									</div>
    									<div class=\"bar_chart\">
    										<div class=\"bar_chart_bar\">
    											<div class=\"bar_chart_bar_value\" style=\"height:" . round(($total_pages_count[1]/$thirty_days_pageviews)*100) . "%;\"></div>
    										</div>
    									</div>
    									<div class=\"bar_chart\">
    										<div class=\"bar_chart_bar\">
    											<div class=\"bar_chart_bar_value\" style=\"height:" . round(($total_pages_count[2]/$thirty_days_pageviews)*100) . "%;\"></div>
    										</div>
    									</div>
    									<div class=\"bar_chart\">
    										<div class=\"bar_chart_bar\">
    											<div class=\"bar_chart_bar_value\" style=\"height:" . round(($total_pages_count[3]/$thirty_days_pageviews)*100) . "%;\"></div>
    										</div>
    									</div>
    									<div class=\"bar_chart\">
    										<div class=\"bar_chart_bar\">
    											<div class=\"bar_chart_bar_value\" style=\"height:" . round(($total_pages_count[4]/$thirty_days_pageviews)*100) . "%;\"></div>
    										</div>
    									</div>
    									<div class=\"bar_chart\">
    										<div class=\"bar_chart_bar\">
    											<div class=\"bar_chart_bar_value\" style=\"height:" . round(($total_pages_count[5]/$thirty_days_pageviews)*100) . "%;\"></div>
    										</div>
    									</div>
    									<div class=\"bar_chart\">
    										<div class=\"bar_chart_bar\">
    											<div class=\"bar_chart_bar_value\" style=\"height:" . round(($total_pages_count[6]/$thirty_days_pageviews)*100) . "%;\"></div>
    										</div>
    									</div>
    									<div class=\"bar_chart\">
    										<div class=\"bar_chart_bar\">
    											<div class=\"bar_chart_bar_value\" style=\"height:" . round(($total_pages_count[7]/$thirty_days_pageviews)*100) . "%;\"></div>
    										</div>
    									</div>
    									<div class=\"bar_chart\">
    										<div class=\"bar_chart_bar\">
    											<div class=\"bar_chart_bar_value\" style=\"height:" . round(($total_pages_count[8]/$thirty_days_pageviews)*100) . "%;\"></div>
    										</div>
    									</div>
    									<div class=\"bar_chart\">
    										<div class=\"bar_chart_bar\">
    											<div class=\"bar_chart_bar_value\" style=\"height:" . round(($total_pages_count[9]/$thirty_days_pageviews)*100) . "%;\"></div>
    										</div>
    									</div>
    								</div>
    							</div>
    									<div class=\"content_inner_tripple_wrapper_inner\" style=\"min-height:0;\">
    										<div class=\"tripple_chart_item\">
    											<div class=\"tripple_chart_item_huge\">" . str_replace('_slash_', '/',$total_pages_page[0]) . "</div>
    											<div class=\"tripple_chart_item_small\">" . round(($total_pages_count[0]/$thirty_days_pageviews)*100) . "%</div>
    										</div>
    										<div class=\"tripple_chart_item\">
    											<div class=\"tripple_chart_item_huge\">" . str_replace('_slash_', '/',$total_pages_page[1]) . "</div>
    											<div class=\"tripple_chart_item_small\">" . round(($total_pages_count[1]/$thirty_days_pageviews)*100) . "%</div>
    										</div>
    										<div class=\"tripple_chart_item\">
    											<div class=\"tripple_chart_item_huge\">" . str_replace('_slash_', '/',$total_pages_page[2]) . "</div>
    											<div class=\"tripple_chart_item_small\">" . round(($total_pages_count[2]/$thirty_days_pageviews)*100) . "%</div>
    										</div>
    										<div class=\"tripple_chart_item\">
    											<div class=\"tripple_chart_item_huge\">" . str_replace('_slash_', '/',$total_pages_page[3]) . "</div>
    											<div class=\"tripple_chart_item_small\">" . round(($total_pages_count[3]/$thirty_days_pageviews)*100) . "%</div>
    										</div>
    										<div class=\"tripple_chart_item\">
    											<div class=\"tripple_chart_item_huge\">" . str_replace('_slash_', '/',$total_pages_page[4]) . "</div>
    											<div class=\"tripple_chart_item_small\">" . round(($total_pages_count[4]/$thirty_days_pageviews)*100) . "%</div>
    										</div>
    										<div class=\"tripple_chart_item\">
    											<div class=\"tripple_chart_item_huge\">" . str_replace('_slash_', '/',$total_pages_page[5]) . "</div>
    											<div class=\"tripple_chart_item_small\">" . round(($total_pages_count[5]/$thirty_days_pageviews)*100) . "%</div>
    										</div>
    										<div class=\"tripple_chart_item\">
    											<div class=\"tripple_chart_item_huge\">" . str_replace('_slash_', '/',$total_pages_page[6]) . "</div>
    											<div class=\"tripple_chart_item_small\">" . round(($total_pages_count[6]/$thirty_days_pageviews)*100) . "%</div>
    										</div>
    										<div class=\"tripple_chart_item\">
    											<div class=\"tripple_chart_item_huge\">" . str_replace('_slash_', '/',$total_pages_page[7]) . "</div>
    											<div class=\"tripple_chart_item_small\">" . round(($total_pages_count[7]/$thirty_days_pageviews)*100) . "%</div>
    										</div>    										
    										<div class=\"tripple_chart_item\">
    											<div class=\"tripple_chart_item_huge\">" . str_replace('_slash_', '/',$total_pages_page[8]) . "</div>
    											<div class=\"tripple_chart_item_small\">" . round(($total_pages_count[8]/$thirty_days_pageviews)*100) . "%</div>
    										</div>
    										<div class=\"tripple_chart_item\">
    											<div class=\"tripple_chart_item_huge\">" . str_replace('_slash_', '/',$total_pages_page[9]) . "</div>
    											<div class=\"tripple_chart_item_small\">" . round(($total_pages_count[9]/$thirty_days_pageviews)*100) . "%</div>
    										</div>
    									</div>
    						</div>
    ";
    
    
    
    
    
    
    
    
    
    
    // Pages analytics

	if($total_visitors - $totalReferrer > 0)
	{
		
		$difference = $total_visitors - $totalReferrer;
		//$difference = number_format(($difference/$total_visitors)*100, 0);
		foreach($total_referrers_referrer as $keys => $referrer)
		{
			#if($referrer == "Lien direct")
			#{
			#	$total_referrers_count[$keys] = intVal($total_referrers_count[$keys])+intVal($difference);
			#}
		}
	}


	$analytics_content .= "
    						<div style='padding-bottom: 15px; height: 486px' class=\"content_tripple_wrapper\">
    							<div class=\"darken\"></div>
    							<div class=\"content_headline\" style=\"margin:50px 0 30px 0;\">Provenance</div>
    							<div class=\"content_inner_tripple_wrapper_inner\">
    								<div class=\"bar_chart_holder\">
    									<div class=\"bar_chart\">
    										
    									</div>
    									<div class=\"bar_chart\">
    										
    									</div>
    									<div class=\"bar_chart\">
    										
    									</div>
    									<div class=\"bar_chart\">
    										<div class=\"bar_chart_bar\">
    											<div class=\"bar_chart_bar_value\" style=\"height:" . round(($total_referrers_count[0]/$totalReferrer)*100) . "%;\"></div>
    										</div>
    									</div>
    									<div class=\"bar_chart\">
    										<div class=\"bar_chart_bar\">
    											<div class=\"bar_chart_bar_value\" style=\"height:" . round(($total_referrers_count[1]/$totalReferrer)*100) . "%;\"></div>
    										</div>
    									</div>
    									<div class=\"bar_chart\">
    										<div class=\"bar_chart_bar\">
    											<div class=\"bar_chart_bar_value\" style=\"height:" . round(($total_referrers_count[2]/$totalReferrer)*100) . "%;\"></div>
    										</div>
    									</div>
    									<div class=\"bar_chart\">
    										<div class=\"bar_chart_bar\">
    											<div class=\"bar_chart_bar_value\" style=\"height:" . round(($total_referrers_count[3]/$totalReferrer)*100) . "%;\"></div>
    										</div>
    									</div>
    								</div>
    							</div>
    							
    									<div class=\"content_inner_tripple_wrapper_inner\" style=\"min-height:0;\">
    									
    									<div id='back'>< Retour</div>
    									<div id='referrersDeBase'>	
    										<div class=\"tripple_chart_item\">
    											<div class=\"tripple_chart_item_huge ".$linkIndex[0]."\">" . $total_referrers_referrer[0] . "</div>
    											<div class=\"tripple_chart_item_small\">" . round(($total_referrers_count[0]/$totalReferrer)*100) . "%</div>
    										</div>
    										<div class=\"tripple_chart_item\">
    											<div class=\"tripple_chart_item_huge ".$linkIndex[1]."\">" . $total_referrers_referrer[1] . "</div>
    											<div class=\"tripple_chart_item_small\">" . round(($total_referrers_count[1]/$totalReferrer)*100) . "%</div>
    										</div>
    										<div class=\"tripple_chart_item\">
    											<div class=\"tripple_chart_item_huge ".$linkIndex[2]."\">" . $total_referrers_referrer[2] . "</div>
    											<div class=\"tripple_chart_item_small\">" . round(($total_referrers_count[2]/$totalReferrer)*100) . "%</div>
    										</div>
    										<div class=\"tripple_chart_item\">
    											<div class=\"tripple_chart_item_huge ".$linkIndex[3]."\">" . $total_referrers_referrer[3] . "</div>
    											<div class=\"tripple_chart_item_small\">" . round(($total_referrers_count[3]/$totalReferrer)*100) . "%</div>
    										</div>
    										<div class=\"tripple_chart_item\">
    											<div class=\"tripple_chart_item_huge\"></div>
    											<div class=\"tripple_chart_item_small\"></div>
    										</div>
    										<div class=\"tripple_chart_item\">
    											<div class=\"tripple_chart_item_huge\"></div>
    											<div class=\"tripple_chart_item_small\"></div>
    										</div>
    										<div class=\"tripple_chart_item\">
    											<div class=\"tripple_chart_item_huge\"></div>
    											<div class=\"tripple_chart_item_small\"></div>
    										</div>
    										<div class=\"tripple_chart_item\">
    											<div class=\"tripple_chart_item_huge\"></div>
    											<div class=\"tripple_chart_item_small\"></div>
    										</div>
    										<div class=\"tripple_chart_item\">
    											<div class=\"tripple_chart_item_huge\"></div>
    											<div class=\"tripple_chart_item_small\"></div>
    										</div>
    										<div class=\"tripple_chart_item\">
    											<div class=\"tripple_chart_item_huge\"></div>
    											<div class=\"tripple_chart_item_small\"></div>
    										</div>
    									</div>

    									</div>
    						</div>
    ";
    
    
    
    
    
    
    
     // Pages analytics
	
	$analytics_content .= "
    						<div class=\"content_tripple_wrapper\">
    							<div class=\"darken\"></div>
    							<div class=\"content_headline\" style=\"margin:50px 0 30px 0;\">Pays</div>
    							<div class=\"content_inner_tripple_wrapper_inner\">
    								<div class=\"bar_chart_holder\">
    									<div class=\"bar_chart\">
    										<div class=\"bar_chart_bar\">
    											<div class=\"bar_chart_bar_value\" style=\"height:" . round(($total_countries_count[0]/$thirty_days_visitors)*100) . "%;\"></div>
    										</div>
    									</div>
    									<div class=\"bar_chart\">
    										<div class=\"bar_chart_bar\">
    											<div class=\"bar_chart_bar_value\" style=\"height:" . round(($total_countries_count[1]/$thirty_days_visitors)*100) . "%;\"></div>
    										</div>
    									</div>
    									<div class=\"bar_chart\">
    										<div class=\"bar_chart_bar\">
    											<div class=\"bar_chart_bar_value\" style=\"height:" . round(($total_countries_count[2]/$thirty_days_visitors)*100) . "%;\"></div>
    										</div>
    									</div>
    									<div class=\"bar_chart\">
    										<div class=\"bar_chart_bar\">
    											<div class=\"bar_chart_bar_value\" style=\"height:" . round(($total_countries_count[3]/$thirty_days_visitors)*100) . "%;\"></div>
    										</div>
    									</div>
    									<div class=\"bar_chart\">
    										<div class=\"bar_chart_bar\">
    											<div class=\"bar_chart_bar_value\" style=\"height:" . round(($total_countries_count[4]/$thirty_days_visitors)*100) . "%;\"></div>
    										</div>
    									</div>
    									<div class=\"bar_chart\">
    										<div class=\"bar_chart_bar\">
    											<div class=\"bar_chart_bar_value\" style=\"height:" . round(($total_countries_count[5]/$thirty_days_visitors)*100) . "%;\"></div>
    										</div>
    									</div>
    									<div class=\"bar_chart\">
    										<div class=\"bar_chart_bar\">
    											<div class=\"bar_chart_bar_value\" style=\"height:" . round(($total_countries_count[6]/$thirty_days_visitors)*100) . "%;\"></div>
    										</div>
    									</div>
    									<div class=\"bar_chart\">
    										<div class=\"bar_chart_bar\">
    											<div class=\"bar_chart_bar_value\" style=\"height:" . round(($total_countries_count[7]/$thirty_days_visitors)*100) . "%;\"></div>
    										</div>
    									</div>
    									<div class=\"bar_chart\">
    										<div class=\"bar_chart_bar\">
    											<div class=\"bar_chart_bar_value\" style=\"height:" . round(($total_countries_count[8]/$thirty_days_visitors)*100) . "%;\"></div>
    										</div>
    									</div>
    									<div class=\"bar_chart\">
    										<div class=\"bar_chart_bar\">
    											<div class=\"bar_chart_bar_value\" style=\"height:" . round(($total_countries_count[9]/$thirty_days_visitors)*100) . "%;\"></div>
    										</div>
    									</div>
    								</div>
    							</div>
    							<div class=\"content_inner_tripple_wrapper_inner\" style=\"min-height:0;\">
    										<div class=\"tripple_chart_item\">
    											<div class=\"tripple_chart_item_huge\">" . $total_countries_country[0] . "</div>
    											<div class=\"tripple_chart_item_small\">" . round(($total_countries_count[0]/$thirty_days_visitors)*100) . "%</div>
    										</div>
    										<div class=\"tripple_chart_item\">
    											<div class=\"tripple_chart_item_huge\">" . $total_countries_country[1] . "</div>
    											<div class=\"tripple_chart_item_small\">" . round(($total_countries_count[1]/$thirty_days_visitors)*100) . "%</div>
    										</div>
    										<div class=\"tripple_chart_item\">
    											<div class=\"tripple_chart_item_huge\">" . $total_countries_country[2] . "</div>
    											<div class=\"tripple_chart_item_small\">" . round(($total_countries_count[2]/$thirty_days_visitors)*100) . "%</div>
    										</div>
    										<div class=\"tripple_chart_item\">
    											<div class=\"tripple_chart_item_huge\">" . $total_countries_country[3] . "</div>
    											<div class=\"tripple_chart_item_small\">" . round(($total_countries_count[3]/$thirty_days_visitors)*100) . "%</div>
    										</div>
    										<div class=\"tripple_chart_item\">
    											<div class=\"tripple_chart_item_huge\">" . $total_countries_country[4] . "</div>
    											<div class=\"tripple_chart_item_small\">" . round(($total_countries_count[4]/$thirty_days_visitors)*100) . "%</div>
    										</div>
    										<div class=\"tripple_chart_item\">
    											<div class=\"tripple_chart_item_huge\">" . $total_countries_country[5] . "</div>
    											<div class=\"tripple_chart_item_small\">" . round(($total_countries_count[5]/$thirty_days_visitors)*100) . "%</div>
    										</div>
    										<div class=\"tripple_chart_item\">
    											<div class=\"tripple_chart_item_huge\">" . $total_countries_country[6] . "</div>
    											<div class=\"tripple_chart_item_small\">" . round(($total_countries_count[6]/$thirty_days_visitors)*100) . "%</div>
    										</div>
    										<div class=\"tripple_chart_item\">
    											<div class=\"tripple_chart_item_huge\">" . $total_countries_country[7] . "</div>
    											<div class=\"tripple_chart_item_small\">" . round(($total_countries_count[7]/$thirty_days_visitors)*100) . "%</div>
    										</div>
    										<div class=\"tripple_chart_item\">
    											<div class=\"tripple_chart_item_huge\">" . $total_countries_country[8] . "</div>
    											<div class=\"tripple_chart_item_small\">" . round(($total_countries_count[8]/$thirty_days_visitors)*100) . "%</div>
    										</div>
    										<div class=\"tripple_chart_item\">
    											<div class=\"tripple_chart_item_huge\">" . $total_countries_country[9] . "</div>
    											<div class=\"tripple_chart_item_small\">" . round(($total_countries_count[9]/$thirty_days_visitors)*100) . "%</div>
    										</div>
    									</div>
    						</div>
    						</div>
    ";
    
	foreach($total_cities_country as $key => $city)
	{
		#echo $total_cities_count[$key];
		$analytics_content .= "<input class='city' type='hidden' value=\"$city\"/><input type='hidden' class='cityCount' value='".round(($total_cities_count[$key]/$thirty_days_visitors)*100,2)."'/>";
	}
	
	$analytics_content .= "<div id='map'></div>";
	
	
	
	// Devices analytics
	
	$analytics_content .= "
							<div class=\"content_container dark\">
    						<div class=\"content_tripple_wrapper\">
    							<div class=\"darken\"></div>
    							<div class=\"content_headline\">Appareils</div>
    							
    							<div class=\"content_inner_tripple_wrapper_inner\">
    								<div class=\"tripple_chart_holder\" id=\"devices_total_chart_holder\" style=\"top:20%; height:80%; margin-top:0;\">
    									<canvas id=\"devices_total_chart\" style=\"position:relative; float:left; width:100%; height:100%;\"></canvas>
    								</div>
    							</div>
    							<div class=\"content_inner_tripple_wrapper_inner\" style=\"min-height:0;\">
    								<div class=\"tripple_chart_item\" style=\"margin-top:35px;\">
    									<div class=\"tripple_chart_item_large\">" . "Ordinateur" . "</div>
    									<div class=\"tripple_chart_item_medium\">" . round(($total_devices[0]/$thirty_days_visitors)*100) . "%</div>
    								</div>
    								<div class=\"tripple_chart_item\">
    									<div class=\"tripple_chart_item_large\">" . "Smartphone" . "</div>
    									<div class=\"tripple_chart_item_medium\">" . round(($total_devices[1]/$thirty_days_visitors)*100) . "%</div>
    								</div>
    								<div class=\"tripple_chart_item\">
    									<div class=\"tripple_chart_item_large\">" . "Tablette" . "</div>
    									<div class=\"tripple_chart_item_medium\">" . round(($total_devices[2]/$thirty_days_visitors)*100) . "%</div>
    								</div>
    								<div class=\"tripple_chart_item\">
    									<div class=\"tripple_chart_item_large\">" . "Serveur" . "</div>
    									<div class=\"tripple_chart_item_medium\">" . round(($total_devices[3]/$thirty_days_visitors)*100) . "%</div>
    								</div>
    								<div class=\"tripple_chart_item\">
    									<div class=\"tripple_chart_item_large\">" . "Autre" . "</div>
    									<div class=\"tripple_chart_item_medium\">" . round(($total_devices[4]/$thirty_days_visitors)*100) . "%</div>
    								</div>
    								<div class=\"tripple_chart_item\">
    									<div class=\"tripple_chart_item_large\">Inconnus</div>
    									<div class=\"tripple_chart_item_medium\">".round(($total_devices[5]/$thirty_days_visitors)*100)."%</div>
    								</div>
    								<div class=\"tripple_chart_item\">
    									<div class=\"tripple_chart_item_large\"></div>
    									<div class=\"tripple_chart_item_medium\"></div>
    								</div>
    								<div class=\"tripple_chart_item\">
    									<div class=\"tripple_chart_item_large\"></div>
    									<div class=\"tripple_chart_item_medium\"></div>
    								</div>
    							</div>
    						</div>
    						
    						<script>
    							
    							
  								var devices_total_data = 
    							[
    								{
        								value:" . $total_devices[0] . ",
        								color:\"rgba(255,255,255,1)\",
        								label: 'Ordinateur'
    								},
    								{
        								value:" . $total_devices[1] . ",
        								color:\"rgba(255,255,255,0.8)\",
        								label: 'Smartphone'
    								},
    								{
        								value:" . $total_devices[2] . ",
        								color:\"rgba(255,255,255,0.6)\",
        								label: 'Tablette'
    								},
    								{
        								value:" . $total_devices[3] . ",
        								color:\"rgba(255,255,255,0.4)\",
        								label: 'Serveur'
    								},
    								{
        								value:" . $total_devices[4] . ",
        								color:\"rgba(255,255,255,0.2)\",
        								label: 'Autre'
    								}
  								]
  								
  								var devices_total_data = 
	  							{
		  							labels: 
		  							[
			  							'Ordinateur',
			  							'Smartphone',
			  							'Tablette',
			  							'Serveur',
			  							'Autre'
			  						],
			  						datasets:
			  						[{
				  						data:[".$total_devices[0].",".$total_devices[1].",".$total_devices[2].",".$total_devices[3].",".$total_devices[4]."],
				  						backgroundColor:
				  						[
					  						\"rgba(255,255,255,1)\",
					  						\"rgba(255,255,255,0.8)\",
					  						\"rgba(255,255,255,0.6)\",
					  						\"rgba(255,255,255,0.4)\",
					  						\"rgba(255,255,255,0.2)\"
				  						]
				  						
			  						}]
	  							}
  								
								
							
    							document.getElementById('devices_total_chart').width = document.getElementById('devices_total_chart_holder').offsetWidth;
								document.getElementById('devices_total_chart').height = document.getElementById('devices_total_chart_holder').offsetHeight;
								
    							var devices_total_chart = document.getElementById('devices_total_chart').getContext('2d');
    							new Chart(devices_total_chart, {
    								type: \"doughnut\",
    								data: devices_total_data,
    								options:
    								{
								         legend: {
								            display: false
								         },
								         tooltips: {
								            enabled: true
								         }
	    							}	
    							});
    							
    							
    						
    						</script>
    
    ";
	
	
	
	
	// OS analytics
	$analytics_content .= "
    						<div class=\"content_tripple_wrapper\">
    							<div class=\"darken\"></div>
    							<div class=\"content_headline\">Systèmes</div>
    							
    							<div class=\"content_inner_tripple_wrapper_inner\">
    								<div class=\"tripple_chart_holder\" id=\"oss_total_chart_holder\" style=\"top:20%; height:80%; margin-top:0;\">
    									<canvas id=\"oss_total_chart\" style=\"position:relative; float:left; width:100%; height:100%;\"></canvas>
    								</div>
    							</div>
    							<div class=\"content_inner_tripple_wrapper_inner\" style=\"min-height:0;\">
    								<div class=\"tripple_chart_item\" style=\"margin-top:35px;\">
    									<div class=\"tripple_chart_item_large\">" . "Windows" . "</div>
    									<div class=\"tripple_chart_item_medium\">" . round(($total_oss[0]/$thirty_days_visitors)*100) . "%</div>
    								</div>
    								<div class=\"tripple_chart_item\">
    									<div class=\"tripple_chart_item_large\">" . "Mac OS" . "</div>
    									<div class=\"tripple_chart_item_medium\">" . round(($total_oss[1]/$thirty_days_visitors)*100) . "%</div>
    								</div>
    								<div class=\"tripple_chart_item\">
    									<div class=\"tripple_chart_item_large\">" . "Linux" . "</div>
    									<div class=\"tripple_chart_item_medium\">" . round(($total_oss[2]/$thirty_days_visitors)*100) . "%</div>
    								</div>
    								<div class=\"tripple_chart_item\">
    									<div class=\"tripple_chart_item_large\">" . "iOS" . "</div>
    									<div class=\"tripple_chart_item_medium\">" . round(($total_oss[3]/$thirty_days_visitors)*100) . "%</div>
    								</div>
    								<div class=\"tripple_chart_item\">
    									<div class=\"tripple_chart_item_large\">" . "Android" . "</div>
    									<div class=\"tripple_chart_item_medium\">" . round(($total_oss[4]/$thirty_days_visitors)*100) . "%</div>
    								</div>
    								<div class=\"tripple_chart_item\">
    									<div class=\"tripple_chart_item_large\">Inconnus</div>
    									<div class=\"tripple_chart_item_medium\">".round(($total_oss[5]/$thirty_days_visitors)*100)."%</div>
    								</div>
    								<div class=\"tripple_chart_item\">
    									<div class=\"tripple_chart_item_large\"></div>
    									<div class=\"tripple_chart_item_medium\"></div>
    								</div>
    								<div class=\"tripple_chart_item\">
    									<div class=\"tripple_chart_item_large\"></div>
    									<div class=\"tripple_chart_item_medium\"></div>
    								</div>
    							</div>
    						</div>
    						
    						<script>
    						
    							
  								var oss_total_data = 
    							[
    								{
        								value:" . $total_oss[0] . ",
        								color:\"rgba(255,255,255,1)\",
        								label: 'Windows'
    								},
    								{
        								value:" . $total_oss[1] . ",
        								color:\"rgba(255,255,255,0.8)\",
        								label: 'Mac OS'
    								},
    								{
        								value:" . $total_oss[2] . ",
        								color:\"rgba(255,255,255,0.6)\",
        								label: 'Linux'
    								},
    								{
        								value:" . $total_oss[3] . ",
        								color:\"rgba(255,255,255,0.4)\",
        								label: 'iOS'
    								},
    								{
        								value:" . $total_oss[4] . ",
        								color:\"rgba(255,255,255,0.2)\",
        								label: 'Android'
    								}
  								]
  								
  								var oss_total_data = 
  								{
		  							labels: 
		  							[
			  							'Windows',
			  							'Mac OS',
			  							'Linux',
			  							'iOS',
			  							'Android'
			  						],
			  						datasets:
			  						[{
				  						data:[".$total_oss[0].",".$total_oss[1].",".$total_oss[2].",".$total_oss[3].",".$total_oss[4]."],
				  						backgroundColor:
				  						[
					  						\"rgba(255,255,255,1)\",
					  						\"rgba(255,255,255,0.8)\",
					  						\"rgba(255,255,255,0.6)\",
					  						\"rgba(255,255,255,0.4)\",
					  						\"rgba(255,255,255,0.2)\"
				  						]
				  						
			  						}]  								
  								}
								
								document.getElementById('oss_total_chart').width = document.getElementById('oss_total_chart_holder').offsetWidth;
								document.getElementById('oss_total_chart').height = document.getElementById('oss_total_chart_holder').offsetHeight;
								
    							var oss_total_chart = document.getElementById('oss_total_chart').getContext('2d');
    							new Chart(oss_total_chart, {
    								type: \"doughnut\",
    								data: oss_total_data,
    								options:
    								{
								         legend: {
								            display: false
								         },
								         tooltips: {
								            enabled: true
								         }
	    							}	
    							
    							});
    						</script>
    
    ";
    
    
    
    
    
    
	
	
	
	// Browsers analytics
	
	$analytics_content .= "
    						<div class=\"content_tripple_wrapper\">
    							<div class=\"darken\"></div>
    							<div class=\"content_headline\">Navigateurs</div>
    							
    							
    							<div class=\"content_inner_tripple_wrapper_inner\">
    								<div class=\"tripple_chart_holder\" id=\"browsers_total_chart_holder\" style=\"top:20%; height:80%; margin-top:0;\">
    									<canvas id=\"browsers_total_chart\" style=\"position:relative; float:left; width:100%; height:100%;\"></canvas>
    								</div>
    							</div>
    							<div class=\"content_inner_tripple_wrapper_inner\" style=\"min-height:0;\">
    								<div class=\"tripple_chart_item\" style=\"margin-top:35px;\">
    									<div class=\"tripple_chart_item_large\">" . "Chrome" . "</div>
    									<div class=\"tripple_chart_item_medium\">" . round(($total_browsers[0]/$thirty_days_visitors)*100) . "%</div>
    								</div>
    								<div class=\"tripple_chart_item\">
    									<div class=\"tripple_chart_item_large\">" . "Firefox" . "</div>
    									<div class=\"tripple_chart_item_medium\">" . round(($total_browsers[1]/$thirty_days_visitors)*100) . "%</div>
    								</div>
    								<div class=\"tripple_chart_item\">
    									<div class=\"tripple_chart_item_large\">" . "Safari" . "</div>
    									<div class=\"tripple_chart_item_medium\">" . round(($total_browsers[2]/$thirty_days_visitors)*100) . "%</div>
    								</div>
    								<div class=\"tripple_chart_item\">
    									<div class=\"tripple_chart_item_large\">" . "Internet Explorer" . "</div>
    									<div class=\"tripple_chart_item_medium\">" . round(($total_browsers[3]/$thirty_days_visitors)*100) . "%</div>
    								</div>
    								<div class=\"tripple_chart_item\">
    									<div class=\"tripple_chart_item_large\">" . "Opera" . "</div>
    									<div class=\"tripple_chart_item_medium\">" . round(($total_browsers[5]/$thirty_days_visitors)*100) . "%</div>
    								</div>
    								<div class=\"tripple_chart_item\">
    									<div class=\"tripple_chart_item_large\">" . "Edge" . "</div>
    									<div class=\"tripple_chart_item_medium\">" . round(($total_browsers[6]/$thirty_days_visitors)*100) . "%</div>
    								</div>
    								<div class=\"tripple_chart_item\">
    									<div class=\"tripple_chart_item_large\">" . "Mobile" . "</div>
    									<div class=\"tripple_chart_item_medium\">" . round(($total_browsers[4]/$thirty_days_visitors)*100) . "%</div>
    								</div>
    								<div class=\"tripple_chart_item\">
    									<div class=\"tripple_chart_item_large\">" . "Inconnus" . "</div>
    									<div class=\"tripple_chart_item_medium\">" . round(($total_browsers[7]/$thirty_days_visitors)*100) . "%</div>
    								</div>
    							</div>
    						</div>
    						
    						<script>
    						
    							
  								var browsers_total_data = 
    							[
    								{
        								value:" . $total_browsers[0] . ",
        								color:\"rgba(255,255,255,1)\",
        								label: 'Chrome'
    								},
    								{
        								value:" . $total_browsers[1] . ",
        								color:\"rgba(255,255,255,0.8)\",
        								label: 'Firefox'
    								},
    								{
        								value:" . $total_browsers[2] . ",
        								color:\"rgba(255,255,255,0.6)\",
        								label: 'Safari'
    								},
    								{
        								value:" . $total_browsers[3] . ",
        								color:\"rgba(255,255,255,0.4)\",
        								label: 'Internet Explorer'
    								},
    								{
        								value:" . $total_browsers[4] . ",
        								color:\"rgba(255,255,255,0.2)\",
        								label: 'Mobile'
    								},
    								{
        								value:" . $total_browsers[5] . ",
        								color:\"rgba(255,255,255,0.9)\",
        								label: 'Opera'
    								},
    								{
        								value:" . $total_browsers[6] . ",
        								color:\"rgba(255,255,255,0.5)\",
        								label: 'Edge'
    								}
  								]
  								
  								var browsers_total_data = 
  								{
		  							labels: 
		  							[
			  							'Chrome',
			  							'Firefox',
			  							'Safari',
			  							'I.E.',
			  							'Mobile',
			  							'Opera',
			  							'Edge'
			  						],
			  						datasets:
			  						[{
				  						data:[".$total_browsers[0].",".$total_browsers[1].",".$total_browsers[2].",".$total_browsers[3].",".$total_browsers[4].",".$total_browsers[5].",".$total_browsers[6]."],
				  						backgroundColor:
				  						[
					  						\"rgba(255,255,255,1)\",
					  						\"rgba(255,255,255,0.8)\",
					  						\"rgba(255,255,255,0.6)\",
					  						\"rgba(255,255,255,0.4)\",
					  						\"rgba(255,255,255,0.2)\",
					  						\"rgba(255,255,255,0.9)\",
					  						\"rgba(255,255,255,0.5)\"
				  						]
				  						
			  						}]  								
  								}
								
								document.getElementById('browsers_total_chart').width = document.getElementById('browsers_total_chart_holder').offsetWidth;
								document.getElementById('browsers_total_chart').height = document.getElementById('browsers_total_chart_holder').offsetHeight;
								
    							var browsers_total_chart = document.getElementById('browsers_total_chart').getContext('2d');
    							new Chart(browsers_total_chart, {
    								type: \"doughnut\",
    								data: browsers_total_data,
									options:
    								{
								         legend: {
								            display: false
								         },
								         tooltips: {
								            enabled: true
								         }
	    							}
    							});
    							
    							
    							
    							
    							
    						</script>
    					
    ";
    
    
    	// language analytics
    	
    	foreach($total_lang as $keys => $lang)
    	{
	    	$total_lang_sort[] = $lang;
	    	$total_lang_count_sort += $lang;
	    	$total_lang_label_sort[] = $keys;
	    	
    	}
    	$total_lang = $total_lang_sort;
    	$total_lang_count = $total_lang_count_sort;
		$total_lang_label = $total_lang_label_sort;
		
		if(!isset($total_lang[0])) $total_lang[0] = "0";
		if(!isset($total_lang[1])) $total_lang[1] = "0";
		if(!isset($total_lang[2])) $total_lang[2] = "0";
		if(!isset($total_lang[3])) $total_lang[3] = "0";
		if(!isset($total_lang[4])) $total_lang[4] = "0";
		if(!isset($total_lang[5])) $total_lang[5] = "0";
		if(!isset($total_lang[6])) $total_lang[6] = "0";
		if(!isset($total_lang[7])) $total_lang[7] = "0";
		if(!isset($total_lang[8])) $total_lang[8] = "0";
		if(!isset($total_lang[9])) $total_lang[9] = "0";
		
		foreach($total_lang_label as &$langue_label)
		{
			$langue_label = ucfirst(Locale::getDisplayLanguage($langue_label, 'fr'));
		}
		
		
	$analytics_content .= "
    						<div class=\"content_tripple_wrapper\">
    							<div class=\"darken\"></div>
    							<div class=\"content_headline\">Langues</div>
    							
    							
    							<div class=\"content_inner_tripple_wrapper_inner\">
    								<div class=\"tripple_chart_holder\" id=\"lang_total_chart_holder\" style=\"top:20%; height:80%; margin-top:0;\">
    									<canvas id=\"lang_total_chart\" style=\"position:relative; float:left; width:100%; height:100%;\"></canvas>
    								</div>
    							</div>
    							<div class=\"content_inner_tripple_wrapper_inner\" style=\"min-height:0;\">
    								<div class=\"tripple_chart_item\" style=\"margin-top:35px;\">
    									<div class=\"tripple_chart_item_large\">" . $total_lang_label[0] . "</div>
    									<div class=\"tripple_chart_item_medium\">" . round(($total_lang[0]/$total_lang_count)*100) . "%</div>
    								</div>
    								<div class=\"tripple_chart_item\">
    									<div class=\"tripple_chart_item_large\">" . $total_lang_label[1] . "</div>
    									<div class=\"tripple_chart_item_medium\">" . round(($total_lang[1]/$total_lang_count)*100) . "%</div>
    								</div>
    								<div class=\"tripple_chart_item\">
    									<div class=\"tripple_chart_item_large\">" . $total_lang_label[2] . "</div>
    									<div class=\"tripple_chart_item_medium\">" . round(($total_lang[2]/$total_lang_count)*100). "%</div>
    								</div>
    								<div class=\"tripple_chart_item\">
    									<div class=\"tripple_chart_item_large\">" . $total_lang_label[3] . "</div>
    									<div class=\"tripple_chart_item_medium\">" . round(($total_lang[3]/$total_lang_count)*100) . "%</div>
    								</div>
    								<div class=\"tripple_chart_item\">
    									<div class=\"tripple_chart_item_large\">" . $total_lang_label[4] . "</div>
    									<div class=\"tripple_chart_item_medium\">" . round(($total_lang[4]/$total_lang_count)*100) . "%</div>
    								</div>    								
    								<div class=\"tripple_chart_item\">
    									<div class=\"tripple_chart_item_large\">" . $total_lang_label[5] . "</div>
    									<div class=\"tripple_chart_item_medium\">" . round(($total_lang[5]/$total_lang_count)*100) . "%</div>
    								</div> 
    								<div class=\"tripple_chart_item\">
    									<div class=\"tripple_chart_item_large\">" . $total_lang_label[6] . "</div>
    									<div class=\"tripple_chart_item_medium\">" . round(($total_lang[6]/$total_lang_count)*100) . "%</div>
    								</div> 
    								<div class=\"tripple_chart_item\">
    									<div class=\"tripple_chart_item_large\">" . $total_lang_label[7] . "</div>
    									<div class=\"tripple_chart_item_medium\">" . round(($total_lang[7]/$total_lang_count)*100) . "%</div>
    								</div> 
    							</div>
    						</div>
    						
    						<script>
    						
    							
  								var lang_total_data = 
    							[
    								{
        								value:" . $total_lang[0] . ",
        								color:\"rgba(255,255,255,1)\",
        								label: '".$total_lang_label[0]."'
    								},
    								{
        								value:" . $total_lang[1] . ",
        								color:\"rgba(255,255,255,0.8)\",
        								label: '".$total_lang_label[1]."'
    								},
    								{
        								value:" . $total_lang[2] .",
        								color:\"rgba(255,255,255,0.6)\",
        								label: '".$total_lang_label[2]."'
    								},
    								{
        								value:" . $total_lang[3] . ",
        								color:\"rgba(255,255,255,0.4)\",
        								label: '".$total_lang_label[3]."'
    								},
    								{
        								value:" . $total_lang[4] . ",
        								color:\"rgba(255,255,255,0.2)\",
        								label: '".$total_lang_label[4]."'
    								}
  								]
  								
  								var lang_total_data = 
  								{
		  							labels: 
		  							[
			  							'".$total_lang_label[0]."',
			  							'".$total_lang_label[1]."',
			  							'".$total_lang_label[2]."',
			  							'".$total_lang_label[3]."',
			  							'".$total_lang_label[4]."'
			  						],
			  						datasets:
			  						[{
				  						data:[".$total_lang[0].",".$total_lang[1].",".$total_lang[2].",".$total_lang[3].",".$total_lang[4]."],
				  						backgroundColor:
				  						[
					  						\"rgba(255,255,255,1)\",
					  						\"rgba(255,255,255,0.8)\",
					  						\"rgba(255,255,255,0.6)\",
					  						\"rgba(255,255,255,0.4)\",
					  						\"rgba(255,255,255,0.2)\"
				  						]
				  						
			  						}]  								
  								}
								
								document.getElementById('lang_total_chart').width = document.getElementById('lang_total_chart_holder').offsetWidth;
								document.getElementById('lang_total_chart').height = document.getElementById('lang_total_chart_holder').offsetHeight;
								
    							var lang_total_chart = document.getElementById('lang_total_chart').getContext('2d');
    							new Chart(lang_total_chart, {
    								type: \"doughnut\",
									data: lang_total_data,
									options:
    								{
								         legend: {
								            display: false
								         },
								         tooltips: {
								            enabled: true
								         }
	    							}
    							});
    						</script>
    					</div>";	
	
	

	#echo $analytics_content;

	}
	if(isset($_GET['video']))
	{
		function db()
		{
			if(file_exists("../db.conf"))
			{
			// $dsn = "mysql:dbname=CMS;host=localhost;charset=utf8";
			// $login = "root";
			// $password = "y31TOGBRkc";
				$fichierParametre = file("../db.conf");
				foreach($fichierParametre as &$ligne)
				{
					$ligne = str_replace("\n", "", $ligne);
				}
				$db_name = $fichierParametre[0];
				$dsn = "mysql:dbname=".$fichierParametre[0].";host=".$fichierParametre[1].";charset=".$fichierParametre[2];
				$login = $fichierParametre[3];
				$password = $fichierParametre[4];
				try 
				{
		            $db = new PDO($dsn, $login, $password);
		            return $db;
		        }
		        catch(PDOException $e)
		        {
			        echo $e;
		        	echo "erreur de connexion à la base de donnée";
		        }
		    }
		}

		$db = db();


		//$db = new DB();
		$sqlVideo = "SELECT * FROM medias WHERE type = 'video' ORDER BY ID DESC";
		$reponseVideo = $db->query($sqlVideo);

		while($donneesVideo = $reponseVideo->fetch())
		{
			
			$url = $donneesVideo['url'];
			// if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
			//     $video_id = $match[1];
			// }
			// if(preg_match('%(?:dailymotion(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/video/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)){
			// 	$video_idDailymotion = $match[1];
			// 	echo $video_idDailymotion;
			// }

			$link = $url;
			$media_url = "";
			$site = "";

			//YOUTUBE
			if(preg_match('#(?<=(?:v|i)=)[a-zA-Z0-9-]+(?=&)|(?<=(?:v|i)\/)[^&\n]+|(?<=embed\/)[^"&\n]+|(?<=(?:v|i)=)[^&\n]+|(?<=youtu.be\/)[^&\n]+#', $link, $videoid)){
			        if(strlen($videoid[0])) { $media_url = $videoid[0]; $site = "youtube";}
			}

			//DAILYMOTION
			preg_match('#<object[^>]+>.+?www.dailymotion.com/swf/video/([A-Za-z0-9]+).+?</object>#s', $link, $matches);
			if(!isset($matches[1])) {
			        preg_match('#www.dailymotion.com/video/([A-Za-z0-9]+)#s', $link, $matches);
			        if(!isset($matches[1])) {
			                preg_match('#www.dailymotion.com/embed/video/([A-Za-z0-9]+)#s', $link, $matches);
			                if(strlen($matches[1])){ $media_url = $matches[1]; $site = "dailymotion";}
			        }elseif(strlen($matches[1])){
			                $media_url = $matches[1];
			                $site = "dailymotion";
			        }
			}elseif(strlen($matches[1])){
			        if(strlen($matches[1])){ $media_url = $matches[1]; $site = "dailymotion";}
			}
			 
			//VIMEO
			if(preg_match('#(https?://)?(www.)?(player.)?vimeo.com/([a-z]*/)*([0-9]{6,11})[?]?.*#', $link, $videoid)){
			        if(strlen($videoid[5])) { $media_url = $videoid[5]; $site = "vimeo";}
			}

			if($site == "dailymotion")
			{
				$api = file_get_contents("https://api.dailymotion.com/video/".$media_url."?fields=views_total");
				$api = json_decode($api, true);
				$vueDailyMotion += $api['views_total'];
				$dailymotionInfo .= "<div class='ligneValeur vues'><span class='nomVideo'>".$donneesVideo['nom']."</span><span class='green values'>".number_format($api['views_total'], 0, ',', '.')."</span></div>";
			}
			if($site == "youtube")
			{
				$api = file_get_contents("https://www.googleapis.com/youtube/v3/videos?id=".$media_url."&key=AIzaSyDQAjJWIUqy9ZToky2SnPBfhN0uliuSh54&part=statistics");
				$api = json_decode($api, true);
				foreach($api["items"] as $item)
				{
					$vueYoutube += $item['statistics']['viewCount'];
					$youtubeInfo .= "<div class='ligneValeur vues'><a target='_blank' href='http://youtube.com/watch?v=".$media_url."' class='nomVideo'>".$donneesVideo['nom']."&nbsp&nbsp<img src='../images/like.png' style='height: 14px'/>&nbsp".$item['statistics']['likeCount']."&nbsp&nbsp<img src='../images/dislike.png' style='height: 14px'/>&nbsp".$item['statistics']['dislikeCount']."</a><span class='green values'><img src='../images/eye.png' style='height: 14px'/>&nbsp".number_format($item['statistics']['viewCount'], 0, ',', '.')."</span></div>";
				}
			}
			
		}
		
		
		$analytics_content .= "<div class='videos'><div class='ligneValeur' style='width: 50%; float: left; overflow: hidden; padding-bottom: 50px'><div data-data='youtube' class='content_headline lien titleVideo'>Youtube - <span class='green'>".number_format($vueYoutube, 0, ',', '.')." vues</span></div>$youtubeInfo</div>";
		#$analytics_content .= "<div class='detailsVideo' id='youtubeInfo'></div>";
		$analytics_content .= "<div class='ligneValeur' style='width: 50%; float: left; overflow: hidden;padding-bottom: 50px'><div data-data='dailymotion' class='lien titleVideo'>Dailymotion - <span class='green'>".number_format($vueDailyMotion, 0, ',', '.')." vues</span></div>$dailymotionInfo</div></div>";
		#$analytics_content .= "<div class='detailsVideo'  id='dailymotionInfo'>$dailymotionInfo</div>";
		
		

		#echo "</div>";	

		#$analytics_content .= "</div>";
	}
		
	$analytics_content = "<div class='btn_container'><a class='btn_analytics' href='admin.php'>Trafic</a><a class='btn_analytics' href='?video=true'>Vidéos</a></div>".$analytics_content;	
	$end_time =  microtime(true);
	$analytics_content .= '<div style="width: 100%" id="bench"><span class="result">Temps d\'exécution : '.number_format($end_time - $begin_time, 2).' secondes</span></div>';	
	
	echo $analytics_content;
		#echo '<div style="width: 100%" id="bench"><span class="result">Temps d\'exécution : '.number_format($end_time - $begin_time, 2).' secondes</span></div>';
	
?>