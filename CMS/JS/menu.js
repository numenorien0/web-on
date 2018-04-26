$(function(){
	
	//var json = new Array();
	$('#selectMenuType').change(function(){
		window.location.href = "menuEcommerce.php";
	})
	var heightOption = $('.topmenuoption').height();

	$('.topmenuoption').height("15px");
	
	$('.topmenuoption h3').click(function(){
		
		if($('.topmenuoption').css("height") == "45px")
		{
			$('.topmenuoption').animate({"height":heightOption+100+"px"}, 500);
		}
		else
		{
			$('.topmenuoption').animate({"height":"45px"}, 500);
		}
	})
	
	$('#searchPage').keyup(function(){
		if($('#currentLang').val() != "")
		{
			var langueInputHidden = "&lang="+$('#currentLang').val();
		}
		else
		{
			var langueInputHidden = "";
		}
		$.ajax({
			url: "ajax_page.php?key="+$(this).val()+langueInputHidden,
		}).done(function(html){
			$(".result").html(html);
		})
	})	
	
	
	$('body').on('click', '.main-page', function(){
		changement_en_cours = true;
		var count = 0;
		$('.column').each(function(){
			if($(this).html() == "" && $(this).hasClass("extra") == false)
			{
			}
			else
			{
			 	count ++;	
			}			
		});
		
		if(count <= 8)
		{
			var json = new Array();
			var row = new Array();
			var element = new Object();
			var link = $(this).attr('data-link');
			var texte = $(this).text();
			var id = $(this).attr('data-id');
			if(link == "choice_lang")
			{
				$('<div class="column"><div class="portlet" data-link="'+link+'"><div data-id="'+id+'" class="portlet-header"><span class="titre">'+texte+'</span></div><div class="portlet-content"><input type="text" value="'+texte+'" class="inputNom" style="visibility: hidden; margin-top: 0px; margin-bottom: 10px"/><input style="visibility: hidden; margin-top: 0px" type="text" value="'+link+'" class="inputlink" /></div></div></div>').insertBefore(".extra");
			}
			else
			{
				$('<div class="column"><div class="portlet" data-link="'+link+'"><div data-id="'+id+'" class="portlet-header"><span class="titre">'+texte+'</span></div><div class="portlet-content"><label class="champs">Modifier le nom : </label><input type="text" value="'+texte+'" class="inputNom" style="margin-top: 0px; margin-bottom: 10px"/><br/><label class="champs">Modifier le lien : </label><input style="margin-top: 0px" type="text" value="'+link+'" class="inputlink" /></div></div></div>').insertBefore(".extra");
			}
			init_sortable();
			$('.column').each(function(){
				if($(this).html() == "" && $(this).hasClass("extra") == false)
				{

				}
				else
				{
					var row = new Array();
					$(this).children('.portlet').each(function(){
						var element = new Object();
						var nom = $(this).children(".portlet-header").children(".titre").text();
						var id = $(this).attr('data-id');
						var link = $(this).children(".portlet-content").children(".inputlink").val();
						//console.log(nom+" "+link);
						element.nom = nom;
						//element.ID = id;
						element.link = link;
						row.push(element);	
						//console.log(row);					
					})
					json.push(row);
					//alert('ok');
				}
			})
			//console.log(json)
			json = JSON.stringify(json,null,2); 
			$('#code').html(json);
			json = new Array();
	    }
	    else
	    {
		    
	    }
	 
	})


	if($("#code").val() != "")
	{
		var code = jQuery.parseJSON($("#code").val());
		//alert(code);
		$.each(code, function(i,u){
			var colonne = $('<div class="column"></div>').insertBefore(".extra");
			$.each(u, function(e, a){
				if(a.link == "choice_lang")
				{
					$('<div class="portlet" data-link="'+a.link+'"><div data-id="" class="portlet-header"><span class="titre">'+a.nom+'</span></div><div class="portlet-content"><input type="text" value="'+a.nom+'" class="inputNom" style="visibility: hidden; margin-top: 0px; margin-bottom: 10px"/><input style="visibility: hidden; margin-top: 0px" type="text" value="'+a.link+'" class="inputlink" /></div></div>').appendTo(colonne);
				}
				else
				{
					$('<div class="portlet" data-link="'+a.link+'"><div data-id="" class="portlet-header"><span class="titre">'+a.nom+'</span></div><div class="portlet-content"><label class="champs">Modifier le nom : </label><input type="text" value="'+a.nom+'" class="inputNom" style="margin-top: 0px; margin-bottom: 10px"/><br/><label class="champs">Modifier le lien : </label><input style="margin-top: 0px" type="text" value="'+a.link+'" class="inputlink" /></div></div>').appendTo(colonne);
				}
			})
		})
		init_sortable();
	}




	var changement_en_cours = false;

	langChoice();
	
	function langChoice()
	{
		if($('#currentLang').val() != "")
		{
			var langueInputHidden = $('#currentLang').val();
			$('.btn_lang').each(function(){
				if($(this).attr('data-lang') == langueInputHidden)
				{
					$(this).addClass("active").text($(this).attr('data-lang-name'));
				}
			})	
		}
		else
		{
			$('.btn_lang').first().addClass("active").text($('.btn_lang').first().attr('data-lang-name'));
		}
		$('.btn_lang').click(function(e){
			if(changement_en_cours == true)
			{
				$(window).bind('beforeunload', function(){
				  return 'Are you sure you want to leave?';
				});
				
				if($(this).attr('data-main') == "true")
				{
					window.location.href = "menu.php";
				}
				else
				{
					window.location.href = "?lang="+$(this).attr('data-lang');					
				}
			}
			else
			{
				if($(this).attr('data-main') == "true")
				{
					window.location.href = "menu.php";
				}
				else
				{
					window.location.href = "?lang="+$(this).attr('data-lang');					
				}
			}
		})
	}
	
/*
	$(window).bind('beforeunload', function(){
	  return 'Are you sure you want to leave?';
	});	
*/
	
	function init_sortable()
	{
		$('.inputNom').change(function(){
			changement_en_cours = true;
			var value = $(this).val();
			$(this).parent().parent().children(".portlet-header").children(".titre").text(value);
			init_sortable();
		})
		
		$('.inputlink').change(function(){
			changement_en_cours = true;
			init_sortable();
		})

		var json = new Array();
		var row = new Array();
		var element = new Object();
		$('#rendu').sortable({
		    stop: function(event, ui){
		        $('.column').each(function(){
				if($(this).html() == "" && $(this).hasClass("extra") == false)
				{
					//var row = new Array();
					//var element = new Object();					
					$(this).remove();
				}
				else
				{
					$(this).children('.portlet').addClass("lv2");
					$(this).children('.portlet:first-child').removeClass("lv2");
					var row = new Array();
					$(this).children('.portlet').each(function(){
						var element = new Object();
						var nom = $(this).children(".portlet-header").children(".titre").text();
						var id = $(this).attr('data-id');
						var link = $(this).children(".portlet-content").children(".inputlink").val();
						//console.log(nom+" "+link);
						element.nom = nom;
						//element.ID = id;
						element.link = link;
						row.push(element);	
						//console.log(row);					
					})
					//console.log(row);
					//console.log(row);
					//console.log(json);
					json.push(row);
					//alert('ok');
				}
			})
			//console.log(json)
			json = JSON.stringify(json,null,2); 
			$('#code').html(json);
		    }
		});
	    $( ".column" ).sortable({
	      connectWith: ".column",
	      handle: ".portlet-header",
	      cancel: ".portlet-toggle",
	      placeholder: "portlet-placeholder ui-corner-all",
	      stop: function(event, ui){
		      changement_en_cours = true;
			if($(ui.item).parent().hasClass("extra"))
			{
			  $(ui.item).parent().removeClass("extra");
			  $('<div class="column extra"></div>').appendTo("#rendu");
			  init_sortable();
			}
			
			$('.column').each(function(){
				if($(this).html() == "" && $(this).hasClass("extra") == false)
				{
					//var row = new Array();
					//var element = new Object();					
					$(this).remove();
				}
				else
				{
					$(this).children('.portlet').addClass("lv2");
					$(this).children('.portlet:first-child').removeClass("lv2");
					var row = new Array();
					$(this).children('.portlet').each(function(){
						var element = new Object();
						var nom = $(this).children(".portlet-header").children(".titre").text();
						var id = $(this).attr('data-id');
						var link = $(this).children(".portlet-content").children(".inputlink").val();
						//console.log(nom+" "+link);
						element.nom = nom;
						//element.ID = id;
						element.link = link;
						row.push(element);	
						//console.log(row);					
					})
					//console.log(row);
					//console.log(row);
					//console.log(json);
					json.push(row);
					//alert('ok');
				}
			})
			//console.log(json)
			json = JSON.stringify(json,null,2); 
			$('#code').html(json);
			json = new Array();
	      }
    	});
   
		$('.portlet').each(function(){
			if($(this).hasClass("ui-widget") == false)
			{
			    $(this)
			      .addClass( "ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" )
			      .find( ".portlet-header" )
			        .addClass( "ui-widget-header ui-corner-all" )
			        .prepend( "<span class='ui-icon ui-icon-close portlet-toggle'></span>");
			 
			    $(this).children().children(".portlet-toggle").on( "click", function() {
			      var icon = $( this );
			      icon.toggleClass( "ui-icon-minusthick ui-icon-plusthick" );
			      icon.closest( ".portlet" ).find( ".portlet-content" ).toggle();
			      $(this).parent().parent().remove();
					$('.column').each(function(){
						if($(this).html() == "" && $(this).hasClass("extra") == false)
						{
							$(this).remove();
						}
						else
						{
							$(this).children('.portlet').addClass("lv2");
							$(this).children('.portlet:first-child').removeClass("lv2");
							var row = new Array();
							$(this).children('.portlet').each(function(){
								var element = new Object();
								var nom = $(this).children(".portlet-header").text();
								var id = $(this).attr('data-id');
								var link = $(this).children(".portlet-content").children(".inputlink").val();
								//console.log(nom+" "+link);
								element.nom = nom;
								//element.ID = id;
								element.link = link;
								row.push(element);	
								//console.log(row);					
							})
							//console.log(row);
							//console.log(row);
							//console.log(json);
							json.push(row);
							//alert('ok');
						}
					})
					//console.log(json)
					json = JSON.stringify(json,null,2); 
					$('#code').html(json);
					json = new Array();
			    });				
			}
		});
		
		$('.column').each(function(){
			if($(this).html() == "" && $(this).hasClass("extra") == false)
			{	
				$(this).remove();
			}
			else
			{
					$(this).children('.portlet').addClass("lv2");
					$(this).children('.portlet:first-child').removeClass("lv2");
				var row = new Array();
				$(this).children('.portlet').each(function(){
					var element = new Object();
					var nom = $(this).children(".portlet-header").text();
					var id = $(this).attr('data-id');
					var link = $(this).children(".portlet-content").children(".inputlink").val();
					//console.log(link);
					//console.log(nom+" "+link);
					element.nom = nom;
					//element.ID = id;
					element.link = link;
					row.push(element);	
					//console.log(row);					
				})
				//console.log(row);
				//console.log(row);
				//console.log(json);
				json.push(row);
			}
		})
		
		json = JSON.stringify(json,null,2); 
		$('#code').html(json);
		json = new Array();		
		
	}
	
	$(window).load(function(){
		tinyMCE.get("tinyMCE").setContent($('#topmenu').val());
		tinyMCE.get("tinyMCE").on("keyup", function(e){
			var value = tinyMCE.get("tinyMCE").getContent();
			$('#topmenu').val(value);
		})		
	})

	
})