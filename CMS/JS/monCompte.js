$(function(){
	
	$(".pop").hide();
	
	$('.lien-vert').click(function(){
		var idSelect = $(this).attr('data-id');
		$("#js-example-basic-single-"+idSelect).select2();
		$("#js-example-basic-single-type-"+idSelect).select2();
	})
	
	$("#js-example-basic-single").select2();
	$("#js-example-basic-single-type").select2();
	
	$(".test").hover(function(){
		var idCom = $(this).attr('data-id');
		$("#pop"+idCom).toggle();
	})
	
	$('#dateChange').change(function(){
		var date = $(this).val();
		//alert(date);
		window.location.href="?tab=commandes&date="+date;
		
	})
	
})

