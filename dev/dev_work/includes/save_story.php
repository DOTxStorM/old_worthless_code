<?php

include_once 'open_connection.php';
include_once 'story_manager.php';
include_once 'slide_manager.php';
include_once 'tags_manager.php';

$mysqli = open_connection();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
	
	if (checkSubmission()){ // make sure all data elements are set
		$str_id = updateMainData(); // update title/description/tags
		$json_array = json_encode($str_id); //encode str_id to json encoded string
		// catch error
		if ($str_id === 0){
			return; // exit function
		}
		
		if($_POST['save_type'] == "draft"){ //if save as draft button is clicked
		
			/*NEEDS DATABASE updateSlide FUNCTION CALLED HERE THAT TAKES ASSOCIATIVE widget_array*/
			updateMainData();
			echo "SAVE_DRAFT_SUCCESS"; //echo response
		}
		else if($_POST['save_type'] == "finished"){ //if finished button is clicked
			save_draft_id_as_completed($str_id); // complete story
			echo "FINISH_STORY_SUCCESS"; //echo response
		}
	}
	else{
		// Otherwise, bad request. Do nothing
		echo "ERROR not all variables set";
	}
}
else{
	echo "Bad Request to server";
}


function checkSubmission(){
	if (isset($_POST['save_type']) && isset($_POST['story_title']) && isset($_POST['story_desc']) && isset($_POST['story_tags']) && isset($_POST['id']) && isset($_POST['slide'])){
		return true;
	}
	else{	
		if (!isset($_POST['save_type'])){
			echo "save ";
		}
		if (!isset($_POST['story_desc'])){
			echo "desc ";
		}
		if (!isset($_POST['story_tags'])){
			echo "tags ";
		}
		if (!isset($_POST['story_title'])){
			echo "title ";
		}
		if (!isset($_POST['id'])){
			echo "id ";
		}
		if (!isset($_POST['slide'])){
			echo "slide ";
		}
		
		return false;
	}
}
	
function updateMainData(){
	try{
		$title = urldecode($_POST['story_title']);
		$desc = urldecode($_POST['story_desc']);
		$tags = urldecode($_POST['story_tags']);
		
		//update slide information
		$slide_id = ($_POST['slide_id']);
		$slide_bg_color = ($_POST['bg_color']);
		slideUpdateBackgroundColor($slide_id, $slide_bg_color);
		
		//updates widgets in slide
		$slide = urldecode($_POST['slide']); //which just captures widgets...maybe poorly named? meh...it'll do
		updateWidInSlide($slide);
		
		//update story info
		$str_id = $_POST['id'];	
		$good_save = update_story_title($str_id, $title);
		$good_save &= update_story_description($str_id, $desc);
		update_story_date_modified($str_id, date("Y-m-d H:i:s"));
		addStringTag($tags, $str_id);
	}
	catch(Exception $e){
		//echo $e;
		//log($e); // log error
		echo ("ERROR ". $e);
		$str_id = 0;
	}
	return $str_id;
}

?>