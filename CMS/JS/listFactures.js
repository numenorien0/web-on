$(function(){
	$('#tabfacture, #tabNC').DataTable({
    	"language": {
			"url": "https://cdn.datatables.net/plug-ins/1.10.13/i18n/French.json"
		}
	});

	$('#download').click(function(){
		var start = $("#startDate").val();
		var end = $("#endDate").val();
		
		window.location.href = '?start='+start+"&end="+end;
		
	})
	
	$('#downloadNC').click(function(){
		var start = $("#startDateNC").val();
		var end = $("#endDateNC").val();
		
		window.location.href = '?startNC='+start+"&endNC="+end;
		
	})
	
})