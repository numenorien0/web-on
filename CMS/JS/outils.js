$(function(){
	$('#plugin a').click(function(e){
		e.preventDefault();
		var url = $(this).attr('href').split(".php");
		window.location.href = 'outils.php?tools='+url[0];
	});



$(document).on('dragenter', '#dropfile', function() {
            $(this).css('border', '3px dashed red');
            return false;
});
 
$(document).on('dragover', '#dropfile', function(e){
            e.preventDefault();
            e.stopPropagation();
            $(this).css('border', '3px dashed red');
            return false;
});
 
$(document).on('dragleave', '#dropfile', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).css('border', '3px dashed #BBBBBB');
            return false;
});

var fichier;
var i = 0;
var nombreFichier;

$(document).on('drop', '#dropfile', function(e) {
            if(e.originalEvent.dataTransfer){
                       if(e.originalEvent.dataTransfer.files.length) {
                                   // Stop the propagation of the event
                                   nombreFichier = e.originalEvent.dataTransfer.files.length;

                                   e.preventDefault();
                                   e.stopPropagation();
                                   $(this).css('border', '3px dashed green');
                                   // Main function to upload
                                   fichier = e.originalEvent.dataTransfer.files;
                                   uploadFile(fichier);
                       }  
            }
            else {
                       $(this).css('border', '3px dashed #BBBBBB');
            }
            return false;
});

	var percent;
	function _(el){
		return document.getElementById(el);
	}

	function uploadFile(fichierTemp){
		
		var file = fichierTemp[i];
		//alert(file);
		var formdata = new FormData();
		formdata.append("file", file);



		var ajax = new XMLHttpRequest();
		ajax.upload.addEventListener("progress", progressHandler, false);
		ajax.addEventListener("load", completeHandler, false);
		ajax.addEventListener("error", errorHandler, false);
		ajax.addEventListener("abort", abortHandler, false);
		ajax.open("POST", "uploadPlugins.php");
		ajax.send(formdata);
	}
	function progressHandler(event){
		percent = (event.loaded / event.total) * 100;
		$('.explicationUpload').text("Téléchargement effectué à "+Math.round(percent)+"%");
	}
	function completeHandler(event){
		i++;
		if(i > nombreFichier)
		{
			//alert("Installation terminée!");
			var successAudio = new Audio();
			successAudio.src = "content/sound/success.mp3";
			successAudio.play();
			$('.explicationUpload').text("Glissez pour installer un plugin");
			$('#dropfile').css({"border":"2px solid #AFAFAF"});
			i = 0;
			//window.location.reload();
		}
		else
		{
			uploadFile(fichier);
		}
		//alert(event.target.responseText);
		//window.location.href = "video.php";
	}
	function errorHandler(event){
		
	}
	function abortHandler(event){
		
	}

})