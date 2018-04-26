<?php
	include("includes/contextMenu.php");	
?>
<div class='log'>
</div>
<div class='epinglemoica'>
    <a id='addEpingle' href='#'><i class="fas fa-thumbtack"></i> Epingler cette page</a>
    <div style='margin-top: 15px' class='epingleInput'>
        <input type='text' style='margin-top: 5px' id='epingleName' placeholder="Nom de l'épingle" />
        <input style='margin-top: -20px' id='epingler' type='button' value='Epingler !'/>
    </div>
</div>
<div id='infowindow'>
<div class='' style='text-align: left; color: #666666'>
<h4 style='font-weight: bold; text-align: center; font-size: 32px; '>Aide <img style='height: 25px; margn-top: -20px;' src='images/question.png'/></h4>
<h3 style='margin-top: 20px; text-align: center'>Pas d'aide disponible</h3>
</div>
</div>
<div id='menu' class='col-sm-2 sidebar-nav'>

	<div id='logo' class='row' style='text-align:center; margin: <?=$margin?> 0px'><img style='width: 250px; max-width: <?=$size?>' src='images/<?=$logo?>'/></div>
<!-- 	<a class='col-sm-12' id='tableauDeBord' href='index.php'><img src='images/dashboard.png'>Tableau de bord</a> -->
	<a class='col-sm-12' href='analyse.php'><div class='imageContainerMenu'><i class="fal fa-chart-bar"></i></div>Statistiques</a>
<!-- 	<a class='col-sm-12' href='mailing.php'><img src='images/mailbox.png'>Newsletters</a> -->
	<a class='col-sm-12' href='listContent.php'><div class='imageContainerMenu'><i class="fal fa-file"></i></div>Contenu</a>
	<?php
		$db = new DB();
		if($db->ecommerce_is_actived())
		{	
	?>
	<a class='col-sm-12' href='ecommerce.php'><div class='imageContainerMenu'><img src='images/shop.png'></div>E-shop</a>
	<?php
		}	
	?>
<!--		<div class='col-sm-12 submenu'>

			<a class='col-sm-12 submenuChild' href='menu.php'><div class='imageContainerMenu'><img src='images/compass.png'></div>Menu</a>
			<a class='col-sm-12 submenuChild' href='listContent.php'><div class='imageContainerMenu'><img src='images/texte.png'></div>Pages</a>
			<a class='col-sm-12 submenuChild' href='footer.php'><div class='imageContainerMenu'><img src='images/footwear.png'></div>Pied de page</a>
			<a class='col-sm-12 submenuChild' href='template.php'><div class='imageContainerMenu'><img src='images/cube.png'></div>Modèle de contenu</a>

		</div>-->
	<a class='col-sm-12' href='design.php'><div class='imageContainerMenu'><i class="fal fa-paint-brush"></i></div>Thèmes</a>
	<a class='col-sm-12' href='outils.php'><div class='imageContainerMenu'><i class="fab fa-app-store"></i></div>Applications</a>
	
<!--
	<div class='col-sm-12 submenu'>
		<a class='col-sm-10 col-sm-offset-2 submenuChild' href='addContent.php'>- Ajouter</a>
		<a class='col-sm-10 col-sm-offset-2 submenuChild' href='listContent.php'>- Liste</a>
	</div>
-->
<!-- 	<a class='col-sm-12' href='listMedias.php'><img src='images/multimedia.png'>Médias</a> -->
<!-- 	<div class='col-sm-12 submenu'>
		<a class='col-sm-10 col-sm-offset-2 submenuChild' href='#'>- Ajouter</a>
		<a class='col-sm-10 col-sm-offset-2 submenuChild' href='listMedias.php'>- Liste</a>
	</div> -->
	<a class='col-sm-12' href='profil.php'><div class='imageContainerMenu'><i class="fal fa-user"></i></div>Profil</a>
	<a class='col-sm-12' href='#'><div class='imageContainerMenu'><i class="fal fa-sliders-h"></i></div>Options</a>
	<div class='col-sm-12 submenu'>
		<a class='col-sm-12 submenuChild' href='options.php'><div class='imageContainerMenu'><i class="fal fa-cogs"></i></div>Système</a>
		<a class='col-sm-12 submenuChild' href='options-users.php'><div class='imageContainerMenu'><i class="fal fa-users"></i></div>Utilisateurs</a>
		<a class='col-sm-12 submenuChild' href='options-website.php'><div class='imageContainerMenu'><i class="fab fa-safari"></i></div>Site internet</a>
	</div>
    
	<?php 
	
	$epingle = file_get_contents("content/epingle.json");
	$epingle = json_decode($epingle, true);
	if(count($epingle))
	{
	    ?><hr class='col-sm-12' style='padding: 0'><?php
	}
	foreach($epingle as $nom => $lien)
	{
	    ?>
	    <a class='col-sm-12' href='<?=$lien?>'><div class='imageContainerMenu'><i class="fas fa-thumbtack"></i></div> <?=$nom?> <span class='remove removeEpingle' data-remove='<?=$nom?>'><i class="fal fa-times"></i></span></a>
	    <?php
	}
	if(count($epingle))
	{
	    ?><hr class='col-sm-12' style='padding: 0'><?php
	}
	?>

	<a id='onvousaide' class='col-sm-12' href='#'><div class='imageContainerMenu'><i class="fal fa-question-circle"></i></div>Aide</a>
	<a class='col-sm-12' href='deconnexion.php'><div class='imageContainerMenu'><i class="fal fa-sign-out"></i></div>Déconnexion</a>
	
	<?php
		echo "<input type='hidden' value='".$_GET['f']."' id='page'/>";
		$install = new Install();
		$install->detectInstallation();
		$login = new Login();
		$maj = new Update();
		if($maj->checkUpdate() == true)
		{
			$updateDispo = "<span class='update'>Une mise à jour est disponible!</span>";
		}
		else
		{
			$updateDispo = "";
		}
		$login->verificationConnecte();
		$ouvertureDuFichierDeVersion = file_get_contents("version.txt");
		$_SESSION['version'] = $ouvertureDuFichierDeVersion;
		echo '<div id="version"><a href="feedback.php" class="feedback">Laissez-nous un feedback</a>Version  '.$_SESSION['version'].'<br/>'.$updateDispo.'</div>';
	
	
	?>
<!--
<div id="triangle">
	
</div>
-->
</div>
	<div class='blackScreen'>
	</div>
	<div class='iframe'>
	</div>
	<div class='popup'>
	</div>
<script>
$(function(){
    var page = window.location.href;
    
    
    $('.epingleInput').hide();
    $('#addEpingle').click(function(e){
        e.preventDefault();
        $(".epingleInput").show();
        $('#epingleName').focus();
    })
    
     $('#epingleName').on("keyup", function(e){
         if(e.keyCode == 13)
         {
             $('#epingler').click();
         }
     })
    
    $('#epingler').click(function(){
        if($('#epingleName').val() != "")
        {
            $.ajax({
                url: "ajax/epingle.php",
                data:{
                    action: "add",
                    name: $('#epingleName').val(),
                    url: page
                }
            }).done(function(){
                window.location.reload(true);
            })
        }
    });
    
    $('#menu .removeEpingle').on("click", function(e){
        //alert("ok");
        e.stopPropagation();
        var name = $(this).attr('data-remove');
        $.ajax({
            url: "ajax/epingle.php?action=remove&name="+name
        }).done(function(){
            window.location.reload(true);
        })
    })
});
</script>
	<script>
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
	    
	</script>
<?php 
// API SHORTCODE
function add_shortcode($nom, $shortcode, $description)
{
    if(!file_exists("content/shortcode.json"))
    {
        $array = json_encode([]);
        file_put_contents("content/shortcode.json", $array);
        
    }
    
    $fichierJson = json_decode(file_get_contents("content/shortcode.json"), true);
    $fichierJson[$nom] = array("shortcode" => $shortcode, "description" => $description);
    $fichierJson = json_encode($fichierJson);
    file_put_contents("content/shortcode.json", $fichierJson);
}

function delete_shortcode($nom)
{
    $fichierJson = json_decode(file_get_contents("content/shortcode.json"), true);
    unset($fichierJson[$nom]);
    $fichierJson = json_encode($fichierJson);
    file_put_contents("content/shortcode.json", $fichierJson);
}

function list_shortcode()
{
    $json = file_get_contents("content/shortcode.json");
    $fichierJson = json_decode($json, true);
    
    echo "<div style='text-align: center' class='allShortcode'><div class='col-sm-12'>";
    echo "<h4>Liste des shortcode</h4>";
    echo "<select class='shortcode'>";
    foreach($fichierJson as $key => $json)
    {
        echo "<option value='".$json['shortcode']."'>$key</option>";
    }
    echo "</select>";
    echo "<input type='button' value='Ajouter' id='addshortCode'/>";
    echo "</div></div>";
    return $fichierJson;
}
list_shortcode();
//add_shortcode("coucouuu", "[shortcode my2 gueule]", "Coucou");

?>

