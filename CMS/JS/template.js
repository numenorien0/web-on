$(function(){
	
	$('.template').click(function(){
		var d = new Date();
		var nom = $(this).children(".nom").text();
		$.ajax({
			url: "content/templates/"+nom+".txt?t="+d.getTime(),
		}).done(function(html){
			$('#nom').val(nom);
			tinyMCE.activeEditor.setContent(html);
		})
		
		
	})
	
	
	$('#create').click(function(){
		$('#nom').val("").focus();
		tinyMCE.activeEditor.setContent("");
	})
	
	
	
})