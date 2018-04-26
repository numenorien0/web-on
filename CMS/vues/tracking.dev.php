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

$(function($){

var ip = "<?=$_SERVER['REMOTE_ADDR']?>";
var OS = "<?=$user_os?>";
var browser = "<?=$user_browser?>";
var ville;
var pays;
var referrer = "";
referrer = document.referrer;
var langue = "<?=$langue{0}.$langue{1};?>";
var page = window.location.href;


$.getJSON("http://geoip.nekudo.com/api/"+ip+"/fr?callback=?",function(data){
	//console.log("ok");
	ville = data.city;
	pays = data.country.name;
	sendData(browser, ip, ville, pays, referrer, langue, OS);
});

function decode(s)
{
    var e={},i,b=0,c,x,l=0,a,r='',w=String.fromCharCode,L=s.length;
    var A="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
    for(i=0;i<64;i++){e[A.charAt(i)]=i;}
    for(x=0;x<L;x++){
        c=e[s.charAt(x)];b=(b<<6)+c;l+=6;
        while(l>=8){((a=(b>>>(l-=8))&0xff)||(x<(L-2)))&&(r+=w(a));}
    }
    return r;
};


var session_ID = "<?=$session_id?>";


function sendData()
{
	var urlDecoded = decode("<?=$_GET['id']?>");
	if(ville == "false") {ville = "inconnue"};
	if(ville == "") {ville = "inconnue"};
	//ip = ip+": <?=$local?>";
	$.ajax({
		url: urlDecoded,
		type: 'GET',
		data: {browser: browser, ville: ville, ip: ip, pays: pays, referrer: referrer, page: page, langue: langue, OS: OS, session_ID: session_ID},
	})
	.done(function(html) {
		//session_ID = html;
	})
	.fail(function() {
		//console.log("error");
	})
	.always(function() {
		
	});
}
var vis = (function(){
    var stateKey, eventKey, keys = {
        hidden: "visibilitychange",
        webkitHidden: "webkitvisibilitychange",
        mozHidden: "mozvisibilitychange",
        msHidden: "msvisibilitychange"
    };
    for (stateKey in keys) {
        if (stateKey in document) {
            eventKey = keys[stateKey];
            break;
        }
    }
    return function(c) {
        if (c) document.addEventListener(eventKey, c);
        return !document[stateKey];
    }
})();



var time = 0;
function sendTime()
{
	var visible = vis();
	if(visible == true && document.hasFocus())
	{
		//alert(visible);
		var urlDecoded = decode("<?=$_GET['id']?>");
		time += 2;
		$.ajax({
			url: urlDecoded,
			type: 'GET',
			data: {ip: ip, session_ID: session_ID, page: page, time: time},		
		})	
		.done(function(html) {
			//console.log(html);
			console.log("time enabled");
		})
	}
}

//sendTime();
setInterval(sendTime, 2000);

});

