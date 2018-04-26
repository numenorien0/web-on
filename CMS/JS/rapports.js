/*
$(function(){
	$( "#customForm" ).submit(function(e) {
		e.preventDefault();
		var startTime = $('#startTime').val();
		var endTime = $('#endTime').val();
		 
		if(startTime === '' && endTime === '') {
            alert('Les champs doivent êtres remplis');
		}
		else
        {
	    	$.ajax({
					url: "rapports.php",
					type: "POST",
					data: {
						endTime: $("#endTime").val(),
						startTime: $("#startTime").val()
					}
			})
			.done(function(html){		
				var newCat = "<div class='arborescence col-sm-12 visiblePage' data-id='"+$('#laID').val()+"' data-parent='"+$('#idCtg').val()+"'><span class='col-sm-10 nomCategory'>"+$('#addCat').val()+"</span><input data-id='"+$('#laID').val()+"' data-parent='"+$('#idCtg').val()+"'class='bnt' type='button' value='Sélectionner'/><span class='hidden'><input id='"+$('#laID').val()+"'type='checkbox' value='"+$('#laID').val()+"' name='categories[]'></span></div>";
				$(newCat).appendTo(".listeCategory");
			});
		}
	});
})
*/