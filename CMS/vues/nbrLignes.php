<?php 

function counter($dir)
{
   $handle = opendir($dir);

   $nbLines = 0;
   
   while( ($file = readdir($handle)) != false )
   {
      if( $file != "." && $file != "..")
      {
         if( !is_dir($dir."/".$file) )
         {
            if( preg_match("#\.(php|html|txt|css|js)$#", $file) AND $file != "bootstrap.min.js" AND $file != "bootstrap.min.css" AND $file != "select2.min.css" AND $file != "select2.min.js" AND $file != "chart.min.js" AND $file !=  "Chart.min2.js" AND $file != "chart2.min.js" AND $file != "canvas2image.js" AND $file != "bootbox.min.js" AND $file != "codemirror.js" AND $file != "date.full.js" AND $file != "dom-to-image.min.js" AND $file != "FileSaver.js" AND $file != "fittext.js" AND $file != "html2canvas.js" AND $file != "jquery-ui.min.js" AND $file != "select2.full.min.js" AND $file != "show-hint.js" AND $file != "spectrum.js" AND $file != "switchery.min.js")
            {
                $nb = count(file($dir."/".$file));
                echo $dir,"/",$file," => <strong>",$nb,"</strong><br />";
                $nbLines += $nb;
            }
         }
         else
         {
            if($file != "tinymce" AND $file != "fpdf1812" AND $file !=  "tinymce3" AND $file != "stripe" AND $file != "" AND $file != "content" AND $file != "font" AND $file != "font-awesome" AND $file != "analytics" AND $file != "fpdf" AND $file != "newsletter")
            {
              $nbLines += counter($dir."/".$file);
            }
         }
      }
    }
   closedir($handle);
   
   return $nbLines;
}

// dossier à parcourir
// '.' signifie que je parcours le dossier où se trouve mon script
$dir = ".";

$nb = counter($dir);
$nb = number_format($nb, 0, ",", ".");
print("<br />Le projet comporte un total de <strong>".$nb.
"</strong> lignes de code<br />");

?>


