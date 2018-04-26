function getHTTPObject()
{
	if (window.ActiveXObject) 
	{
		return new ActiveXObject("Microsoft.XMLHTTP");
	}
	else
	{
	 	if (window.XMLHttpRequest) 
	 	{
			return new XMLHttpRequest();
		}
		else 
		{
			return null;
		}
	}
} 
 
function update_analytics(httpObject) 
{
	if (httpObject.readyState == 4 && httpObject.status == 200) 
	{
		var response = httpObject.responseText;
					
		document.getElementById("content_holder").innerHTML = response;
	}
}	  

function refresh_analytics()
{    
	var httpObject = getHTTPObject();
		
	if (httpObject != null) 
	{
		var link = "update.php";
			
		httpObject.open("GET",link, true);
		httpObject.onreadystatechange = function() { update_analytics(httpObject); };
		httpObject.send(null);
	}
}

function refresh_timer() 
{
	refresh_analytics();
	setTimeout("refresh_timer()", 3000);
}


	
window.onload = function() { refresh_timer();};