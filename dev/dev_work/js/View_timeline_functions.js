/**JS written for timeline portion of testView page
 *
 * this file is supposed to accomplish the following functions:

 * Populate timeline when new story loads
 * populate slide widgets on canvas
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
		slideLabel.appendChild(txt); //put the text in the p
		thumbDiv.appendChild(slideThumb); //insert the img into the div
		thumbDiv.appendChild(slideLabel); //insert the label into the div

		//create jQuery object and set click functionality
		$( li ).append(thumbDiv); //check to see if this appends in jQuery
		$( ul ).append(li);
		//mouseDown function for slides
		$(".slideThumb img").unbind('click');
		$(".slideThumb img").click(function() {


			/* important order of logic: save draft (of whatever previous slide was automatically)
			 * 1. save slide user just left
			 * 2. get position of current slide
			 * 3. set widget array to be current widget array
			 * 4. display_slide
			 * 5. set clicked slide as current slide
			 */

			/* step 1 */
			//saver('draft');//currently errors out

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
			/*for(var j=0; j < encodedStoryArray[i][0].length; j++){
				temp = new Array();
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






