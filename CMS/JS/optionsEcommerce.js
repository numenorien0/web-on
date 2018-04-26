$(function(){
	$('.lang').hide()
	$('.name-cat-fr').show()
	$('.desc-cat-fr').show();
	$('span[data-lang=fr]').addClass("active");
	$('span[data-lang=fr]').text("Français");
	$('.btn_lang').click(function(e){
		e.preventDefault();
		var celuila = $('.btn_lang.active').attr('data-lang');
		$('.btn_lang.active').text(celuila);
		$('.btn_lang').removeClass("active");

		$('.lang').hide()
		var lang = $(this).attr('data-lang')
		var langue = $(this).attr('data-lang-name');
		$('.name-cat-'+lang).show()
		$('.desc-cat-'+lang).show()	
		$('span[data-lang='+lang+']').addClass("active");
		$('span[data-lang='+lang+']').text(langue);
	})
	
	$('.modalDisplay').hide();

	
	$('.wireframe_miniatures').click(function(){
		$('.wireframe_miniatures').removeClass('activeWireframe')
		$(this).addClass('activeWireframe')
		var id = $(this).attr('data-id')
		var modal = $(this).attr('data-modal')
		$('#thumbProd-'+modal).val(id)
	})
	
	$('#file_btn').click(function(){
		$('#file').click();
	})
	$('#tabTVA').DataTable({
	    	"language": {
				"url": "https://cdn.datatables.net/plug-ins/1.10.13/i18n/French.json"
			}
	});
	$('.retour').hide();
	$('.arborescence').each(function(){
		if($(this).attr('data-parent') != "0")
		{
			$(this).hide();
		}
	})
	$('.delBTN').each(function(){
		if($(this).attr('data-parent') != "0")
		{
			$(this).hide();
		}
	})
	
	$('.editBtn').click(function(){
/*
		var nom = $(this).parent().attr('data-name');
		var description = $(this).parent().attr('data-description');
		var image = $(this).parent().attr('data-image');
		var wich = $(this).parent().attr('data-id');
		
		
		$('#editID').val(wich);
		$('#editName').val(nom);
		$('#editDescription').val(description);
		$('.photoCat').html("<img src='content/products/categories/"+image+"' style='max-height: 100%; max-width: 100%'>");
*/
	})
	
	$(document).on("click", ".nomCategory", function(){
		
		//$(this).addClass("");
		var ID = $(this).parent().attr('data-id');
		var parent = $(this).parent().attr('data-parent');
		$('#hideID').val(parent);
		$('.arborescence').hide(); //"slide", { direction: "left" }, 200
		$('.retour').show();//"slide", { direction: "right" }, 500
		$('.delBTN').hide();
		//redraw("#categories");
		$('.arborescence[data-parent='+ID+']').show(); //"slide", { direction: "right" }, 1000
		$('.delBTN[data-parent='+ID+']').show();
		$('#idCtg').val(ID);

	})
	$('.retour').click(function(){
		var destination = $('#hideID').val();
		var parValue = $('.arborescence[data-id='+destination+']').attr('data-parent');
		
		$('.arborescence').hide();
		$('.delBTN').hide();
		if(destination == 0)
		{
			$('.retour').hide();
		}
		
		$('.arborescence[data-parent='+destination+']').show(); //"slide", { direction: "left" }, 200
		$('.delBTN[data-parent='+destination+']').show();
		$('#hideID').val(parValue);
		$('#idCtg').val(destination);
	})
	
/*
	$('.delBTN, .editBtn').click(function(e){
		e.stopPropagation();
	})
*/
	
	$("#addCategorieButton").click(function(){
		$('#configCat').submit();
	})
	$('#configCat').submit(function(e) {
		//e.preventDefault();
		//alert('ok');
		var formData = new FormData($(this)[0]);
		//alert($('#addCat').val())
		
		var nameByLanguage = new Array();
		
		$(".name-cat").each(function(){
			var language = $(this).attr('data-lang');
			nameByLanguage.language = $(this).val();
		})
		
		formData.append("addCat", nameByLanguage);
		formData.append("idCtg", $('#idCtg').val());
		formData.append("laID", $('#laID').val());
		formData.append("descCat", $('#descCat').val());
		formData.append("imgCat", $('#imgCat')[0].files[0]);
		
		//formData.append("addCat", "OK");
		console.log(formData);
		//var key = e.which;
		//if (key == 13) {
			
			

            // Envoi de la requête HTTP en mode asynchrone
				
				
			
			
		//}
	})


})

tinymce.init({
	selector: ".wysiwyg",
	language : 'fr_FR',
	height: "200px",
	menubar: false,
	skin: "test",
		content_style: "*{font-family: 'Roboto', sans-serif; font-size: 14px}",
		font_formats: "Roboto (défaut)=Roboto, sans-serif;"+"Andale Mono=andale mono,times;"+ "Arial=arial,helvetica,sans-serif;"+ "Arial Black=arial black,avant garde;"+ "Book Antiqua=book antiqua,palatino;"+ "Comic Sans MS=comic sans ms,sans-serif;"+ "Courier New=courier new,courier;"+ "Georgia=georgia,palatino;"+ "Helvetica=helvetica;"+ "Impact=impact,chicago;"+ "Symbol=symbol;"+ "Tahoma=tahoma,arial,helvetica,sans-serif;"+ "Terminal=terminal,monaco;"+ "Times New Roman=times new roman,times;"+ "Trebuchet MS=trebuchet ms,geneva;"+ "Verdana=verdana,geneva;"+ "Webdings=webdings;"+ "Wingdings=wingdings,zapf dingbats",
		fontsize_formats: "8px 10px 12px 14px 18px 24px 36px",
	relative_urls : false,
	plugins: "paste code jbimages colorpicker textcolor fullscreen table link contextmenu media preview", 
	toolbar: "mybutton | code | jbimages undo redo | link backcolor forecolor | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table | fontsizeselect | media | fullscreen | fontselect",
		contextmenu: "link jbimages inserttable | cell row column deletetable | formats",
});


$('#myTabs a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
})

