<?php 
include_once 'open_connection.php';
include_once 'story_manager.php';
$mysqli = open_connection();

if (isset($_POST['type'])) {
	
	switch ($_POST['type']){
		case 'delete':
			deleter();
			break;
		case 'unfavorite':
			unfavoriter();
			break;
		case 'publish':
			publish();
			break;
		case 'unpublish':
			unpublish();
			break;
		default:
			echo "ERROR";
	}
	
}
else{
	echo "ERROR";
}

function deleter(){
	if (isset($_POST["story_id"])){
		delete_story($_POST["story_id"]);
	}
	else{
		echo "ERROR";
	}
}

function unfavoriter(){
	if (isset($_POST["story_id"]) && isset($_POST['userid'])){
		remove_favorite($_POST['userid'],$_POST["story_id"], 1);
	}
	else{
		echo "ERROR";
	}
}

function publish(){
	if (isset($_POST["story_id"])){
		update_story_share_setting($_POST["story_id"], 1);
	}
	else{
		echo "ERROR";
	}
}

function unpublish(){
	if (isset($_POST["story_id"])){
		update_story_share_setting($_POST["story_id"], 0);
	}
	else{
		echo "ERROR";
	}
}

?>