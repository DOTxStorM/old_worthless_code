//////DRAGGABLE // // //
/*
 * All the functionality for dragging a new widget onto the canvas, dragging a
 * widget on the canvas, selecting a widget is handled below
 */

function draggable_init(){
	try{
		// enable items from left sidebar to be draggable to canvas
		$(".drag_item").draggable({
			revert: true,
			revertDuration: 0,
			helper: "clone",
			opacity: 0.7,
			start: function(event, ui) { 
				$(this).draggable("option", "cursorAt", {
					left: Math.floor(this.clientWidth / 2),
					top: Math.floor(this.clientHeight / 2)
				}); 
			}
		});

		// Allow widgets to be dropped on canvas
		$("#storyCanvas").droppable({
			activeClass: "canvas_active",
			hoverClass: "canvas_hover",
			accept: ".drag_item",
			drop: function( event, ui ) {

				// Get widget type
				var type = $(ui.draggable).attr('id');

				// Create the object and add it to the canvas
				//var new_w = create_widget(type);
				var ob_id = new_id();
				widget_array[ob_id] = new_widget_dataset(type);
				var $ob = create_widget(widget_array[ob_id]);

				// set local id
				$ob.attr('l_id', ob_id);

				// send AJAX request for new id data
				// automatically sets the appropriate id's in the widget array once they're received
				get_ID_data(ob_id);

				// initialize widget functionality
				widget_init($ob, event);


				// Finally, select the new object
				setSelected($ob);

				// Set source for all media widgets
				if (type == "_video" || type == "_audio" || type == "_picture" || type == "_embedded" ){
					openFileDialog();
				}
			}
		});

		// Deselection: user clicks on canvas, but not on widget
		$("#storyCanvas").mousedown(function(){
			canvasMouseDown();
		});
	}
	catch(e){
		log("drag_drop.js draggable_init", e.lineNumber, e);
	}
}

function setSrc(url){
	try{
		l_id = $("#selected").attr('l_id');

		if ($("#selected").hasClass("widg_video")){
			$("#selected").html(new_video_widget(url, 'false'));
			widget_array[l_id][2] = $("#selected").children().children().width();
			//widget_array[l_id][3] = $("#selected").children().children().height();
		}
		else if($("#selected").hasClass("widg_embedded")){
			$("#selected").html(new_embedded_widget(url, 'false'));
		}
		else if($("#selected").hasClass("widg_audio")){
			$("#selected").html(new_audio_widget(url, 'false'));
		}
		else if($("#selected").hasClass("widg_picture")){
			$("#selected").html(new_picture_widget(url));
			widget_array[l_id][2] = $("#selected").children().width();
			widget_array[l_id][3] = $("#selected").children().height();
			$("#width").val(widget_array[l_id][2]);
			//$("#height").val(widget_array[l_id][3]);
		}
		// DEMO
		else if($("#selected").hasClass("widg_text")){
			$("#selected").html(new_text_widget(url));
		}
		widget_array[l_id][7] = url;
	}
	catch(e){
		log("drag_drop.js set_src", e.lineNumber, e);
	}
}

//Sends ajax request, waits for response 
function get_ID_data(ob_id){
	try{
		// assmeble data to send
		var data = JSON.stringify(widget_array[ob_id]);
		$.post("includes/insert_widget.php", {
			json : data,
			slide_id : slide_array[current_slide - 1].id,
		}, function(r){
			//var result = JSON.parse(r);

			if (typeof(result) == "string"){
				// Display error 
				//alert("We could not make this widget. :: "+result);
				delete widget_array[ob_id];
				$('[l_id=' + ob_id.toString() + "]").css({
					'border': "solid red 2px",
				});
				return false;
			}
			else{
				// set id in array
				widget_array[ob_id][8] = r;
				return true;
			}

		})
		.error(function(){
			//alert("Could not connect to DB.");
		});

		//alert("request for widget id sent");
	}
	catch(e){
		log("drag_drop.js insert_widget get_ID_data", e.lineNumber, e);
	}
}

//When widget is selected, highlight it and set id to 'selected'
function setSelected($new){
	try{		
		// unhighlight everything
		$(".widg").removeClass("selected_widg");

		$("#selected").removeAttr('id');

		// TEMP
		$(".widg").css({
			'-webkit-box-shadow' : 'none', 
			'-moz-box-shadow': 'none', 
			'box-shadow':'none',
		});

		// clear selection
		selected_widget = null;

		// check if object was selected
		if ($new !== null){

			// set id to selected
			$new.attr("id","selected");

			// set selected widget int
			selected_widget = $new.attr('l_id');

			// highlight selected
			$new.addClass("selected_widg");

			// TEMP
			$(".selected_widg").css({
				'-webkit-box-shadow' : '0 0 5px blue', 
				'-moz-box-shadow': '0 0 5px blue', 
				'box-shadow':'0 0 5px blue',
			});
		}
		setSidebar();
		setDisplayCoordinates($new);
	}

	catch(e){
		log("drag_drop.js setSelected", e.lineNumber, e);
	}
}

//Newly created widget appears on canvas
function addWidgToCanvas($widg, coor){
	try{
		var relX = coor[0];
		var relY = coor[1];

		//
		var $par = $("#storyCanvas");

		$widg.appendTo($par);

		// Set location to mousedrop
		//$widg.css({top: Math.round(relY - $widg.height()/2), left: Math.round(relX - $widg.width()/2), position:'absolute'});

		$widg.css({
			position:'absolute',
			top: Math.round(relY - $widg.height()/2), 
			left: Math.round(relX - $widg.width()/2) 
		});


		// Get position relative to canvas for display
		setSidebar(); 
	}
	catch(e){
		log("drag_drop.js addWidgetToCanvas", e.lineNumber, e);
	}
}

//Updates coordinates in attribute bar
function setDisplayCoordinates($widg){
	try{
		if ($widg === null){
			// we cant display coordinates of nothing
			return;
		}

		var widgPosition = $widg.position();
		var x = Math.round(widgPosition.left);
		var y = Math.round(widgPosition.top);

		$("#x").val(x);
		$("#y").val(y);  

		var l_id = $widg.attr("l_id");
		//set widget array widget coordinates
		slide_array[current_slide - 1].widg_array[l_id][4] = x;
		slide_array[current_slide - 1].widg_array[l_id][5] = y;
	}
	catch(e){
		log("drag_drop.js setDisplayCoordinates", e.lineNumber, e);
	}
}

//Gets coordinates of drop for display
//TEMP NEEDS FIXING
function getRelativeCoordinates(event){
	try{
		var $par = $("#storyCanvas");
		var parentOffset = $par.offset(); 
		var relX = event.pageX + (parentOffset.left);
		var relY = event.pageY - (parentOffset.top);
		return [relX, relY];
	}
	catch(e){
		log("drag_drop.js getRelativeCoordinates", e.lineNumber, e);
	}
}

//Gives new id
function new_id(){
	return ++id_counter;
}

//Handles click on widget
function widgMouseDown($widg){
	try {
		// Store widget clicked globally
		widg_clicked = true;

		// Store coordinates on click
		var pos = $widg.position();
		x_old = pos.left;
		y_old = pos.top;

		setSelected($widg);
	}
	catch(e) {
		log("drag_drop.js widgMouseDown", e.lineNumber, e);
	}
}

//Handles mouseup on widget
function widgMouseUp($widg){
	// Get coordinates on mouseup,
	// if widget has moved, save the data to the widget array
	try {
		var pos = $widg.position();
		var x_new = pos.left;
		var y_new = pos.top;
		if (x_new !== x_old || y_new !== y_old){
			// update coordinates in widget array
			var l_id = $widg.attr('l_id');
			// update x value
			widget_array[l_id][4] = x_new;
			//update y value
			widget_array[l_id][5] = y_new;

		}// otherwise, do nothing

		// Release widget
		widg_clicked = false;
	}
	catch(e) {
		log("drag_drop.js widgMouseUp", e.lineNumber, e);
	}
}

function canvasMouseDown(){
	try {
		if (!widg_clicked){
			setSelected(null);
		}
	}
	catch(e) {
		log("drag_drop.js canvasMouseDown", e.lineNumber, e);
	}
}


//Creating new widgets on the screen

//Default html for picture widget
function new_picture_widget(source){
	try{
		return "<div class='widg widg_picture'>"+
		"<img class='widg widg_picture' src='"+source+"'/>"+
		"</div>";
	}
	catch(e){
		log("drag_drop.js new_picture_widget", e.lineNumber, e);
	}
}

//Default html for audio widget
function new_audio_widget(source, autoplay){
	try{
		var controls = "";

		var type = getExtension(source);
		if (!type){
			return false;
		}

		if (autoplay == "true"){
			controls = 'autoplay';
		} 
		return '<div class="widg widg_audio"><audio controls '+controls+'>'+
		'<source src="'+ source +'" type="audio/'+type+'">'+
		'</audio></div>';
	}
	catch(e){
		log("drag_drop.js new_audio_widget", e.lineNumber, e);
	}
}

//Default html for text widget
function new_text_widget(text){
	try{
		return "<div class='widg widg_text'>"+text+"</div>";
	}
	catch(e){
		log("drag_drop.js new_text_widget", e.lineNumber, e);
	}
}

//Default html for video widget
function new_video_widget(source, autoplay){
	try{
		var type = getExtension(source);
		if (!type){
			return false;
		}

		var controls = "";
		if (autoplay == "true"){
			controls = 'autoplay';
		}
		else{
			controls = '';
		}
		return "<div class='widg widg_video'><video controls "+controls+">"+
		"<source src='"+source+"' type='video/"+type+"'>"+
		"</video>"+
		"</div>";
	}
	catch(e){
		log("drag_drop.js new_video_widget", e.lineNumber, e);
	}
}

//Default html for new new video embedded from youtube
function new_embedded_widget(source, autoplay){
	//alert(source);
	try{
		var controls = "?autoplay=0";
		if (autoplay == "true"){
			controls = '?autoplay=1';
		}
		var src = "";
		var pair = "";
		var query_string = source.split('?')[1] + ""; // get url
		var vars = query_string.split("&") + ""; // split by variables
		if (!(vars instanceof Array)) {
			pair = vars.split("=");
			if(pair[0] == 'v'){
				src = pair[1];
			}
		}
		else{
			for (var i=0;i<vars.length;i++) {
				pair = vars[i].split("=");
				if(pair[0] == 'v'){
					//alert("src::: "+pair[1]);
					src = pair[1];
					break;
				}
			}  
		}
		return "<div style='padding:30px' class='widg widg_embedded'><iframe type='application/x-shockwave-flash'" +
		" src='http://www.youtube.com/v/"+src+controls+"'>"+
		"</object>"+
		"</div>";
	}
	catch(e){
		log("drag_drop.js new_embedded_widget", e.lineNumber, e);
	}
}

//Creates an array of all the widgets data, stored locally in widget_array,
//referenced by objects l_id
function new_widget_dataset(type){

	try{
		//var layer = num_layers[current_slide - 1];
		var layer = slide_array[current_slide - 1].widget_count + 1;
		var slide_id = slide_array[current_slide - 1].id;

		if (type == "_video"){
			return [1,slide_id,250,null,200,200,layer,"temp.mp4",null,false];
		}
		else if(type == "_embedded"){
			return [2,slide_id,null,null,200,200,layer,"",null,false];
		}
		else if(type == "_audio"){
			return [3,slide_id,250,null,200,200,layer,"temp.mp3",null,false];
		}
		else if(type == "_picture"){
			return [0,slide_id,250,250,200,200,layer,"img.jpg",null,"none"];
		}
		else if(type == "_text"){
			return [4,slide_id,120,20,200,200,layer,"Sample Text",null,"#000000","Verdana"];
		}
	}
	catch(e){
		log("drag_drop.js new_widget_dataset", e.lineNumber, e);
	}
}

function create_widget(widg_data){
	try {
		if ( typeof(widg_data) == "undefined" || widg_data === null ) {
			//alert("null widget");
			return null;
		}

		// increment number of layers
		//++num_layers[current_slide - 1];
		// All widgets require that the length of the data array be verified
		// image
		//if widg_data is null slide has no widgets,, make next line else if
		if (widg_data.length == 10 || (widg_data.length == 11 && widg_data[0] == 4)){
			// picture				
			if (widg_data[0] == 0){
				return make_image(widg_data);
			}
			// video
			else if (widg_data[0] == 1){
				return make_video(widg_data);
			}
			// embedded video
			else if (widg_data[0] == 2){
				return make_embedded(widg_data);
			}
			// audio
			else if (widg_data[0] == 3){
				return make_audio(widg_data);
			}
			// text
			else if(widg_data[0] == 4){
				return make_text(widg_data);
			}
			else{
				//alert("Error?");
				// Error?
			}
			
			++slide_array[current_slide - 1].widget_count;

			
		}
	}
	catch(e) {
		log("drag_drop.js create_widget", e.lineNumber, e);
	}
}

//Include data if it's video or audio???
function make_video(data){
	try {
//		load all data into local variables
		var ref_id = data[1];
		var width = data[2] + 'px';
		var scale = data[3] + 'px';
		var x = data[4];
		var y = data[5] ;
		var layer = data[6];
		var file = data[7];
		var media_id = data[8];
		var autoplay = data[9];

//		Begin construction object
		$widg = $(new_video_widget(file, autoplay));
		$widg.children().css({
			width : width,
			//height : (width / scale),
			'z-index' : layer,
		});
		$widg.position({
			top: y,
			left: x,
		});

		return $widg;
	}
	catch(e) {
		log("drag_drop.js make_video", e.lineNumber, e);
	}

}

//Include data if it's video or audio???
function make_embedded(data){
	try {
//		load all data into local variables
		var ref_id = data[1];
		var width = data[2] + 'px';
		var scale = data[3] + 'px';
		var x = data[4];
		var y = data[5] ;
		var layer = data[6];
		var source = data[7];
		var media_id = data[8];
		var autoplay = data[9];	

//		Begin construction object
		$widg = $(new_embedded_widget(source,autoplay));

		$widg.children().css({
			width : width,
			//height : (width / scale),
			'z-index' : layer,
		});

		return $widg;
	}
	catch(e) {
		log("drag_drop.js make_embedded", e.lineNumber, e);
	}
}

function make_image(data){
	try {
//		load all data into local variables
		var ref_id = data[1];
		var width = data[2] + 'px';
		//var height = data[3] + 'px';
		var x = data[4];
		var y = data[5] ;
		var layer = data[6];
		var file = data[7];
		var img_id = data[8];
		var border = data[9];

//		Begin construction object
		//alert(file);
		$widg = $(new_picture_widget(file));
		$widg.children().css({
			width : width,
			//height : height,
			'z-index' : layer,
			border : border,
		});

		return $widg;
	}
	catch(e) {
		log("drag_drop.js make_image", e.lineNumber, e);
	}

}

//Include data if it's video or audio???
function make_audio(data){
	try {
//		load all data into local variables
		var ref_id = data[1];
		var width = data[2] + 'px';
		var hidden = data[3];
		if (hidden == "true"){
			hidden = "hidden";
		}
		else{
			hidden = "inline";
		}
		var x = data[4];
		var y = data[5] ;
		var layer = data[6];
		var file = data[7];
		var media_id = data[8];
		var autoplay = data[9];


//		Begin construction object
		$widg = $(new_audio_widget(file, autoplay));

		$widg.children().css({
			width : width,
			display : hidden,
			'z-index' : layer,
		});

		return $widg;
	}
	catch(e) {
		log("drag_drop.js make_audio", e.lineNumber, e);
	}

}

function make_text(data){
	try {
//		load all data into local variables
		var ref_id = data[1];
		var width = data[2] + 'px';
		var size = data[3] + 'px';
		var x = data[4];
		var y = data[5] ;
		var layer = data[6];
		var text = data[7];
		var text_id = data[8];
		var color = data[9];
		var style = data[10];


//		Begin construction object
		$widg = $(new_text_widget(text));


		//$widg.children().css({   removed
		$widg.css({
			'margin' : 0,
			'padding' : 0,
			'color' : color, 
			'font-size' : size,
			'font-family' : style,
			width : width,
			'z-index' : layer,
		});

		return $widg;
	}
	catch(e) {
		log("drag_drop.js make_text", e.lineNumber, e);
	}
}


/////// Loading slide - > populates canvas with widget_data

function display_slide(){
	try {
		// wipe slide
		clear_all();

		// aquire new data
		widget_array = slide_array[current_slide-1].widg_array;
		slide_array[current_slide-1].widget_count = widget_array.length;
		for (var i = 0; i < widget_array.length; ++i){
			// create widget from saved data
			$widg = create_widget(widget_array[i]);
			if ($widg === null || typeof($widg) == "undefined"){
				//alert("widg "+i+" undefined")
				continue;
			}

			//alert("display_slide is being called...");

			//alert(widget_array[i] + " is widget_array[i]");

			//set local id
			$widg.attr('l_id', i);
			
			if (this_page == "play"){
				widget_init($widg, 'play');
			}
			else{
				widget_init($widg, null);  //i being passed as event just so it can populate coordinates better than long call
			}
		}     
	}
	catch(e) {
		log("drag_drop.js display_slide", e.lineNumber, e);
	}

}

//removes all widgets from canvas
function clear_all(){
	try {
		$("#storyCanvas").children().remove();
	}
	catch(e) {
		log("drag_drop.js clear_all", e.lineNumber, e);
	}

}

function widget_init($ob, event){
	try {
		var coor = [0,0]; //init array of 2 coordinates
		if(event !== null && event !== "play"){
			// create new entry in local widget array
			coor = getRelativeCoordinates(event);
			addWidgToCanvas($ob, coor);
		}
		else{
			//need to set coordinates then add widg to canvas
			//i captures current slide position so no need for long code
			coor = [widget_array[$ob.attr('l_id')][4],widget_array[$ob.attr('l_id')][5]]; //coords from widget_array

			var relX = coor[0];
			var relY = coor[1];


			var $par = $("#storyCanvas");
			//put widget on storyCanvas
			$widg.appendTo($par);
			$widg.css({position:'absolute', top: relY, left: relX});
			$widg.offset({top: relY, left: relX});
		}


		if (event !== "play"){
			// // DEFINE new OBJECT's FUNCTIONALITY // //

			// When clicked, set new object as selected
			$ob.mousedown(function(){
				widgMouseDown($(this));
			});

			// When mouse goes up, if the coordinates have changed, save the
			// widget
			$ob.mouseup(function(){
				widgMouseUp($(this));
			});

			// mouse becomes pointer when over
			$ob.css({
				"cursor": "pointer"
			});

			// TEST
			$ob.dblclick(function(){
				//alert(widget_array[selected_widget]);
				//setSrc(prompt(''));
				//alert($(this).html());
			});

			// Make object draggable
			$ob.draggable({
				containment: "#storyCanvas",
				scroll: false,
				// While being dragged, update x, y coordinates in attr bar
				drag: function() {
					// update on attribute bar
					setDisplayCoordinates($ob);           
				}
			});
		}
	}
	catch(e) {
		log("drag_drop.js widget_init", e.lineNumber, e);
	}

}

function getExtension(file){
	try {
		var f = file.split('.');

		if (f.length > 1){
			return f.pop();
		}
		else{
			return false;
		}
	}
	catch(e) {
		log("drag_drop.js getExtension", e.lineNumber, e);
	}

}


