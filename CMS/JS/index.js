$(function(){
	
	var qui = "notme";
	var totalFreeSpace = $('#freeSpaceOctet').val();
	var TotalSpace = $('#TotalSpaceOctet').val();
	
// 	alert(TotalSpace);
	var totalPourcentage = 100-(totalFreeSpace/TotalSpace*100);
	
	$('.progress-pie-chart').attr('data-percent', totalPourcentage);
	
	$('#messageContainer').scrollTop($('#messageContainer')[0].scrollHeight);
      var $ppc = $('.progress-pie-chart'),
        percent = parseInt($ppc.data('percent')),
        deg = 360*percent/100;
      if (percent > 50) {
        $ppc.addClass('gt-50');
      }
      $('.ppc-progress-fill').css('transform','rotate('+ deg +'deg)');
      $('.ppc-percents span').html(percent+'%');
      
	      
function refreshMessage()
{
	$.ajax({
	  url: "refreshMessage.php",
	  method: "GET",
	  data: { type : "get" },
	}).done(function( msg ) {
		var needToScroll = false;
		//alert($('#messageContainer').scrollTop());
		if($('#messageContainer').scrollTop() + $('#messageContainer').height() == $('#messageContainer')[0].scrollHeight)
		{
			//alert('ok');
			needToScroll = true;
	  	}
	  	else
	  	{
		  	
		  	needToScroll = false;
	  	}
		var nombreDeMessage = $('.message').length;
		$('#messageContainer').html(msg);
		
		if(needToScroll == true)
		{
			$('#messageContainer').scrollTop($('#messageContainer')[0].scrollHeight);
		}
	  if($('.message').length > nombreDeMessage)
	  {
		  	if(!document.hasFocus())
		  	{
				Notification.requestPermission( function(status) {
				  console.log(status); // les notifications ne seront affichées que si "autorisées"
				  var n = new Notification("Pilot", {body: "Vous avez reçu de nouveaux messages", icon: "images/favicon.png"}); // this also shows the notification
				});	
			}  
	  }
	}).fail(function( jqXHR, textStatus ) {
	  //alert( "Request failed: " + textStatus );
	});
}
var keydown = false;
$('#yourMessage').focus(function(){
	$(document).keydown(function(e){
		//keydown = true;
		if(e.shiftKey && e.keyCode == "13")
		{
			
		}
		else
		{
			if(e.keyCode == "13")
			{
				if($('#yourMessage').val() != "")
				{
					e.preventDefault();
					$('#sendMessage').click();
				}
				else
				{
					e.preventDefault();
					return false;
				}
			}
		}
	})
});

$(document).keyup(function(){
	//keydown = false;
})
$('#sendMessage').click(function(e){
	e.preventDefault();
	if($('#yourMessage').val() != "")
	{
		postMessage();
	}
})

function postMessage()
{
	$.ajax({
	  url: "refreshMessage.php",
	  method: "POST",
	  data: { type : "post", message: $("#yourMessage").val()},
	}).done(function( msg ) {
		$('#yourMessage').val("");
		refreshMessage();		
	});
}

setInterval(refreshMessage, 2000);

})