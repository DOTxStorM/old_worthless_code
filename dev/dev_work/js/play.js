function displaySlides(p_story_array){
    //alert("in display slides");
    var slide_array = createSlideArray(p_story_array);   
    var numSlides = slide_array.length;
    
    /*
    var selected_wigdet = null;			//the widget that the user has clicked on -- start with nothing selected
    var selected_slide = null;          //the slide the user currently is viewing
    				//the slide the user is looking at -- start at 1
    var widget_array = new Array();		//the array of widgets on CURRENT slide
    var id_counter = 0;
    var widg_clicked = false;
    var num_layers = 1;
    */
    var current_slide = 1;
    var slides_container = document.getElementById("slide_content");
    var ul = document.createElement("ul");
    var slideNo = 0; 
    for(var i = 0; i < numSlides; i++){
        //var slide = p_slides[i];
       // slide_div.class = "slides";
        var slide_div = document.createElement("div"); //create a div to put in the li
        
        try{
            var li = document.createElement("li"); //create a new li to add to it
            li.className = "slide_list_item";
            slide_div.id = slide_array[i]['slide_id']; 
            slide_div.setAttribute("class", "slides"); //set css class for thumbnail
            var slideThumb = document.createElement("img"); // create an img to put in the div
            
            //slideThumb.setAttribute("src", "images/profile.png"); //!!!CHANGE TO REFLECT USER UPLOAD WHEN BUILT!!!!!!
            slide_div.appendChild(slideThumb);
            li.appendChild(slide_div); //create div in the li
            ul.appendChild(li);	//li in the ul	
            slides_container.appendChild(ul);

            /*
            li.setAttribute("class", "slideSorter"); //ensure the li is the same class as the current list
            li.setAttribute("id", "slide-"+(i + 1));//this needs to find out how many slides there are
            var txt = document.createTextNode("Slide "+(i + 1)); //label current slide number
            slideLabel.appendChild(txt); //put the text in the p
      
            slide_div.appendChild(slideLabel); //insert the label into the div
            
            
            slides_container.appendChild(ul);
            //initialize proper associative array in a slide and append blank slide to slide_array	
            //var temp_slide = new Array();
            //temp_slide.push({id: 'id', position: 'slideNo', background_color: 'bkgd', thumbnail_path: 'thumb', widg_array: 'widgetArray'});
            */
        }catch(e){
            return;
        }
    }   
}

// Slide constructor function
function Slide(p, w, d){
    var position; 		// position in the story's order
    var widget_array; 	// array containing all the widget data for this new slide
    var data;			// other data for slide, such as background color, stored in associative array

    this.position = p;
    this.widget_array = w;
    this.data = d;
}


function createSlideArray(story_array){ 
    var slide_array = new Array();//contains all the slides of the story
	
    //loop through array from DB to populate javascript slide_array
    var storyArrayLength = story_array.length;
    
    for(var i=0; i < storyArrayLength; i++){
        slide_array[i] = { };
        slide_array[i]['slide_id'] = story_array[i]['slide_id']; //update slide_ID from database
        slide_array[i]['position'] = story_array[i]['position']; //set position;
        slide_array[i]['background_color'] = story_array[i]['background_color']; //set bkgd color
        slide_array[i]['thumbnail_file_path'] = story_array[i]['thumbnail_file_path']; //set thumbnail path
        
        //slide_array[i].widg_array = new Array(); //create third dimension array in slide_array
        //NEED TO CALL GETwIDGET HERE AS DB FUNCTION TO POPULATE WIDGET ARRAY WITH SECOND FOR LOOP
    } 
    return slide_array;
}

    
