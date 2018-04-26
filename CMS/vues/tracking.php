<?php
	session_start();
	if(!isset($_SESSION['pilot_time']))
	{
		$_SESSION["pilot_time"] = time();
		$session_id = session_id();
	}
	else
	{
		if($_SESSION['pilot_time'] < time() - 3600)
		{
			$_SESSION["pilot_time"] = time();
			session_regenerate_id(true);
			$session_id = session_id();
		}
		else
		{
			$session_id = session_id();
		}
	}
	header('Content-Type: application/javascript');
	$local = gethostbyname(trim(`hostname`));
	$langue = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
	$user_agent = $_SERVER['HTTP_USER_AGENT'];

	
function getOS() { 

    global $user_agent;

    $os_platform    =   "Inconnu";

    $os_array       =   array(
                            '/windows nt 10/i'     =>  'Windows 10',
                            '/windows nt 6.3/i'     =>  'Windows 8.1',
                            '/windows nt 6.2/i'     =>  'Windows 8',
                            '/windows nt 6.1/i'     =>  'Windows 7',
                            '/windows nt 6.0/i'     =>  'Windows Vista',
                            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                            '/windows nt 5.1/i'     =>  'Windows XP',
                            '/windows xp/i'         =>  'Windows XP',
                            '/windows nt 5.0/i'     =>  'Windows 2000',
                            '/windows me/i'         =>  'Windows ME',
                            '/win98/i'              =>  'Windows 98',
                            '/win95/i'              =>  'Windows 95',
                            '/win16/i'              =>  'Windows 3.11',
                            '/macintosh|mac os x/i' =>  'Mac OS X',
                            '/mac_powerpc/i'        =>  'Mac OS 9',
                            '/linux/i'              =>  'Linux',
                            '/ubuntu/i'             =>  'Ubuntu',
                            '/iphone/i'             =>  'iOS',
                            '/ipod/i'               =>  'iOS',
                            '/ipad/i'               =>  'iOS',
                            '/android/i'            =>  'Android',
                            '/blackberry/i'         =>  'BlackBerry',
                            '/webos/i'              =>  'Mobile'
                        );

    foreach ($os_array as $regex => $value) { 

        if (preg_match($regex, $user_agent)) {
            $os_platform    =   $value;
        }

    }   

    return $os_platform;

}

function getBrowser() {

    global $user_agent;

    $browser        =   "Inconnu";

    $browser_array  =   array(
                            '/msie/i'       =>  'Internet Explorer',
                            '/firefox/i'    =>  'Firefox',
                            '/safari/i'     =>  'Safari',
                            '/chrome/i'     =>  'Chrome',
                            '/opera/i'      =>  'Opera',
                            '/netscape/i'   =>  'Netscape',
                            '/maxthon/i'    =>  'Maxthon',
                            '/konqueror/i'  =>  'Konqueror',
                            '/mobile/i'     =>  'Navigateur mobile'
                        );

    foreach ($browser_array as $regex => $value) { 

        if (preg_match($regex, $user_agent)) {
            $browser    =   $value;
        }

    }

    return $browser;

}


$user_os        =   getOS();
$user_browser   =   getBrowser();
?>

$(function(n){function e(n){var e,i,o,r,t={},a=0,c=0,u="",s=String.fromCharCode,d=n.length,f="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";for(e=0;64>e;e++)t[f.charAt(e)]=e;for(o=0;d>o;o++)for(i=t[n.charAt(o)],a=(a<<6)+i,c+=6;c>=8;)((r=a>>>(c-=8)&255)||d-2>o)&&(u+=s(r));return u}function i(){var i=e("<?=$_GET['id']?>");"false"==r&&(r="inconnue"),""==r&&(r="inconnue"),n.ajax({url:i,type:"GET",data:{browser:u,ville:r,ip:a,pays:t,referrer:s,page:f,langue:d,OS:c,session_ID:l}}).done(function(){}).fail(function(){}).always(function(){})}function o(){var i=v();if(1==i&&document.hasFocus()){var o=e("<?=$_GET['id']?>");g+=2,n.ajax({url:o,type:"GET",data:{ip:a,session_ID:l,page:f,time:g}}).done(function(){console.log("time enabled")})}}var r,t,a="<?=$_SERVER['REMOTE_ADDR']?>",c="<?=$user_os?>",u="<?=$user_browser?>",s="";s=document.referrer;var d="<?=$langue{0}.$langue{1};?>",f=window.location.href;n.getJSON("http://geoip.nekudo.com/api/"+a+"/fr?callback=?",function(n){r=n.city,t=n.country.name,i(u,a,r,t,s,d,c)});var l="<?=$session_id?>",v=function(){var n,e,i={hidden:"visibilitychange",webkitHidden:"webkitvisibilitychange",mozHidden:"mozvisibilitychange",msHidden:"msvisibilitychange"};for(n in i)if(n in document){e=i[n];break}return function(i){return i&&document.addEventListener(e,i),!document[n]}}(),g=0;setInterval(o,2e3)});

