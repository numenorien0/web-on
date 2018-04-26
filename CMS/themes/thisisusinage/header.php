<?php
	
$css = [
    'https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i|Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i',
    'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css',
     $pilot->get_theme_path().'/CSS/fontawesome/css/fontawesome-all.min.css',
    '//cdn.quilljs.com/1.3.5/quill.snow.css',
    '//cdn.quilljs.com/1.3.5/quill.bubble.css',
    '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css',
    $pilot->get_theme_path().'/CSS/style.css',

    
];

$js = [
    'https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js',
    'https://code.jquery.com/ui/1.12.1/jquery-ui.min.js',
    'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js',
	'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
	$pilot->get_theme_path().'/JS/app.js'
];

echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
foreach($css as $file)
{
    echo "<link rel='stylesheet' href='$file' type='text/css'/>";
}

foreach($js as $file)
{
    echo "<script src='$file'></script>";
}	
	
?>