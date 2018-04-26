<!DOCTYPE html>
<html>
<head>
	<title>Pilot - Rapports de vente</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?=$includeJSAndCSS;?>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>
</head>
<body>
<div class='container-fluid'>
	<?php
		include("includes/menu.php");
		$options = new Rapports();
	?>
	<div id='wrapper' class='col-sm-10'>
		<h2 class='cadre row'><div class='container'>Rapports de vente</div></h2>
		<?php include('includes/ecommerceMenu.php')?>
		<div class='col-sm-12 col-lg-10 col-lg-offset-1' style='padding: 0' >
			<div class='col-md-3 colonneGauche colonne'>
				<?php $options->verticalMenu(); ?>
			</div>

			<div class='col-md-9 colonneDroite colonne'>
				<?php $options->dataDisplay();?>
			
			</div>
		</div>
	</div>
</div>
<script>
	(function($) {
		"use strict";
		function count($this){
		var current = parseFloat($this.html(), 10);
		current = current + 0; /* Where 50 is increment */	
		$this.html(++current);
			if(current > $this.data('count')){
				$this.html($this.data('count'));
			} else {    
				setTimeout(function(){count($this)}, 10);
			}
		}        	
		$(".stat-count").each(function() {
		  $(this).data('count', parseFloat($(this).html(), 10));
		  $(this).html('0');
		  count($(this));
		});
   })(jQuery);
   
   (function($) {
		"use strict";
		function count($this){
		var current = parseInt($this.html(), 10);
		current = current + 0; /* Where 50 is increment */	
		$this.html(++current);
			if(current > $this.data('count')){
				$this.html($this.data('count'));
			} else {    
				setTimeout(function(){count($this)}, 10);
			}
		}        	
		$(".stat-count-int").each(function() {
		  $(this).data('count', parseInt($(this).html(), 10));
		  $(this).html('0');
		  count($(this));
		});
   })(jQuery);
</script>
<?php if(isset($_GET['tab']) AND $_GET['tab'] == "vuedensemble")
	{
?>
<script>
	<?php if(!isset($_GET['startTime']) AND !isset($_GET['endTime']))
		{
	?>
			$('#7daysSalesBtn').removeClass('btn_analytics');
			$('#7daysSalesBtn').addClass('btn_analytics-selected');
	<?php
		}
	?>
	$( "#customSalesForm" ).hide();
	var ctx = document.getElementById("myChart").getContext('2d');
	var myChart = new Chart(ctx, {
		type: 'bar',
		options: {
			title: {
				display: true,
				text: 'Ventes des 7 derniers jours'
  			}
		},
		data: {
		    labels: [<?php $options->load7Days(); ?>],
			datasets: [{
		      	label: 'Ventes totales',
		      	backgroundColor: "rgba(30, 114, 0, 0.4)",
			  	data: [<?php $options->dataSales7days(); ?>]
		    },
		    {
		      label: 'Ventes ♀',
		      backgroundColor: "rgba(0, 55, 183, 0.4)",
		      data: [<?php $options->womenSales7daysData(); ?>]
		    },
		    {
		      label: 'Ventes ♂',
		      backgroundColor: "rgba(241, 181, 0, 0.4)",
		      data: [<?php $options->menSales7daysData(); ?>]
		    }]
		}
	});
	
	

	<?php
		if(isset($_GET['startTime']) AND isset($_GET['endTime']))
		{
			echo "$( '#7daysSalesChart' ).hide();";
		}
	?>
	var ctx2 = document.getElementById("MonthSalChart").getContext('2d');
	var myChart2 = new Chart(ctx2, {
		type: 'bar',
		options: {
			title: {
				display: true,
				text: 'Ventes du mois en cours'
  			}
		},
		data: {
		    labels: [<?php $options->loadMonth(); ?>],
			datasets: [{
		      	label: 'Ventes totales',
		      	backgroundColor: "rgba(30, 114, 0, 0.4)",
			  	data: [<?php $options->dataSalesMonth(); ?>]
		    },
		    {
		      label: 'Ventes ♀',
		      backgroundColor: "rgba(0, 55, 183, 0.4)",
		      data: [<?php $options->womenSalesMonthData(); ?>]
		    },
		    {
		      label: 'Ventes ♂',
		      backgroundColor: "rgba(241, 181, 0, 0.4)",
		      data: [<?php $options->menSalesMonthData(); ?>]
		    }]
		}
	});
		
	$( '#monthSalesChart' ).hide();
	<?php 
		if(isset($_GET['startTime']) AND isset($_GET['endTime']))
		{?>
			var ctx3 = document.getElementById("customSalChart").getContext('2d');
			var myChart3 = new Chart(ctx3, {
				type: 'bar',
				options: {
					title: {
						display: true,
						text: "Ventes du <?php echo date("d-m-y", strtotime($_GET['startTime']))." au ".date("j-m-y", strtotime($_GET['endTime'])); ?>"
  					}
				},
				data: {
				    labels: [<?php $options->loadCustom(); ?>],
					datasets: [{
				      	label: 'Ventes totales',
				      	backgroundColor: "rgba(30, 114, 0, 0.4)",
					  	data: [<?php $options->dataSalesCustom(); ?>]
				    },
				    {
				      label: 'Ventes ♀',
				      backgroundColor: "rgba(0, 55, 183, 0.4)",
				      data: [<?php $options->womenSalesCustomData(); ?>]
				    },
				    {
				      label: 'Ventes ♂',
				      backgroundColor: "rgba(241, 181, 0, 0.4)",
				      data: [<?php $options->menSalesCustomData(); ?>]
				    }]
				}
			});
		
	<?php 
		}
	?>
	
	$( "#monthSalesBtn" ).click(function() {
		$('#customSalesBtn').removeClass('btn_analytics-selected');
		$('#customSalesBtn').addClass('btn_analytics');
		$('#7daysSalesBtn').removeClass('btn_analytics-selected');
		$('#7daysSalesBtn').addClass('btn_analytics');
		$( ".salesChart" ).hide();
		$( "#customSalesForm" ).hide();
		$( "#monthSalesChart" ).show();
	});

	$( "#7daysSalesBtn" ).click(function() {
		$('#customSalesBtn').removeClass('btn_analytics-selected');
		$('#customSalesBtn').addClass('btn_analytics');
		$( ".salesChart" ).hide();
		$( "#customSalesForm" ).hide();
		$( "#7daysSalesChart" ).show();
	});

	$("html").click(function() {
		$( "#customSalesForm" ).hide();
	});
	$("#customSalesInputBtn").click(function(e) {
			e.stopPropagation();
			$('#customSalesBtn').removeClass('btn_analytics-selected');
			$('#customSalesBtn').addClass('btn_analytics');
			$('#7daysSalesBtn').removeClass('btn_analytics-selected');
			$('#7daysSalesBtn').addClass('btn_analytics');
			$("#customSalesForm").show();
	});
	
	$("#customSalesForm").click(function(e){
		e.stopPropagation();
	});
	
	
	$( "#customSalesBtn" ).click(function() {
		$('#customSalesBtn').removeClass('btn_analytics-selected');
		$('#customSalesBtn').addClass('btn_analytics');
		$('#7daysSalesBtn').removeClass('btn_analytics-selected');
		$('#7daysSalesBtn').addClass('btn_analytics');
		$( ".salesChart" ).hide();
		$( "#customSalesForm" ).hide();
		$( "#customSalesChart" ).show();
	});
   $( "#customSalesForm" ).draggable({ containment: "#wrapper" });

	
</script>
<?php } 
	if(isset($_GET['tab']) AND $_GET['tab']=='clients')
	{
?>
<script>
	<?php if(!isset($_GET['startTime']) AND !isset($_GET['endTime']))
		{
	?>
			$('#allSexBtn').removeClass('btn_analytics');
			$('#allSexBtn').addClass('btn_analytics-selected');
			
	<?php
		}
	?>
	
	var ctx4 = document.getElementById("radarChart").getContext('2d');
	var radarChart4 = new Chart(ctx4, {
	  type: 'doughnut',
	  options: {
					title: {
						display: true,
						text: "Tous les inscrits"
  					}
				},

	  data: {
	    labels: ["Hommes", "Femmes"],
	    datasets: [{
	      backgroundColor: [
	        "#2ecc71",
	        "#3498db"
	      ],
	      data: [<?php $options->sexData(); ?>]
	    }]
	  }
	});
	
	<?php 
		if(isset($_GET['startTime']) AND isset($_GET['endTime']))
		{
	?>
			$( '#radarChart' ).hide();
			var ctx7 = document.getElementById("customSexChart").getContext('2d');
			var radarChart7 = new Chart(ctx7, {
			  type: 'doughnut',
			  options: {
					title: {
						display: true,
						text: "Inscriptions du <?php echo date("d-m-y", strtotime($_GET['startTime']))." au ".date("j-m-y", strtotime($_GET['endTime'])); ?>"
  					}
				},
			  data: {
			    labels: ["Hommes", "Femmes"],
			    datasets: [{
			      backgroundColor: [
			        "#2ecc71",
			        "#3498db"
			      ],
			      data: [<?php $options->sexCustomData(); ?>]
			    }]
			  }
			});
		
			
	<?php
		}
	?>
	var ctx6 = document.getElementById("7daysSexChart").getContext('2d');
	var radarChart6 = new Chart(ctx6, {
	  type: 'doughnut',
	  options: {
		  
					title: {
						display: true,
						text: "Inscriptions ces 7 derniers jours"
  					}
				},
	  data: {
	    labels: ["Hommes", "Femmes"],
	    datasets: [{
	      backgroundColor: [
	        "#2ecc71",
	        "#3498db"
	      ],
	      data: [<?php $options->sex7daysData(); ?>]
	    }]
	  }
	});
	$( '#7daysSexChart' ).hide();
	
	var ctx5 = document.getElementById("monthSexChart").getContext('2d');
	var radarChart5 = new Chart(ctx5, {
	  type: 'doughnut',
	  options: {
					title: {
						display: true,
						text: "Inscriptions de ce mois"
  					}
				},
	  data: {
	    labels: ["Hommes", "Femmes"],
	    datasets: [{
	      backgroundColor: [
	        "#2ecc71",
	        "#3498db"
	      ],
	      data: [<?php $options->sexMonthData(); ?>]
	    }]
	  }
	});
	
	var ctx8 = document.getElementById("languagesClientsChart").getContext('2d');
	var radarChart8 = new Chart(ctx8, {
	  type: 'doughnut',
	  options: {
					title: {
						display: true,
						text: "Langues des inscrits"
  					}
				},
	  data: {
	    labels: [<?php echo $options->_langName; ?>],
	    datasets: [{
	      backgroundColor: [
	        "#2ecc71",
	        "#3498db"
	      ],
	      data: [<?php echo $options->_lang; ?>]
	    }]
	  }
	});
	$( '#monthSexChart' ).hide();
	$( '#customSexForm' ).hide();

	$( "#allSexBtn" ).click(function() {
		$('.btn_analytics').removeClass('btn_analytics-selected');
		$( ".sexChart" ).hide();
		$( "#customSexForm" ).hide();
		$( "#radarChart" ).show();
	});	

	$( "#monthSexBtn" ).click(function() {
		$('.btn_analytics').removeClass('btn_analytics-selected');
		$( ".sexChart" ).hide();
		$( "#customSexForm" ).hide();
		$( "#monthSexChart" ).show();
	});

	$( "#7daysSexBtn" ).click(function() {
		$('.btn_analytics').removeClass('btn_analytics-selected');
		$( ".sexChart" ).hide();
		$( "#customSexForm" ).hide();
		$( "#7daysSexChart" ).show();
	});

	$("html").click(function() {
		$( "#customSexForm" ).hide();
	});
	$("#customSexInputBtn").click(function(e) {
			e.stopPropagation();
			$('.btn_analytics').removeClass('btn_analytics-selected');
			$("#customSexForm").show();
	});
	
	$("#customSexForm").click(function(e){
		e.stopPropagation();
	});
	
	$('#customSexBtn').addClass('btn_analytics-selected');
	
	$( "#customSexBtn" ).click(function() {
		$('.btn_analytics').removeClass('btn_analytics-selected');

		$( ".sexChart" ).hide();
		$( "#customSexForm" ).hide();
		$( "#customSexChart" ).show();
	});

	
	$( "#customSexForm" ).draggable({ containment: "#wrapper" });
</script>
<?php }$options->produitsVendus(); ?>


	
	<?php
	if(isset($_GET['tab']) AND $_GET['tab']=='produits')
	{
		
	?>
	<script>
	var ctx4 = document.getElementById("produitsVendus").getContext('2d');
	var data = {
	    labels: [<?php echo $options->_nomAll; ?>],
	    datasets: [
	        {
	            label: "Ventes totales",
	            backgroundColor: [
	                'rgba(255, 99, 132, 0.2)',
	                'rgba(54, 162, 235, 0.2)',
	                'rgba(255, 206, 86, 0.2)',
	                'rgba(75, 192, 192, 0.2)',
	                'rgba(153, 102, 255, 0.2)',
	                'rgba(255, 159, 64, 0.2)'
	            ],
	            borderColor: [
	                'rgba(255,99,132,1)',
	                'rgba(54, 162, 235, 1)',
	                'rgba(255, 206, 86, 1)',
	                'rgba(75, 192, 192, 1)',
	                'rgba(153, 102, 255, 1)',
	                'rgba(255, 159, 64, 1)'
	            ],
	            borderWidth: 1,
	            data: [<?php echo $options->_quantiteAll; ?>],
	        }
	    ]
	};
	var radarChart4 = new Chart(ctx4, {
	  data: data,
    type: 'bar',
    options:{
	    
    }
	});
	</script>
	<?php 
	}
	?>

</body>
</html>

