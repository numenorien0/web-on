$(function(){
		
		function inIframe(){
		    try {
		        return window.self !== window.top;
		    } catch (e) {
		        return true;
		    }
		}
		   console.log("hello");
		///////UPLOAD DRAG AND DROP/////////
		var nombreFichier;
		var i = 0;
		var fichier;
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
			//alert('ok');
	        if(e.originalEvent.dataTransfer){
	           if(e.originalEvent.dataTransfer.files.length) {
	
	   				nombreFichier = e.originalEvent.dataTransfer.files.length;
		           // Stop the propagation of the event
		           e.preventDefault();
		           e.stopPropagation();
		           $(this).css('border', 'none');
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
		
		
		function uploadFile(fichierTemp){
	
			$('.status').fadeIn();
			
			var file = fichierTemp[i];
			//var filePhoto = _("btn_photo").files[0];
			//alert(file.name+" | "+file.size+" | "+file.type);
			var formdata = new FormData();
			formdata.append("file", file);
	
	
	        if(typeof file !== "undefined")
	        {
	            //alert(file);
    			var ajax = new XMLHttpRequest();
    			ajax.upload.addEventListener("progress", progressHandler, false);
    			ajax.addEventListener("load", completeHandler, false);
    			ajax.addEventListener("error", errorHandler, false);
    			ajax.addEventListener("abort", abortHandler, false);
    			ajax.open("POST", "ajax/photo_upload.php");
    			ajax.send(formdata);
	        }
		}
		function progressHandler(event){
			percent = (event.loaded / event.total) * 100;
			$("#progressBar")[0].value = Math.round(percent);
			$("#status")[0].innerHTML = Math.round(percent)+"% téléchargé... (fichier "+(i+1)+" sur "+nombreFichier+")";
		}
		function completeHandler(event){
			i++;
			$(".noMedia").remove()
			if(i >= nombreFichier)
			{
				$("#progressBar")[0].value = 0;
				$("#status")[0].innerHTML = "terminé!";
				listPhoto();
				i = 0;
				$('.status').fadeOut();
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
		
		$('#monthChoose').change(function(){
			var value = $(this).val();
			$('.listFile').html("");
	        $.ajax({
				url: "ajax/photo_upload.php",
				data:{
					action: "list",
					date: value
				},
				dataType: "json",
				complete: function(xhr, textStatus) {
			        
			        if(xhr.status == 201)
			        {
				        $(".listFile").html("<div class='noMedia'>Pas de médias, glissez des images ici pour commencer</div>");
			        }
			    }
				
			}).done(function(json){
				
				$.each(json, function(i,v){
				    
					if(!$("div[data-id='"+v['ID']+"']").length)
					{
					    //alert(v['file']);
					    if(v['type'] !== "video")
					    {
					        var html = "<div class='imageLibraryContainer col-md-2'><div class='col-md-12 imageLibrary' data-alt='"+v["alt"]+"' data-id='"+v['ID']+"' data-type='"+v['type']+"' data-parent='"+v['parent']+"' data-src='"+v['file']+"' style='background-image: url("+v['file']+"); background-size: cover; background-position: center;'></div></div>";
					    }
					    else{
					        
					        var html = "<div class='imageLibraryContainer col-md-2' style='overflow: hidden'><div class='col-md-12 imageLibrary' style='overflow: hidden' data-alt='"+v["alt"]+"' data-id='"+v['ID']+"' data-type='"+v['type']+"' data-parent='"+v['ID']+"' data-src='"+v['file']+"' style='background-image: url("+v['file']+"); background-size: cover; background-position: center;'><video style='Object-fit: cover; width: 100%; height: 100%' src='"+v['file']+"'  muted loop></video></div></div>";
					    }
						$(html).prependTo(".listFile");
					}
				})
				
				
				
			})
        })
		
		function listPhoto()
		{
			$.ajax({
				url: "ajax/photo_upload.php",
				data:{
					action: "list"
				},
				dataType: "json"
			}).done(function(json){
				$.each(json, function(i,v){
				    
					if(!$("div[data-id='"+v['ID']+"']").length)
					{
					    //alert(v['file']);
					    if(v['type'] !== "video")
					    {
					        var html = "<div class='imageLibraryContainer col-md-2'><div class='col-md-12 imageLibrary' data-alt='"+v["alt"]+"' data-id='"+v['ID']+"' data-type='"+v['type']+"' data-parent='"+v['parent']+"' data-src='"+v['file']+"' style='background-image: url("+v['file']+"); background-size: cover; background-position: center;'></div></div>";
					    }
					    else{
					        
					        var html = "<div class='imageLibraryContainer col-md-2' style='overflow: hidden'><div class='col-md-12 imageLibrary' style='overflow: hidden' data-alt='"+v["alt"]+"' data-id='"+v['ID']+"' data-type='"+v['type']+"' data-parent='"+v['ID']+"' data-src='"+v['file']+"' style='background-image: url("+v['file']+"); background-size: cover; background-position: center;'><video style='Object-fit: cover; width: 100%; height: 100%' src='"+v['file']+"'  muted loop></video></div></div>";
					    }
						$(html).prependTo(".listFile");
					}
				})
			})
		}
		
		var selectedItem = new Array();
		var shiftKey = false;
		
		$(document).on("keydown", function(e){
			if(e.shiftKey)
			{
				shiftKey = true;
			}
		})
		$(document).on("keyup", function(){
			shiftKey = false;
		})
		var id;
		$(document).on("click", ".imageLibrary", function(){
		    var video;
		    if($(this).attr('data-type') == "video")
		    {
		        var type = $(this).attr('data-type');
		        video = true;
		    }
		    else{
		        var type = "HD";
		        video = false;
		    }
			
			
			if(shiftKey == false)
			{
				$('.imageLibrary').removeClass("selected");
			}
			
			if($(this).hasClass("selected"))
			{
				$(this).removeClass("selected");
			}
			else
			{
				$(this).addClass("selected");
			}
			//alert("ok");
			
			if($(this).attr('data-parent'))
			{
				id = $(this).attr('data-parent');
			}
			else
			{
				id = $(this).attr('data-id');
			}
			$.ajax({
				url: "ajax/photo_upload.php",
				dataType: "json",
				data: {
					action: "file_details",
					ID: id
				}
			}).done(function(json){
				console.log(json); 
				if(video)
				{
				    $(".imageContainer").html("<input type='hidden' id='currentID' value='"+id+"' /><video style='max-width: 100%;' autoplay muted loop src='"+json[type].file+"'></div><div class='resolution'></div>");
				}
				else
				{
				    $(".imageContainer").html("<input type='hidden' id='currentID' value='"+id+"' /><img style='max-width: 100%;' src='"+json[type].file+"' /><div class='resolution'>"+json[type].resolution+"</div>");
				}
				$("#insertImage").remove();
				var select = "<br/><br/><select class='imageType'>";
				$.each(json, function(i,v){
					console.log(v);
					
					if(type == v.type)
					{
						var selected = "selected";
					}
					else
					{
						selected = "";
					}
					select += "<option "+selected+" value='"+v.type+"'>"+v.type+"</option>";
				});
				select += "</select>";
				$('.formContainer').html(displayAllLangTab());
				$('.formContainer').append(select);
				$.each(lang, function(i,v){
					v = v[0];
					if(video)
					{
					    var element = json.video;
					}
					else
					{
					    var element = json.full;
					}
					$('.formContainer').append("<input type='text' class='imageName' data-lang='"+v+"' placeholder='Nom' value=\""+parseJSONresponse(element.nom, v)+"\"/><textarea data-lang='"+v+"' class='imageDescription' placeholder='description' value='' data-lang='"+v+"'>"+parseJSONresponse(element.description, v)+"</textarea><input type='text' class='imageAlt' placeholder='Alt text' data-lang='"+v+"' value=\""+parseJSONresponse(element.alt, v)+"\"/>");
				});
				
				//alert($('.formContainer').find(".imageAlt").val());
				hideOtherLang();
				
				
				$("<button style='margin: 0; margin-bottom: 15px' class='iframed' id='insertImage'><i class='fa fa-paste'></i> Sélectionner : HD</button>").insertBefore(".imageContainer");
				$('.formContainer').append("<br/><br/><button id='changeMetaImg'><i class='fa fa-save'></i> Sauvegarder</button><button id='deleteImage' class='supprimer'><i class='fa fa-remove'></i> Supprimer</button>")
				$('.formContainer .selectLang').click(function(){
					
				})
				$('#deleteImage').click(function(){
					var ID = $("#currentID").val();
					$.ajax({
						url: "ajax/photo_upload.php",
						type: "POST",
						data: {
							action: "delete",
							ID: ID
						}
					}).done(function(){
						$("div[data-parent='"+ID+"']").parent().remove();
						$('.formContainer, .imageContainer').html("");
					})
				})
				
				$(".imageType").unbind("change").bind("change", function(){
					var elem = $(this).val();
					$('#insertImage').html("<i class='fa fa-paste'></i> Sélectionner : "+elem);
					var ID = $("#currentID").val();
					$('.imageContainer img').attr('src', json[elem].file);
					$('.resolution').text(json[elem].resolution);
					$('.imageLibrary[data-parent="'+ID+'"]').attr('data-src', json[elem].file);
				})
				
				$('#changeMetaImg').click(function(){
					var data = new Object();
					var elem = $(this);
					
					$.each(lang, function(i,v){
						v = v[0];
						data[v] = new Object();
						
						$('.formContainer input[data-lang="'+v+'"], .formContainer textarea[data-lang="'+v+'"]').each(function(){
						
							var classe = $(this).attr("class");
							data[v][classe] = $(this).val();
						
						});
						
						
					});
					
					var donnees = JSON.stringify(data);

					$.ajax({
						url: "ajax/photo_upload.php",
						type: "POST",
						data:{
							
							action: 'editMeta',
							data: donnees,
							ID: $("#currentID").val()
						},
						
					}).done(function(e){
						$(elem).html("<i class='fa fa-check'></i> Sauvegardé !");
					})
				})
			})
			
			//$(".imageContainer").html("<img src='"++"' />");
		})
		 });