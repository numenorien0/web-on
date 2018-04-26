$(function(){
	var nombreFichier;
	var i = 0;
	var fichier;

///////UPLOAD DRAG AND DROP/////////

$(document).on('dragenter', '#dropfile', function() {
            $(this).css('border', '2px solid #66D04D');
            return false;
});
 
$(document).on('dragover', '#dropfile', function(e){
            e.preventDefault();
            e.stopPropagation();
            $(this).css('border', '2px solid #66D04D');
            return false;
});
 
$(document).on('dragleave', '#dropfile', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).css('border', '2px solid #AFAFAF');
            return false;
});


$(document).on('drop', '#dropfile', function(e) {
            if(e.originalEvent.dataTransfer){
                       if(e.originalEvent.dataTransfer.files.length) {

                       				nombreFichier = e.originalEvent.dataTransfer.files.length;
                                   // Stop the propagation of the event
                                   e.preventDefault();
                                   e.stopPropagation();
                                   $(this).css('border', '2px solid #66D04D');
                                   // Main function to upload
                                   fichier = e.originalEvent.dataTransfer.files;
                                   console.log(fichier);
                                   uploadFile(fichier);
                       }  
            }
            else {
                       $(this).css('border', '2px solid #BBBBBB');
            }
            return false;
});



///////////////////////////////////

	$('#file_btn').click(function(){
		$('#file').click();
	});

	$('#buttonPhoto').click(function(){
		$('#file_photo').click();
	})

	$('textarea[name=url]').change(function(){
		$('.iframeVideo').html($(this).val());
	})

	$('#file_photo').change(function(){
		nombreFichier = $(this)[0].files.length;
		fichier = $(this)[0].files;
		uploadFile(fichier);
	});

	var album = $("#albumHidden").val();

	var percent;
	function _(el){
		return document.getElementById(el);
	}

	function uploadFile(fichierTemp){

		$('#progressBar').fadeIn();
		$('#status').fadeIn();
		
		var file = fichierTemp[i];
		var album = $("#albumHidden").val();
		//var filePhoto = _("btn_photo").files[0];
		//alert(file.name+" | "+file.size+" | "+file.type);
		var formdata = new FormData();
		formdata.append("file", file);
		formdata.append("album", album);



		var ajax = new XMLHttpRequest();
		ajax.upload.addEventListener("progress", progressHandler, false);
		ajax.addEventListener("load", completeHandler, false);
		ajax.addEventListener("error", errorHandler, false);
		ajax.addEventListener("abort", abortHandler, false);
		ajax.open("POST", "photo_upload.php");
		ajax.send(formdata);
	}
	function progressHandler(event){
		percent = (event.loaded / event.total) * 100;
		_("progressBar").value = Math.round(percent);
		_("status").innerHTML = Math.round(percent)+"% téléchargé... (fichier "+(i+1)+" sur "+nombreFichier+")";
	}
	function completeHandler(event){
		i++;
		if(i > nombreFichier)
		{
			var successAudio = new Audio();
			successAudio.src = "content/sound/success.mp3";
			successAudio.play();
			_("progressBar").value = 0;
			_("status").innerHTML = "terminé!";
			listPhoto();
			i = 0;
			$('#progressBar').fadeOut(2000);
			Notification.requestPermission( function(status) {
			  console.log(status); // les notifications ne seront affichées que si "autorisées"
			  var n = new Notification("Pilot", {body: "Toutes les photos ont été téléchargées", icon: "images/favicon.png"}); // this also shows the notification
			});
		}
		else
		{
			listPhoto();
			uploadFile(fichier);
		}
		//alert(event.target.responseText);
		//window.location.href = "video.php";
	}
	function errorHandler(event){
		_("status").innerHTML = "Upload échoué";
	}
	function abortHandler(event){
		_("status").innerHTML = "Upload abandonné";
	}

	function deletePhoto(idPhoto)
	{
		$.ajax({
			url: 'photo_upload.php',
			type: 'GET',
			data: {demand: 'delete', id: idPhoto},
		})
		.done(function(value) {
			listPhoto();
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});		
	}

	function listPhoto()
	{
		$.ajax({
			url: 'photo_upload.php',
			type: 'GET',
			data: {demand: 'list', id: album},
		})
		.done(function(value) {


			$('#listPhoto').html(value);
					$('.submitDescription').click(function(){
						var description = $(this).parent().children(".descriptionValue").val();
						var idDescription = $(this).parent().children(".hiddenIDDescription").val()
						//alert($(this).prev(".descriptionValue").val());
						$.ajax({
							url: 'photo_upload.php',
							type: 'POST',
							data: {demand: 'description', id: idDescription, description: description},
						})
						.done(function(value){
							$(".descriptionForm").stop().fadeOut();
						})
					})
			$('#listPhoto div').mouseenter(function(){
				
				$(this).children(".blackHover").stop().fadeIn();
				//$(this).children("div").css({"-webkit-filter":"brightness(40%)", "cursor":"normal"});

				$(this).children(".deleteIcon, .fullscreen, .editIcon").stop().fadeIn();

				$(this).children(".deleteIcon").click(function(){
					//if(confirm("Etes vous sur de vouloir supprimer définitivement cette photo?"))
					//{
						deletePhoto($(this).attr('data-id'));
					//}
				});

				$(this).children(".fullscreen").click(function(){
					$('#fullscreen').fadeIn();
					var source = $(this).attr('data-img');
					$('#fullscreenImage').attr('src', source);
					$('#closeImg').click(function(){
						$('#fullscreen').fadeOut();
					})
				});

				$(this).children(".editIcon").click(function(e){
					$(".descriptionForm").stop().fadeOut();
					e.stopPropagation();
					$(this).parent().next(".descriptionForm").stop().fadeIn();

				});
				
				$(".descriptionForm").click(function(e){
					e.stopPropagation();
				})

			})
			$('#listPhoto div').mouseleave(function(){
				$(this).children("div").css({"-webkit-filter":"brightness(100%)", "cursor":",normal"});
				$(this).children(".blackHover").stop().fadeOut();
				$(this).children(".deleteIcon, .fullscreen, .editIcon").stop().fadeOut();
			})
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		
	}


	$("#containerPhoto").click(function(){
		$(".descriptionForm").stop().fadeOut();
	})

	$('.deleteImage').click(function(e){
		e.preventDefault();

		var image = $(this).attr('href');
		bootbox.confirm("Attention, la page va être rechargée, les modifications non sauvegardées seront perdues. Continuer?", function(result){
		if(result == true)
		{
			window.location.href = window.location.href+image;
		}
		});

	})

	if($('#decompte').length != 0)
	{
		$('#formulaire').hide();
		var secondes = 4;
		var decompte = setInterval(function(){
			$("#decompte").text(secondes+" secondes");
			secondes--;
			if(secondes == 0)
			{
				clearInterval(decompte);
				window.location.href = "outils.php?tools=video&page=listMedias";
			}
		}, 1000)
	}

	if($('#actionHidden').length != 0)
	{
		//e.stopPropagation();
		$('#blackScreen, #containerPhoto').fadeIn();
		listPhoto();
	}

	$('#addPhotos').click(function(e){
		e.stopPropagation();
		$('#blackScreen, #containerPhoto').fadeIn();
		listPhoto();
	});

	$('#containerPhoto').click(function(e){
		e.stopPropagation();
	});


	$("html").click(function(){
		$('#blackScreen, #containerPhoto').fadeOut();
	})
})