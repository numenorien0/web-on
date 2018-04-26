$(function(){
	$(".nextMove").click(function() {
		alert("ok");
	});
	
	$(document).ready(function() {
    	$('#tabClient').DataTable({
	    	"language": {
				"url": "https://cdn.datatables.net/plug-ins/1.10.13/i18n/French.json"
			}
    	});
	});
})