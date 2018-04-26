<!DOCTYPE html>
<html>
	<head>
	    <?=$pilot->get_base()?>
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?=$pilot->get_site_title()?> - <?=$pilot->get_title()?></title>
	    <link rel='icon' href='<?=$pilot->get_favicon()?>'/>
	</head>
	<body>
		<menu>
		
			<div class='container' style='position: relative'>
				<div class='mots-1'>
					
					<div class='mot'>pénurie</div>
					<div class='mot'>carriere</div>
					<div class='mot'>bio tech</div>
					<div class='mot'>propre</div>
					<div class='mot'>aéro</div>
					<div class='mot'>top</div>
					<div class='mot'>Performance</div>
					<div class='mot'>Futur</div>
					<div class='mot'>Avenir</div>
					
					
				</div>
				<div id='logoContainer'><a href='./'><img src='<?=$pilot->get_logo()?>' id='logo'/></a><div id='responsiveMenu' class='hidden-md hidden-lg hidden-sm'><span>=</span></span></div></div>
				<div class='mots-2'>
					<div class='mot'>spatial</div>
					<div class='mot'>futur</div>
					<div class='mot'>valorisant</div>
					<div class='mot'>passion</div>
					<div class='mot'>rémunération</div>
					<div class='mot'>challenge</div>
					<div class='mot'>high-tech</div>
					<div class='mot'>evolution</div>
					<div class='mot'>technologie</div>
					


					
					
				</div>
			</div>
			<div id='menuItem' class='container' style='position: relative;'>
			    <?php 
			        foreach($pilot->get_menu() as $item)
			        {
			            if(count($item) != 0)
			            {
    			            if(count($item) > 1)
    			            {
    			                echo "<div class=' menuMainItem' style='margin: auto'><a href='".$item[0]['link']."'>".$item[0]['nom']." &nbsp;<i class='fal fa-angle-down'></i></a>";
    			                echo "<div style='padding: 7px; ' class='submenu'>";
    			                foreach($item as $key => $submenu)
    			                {
    			                    if($key > 0)
    			                    {
    			                        echo "<div style='padding: 7px'><a href='".$submenu['link']."' class=''>".$submenu['nom']."</a></div>";
    			                    }
    			                }
    			                echo "</div>";
    			                echo "</div>";
    			            }
    			            else
    			            {
    			                echo "<div class='menuMainItem' style='margin: auto'><a href='".$item[0]['link']."'>".$item[0]['nom']."</a></div>";
    			            }
			            }
			        }
			    ?>
			</div>
		</menu>