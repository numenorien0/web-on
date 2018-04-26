$(function(){
	
	$('.blackScreen').click(function(){
		removePopup();
	})
    
    $('.addImage').click(function(){
        
        imageLibrary($(this), $(this).attr('data-preview'));
    })	    
    
    function showPopup()
	{
		$('.popup, .blackScreen').fadeIn();
		//$('.body').css({"filter":"blur(10px)"})
	}
	
	function removePopup()
	{
		$('.popup, .blackScreen').fadeOut();
		//$('.body').css({"filter":"blur(0px)"})
	}
	
	$('.deleteImage').click(function(){
	    $('#votre_image').val("");
	    
	    $("#imagePrev").html("");
	})
	
	$('.fichierSelect').select2({
	    dropdownParent: $('.listFichiers')
	});
	
	$('.shortcode').select2({
	    dropdownParent: $('.allShortcode')
	});
	
	function imageLibrary(elem, preview)
	{
	    var images = new Object();
	    $('.popup').html("<iframe src='medias.php' style='height: 100%; width: 100%;'></iframe>");
			var src;
			$('.popup iframe').on('load', function(){
				$(this).contents().on('click', '.imageLibrary', function(){
					
				});
				var iframe = $(this);
				$(this).contents().on("click", "#insertImage", function(){
					//var imageArray = new Array();
					$( ".selectimageContainer" ).sortable({
						placeholder: "ui-state-highlight"
					});
					
					//$("#votre_image").val("");
					
					$('.popup iframe').contents().find(".imageLibrary.selected").each(function(){
						
						
						if($(this).attr('data-parent') == "")
						{
							var ID = $(this).attr('data-id');
						}
						else
						{
							var ID = $(this).attr('data-parent');
						}
						
						var v;
						var alt;
						
						$.ajax({
							url: "ajax/photo_upload.php",
							dataType: "json",
							data: {
								action: "file_details",
								ID: ID
							}
						}).done(function(json){
							//console.log(json);
							var type = $(iframe).contents().find('.imageType').val();
							v = $(iframe).contents().find('.activeLang').attr('data-tab');
							console.log(json[type]);
							src = json[type].file;
							//alert(src);
							alt = parseJSONresponse(json[type].alt, v);
							if(!json[type].parent)
							{
							    var parent = json[type].ID;
							}
							else
							{
							    var parent = json[type].parent;
							}
							parent = src;
							$(elem).next('input').val(parent);
						    if(type == "video")
                	        {
                           		$("."+preview).html("<video autoplay muted loop width='33%' style='margin-left: 17%' src='"+src+"'></video>");
                		   	}
                		   	else
                		   	{
                			   	$("."+preview).html("<div class='col-sm-4 col-sm-offset-2'><img style='margin-top: 15px; margin-bottom: 15px; max-height: 100px' src='"+src+"'></div>");
                		   	}
							//images.push(json[type].parent);
							//$('.selectimageContainer').append("<div data-id='"+json[type].ID+"' class='imageSelectionnee' style='width: 100px; height: 100px; background: url("+src+"); background-position: center; background-size: cover; float: left; margin: 5px;'></div>");
							//editor[which].clipboard.dangerouslyPasteHTML(index, '<img src="'+src+'" alt="'+alt+'" />');
							
						});
						
						
						//imageArray.push($(this).attr('data-src'));
					});
					
					
					
					console.log(images);
					//$("#votre_image").val(images.join(";"));
					removePopup();
					//
				})
			})
			
			showPopup();
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	var titre = $("h2 .container .h2titre").text();
	
	$.datetimepicker.setLocale('fr');
    $("input[type=datetime]").datetimepicker({
	    format: 'Y-m-d H:i'
    });
	
	
	
	
	
	
	
	
	
	
	if(window.frameElement)
	{
		$('#menu').hide();
		//$('#onvousaide').hide();
		$('#wrapper').css({"width": "100%"});
	}
	else
	{
		$('#wrapper').scroll(function(){
			if($(window).width() < 1400)
			{
				if($(this).scrollTop() > 50)
				{
					//$('#onvousaide').stop().fadeOut();
				}
				else
				{
					//$("#onvousaide").stop().fadeIn();
				}
			}
		})
	}
	$('.filter_miniatures').click(function(){
		var filter = $(this).attr('data-filter');
		$('.wireframe_miniatures').parent().hide();
		$(".filter_miniatures").removeClass("active");
		$(this).addClass("active");
		$('div[data-filter=filter-'+filter+']').show();
		if(!$(this).attr("data-filter"))
		{
			$('.wireframe_miniatures').parent().show();
		}
	})
	
	$('#onvousaide').click(function(e){
		e.stopPropagation();
		$.ajax({
			url: "help/"+$('#page').val().replace(".php", ".html")
		}).done(function(html){
			$('#infowindow').html(html);
		})
		$('#infowindow').animate({"left":"0%"}, 500);
		$('#infowindow').click(function(e){
			e.stopPropagation();
		})
		$("html").click(function(){
			$('#infowindow').animate({"left":"-20%"}, 500);
		})
	})
	
	
	var from = $('.btn_lang').first().attr('data-lang');
	$(".colorPicker").spectrum({
	    allowEmpty: true,
    	showAlpha: true,
	    showInput: true,
	    preferredFormat: "rgb"
	});

	$('.preview').on('click', function(e){
		e.preventDefault();
		var nom = $('.nameField').eq(0).val();
		var description = $('.descriptionField').eq(0).val();
		var texte = tinyMCE.get('wysiwyg-'+from).getContent();
		var ID = $('#ID').val();

		if($("#imagePrev div img").length == 0)
		{
			var image = $("#imagePrev img").attr('src');
		}
		else
		{
			var image = $("#imagePrev div img").attr('src');
		}
		
		
		var page = $('#display').val();
		
		
		//alert(nom + description + texte + " " + image);


		$.post("preview.php",{nom: nom, description: description, image: image, texte: texte, page: page, ID: ID}).done(function(html){
			
		
			$("#preview").html("<div class='responsive'><img class='active agent' data-width='100%' src='images/responsive/desktop.png'/><img data-width='980px' class='agent' src='images/responsive/tablet.png'/><img class='agent' data-width='420px' src='images/responsive/phone.png'/></div><iframe src='preview.php' height='100%' width='100%'></iframe>");
			$("h2 .container .h2titre").html("<a class='backPreview' href='#'>&#8678; Retour</a> Aperçu de votre page");
			$("#formulaireGeneral").hide();
			$('#preview').show();
			$('#onvousaide').hide();
			//$('.blackScreen').fadeIn();
			$("#preview").click(function(e){
				e.stopPropagation();
			})

			$('.agent').click(function(){
				$('.agent').removeClass("active");
				$(this).addClass("active");
				
				var width = $(this).attr('data-width');
				
				$("#preview iframe").animate({"width":width}, 1000, "linear");
				
			})

			$(".backPreview").on('click', function(e){
				e.preventDefault();
				$("#preview").hide();
				$("#formulaireGeneral").show();
				$("h2 .container .h2titre").html(titre);
				$('#onvousaide').show();
				//$('.blackScreen').fadeOut();
			})	
			
		});
	
	
	})
	
	$('.demandTranslate').click(function(){
		
		var currentLang = $('.btn_lang.active').attr('data-lang');
		
		
		
		//alert("from:"+from+"to:"+currentLang);
		
		//pour le nom
		var nom = $('.name-'+from).val();
		
		$.ajax({
			url: "https://translate.yandex.net/api/v1.5/tr.json/translate",
			method: "POST",
			data: {key: "trnsl.1.1.20161119T170438Z.9dd752e92c368855.756b63a63f048233e0b1fd1165c12edf764624f3", text: nom, lang: currentLang}
		}).done(function(html){
			$('.name-'+currentLang).val(html.text[0]);
		})
		
		// pour la description

		var description = $('.description-'+from).val();
		
		$.ajax({
			url: "https://translate.yandex.net/api/v1.5/tr.json/translate",
			method: "POST",
			data: {key: "trnsl.1.1.20161119T170438Z.9dd752e92c368855.756b63a63f048233e0b1fd1165c12edf764624f3", text: description, lang: currentLang}
		}).done(function(html){
			$('.description-'+currentLang).val(html.text[0]);
		})
		
		// pour les liens
		
		var lien = $('.lien-'+from).val();
		
		$.ajax({
			url: "https://translate.yandex.net/api/v1.5/tr.json/translate",
			method: "POST",
			data: {key: "trnsl.1.1.20161119T170438Z.9dd752e92c368855.756b63a63f048233e0b1fd1165c12edf764624f3", text: lien, lang: currentLang}
		}).done(function(html){
			$('.lien-'+currentLang).val(html.text[0]);
		})		
		
		// pour le texte

		var texte = tinyMCE.get('wysiwyg-'+from).getContent();
		
		$.ajax({
			url: "https://translate.yandex.net/api/v1.5/tr.json/translate",
			method: "POST",
			data: {key: "trnsl.1.1.20161119T170438Z.9dd752e92c368855.756b63a63f048233e0b1fd1165c12edf764624f3", text: texte, lang: currentLang}
		}).done(function(html){
			console.log(html);
			tinyMCE.get('wysiwyg-'+currentLang).setContent(html.text[0]);
		})		

		//pour le SEO_description
		var SEO_description = $('.SEO_description-'+from).val();
		
		$.ajax({
			url: "https://translate.yandex.net/api/v1.5/tr.json/translate",
			method: "POST",
			data: {key: "trnsl.1.1.20161119T170438Z.9dd752e92c368855.756b63a63f048233e0b1fd1165c12edf764624f3", text: SEO_description, lang: currentLang}
		}).done(function(html){
			$('.SEO_description-'+currentLang).val(html.text[0]);
		})		
		
		
	})
	
	$('#custom-meta').click(function(){
		$('#custom-meta-field').toggle();
	})
	
	
	$('#changeWireframePage').click(function(e){
		e.stopPropagation();
		$('#wireframe').fadeIn();
		$('.blackScreen').fadeIn();
		
	});
	
	$('#changeWireframeMiniature').click(function(e){
		e.stopPropagation();
		$('#miniaturesChoice').fadeIn();
		$('.blackScreen').fadeIn();
	});	
	
	$('#wireframe .wireframe_page').click(function(){
		$('#wireframe .wireframe_page').removeClass("activeWireframe");
		$(this).addClass("activeWireframe");
		var id = $(this).attr('data-id');
		var image = $(this).children("img").attr('src');
		var description = $(this).children(".desc").text();
		$('#display').val(id);
		$('.wireframe_image').attr('src', image);
		$('.wireframe_description').text(description);
		$('.apercuContentPage').html("<img src='"+image+"' style='max-height: 100%; max-width: 100%;' />");
// 		alert($('.wireframe_image').attr('src'));

		
	})

	$('#miniaturesChoice .wireframe_miniatures').click(function(){
		//$('#miniaturesChoice').fadeOut();
		//$('.blackScreen').fadeOut();
		var id = $(this).attr('data-id');
		var image = $(this).children("img").attr('src');
		var description = $(this).children(".desc").text();
		$('#miniaturesChoice .wireframe_miniatures').removeClass("activeWireframe");
		$(this).addClass("activeWireframe");
		$('#miniatures').val(id);
		$('.miniatures_image').attr('src', image);
		$('.miniatures_description').text(description);
		$('.apercuContent').html("<img src='"+image+"' style='max-height: 100%; max-width: 100%;' />");
// 		alert($('.wireframe_image').attr('src'));

		$.ajax({
			url: "wireframes/Miniatures/"+id+"/code.template", 
		}).done(function(html){

/*
			txt = html;
			var style = "";
			var regex = /\<\?\=(.*)\?\>/g;
			var matches = [];
			var match = regex.exec(txt);
			while (match != null) {
			    matches.push(match[1]);
			    match = regex.exec(txt);
			    
			}
			var input;
*/
			var input;
			//champsPerso = matches;
			//console.log(matches)
			var match = /child\['champsPerso'\]\['[a-zA-Z]+'\]\['[a-zA-Z]+'\]/g, result, champsPerso = [];
			var style = "";
			console.log(champsPerso);
			//console.log(html.match(match));
/*
			while(result = html.match(match)) //match.exec(html)
			{
				
				champsPerso.push(result)
				//match.lastIndex -= result[0].length;
			}
*/
			var value = html.match(match)
			if(value != null)
			{			
			$.each(value, function(i, v){
				value = v.replace("child", "");
				var regex = /\['champsPerso'\]\['(.*)'\]\['(.*)'\]/g, resultat, champs = [];
				champs = regex.exec(value);
				champsPerso.push(champs);
			})
			console.log(champsPerso);

				style += "<div class='champsPerso'>";
				$.each(champsPerso, function(i, v){
					if(v[1] == "texte")
					{
						input = "<label class='labelLeft col-md-4'>"+v[2]+"&nbsp&nbsp</label><input type='text' value='' name=\"input["+v[1]+"]["+v[2]+"]\" class='col-sm-8'>";
					}
					if(v[1] == "map")
					{
						input = "<div class='mapContainer'><input type='button' value='Coordonnées' style='margin-top: 10px' class='col-sm-12 mapButton'><input type='hidden' value='' placeholder='glissez le marqueur pour déterminer une position géographique' name=\"input["+v[1]+"]["+v[2]+"]\" class='inputMap col-sm-12'><div style='' data-lat='' data-lng='' class='mapPicker col-sm-12'></div></div>";
					}
					if(v[1] == "textarea")
					{
						input = "<label class='labelLeft col-md-4'>"+v[2]+"&nbsp&nbsp</label><textarea name=\"input["+v[1]+"]["+v[2]+"]\" class='col-sm-8'></textarea>"
					}
					if(v[1] == "color")
					{
						input = "<label class='labelLeft col-md-4'>"+v[2]+"&nbsp&nbsp</label><input type='color' value='' name=\"input["+v[1]+"]["+v[2]+"]\" class='col-sm-8'>";
					}
					if(v[1] == "datetime")
					{
						input = "<label class='labelLeft col-md-4'>"+v[2]+"&nbsp&nbsp</label><input type='datetime' value='' name=\"input["+v[1]+"]["+v[2]+"]\" class='col-sm-8'>";
					}
					style += "<div class='col-sm-12'>"+input+"</div>";
					
				})
				
				style += "</div>";	
			}		
			
			
			if(html.indexOf("<?=$this->_child['style']['background']?>") != -1)
			{
				style += "<div class='styleInput col-sm-12'><label class='labelLeft col-md-6'>Arrière plan&nbsp&nbsp</label><input class='colorPicker' value='' type='text' name='style[background]'/></div>";
			}
			if(html.indexOf("<?=$this->_child['style']['background_cadre']?>") != -1)
			{
				style += "<div class='styleInput col-sm-12'><label class='labelLeft col-md-6'>Couleur du cadre&nbsp&nbsp</label><input class='colorPicker' value='' type='text' name='style[background_cadre]'/></div>";
			}
			if(html.indexOf("<?=$this->_child['style']['color']?>") != -1)
			{
				style += "<div class='styleInput col-sm-12'><label class='labelLeft col-md-6'>Couleur du texte&nbsp&nbsp</label><input class='colorPicker' value='' type='text' name='style[color]'/></div>";
			}
			if(html.indexOf("<?=$this->_child['style']['color_title']?>") != -1)
			{
				style += "<div class='styleInput col-sm-12'><label class='labelLeft col-md-6'>Couleur du titre&nbsp&nbsp</label><input class='colorPicker' value='' type='text' name='style[color_title]'/></div>";
			}
			
			
			
			style += "<div class='styleInput col-sm-12'><label class='labelLeft col-md-6'>Couleur du bouton&nbsp&nbsp</label><input class='colorPicker' value='' type='text' name='style[background_link]'/></div>";
			style += "<div class='styleInput col-sm-12'><label class='labelLeft col-md-6'>Couleur du texte du bouton &nbsp&nbsp</label><input class='colorPicker' value='' type='text' name='style[color_link]'/></div>";
			style += "<div class='styleInput col-sm-12'><label style='margin-top: 15px' class='labelLeft col-md-6'>Url du bouton &nbsp&nbsp</label><input class='' value='' type='text' name='style[url]'/></div>";
			//style += "<div class='col-sm-12'><label for='imposedStyle'>Appliquer ce style aux autres miniatures</label><input name='imposedStyle' type='checkbox'></div>";
			$('#styleContainer').html(style);
			$(".colorPicker").spectrum({
			    allowEmpty: true,
		    	showAlpha: true,
			    showInput: true,
			    preferredFormat: "rgb"
			});
			
			//$.datetimepicker.setLocale('fr');
		    $("input[type=datetime]").datetimepicker({
			    format: 'Y-m-d H:i'
		    });
		    
			$('.mapPicker').each(function(){
				var attr = $(this).attr('data-lat');
				if(attr != "")
				{
					$(this).parent(".mapContainer").children(".mapButton").val($(this).attr('data-lat') + ", " + $(this).attr('data-lng'));
					$(this).locationpicker({
						location: {latitude: $(this).attr('data-lat'), longitude: $(this).attr('data-lng')},
						radius: 50,
						zoom: 15,
						onchanged: function(currentLocation, radius, isMarkerDropped) {
							$(this).parent(".mapContainer").children(".inputMap").val(currentLocation.latitude + ", " + currentLocation.longitude);
							$(this).parent(".mapContainer").children(".mapButton").val(currentLocation.latitude + ", " + currentLocation.longitude);
						}
					});			
				}
				else
				{
					$(this).locationpicker({
						location: {latitude: 50.56574118400314, longitude: 5.527122840508355},
						radius: 50,
						zoom: 15,
						onchanged: function(currentLocation, radius, isMarkerDropped) {
							$(this).parent(".mapContainer").children(".inputMap").val(currentLocation.latitude + ", " + currentLocation.longitude);
							$(this).parent(".mapContainer").children(".mapButton").val(currentLocation.latitude + ", " + currentLocation.longitude);
						}
					});
				}
			});	
			
			$('.mapButton').click(function(e){
				e.stopPropagation();
				$(this).parent().children(".mapPicker").css({"visibility":"visible"});
					
			});		
			
		})
		
	})	
	
	
	$('.blackScreen').click(function(){
		$('#wireframe, #miniaturesChoice').fadeOut();
		$(this).fadeOut();
	})
	
	
	$('.parametreAccordeon .cadre').css({"height":"45px","overflow":"hidden"});
	$('.parametreAccordeon .indication').hide();
	
	$('.parametreAccordeon .cadre h3').click(function(){
		//alert($(this).parent(".cadre").height());
		if($(this).parent(".cadre").height() == '15')
		{
			$(this).parent(".cadre").css({"height":"auto","overflow":"auto"});
			$(this).children(".indication").show();
		}
		else
		{
			$(this).parent(".cadre").css({"height":"45px","overflow":"hidden"});
			$(this).children(".indication").hide();
			
		}
	})


	
	$('.mapButton').click(function(e){
		e.stopPropagation();
		$(this).parent().children(".mapPicker").css({"visibility":"visible"});
			
	});
	
	$(".mapPicker").click(function(e){
		e.stopPropagation();
	});
	
	$("html").click(function(){
		$('.mapPicker').stop().css({"visibility":"hidden"});
	})
	var lat;
	var lng;
	
	$('.mapPicker').each(function(){
		var attr = $(this).attr('data-lat');
		if(typeof attr !== typeof undefined && attr !== false)
		{
			$(this).parent(".mapContainer").children(".mapButton").val($(this).attr('data-lat') + ", " + $(this).attr('data-lng'));
			$(this).locationpicker({
				location: {latitude: $(this).attr('data-lat'), longitude: $(this).attr('data-lng')},
				radius: 50,
				zoom: 15,
				onchanged: function(currentLocation, radius, isMarkerDropped) {
					$(this).parent(".mapContainer").children(".inputMap").val(currentLocation.latitude + ", " + currentLocation.longitude);
					$(this).parent(".mapContainer").children(".mapButton").val(currentLocation.latitude + ", " + currentLocation.longitude);
				}
			});			
		}
		else
		{
			$(this).locationpicker({
				location: {latitude: 50.56574118400314, longitude: 5.527122840508355},
				radius: 50,
				zoom: 15,
				onchanged: function(currentLocation, radius, isMarkerDropped) {
					$(this).parent(".mapContainer").children(".inputMap").val(currentLocation.latitude + ", " + currentLocation.longitude);
					$(this).parent(".mapContainer").children(".mapButton").val(currentLocation.latitude + ", " + currentLocation.longitude);
				}
			});
		}
	});
	//var size = $('.mapPicker').width();
	
	//$('.mapPicker').height(size);
	
	
	if($('#page').val() != "index.php")
	{
		$('<div id="messageContainer"></div>').appendTo("body").css({"display":"none"});
		var countRefresh = 0;
		var contenuTableauDeBordOnglet = $('#tableauDeBord').html();
		var contenuTitle = $('title').text();
		function refreshMessage()
		{
			
			$.ajax({
			  url: "refreshMessage.php",
			  method: "GET",
			  data: { type : "get" },
			}).done(function( msg ) {
				var nombreDeMessage = $('.message').length;
			  $('#messageContainer').html(msg);
			  //console.log("done");
			  
			  //alert(nombreDeMessage);
			  //$('#messageContainer').scrollTop($('#messageContainer')[0].scrollHeight);
			  
			  if($('.message').length > nombreDeMessage)
			  {
				  	if(!document.hasFocus() && countRefresh != 0)
				  	{
						Notification.requestPermission( function(status) {
						  console.log(status); // les notifications ne seront affichées que si "autorisées"
						  var n = new Notification("Pilot", {body: "Vous avez reçu de nouveaux messages", icon: "images/favicon.png"}); // this also shows the notification
						});
							
					}
					if(countRefresh != 0)
					{
						$('#tableauDeBord').html(contenuTableauDeBordOnglet+"<span class='notification'>1</span>");
						$('title').text(contenuTitle+" (1)");  
					}
			  }
			  countRefresh++;
			}).fail(function( jqXHR, textStatus ) {
			  //alert( "Request failed: " + textStatus );
			});
		}
		//refreshMessage();
		//setInterval(refreshMessage, 6000);
	}
	
	window.addEventListener('load', function () {
		Notification.requestPermission(function (status) {
		// Cela permet d'utiliser Notification.permission avec Chrome/Safari
			if (Notification.permission !== status) 
			{
				Notification.permission = status;
			}
		});
	});
	
	
	$('input').attr('autocomplete','off');
	
	$('#menu a').each(function(){
		if($(this).attr('href') == $("#page").val() || $(this).attr('href') == "index.php" && $("#page").val() == "index.php")
		{
			$(this).addClass("activeMenu");
		}
	});

	$('#menu a').click(function(){
		if($(this).next(".submenu").css("display") != "none")
		{
			$('.submenu').hide();
		}
		else
		{
			$('.submenu').hide();
			$(this).next(".submenu").show();
		}
		
	});


	$('#logo').click(function(){
		window.location.href = "index.php";
	});

	$('#file').change(function(){
		var valeurFichierCache = $(this)[0].files[0].name;
		$('#file_btn').val(valeurFichierCache);
	});

	$(".update").click(function(){
		window.location.href = "options.php";
	})
	
	var nom;
	var url;
	var oneTime = 0;
	var skin = $('#skin').val();

	tinymce.on("focus", function(){
		
	})

	tinymce.init({
    	selector: ".tinyMCE",
    	language : 'fr_FR',
    	height: "200px",
    	menubar: false,
    	themes: "advanced",
    	skin: "light",
    	content_css: "themes/bootstrap.min.css, themes/reset.css",
 		content_style: "#tinymce{padding: 15px} p{padding: 4px; display: block} .bootstrapElement{padding: 15px; border: 1px dotted #dadada}",
 		font_formats: "Roboto (défaut)=Roboto, sans-serif;"+"Andale Mono=andale mono,times;"+ "Arial=arial,helvetica,sans-serif;"+ "Arial Black=arial black,avant garde;"+ "Book Antiqua=book antiqua,palatino;"+ "Comic Sans MS=comic sans ms,sans-serif;"+ "Courier New=courier new,courier;"+ "Georgia=georgia,palatino;"+ "Helvetica=helvetica;"+ "Impact=impact,chicago;"+ "Symbol=symbol;"+ "Tahoma=tahoma,arial,helvetica,sans-serif;"+ "Terminal=terminal,monaco;"+ "Times New Roman=times new roman,times;"+ "Trebuchet MS=trebuchet ms,geneva;"+ "Verdana=verdana,geneva;"+ "Webdings=webdings;"+ "Wingdings=wingdings,zapf dingbats",
 		fontsize_formats: "8px 10px 12px 14px 18px 24px 36px",
    	relative_urls : false,
    	plugins: "advlist image imagetools codemirror paste jbimages colorpicker textcolor fullscreen table link contextmenu media preview", 
    	toolbar: "fullscreen | formatselect news image | mybutton | code link backcolor forecolor | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | table | fontsizeselect | media | formats | shortcode | grid | numlist bullist",
    	image_advtab: true,
    	valid_children : '+div[p]',
    	codemirror:{
    	    saveCursorPosition: false,
    	    cssFiles: [
    	        "theme/tomorrow-night-eighties.css"
    	    ],
    	    config: {
    	        theme: 'tomorrow-night-eighties'
    	    }
    	},
    	valid_elements : '+*[*]',
    	extended_valid_elements: "+@[data-options]",
 		contextmenu: "link inserttable | cell row column deletetable | formats",
 		    setup : function(ed) {
        // Add a custom button     
        
        	
        		function addWhiteSpace()
        		{
	        		tinymce.activeEditor.dom.add(tinymce.activeEditor.getBody(), 'p', {title: 'my title'}, '');
        		}
        
        		ed.addButton('grid', {
			      type: 'menubutton',
			      text: 'Grille bootstrap',
			      icon: false,
			      menu: [{
			        text: 'container-fluid',
			        onclick: function() {
			          tinyMCE.activeEditor.selection.setNode(tinyMCE.activeEditor.dom.create('div', {class : 'container-fluid bootstrapElement'}, "<p><br></p>"));
			          //ed.insertContent('<div class="row bootstrapElement"><p></p></div>');
			          //tinyMCE.EditorManager.activeEditor.blur();
			          
			        }
			      },
			      {
			        text: 'container',
			        onclick: function() {
			          tinyMCE.activeEditor.selection.setNode(tinyMCE.activeEditor.dom.create('div', {class : 'container bootstrapElement'}, "<p><br></p>"));
			          //ed.insertContent('<div class="row bootstrapElement"><p></p></div>');
			          //tinyMCE.EditorManager.activeEditor.blur();
			        }
			      },
			      {
			        text: 'row',
			        onclick: function() {
			          tinyMCE.activeEditor.selection.setNode(tinyMCE.activeEditor.dom.create('div', {class : 'row bootstrapElement'}, "<p><br></p>"));
			          //ed.insertContent('<div class="row bootstrapElement"><p></p></div>');
			          //tinyMCE.EditorManager.activeEditor.blur();
			        }
			      },{
			        text: 'Grille',
			        menu: [
			        {
			          text: 'grille 12x1',
			          onclick: function() {
			            for(var i = 0; i<12; i++)
			            {
				            tinyMCE.activeEditor.selection.setNode(tinyMCE.activeEditor.dom.create('div', {class : 'col-md-1 bootstrapElement'}, "<p><br></p>"));
			            }
			          }
			        },
			        {
			          text: 'grille 6x2',
			          onclick: function() {
			            for(var i = 0; i<6; i++)
			            {
				            tinyMCE.activeEditor.selection.setNode(tinyMCE.activeEditor.dom.create('div', {class : 'col-md-2 bootstrapElement'}, "<p><br></p>"));
			            }
			          }
			        },
			        {
			          text: 'grille 4x3',
			          onclick: function() {
			            for(var i = 0; i<4; i++)
			            {
				            tinyMCE.activeEditor.selection.setNode(tinyMCE.activeEditor.dom.create('div', {class : 'col-md-3 bootstrapElement'}, "<p><br></p>"));
			            }
			          }
			        },
			        {
			          text: 'grille 3x4',
			          onclick: function() {
			            for(var i = 0; i<3; i++)
			            {
				            tinyMCE.activeEditor.selection.setNode(tinyMCE.activeEditor.dom.create('div', {class : 'col-md-4 bootstrapElement'}, "<p><br></p>"));
			            }
			          }
			        },
			        {
			          text: 'grille 2x6',
			          onclick: function() {
			            for(var i = 0; i<2; i++)
			            {
				            tinyMCE.activeEditor.selection.setNode(tinyMCE.activeEditor.dom.create('div', {class : 'col-md-6 bootstrapElement'}, "<p><br></p>"));
			            }
			          }
			        },
			        {
			          text: 'grille 1x12',
			          onclick: function() {
			            for(var i = 0; i<1; i++)
			            {
				            tinyMCE.activeEditor.selection.setNode(tinyMCE.activeEditor.dom.create('div', {class : 'col-md-12 bootstrapElement'}, "<p><br></p>"));
			            }
			          }
			          
			        }]
			      },{
			        text: 'Ajouter espace blanc à la fin',
			        onclick: function() {
			          //tinyMCE.activeEditor.selection.setNode(tinyMCE.activeEditor.dom.create('div', {class : 'container-fluid bootstrapElement'}, "<p><br></p>"));
			          //ed.insertContent('<div class="row bootstrapElement"><p></p></div>');
			          //tinyMCE.EditorManager.activeEditor.blur();
			          addWhiteSpace();
			        }
			      }
			      ]
			    });
				
				ed.addButton('fontformatalt', {
		            title : 'Ajouter un fichier',
		            type: "menubutton",
		            type: 'listbox',
				      text: 'Format',
				      icon: false,
				      onselect: function (e) {
					  	console.log(e);
					  	var a = this.value();
					  	var b = "/";
					  	var position = 1;
					  	var end = [a.slice(0, position), b, a.slice(position)].join('');
				        ed.selection.setContent(this.value()+ed.selection.getContent()+end);
				      },
				      values: [
					    { text: 'Paragraphe', value: '<p>'},
					    { text: 'Citation', value: '<blockquote>'},
				        { text: 'En-tête 1', value: '<h1>'},
				        { text: 'En-tête 2', value: '<h2>'},
				        { text: 'En-tête 3', value: '<h3>'},
				        { text: 'En-tête 4', value: '<h4>'},
				        { text: 'En-tête 5', value: '<h5>'},
				        { text: 'En-tête 6', value: '<h6>'},
				        
				      ]
		            

        	});
        
		        ed.addButton('mybutton', {
		            title : 'Ajouter un fichier',
		            icon: "newdocument",
		            text : "Fichier",
		            onclick : function(e) {
			            oneTime = 0;
			            url = "";
			            nom = "";
			            e.stopPropagation();
		                // Add you own code to execute something on click
						$('.listFichiers').fadeIn();
						$('.blackScreen').fadeIn();
						$('.listFichiers').click(function(e){
							e.stopPropagation();
						})
						$('#addFile').click(function(){
							if(oneTime == 0)
							{
								$('.listFichiers').fadeOut();
								$('.blackScreen').fadeOut();
								oneTime = 1;
								ed.focus();
								url = $(".fichierSelect").val();
							
								ed.selection.setContent('<a href="'+url+'">'+url+'</a>');
							}
						})
						$('html').click(function(){
							$('.listFichiers').fadeOut();
							$('.blackScreen').fadeOut();
						})
		            }

        	});
        	ed.addButton('shortcode', {
		            title : 'Shortcode',
		            icon: "code",
		            text : "Shortcode",
		            onclick : function(e) {
		                oneTime = 0;
			            url = "";
			            nom = "";
			            e.stopPropagation();
		                // Add you own code to execute something on click
						$('.allShortcode').fadeIn();
						$('.blackScreen').fadeIn();
						$('.allShortcode').click(function(e){
							e.stopPropagation();
						})
						$('#addshortCode').click(function(){
							if(oneTime == 0)
							{
								$('.allShortcode').fadeOut();
								$('.blackScreen').fadeOut();
								oneTime = 1;
								ed.focus();
								url = $(".shortcode").val();
							
								ed.selection.setContent(url);
							}
						})
						$('html').click(function(){
							$('.allShortcode').fadeOut();
							$('.blackScreen').fadeOut();
						})
		            }
        	})
		        ed.addButton('news', {
		            title : 'Images',
		            icon: "image",
		            text : "Images",
		            onclick : function(e) {
		                
		                var images = new Object();
                	    $('.popup').html("<iframe src='medias.php' style='height: 100%; width: 100%;'></iframe>");
                			var src;
                			$('.popup iframe').on('load', function(){
                				$(this).contents().on('click', '.imageLibrary', function(){
                					
                				});
                				var iframe = $(this);
                				$(this).contents().on("click", "#insertImage", function(){
                					//var imageArray = new Array();
                					$( ".selectimageContainer" ).sortable({
                						placeholder: "ui-state-highlight"
                					});
                					
                					//$("#votre_image").val("");
                					
                					$('.popup iframe').contents().find(".imageLibrary.selected").each(function(){
                						
                						
                						if($(this).attr('data-parent') == "")
                						{
                							var ID = $(this).attr('data-id');
                						}
                						else
                						{
                							var ID = $(this).attr('data-parent');
                						}
                						
                						var v;
                						var alt;
                						
                						$.ajax({
                							url: "ajax/photo_upload.php",
                							dataType: "json",
                							data: {
                								action: "file_details",
                								ID: ID
                							}
                						}).done(function(json){
                							//console.log(json);
                							var type = $(iframe).contents().find('.imageType').val();
                							v = $(iframe).contents().find('.activeLang').attr('data-tab');
                							console.log(json[type]);
                							src = json[type].file;
                							//alert(src);
                							alt = parseJSONresponse(json[type].alt, v);
                							if(!json[type].parent)
                							{
                							    var parent = json[type].ID;
                							}
                							else
                							{
                							    var parent = json[type].parent;
                							}
                							parent = src;
                							
                						    if(type == "video")
                                	        {
                                           		ed.selection.setContent('<video controls="controls" src="'+src+'"></video>');
                                		   	}
                                		   	else
                                		   	{
                                			   	ed.selection.setContent("<img src='"+src+"'>");
                                		   	}
                                		   	ed.windowManager.nodeChanged();
                							//images.push(json[type].parent);
                							//$('.selectimageContainer').append("<div data-id='"+json[type].ID+"' class='imageSelectionnee' style='width: 100px; height: 100px; background: url("+src+"); background-position: center; background-size: cover; float: left; margin: 5px;'></div>");
                							//editor[which].clipboard.dangerouslyPasteHTML(index, '<img src="'+src+'" alt="'+alt+'" />');
                							
                						});
                						
                						
                						//imageArray.push($(this).attr('data-src'));
                					});
                					
                					
                					
                					console.log(images);
                					//$("#votre_image").val(images.join(";"));
                					removePopup();
                					//
                				})
                			})
                			
                			showPopup();
		                
		                
						


		            }
		        });
    	}
 	});

 	//$('.tinyMCE').editorCommands.execCommand("fontName", false, "Arial");
 	
})