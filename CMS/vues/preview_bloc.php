<!DOCTYPE html>
<html>
	<head>
		<?php
			$preview = new Preview_bloc();
			$preview->get_header();	
			if($_GET['type'] != "menu")
			{
				$width = "1280";
				$height = "1280";
			}
			else
			{
				$width = "1280";
				$height = "500";
			}
		?>
		<script src="JS/FileSaver.min.js"></script>
		<script src="JS/dom-to-image.min.js"></script>
		<script src="JS/cookie.js"></script>
	</head>
	<body>
		<?php
			#$preview->get_menu();
		?>
		<style>
			html, body
			{
				width: 1280px;
				height: 1280px;				
			}
			.surlignageTitre
			{
				color: #cbcbcb;
				background-color: #cbcbcb;
				margin-top: 10px;
				border-radius: 4px;
				display: inline !important;
				line-height: 200% !important;
				font-size: 100%;
				padding: 0px !important;
				margin-bottom: 10px !important;
				margin-top: 10px !important;
				float: none;
				width:100%;
				clear: both;
				word-break: break-all;
				text-shadow: none !important;
				
			}
			.titre::after
			{
				content: "";
				display: block;
				
			}
			.titre, .description
			{
				text-shadow: none !important;
			}
			.surlignageDescription
			{
				margin-top: 10px;
				color: #edecee;
				background-color: #edecee;
				margin-top: 0px;
				display: inline !important;
				padding: 0px !important;
				line-height: 180% !important;
				border-radius: 4px;	
				float: none;	
				text-shadow: none !important;		
			}
			.callToAction
			{
				border-radius: 4px;
				box-shadow: 0px 2px 2px rgba(0,0,0,0.1);
				position: relative;
				color: transparent !important;
			}
			.callToAction::after
			{
				content: "";
				display: block;
				width: 50px;
				height: 10px;
				left: 0;
				right: 0;
				top: 0;
				bottom: 0;
				margin: auto;
				background-color: #00a9ff;
				position: absolute;				
			}
			.cadre
			{
				border-radius: 4px;
				box-shadow: 0px 2px 2px rgba(0,0,0,0.2);
			}
			.map
			{
				color: transparent;
				background: url("images/mapTemplate.png");
				background-size: cover;
				background-position: center;
			}
			video
			{
				background: url("images/video.jpg");
				background-size: cover;
				background-position: center;
			}
			.nav-item
			{
				padding-top: 0px;
				padding-bottom: 0px;
				color: #cbcbcb;
				background: #cbcbcb;
				font-size: 10px;
				border-radius: 4px;
				position: relative;
				height: 20px;
				overflow: hidden;
			}
			.nav-item:before
			{
				content: "";
				display: block;
				position: absolute;
				left:0;
				top:0;
				right: 0;
				bottom: 0;
				margin: auto;
				width: 50%;
				height: 25%;
				background-color: #e3e3e3;
			}
			
		</style>
		<div id='wrapper' style="background-color: white; width: <?=$width?>px !important; height: <?=$height?>px !important; overflow: hidden !important">
			<?php 
				if($_GET['type'] != "menu")
				{
			?>
			<menu style='padding: 15px; text-align: center; font-size: 40px; margin-bottom: 0px;'>
				<h1 style="text-align: center !important; width: 100% !important">MENU</h1>
			</menu>
			<?php
				}
			?>
		<?php
			if($_GET['type'] == "miniature")
			{
				$preview->get_child($_POST, 1, $_GET['miniature']);
			}
			else
			{
				if($_GET['type'] == "menu")
				{
					$preview->get_menu();
				}
				else
				{
					$preview->get_page();
				}
			}
		?>
		</div>
		<script>
			$(function(){
			
			$(".titre").each(function(){
				
				var contenu = $(this).html();
				$(this).html("<span class='surlignageTitre'>"+contenu+"</span>");
				
			})
			
			$(".description").each(function(){
				
				var contenu = $(this).html();
				$(this).html("<span class='surlignageDescription'>"+contenu+"</span>");
				
			})
			
			$("img, video").each(function(){
				var source = $(this).attr('src');
				source = source.replace("CMS/", "");
				$(this).attr('src', source);
			})
				
			$("marquee").replaceWith($("<div style='width: 100%; text-align: center; padding: 15px'>Bannière défilante de de votre description. Vous y mettez ce que vous voulez, elle défilera.</div>"))	
				
			function post_to_url(url, params1, params2, params3) {
			    var form = document.createElement('form');
			    form.action = url;
			    form.method = 'POST';
			
			    /*var postParam = encodeURIComponent(params);
			    postParam = decodeURIComponent(postParam);*/
			    var input = document.createElement('input');
			    input.type = 'hidden';
			    input.name = 'image';
			    input.value = params1;
			    document.body.appendChild(input);
			    var input2 = document.createElement('input');
			    input2.type = 'hidden';
			    input2.name = 'miniature';
			    input2.value = params2;
			    document.body.appendChild(input2);
			    var input3 = document.createElement('input');
			    input3.type = 'hidden';
			    input3.name = 'type';
			    input3.value = params3;
			    document.body.appendChild(input3);			    
			    form.appendChild(input);
			    form.appendChild(input2); 
			     form.appendChild(input3);  
			    form.submit(); 
			
			}
							
			setTimeout(function(){
				var node = document.getElementById('wrapper');
	
				domtoimage.toPng(node, {width: <?=$width?>, height: <?=$height?>})
				    .then(function (dataUrl) {
				        var img = new Image();
				        img.src = dataUrl;
				        post_to_url("save_image.php", dataUrl, "<?=$_GET['miniature']?>", "<?=$_GET['type']?>");
				        //$.cookie("preview_bloc", "value", {expire: 1});
						//window.location.href = "save_image.php?miniature=<?=$_GET['miniature']?>";
						$(img).insertAfter("#wrapper");
						//document.write(img.src);
						
				        //$('#wrapper').hide();
				        
				        $.ajax({
					        url: "save_image.php",
					        type: "POST",
					        data:{
						        image: dataUrl,
						        miniature: '<?=$_GET['miniature']?>',
						        type: '<?=$_GET['type']?>'
					        }
				        });
				        
				        
				        
				    })
				    .catch(function (error) {
				        console.error('oops, something went wrong!', error);
				    });
			}, 1000);
			});
		</script>
	</body>
</html>


