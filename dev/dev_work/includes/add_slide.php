<?php
include_once "open_connection.php";
include_once "user_manager.php";
include_once "story_manager.php";
include_once "slide_manager.php";
$mysqli = open_connection();


//function insertSlide($p_position, $p_story_ref_id, $p_no_widgets, $p_thumbnail_file_path) {



if($_SERVER['REQUEST_METHOD'] === 'POST'){
	
	if (checkSubmission()){ // make sure all data elements are set
		
		
		// catch error to ensure all things were in fact properly set 
		$str_id = updateMainData(); // make sure everything posted property and set it to variables
		if ($str_id === 0){ //this will be set to 0 if updateMainData has an error
			return; // exit function
		}
		
		//updateMainData();

		//declare variables...again because apparently this function cannot read functions defined in updateMainData()
		$position = urldecode($_POST['position']); //currently not getting the actual slideNo
		$widgets = $_POST['slide_widgets'];
		$thumbnail_path = urldecode($_POST['thumbnail_path']);
		$background = urldecode($_POST['background_color']);
		$str_id = $_GET['id'];	
		
		//INSERT THE SLIDE!!
		//and also assign it to a variable so slide_id which is returned is stored 
		$slide_id_from_server = insertSlide($position, $str_id, $widgets, $thumbnail_path, $background);
		$encoded_slide_id = json_encode($slide_id_from_server);

		//insertSlide(urldecode($_POST['position']), $str_id, $_POST['slide_widgets'], urldecode($_POST['thumbnail_path']), urldecode($_POST['background_color']));
		//echo 'SUCCESS';
		
		//capture the newly created slide ID
		//$slideInfoArray = getSlidesForStory($str_id);
		//echo $slideInfoArray;
		
		//insertSlide returns and int which is the assigned slide_id
		//$slide_id_from_server = insertSlide($position, $str_id, $widgets, $thumbnail_path, $background);
		echo ($slide_id_from_server);
		
	}
	
	else{
	// Otherwise, bad request. Do nothing
	echo 'CANNOT_CHECK';
	}
}
else
{
	echo 'BAD_REQUEST';
}


function checkSubmission(){
	//return true; //epic bug this completely skips all set checking below and thus currently none of mine is posting
	if (isset($_POST['position']) && isset($_GET['id']) && isset($_POST['slide_widgets']) && isset($_POST['thumbnail_path']) && isset($_POST['background_color'])){
		return true;
	}
	else{
		echo 'NOT_SET';
		return false;
	}
}

function updateMainData(){
	try{
		$position = urldecode($_POST['position']); //currently not getting the actual slideNo
		$widgets = $_POST['slide_widgets'];
		$thumbnail_path = urldecode($_POST['thumbnail_path']);
		$background = urldecode($_POST['background_color']);
		$str_id = $_GET['id'];	
	}
	catch(Exception $e){
		//echo $e;
		//log($e); // log error
		echo "ERROR";
		$str_id = 0;
	}
	return $str_id;
}


?>


