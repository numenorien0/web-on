$(function(){
	$('#fileDisplay').click(function(){
		$('#fileHidden').click();
	});

	$('#fileHidden').change(function(){
		var valeurFichierCache = $(this)[0].files[0].name;
		$('#fileDisplay').val(valeurFichierCache);
	})

	if($("#categorie").val() != "")
	{
		var categorie = $("#categorie").val();
		
		categorie = jQuery.parseJSON(categorie);
		var longueur = Object.keys(categorie).length
		//alert(longueur);
		
		var i = 1;
		while(i<longueur)
		{
			var clone = $('#selectCategorie').clone();
			$("<div class='row'><div class='col-sm-4'></div></div>").insertBefore($("#addCategory").parent(".row")).append(clone).append("<input type='button' class='col-sm-1 deleteSelect' value='X'/>");	
			i++;		
		}
		
		
		$.each(categorie, function(i, v){
			console.log(v);
			var valeur = v;
			$('.categoriesSelect:nth('+i+') option').each(function(){
				if($(this).text() == valeur)
				{
					$(this).prop("selected","selected");
				}
			})
		})
	}
	
	$('#addCategory').click(function(){
		var clone = $('#selectCategorie').clone();
		$("<div class='row'><div class='col-sm-4'></div></div>").insertBefore($(this).parent(".row")).append(clone).append("<input type='button' class='col-sm-1 deleteSelect' value='X'/>");
		$('.deleteSelect').click(function(){
		$(this).prev("select").parent(".row").remove();
	})
	})
	
	$('.deleteSelect').click(function(){
		$(this).prev("select").parent(".row").remove();
	})
	
})