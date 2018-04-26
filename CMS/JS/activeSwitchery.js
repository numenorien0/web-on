$(function(){
	
	var elems = Array.prototype.slice.call(document.querySelectorAll('input[type=checkbox]'));

	elems.forEach(function(html) {
		if($(html).hasClass("deleteCheckBox") || $(html).hasClass("oldCheckbox"))
		{
			//alert('ok');
		}
		else
		{
			var switchery = new Switchery(html, { size: 'small' });
		}
	});	
	
	
	
})