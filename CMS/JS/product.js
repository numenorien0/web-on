$(function(){
	//prependTo = dedans (au début)
	//appendTo = dedans
	//insertBefore = avant
	//insertAfter = après
	
	$('.btn_lang').removeClass("active");
	$('span[data-lang=fr]').addClass("active");
	$('span[data-lang=fr]').text("Français");
	if ( $('.photo-container').children().length >= 1 ) {
				$("h2.labelDragDrop").hide();
	}
	
	var valeurInit = $('.js-example-basic-multiple').val()
	
	$('.js-example-basic-multiple').change(function(){
		var valeur = $(this).val();
/*
		if(jQuery.inArray("tous", valeur) == -1)
		{
			//alert("ok")
			$('.js-example-basic-multiple option[value=tous]').removeAttr('selected')
		}
*/
		//alert(valeur)
		
		if(jQuery.inArray("tous", valeurInit) == -1 && jQuery.inArray("tous", valeur) != -1)
		{
			$('.js-example-basic-multiple option').removeAttr('selected')
			$('.js-example-basic-multiple option[value=tous]').prop('selected', 'selected')
		}
		
		if(jQuery.inArray("tous", valeurInit) != -1 && (jQuery.inArray("recherche", valeur) != -1 || jQuery.inArray("lien", valeur) != -1 || jQuery.inArray("catalogue", valeur) != -1))
		{
			$('.js-example-basic-multiple option[value=tous]').removeAttr('selected')
		}
		
		
		
		if(jQuery.inArray("recherche", valeur) != -1 && jQuery.inArray("lien", valeur) != -1 && jQuery.inArray("catalogue", valeur) != -1)
		{
			$('.js-example-basic-multiple option').removeAttr('selected')
			$('.js-example-basic-multiple option[value=tous]').prop('selected', 'selected')
		}
		
		if(valeur == null)
		{
			$('.js-example-basic-multiple option[value=tous]').prop('selected', 'selected')
		}
		
		valeurInit = $('.js-example-basic-multiple').val()
	})
	
	$('.lang').hide()
	
	
	$('div#description-sm-fr').show()
	$('div#nom-fr').show()
	$('div#description-lg-fr').show()
	
	$('.btn_lang').click(function(e){
		e.preventDefault();
		$('.lang').hide();
		var celuila = $('.btn_lang.active').attr('data-lang');
		$('.btn_lang.active').text(celuila);
		$('.btn_lang').removeClass("active");
		
		var lang = $(this).attr('data-lang')
		var langue = $(this).attr('data-lang-name');

		$('div#nom-'+lang).show()
		$('div#description-sm-'+lang).show()
		$('div#description-lg-'+lang).show()
		var addVar = $('.tab-pane.active').attr('data-variation');
		var id = $('.id-'+addVar).val();
		
		$('div#description-sm-'+addVar+'-'+lang).show()
		$('div#description-lg-'+addVar+'-'+lang).show()
		if(id && lang == 'fr')
		{
			$('div#trad-'+addVar+'-fr').show()
		}
		if(lang != 'fr')
		{
			$('div#trad-'+addVar+'-'+lang).show()
		}
		
		
		$('span[data-lang='+lang+']').text(langue);
		$('span[data-lang='+lang+']').addClass("active");
		
		
		
	})
	

/*
	$('.btn_lang').click(function(){
		var addVar = $('.tab-pane.active').attr('data-variation');
		//alert(addVar);
		$('.lang').hide()
		var lang = $(this).attr('data-lang')
		//alert(lang)
		$('div#nom-'+lang).show()
		$('div#description-sm-'+addVar+'-'+lang).show()
		$('div#description-lg-'+addVar+'-'+lang).show()
	})
*/
	
	$('.tab-pane:first-child').addClass("active");
	$('li[role=presentation]:first-child').addClass("active");
	var nameTab = $('.tab-pane.active').attr('data-variation')
	$('div#description-sm-'+nameTab+'-fr').show()
	$('div#description-lg-'+nameTab+'-fr').show()
	
	var addVar = $('.tab-pane.active').attr('data-variation');
	var id = $('.id-'+addVar).val();
	//alert(id)
	if(id != '')
	{
		$('div#trad-'+addVar+'-fr').show()
	}
	
	$('#valider').click(function(e){
		//e.preventDefault();
		
		
		$('.blackScreen').fadeIn().css({"display":"flex"});
		$('<div style="margin: auto; color:#fff; text-align:center;"><i style="margin-bottom:10px;" class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i><br /><h3 style="color:#fff; text-align:center;">Chargement des fichers</div>').appendTo(".blackScreen");
		//LOADER IMG
		//$('<div style="margin: auto"><img src="images/ecommerce/loader.gif" style="height: 200px"/><br /><h3 style="color:#fff; text-align:center;">Chargement des fichers</div>').appendTo(".blackScreen");

		//$('#formulaireProduit').submit();
	})
	
	var u = 0;
	$('.mediaPreview').click(function(){
		if($(this).hasClass( "selectedImage" )){
			$(this).removeClass( "selectedImage" );
			var dataimg = $(this).attr('data-photo');
			
			$(".photoPreview[data-photo='"+dataimg+"']").remove();
			if ( $('.photo-container').children().length < 1 ) {
				$("h2.labelDragDrop").show();
			}
		}else{
			
			u = $(".photoPreview").length + 1 ;
			var addVarImg = $( "li.active a" ).attr( "aria-controls" );
			//alert(addVarImg);
			$(this).addClass( "selectedImage" );
			$("h2.labelDragDrop").hide();
			var dataPh = $(this).attr('data-photo');
			var nomVar = $('.tab-pane.active').attr('data-variation')
			var selectType = $('#type').val();

			if(selectType == "variable")
			{
				var insertImg ="<div class='photoPreview col-md-3 del-"+u+"' data-photo='"+dataPh+"'style='display: block; margin: 10px 5px 0 5px; height: 100px; width: 100px; background-repeat: no-repeat; background-size: cover; background-position: center; background-image:url(\"content/products/"+dataPh+"\"); border:solid 1px #ddd;'><input type='hidden' name='mediasMultiple["+nomVar+"][]' value='"+dataPh+"'><img style='position: absolute; margin-left: 70px; margin-top: -10px; cursor:pointer;' class='supp-img' id='del-"+u+"' src='images/error.png'></div>"
				$(insertImg).appendTo('.photo-container-'+addVarImg);
			}
			if(selectType == "unique")
			{

				var insertImg ="<div class='photoPreview col-md-3 del-"+u+"' data-photo='"+dataPh+"'style='display: block; margin: 10px 5px 0 5px; height: 100px; width: 100px; background-repeat: no-repeat; background-size: cover; background-position: center; background-image:url(\"content/products/"+dataPh+"\"); border:solid 1px #ddd;'><input type='hidden' name='mediasMultiple[]' value='"+dataPh+"'><img style='position: absolute; margin-left: 70px; margin-top: -10px; cursor:pointer;' class='supp-img' id='del-"+u+"' src='images/error.png'></div>"
				$(insertImg).appendTo('.photo-container-');
			}
			
			if(selectType == "telechargeable")
			{
				var insertImg ="<div class='photoPreview col-md-3 del-"+u+"' data-photo='"+dataPh+"'style='display: block; margin: 10px 5px 0 5px; height: 100px; width: 100px; background-repeat: no-repeat; background-size: cover; background-position: center; background-image:url(\"content/products/"+dataPh+"\"); border:solid 1px #ddd;'><input type='hidden' name='mediasMultiple_tele[]' value='"+dataPh+"'><img style='position: absolute; margin-left: 70px; margin-top: -10px; cursor:pointer;' class='supp-img' id='del-"+u+"' src='images/error.png'></div>"
				$(insertImg).appendTo('.photo-container-telechargeable');
			}
			
		}
		
	})
	
	

	function readURL(input) {
	
			//alert(input.)
		$.each(input.files, function(i, v){
			var reader = new FileReader();
			console.log(v);
			reader.onload = function (e) {
				u = $(".photoPreview").length + 1 ;
				var selectType = $('#type').val();
				var addVarImg = $( "li.active a" ).attr( "aria-controls" );
				var nameVar = $('.tab-pane.active').attr('data-variation')

				if(selectType == "variable")
				{
					var photoPreview = "<div class='photoPreview del-"+u+" col-md-3' style='display: block; margin: 10px 5px 0 5px; height: 100px; width: 100px; background-repeat: no-repeat; background-size: cover; background-position: center; background-image:url(\""+e.target.result+"\"); border:solid 1px #ddd;'><input type='hidden' name='photoMultiple["+nameVar+"][]' value='"+e.target.result+"'><img style='position: absolute; margin-left: 70px; margin-top: -10px; cursor:pointer;' class='supp-img' id='del-"+u+"' src='images/error.png'></div>";
					$(photoPreview).appendTo('.photo-container-'+addVarImg);
				}
				
				if(selectType == "unique")
				{
					var photoPreview = "<div class='photoPreview del-"+u+" col-md-3' style='display: block; margin: 10px 5px 0 5px; height: 100px; width: 100px; background-repeat: no-repeat; background-size: cover; background-position: center; background-image:url(\""+e.target.result+"\"); border:solid 1px #ddd;'><input type='hidden' name='photoMultiple[]' value='"+e.target.result+"'><img style='position: absolute; margin-left: 70px; margin-top: -10px; cursor:pointer;' class='supp-img' id='del-"+u+"' src='images/error.png'></div>";
					$(photoPreview).appendTo('.photo-container-');
				}
				
				if(selectType == "telechargeable")
				{
					var photoPreview = "<div class='photoPreview del-"+u+" col-md-3' style='display: block; margin: 10px 5px 0 5px; height: 100px; width: 100px; background-repeat: no-repeat; background-size: cover; background-position: center; background-image:url(\""+e.target.result+"\"); border:solid 1px #ddd;'><input type='hidden' name='photoMultiple_tele[]' value='"+e.target.result+"'><img style='position: absolute; margin-left: 70px; margin-top: -10px; cursor:pointer;' class='supp-img' id='del-"+u+"' src='images/error.png'></div>";
					$(photoPreview).appendTo('.photo-container-telechargeable');
				}
				//$(input).insertBefore("li[role=presentation]:last-child");
				//$('.photoPreview').css('background-image', 'url('+e.target.result+')');
			}
			
			reader.readAsDataURL(input.files[i]);			
		})	
/*
		if (input.files && input.files[0]) {

		}
*/
	}
	
	function readURLDrop(input) {
	
			//alert(input.)
		$.each(input, function(i, v){
			console.log(v);
			var reader = new FileReader();
			
			reader.onload = function (e) {
				u = $(".photoPreview").length + 1;
				var selectType = $('#type').val();
				var nameVar = $('.tab-pane.active').attr('data-variation')
				var addVarImg = $( "li.active a" ).attr( "aria-controls" );
				if(selectType == "variable")
				{
					var photoPreview = "<div class='photoPreview del-"+u+" col-md-3' style='display: block; margin: 10px 5px 0 5px; height: 100px; width: 100px; background-repeat: no-repeat; background-size: cover; background-position: center; background-image:url(\""+e.target.result+"\"); border:solid 1px #ddd;'><input type='hidden' name='photoMultiple["+nameVar+"][]' value='"+e.target.result+"'><img style='position: absolute; margin-left: 70px; margin-top: -10px; cursor:pointer;' class='supp-img' id='del-"+u+"' src='images/error.png'></div>";
					$(photoPreview).appendTo('.photo-container-'+addVarImg);
				}
				
				if(selectType == "unique")
				{
					var photoPreview = "<div class='photoPreview del-"+u+" col-md-3' style='display: block; margin: 10px 5px 0 5px; height: 100px; width: 100px; background-repeat: no-repeat; background-size: cover; background-position: center; background-image:url(\""+e.target.result+"\"); border:solid 1px #ddd;'><input type='hidden' name='photoMultiple[]' value='"+e.target.result+"'><img style='position: absolute; margin-left: 70px; margin-top: -10px; cursor:pointer;' class='supp-img' id='del-"+u+"' src='images/error.png'></div>";
					$(photoPreview).appendTo('.photo-container-');
				}
				
				if(selectType == "telechargeable")
				{
					var photoPreview = "<div class='photoPreview del-"+u+" col-md-3' style='display: block; margin: 10px 5px 0 5px; height: 100px; width: 100px; background-repeat: no-repeat; background-size: cover; background-position: center; background-image:url(\""+e.target.result+"\"); border:solid 1px #ddd;'><input type='hidden' name='photoMultiple_tele[]' value='"+e.target.result+"'><img style='position: absolute; margin-left: 70px; margin-top: -10px; cursor:pointer;' class='supp-img' id='del-"+u+"' src='images/error.png'></div>";
					$(photoPreview).appendTo('.photo-container-telechargeable');
				}
				//$(input).insertBefore("li[role=presentation]:last-child");
				//$('.photoPreview').css('background-image', 'url('+e.target.result+')');
			}
			
			reader.readAsDataURL(input[i]);			
		})	
/*
		if (input.files && input.files[0]) {

		}
*/
	}
	
	$(document).on('dragenter', '.photoDisplay', function() {
            $(this).css('border', '3px dashed red');
            return false;
	});
 
	$(document).on('dragover', '.photoDisplay', function(e){
	            e.preventDefault();
	            e.stopPropagation();
	            $(this).css('border', '3px dashed red');
	            return false;
	});
	 
	$(document).on('dragleave', '.photoDisplay', function(e) {
	            e.preventDefault();
	            e.stopPropagation();
	            $(this).css('border', '3px dashed #BBBBBB');
	            return false;
	});
	
	var fichier;
	//var i = 0;
	var nombreFichier;
	
	$(document).on('drop', '.photoDisplay', function(e) {
	            if(e.originalEvent.dataTransfer){
	                       if(e.originalEvent.dataTransfer.files.length) {
	                                   // Stop the propagation of the event
	                                   nombreFichier = e.originalEvent.dataTransfer.files.length;
	
	                                   e.preventDefault();
	                                   e.stopPropagation();
	                                   $(this).css('border', '3px dashed green');
	                                   // Main function to upload
	                                   fichier = e.originalEvent.dataTransfer.files;
	                                   console.log(fichier);
	                                   readURLDrop(fichier);
	                       }  
	            }
	            else {
	                       $(this).css('border', '3px dashed #BBBBBB');
	            }
	            return false;
	});
		
		$('#wrapper').on("click", '.supp-img', function(){
			var ID = $(this).attr('id');
	
			$( "."+ID ).remove();
		});
		
		
		
		$('#file_btn').click(function(){
			$('#file').click();
			$("#file").change(function(){
				//alert($(this).val());
				readURL(this);
				
			});
		})
		
		$('#file_btn_tele').click(function(){
			$('#file_tele').click();
			$("#file_tele").change(function(){
				//alert($(this).val());
				var nombre = $(this).get(0).files;
				$('#file_btn_tele').val(nombre.length+" fichier(s) chargé(s)");
				
			});
		})
		
		$('#file_btn_img_tele').click(function(){
			$('#file_img_tele').click();
			$("#file_img_tele").change(function(){
				//alert($(this).val());
				readURL(this);
				
			});
		})
		

		$('.file_btn').click(function(){
			var inputHidden = $('.tab-pane.active').attr('data-variation');
			$('#file_'+inputHidden).click();
			$("#file_"+inputHidden).change(function(){
				readURL(this);
				//alert($(this).val());
			});
		})
		
		$('#previsualisation_btn_tele').click(function(){
			$('#previsualisation_tele').click();
			$("#previsualisation_tele").change(function(){
				//alert($(this).val());
				var nombre = $(this).get(0).files;
				$('#previsualisation_btn_tele').val(nombre.length+" fichier chargé");
				
			});
		})
		
		
		
		$('.arborescence').each(function(){
			if($(this).attr('data-parent') != "0")
			{
				$(this).hide();
			}
		})
		$('.arborescence').click(function(){
			
			//$(this).addClass("");
			var ID = $(this).attr('data-id');
			var parent = $(this).attr('data-parent');
			
			$('#hideID').val(parent);
			$('.arborescence').hide();
			//redraw("#categories");
			$('.arborescence[data-parent='+ID+']').show();
			$('#idCtg').val(ID);
	
		})
	
	

	$('.bnt').click(function(e){
		e.stopPropagation();
		var ID = $(this).attr('data-id');
		var parent = $(this).attr('data-parent');
		if(!$('input#'+ID).attr("checked"))
		{
			$('input#'+ID).prop('checked', 'checked');
			$('.arborescence[data-id='+ID+']').addClass("selectedCategory");
			$(this).addClass("selectedButton");
			$(this).removeClass("button-add");
			$(this).val("Sélectionnée");
			redraw("#categories");
		}
		else
		{
			$('input#'+ID).removeAttr('checked');
			$('.arborescence[data-id='+ID+']').removeClass("selectedCategory");
			$(this).removeClass("selectedButton");
			$(this).addClass("button-add");
			$(this).val("Sélectionner");
			redraw("#categories");
		}
		
	})	

	//$('#listeCategory').jstree();	
	
		
		
		
	$('.retour').click(function(){
		var destination = $('#hideID').val();
		var parValue = $('.arborescence[data-id='+destination+']').attr('data-parent');
		
		$('.arborescence').hide();
		
		$('.arborescence[data-parent='+destination+']').show();
		
		$('#hideID').val(parValue);
		$('#idCtg').val(destination);
	})		
	
	$('#addCat').keydown(function(e) {
		var key = e.which;
		if (key == 13) {
			
			e.preventDefault();

            // Envoi de la requête HTTP en mode asynchrone
		    $.ajax({
		    	url: "product.php", // Le nom du fichier indiqué dans le formulaire
		        type: "POST", // La méthode indiquée dans le formulaire (get ou post)
		        data: {
			    	addCat: $('#addCat').val(),
			    	idCtg: $('#idCtg').val(),
			    	laID: $('#laID').val()
			    } // Je sérialise les données (j'envoie toutes les valeurs présentes dans le formulaire)
		    }).done(function(html){
			    
			   var idParCtg = $('#idCtg').val();
			   var newCat = "<div class='arborescence col-sm-12 visiblePage' data-id='"+$('#laID').val()+"' data-parent='"+$('#idCtg').val()+"'><span class='col-sm-10 nomCategory'>"+$('#addCat').val()+"</span><input data-id='"+$('#laID').val()+"' data-parent='"+$('#idCtg').val()+"'class='bnt' type='button' value='Sélectionner'/><span class='hidden'><input id='"+$('#laID').val()+"'type='checkbox' value='"+$('#laID').val()+"' name='categories[]'></span></div>";
			   //var newCat= "<div class='col-sm-12' data-parent='"+idParCtg+"'><label class='col-sm-9 col-md-9' for='commentaire'>"+$('#addCat').val()+"</label><input type='checkbox' class='categories_input' id=''name='categories' data-parent='' ></div>";
				$(newCat).appendTo(".listeCategory");	
				redraw("#categories");
				$('#addCat').val("");
				
				$('.bnt').click(function(e){
					e.stopPropagation();
					var ID = $(this).attr('data-id');
					var parent = $(this).attr('data-parent');
					if(!$('input#'+ID).attr("checked"))
		{
			$('input#'+ID).prop('checked', 'checked');
			$('.arborescence[data-id='+ID+']').addClass("selectedCategory");
			$(this).addClass("selectedButton");
			$(this).removeClass("button-add");
			$(this).val("Sélectionnée");
			redraw("#categories");
		}
		else
		{
			$('input#'+ID).removeAttr('checked');
			$('.arborescence[data-id='+ID+']').removeClass("selectedCategory");
			$(this).removeClass("selectedButton");
			$(this).addClass("button-add");
			$(this).val("Sélectionner");
			redraw("#categories");
		}
		
				})					
				
			})
			
		}
	})

	
	$(".js-example-tags").select2({
	  tags: true
	})
	
	$( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();
    
    $( "#selectable" ).selectable();
	
	$(".js-example-basic-multiple").select2();


	function redraw(location)
	{
		$(location+' input[type=checkbox]').next(".switchery").remove();
		var elems = Array.prototype.slice.call($(location+' input[type=checkbox]'));
		
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
	

	function recursive(parent)
	{
		
		var ID = $('.categories_input_child[data-childOf='+parent+']').attr('data-parent');
		$('.col-sm-12[data-childOf='+parent+']').remove();
		if($('.col-sm-12[data-childOf='+ID+']').length)
		{
			recursive(ID);
		}
	}	
	
	function recursiveCheckBox(element)
	{
		var element = $(element).parent("li").parent("ul").prev().prev(".oldCheckbox");
		$(element).prop("checked", "checked");
		if($(element).attr('data-level') != "0")
		{
			recursiveCheckBox(element);
		}
	}
	
	$('.oldCheckbox').change(function(){
		if($(this).is(":checked"))
		{
			recursiveCheckBox($(this));
		}
	})
	
	$('#addOnglet').click(function(e){
		e.preventDefault();
		$('.btn_lang').removeClass("active");
		$(this).hide();
		var input = "<li role='presentation' id='inputTab'><form id='monForm' action='product.php' method='POST'><input id='addVar' placeholder='Nouvelle variation' type='text' name='addVar'/><input type='submit' id='envoyer' value='Envoyer' class='hidden' name='addVar'/></form></li>";
		$(input).insertBefore("li[role=presentation]:last-child");
		$('#monForm').keydown(function(e) {
			var key = e.which;
			if (key == 13) {
				// As ASCII code for ENTER key is "13"
			    $('#monForm').submit(function(e) {
				    $('#addOnglet').show();
			        e.preventDefault(); // J'empêche le comportement par défaut du navigateur, c-à-d de soumettre le formulaire
			        var $this = $(this); // L'objet jQuery du formulaire
			        // Je récupère les valeurs
			        var addVar = $('#addVar').val();
			 
			        // Je vérifie une première fois pour ne pas lancer la requête HTTP
			        // si je sais que mon PHP renverra une erreur
			        if(addVar === '') {
			            alert('Les champs doivent êtres remplis');
			        }
			        else
			        {
	            // Envoi de la requête HTTP en mode asynchrone
			            $.ajax({
			                url: "ajax/"+$this.attr('action'), // Le nom du fichier indiqué dans le formulaire
			                type: $this.attr('method'), // La méthode indiquée dans le formulaire (get ou post)
			                data: $this.serialize() // Je sérialise les données (j'envoie toutes les valeurs présentes dans le formulaire)
			                //dataType: 'json', // JSON
	            	}
				)
		            .done(function(html){
			            var idNum = 0;
			            $('li[role=presentation]').removeClass('active');
			            $('.tab-pane').removeClass('active');		
						var  onglet= "<li role='presentation' class='active'><a href='#' aria-controls='"+$('#addVar').val()+"' role='tab' data-toggle='tab'>"+$('#addVar').val()+"</a></li>";
						$(onglet).insertBefore("li#inputTab");	
						
						$.ajax({
							url: "ajax/FormulaireVariable.php",
							type: "POST",
							data: {
								addVar: $("#addVar").val()
							}
						})
						.done(function(html){
							$(html).appendTo("#formVariable");
							$('#formVariable .btn_lang').remove();
							
							$('.lang').hide()
							$('div#nom-fr').show()
							$('div#description-sm-'+$('#addVar').val()+'-fr').show()
							$('div#description-lg-'+$('#addVar').val()+'-fr').show()
							
							$(".js-example-tags").select2({
							  tags: true
							})
							$('#file_btn_'+addVar).click(function(){
								$('#file_'+addVar).click();
							})
							
							$("#file_"+addVar).change(function(){
								readURL(this);
								//alert($(this).val());
							});
							var u = 0;
							$('.mediaPreview-'+addVar).click(function(){
								if($(this).hasClass( "selectedImage" )){
									$(this).removeClass( "selectedImage" );
									var dataimg = $(this).attr('data-photo');
									
									$(".photoPreview-"+addVar+"[data-photo='"+dataimg+"']").remove();
									if ( $('.photo-container').children().length < 1 ) {
										$("h2.labelDragDrop-"+addVar).show();
									}
								}else{
									
									u = $(".photoPreview").length + 1 ;
									$(this).addClass( "selectedImage" );
									$("h2.labelDragDrop").hide();
									var dataPh = $(this).attr('data-photo');
									var insertImg ="<div class='photoPreview-"+addVar+" col-md-3 del-"+u+"' data-photo='"+dataPh+"'style='display: block; margin: 10px 5px 0 5px; height: 100px; width: 100px; background-repeat: no-repeat; background-size: cover; background-position: center; background-image:url(\"content/products/"+dataPh+"\"); border:solid 1px #ddd;'><input type='hidden' name='mediasMultiple["+addVar+"][]' value='"+dataPh+"'><img style='position: absolute; margin-left: 70px; margin-top: -10px; cursor:pointer;' class='supp-img' id='del-"+u+"' src='images/error.png'></div>"
									$(insertImg).appendTo('.photo-container-'+addVar);
									if ( $('.photo-container-'+addVar).children().length >= 1 ) {
										$("h2.labelDragDrop-"+addVar).hide();
									}
								}
								
							})
							
							redraw("#wrapper");
							
							$('#inputTab').remove();
							
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
						  	
						  	
					  	
						  	
						  							
						})			
					})
	        	}
			});
				
		}
	});	
		
});
	
	
	$(document).on('click', 'li[role=presentation]', function(){
		$('.tab-pane').removeClass("active");
		var cible = $(this).children("a").attr('aria-controls');
		$('.btn_lang').removeClass("active");
		$('span[data-lang=fr]').addClass("active");
		var nameTab = $(this).children("a").text();
		$("#"+cible).addClass("active");
		$('.lang').hide();
		$('div#nom-fr').show()
		$('div#description-sm-'+nameTab+'-fr').show()
		$('div#description-lg-'+nameTab+'-fr').show()	
	})	
	
	
	
	$('#type').change(function(){
		var selected = $(this).val();
		$('.blockFormulaire').hide();
		$("#"+selected).show();
	})
	
	var selected = $('#type').val();
	$('.blockFormulaire').hide();
	$("#"+selected).show();
	
	$(".listeCategory li").each(function(){
		if($(this).attr("data-level") != "0")
		{
			$(this).parent("ul").hide();
			
		}
	});
	
	$(".listeCategory li a").click(function(){
		$(this).parent().children("ul").toggle();
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
	
	$('.listeCategory .switchery').remove();
		
});
