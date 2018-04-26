<!DOCTYPE html>
<html>
    <head>
        <?php

            $medias = new Medias();
        ?>
        <?=$includeJSAndCSS;?>
       
       
    </head>
    <body>
        <?php
        	$db = new DB();
        	//print_r($db->listAllLang());list_all_language
        	$lang = [];
        	$allLang = $db->listAllLang();
        	foreach($db->list_all_language() as $currentLang)
        	{
        	    $lang[] = array($currentLang, $allLang[$currentLang]);
        	}
        	//print_r($lang);
        	//$lang = [["fr", "français"], ["en", "anglais"], ["it", "italien"]];
        	global $lang;
        ?>
        <script>
        var lang = <?=json_encode($lang)?>;
        function hideOtherLang()
        {
        	$('*[data-lang]').hide();
        	$('*[data-lang="'+lang[0][0]+'"]').show();
        	$('.selectLang[data-tab="'+lang[0][0]+'"]').addClass("activeLang")
        }
        
        function displayAllLangTab(where)
        {
        	var tabLang = "";
        	$.each(lang, function(i,v){
        		tabLang += "<a href='#' class='selectLang' data-tab='"+v[0]+"'>"+v[1]+"</a>";
        	});
        	
        	return tabLang;
        }
        
        function parseJSONresponse(response, lang)
        {
        	var parsed;
        	//alert(response);
        	try{
        		parsed = $.parseJSON(response)[lang];
        		//alert($.parseJSON(response));
        	}
        	catch(e){
        		
        	}
        	
        	if(typeof parsed !== 'undefined')
        	{
        		return parsed;
        	}
        	else
        	{
        		return "";
        	}
        }
        
        
        
        $(document).on("click", ".selectLang", function(){
        	$('*[data-lang]').hide();
        	$('.activeLang').removeClass("activeLang");
        	$(this).addClass("activeLang");
        	var selectedLanguage = $(this).attr("data-tab");
        	$('*[data-lang="'+selectedLanguage+'"]').show();
        })
        </script>
        
        <div class='connectForm'></div>
        <div id='page' class='container-fluid'>
            
            <div style='' class='body'>
                <div id='containerBody'>
                    <h1 id='titlePage'><i class="fa fa-image"></i> Médias</h1>
                    <div id='contentContainer' class='firstContainer contentContainer col-md-9'>
                        <div class='cadre'>
                            <h3>#bibliothèque</h3>
                            <div id='dropfile' class='library'>
	                            <div class='result'>
		                            <div class='row'>
			                           <div class='col-md-12'>
				                            Afficher les éléments de 
				                            <input id='monthChoose' type='month' value='<?=date("Y-m")?>'/>
			                           </div>
		                            </div>
		                            <div class='row listFile' style='padding: 0'>
		                            <?php 
			                            $date = date("m/01/Y");
			                            $date = strtotime($date);
			                            
			                            $images = $medias->get_medias($date, "intermediate");
			                            if($images == "none")
			                            {
				                            ?>
				                            	<div class='noMedia'>Pas de médias, glissez des images ici pour commencer</div>
				                            <?php
					                            
			                            }
			                            else
			                            {
				                            foreach($images as $image)
				                            {
				                                $positionExtension = strrpos($image['file'], ".");
		                                        $extension = substr($image['file'], $positionExtension);
		                                        
		                                        if($image["type"] === "video")
		                                        {
		                                            echo "<div class='imageLibraryContainer col-md-2'><div style='overflow: hidden' class='col-md-12 imageLibrary' data-alt='".$image['alt']."' data-parent='".$image['ID']."' data-id='".$image['ID']."' data-src='".$image['file']."' data-type='".$image["type"]."' style='background-image: url(".$image['file']."); background-size: cover; background-position: center;'><video src='".$image['file']."' loop controls muted style='object-fit: cover; width: 100%; height: 100%;'></video></div></div>";
		                                        }
		                                        else
		                                        {
		  				                            echo "<div class='imageLibraryContainer col-md-2'><div class='col-md-12 imageLibrary' data-alt='".$image['alt']."' data-parent='".$image['parent']."' data-id='".$image['ID']."' data-src='".$image['file']."' data-type='".$image["type"]."' style='background-image: url(".$image['file']."); background-size: cover; background-position: center;'></div></div>";

		                                        }
		                                        
				                            }
			                            }
			                            
		                            ?>
		                            </div>
	                            </div>
                            </div>
                        </div>
                    </div>
                    <div class='contentContainer col-md-3'>
	                    <div class='cadre status'>
	                    	<h3>#Status</h3>
							<div class='row'><h5 class='col-sm-12' style='margin-top: 20px; text-align: center' id='status'>&nbsp</h5></div>
							<div class='row'><progress style='margin-top: 5px; margin-bottom: 15px;' id='progressBar' value='0' max='100' class='col-sm-10 col-sm-push-1'></progress></div>
							
	                    </div>
                        <div class='cadre'>
                            <h3>#Informations</h3>
                            <div class='imageContainer'></div>
                            <div class='formContainer'></div>
                            
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>