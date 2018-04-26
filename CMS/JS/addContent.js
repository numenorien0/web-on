$(function(){
	
	
/*
	var time = 1000;
	
	$('.wireframe_miniatures').each(function(){

		var actuel = $(this);
		var ID = $(this).attr('data-id');
		setTimeout(function(){
			$("#generateMiniature").attr("src", "preview_bloc.php?miniature="+ID);
			//$(actuel).children("img").attr('src', "wireframes/Miniatures/"+ID+"/preview_2.png")

			
		}, time)
		
		time += 3000;

	})
*/
	
	$("#template").select2();
	
	function readURL(input)
	{
        var reader = new FileReader();
        
        reader.onload = function (e) {
           	$("#imagePrev").html("<div class='col-sm-4 col-sm-offset-2'><img style='margin-top: 15px; margin-bottom: 15px; max-height: 100px' src='"+e.target.result+"'></div>");
        }	
        
        reader.readAsDataURL(input.files[0]);
	}
	
	$('#file').change(function(){
		
		readURL(this);
	
	})
	
	var select = $('.medias:first');
	var clone;
		$('.medias').change(function(){
			//refreshSelect();
			$(".medias").select2("destroy");
			var element = $(this);
			if($(this).val() == "----> Ajouter une vidéo")
			{
				$('.iframe').html("<iframe class='contenuDeLaPage' src='outils.php?tools=video&page=addMedias&type=video&display=included' width='100%' height='100%'></iframe>");
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
			$(".medias").select2();
		});



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
			redraw(".userPermission");
			
		}
		else
		{
			$(this).parent().children(".checkboxPermissions").prop("checked", false);
			redraw(".userPermission");
		}
	})

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
	

	$('#file_btn').click(function(){
		$('#file').click();
	});

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
		$('#homepage').attr('checked','checked');
	}

	if($('#state_success').length != 0)
	{
		//bootbox.alert("Contenu créé avec succès!", function(){
			setTimeout(function(){
				window.location.href = "listContent.php?parent="+$('#state_success').attr('data-link');
			}, 1000);
		//});
		
		
	}

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
	

	$(".medias").select2();
	if($("#realKeywords").val() != "")
	{
		//console.log("ok");
		//var value = new Array();
		var value = $("#realKeywords").val().split(", ");
		$.each(value, function(i, value){
			console.log(value);
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
		console.log("");
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
			$(".descriptionField, .customField, .nameField, .wysiwygContainer, .SEO_descriptionField, .lienField").hide();
			$('.description-'+langue).show();
			$('.lien-'+langue).show();
			$('.SEO_description-'+langue).show();
			$('.name-'+langue).show();
			$('.text-'+langue).show();
			$('.custom-'+langue).show();
		})
	}
	
	
})