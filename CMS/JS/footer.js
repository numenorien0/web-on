$(function(){

	var currentLang = $('.btn_lang').first().attr('data-lang');
	var langue = "";

	
	$('.code').each(function(){
		var langueCode = $(this).attr('data-lang');
		console.log(langueCode);
		if($(this).val() == "")
		{
			//alert('vide');
		}
		else
		{
			var valeur = $(this).val();
			console.log(valeur);
			var count = 0;
			var contenu = "";
			valeur = jQuery.parseJSON(valeur);
			$.each(valeur, function(i, value){
				//console.log(value.classe);
				if(value.classe.indexOf("copyright") != -1)
				{
					
					$('.copyrightCadre-'+langueCode).html(value.contenu);	
				}
				else
				{
					contenu += "<div data-number='"+i+"' data-size='"+value.classe+"' class='cadre-"+i+" cadreBootstrap "+value.classe+"'>"+value.contenu+"</div>";
				}
				count++;
			})
			$(".rendu-"+langueCode).html(contenu);
		}
	})
	
	
	var json = new Array();
/*
	$(".rendu-"+langue).html("<div data-number='1' data-size='col-sm-12' class='cadre-1 cadreBootstrap col-sm-12'>Contenu du footer</div>");
	var row = {classe: "col-sm-12", contenu: "Contenu du footer"};
	json.push(row);
	var jsonPretty = JSON.stringify(json,null,2);
	$('#code').html(jsonPretty);
*/
	
	$('#row').change(function(){
		//alert('ok');
		var nombreDeColonne = 12/$(this).val();
		var html = "";
		var json = new Array();
		
		for(var i = 1; i <= $(this).val(); i++)
		{
			
			var contenu = "";
			
			var classe = "col-sm-"+nombreDeColonne;
			if($(".rendu-"+currentLang+" .cadreBootstrap:nth-child("+(i)+")").length != 0)
			{
				//alert(i);
				var contenu = $(".rendu-"+currentLang+" .cadreBootstrap:nth-child("+(i)+")").html();
				//$("#apercu .cadreBootstrap:nth-child("+(i)+")").removeClass().addClass("col-sm-"+nombreDeColonne);
				html += "<div data-number='"+i+"' data-size='"+classe+"' class='cadre-"+i+" cadreBootstrap "+classe+"'>"+contenu+"</div>";				
			}
			else
			{
				var contenu = "contenu";
				//alert('ok');
				html += "<div data-number='"+i+"' data-size='"+classe+"' class='cadre-"+i+" cadreBootstrap "+classe+"'>"+contenu+"</div>";

			}
			
			var row = {classe: classe, contenu: contenu};
			
			json.push(row);
		}
		$(".rendu-"+currentLang).html(html);
		var jsonPretty = JSON.stringify(json,null,2);
		
		$('#code').html(jsonPretty);

	})		
	var cadre = 0;
	$('.rendu, .copyright').on("click", '.cadreBootstrap', function(){
		
		var data = $(this).html();
		cadre = $(this).attr('data-number');
 		
		tinyMCE.activeEditor.setContent(data);
		tinymce.execCommand('mceFocus',true,'tinyMCE');
		
	});
	
	setTimeout(function(){ 
		tinyMCE.activeEditor.on("change", function(e){
			if(!isNaN(cadre))
			{	
				$(".rendu-"+currentLang+" .cadre-"+cadre).html(tinyMCE.activeEditor.getContent());
				var json = new Array();
				$('.rendu-'+currentLang+' .cadreBootstrap').each(function(){
					var contenu = $(this).html();
					var classe = $(this).attr('data-size');
					var row = {classe: classe, contenu: contenu};
					console.log(contenu);
					json.push(row);
					var jsonPretty = JSON.stringify(json,null,2);
					
					$('.code-'+currentLang).html(jsonPretty);
				})
			}
			else
			{
				
				//var content = tinyMCE.activeEditor.getContent();
				$("."+cadre).html(tinyMCE.activeEditor.getContent());
				var json = new Array();
				$('.rendu-'+currentLang+' .cadreBootstrap').each(function(){
					var contenu = $(this).html();
					var classe = $(this).attr('data-size');
					var row = {classe: classe, contenu: contenu};
					//console.log(contenu);
					json.push(row);
					
					
					
				})
				row = {classe: "col-sm-12 copyright", contenu: $("."+cadre).html()};
				json.push(row);
				var jsonPretty = JSON.stringify(json,null,2);
				$('.code-'+currentLang).html(jsonPretty);
			}
		})
		tinyMCE.activeEditor.on("keyup", function(e){
			if(!isNaN(cadre))
			{
				//alert('ok');
				$(".rendu-"+currentLang+" .cadre-"+cadre).html(tinyMCE.activeEditor.getContent());
				var json = new Array();
				$('.rendu-'+currentLang+' .cadreBootstrap').each(function(){
					var contenu = $(this).html();
					var classe = $(this).attr('data-size');
					var row = {classe: classe, contenu: contenu};
					console.log(contenu);
					json.push(row);
					var jsonPretty = JSON.stringify(json,null,2);
					
					$('.code-'+currentLang).html(jsonPretty);
				})
			}
			else
			{
				
				//var content = tinyMCE.activeEditor.getContent();
				$("."+cadre).html(tinyMCE.activeEditor.getContent());
				var json = new Array();
				$('.rendu-'+currentLang+' .cadreBootstrap').each(function(){
					var contenu = $(this).html();
					var classe = $(this).attr('data-size');
					var row = {classe: classe, contenu: contenu};
					//console.log(contenu);
					json.push(row);
					
					
					
				})
				row = {classe: "col-sm-12 copyright", contenu: $("."+cadre).html()};
				json.push(row);
				var jsonPretty = JSON.stringify(json,null,2);
				$('.code-'+currentLang).html(jsonPretty);
			}
		})
	}, 1000);
	
	langChoice();
	function langChoice()
	{
		
		var json = new Array();
		$('.btn_lang').first().addClass("active").text($('.btn_lang').first().attr('data-lang-name'));
		$(".rendu").first().show();
		$(".copyright").first().show();
		var nombreDelement = $('.rendu-'+currentLang+' .cadreBootstrap').length;
		$('#row option[value="'+nombreDelement+'"]').prop('selected', true);
// 		alert(nombreDelement);
		
		
		$('.btn_lang').click(function(){
			$('#row option:eq(0)').prop('selected', true);
			$('.btn_lang').removeClass("active");
			$('.btn_lang').each(function(){
				$(this).text($(this).attr('data-lang'));
			})
			$(this).addClass("active");
			langue = $(this).attr('data-lang');
			currentLang = langue;
			$(this).text($(this).attr('data-lang-name'));
			$('.rendu, .copyright').hide();
			$('.rendu-'+langue+", .copyright-"+langue).show();
			var nombreDelement = $('.rendu-'+currentLang+' .cadreBootstrap').length;
			$('#row option[value="'+nombreDelement+'"]').prop('selected', true);
		})
	}	
	
	
	
})