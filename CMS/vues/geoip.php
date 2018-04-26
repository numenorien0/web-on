<?php

			
			$ip = $_GET['ip'];
			$ip = explode(".", $ip);
			
			$monPrefix = $ip[0];
			
			$info = file("includes/ip/$monPrefix.csv");
			
			
// 			$res = array_unique($dtls);
			#$delimiter = ',';

/*
			 while(($ipAddress = fgetcsv($info, 0, $delimiter)) !== false) // Récupération d'une ligne
			 {		
*/	

/*
			$count = 255;
			$i = 0;
			while($i <= $count)
			{
				if(!file_exists("includes/ip/$i.csv"))
				{
					fopen("includes/ip/$i.csv", "w+");
				}
				$i++;
			}
			
			
			foreach($info as $key => $ip)
			{
				
				$ipAddress = explode(",",$ip);
				$ipAddress[0] = str_replace('"','', $ipAddress[0]);
				$prefix = explode(".", $ipAddress[0]);
				if(intval($prefix[0]) >= 199)
				{
					$fichierAModifier = file_get_contents("includes/ip/".$prefix[0].".csv");
					$fichierAModifier .= $ip;
					file_put_contents("includes/ip/".$prefix[0].".csv", $fichierAModifier);
				}
			}
*/
			$monIP = explode(".", $_GET['ip']);
			$ipOK = array();
			foreach($monIP as $ip)
			{
				if(strlen(''. $ip .'') == 1)
				{
								
					$ip= "00".$ip;
				}
				if(strlen(''. $ip .'') == 2)
				{
					$ip = "0".$ip;
				}
				$ipOK[] = $ip;
			}
			$ipVal = implode("", $ipOK);
			

			foreach($info as $ipAddress)
			{
				$ipAddress = explode(",",$ipAddress);
				
				$ipAddress[0] = str_replace('"','', $ipAddress[0]);
				$ipAddress[0] = explode(".", $ipAddress[0]);
				$ipAddress[1] = str_replace('"','', $ipAddress[1]);
				$ipAddress[1] = explode(".", $ipAddress[1]);
				
				
				
				
				
				$ipMin = array();
				$ipMin2 = array();
				foreach($ipAddress[0] as $nombre)
				{
					//for($i = strlen(''. $nombre .''); $i <= 3; $i++)
					//{
						//$nombre = "0"+$nombre;
					//}
					
					if(strlen(''. $nombre .'') == 1)
					{
						
						$nombre = "00".$nombre;
					}
					if(strlen(''. $nombre .'') == 2)
					{
						$nombre = "0".$nombre;
					}
					
					$ipMin[] = $nombre;
					
				}
				foreach($ipAddress[1] as $nombre2)
				{
					//for($i = strlen(''. $nombre .''); $i <= 3; $i++)
					//{
						//$nombre = "0"+$nombre;
					//}
					
					if(strlen(''. $nombre2 .'') == 1)
					{
						
						$nombre2 = "00".$nombre2;
					}
					if(strlen(''. $nombre2 .'') == 2)
					{
						$nombre2 = "0".$nombre2;
					}
					
					$ipMin2[] = $nombre2;
					
				}
				$ipMin = implode("", $ipMin);
				$ipMax = implode("", $ipMin2);					

				if($ipVal >= $ipMin AND $ipVal <= $ipMax)
				{
					echo $ipAddress[4];
					//$this->_country = str_replace('"', "", $ipAddress[4]);
				}

			}	

	
?>

