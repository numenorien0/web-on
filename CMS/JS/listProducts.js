$(function(){
	$(".nextMove").click(function() {
		alert("ok");
	});

	$('.delete').click(function(e){
		e.preventDefault();
		var lienToDelete = $(this).attr('href');
		bootbox.confirm("Voulez-vous vraiment supprimer ce produit?", function(result){
			if(result == true)
			{
				window.location.href = lienToDelete;
			}
		});
		
	});	
	
    	$('#tabProduit').DataTable({
	    	"language": {
				"url": "https://cdn.datatables.net/plug-ins/1.10.13/i18n/French.json"
			},
			"lengthMenu": [[50, 100, 200, -1], [50, 100, 200, "All"]]
    	});
    	$('.stockValue').keydown(function(e){
	    	if(e.keyCode == "13")
	    	{
		    	$(this).next(".addStock").click();
	    	}
    	})
    	$('.addStock').click(function(){
	    	var id = $(this).prev("input").attr('data-id');
	    	var value = $(this).prev("input").val();
	    	var elem = $(this);
	    	//alert(id + " - "+value);
	    	
	    	$.ajax({
		    	url: "listProducts.php?addStock="+value+"&IDproduct="+id
	    	}).done(function(html){
		    	$(elem).prev("input").val("");
		    	var stock = parseInt($(elem).parent().prev("td").text());
		    	stock = stock + parseInt(value);
		    	$(elem).parent().prev("td").text(stock);
	    	})
    	})
})