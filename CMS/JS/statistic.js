$(function(){
	
	
	
	
	 $('.pageInteractive').hover(function(e){
		 var positionX = $(this).parent(".pageInteraction").position().left;
		 var positionY = $(this).parent(".pageInteraction").position().top;
		 $('#dialogComportement').show().css({"left":positionX+120, "top": positionY+30});
		 var contenu = $(this).next(".whatIsTheNextStep").html();
		 $('#dialogComportement').html(contenu);
		 //alert('ok');
	 }).mouseout(function(){
	 	$('#dialogComportement').hide();
	});
	
	function getRandomColor2(number)
	{
		var color = "#ff0200";
		if(number < 90) color = "#ff2c2c";
		if(number < 80) color = "#fff04d";
		if(number < 70) color = "#39ce3f";
		if(number < 60) color = "#6fa4ff";
		if(number < 50) color = "#69d545";
		if(number < 40) color = "#b1b1b1";
		if(number < 30) color = "#cc88ff";
		if(number < 20) color = "#ff6a28";
		if(number < 10) color = "#5496ff";
			
	    return color;
	}
	
	var percentColors = [
    { pct: 0.0, color: { r: 255, g: 115, b: 115 } },
    { pct: 0.5, color: { r: 125, g: 235, b: 103 } },
    { pct: 1.0, color: { r: 98, g: 210, b: 132 } }];
    
    
	function getRandomColor(pct) {
		pct = pct/100;
		console.log(pct);
	    for (var i = 1; i < percentColors.length - 1; i++) {
	        if (pct < percentColors[i].pct) {
	            break;
	        }
	    }
	    var lower = percentColors[i - 1];
	    var upper = percentColors[i];
	    var range = upper.pct - lower.pct;
	    var rangePct = (pct - lower.pct) / range;
	    var pctLower = 1 - rangePct;
	    var pctUpper = rangePct;
	    var color = {
	        r: Math.floor(lower.color.r * pctLower + upper.color.r * pctUpper),
	        g: Math.floor(lower.color.g * pctLower + upper.color.g * pctUpper),
	        b: Math.floor(lower.color.b * pctLower + upper.color.b * pctUpper)
	    };
	    return 'rgb(' + [color.r, color.g, color.b].join(',') + ')';
	    // or output as hex if preferred
	}
	var options = '';
// Get the context of the canvas element we want to select$
	if($('#pagesVues').length != 0)
	{
		var ctx4 = document.getElementById("pagesVues").getContext("2d");
			
		var dataPages = [];
		var pages = [];
		var nombreParPage = [];
		
		$('.pageLesPlusVues').each(function(){
			
			pages.push($(this).attr('data-label'));
			nombreParPage.push($(this).attr('data-value'));
			
		});
		
		dataPages = {
	    	labels: pages,
			datasets: [
	        {
	            label: "My First dataset",
	            fillColor: "rgba(117,202,75,0.3)",
	            strokeColor: "rgba(220,220,220,0.8)",
	            highlightFill: "rgba(220,220,220,0.75)",
	            highlightStroke: "rgba(220,220,220,1)",
	            data: nombreParPage
	        }
			]
		};
		
		var sizePageVues = $('.pageContainer').width();
		$('#pagesVues').attr('width', sizePageVues);
		
		var myBarChart = new Chart(ctx4).Bar(dataPages, {
				scaleFontSize: 0
			});		
		
	}
	if($('#paysGraph').length != 0)
	{
		var ctx = document.getElementById("paysGraph").getContext("2d");
		var ctx2 = document.getElementById("traficGraph").getContext("2d");
		var ctx3 = document.getElementById("navGraph").getContext("2d");
	
		var data = [];
		var jours = new Array();
		var traficValue = new Array();
		
		$('.traficSurDixJours').each(function(){
	
			
			jours.push($(this).attr('data-date'));
			traficValue.push($(this).attr('data-value'));
		});
		
		
		
		var dataTrafic = {
		    labels: jours.reverse(),
		    datasets: [
		        {
		            label: "Trafic sur 10 jours",
		            fillColor: "rgba(117,202,75,0.3)",
		            strokeColor: "rgba(220,220,220,1)",
		            pointColor: "rgba(220,220,220,1)",
		            pointStrokeColor: "#fff",
		            pointHighlightFill: "#fff",
		            pointHighlightStroke: "rgba(220,220,220,1)",
		            data: traficValue.reverse()
		        }
		    ]
		};
		
		
		
		var sizeTraficContainer = $('.traficContainer').width();
		//alert(sizeTraficContainer);
		$('#traficGraph').attr("width", sizeTraficContainer);
	
		
		var myLineChart = new Chart(ctx2).Line(dataTrafic, options);
		
		$('.originGraphData').each(function(){
			
			var string = new Object();
			
			string.value = $(this).attr("data-pourcentage");
			string.color = getRandomColor(string.value);
			string.highlight = getRandomColor(string.value);
			string.label = $(this).attr("data-pays");
			
	// 		var string = '{value : '+$(this).attr("data-pourcentage")+',color : "'+getRandomColor()+'",highlight : "'+getRandomColor()+'",label : "'+$(this).attr("data-pays")+'"}';
			data.push(string);
		})
		
		var dataNav = [];
		$('.navigateurGraph').each(function(){
			
			var stringNav = new Object();
			
			stringNav.value = $(this).attr("data-value");
			stringNav.color = getRandomColor(stringNav.value);
			stringNav.highlight = getRandomColor(stringNav.value);
			stringNav.label = $(this).attr("data-label");
			
	// 		var string = '{value : '+$(this).attr("data-pourcentage")+',color : "'+getRandomColor()+'",highlight : "'+getRandomColor()+'",label : "'+$(this).attr("data-pays")+'"}';
			dataNav.push(stringNav);
		})
		
		//data = JSON.parse(data);
		//console.log(data);
	
		
		var myPieChart = new Chart(ctx).Pie(data,{
				animateRotate : false,
				animateScale : true
			});
		var myPieChartNav = new Chart(ctx3).Pie(dataNav,{
				animateRotate : false,
				animateScale : true
			});

	}
	
	$('.remplissage').each(function(){
		var percent = $(this).attr('data-value');
		percent = percent.replace(",", ".");
		console.log(percent);
		$(this).css({"height":percent+"%"});
	})
	
/*
	$('.pageInteraction').each(function(){
		var hauteur = $(this).attr('data-height') * 2;
		$(this).height(hauteur);
		$(this).css({"min-height": hauteur+"px"});
	})
*/
	
	
	$('.lien').click(function(e){
		// e.stopPropagation();
		// $('#blackscreen').fadeIn();
		// $('#info').fadeIn();

		// var id = $(this).attr('data-data');
		// id = "#"+id+"Info";

		// $("#info").html("<h3>Détails</h3>"+$(id).html());
		if($(this).parent().next(".detailsVideo").css("display") == "none")
		{
			$(this).parent().next(".detailsVideo").show();
		}
		else
		{
			$(this).parent().next(".detailsVideo").hide();
		}
	});

	var tailleComportement = 0;

	$('.step').each(function(){
		tailleComportement += $(this).width()+45;
	});
	
	$('#comportementDiv').width(tailleComportement+"px");

	var ongletVal = $("#ongletHidden").val();
	var activeOnglet = false;
	var hiddenVal = $('#dateHidden').val();
	var activeFilter = false;

	$('.linkDate').each(function(){
		if($(this).attr('data-date') == hiddenVal)
		{
			activeFilter = true;
			$(this).css({"text-decoration": "none","background-color": "#5BC25C","color": "white", "border": "2px solid #5BC25C"});
		}
	});
	
	$('.onglet a').each(function(){
		if($(this).attr('data-filter') == ongletVal)
		{
			activeOnglet = true;
			$(this).parent().css({"text-decoration": "none","background-color": "#F4F4F4","color": "white", "box-shadow":"0px 2px 2px rgba(0,0,0,0.2)"});
		}
	});
	
	if(activeOnglet == false)
	{
		$('.onglet:eq(0)').css({"text-decoration": "none","background-color": "#F4F4F4","color": "white", "box-shadow":"0px 2px 2px rgba(0,0,0,0.2)"});
	}
	if(activeFilter == false)
	{
		$('.linkDate:eq(0)').css({"text-decoration": "none","background-color": "#5BC25C","color": "white", "border": "2px solid #5BC25C"});
	}

	$('.lienDetails').click(function(e){
		// e.stopPropagation();
		// $('#blackscreen').fadeIn();
		// $('#info').fadeIn();

		// var id = $(this).attr('data-data');
		// id = "#"+id+"Info";

		// $("#info").html("<h3>Détails</h3>"+$(id).html());
		if($(this).next(".detailsView").css("display") == "none")
		{
			$(this).next(".detailsView").show();
		}
		else
		{
			$(this).next(".detailsView").hide();
		}
	});

	$('#btn1').click(function(){
		$('.stripe1 .stripe-button-el').click();
	})

	$('#btn2').click(function(){
		$('.stripe2 .stripe-button-el').click();
	})

	$('#info').click(function(e){
		e.stopPropagation();
	})

	$('html').click(function(e){
		$('#blackscreen, #info').fadeOut();
	});

	$('.lienPays').click(function(e){
		//$('.villesInfos').hide();
		if($(this).parent().next(".villesInfos").css("display") == "none")
		{
			$(this).parent().next(".villesInfos").show();
		}
		else
		{
			$(this).parent().next(".villesInfos").hide();
		}
	})
});