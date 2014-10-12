$dialog = $('<div></div>');

function initializeDialog(){
	try{	
		// handle dialog basics
		$dialog.dialog({
			show: {effect: 'fade', speed: 1000},
			hide: {effect: 'fade', speed: 3000},
			autoOpen: false,
			modal: true
		});	
	}catch(e){
		log("dialogs.js", e.lineNumber, e);
	}
}

function openDialog(t, b){
	try{
		$dialog.dialog('option', 'title', t);
		$dialog.html(b);
		$dialog.dialog("open");
	}catch(e){
		log("dialogs.js", e.lineNumber, e);
	}
}

function closeDialog(){
	try{
		$dialog.dialog("close");
	}catch(e){
		log("dialogs.js", e.lineNumber, e);
	}
}

function changeDialogContent(new_title, content){
	try{
		$dialog.dialog("option", "title", new_title);
		$dialog.html(content);
	}catch(e){
		log("dialogs.js", e.lineNumber, e);
	}
}

function openFileDialog(){
	try{
                var data = JSON.stringify(user_id);
                $sel = $("#selected");
                var type = "";
                if($sel.hasClass("widg_picture")){
                    type = JSON.stringify("picture");
                }else{
                    type = JSON.stringify("other");
                }
                //alert(data);
		$dialog.dialog('option', 'title', 'File Selector');
		$dialog.html(generate_file_dialog_html());
                /*$.post("includes/dialog_html.php", {data: data, type: type},
                function(r){
                    var result = r;
                    $('#media_holder').html(result);
                }).error(function(r){
                    var err = (r);
                    alert("Failed: " + err);
                });*/
		
		$('#file_upload').uploadify({
                    'buttonText' : 'Add Media',
	            'swf'      : '../../uploadify/uploadify.swf',
	            'uploader' : '../../uploadify/uploadify.php',
                    'formData': { 'userid': user_id, 'table': 'user'},
	            'auto'      : true,
				'onUploadSuccess' : function(file, data, response) {
					$('#media_holder').append('<div class="media_item"><img src=//data-storyblox.omixorp.com/'+data+'></div>');
                                        setSrc(data);
                                        $("#file_dialog").dialog('close');
                                        return false;
                                        //$dialog.dialog('close');
				}
	        });
                $dialog.dialog(accordion());
                
                
	}catch(e){
		log("dialogs.js", e.lineNumber, e);
	} 
}

//Create html to allow user to select a file
function generate_file_dialog_html(){
	try{
            ret = "<div class='jumbotron' id='file_dialog' style='font-size: 12px;background: #FFFFFF; border: 5px solid #7575ff; color: #222222;'>"+
            "<div id='accordion_box'>"+
            "<h3><a href='#'>Paste URL</a></h3>"+
            "<div class='form' id='paste_url_disp'>"+
            "<p id='url_error' class='error'></p>"+
            "<input type='text' id='new_url' name='new_file' placeholder='Paste URL Here'/><br>"+
            "<br><button class='button' type='button' onclick='return paste_url();'>Confirm</button>"+
            "</div>"+
            "<h3><a href='#'>Choose from My Media</a></h3>"+
            "<div class='form' id='media_holder' style='height:300px; width:300px; margin: 0 10px; background-color:#ffffff; border:3px #999999 solid; overflow-y:auto; overflow-x:hidden;'>"+
            "</div>"+
            "<h3><a href='#'>Upload File</a></h3>"+
            "<div class='form' id='add_media_button_holder'>"+
            "<input id='file_upload' name='file_upload' type='file' multiple='true'>"+
            "</div>"+
            "</div>"+
            "</div>";
    
            return ret;
	}catch(e){
		log("dialogs.js", e.lineNumber, e);
	} 
}

function accordion(){
	try{
		$("#file_dialog").dialog({
			height: 400,
			width: 400,
			modal: true,
			open: function(){
                            $("#accordion_box").accordion({
                                autoHeight: true
                            });
			},
                        /*close: function(){
                            $("#file_dialog").dialog('close');
                            return false;
                        }*/
		});
	}catch(e){
		log("dialogs.js", e.lineNumber, e);
	}
}

function paste_url(){
	try{
		//determined what media type is selected
		$w = $("#selected");
                
		if($w.hasClass("widg_picture")){
			//get value of pasted url
			var url = $("#new_url").val();
                        //alert(url);
                        
			//check if nothing was entered
			if(url == ''){
				document.getElementById("url_error").innerHTML = 'You must paste a URL in the field.';
				//alert("url is empty");
                                return false;
			}
			//make sure the picture is jpeg, png, or gif
			else if(url.match(/\.(jpeg|png|gif|jpg)$/) == null){
				document.getElementById("url_error").innerHTML = 'Invalid URL.';
                                //alert("url doesn't match regex");
				return false;
			}
                        
			//if all tests are passed, continue on to update
                        
                        //Error happening right around here
                        setSrc(url);
                        
			$("#file_dialog").dialog('close');
                        return false;
		}
		else if($w.hasClass("widg_video")){
			//mp4, avi, mov
			//get value of pasted url
			var url = $("#new_url").val();

			//check if nothing was entered
			if(url == ''){
				document.getElementById("url_error").innerHTML = 'You must paste a URL in the field.';
				return false;
			}

			//make sure the video is mp4, avi, or mov
			else if(url.match(/\.(mp4|avi|mov)$/) == null){
				document.getElementById("url_error").innerHTML = 'Invalid URL.';
				return false;
			}

			//if all tests are passed, continue on to update

			setSrc(url);
			$("#file_dialog").dialog('close');
                        return false;

		}
		else if($w.hasClass("widg_audio")){
			//mp3 & aac

			//get value of pasted url
			var url = $("#new_url").val();

			//check if nothing was entered
			if(url == ''){
				document.getElementById("url_error").innerHTML = 'You must paste a URL in the field.';
				return false;
			}

			//make sure the audio file is mp3 or aac
			else if(url.match(/\.(mp3|aac)$/) == null){
				document.getElementById("url_error").innerHTML = 'Invalid URL.';
				return false;
			}

			//if all tests are passed, continue on to update

			setSrc(url);
                        $("#file_dialog").dialog('close');
                        return false;
		}

		else if($w.hasClass("widg_embedded")){

			//get value of pasted url
			var url = $("#new_url").val();

			//check if nothing was entered
			if(url == ''){
				document.getElementById("url_error").innerHTML = 'You must paste a URL in the field.';
				return false;
			}

			//make sure the embedded video is a youtube video
			else if(url.match(/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/) == null){
				document.getElementById("url_error").innerHTML = 'Invalid URL.';
				return false;
			}

			//if all tests are passed, continue on to update

			setSrc(url);
			$("#file_dialog").dialog('close');
                        return false;
		}
	}catch(e){
		log("dialogs.js", e.lineNumber, e);
	}
}

function testImage(url, callback, timeout) {
	try{
		timeout = timeout || 5000;
		var timedOut = false, timer;
		var img = new Image();
		img.onerror = img.onabort = function() {
			if (!timedOut) {
				clearTimeout(timer);
				callback(url, "error");
			}
		};
		img.onload = function() {
			if (!timedOut) {
				clearTimeout(timer);
				callback(url, "success");
			}
		};
		img.src = url;
		timer = setTimeout(function() {
			timedOut = true;
			callback(url, "timeout");
		}, timeout); 
	}catch(e){
		log("dialogs.js", e.lineNumber, e);
	}
}

function record(url, result) {
	try{
		return result;
	}catch(e){
		log("dialogs.js", e.lineNumber, e);
	}
}

function save(method){
	try{

		//check for valid methods of saving
		if(!(method == "image" || method == "video" || method == "text" || method == "audio" || method == "imbedded")){
			return;
		}

	}catch(e){
		log("dialogs.js", e.lineNumber, e);
	}  

}