<?php

include_once 'text_widget_manager.php';
include_once 'media_widget_manager.php';
include_once 'image_widget_manager.php';


//insert slide (postition, story-ref, no. of widgets)
function insertSlide($p_position, $p_story_ref_id, $p_no_widgets, $p_thumbnail_file_path, $p_background_color) {
	$con = open_connection();
	mysqli_query($con,"INSERT INTO slide (position, story_ref_id, no_widgets, thumbnail_file_path, background_color)
		VALUES ('". $p_position ."' , '" . $p_story_ref_id ."' , '" . $p_no_widgets ."' , '" . $p_thumbnail_file_path . "', '" . $p_background_color . "')");
	$slide_id = mysqli_insert_id($con);
	//updates no of slides in stories
	$no_slides = get_story_attribute($p_story_ref_id, 'no_slides');
	update_story_no_slides($p_story_ref_id, $no_slides+1);
	mysqli_close($con);
	return $slide_id;
}

//delete slide(slide id)
function deleteSlide($p_slide_id) {
	$con = open_connection();
	//All of this must be under open connection line in deleteSlide method
	$query = mysqli_query($con, "SELECT story_ref_id FROM slide WHERE slide_id  = $p_slide_id");
	$result = mysqli_result($query, 0);
	//The 2nd part of the AND is for negative check just in case
	mysqli_query($con,"UPDATE story SET no_slides = no_slides - 1 WHERE str_id = $result AND no_slides > 0");
	mysqli_query($con,"DELETE FROM slide WHERE slide_id = '". $p_slide_id ."'");
	mysqli_close($con);
}

//deletes all slides given a story ref id
function deleteAllSlides($p_str_id) {
	$con = open_connection();
	mysqli_query($con,"DELETE FROM slide WHERE story_ref_id = $p_str_id");
	mysqli_close($con);
}

//updates the story ref id of all slides with a given story ref id
function slideUpdateAllStrRefIds($p_str_id, $original_id) {
	$con = open_connection();
	$query = mysqli_query($con, "SELECT * FROM slide WHERE story_ref_id  = $p_str_id");
	mysqli_close($con);

	while($row = mysqli_fetch_array($query)) {
		slideUpdateStrRefId($row['slide_id'], $original_id);
	}
}

//update slide story ref id (id, story ref id)
function slideUpdateStrRefId($p_id, $p_str_id) {
	$con = open_connection();
	mysqli_query($con,"UPDATE slide SET story_ref_id = '". $p_str_id ."' WHERE slide_id = '". $p_id ."'");
	mysqli_close($con);
}

//update slide position (id, position)
function slideUpdatePosition($p_id, $p_pos) {
	$con = open_connection();
	mysqli_query($con,"UPDATE slide SET position = '". $p_pos ."' WHERE slide_id = '". $p_id ."'");
	mysqli_close($con);
}

//update number of widgets (id, no. of widgets)
function slideUpdateNoWidgets($p_slide_id, $p_no_widgets) {
	$con = open_connection();
	mysqli_query($con,"UPDATE slide SET no_widgets = '". $p_no_widgets ."' WHERE slide_id = '". $p_slide_id ."'");
	mysqli_close($con);
}

//update thumbnail file path (id, file path)
function slideUpdateThumbnailPath($p_id, $p_thumbnail_file_path) {
	$con = open_connection();
	mysqli_query($con,"UPDATE slide SET thumbnail_file_path = '" . $p_thumbnail_file_path . "' WHERE slide_id = '" . $p_id . "'");
	mysqli_close($con);
}

//update background color (id, background color)
function slideUpdateBackgroundColor($p_id, $p_background_color) {
	$con = open_connection();
	mysqli_query($con,"UPDATE slide SET background_color = '" . $p_background_color . "' WHERE slide_id = '" . $p_id . "'");
	mysqli_close($con);
}

//get the information about a slide
function getSlideInfo ($p_id, $p_column_name) {
	$con = open_connection();
	$query = mysqli_query($con, "SELECT $p_column_name FROM slide WHERE slide_id  = $p_id");
	$result = mysqli_result($query, 0);
	mysqli_close($con);
	return $result;
}

//get array of slides in their right order (story id) {
function getSlidesForStory($p_id) {
	$con = open_connection();
	$query =  mysqli_query($con,"SELECT * FROM slide  WHERE story_ref_id  = $p_id ORDER BY position ASC");
	mysqli_close($con);
	return $query;
}

	
//returns array of all widgets, text, media, and image of a slide
	function getAllWidgets($p_slide_id) {
		$wid_array = array();		//widget array
		
		$con = open_connection();
		
		$media_wid = getMediaWidgetArray($p_slide_id);
		$text_wid =  getTextWidgetArray($p_slide_id);
		$image_wid = getImageWidgetArray($p_slide_id);
		
		array_push($wid_array, array_merge($media_wid, $text_wid, $image_wid));
		
		return $wid_array;
	}


function updateWidInSlide($json) {
	$wid_array = json_decode ($json);
	//updates all widgets in slide
	for ($i = 0; $i < count($wid_array); $i++) {
		$type = $wid_array[$i][0];
		//checks type of widget and calls appropriate widget function
		switch($type) {
		case 0:
			updateAllImageFields($wid_array[$i][8], $wid_array[$i][2], $wid_array[$i][3], $wid_array[$i][4], $wid_array[$i][5],
								$wid_array[$i][6], $wid_array[$i][1], $wid_array[$i][7], $wid_array[$i][9]);
		case 1:
		case 2:
		case 3:
			updateAllMediaFields($wid_array[$i][8], $wid_array[$i][2], $wid_array[$i][3], $wid_array[$i][4], $wid_array[$i][5],
								$wid_array[$i][6], $wid_array[$i][1], $wid_array[$i][7], $wid_array[$i][9]);
		case 4:
			updateAllTextFields($wid_array[$i][8], $wid_array[$i][2], $wid_array[$i][4], $wid_array[$i][5],
								$wid_array[$i][6], $wid_array[$i][1], $wid_array[$i][3], $wid_array[$i][9], $wid_array[$i][9], $wid_array[$i][7]);
		}
	}
}



?>
