$(function(){

	var formulaireHTML = $('#formulaireGeneral').html();
	
	$('#formulaireGeneral').submit(function(e){
		
		$('#valider').val("Sauvegarde...");
		if($("#backup").length)
		{
			
			$.ajax({
				url: "recovery.php",
				type: "POST", 
				data: {
					html: formulaireHTML,
					ID: $("#ID").val()
				}
			}).done(function(html){
	 			return true;
			})
		}
		return true;
	})

	$('#recovery').change(function(){
		var value = $(this).val();
		if(value == "Actuelle")
		{
			window.location.href = "editContent.php?id="+$("#ID").val();
		}
		else
		{
			window.location.href = "editContent.php?id="+$("#ID").val()+"&previous="+value;
		}
	})

	$("#template").select2();

	$('#template').change(function(){
		var nom = $(this).val();
		var currentLang = $('.btn_lang.active').attr('data-lang');
		$.ajax({
			url: "content/templates/"+nom+".txt"
		}).done(function(html){
			
			tinyMCE.get('wysiwyg-'+currentLang).setContent(html);
			$('#template').prop('selectedIndex',0);
		})
	})

	function readURL(input)
	{
        var reader = new FileReader();
        
        reader.onload = function (e) {
	        if(e.target.result.indexOf(".mp4") > 0)
	        {
           		$("#imagePrev").html("<video autoplay muted loop width='33%' style='margin-left: 17%' src='"+e.target.result+"'></video>");
		   	}
		   	else
		   	{
			   	$("#imagePrev").html("<div class='col-sm-4 col-sm-offset-2'><img style='margin-top: 15px; margin-bottom: 15px; max-height: 100px' src='"+e.target.result+"'></div>");
		   	}
        }	
        
        reader.readAsDataURL(input.files[0]);
	}
	
	$('#file').change(function(){
		
		readURL(this);
	
	})
	
	if($('#onlineHidden').val() == "on")
	{
		$('#online').attr('checked','checked');
	}
	if($('#commentaireHidden').val() == "on")
	{
		$('#commentaire').attr('checked','checked');
	}
	if($('#importantHidden').val() == "on")
	{
		$('#important').attr('checked','checked');
	}
	if($('#homepageHidden').val() == "on")
	{
		//alert('ok');
		$('#homepage').attr('checked','checked');
	}

		$('.medias').change(function(){
			var element = $(this);
			if($(this).val() == "----> Ajouter une vidéo")
			{
				$('.iframe').html("<iframe class='contenuDeLaPage' src='addMedias.php?type=video&display=included' width='100%' height='100%'></iframe>");
				$('.iframe').fadeIn();
				$('.blackScreen').fadeIn();
				submittedIframe();
				$('.blackScreen').click(function(){
					$('.iframe, .blackScreen').fadeOut();
					$(element).children("option:first-child").attr('selected', 'selected');
				});
				$('.iframe').click(function(e){
					e.stopPropagation();
				})
				
			}
			if($(this).val() == "----> Ajouter un album")
			{
				$('.iframe').html("<iframe class='contenuDeLaPage' src='addMedias.php?type=photo&display=included' width='100%' height='100%'></iframe>");
				$('.iframe').fadeIn();
				$('.blackScreen').fadeIn();
				submittedIframe();
				$('.blackScreen').click(function(){
					$('.iframe, .blackScreen').fadeOut();
					$(element).children("option:first-child").attr('selected', 'selected');
				});
				$('.iframe').click(function(e){
					e.stopPropagation();
				})
			}
			if($(this).val() == "----> Ajouter un fichier")
			{
				$('.iframe').html("<iframe class='contenuDeLaPage' src='addMedias.php?type=fichier&display=included' width='100%' height='100%'></iframe>");
				$('.iframe').fadeIn();
				$('.blackScreen').fadeIn();
				submittedIframe();
				$('.blackScreen').click(function(){
					$('.iframe, .blackScreen').fadeOut();
					$(element).children("option:first-child").attr('selected', 'selected');
				});
				$('.iframe').click(function(e){
					e.stopPropagation();
				})
			}
		});




	function submittedIframe()
	{
		$('iframe').load(function() {
		  $(this).contents().find('#formulaireMedia').submit(function() { 
			  $('iframe').load(function() {
				  if($("iframe").contents().find('.fail').length == 0)
				  {
					  $('.iframe, .blackScreen').fadeOut();
					  refreshSelect();
				  }
			  });
		  });
		});
	}
	
	function refreshSelect()
	{
		$.ajax({
			url: "refreshSelect.php",
			method: "GET",
		})
		.done(function(data){
			$('.mediaContainer select').each(function(){
				var valueToSave = $(this).val();
				$(this).html(data);
				$(this).children("optgroup").each(function(){
					$(this).children("option").each(function(){
						if($(this).val() == valueToSave)
						{
							$(this).attr('selected','selected');
						}
					})
				})
			})
		})
		.fail(function(data){
			alert('erreur');
		})
	}
	
	
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

	$('#allCheck').change(function(){
		if($(this).prop('checked') == true)
		{
			$('.checkboxPermissions').prop("checked", true);
			redraw(".permissionsContainer");
		}
		else
		{
			$('.checkboxPermissions').prop("checked", false);
			redraw(".permissionsContainer");
		}
	});
	
	
	$('.checkboxPermissions').change(function(){
		if($(this).prop("checked") == true)
		{
			$(this).parent().children(".checkboxPermissions").prop("checked", true);
			//redraw(".userPermission");
			
		}
		else
		{
			$(this).parent().children(".checkboxPermissions").prop("checked", false);
			//redraw(".userPermission");
		}
	})
	
/*
	$('.afficherPermissions').click(function(){
		if($('.permissionsContainer').css("display") != "none")
		{
			$('.afficherPermissions').html("Afficher <strong>&darr;</strong>");
			$('.permissionsContainer').hide();
		}
		else
		{
			$('.afficherPermissions').html("Masquer <strong>&uarr;</strong>");
			$('.permissionsContainer').show();
		}
	})
*/



	$('#file_btn').click(function(){
		$('#file').click();
	});

	var nombreDeRepertoireMin = 0;
	var nombreDeRepertoireMax = 5;
	$('.backRepertoire, .nextRepertoire').hide();
	var nombreRepertoire = 0;
	var nombreTotal = $('.repertoire').length - 1;

	if($('.repertoire').length > 5)
	{
		$('.nextRepertoire').show();
		$('.repertoire').each(function(){
			if(nombreRepertoire >= nombreDeRepertoireMin && nombreRepertoire < nombreDeRepertoireMax)
			{
				$(this).show();
			}
			else
			{
				$(this).hide();
			}
			nombreRepertoire++;
		})
	}

	$('.nextRepertoire').click(function(){
		nextRepertoire();
	})
	$('.backRepertoire').click(function(){
		prevRepertoire();
	})

	function nextRepertoire()
	{
		$('.backRepertoire').show();
		nombreDeRepertoireMin = nombreDeRepertoireMin+5;
		nombreDeRepertoireMax = nombreDeRepertoireMax+5;
		nombreRepertoire = 0;

		$('.repertoire').each(function(){
			if(nombreRepertoire >= nombreDeRepertoireMin && nombreRepertoire < nombreDeRepertoireMax)
			{
				$(this).show();
			}
			else
			{
				$(this).hide();
			}
			nombreRepertoire++;
		})

			if($('.repertoire').eq(nombreTotal).css("display") != "none")
			{
				$('.nextRepertoire').hide();
			}
	}

	function prevRepertoire()
	{
		$('.nextRepertoire').show();
		nombreDeRepertoireMin = nombreDeRepertoireMin-5;
		nombreDeRepertoireMax = nombreDeRepertoireMax-5;
		nombreRepertoire = 0;

		$('.repertoire').each(function(){
			if(nombreRepertoire >= nombreDeRepertoireMin && nombreRepertoire < nombreDeRepertoireMax)
			{
				$(this).show();
			}
			else
			{
				$(this).hide();
			}
			nombreRepertoire++;
		})

			if($('.repertoire').eq(0).css("display") != "none")
			{
				$('.backRepertoire').hide();
			}
	}


	
	var select = $('.medias:first');
	//console.log(select);
	
	var clone;
	
	$('#addMedias').click(function(){
		$(".medias").select2("destroy");
		clone = $(select).clone();
		$(clone).appendTo($(select).parent());
		
		$(".medias:last-child").children("option:first-child").attr('selected', 'selected');
		
		$('.medias').change(function(){
			$(".medias").select2("destroy");
			if($(this).val() == "Aucun" && !$(this).is(":first-child"))
			{
				$(this).remove();
			}
			$(".medias").select2();
		});
		
		$('.medias').change(function(){
			var element = $(this);
			if($(this).val() == "----> Ajouter une vidéo")
			{
				$('.iframe').html("<iframe class='contenuDeLaPage' src='addMedias.php?type=video&display=included' width='100%' height='100%'></iframe>");
				$('.iframe').fadeIn();
				$('.blackScreen').fadeIn();
				submittedIframe();
				$('.blackScreen').click(function(){
					$('.iframe, .blackScreen').fadeOut();
					$(element).children("option:first-child").attr('selected', 'selected');
				});
				$('.iframe').click(function(e){
					e.stopPropagation();
				})
			}
			if($(this).val() == "----> Ajouter un album")
			{
				$('.iframe').html("<iframe class='contenuDeLaPage' src='addMedias.php?type=photo&display=included' width='100%' height='100%'></iframe>");
				$('.iframe').fadeIn();
				$('.blackScreen').fadeIn();
				submittedIframe();
				$('.blackScreen').click(function(){
					$('.iframe, .blackScreen').fadeOut();
					$(element).children("option:first-child").attr('selected', 'selected');
				});
				$('.iframe').click(function(e){
					e.stopPropagation();
				})
			}
			if($(this).val() == "----> Ajouter un fichier")
			{
				$('.iframe').html("<iframe class='contenuDeLaPage' src='addMedias.php?type=fichier&display=included' width='100%' height='100%'></iframe>");
				$('.iframe').fadeIn();
				$('.blackScreen').fadeIn();
				submittedIframe();
				$('.blackScreen').click(function(){
					$('.iframe, .blackScreen').fadeOut();
					$(element).children("option:first-child").attr('selected', 'selected');
				});
				$('.iframe').click(function(e){
					e.stopPropagation();
				})
			}
		});
		
		$(".medias").select2();
		
	})

	var nombreDeMedias = $('.mediasHidden').length;

	var i = 1;

	while(i < nombreDeMedias)
	{
		clone = $(select).clone();
		$(clone).appendTo($(select).parent());
		$(clone).children("optgroup").each(function(){
			$(this).children("option").each(function(){
				if($(this).val() == $(".mediasHidden:eq("+i+")").val())
				{
					$(this).prop('selected','selected');
				}
			});
		});
		i++;
	}
	$(select).children("optgroup").each(function(){
		$(this).children("option").each(function(){
			if($(this).val() == $(".mediasHidden:eq(0)").val())
			{
				$(this).prop('selected','selected');
			}
		});
	});

	$('.medias').change(function(){
		if($(this).val() == "Pas de média" && !$(this).is(":first-child"))
		{
			$(this).remove();
		}
	});

	if($('#decompte').length != 0)
	{
		if($('#decompte').attr('data-link') != "")
		{
			window.location.href = "listContent.php?parent="+$('#decompte').attr('data-link');
		}
		else
		{
			window.location.href = "listContent.php";
		}
		$('#formulaire').hide();
		var secondes = 0;
		var decompte = setInterval(function(){
			$("#decompte").text(secondes+" secondes");
			secondes--;
			if(secondes == 0)
			{
				clearInterval(decompte);
				if($('#decompte').attr('data-link') != "")
				{
					window.location.href = "listContent.php?parent="+$('#decompte').attr('data-link');
				}
				else
				{
					window.location.href = "listContent.php";
				}
				
			}
		}, 1000)
	}
	
	
	$(".medias").select2();


	var id;
	var otherId;
	var titreCategorie = "Pages principales";

	$(".titreCategorie").text("Page de destination : "+titreCategorie);

	$('.selectionner').click(function(e){
		e.stopPropagation();
		$('#destination').val($(this).parent().text());
		$('#destinationID').val($(this).parent().attr('data-id'));
	})

	$('.arborescence').each(function(){
		if($(this).attr('data-parent'))
		{
			$(this).hide();
		}
		else
		{
			$(this).addClass("visiblePage");
		}
	});

	$('.back').hide();

	$('.arborescence').click(function(){
		$('.back').show();
		titreCategorie = $(this).text();
		id = $(this).attr('data-id');

		$('.arborescence').hide();
		$(".arborescence").removeClass("visiblePage");
		$('.arborescence').each(function(){
			if($(this).attr('data-parent') == id)
			{
				$(this).show();
				$(this).addClass("visiblePage");
			}
		});
		$('.PagePrincipale').show();
		if($('.arborescence:visible:first').length == 0)
		{
			$('<div data-id="'+id+'" class="col-sm-12 noPage"><span class="col-sm-12 nomCategory">Pas de sous-page</span><input type="button" value="Déplacer ici" class="col-sm-6 col-sm-offset-3 selectionner"></div>').insertBefore('.titleDestinationVers');
			$('.PagePrincipale').hide();
			$('.selectionner').click(function(e){
				e.stopPropagation();
				var idARechercher = $(this).parent().attr('data-id');
				var texte;
				$('.arborescence').each(function(){
					if(idARechercher == $(this).attr('data-id'))
					{
						texte = $(this).text();
					}
				})
				
				$('#destination').val(texte);
				$('#destinationID').val($(this).parent().attr('data-id'));
			})
		}
		$(".titreCategorie").text("Page de destination : "+titreCategorie);
		limiterAffichage();
	});

/*	$('.deleteImage').click(function(e){
		e.preventDefault();
		
		var image = $(this).attr('href');
		bootbox.confirm("Attention, la page va être rechargée, les modifications non sauvegardées seront perdues. Continuer?", function(result){
		if(result == true)
		{
			window.location.href = window.location.href+image;
		}
		});
	})*/

	$('#cancel').click(function(){
		$('#destination').val("");
		$('#destinationID').val("");
	});

	var advanced;

	if($('#advancedHidden').val() == "true")
	{
		advanced = true;
	}
	else
	{
		advanced = false;
	}

	if(advanced == false)
	{
		$('.PagePrincipale').hide();
	}

	$('.back').click(function(){
		$('.noPage').remove();
		//$(".arborescence").removeClass("visiblePage");
		if($('.arborescence:visible:first').attr('data-parent') || $('.arborescence:visible:first').length == 0)
		{
			var idTemp = $('.arborescence:visible:first').attr('data-parent');

			if(!idTemp)
			{
				idTemp = id;
			}

			$('.arborescence').hide();
			$(".arborescence").removeClass("visiblePage");
			$('.PagePrincipale').show();
			$('.arborescence').each(function(){
				if($(this).attr('data-id') == idTemp)
				{
					$(this).show();
					$(this).addClass("visiblePage");
					otherId = $(this).attr('data-parent');
					$('.arborescence').each(function(){
						if($(this).attr('data-id') == otherId)
						{
							titreCategorie = $(this).text();
						}
					})
				}
			});

			$('.arborescence').each(function(){
				if($(this).attr('data-parent') == otherId)
				{
					$(this).show();
					$(this).addClass("visiblePage");
				}
			});

			if(!$('.arborescence:visible:first').attr('data-parent'))
			{
				titreCategorie = "Pages principales";
				$('.back').hide();
				if(advanced == false)
				{
					$('.PagePrincipale').hide();
				}
				else
				{
					$('.PagePrincipale').show();
				}
			}
			
		}
		$(".titreCategorie").text("Page de destination : "+titreCategorie);
		limiterAffichage();
	})


	$('.PagePrincipale').click(function(){
		var idDuParent = $('.arborescence:visible:first').attr('data-parent');
		if(!$('.arborescence:visible:first').attr('data-parent'))
		{
			$('#destination').val("Pages principales");
			$('#destinationID').val("0");
		}
		else
		{
			$('#destination').val(titreCategorie);
			$('#destinationID').val(idDuParent);
		}
	})



	var nombreDeLigneMin = 0;
	var nombreDeLigneMax = 5;
	$('.backMove, .nextMove').hide();
	var nombreLigne = 0;
	var nombreTotalLigne = $('.visiblePage').length - 1;

	function limiterAffichage()
	{
		nombreDeLigneMin = 0;
		nombreDeLigneMax = 5;
		$('.backMove, .nextMove').hide();
		nombreLigne = 0;
		nombreTotalLigne = $('.visiblePage').length - 1;

		//alert(nombreTotalLigne);

		if($('.visiblePage').length > 5)
		{
			$('.nextMove').show();
			$('.visiblePage').each(function(){
				if(nombreLigne >= nombreDeLigneMin && nombreLigne < nombreDeLigneMax)
				{
					$(this).show();
				}
				else
				{
					$(this).hide();
				}
				nombreLigne++;
			})
		}
	}

	limiterAffichage();

	$('.nextMove').click(function(){
		nextMove();
	})
	$('.backMove').click(function(){
		prevMove();
	})

	function nextMove()
	{
		$('.backMove').show();
		nombreDeLigneMin = nombreDeLigneMin+5;
		nombreDeLigneMax = nombreDeLigneMax+5;
		nombreLigne = 0;

		$('.visiblePage').each(function(){
			if(nombreLigne >= nombreDeLigneMin && nombreLigne < nombreDeLigneMax)
			{
				$(this).show();
			}
			else
			{
				$(this).hide();
			}
			nombreLigne++;
		})

			if($('.visiblePage').eq(nombreTotalLigne).css("display") != "none")
			{
				$('.nextMove').hide();
			}
	}

	function prevMove()
	{
		$('.nextMove').show();
		nombreDeLigneMin = nombreDeLigneMin-5;
		nombreDeLigneMax = nombreDeLigneMax-5;
		nombreLigne = 0;

		$('.visiblePage').each(function(){
			if(nombreLigne >= nombreDeLigneMin && nombreLigne < nombreDeLigneMax)
			{
				$(this).show();
			}
			else
			{
				$(this).hide();
			}
			nombreLigne++;
		})

			if($('.visiblePage').eq(0).css("display") != "none")
			{
				$('.backMove').hide();
			}
	}


	$('#keywordsField').keydown(function(e){
		
		var scroll = $("#wrapper").scrollTop();
		var positionX = $("#keywordsList").position().left;
		var positionY = $("#keywordsList").offset().top + scroll;
		console.log(positionY);
		var value = $(this).val();
		
		if(e.keyCode == "13")
		{
			e.preventDefault();
			
			if($("#keylist ul").children(".active").length != 0)
			{
				
				value = $("#keylist ul li.active").text();
				$('#keylist').hide();
			}
			$(this).val("");
			$("#keywordsList").append("<div class='keywordsWrap'><div class='keyValue'>"+value+"</div><div class='deleteKeywords'><img src='images/cancel.png'/></div></div>");
			$('.deleteKeywords').click(function(){
				$(this).parent().remove();
				var chaine = new Array();
				$('#keywordsList .keyValue').each(function(){
					chaine.push($(this).html());
				})
				
				chaine = chaine.join(", ");
				$("#realKeywords").val(chaine);
			})
			
			
			var chaine = new Array();
			$('#keywordsList .keyValue').each(function(){
				chaine.push($(this).html());
			})
			
			chaine = chaine.join(", ");
			$("#realKeywords").val(chaine);
		}
		else
		{
			if(e.keyCode != "40" && e.keyCode != "38")
			{
				$.ajax({
					url: "loadKeywords.php?key="+value,
				}).done(function(html){
					if(html == "<ul class='keywordsItems'></ul>")
					{
						$("#keylist").hide();
					}
					else
					{
						$("#keylist").show();
					}
					$("#keylist").html(html).css({"top": (positionY+10)+"px","left": (positionX+15)+"px"});
					$('.keywordsItem').click(function(){

						value = $(this).text();
						$('#keylist').hide();
						$('#keywordsField').val("");
						$("#keywordsList").append("<div class='keywordsWrap'><div class='keyValue'>"+value+"</div><div class='deleteKeywords'><img src='images/cancel.png'/></div></div>");			
						$('.deleteKeywords').click(function(){
							$(this).parent().remove();
							var chaine = new Array();
							$('#keywordsList .keyValue').each(function(){
								chaine.push($(this).html());
							})
							
							chaine = chaine.join(", ");
							$("#realKeywords").val(chaine);
						})
						
						
						var chaine = new Array();
						$('#keywordsList .keyValue').each(function(){
							chaine.push($(this).html());
						})
						
						chaine = chaine.join(", ");
						$("#realKeywords").val(chaine);
					});
					
				})
			}
			else
			{
				if(e.keyCode == "40")
				{
					e.preventDefault();
					if($("#keylist ul").children(".active").length == 0)
					{
						$("#keylist ul li").first().addClass("active");
						
					}
					else
					{
						if($(".active").next("li").length != 0)
						{
							$(".active").removeClass("active").next().addClass("active");
						}
					}
				}
				if(e.keyCode == "38")
				{
					e.preventDefault();
					if($("#keylist ul").children(".active").length == 0)
					{
						$("#keylist ul li").last().addClass("active");
						
					}
					else
					{
						if($(".active").prev("li").length != 0)
						{
							$(".active").removeClass("active").prev().addClass("active");
						}
					}
				}				

			}
		}
		

	});
	

	
	if($("#realKeywords").val() != "")
	{
		//console.log("ok");
		//var value = new Array();
		var value = $("#realKeywords").val().split(", ");
		$.each(value, function(i, value){
			//console.log(value);
			$("#keywordsList").append("<div class='keywordsWrap'><div class='keyValue'>"+value+"</div><div class='deleteKeywords'><img src='images/cancel.png'/></div></div>");
			$('.deleteKeywords').click(function(){
				$(this).parent().remove();
				var chaine = new Array();
				$('#keywordsList .keyValue').each(function(){
					chaine.push($(this).html());
				})
				
				chaine = chaine.join(", ");
				$("#realKeywords").val(chaine);
			})
		})
	}
	else
	{
		console.log("mother");
	}
    $(".customField").hide();	
	langChoice();
	
	function langChoice()
	{
		$('.btn_lang').first().addClass("active").text($('.btn_lang').first().attr('data-lang-name'));
		$('.demandTranslate').hide();
		$(".descriptionField").first().show();
		$(".lienField").first().show();
		$(".SEO_descriptionField").first().show();
		$(".wysiwygContainer").first().show();
		$(".nameField").first().show();
		$(".customField").first().show();
		$('.btn_lang').click(function(){
			$('.btn_lang').removeClass("active");
			$('.btn_lang').each(function(){
				$(this).text($(this).attr('data-lang'));
			});
			$(this).addClass("active");
			if($('.btn_lang').first().hasClass("active"))
			{
				$('.demandTranslate').hide();
			}
			else
			{
				$('.demandTranslate').show();
			}			
			var langue = $(this).attr('data-lang');
			$(this).text($(this).attr('data-lang-name'));
			$(".descriptionField, .nameField, .wysiwygContainer, .SEO_descriptionField, .lienField, .customField").hide();
			$('.description-'+langue).show();
			$('.lien-'+langue).show();
			$('.SEO_description-'+langue).show();
			$('.name-'+langue).show();
			$('.text-'+langue).show();
			$('.custom-'+langue).show();
		})
	}
})