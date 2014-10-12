/**JS written for timeline portion of createStory page
 *
 * this file is supposed to accomplish the following functions:
 * Create new slide
 * Update database with slide position
 * Call widget info from DB when selected && update current_slide number when user selects a slide in the timeline
 * Populate timeline when new story loads
 * 
 * 
 *
 *
 */
/**
 * timeline functions
 * @class timeline_functions
 */

var slideNo = 1;//sets the first slide position number to 1
/**
 * adds slide
 * @method addSlide
 */
function addSlide()
{
	try{

		if(slide_array.length != 0){
			saver('draft'); //if the slide is populated, save it and clear the widgets so the next one can be created
			clear_all();
		}

		//graphically insert slide
		var ul = document.getElementById("timelineSortable");//get current sortable timeline list
		var li = document.createElement("li"); //create a new li to add to it
		var thumbDiv = document.createElement("div"); //create a div to put in the li
		var slideThumb = document.createElement("img"); // create an img to put in the div
		var slideLabel = document.createElement("p"); //create a p to label the img in the div
		thumbDiv.setAttribute("class", "slideThumb"); //set css class for thumbnail
		slideThumb.setAttribute("src", "images/profile.png"); //!!!CHANGE TO REFLECT USER UPLOAD WHEN BUILT!!!!!!
		li.setAttribute("class", "slideSorter"); //ensure the li is the same class as the current list
		li.setAttribute("id", "slide-"+slideNo);//this needs to find out how many slides there are
		var txt = document.createTextNode("Slide "+slideNo); //label current slide number
		slideThumb.setAttribute("id", "position "+slideNo); //this is the position assigned to the p
		slideLabel.setAttribute("id", "position "+slideNo); //this is the position assigned to the p
		slideLabel.appendChild(txt); //put the text in the p
		thumbDiv.appendChild(slideThumb); //insert the img into the div
		thumbDiv.appendChild(slideLabel); //insert the label into the div

		//testing append using jQuery so div thumbDiv becomes jQuery object
		$( li ).append(thumbDiv); //check to see if this appends in jQuery
		$( ul ).append(li);
		//mouseDown function for slides
		$(".slideThumb img, .slideThumb p").unbind('click');
		$(".slideThumb img, .slideThumb p").click(function() {

			/* important order of logic: save draft (of whatever previous slide was automatically)
			 * 1. save slide user just left
			 * 2. get position of current slide
			 * 3. set widget array to be current widget array
			 * 4. display_slide
			 * 5. set clicked slide as current slide
			 */

			/* step 1 */
			saver('draft');//currently errors out

			/* step 2 */
			var current_id = $(this).attr("id"); //gets the css id called position so current_id is clicked slide position
			current_id = current_id.replace(/[^0-9$.,]/g, ''); //removes string position to reveal only slideNo (functionally posiiton)

			/* step 3 */

			//alert(widget_array + " Before update current_slide");

			current_slide = current_id; 

			//alert whole dependency chain because create_widget is having an issue with widget_data.length

			widget_array = slide_array[current_id-1].widg_array; //sets the new widget array

			display_slide();
			//alert(widget_array + " after update current slide and display_slide");
			//clear_all();

			/* step 4*/
			//display_slide();

			/* step 5 */
			//current_slide = current_id; //sets current slide to the clicked slide

		});


		//AJAX for updating slide through php

		//open dialog to display results of save attempt
		openDialog('Loading Slide...', '<br><img src="images/loading.gif"/>');

		// Initialize Ajax request
		var httpReq = new XMLHttpRequest();

		// Get story id from url
		var id = GET_variable('id');
		if (id === false){ // id was empty
			//error -> exit function
			return;
		}
		//Get all other variables necessary for insert function
		var src = "includes/add_slide.php?id="+id; //where to send $_POST data
		var thumbnail_path = "NULL"; //  !!Update when thumbnail file path is developed!!
		var widgets = id_counter; // there are no widgets in a new blank slide but this returns the number of widgets
		var bkgdColor = ""; //default to empty string
		var slide_id = -1; //initialize slide_id to be updated later

		//initialize slide array
		slide_array.push({id: 'id', position: 'slideNo', background_color: 'bkgd', thumbnail_path: 'thumb', widg_array: 'widgetArray'});
		//num_layers.push(1);


		//attempt to encode-decode to solve db


		// collect data to set in post
		// follow this format function insertSlide($p_position, $p_story_ref_id, $p_no_widgets, $p_thumbnail_file_path)
		var data = "position="+slideNo+"&story_id="+id+"&slide_widgets="+widgets+"&thumbnail_path="+thumbnail_path+"&background_color="+bkgdColor;

		// Start post
		httpReq.open("POST", src, false); //the third parameter makes this a sychronous call so js waits for response to continue

		//I don't think I use this since I'm not encoding things with spaces
		httpReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		// When server responds, call this function
		httpReq.onreadystatechange = function() {

			// If everything is good, and server replies, get the message
			if(httpReq.readyState === 4 && httpReq.status === 200) {
				var response = httpReq.responseText;


				// Display possible errors to user or else set the slide_array and finish addSlide
				if (response == "NOT_SET"){
					// Something failed to set in the updateSlides
					changeDialogContent('Error', '<p>Some POST variable not set</p>');
					setTimeout(function(){
						closeDialog();
					}, 4000);

				}
				else if (response == "CANNOT_CHECK"){
					// Something failed in checking if POST is set
					changeDialogContent('Error', '<p>Cannot check if info is loaded</p>');
					setTimeout(function(){
						closeDialog();
						// redirect to home once dialog closes
						window.location.replace("home.php");
					}, 4000);
				}
				else if (response == "ERROR"){
					// Something failed in declaring variables
					changeDialogContent('Error', '<p>Break Point is at declaring varibales</p>');
					setTimeout(function(){
						closeDialog();
						// redirect to home once dialog closes
						window.location.replace("home.php");
					}, 4000);
				}					
				else if (response == "BAD_REQUEST"){
					// Bad Server request
					changeDialogContent('Error', '<p>Cannot check if info is loaded</p>');
					setTimeout(function(){
						closeDialog();
						// redirect to home once dialog closes
						window.location.replace("home.php");
					}, 2000);
				}
				else{    //...assuming no errors were retuned, response is slide_id
					//set global slide_id variable;
					var server_slide_id = response; //response is $slide_id_from_server
					slide_id = server_slide_id;

					// Display success results
					changeDialogContent('Success', '<p>Slide Added</p>');
					setTimeout(function(){
						closeDialog();
					}, 4000);						
				}
			}
		};

		//debugging respond with server response
		//alert(response + " is what the server says");

		// Send the data
		httpReq.send(data);

		//close dialog
		closeDialog();


		try{			

			//initialize associative array
			//slide_array.push({id: 'id', position: 'slideNo', background_color: 'bkgd', thumbnail_path: 'thumb', widg_array: 'widgetArray'});
			//init blank associative array that is slide then append slide to slide_array
			//var temp_slide = new Array();	
			//temp_slide.push({id: 'id', position: 'slideNo', background_color: 'bkgd', thumbnail_path: 'thumb', widg_array: 'widgetArray'});
			//slide_array.push(temp_slide); //each time we add a slide, initialize temporary slide


			slide_array[slideNo-1].id = slide_id; //set ID wrong ID this needs to be slide ID
			slide_array[slideNo-1].position = slideNo; //set position;
			slide_array[slideNo-1].background_color = bkgdColor; //set bkgd color
			slide_array[slideNo-1].thumbnail_path = thumbnail_path; //set thumbnail path
			slide_array[slideNo-1].widg_array = new Array(); //initialize next dimension array
			slide_array[slideNo-1].widget_count = 0;
			//slide_array[slideNo-1].widg_array = widget_array; //lets hope... widget array populates?

			//set newly created slide as current slide
			current_slide = slideNo;
			//alert(current_slide);

			display_slide(); //clear the widgets between each slide then load the new ones

		}
		catch(e){
			log("timeline_function.js error creating slide_array", e.lineNumber, e);
		}


		slideNo++; //increment Slide Number so its increased next time


	}
	catch(e){
		log("timeline_function.js error somewhere in addSlide", e.lineNumber, e);
	}
}


//ERROR CURRENTLY THE BELOW IS BEING CALLED MULTIPLE TIMES! TRY TO FIND OUT WHY STORYARRAYLENGTH IS DOUBLING
//solved, in addSlide.php setting variable equal to insertSlide function called the function again

//used for call in doc_ready to populate timeline without updating the database

/**
 * used for call in doc_ready to populate timeline without updating the database
 * @method addSlideToTimeline
 */
function addSlideToTimeline(i){
	//slideNo = i + 1;
	try{
		//graphically insert slide
		var ul = document.getElementById("timelineSortable");//get current sortable timeline list
		var li = document.createElement("li"); //create a new li to add to it
		var thumbDiv = document.createElement("div"); //create a div to put in the li
		var slideThumb = document.createElement("img"); // create an img to put in the div
		var slideLabel = document.createElement("p"); //create a p to label the img in the div
		thumbDiv.setAttribute("class", "slideThumb"); //set css class for thumbnail
		slideThumb.setAttribute("src", "images/profile.png"); //!!!CHANGE TO REFLECT USER UPLOAD WHEN BUILT!!!!!!
		li.setAttribute("class", "slideSorter"); //ensure the li is the same class as the current list
		li.setAttribute("id", "slide-"+slideNo);//this needs to find out how many slides there are
		var txt = document.createTextNode("Slide "+slideNo); //label current slide number
		slideThumb.setAttribute("id", "position "+slideNo); //this is the position assigned to the p
		slideLabel.setAttribute("id", "position "+slideNo); //this is the position assigned to the p
		slideLabel.appendChild(txt); //put the text in the p
		thumbDiv.appendChild(slideThumb); //insert the img into the div
		thumbDiv.appendChild(slideLabel); //insert the label into the div

		//create jQuery object and set click functionality
		$( li ).append(thumbDiv); //check to see if this appends in jQuery
		$( ul ).append(li);
		//mouseDown function for slides
		$(".slideThumb img, .slideThumb p").unbind('click');
		$(".slideThumb img, .slideThumb p").click(function() {


			/* important order of logic: save draft (of whatever previous slide was automatically)
			 * 1. save slide user just left
			 * 2. get position of current slide
			 * 3. set widget array to be current widget array
			 * 4. display_slide
			 * 5. set clicked slide as current slide
			 */

			/* step 1 */
			saver('draft');//currently errors out

			/* step 2 */
			var current_id = $(this).attr("id"); //gets the css id called position so current_id is clicked slide position
			current_id = current_id.replace(/[^0-9$.,]/g, ''); //removes string position to reveal only slideNo (functionally posiiton)

			/* step 3 */

			//alert(widget_array + " Before update current_slide");


			current_slide = current_id; 


			//alert whole dependency chain because create_widget is having an issue with widget_data.length

			widget_array = slide_array[current_id-1].widg_array; //sets the new widget array

			// debugging -> this is called twice
			display_slide();
			//alert(widget_array + " after update current slide and display_slide");
			//clear_all();

			/* step 4*/
			//display_slide();

			/* step 5 */
			//current_slide = current_id; //sets current slide to the clicked slide

		});

	}
	catch(e) {
		log("timeline_function.js error creating html element", e.lineNumber, e);
	}

	try{  


		//loop through array from DB to populate javascript slide_array
		//var storyArrayLength = encodedStoryArray.length;
		//for(var i=0; i < storyArrayLength; i++){   
		//initialize slide array  //actually not needed
		slide_array.push({id: 'id', position: 'slideNo', background_color: 'bkgd', thumbnail_path: 'thumb', widg_array: 'widgetArray'});


		//slide_array.push(temp_slide); //this initalizes a blank slide
		slide_array[i].id = encodedStoryArray[i].slide_id; //update slide_ID from database
		//alert(slide_array[i].id);
		slide_array[i].position = encodedStoryArray[i]['position']; //set position
		slide_array[i].background_color = encodedStoryArray[i]['background_color']; //set bkgd color
		slide_array[i].thumbnail_path = encodedStoryArray[i]['thumbnail_file_path']; //set thumbnail path
		slide_array[i].widg_array = new Array(); //create third dimension array in slide_array
		slide_array[i].widget_count = 0;
		
		if (Array.isArray(encodedStoryArray[i][0])){
			//for(var j=0; j < encodedStoryArray[i][0].length; j++){
				/*temp = new Array();
				if (encodedStoryArray[i][0][j][1] == 4){ // text
					temp.push(encodedStoryArray[i][0][j][1]);//type
					temp.push(encodedStoryArray[i][0][j][2]);//slide id
					temp.push(encodedStoryArray[i][0][j][3]);//width
					temp.push(encodedStoryArray[i][0][j][8]);//fontsize
					temp.push(encodedStoryArray[i][0][j][5]);//x
					temp.push(encodedStoryArray[i][0][j][6]);//y
					temp.push(encodedStoryArray[i][0][j][7]);//layer
					temp.push(encodedStoryArray[i][0][j][10]);//text
					temp.push(encodedStoryArray[i][0][j][0]);//id
					temp.push(encodedStoryArray[i][0][j][4]);//color
					temp.push(encodedStoryArray[i][0][j][9]);//style
				}
				else{
					temp.push(encodedStoryArray[i][0][j][1]);//type
					temp.push(encodedStoryArray[i][0][j][2]);//slide id
					temp.push(encodedStoryArray[i][0][j][3]);//width
					temp.push(encodedStoryArray[i][0][j][4]);//size
					temp.push(encodedStoryArray[i][0][j][5]);//x
					temp.push(encodedStoryArray[i][0][j][6]);//y
					temp.push(encodedStoryArray[i][0][j][7]);//layer
					temp.push(encodedStoryArray[i][0][j][8]);//file
					temp.push(encodedStoryArray[i][0][j][0]);//id
					temp.push(encodedStoryArray[i][0][j][9]);//autoplay / border
				}*/
				
				slide_array[i].widg_array = encodedStoryArray[i][0];
				//slide_array[i].widg_array.push(temp);
				//++slide_array[i].widget_count;
				//alert("timeline::encodedStoryArray["+i+"]\n"+encodedStoryArray[i][0]);
				//alert(encodedStoryArray[i][j] +" from nested for loop should return widg_array");
			//}
		}
		//}				
		//}

		/*
		//loop through array from DB to populate javascript slide_array
		var storyArrayLength = encodedStoryArray.length;
			for(var i=0; i < storyArrayLength; i++){   
					//initialize slide array  //actually not needed
					slide_array.push({id: 'id', position: 'slideNo', background_color: 'bkgd', thumbnail_path: 'thumb', widg_array: 'widgetArray'});


					//slide_array.push(temp_slide); //this initalizes a blank slide
					slide_array[i].id = encodedStoryArray[i].slide_id; //update slide_ID from database
					//alert(slide_array[i].id);
					slide_array[i].position = encodedStoryArray[i]['position']; //set position
					slide_array[i].background_color = encodedStoryArray[i]['background_color']; //set bkgd color
					slide_array[i].thumbnail_path = encodedStoryArray[i]['thumbnail_file_path']; //set thumbnail path
					slide_array[i].widg_array = new Array(); //create third dimension array in slide_array
					//for(var j=0; j < encodedStoryArray[i].no_widgets; j++){
					if (Array.isArray(encodedStoryArray[i][0])){
						slide_array[i].widg_array = encodedStoryArray[i][0];
						alert("timeline::encodedStoryArray["+i+"]\n"+encodedStoryArray[i][0]);
						//alert(encodedStoryArray[i][j] +" from nested for loop should return widg_array");
					}
					//}				
			}*/

		//please for the love of god load this...	
		//display_slide();
		//IMPORTANT DO NOT REMOVE, sends onload data to doc_ready for populating timeline	



		//as the for loop executes and populates each slide, assign the current_slide to slideNo. Maybe not needed?
		current_slide = slideNo; 

		//initialize proper associative array in a slide and append blank slide to slide_array	
		//var temp_slide = new Array();
		//temp_slide.push({id: 'id', position: 'slideNo', background_color: 'bkgd', thumbnail_path: 'thumb', widg_array: 'widgetArray'});

	}
	catch(e) {
		log("timeline_function.js error populating slide_array " + i, e.lineNumber, e);
	}

	slideNo++; //after everything, all the try catches, cake and ice cream increment the slide number

}

/**
 * get variable 
 * @method GET_variable
 * returns variable
 */
function GET_variable(name){
	try{
		var query_string = window.location.search.substring(1); // get url
		var vars = query_string.split("&"); // split by variables
		for (var i=0;i<vars.length;i++) { 
			var pair = vars[i].split("=");
			if(pair[0] == name){return pair[1];}
		}
		return(false);
	}
	catch(e) {
		log("timeline_function.js error getting variable name", e.lineNumber, e);
	}
}


//JSON turns this serialized string back into actual data over in orderTimeline.php
/*	$(document).ready(function(){
	    $("#timelineSortable").sortable({
	        stop : function(event, ui){
	          alert($(this).sortable('serialize'));  //remove for now or demo
	          var data = $(this).sortable('serialize');//this captures the order of slides after mouseUp
	          //use AJAX to post to orderTimeline.php
	          $.post({   
		            data: data, //this is the actual array being converted to a string for sending purposes
		            type: 'POST',
		            url: 'includes/orderTimeline.php'  //where the _POST variable will be updated with 'data'
		        });
	        }
	    });
	  	$("#sortable").disableSelection();
	});//ready
 */






