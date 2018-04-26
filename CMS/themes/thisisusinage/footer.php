		<footer style='margin-top: 50px'>
		    <?php
			    include($pilot->get_theme_path()."/header.php");
			    echo $pilot->get_analytics();
		    ?>
			<div class='photos'>
				<img class='hidden-xs' src='<?=$pilot->get_theme_path()?>/images/Version1.png'/>
				<img class='hidden-xs' src='<?=$pilot->get_theme_path()?>/images/Version2.png'/>
				<img src='<?=$pilot->get_theme_path()?>/images/Version3.png'/>
			</div>
			<div id='footer'>
				
				<div class='container'>
					<div class='col-md-12' style=''>
						<h2 style='text-align: left; margin-bottom: 30px'>Partenaires</h2>
						<div class='row'>
						<?php 
							
							$folder = $pilot->get_theme_path()."/images/partenaires/";
							$dossier = scandir($folder);
							
							foreach($dossier as $file)
							{
								if($file != "." AND $file != "..")
								{
									echo "<div class='col-md-2 col-xs-4' style='padding: 7px'><div class='part' style='display: flex; height: 70px'><img style='margin: auto; max-width: 100%; max-height: 100%' src='".$folder.$file."'/></div></div>";
								}
							}
							
						?>
						</div>
					</div>
					
					<div class='col-md-12'>
						<h2 style='text-align: left; margin-bottom: 30px'>Adresse</h2>
						<p>
							<strong>TECHNIFUTUR® Asbl Liège</strong><br/>
							Science Park - Rue Bois Saint-Jean, <br>
							15-17 • B-4102 - Seraing<br/>
							T : +32 (0)4 382 45 45<br>
							F : +32 (0)4 382 44 55<br>	
							M : info@technifutur.be<br>
						</p>
						<img src='<?=$pilot->get_theme_path()?>/images/site-photo.jpg' style='width: 100%'/>
					</div>
				</div>
				<script>
					$(function(){
						$(".part").each(function(){
							var width = $(this).width();
							$(this).height(width);
						});
						var timer = 7000;
						$('.slider').hide().css({"left":"100%"});
						$(".slider").first().show().css({"left":"0"});
						var elem = $('.slider').first();
						
						setTimeout(function(){
							carousel(elem);
							
						}, timer);
						
						function carousel(elem)
						{
							$(elem).animate({"left":"-100%"}, 1000, function(){
								$(this).hide().css({"left":"100%"})
							});
							if($(elem).next(".slider").length)
							{
								//alert("ok");
								var elem = $(elem).next(".slider")
							}
							else
							{
								var elem = $(".slider").first();	
							}
							$(elem).show().animate({"left": "0%"}, 1000);
							
							setTimeout(function(){
								carousel(elem);
							
							}, timer);
							
						}
						
						
						$(".arrow i").click(function(){
							var scroll = $("#save").offset().top;
							//alert(scroll);
							var body = $("html, body");
							body.stop().animate({scrollTop:scroll}, 500, 'swing', function() { 
							   //alert("Finished animating");
							});
						})
						
						
						
					})
				</script>
				
			</div>
		</footer>
	</body>
</html>