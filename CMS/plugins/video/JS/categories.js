$(function(){
	$('#fileDisplay').click(function(){
		$('#fileHidden').click();
	});

	$('#fileHidden').change(function(){
		var valeurFichierCache = $(this)[0].files[0].name;
		$('#fileDisplay').val(valeurFichierCache);
	});

	if($('#actifHidden').val() == "true")
	{
		$("#actif").attr('checked', "checked");
		setTimeout(redraw, 1500);
	}
	
	
	
	
	function redraw()
	{
		$('input[type=checkbox]').next(".switchery").remove();
		var elems = Array.prototype.slice.call($('input[type=checkbox]'));
	
		elems.forEach(function(html) {
			if($(html).hasClass("deleteCheckBox"))
			{
				//alert('ok');
			}
			else
			{
				var switchery = new Switchery(html, { size: 'small' });
			}
		});
	}
	
})