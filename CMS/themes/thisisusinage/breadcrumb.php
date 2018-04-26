<?php

$bread = $pilot->get_breadcrumb();
$return = "<a href='".$pilot->_current_lang."/'>Accueil</a>";

foreach($bread as $item)
{
    $return .= " > <a href='".$item['URL']."'>".$item['name']."</a>";
}
?>
<div class='breadCrumb'>
	<div class='container'>
        <?=$return?>
    </div>
</div>
