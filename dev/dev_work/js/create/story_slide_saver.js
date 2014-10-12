//user presses save draft button
function saveDraft(){
	try {
		saver("draft");
	}
	catch(e) {
		log("story_slide_saver.js", e.lineNumber, e);
	}
}

//user presses finish story button
function finishStory(){
	try {
		saver("finished");
	}
	catch(e) {
		log("story_slide_saver.js", e.lineNumber, e);
	}
}

//saves story as either a draft or as complete
function saver(method){
	try{
		// check for valid methods of saving
		if (!(method == "draft" || method == "finished")){
			return; // exit function if invalid method
		}

		// Initialize Ajax request
		var httpReq = new XMLHttpRequest();

		// Get story id from url
		var id = GET_variable('id');
		if (id === false){ // id was empty
			//error -> exit function
			return;
		}
		
		//open dialog to display results of save attempt
		openDialog('Saving...', '<br><img height=50 src="images/loading.gif"/>');

		var src = "includes/save_story.php";
		var data = gatherData(id, method); 
		//alert(data);
		//this point should halt and wait until gatherData is done executing
		// Start post
		httpReq.open("POST", src);

		httpReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		// When server responds, call this function
		httpReq.onreadystatechange = function() {
			// If everything is good, and server replies, get the message
			if(httpReq.readyState === 4 && httpReq.status === 200) {
				var response = httpReq.responseText;

				// Display results to user
				if (response == "SAVE_DRAFT_SUCCESS"){
					// Save worked
					changeDialogContent('Success!', '<p>Your story has been saved.</p>');
					setTimeout(function(){
						closeDialog();
					}, 2000);

				}
				else if (response == "FINISH_STORY_SUCCESS"){
					// Save worked
					changeDialogContent('Success!', '<p>Your story has been completed.</p>');
					setTimeout(function(){
						closeDialog();
						// redirect to home once dialog closes
						window.location.replace("home.php");
					}, 2000);
				}
				// If error
				else{
					// Save failed
					//debugg
					changeDialogContent('Error!', '<p>We were not able to save your story.<br>Please try again.<br>'+response+'</p>');
					setTimeout(function(){
						closeDialog();
					}, 10000);
					//alert(response); 

				}
			}
		};
		// Send the data
		httpReq.send(data);
	}
	catch(e){
		//DEBUGGING
		log("story_slide_saver.js", e.lineNumber, e);
	}
}

function getSlideData(){
	try {
		// return string of all widget data
		//alert(JSON.stringify(slide_array[current_slide-1].widg_array));
		//slide_array[current_slide-1][widg_array] is the path for the widget array of the current slide (array reference is slide-1)
		return JSON.stringify(slide_array[current_slide-1].widg_array);
	}
	catch(e) {
		log("story_slide_saver.js", e.lineNumber, e);
	}


}

function gatherData(id, method){
	// Story all slide data in strings
	try {
		var save_type = method;
		var title = encodeURIComponent(document.getElementById("title_input").value);
		var desc = encodeURIComponent(document.getElementById("desc_input").value);
		var tags = encodeURIComponent(document.getElementById("tags_input").value);
		var slide = encodeURIComponent(getSlideData()); // gets a string of all widget data on slide
		var slide_id = encodeURIComponent(slide_array[current_slide - 1].id);
		var color = encodeURIComponent(slide_array[current_slide - 1].background_color);
		
		//var share_settings = GetShareSettings();

		// collect data to set in post
		var data = "save_type="+save_type+"&story_title="+title+"&story_desc="+desc+"&story_tags="+tags+"&slide="+slide+"&slide_id="+slide_id+"&bg_color="+color+"&id="+id;
		
		return data;
	}
	catch (e) {
		log("story_slide_saver.js", e.lineNumber, e);
	}
}

function GetShareSettings(data){
	//<script>function submitSS(){ alert(\"test\");
	//alert($(\'#shareSettingsSelect\').val());}</script>
	
	var HTML = "<div id=\"test\">"+
		"<form><select id=\"shareSettingsSelect\">"+
		"<option value=\"private\">Private</option>"+  
		"<option value=\"exclusive\">Exclusive</option>"+
		"<option value=\"public\">Public</option>"+
		"</select> <input type=\"button\"  id=\"confirm\" value=\"Submit\"> </form></div>"+
		"<script>"+
		"$(\"#confirm\").button().click(function() {"+
		"GettingDataFromDialog($(\"#shareSettingsSelect\").val(), \""+ data+"\");"+
		"closeDialog();"+
		"});"+
		"</script>";
	var shareSettingsTitle = "Please select your share settings";
	
	openDialog(shareSettingsTitle, HTML);
		
}

function GettingDataFromDialog(share, data){
	var shareNum = 0;
	if(share == "private")
		shareNum = "0";
	else if(share == "exclusive")
		shareNum = "1";
	else if(share == "public")
		shareNum = "2";
	else
		//alert("something went wrong");
	
	data = data + "&share_settings=" + shareNum;
	finalSave(data);
}

function GET_variable(name){
	try {
		var query_string = window.location.search.substring(1); // get url
		var vars = query_string.split("&"); // split by variables
		for (var i=0;i<vars.length;i++) { 
			var pair = vars[i].split("=");
			if(pair[0] == name){return pair[1];}
		}
		return(false);
	}
	catch(e) {
		log("story_slide_saver.js", e.lineNumber, e);
	}
}
