<?php

ini_set('display_errors','off');
error_reporting(E_ALL);
	
	include('main.php');
	
	session_start();
	
	date_default_timezone_set($timezone);

	ini_set('session.gc_maxlifetime', '1800'); 
	$_SESSION['admin_online'] = "true";

	if (isset($_POST['admin_password']) && $_POST['admin_password'] === $admin_password)
	{
		$_SESSION['admin_online'] = "true";
	}
?>

<!DOCTYPE html>
	<html lang="en">
   	 	<head>
   	 		<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
			<meta content="utf-8" http-equiv="encoding">
   	 		<title>Live Analytics</title>
   	 		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
   	 		<script type="text/javascript" src="http://maps.google.com/maps/api/js?libraries=geocoding&key=AIzaSyC5ByezWW13xL5-nIzqRA9Ig7t04WzM-Z4"></script>
			<link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600' rel='stylesheet' type='text/css'>
			<link href="style.css" rel="stylesheet" type="text/css" />
			
			
			<script src="chart.js"></script>
			<script src="main.js"></script>
    	</head>
    	<body class="body">
	    	<script>
				$(function(){
				var styles = 	[
					    {
					        "featureType": "all",
					        "elementType": "labels",
					        "stylers": [
					            {
					                "visibility": "off"
					            }
					        ]
					    },
					    {
					        "featureType": "administrative.country",
					        "elementType": "all",
					        "stylers": [
					            {
					                "visibility": "on"
					            }
					        ]
					    },
					    {
					        "featureType": "administrative.province",
					        "elementType": "all",
					        "stylers": [
					            {
					                "visibility": "on"
					            }
					        ]
					    },
					    {
					        "featureType": "administrative.locality",
					        "elementType": "all",
					        "stylers": [
					            {
					                "visibility": "on"
					            }
					        ]
					    },
					    {
					        "featureType": "landscape",
					        "elementType": "all",
					        "stylers": [
					            {
					                "visibility": "on"
					            },
					            {
					                "color": "#f3f4f4"
					            }
					        ]
					    },
					    {
					        "featureType": "landscape.man_made",
					        "elementType": "geometry",
					        "stylers": [
					            {
					                "weight": 0.9
					            },
					            {
					                "visibility": "off"
					            }
					        ]
					    },
					    {
					        "featureType": "poi.park",
					        "elementType": "geometry.fill",
					        "stylers": [
					            {
					                "visibility": "on"
					            },
					            {
					                "color": "#83cead"
					            }
					        ]
					    },
					    {
					        "featureType": "road",
					        "elementType": "all",
					        "stylers": [
					            {
					                "visibility": "on"
					            },
					            {
					                "color": "#ffffff"
					            }
					        ]
					    },
					    {
					        "featureType": "road",
					        "elementType": "labels",
					        "stylers": [
					            {
					                "visibility": "off"
					            }
					        ]
					    },
					    {
					        "featureType": "road.highway",
					        "elementType": "all",
					        "stylers": [
					            {
					                "visibility": "off"
					            },
					            {
					                "color": "#fee379"
					            }
					        ]
					    },
					    {
					        "featureType": "road.arterial",
					        "elementType": "all",
					        "stylers": [
					            {
					                "visibility": "off"
					            },
					            {
					                "color": "#fee379"
					            }
					        ]
					    },
					    {
					        "featureType": "water",
					        "elementType": "all",
					        "stylers": [
					            {
					                "visibility": "on"
					            },
					            {
					                "color": "#7fc8ed"
					            }
					        ]
					    }
					]					
						
						var map;
						var geocoder = new google.maps.Geocoder();
						
						map = new google.maps.Map(document.getElementById('map'), {
							zoom: 7,
							center: {lat: 50.6292093, lng: 4.7335654},
							mapTypeId: 'Styled',
							zoomControl: true,
							mapTypeControl: false,
							scaleControl: false,
							streetViewControl: false,
							rotateControl: false
						});
					
						var styledMapType = new google.maps.StyledMapType(styles, { name: 'Styled' });
						map.mapTypes.set('Styled', styledMapType);
					

						$(".city").each(function(){
							var adresse = $(this).val();
							var nombre = $(this).next(".cityCount").val();
								console.log(parseFloat(nombre) + " "+ adresse);
								if(parseFloat(nombre) > 0.5)
								{
									//console.log(nombre);
									//geocoder.geocode({'address': adresse}, function(results, status){
									$.getJSON('https://maps.googleapis.com/maps/api/geocode/json?address='+adresse+'&sensor=false&key=AIzaSyC5ByezWW13xL5-nIzqRA9Ig7t04WzM-Z4', null, function (data) {	
										    var cityCircle = new google.maps.Circle({
										      strokeColor: '#1a4a96',
										      strokeOpacity: 0.8,
										      strokeWeight: 2,
										      fillColor: '#73aeff',
										      fillOpacity: 0.5,
										      map: map,
										      center: data.results[0].geometry.location,
										      radius: 10000*parseFloat(nombre)/5
										    });
										    
											var infowindow = new google.maps.InfoWindow({
												content: data.results[0].formatted_address+" ("+nombre+"%)"
											});
											
											cityCircle.addListener('click', function() {
												infowindow.setPosition(data.results[0].geometry.location);
										    	infowindow.open(map, cityCircle);
										  });
									});
								}
						});
						
					//}
														

				});
		    </script>
    		<div class="site_background"></div>
    		<div class="content">
    			<div class="header">
    				<div class="darken"></div>
					<div class="site_title">Smart Analytics</div>

<?php
	if (!empty($_SESSION['admin_online'])) 
	{
?>

					<a href="logout.php"><div class="logout_button"></div></a>
					
<?php
	}
?>

				</div> 
				<div class="content_holder" id="content_holder">
				
<?php
	if (!empty($_SESSION['admin_online'])) 
	{
		include('update.php');
	}

	if (empty($_SESSION['admin_online'])) 
	{
?>
	
					<div class="content_wrapper" style="height:500px;">
  						<div class="admin_login_text">Smart Analytics</div>   
    					<form style="color: white" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    						<input class="admin_login_input" name="admin_password" type="password" value="" />
    						<input class="admin_login_submit" type="submit" value="Login" />
    					</form>
    				</div>
    					
<?php 
		if (isset($_POST['admin_password']))
		{
			echo '<div class="admin_login_error">Mauvais mot de passe, veuillez réessayer.</div>';	
		}
	
	}
	else
	{

	}
?>
					
					</div>
				</div>
			</div>
		</body>
	</html>

