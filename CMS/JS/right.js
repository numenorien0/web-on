$(function(){
	
	$.contextMenu("html5");
	var elementClicked;
	
	
	$(document).mousedown(function(e){
		if(e.which == 3)
		{
			//console.log(e.target);
			var attr = $(e.target).attr('contextmenu');
			if (typeof attr !== typeof undefined && attr !== false)
			{
				if($(e.target).hasClass("openRepertoire"))
				{
					elementClicked = $(e.target).attr('data-id');
				}
				if($(e.target).hasClass("alias"))
				{
// 					alert('ok');
					elementClicked = $(e.target).attr('data-alias');
				}
				if($(e.target).attr('id') == "listeDesPages")
				{
					elementClicked = "liste des pages";
				}	
			}
			else
			{
				//e.preventDefault();
			}
			console.log(elementClicked);
			localStorage.setItem("elementClicked", elementClicked);
		}
	})
})