//id='widgetAttributes'

//When user clicks on a widget, this appropriate inputs are displayed
function setSidebar(){
	try{

		$s = $("#selected");
		$a = $("#widgetAttributes");

		// remove all attributes from sidebar
		clearAttributes($a);
		
		slide_array[current_slide - 1].widget_count = widget_array.length;

		
		if (selected_widget === null){
			// display background/slide attributes
			showSlideAttributes($a);
		}
		else{
			
			if ($s.hasClass("widg_text")){
				// Display text attributes
				showTextAttributes($s, $a);
			}
			else if ($s.hasClass("widg_audio")){
				// Display audio attributes
				showAudioAttributes($s, $a);
			}
			else if ($s.hasClass("widg_video")){
				// Display video attributes
				showVideoAttributes($s, $a);
			}
			else if ($s.hasClass("widg_picture")){
				// Display picture attributes
				showPictureAttributes($s, $a);
			}
			else if ($s.hasClass("widg_embedded")){
				// Display embedded attributes
				showEmbeddedAttributes($s, $a);
			}
			else{
				// Error;
			}
		}
	}
	catch(e){
		log("widget_attr.js", e.lineNumber, e);
	}
}


//Dislpay various attributes according to widget type


//if no widget is selected, let user change background color
function showSlideAttributes($a){
	try{
		//color picker
		$a.append("<label id='l_color_canvas'>Color</label><input id='color' type='color' />");

		activateSlide($a);
	}
	catch(e){
		log("widget_attr.js", e.lineNumber, e);
	}
}

//Populate sidebar with attribute options
function showTextAttributes($s, $a){
//	Append all inputs to widgetAttributes div
	try{

		// layer
		$a.append("<label id='l_layer'>Layer <span id='layer_value'></span></label><input id='layer' type='range' min='1' max='"+(slide_array[current_slide - 1].widget_count)+"' />");
		// width
		$a.append("<label id='l_width'>Width</label><input id='width' type='range' min='5' max='400' />");
		// x-coordinate
		$a.append("<label id='l_x'>X</label><input readonly='readonly' id='x' type='number' />");
		// y-coordinate
		$a.append("<label id='l_y'>Y</label><input readonly='readonly' id='y' type='number' />");

		// font selector
		$a.append(createFontSelectorHTML());
		// text
		$a.append("<textarea id='text' name='textarea' rows='4' maxlength='1000' style='resize: none;' placeholder='Enter text here'></textarea>");
		// text size
		$a.append("<label id='l_size'>Text Size</label><input id='size' type='range' min='8' max='72' />");
		//color picker
		$a.append("<label id='l_color'>Color</label><input id='color' type='color' />");

		

		//Delete button
		$a.append("<button id='b_delete' onclick='deleteWidget()'>Delete Widget</button>");

		textInit($s, $a);
	}
	catch(e){
		log("widget_attr.js", e.lineNumber, e);
	}
}

//Populate sidebar with attribute options
function showVideoAttributes($s, $a){
	try{
		// layer
		$a.append("<label id='l_layer'>Layer <span id='layer_value'></span></label><input id='layer' type='range' min='1' max='"+(slide_array[current_slide - 1].widget_count)+"' />");
		// size
		$a.append("<label id='l_size'>Size</label><input id='size' type='range' min='200' max='400' />");
		// x-coordinate
		$a.append("<label id='l_x'>X</label><input readonly='readonly' id='x' type='number' />");
		// y-coordinate
		$a.append("<label id='l_y'>Y</label><input readonly='readonly' id='y' type='number' />");

		// autoplay
		$a.append("<label id='l_autoplay'>Autoplay </label><input id='autoplay' type='checkbox' />");

		// source
		$a.append("<button id='b_source' onclick='openFileDialog();'>Change Source</button>");

		
		//Delete button
		$a.append("<button id='b_delete' onclick='deleteWidget()'>Delete Widget</button>");

		videoInit($s, $a);
	}
	catch(e){
		log("widget_attr.js", e.lineNumber, e);
	}
}

//Populate sidebar with attribute options
function showEmbeddedAttributes($s, $a){
	try{
		// layer
		$a.append("<label id='l_layer'>Layer <span id='layer_value'></span></label><input id='layer' type='range' min='1' max='"+(slide_array[current_slide - 1].widget_count)+"' />");
		// size
		$a.append("<label id='l_size'>Size</label><input id='size' type='range' min='200' max='400' />");
		// x-coordinate
		$a.append("<label id='l_x'>X</label><input readonly='readonly' id='x' type='number' />");
		// y-coordinate
		$a.append("<label id='l_y'>Y</label><input readonly='readonly' id='y' type='number' />");

		// autoplay
		$a.append("<label id='l_autoplay'>Autoplay </label><input id='autoplay' type='checkbox' />");

		// source
		$a.append("<button id='b_source' onclick='openFileDialog();'>Change Source</button>");

		
		//Delete button
		$a.append("<button id='b_delete' onclick='deleteWidget()'>Delete Widget</button>");

		embeddedInit($s, $a);
	}
	catch(e){
		log("widget_attr.js", e.lineNumber, e);
	}
}

//Populate sidebar with attribute options
function showAudioAttributes($s, $a){
	try{
		// layer
		$a.append("<label id='l_layer'>Layer <span id='layer_value'></span></label><input id='layer' type='range' min='1' max='"+(slide_array[current_slide - 1].widget_count)+"' />");
		// size
		$a.append("<label id='l_size'>Size</label><input id='size' type='range' min='45' max='400' />");
		// hidden
		$a.append("<label id='l_hidden'>Hidden </label><input id='hidden' type='checkbox' />");
		// x-coordinate
		$a.append("<label id='l_x'>X</label><input readonly='readonly' id='x' type='number' />");
		// y-coordinate
		$a.append("<label id='l_y'>Y</label><input readonly='readonly' id='y' type='number' />");

		// autoplay
		$a.append("<label id='l_autoplay'>Autoplay </label><input id='autoplay_audio' type='checkbox' />");

		// source
		$a.append("<button id='b_source_audio' onclick='openFileDialog();'>Change Source</button>");

		
		//Delete button
		$a.append("<button id='b_delete_audio' onclick='deleteWidget()'>Delete Widget</button>");

		audioInit($s, $a);
	}
	catch(e){
		log("widget_attr.js", e.lineNumber, e);
	}
}

//Populate sidebar with attribute options
function showPictureAttributes($s, $a){
	try{
		// layer
		$a.append("<label id='l_layer'>Layer <span id='layer_value'></span></label><input id='layer' type='range' min='1' max='"+(slide_array[current_slide - 1].widget_count)+"' />");
		// width
		$a.append("<label id='l_size'>Size</label><input id='width' type='range' min='5' max='400' />");
		// height
		//$a.append("<label>Height</label><input id='height' type='range' min='5' max='400' />");
		// x-coordinate
		$a.append("<label id='l_x'>X</label><input readonly='readonly' id='x' type='number' />");
		// y-coordinate
		$a.append("<label id='l_y'>Y</label><input readonly='readonly' id='y' type='number' />");

		//TEMP
		// border?

		// source
		$a.append("<button id='b_source_picture' onclick='openFileDialog();'>Change Source</button>");


		//Delete button
		$a.append("<button id='b_delete_picture_picture' onclick='deleteWidget()'>Delete Widget</button>");

		pictureInit($s, $a);
	}
	catch(e){
		log("widget_attr.js", e.lineNumber, e);
	}
}

//removes all attributes from sidebar
function clearAttributes($a){
	try{
		$a.children().remove();
	}
	catch(e){
		log("widget_attr.js", e.lineNumber, e);
	}
}

//Creates html for font dropdown menu
function createFontSelectorHTML(){
	try{
		return "<label>Font</label><select id='font'>"+
		"<option value='Arial' style='font-family:Arial'>Arial</option>"+
		"<option value='Impact' style='font-family:Impact'>Impact</option>"+
		"<option value='Lucida Grande' style='font-family:Lucida Grande'>Lucida Grande</option>"+
		"<option value='Times New Roman' style='font-family:Times New Roman'>Times New Roman</option>"+
		"<option value='Verdana' style='font-family:Verdana'>Verdana</option>"+
		"</select>";
	}
	catch(e){
		log("widget_attr.js", e.lineNumber, e);
	}
}

function textInit($s, $a){
	try{
		// get id of widget data in widget_array
		var l_id = $s.attr("l_id");

		// 2 - width
		$("#width").val(widget_array[l_id][2]);
		$s.width(widget_array[l_id][2]);
		// 3 - font size
		$("#size").val(widget_array[l_id][3]);
		$s.css({'font-size': widget_array[l_id][3]});
		// 4 - x
		$("#x").val(widget_array[l_id][4]);
		// 5 - y
		$("#y").val(widget_array[l_id][5]);
		// 6 - layer
		$("#layer").val(widget_array[l_id][6]);
		$("#layer_value").html(widget_array[l_id][6]);
		// 7 - text
		$("#text").html(widget_array[l_id][7]);
		// 9 - color
		$("#color").val(widget_array[l_id][9]);
		// 10 font
		$("#font").val(widget_array[l_id][10]);

		// turns these inputs on
		activateText(l_id);
	}
	catch(e){
		log("widget_attr.js", e.lineNumber, e);
	}
}

function pictureInit($s, $a){
	try{
		// get id of widget data in widget_array
		var l_id = $s.attr("l_id");

		// 2 - width
		$("#width").val(widget_array[l_id][2]);
		// 4 - x
		$("#x").val(widget_array[l_id][4]);
		// 5 - y
		$("#y").val(widget_array[l_id][5]);
		// 6 - layer
		$("#layer").val(widget_array[l_id][6]);
		$("#layer_value").html(widget_array[l_id][6]);

		activatePicture(l_id);
	}
	catch(e){
		log("widget_attr.js", e.lineNumber, e);
	}
}	

function videoInit($s, $a){
	try{

		// get id of widget data in widget_array
		var l_id = $s.attr("l_id");

		// 2 - width
		$("#size").val(widget_array[l_id][2]);

		// 4 - x
		$("#x").val(widget_array[l_id][4]);
		// 5 - y
		$("#y").val(widget_array[l_id][5]);

		// 6 - layer
		$("#layer").val(widget_array[l_id][6]);
		$("#layer_value").html(widget_array[l_id][6]);

		// 9 - autoplay
		var a = false;
		if (widget_array[l_id][9] == "true"){
			a = true;
		}
		$("#autoplay").prop('checked', a);
		
		activateVideo(l_id);
	}
	catch(e){
		log("widget_attr.js _ videoInit", e.lineNumber, e);
	}
}

function embeddedInit($s, $a){
	try{

		// get id of widget data in widget_array
		var l_id = $s.attr("l_id");

		// 2 - width
		$("#size").val(widget_array[l_id][2]);

		// 4 - x
		$("#x").val(widget_array[l_id][4]);
		// 5 - y
		$("#y").val(widget_array[l_id][5]);

		// 6 - layer
		$("#layer").val(widget_array[l_id][6]);
		$("#layer_value").html(widget_array[l_id][6]);

		// 9 - autoplay
		var a = false;
		if (widget_array[l_id][9] == "true"){
			a = true;
		}
		$("#autoplay").prop('checked', a);
		
		activateEmbedded(l_id);
	}
	catch(e){
		log("widget_attr.js _ videoInit", e.lineNumber, e);
	}
}

function activateSlide(){
	$("#color").change(function(){
		//slide_array[current_slide - 1].background_color = $(this).val();
		$("#storyCanvas").css('background-color', $(this).val());
	});
}

//allows sidebar to change data in widget array and of onscreen widget
function activateText(l_id){
	try{
		// 2 - width
		$("#width").on("change mousemove",function(){
			widget_array[l_id][2] = $(this).val();
			$("#selected").width($(this).val());
			//recalculatePosition(l_id);
		});
		// 3 - font size
		$("#size").on("change mousemove",function(){
			widget_array[l_id][3] = $(this).val();
			$("#selected").css("font-size",$(this).val() + 'px');
			//recalculatePosition(l_id);
		});
		// 4 - x coordinate
		$("#x").on("change","#selected", function(){
			//debug
			//this actually doesn't work... but its set in drag_drop setDisplayCoordinates
			widget_array[l_id][4] = $(this).val();
		});
		// 5 - y coordinate
		$("#y").on("change", "#selected", function(){
			widget_array[l_id][5] = $(this).val();
		});
		// 6 - layer
		$("#layer").on("change mousemove",function(){
			setLayer(l_id, $(this).val());
		});
		// 7 - text
		$("#text").bind('input propertychange', function() {
			if (jQuery.trim( $(this).val() )){ // check for empty string
				widget_array[l_id][7] = $(this).val();
				$("#selected").html($(this).val());
				//recalculatePosition(l_id);
			}
			else{ // if empty string, 
				widget_array[l_id][7] = " "; // set space, so it isn't null
				$("#selected").html("<p style='color:grey; margin:0; padding:0;'>Sample Text</p>");
			}
		});
		// 9 - color
		$("#color").change(function(){
			widget_array[l_id][9] = $(this).val();
			$("#selected").css('color', $(this).val());
		});
		// 10 font
		$("#font").change(function(){
			widget_array[l_id][10] = $(this).val();
			$("#selected").css('font-family', $(this).val());
			//recalculatePosition(l_id);
		});
	}
	catch(e){
		log("widget_attr.js", e.lineNumber, e);
	}
	
}

function activatePicture(l_id){
	try{
		// 2 - width
		$("#width").on("change mousemove",function(){
			widget_array[l_id][2] = $(this).val();
			$("#selected").children().width($(this).val());
			//recalculatePosition(l_id);
		});
		// 4 - x coordinate
		$("#x").on("change",function(){
			widget_array[l_id][4] = $(this).val();
		});
		// 5 - y coordinate
		$("#y").on("change",function(){
			widget_array[l_id][5] = $(this).val();
		});
		// 6 - layer
		$("#layer").on("change mousemove",function(){
			setLayer(l_id, $(this).val());
		});
	}
	catch(e){
		log("widget_attr.js", e.lineNumber, e);
	}
}

function activateVideo(l_id){
	try{		
		// 2 - width
		$("#size").on("change mousemove",function(){
			widget_array[l_id][2] = $(this).val();
			$("#selected").children().width($(this).val());
			//recalculatePosition(l_id);
		});
		// 4 - x coordinate
		$("#x").on("change",function(){
			widget_array[l_id][4] = $(this).val();
		});
		// 5 - y coordinate
		$("#y").on("change",function(){
			widget_array[l_id][5] = $(this).val();
		});
		// 6 - layer
		$("#layer").on("change mousemove",function(){
			setLayer(l_id, $(this).val());
		});
		// 9 - autoplay
		$("#autoplay").change(function() {
			if($(this).is(":checked")) {
				widget_array[l_id][9] = "true";
				$("#selected").children()[0].autoplay = true;
			}
			else {
				widget_array[l_id][9] = "false";
				$("#selected").children()[0].autoplay = false;
			}
		});
	}
	catch(e){
		log("widget_attr.js", e.lineNumber, e);
	}
}

function activateEmbedded(l_id){
	try{		
		// 2 - width
		$("#size").on("change mousemove",function(){
			var old_width = widget_array[l_id][2];
			var old_height = $("#selected").children().children().height();
			widget_array[l_id][2] = $(this).val();
			$("#selected").children().children().width($(this).val());
			$("#selected").children().children().height(old_height * ($(this).val() / old_width));
			//recalculatePosition(l_id);
		});
		// 4 - x coordinate
		$("#x").on("change",function(){
			widget_array[l_id][4] = $(this).val();
		});
		// 5 - y coordinate
		$("#y").on("change",function(){
			widget_array[l_id][5] = $(this).val();
		});
		// 6 - layer
		$("#layer").on("change mousemove",function(){
			setLayer(l_id, $(this).val());
		});
		// 9 - autoplay
		$("#autoplay").change(function() {
			if($(this).is(":checked")) {
				widget_array[l_id][9] = "true";
				$("#selected").children().attr("src", $("#selected").children().attr("src").replace("autoplay=0", "autoplay=1"));
			}
			else {
				widget_array[l_id][9] = "false";
				$("#selected").children().attr("src", $("#selected").children().attr("src").replace("autoplay=1", "autoplay=0"));			}
		});
	}
	catch(e){
		log("widget_attr.js", e.lineNumber, e);
	}
}

function activateAudio(l_id){
	try{		
		// 2 - width
		$("#size").on("change mousemove",function(){
			widget_array[l_id][2] = $(this).val();
			$("#selected").children().width($(this).val());
			//recalculatePosition(l_id);
		});
		// 3 - hidden
		$("#hidden").change(function() {
			if($(this).is(":checked")) {
				widget_array[l_id][3] = "true";
				$("#autoplay_audio")[0].disabled = true;
				$("#autoplay_audio").prop('checked', true);
				widget_array[l_id][9] = "true";
			}
			else {
				widget_array[l_id][3] = "false";
				$("#autoplay_audio")[0].disabled = false;
				var auto = false;
				if (widget_array[l_id][9] == "true"){
					auto = true;
				}
				$("#autoplay_audio").prop('checked', auto);
			}
		});
		// 4 - x coordinate
		$("#x").on("change",function(){
			widget_array[l_id][4] = $(this).val();
		});
		// 5 - y coordinate
		$("#y").on("change",function(){
			widget_array[l_id][5] = $(this).val();
		});
		// 6 - layer
		$("#layer").on("change mousemove",function(){
			setLayer(l_id, $(this).val());
		});
		// 9 - autoplay
		$("#autoplay_audio").change(function() {
			if($(this).is(":checked")) {
				widget_array[l_id][9] = "true";
				$("#selected").children()[0].autoplay = true;
			}
			else {
				widget_array[l_id][9] = "false";
				$("#selected").children()[0].autoplay = false;
			}
		});
	}
	catch(e){
		log("widget_attr.js", e.lineNumber, e);
	}
}

/*function recalculatePosition(l_id){
	try{		
		var widgPosition = $("#selected").position();
		alert($("#selected").html());
		var x = widgPosition.left;
		var y = widgPosition.top;

		$("#x").val(Math.round(x));
		$("#y").val(Math.round(y));

		// Set values in widget_array
		widget_array[l_id][4] = $("#x").val();
		widget_array[l_id][5] = $("#y").val();
	}
	catch(e){
		log("widget_attr.js", e.lineNumber, e);
	}
}*/

//Sets all layers as layer of one element is changed. No two elements are ever on the same layer
function setLayer(l_id, val){
	try{

		//store current layer
		var old_layer = widget_array[l_id][6];

		var i = 0; // defined here because I was getting bugs when defining it in two separate loops

		if (val < old_layer){
			// temporarily set this layer to 0
			widget_array[l_id][6] = 0;
			for (i = 0; i < widget_array.length; ++i){
				if((widget_array[i][6] >= val) && (widget_array[i][6] < old_layer)){
					// move all widgets up a layer
					widget_array[i][6] = parseInt(widget_array[i][6]) + 1;
					// set their display
					$("div[l_id='"+i+"']").css('z-index', widget_array[i][6]);
				}
			}
		}
		else if (val > old_layer){
			// temporarily set this layer to 0
			widget_array[l_id][6] = 0;
			for (i = 0; i < widget_array.length; ++i){
				if((widget_array[i][6] > old_layer) && (widget_array[i][6] <= val)){
					// move all widgets up a layer
					widget_array[i][6] = parseInt(widget_array[i][6]) - 1;
					// set their display
					$("div[l_id='"+i+"']").css('z-index', widget_array[i][6]);
				}
			}
		}
		else{
			// If moving to the same layer, do nothing
			return;
		}

		// Set selected widget's layer
		widget_array[l_id][6] = val;
		$("div[l_id='"+l_id+"']").css('z-index', val);
		// display value on sidebar
		$("#layer_value").html(val);

	}
	catch(e){
		log("widget_attr.js", e.lineNumber, e);
	}
}

function audioInit($s, $a){
	try{
		// get id of widget data in widget_array
		var l_id = $s.attr("l_id");

		// 2 - width
		$("#size").val(widget_array[l_id][2]);
		$s.children().width(widget_array[l_id][2]);

		// 3 - hidden
		var h = false;
		if (widget_array[l_id][3] == "true"){
			h = true;
			$("#autoplay_audio")[0].disabled = true;
		}
		$("#hidden").prop('checked', h);

		// 4 - x
		$("#x").val(widget_array[l_id][4]);
		// 5 - y
		$("#y").val(widget_array[l_id][5]);

		// 6 - layer
		$("#layer").val(widget_array[l_id][6]);
		$("#layer_value").children().html(widget_array[l_id][6]);

		// 9 - autoplay
		var a = false;
		if (widget_array[l_id][9] == "true"){
			a = true;
		}
		$("#autoplay_audio").prop('checked', a);
		
		activateAudio(l_id);

	}
	catch(e){
		log("widget_attr.js", e.lineNumber, e);
	}
}

//removes widget from screen and adjusts data to account for fewer widgets
function deleteWidget(){
	try{
		var l_id = $("#selected").attr("l_id");
		var layer = widget_array[l_id][6];

		// remove from widget array
		widget_array[l_id] = emptyWidg();

		// remove from screen
		$("#selected").remove();

		// set layers to adjust for one fewer widgets
		for (i = 0; i < widget_array.length; ++i){
			if (widget_array[i][6] > layer){
				widget_array[i][6] = parseInt(widget_array[i][6]) - 1;
			}
		}
		// set num layers to 1 fewer
		slide_array[current_slide - 1].widget_count -= 1;

		// set selected to null
		setSelected(null);
	}
	catch(e){
		log("widget_attr.js", e.lineNumber, e);
	}
}

//generate empty widget
function emptyWidg(){
	try{
		return [null,null,null,null,null,null,null,null,null,null];
	}
	catch(e){
		log("widget_attr.js", e.lineNumber, e);
	}
}