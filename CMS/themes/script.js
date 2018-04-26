$(function() {
		$("a").click(function(e) {
			if ($(this).attr('href') == "#") {
				//alert('ok');
				e.preventDefault();
			}
			if ($(this).hasClass("fancybox")) {
				e.preventDefault();
			}
		})
	

/*
	$(document).scroll(function(){
		
		if($(this).scrollTop() > pos.top)
		{
			$(this).addClass('position')
		}
		
	})
*/
	var elementPosition = $('#commentBox').offset();
	var x = $(document).width();
	var marge = $('.container').offset();
	var margin = $('.comment-form').offset();
	var largeur = $('.comment-form').width();
	
	$( window ).resize(function() {
		x = $(document).width();
		marge = $('.container').offset();
		margin = $('.comment-form').offset();
		largeur = $('.comment-form').width();
		//alert('ok');
	})

		/*$(window).scroll(function() {
			//alert(x);
			if(x > 991)
			{
				if ($(window).scrollTop() > elementPosition.top) {
					$('.comment-form').css('position', 'fixed').css('top', '50px').css('left', marge.left+'px').css('width', largeur+'px')
					$('.comment').css('margin-left', largeur+'px')
				}
				if ($(window).scrollTop() < elementPosition.top) {
					$('.comment-form').css('position', '').css('top', '').css('left', '').css('width', '')
					$('.comment').css('margin-left', '')
					//alert('ok')
				}
			}
			else
			{
				$('.comment-form').css('position', '').css('top', '').css('left', '').css('width', '')
				$('.comment').css('margin-left', '')
			}
		});*/
	

	
	$(".stars-default").each(function() {
		var value = $(this).children("input").val();
		$(this).rating('create', {
			value: value,
			glyph: "glyphicon-star"
		});
	})
	$(".stars-post").each(function() {
		var value = $(this).children("input").val();
		$(this).rating('create', {
			value: value,
			glyph: "glyphicon-star"
		}, "true");
	})
	//$('.categories .description').fitText(7);
	$('.miniature-group-1 .image').each(function() {
		var width = $(this).width() / 1.61803398875;
		$(this).height(width);
	})
	$('.square').each(function() {
		var width = $(this).width();
		console.log(width);
		$(this).height(width);
	})
	$('.fancybox').fancybox();
	$('.element').each(function() {
		var $this = $(this);
		if ($this.html().replace(/\s|&nbsp;/g, '').length == 0) $this.remove();
	});
	$('.texte').each(function() {
		var $this = $(this);
		if ($this.html().replace(/\s|&nbsp;/g, '').length == 0) $this.remove();
	});
	$('#language_select').change(function() {
		console.log("change language");
		window.location.href = $(this).val();
	});
	$('.newsletter').submit(function(e) {
		e.preventDefault();
	});
	var width = 0;
	width += $('#topmenu').height();
	width += $('menu').height();
	//alert($('.miniature-25').height() - width);
	$(".miniature .description").each(function() {
		if ($(this).css("text-align") == "center") {
			$(this).parent().parent().find(".callToActionContainer").css({
				"text-align": "center"
			});
		}
	})
	$(".miniature .titre").each(function() {
		if ($(this).css("text-align") == "center") {
			$(this).parent().parent().find(".callToActionContainer").css({
				"text-align": "center"
			});
		}
	})
	if ($("menu").css("position") == "fixed") {
		//$("body").css({"padding-top": width+30+"px"})
	}
	$('.callToAction').each(function() {
		//console.log($(this).css("background-color"));
		if ($(this).attr("style").indexOf("background") >= 0 && $(this).css("background-color") != "rgba(0, 0, 0, 0)") {
			//console.log("ok");
		} else {
			$(this).css({
				"padding-left": "0",
				"padding-right": "0"
			});
		}
		if($(this).text() == "")
		{
			$(this).parent(".callToActionContainer").remove();
		}
	})
	$('.bxslider').bxSlider({
		captions: true,
		adaptiveHeight: true
	});
	
	
	function getCookie(name) {
	  var value = "; " + document.cookie;
	  var parts = value.split("; " + name + "=");
	  if (parts.length == 2) return parts.pop().split(";").shift();
	}
	var pan = getCookie("panier")
	//alert(pan);
	if( pan != null )
	{

		var panier = pan.toString()
		//alert(pan)
		var res = panier.split("%3B");
		//alert(res)
		//alert(res.length)
		var nb = '<span class="badge">'+res.length+'</span>';
		//alert(nb)

		$('a#btn-panier').append(" "+nb)
	
	}
	else
	{
		$('a#btn-panier').append(" <span class='badge'>0</span>")	
	}
})