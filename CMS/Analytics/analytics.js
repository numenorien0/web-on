window.onload = function() {
// 	var scripts = document.getElementsByTagName("script");
	var scripts = document.getElementById("geronimo_analytics");
	var script_location = scripts.src;
	//console.log(script_location);
	script_location = script_location.substring(0, script_location.lastIndexOf("/"));
	//console.log(document.referrer);
	var referrer = encodeURIComponent(document.referrer);
	if(referrer == "" || !referrer)
	{
		referrer = "direct";
	}
	if(referrer.indexOf("newsletter.php"))
	{
		referrer = "Newsletter";
	}
	
	var tracker_holder = document.createElement('div');
	tracker_holder.innerHTML = "<iframe src=\"" + script_location +"/analytics.php?url=" + encodeURIComponent(window.location.href) + "&referrer=" + referrer + "\" style=\"position:fixed; left:-1px; top:-1px; width:1px; height:1px; display:none; border:none; outline:none;\" width=\"1px\" height=\"1px\"></iframe>";
	//console.log(document.body);
	document.getElementsByTagName('body')[0].appendChild(tracker_holder);
	//document.body.innerHTML += tracker_holder;
	
	
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
	
	setInterval(function(){
		var visible = vis()
		if(visible == true && document.hasFocus())
		{
			  var xhr=new XMLHttpRequest();
			  xhr.open("GET", script_location +"/analytics_ajax.php?url=" + encodeURIComponent(window.location.href),true);
			    if(xhr.readyState == 4)
			    {
			      console.log("kkk");	
			    } 
			  xhr.send(null);	
		}
	}, 3000);
}