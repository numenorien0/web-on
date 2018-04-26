$(function(){
	

	
	langChoice();
	
	$('input[type=file]').change(function(){
	    $(this).next("input").val("onchange");
	})
	
	$('.deve').click(function(){
	    if($(this).parent().next('.cat').height() == "0")
	    {
	        $(this).parent().next('.cat').css({"height": "auto"});
	        $(this).text("Réduire");
	    }
	    else
	    {
	        $(this).parent().next('.cat').css({"height": "0"});
	        $(this).text("Développer");
	    }
	})
	
	function langChoice()
	{
		$('.btn_lang').first().addClass("active").text($('.btn_lang').first().attr('data-lang-name'));
		$('.langOption').hide();
		$(".langOption").first().show();
		$('.btn_lang').click(function(){
			$('.btn_lang').removeClass("active");
			$('.btn_lang').each(function(){
				$(this).text($(this).attr('data-lang'));
			});
			$(this).addClass("active");
						
			var langue = $(this).attr('data-lang');
			$(this).text($(this).attr('data-lang-name'));
			$(".langOption").hide();
			$('.langOption[data-lang='+langue+']').show();
		})
	}
	
	
})