$(function(){
	var referrers = $("#referrersDeBase").html();
    $('.otherLink').click(function(){
		$('#referrersDeBase').html($('#OtherSub').html());
		$('#back').show();		
	});
	$('#back').click(function(){
		$('#back').hide();
		$('#referrersDeBase').html(referrers);
	    $('.socialLink').click(function(){
			$('#referrersDeBase').html($('#SocialSub').html());
			$('#back').show();		
		});
	    $('.searchLink').click(function(){
		    //alert('ok');
			$('#referrersDeBase').html($('#SearchSub').html());
			$('#back').show();			
		});
	    $('.otherLink').click(function(){
			$('#referrersDeBase').html($('#OtherSub').html());
			$('#back').show();			
		});
	})	


    $('.socialLink').click(function(){
		$('#referrersDeBase').html($('#SocialSub').html());
		$('#back').show();		
	});


    $('.searchLink').click(function(){
	    //alert('ok');
		$('#referrersDeBase').html($('#SearchSub').html());
		$('#back').show();			
	});
	
	
	$('.custom').click(function(e){
		var position = $(this).position().left;
		e.stopPropagation();
		$('#customForm').css({"display":"inline-block", "left":position});
	});
	
	$('#customForm').click(function(e){
		e.stopPropagation();
	})
	
	$('html').click(function(){
		//alert('ok');
		$('#customForm').css({"display":"none"});
	});
	
	
	$('#submit').click(function(){
	
		if($('#du').val() != "" && $('#au').val() != "")
		{
			var display = "day";
			if($('#month').is(":checked"))
			{
				display = "month";	
			}
			var du = $('#du').val();
			du = new Date(du);
			du = du.getTime()/1000;
			var au = $('#au').val();
			au = new Date(au);
			au = au.getTime()/1000;
			window.location.href = "?from="+du+"&to="+au+"&displayBy="+display+"&filter=custom#buttonDate";
		}
		//var value = $(this).val();
		//alert(value);
		//value = new Date(value);
		//value = value.getTime();
		//$('#duValue').val(value);
	})
	
		    	
})