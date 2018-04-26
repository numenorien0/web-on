$(function(){
	$(".nextMove").click(function() {
		alert("ok");
	});
	
    	$('#tabPromo').DataTable({
	    	"language": {
				"url": "https://cdn.datatables.net/plug-ins/1.10.13/i18n/French.json"
			}
    	});

	var valeurInit = $('.js-example-basic-multiple.produit').val()
	
	$('.js-example-basic-multiple.produit').change(function(){
		var valeur = $(this).val();
		
		if(jQuery.inArray("tous", valeurInit) == -1 && jQuery.inArray("tous", valeur) != -1)
		{
			$('.js-example-basic-multiple.produit option').removeAttr('selected')
			$('.js-example-basic-multiple.produit option[value=tous]').prop('selected', 'selected')
		}
		
		if(jQuery.inArray("tous", valeurInit) != -1 && valeur.length > 1)
		{
			$('.js-example-basic-multiple.produit option[value=tous]').removeAttr('selected')
		}
		
		
		if(valeur == null)
		{
			$('.js-example-basic-multiple.produit option[value=tous]').prop('selected', 'selected')
		}
		
		valeurInit = $('.js-example-basic-multiple.produit').val()
	})
	
	var valeurInitial = $('.js-example-basic-multiple.client').val()
	
	$('.js-example-basic-multiple.client').change(function(){
		var valeurC = $(this).val();
		
		if(jQuery.inArray("tous", valeurInitial) == -1 && jQuery.inArray("tous", valeurC) != -1)
		{
			$('.js-example-basic-multiple.client option').removeAttr('selected')
			$('.js-example-basic-multiple.client option[value=tous]').prop('selected', 'selected')
		}
		
		if(jQuery.inArray("tous", valeurInitial) != -1 && valeurC.length > 1)
		{
			$('.js-example-basic-multiple.client option[value=tous]').removeAttr('selected')
		}
		
		
		if(valeurC == null)
		{
			$('.js-example-basic-multiple.client option[value=tous]').prop('selected', 'selected')
		}
		
		valeurInitial = $('.js-example-basic-multiple.client').val()
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
  	
  	$(".js-example-basic-multiple").select2();
})