<?php 
	ob_start();
	$compte = new monCompte();
	
?>
<!DOCTYPE html>
<html>
	<head>		
		<title><?php $compte->title(); ?></title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src='JS/monCompte.js'></script>
		<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" href="CSS/monCompte.css">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script>
				$(function ( $ ) {
				 
				    $.fn.rating = function(method, options ) {
						method = method || 'create';
				        // This is the easiest way to have default options.
				        var settings = $.extend({
				            // These are the defaults.
							limit: 5,
							value: 0,
							glyph: "glyphicon-star",
				            coloroff: "gray",
							coloron: "gold",
							size: "1.3em",
							cursor: "default",
							onClick: function () {},
				            endofarray: "idontmatter"
				        }, options );
						var style = "";
						style = style + "font-size:" + settings.size + "; ";
						style = style + "color:" + settings.coloroff + "; ";
						style = style + "cursor:" + settings.cursor + "; ";
					
				
						
						if (method == 'create')
						{
							//this.html('');	//junk whatever was there
							
							//initialize the data-rating property
							this.each(function(){
								attr = $(this).attr('data-rating');
								if (attr === undefined || attr === false) { $(this).attr('data-rating',settings.value); }
							})
							
							//bolt in the glyphs
							for (var i = 0; i < settings.limit; i++)
							{
								this.append('<span data-value="' + (i+1) + '" class="ratingicon glyphicon ' + settings.glyph + '" style="' + style + '" aria-hidden="true"></span>');
							}
							
							//paint
							this.each(function() { paint($(this)); });
				
						}
						if (method == 'set')
						{
							this.attr('data-rating',options);
							this.each(function() { paint($(this)); });
						}
						if (method == 'get')
						{
							return this.attr('data-rating');
						}
						//register the click events
				/*
						this.find("span.ratingicon").click(function() {
							rating = $(this).attr('data-value')
							$(this).parent().attr('data-rating',rating);
							paint($(this).parent());
							settings.onClick.call( $(this).parent() );
						})
				*/
						function paint(div)
						{
							rating = parseInt(div.attr('data-rating'));
							div.find("input").val(rating);	//if there is an input in the div lets set it's value
							div.find("span.ratingicon").each(function(){	//now paint the stars
								
								var rating = parseInt($(this).parent().attr('data-rating'));
								var value = parseInt($(this).attr('data-value'));
								if (value > rating) { $(this).css('color',settings.coloroff); }
								else { $(this).css('color',settings.coloron); }
							})
						}
				
				    };
				 
				}( jQuery ));	
				
				
				$(document).ready(function(){
				
					$(".stars-default").each(function(){
						var value = $(this).children("input").val();
						$(this).rating('create', {value: value, glyph: "glyphicon-star"});
					})	
				});
		</script>
	</head>
	<body>
		<div class='container wrapper'>
			<?php $compte->menu(); ?>
			<div class='col-md-9'>
				<?php if(isset($_COOKIE['error']) AND $_COOKIE['error'] != ""){ echo $_COOKIE['error'];} ?>
				
				<?php if(isset($compte->_listeErreur) AND $compte->_listeErreur != null){ echo $compte->_listeErreur;} ?>
				<?php
					if($_GET['tab'] == 'moncompte' OR !isset($_GET['tab']))
					{
						$compte->displayCompte();
					}
					if($_GET['tab'] == 'commandes')
					{
						$compte->displayCommandes();
					}
					if($_GET['tab'] == 'adresses' AND !isset($_GET['id']))
					{
						echo "<h2>Vos adresses</h2>";
						$compte->displayAdresse();
					}
					if($_GET['tab'] == 'commentaires')
					{
						echo "<h2>Vos commentaires</h2>";
						$compte->displayCommentaires();
					}
					if($_GET['tab'] == 'download')
					{
						echo "<h2>Vos téléchargements</h2>";
						$compte->displayTelechargement();
					}
				?>
			</div>
		</div>
	</body>
</html>

