$.getScript("widget_attr.js");
$.getScript("drag_drop.js");
$.getScript("jquery.min.js");

$(document).ready(function(){
	try{
		// Prepare dialogs for use on screen
		initializeDialog();

		// set selected widget to null
		selected_widget = null;

		// TEMP
		$("#storyCanvas").css({"padding":"0"});
		
		
		// Uploadify
		//$("#file_upload").uploadify({'buttonText' : 'Upload File', 'swf': 'uploadify/uploadify.swf','uploader' : 'uploadify/uploadify.php'});
		

		// right now, tooltips look insane.
		// $(document).tooltip();

		
		//if the story is blank, create 1 slide
		if(storyArrayLength == 0){
			addSlide();  //add 1 slide to timeline when it first loads and is empty
		}
		
		// Initialize drag and drop functionality
		draggable_init();

		dialog_init();

		// set attibute bar
		//UpdateAttributes(null);

		

		//gathers var encodedStoryArray = '<?php echo $encoded_array; ?>';
		//and var storyArrayLength = encodedStoryArray.length =>gathered in real time
		for(var i=0; i < storyArrayLength; i++){
			addSlideToTimeline(i); //add a slide for each slide stored in the story_array returned from the db
		}
		
		display_slide();
		setSidebar();


		//jquery start when document loads
		$("#timelineSortable").sortable({
			stop : function(event, ui){
				//alert($(this).sortable('serialize'));  //remove for now or demo

				
				//NEED TO ADD SERIALIZE FUNCTION
				$slide_id = slide_array[current_slide-1].id;
				$position = slide_array[current_slide-1].position;
				
				var data = {slide_id:$slide_id, position:$position};
				//var response = httpReq.responseText;
				
				//alert(response + " is what the server says in doc_ready");
				$.ajax({
	                url:"includes/updatePosition.php",
	                type: 'POST',
	                data:data
				
				});
				
				
				/*var data = $(this).sortable('serialize');//this captures the order of slides after mouseUp
				//use AJAX to post to orderTimeline.php
				$.post({   
					data: data, //this is the actual array being converted to a string for sending purposes
					type: 'POST',
					url: 'includes/orderTimeline.php'  //where the _POST variable will be updated with 'data'
				});*/
			}
		});
		
		$("#sortable").disableSelection();
	

		// Set hotkeys
		//setKeys();
	}
	catch(e){
		// Dislpay errors TEMP
		log("doc_ready.js", e.lineNumber, e);
	}
});

function dialog_init(){
	try {
		var icons={
				header: "ui-icon-plus",
				activeHeader: "ui-icon-minus"
		};
		$("#accordion_box").accordion({
			collapsible: true,
			icons: icons
		});
	}
	catch(e) {
		log("doc_ready.js", e.lineNumber, e);
	}
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
		log("doc_ready.js", e.lineNumber, e);
	}
}

/*
function setKeys(){
	$(document).keydown(function(e){
		// disable scrolling with arrow keys
		if (e.keyCode > 37 && e.keyCode < 41){
			e.preventDefault();
		}

		// user may browse widgets by pressing the arrow keys
		if (selected_widget !== null){
			var val = widget_array[selected_widget][6];
			if ((e.keyCode == 38) && (val < num_layers - 1)) { // up arrow key pressed
				$ob = $("div[l_id='"+(val + 1)+"']");
			}
			else if ((e.keyCode == 40) && ((val > 1))){ // down arrow key pressed
				$ob = $("div[l_id='"+(val - 1)+"']");
			}
			else{
				return;
			}
			setSelected($ob);
		}
	});
}
*/

