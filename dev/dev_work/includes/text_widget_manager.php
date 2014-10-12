<?php

include_once 'slide_manager.php';

//insert new text
function insertText ($p_type, $p_slide_ref_id, $p_width, $p_color, $p_x_coordinate, $p_y_coordinate, $p_layer, $p_font_size, $p_font_style, $p_text){
		$con = open_connection();
		mysqli_query($con,"INSERT INTO text(type, slide_ref_id, width, color, x_coordinate, y_coordinate, layer, font_size, font_style, text) 
		VALUES ('". $p_type ."', '". $p_slide_ref_id ."', '". $p_width ."', '". $p_color ."', '". $p_x_coordinate ."', '". $p_y_coordinate ."', 
				'". $p_layer ."', '". $p_font_size ."','". $p_font_style ."', '". $p_text ."')");
		$image_id = mysqli_insert_id($con);
                     
        //increment the number of widgets
        $result = mysqli_query($con, "SELECT * FROM slide WHERE slide_id = '" . $p_slide_ref_id . "'");
        $row = mysqli_fetch_array($result);
        $no_widgets = $row['no_widgets'] + 1;
        slideUpdateNoWidgets($p_slide_ref_id, $no_widgets);
                     
		mysqli_close($con);
		return $image_id;
	}
              
  //delete text
  function deleteText($p_text_id){
    $con = open_connection();
    mysqli_query($con,"DELETE FROM text WHERE text_id = '". $p_text_id ."'");
    mysqli_close($con);
  }
  
  //update text font size
  function updateFontSize($p_text_id, $p_font_size) {
  $con = open_connection();
  mysqli_query($con, "UPDATE text SET font_size = '". $p_font_size ."' WHERE text_id = '". $p_text_id ."'");
  mysqli_close($con);
  }
  
  //update text font style
  function updateFontStyle($p_text_id, $p_font_style) {
  $con = open_connection();
  mysqli_query($con, "UPDATE text SET font_style = '". $p_font_style ."' WHERE text_id = '". $p_text_id ."'");
  mysqli_close($con);
  }
  
  //update text font color
  function updateFontColor($p_text_id, $p_font_color) {
  $con = open_connection();
  mysqli_query($con, "UPDATE text SET color = '". $p_font_color ."' WHERE text_id = '". $p_text_id ."'");
  mysqli_close($con);
  }
  
  //update text font color
  function updateText($p_text_id, $p_text) {
  $con = open_connection();
  mysqli_query($con, "UPDATE text SET text = '". $p_text ."' WHERE text_id = '". $p_text_id ."'");
  mysqli_close($con);
  }
  
  //update size: width as 2nd arg, lenght as 3rd
function updateTextWidth($p_id, $p_width) {
	$con = open_connection();
	mysqli_query($con,"UPDATE text SET width = '". $p_width ."'");
	mysqli_close($con);
}


//update location in parent: X as 2nd arg, Y as 3rd
function updateTextPosition($p_id, $p_x, $p_y) {
	$con = open_connection();
	mysqli_query($con,"UPDATE text SET x_coordinate = '". $p_x ."', y_coordinate = '". $p_y ."' WHERE text_id = '". $p_id ."'");
	mysqli_close($con);
}


//update widget layer (id, layer)
function updateTextLayer($p_id, $p_lay) {
	$con = open_connection();
	mysqli_query($con,"UPDATE text SET layer = '". $p_lay ."' WHERE text_id = '". $p_id ."'");
	mysqli_close($con);
}
  
  
  //query single widget information(id)
  function getTextInfo($p_id) {
  $con = open_connection();
  $result = mysqli_query($con,"SELECT * FROM text WHERE text_id = '" . $p_id . "'");
  $row = mysqli_fetch_array($result);
  mysqli_close($con);
  return $row;
  }
  
  //widget id, width, x, y, layer, widget reference id, font, style, color, text
function updateAllTextFields($p_id, $p_width, $p_x, $p_y, $p_lay, $p_ref_id, $p_font_size, $p_font_style, $p_font_color, $p_text)
{
	$con = open_connection();
	//need modified update size due to dll changes
	updateTextWidth($p_id, $p_width);
	updateTextPosition($p_id, $p_x, $p_y);
	updateTextLayer($p_id, $p_lay);
	updateFontSize($p_id, $p_font_size);
	updateFontStyle($p_id, $p_font_style);
	updateFontColor($p_id, $p_font_color);
	updateText($p_id, $p_text);

	mysqli_close($con);
}

	
	//return an array of widgets(all the attributes) which are text type inside a slide
	function getTextWidgetArray ($p_id) {
		$con = open_connection();
		$text_wid_array = array();
		$result = mysqli_query($con, "SELECT * FROM text WHERE slide_ref_id = '" . $p_id . "'");
		mysqli_close($con);
		while($row = mysqli_fetch_array($result)) {
			$wid_array = array($row['type'], $row['slide_ref_id'], $row['width'], $row['font_size'], $row['x_coordinate'], $row['y_coordinate'], $row['layer'], $row['text'], $row['text_id'], $row['color'], $row['font_style']);
			array_push($text_wid_array, $wid_array);
		}
		return $text_wid_array;
	}
  
  ?>
