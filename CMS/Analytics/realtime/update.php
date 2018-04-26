<?php

	error_reporting(0);
	ini_set("display_errors", 0);
	
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
	
	
	
	
	
	
	
	
	
	
	
	
	date_default_timezone_set($timezone);
	
	$current_time = time();
	
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
	
	
	
	
	
	// Analytics database directories
	
	$realtime_analytics_folder = $analytics_folder . '/realtime/';
	
	$realtime_analytics_visitors_folder = $realtime_analytics_folder . 'visitors/';
	$realtime_analytics_pageviews_folder = $realtime_analytics_folder . 'pageviews/';
	
	
	
	
	$analytics_content = "";
	
	
	
	
	
	
	// Compute analytics
	
	
	
	
	
	// Realtime analytics
	
	$realtime_visitors = glob($realtime_analytics_visitors_folder . '*');
	
	foreach ($realtime_visitors as $visitor)
  	{
    	if (is_file($visitor))
    	{
    		if (($current_time - filemtime($visitor)) < 180)
      		{
        		$current_online_visitor_count += 1;
        	}
        	
        	for ($i = 0; $i < 100; $i++)
        	{
      			if ((($current_time - filemtime($visitor)) >= ($i*3)) && (($current_time - filemtime($visitor)) < (($i+1)*3)))
      			{
        			$visitors_array[$i] += 1;
        		}
        	}
        	
        	if (($current_time - filemtime($visitor)) >= (101*3))
      		{
        		unlink($visitor);
        	}
        }
    }
    
    
    
    $realtime_pageviews = glob($realtime_analytics_pageviews_folder . '*');
	
	foreach ($realtime_pageviews as $pageviews)
  	{
    	if (is_file($pageviews))
    	{	
        	for ($i = 0; $i < 100; $i++)
        	{
      			if ((($current_time - filemtime($pageviews)) >= ($i*3)) && (($current_time - filemtime($pageviews)) < (($i+1)*3)))
      			{
        			$pageviews_array[$i] += 1;
        		}
        	}
        	
        	if (($current_time - filemtime($pageviews)) >= (101*3))
      		{
        		unlink($pageviews);
        	}
        }
    }
    
	
	
	$max_value = max($pageviews_array);
	
	if ($max_value > 10000)
	{
		$max = 100000;
	}
	
	if ($max_value < 10000)
	{
		$max = 10000;
	}
	
	if ($max_value < 9000)
	{
		$max = 9000;
	}
	
	if ($max_value < 8000)
	{
		$max = 8000;
	}
	
	if ($max_value < 7000)
	{
		$max = 7000;
	}
	
	if ($max_value < 6000)
	{
		$max = 6000;
	}
	
	if ($max_value < 5000)
	{
		$max = 5000;
	}
	
	if ($max_value < 4000)
	{
		$max = 4000;
	}
	
	if ($max_value < 3000)
	{
		$max = 3000;
	}
	
	if ($max_value < 2000)
	{
		$max = 2000;
	}
	
	if ($max_value < 1000)
	{
		$max = 1000;
	}
	
	if ($max_value < 900)
	{
		$max = 900;
	}
	
	if ($max_value < 800)
	{
		$max = 800;
	}
	
	if ($max_value < 700)
	{
		$max = 700;
	}
	
	if ($max_value < 600)
	{
		$max = 600;
	}
	
	if ($max_value < 500)
	{
		$max = 500;
	}
	
	if ($max_value < 400)
	{
		$max = 400;
	}
	
	if ($max_value < 300)
	{
		$max = 300;
	}
	
	if ($max_value < 200)
	{
		$max = 200;
	}
	
	if ($max_value < 100)
	{
		$max = 100;
	}
	
	if ($max_value < 50)
	{
		$max = 50;
	}
	
	if ($max_value < 20)
	{
		$max = 20;
	}
	
	if ($max_value < 10)
	{
		$max = 10;
	}
	
	
	
	
	
	
	
	
	
	
	// Add Analytics to content
		
	// Realtime analytics
	
	$analytics_content .= "
    						<div class=\"content_wrapper white\" style=\"padding:0; min-height:300px;\">
    							<div class=\"realtime_chart_holder\" id=\"realtime_chart_holder\">
    								<canvas id=\"realtime_chart\" style=\"position:relative; float:left; width:100%; height:100%;\"></canvas>
    							</div>
    							<div class=\"darken\"></div>
    							<div class=\"realtime_bar_chart_holder\">
    								<div class=\"realtime_bar_chart\">
    									<div class=\"realtime_bar_chart_bar\">
    									</div>
    								</div>
    					";
    				
    					
    for ($i = 0; $i <= 100; $i++) 
	{
    							
    	$analytics_content .= "	
    								<div class=\"realtime_bar_chart\">
    									<div class=\"realtime_bar_chart_bar\">
    										<div class=\"realtime_bar_chart_bar_value\" style=\"height:" . round((($pageviews_array[$i]/$max)*100)) . "%; background:#6a6ca9;\"></div>
    									</div>
    								</div>
    					";
    }
    							
    							
    $analytics_content .= "			
    							</div>
    							
    							<div class=\"realtime_bar_chart_holder\">
    								<div class=\"realtime_bar_chart\">
    									<div class=\"realtime_bar_chart_bar\">
    									</div>
    								</div>
    					";
    					
    				
    					
    for ($i = 0; $i <= 100; $i++) 
	{
    							
    	$analytics_content .= "	
    								<div class=\"realtime_bar_chart\">
    									<div class=\"realtime_bar_chart_bar\">
    										<div class=\"realtime_bar_chart_bar_value dark_value\" style=\"height:" . round((($visitors_array[$i]/$max)*100)) . "%; background:#51acb8;\"></div>
    									</div>
    								</div>
    					";
    }
    							
    							
    $analytics_content .= "			
    							</div>
    							
    							<div class=\"realtime_chart_mesh\">
    								<div class=\"realtime_chart_mesh_inner\">
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_bar\"></div>
    								</div>
    								<div class=\"realtime_chart_mesh_inner\">
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_bar\"></div>
    								</div>
    								<div class=\"realtime_chart_mesh_inner\">
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_bar\"></div>
    								</div>
    								<div class=\"realtime_chart_mesh_inner\">
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_bar\"></div>
    								</div>
    								<div class=\"realtime_chart_mesh_inner\">
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_bar\"></div>
    								</div>
    								<div class=\"realtime_chart_mesh_inner\">
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_bar\"></div>
    								</div>
    								<div class=\"realtime_chart_mesh_inner\">
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_bar\"></div>
    								</div>
    								<div class=\"realtime_chart_mesh_inner\">
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_bar\"></div>
    								</div>
    								<div class=\"realtime_chart_mesh_inner\">
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_bar\"></div>
    								</div>
    								<div class=\"realtime_chart_mesh_inner\">
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_bar\"></div>
    								</div>
    								<div class=\"realtime_chart_mesh_inner\">
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_bar\"></div>
    								</div>
    								<div class=\"realtime_chart_mesh_inner\">
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_bar\"></div>
    								</div>
    								<div class=\"realtime_chart_mesh_inner\">
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_bar\"></div>
    								</div>
    								<div class=\"realtime_chart_mesh_inner\">
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_bar\"></div>
    								</div>
    								<div class=\"realtime_chart_mesh_inner\">
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_bar\"></div>
    								</div>
    								<div class=\"realtime_chart_mesh_inner\">
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_bar\"></div>
    								</div>
    								<div class=\"realtime_chart_mesh_inner\">
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_bar\"></div>
    								</div>
    								<div class=\"realtime_chart_mesh_inner\">
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_bar\"></div>
    								</div>
    								<div class=\"realtime_chart_mesh_inner\">
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_bar\"></div>
    								</div>
    								<div class=\"realtime_chart_mesh_inner\">
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_metric\"></div>
    									<div class=\"realtime_chart_mesh_metric\"></div>
    								</div>
    							</div>
    							<div class=\"realtime_chart_scale\">
    								<div class=\"realtime_chart_scale_axis\"></div>
    								<div class=\"realtime_chart_scale_axis\"></div>
    								<div class=\"realtime_chart_scale_axis\"></div>
    								<div class=\"realtime_chart_scale_axis\"></div>
    								<div class=\"realtime_chart_scale_axis\"></div>
    								<div class=\"realtime_online_counter_legend\" style=\"bottom:100%; margin-bottom:5px; left:5px;\">" . $max . "</div>
    								<div class=\"realtime_online_counter_legend\" style=\"bottom:80%; margin-bottom:5px; left:5px;\">" . ($max/5)*4 . "</div>
    								<div class=\"realtime_online_counter_legend\" style=\"bottom:60%; margin-bottom:5px; left:5px;\">" . ($max/5)*3 . "</div>
    								<div class=\"realtime_online_counter_legend\" style=\"bottom:40%; margin-bottom:5px; left:5px;\">" . ($max/5)*2 . "</div>
    								<div class=\"realtime_online_counter_legend\" style=\"bottom:20%; margin-bottom:5px; left:5px;\">" . ($max/5)*1 . "</div>
    								<div class=\"realtime_online_counter_legend\" style=\"bottom:0; margin-bottom:5px; left:5px;\">" . "0" . "</div>
    							</div>
    							<div class=\"realtime_online_counter_legend\" style=\"left:705px;\">1 Min</div>
    							<div class=\"realtime_online_counter_legend\" style=\"left:525px;\">2 Min</div>
    							<div class=\"realtime_online_counter_legend\" style=\"left:345px;\">3 Min</div>
    							<div class=\"realtime_online_counter_legend\" style=\"left:165px;\">4 Min</div>
    						</div>
    						<div class=\"content_wrapper dark\" >
    							<div class=\"darken\"></div>
    							<div class=\"realtime_online_counter_holder\">
    								<div class=\"realtime_online_counter_headline\">Visiteurs actuellement en ligne</div>
    								<div class=\"realtime_online_counter_value\">" . $current_online_visitor_count . "</div>
    							</div>
    							<div class=\"realtime_online_visitors_holder\">
    								<div class=\"realtime_online_visitor_holder_header\">
    									<div class=\"realtime_online_visitor_avatar\"></div>
    									<div class=\"realtime_online_visitor_stats\">Adresse IP</div>
    									<div class=\"realtime_online_visitor_stats\">Device</div>
    									<div class=\"realtime_online_visitor_stats\">OS</div>
    									<div class=\"realtime_online_visitor_stats\">Navigateur</div>
    									<div class=\"realtime_online_visitor_stats\">Pays</div>
    									<div class=\"realtime_online_visitor_stats\">Ville</div>
    									<div class=\"realtime_online_visitor_stats\">Page</div>
    									<div class=\"realtime_online_visitor_stats\">Provenance</div>
    								</div>
    ";
    							
    $realtime_iterator_counter = 0;
    foreach ($realtime_visitors as $visitor)
  	{
    	if (is_file($visitor))
    	{
    		if ($realtime_iterator_counter < $current_online_visitor_count)
    		{
    			$online_visitor_content = file($visitor);
    			$analytics_content .= $online_visitor_content[0];
    			$realtime_iterator_counter++;
    		}
        }
   	}
    
    $analytics_content .= "
    							</div>
    						</div>
    
    ";
	
	
	
	
	// Echo analytics content

	echo $analytics_content;
?>

