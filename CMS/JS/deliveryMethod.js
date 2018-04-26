$(document).ready(function() {
  $(".js-example-basic-multiple").select2();
  if($('#type').val() == "point-de-vente")
  {
	  $('#adresse-block').show();
  }
  else
  {
	  $('#adresse-block').hide();
  }
  $('#type').change(function(){
	  if($('#type').val() == "point-de-vente")
	  {
		  $('#adresse-block').show();
	  }
	  else
	  {
		  $('#adresse-block').hide();
	  }
  })
  
  if($('#type').val() == "Point-de-vente")
  {
	  $('#adresse-block').show();
  }
  else
  {
	  $('#adresse-block').hide();
  }
  	  

  
  var type = $('#type').val();
  if(type == 'nationale')
  {
	  $('option[value=BE]').attr('selected', 'selected')
	  var BE = '<li class="select2-selection__choice BE" title="Belgique"><span class="select2-selection__choice__remove" role="presentation">×</span>Belgique</li>'
	  //$(".js-example-basic-multiple").prop("disabled", true);
	  $('.select2-selection__rendered').append(BE)
	  //alert($('.js-example-basic-multiple.col-md-6.select2-hidden-accessible option[value=BE]').val())
  }
  $('#type').change(function(){
	  var type = $('#type').val();
	  alert(type)

	  if(type == 'nationale')
	  {
		  $('option[value=BE]').attr('selected', 'selected')
		  var BE = '<li class="select2-selection__choice BE" title="Belgique"><span class="select2-selection__choice__remove" role="presentation">×</span>Belgique</li>'
		  $(".js-example-basic-multiple").prop("disabled", true);
		  $('.select2-selection__rendered').append(BE)
		  //alert($('.js-example-basic-multiple.col-md-6.select2-hidden-accessible option[value=BE]').val())
	  }
	  else
	  {
	 	 $(".js-example-basic-multiple").prop("disabled", false);
		  $('option[value=BE]').removeAttr('selected')
		  $('.BE').remove()
	  }
  })
	  
});