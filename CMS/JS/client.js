$(function(){
	$('#file_btn').click(function(){
		$('#file').click();
	})
	
	 $('#tabCommande, #tabNC').DataTable({
	    	"language": {
				"url": "https://cdn.datatables.net/plug-ins/1.10.13/i18n/French.json"
			}
    	});
})

$('#myTabs a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
})

$( function() {
    $( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();
  } );