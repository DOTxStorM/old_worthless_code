<?php 
/**
 * gets the story title
 * 
 * @method get_story_title
 * 
 * @param {int} story ID
 * @return {string} story title
 * 
 */
function get_story_title($p_str_id) {
	$con = open_connection();
	$result = mysqli_query($con,"SELECT str_title FROM story WHERE str_id = '" . $p_str_id . "'");
	$row = mysqli_fetch_array($result);
	$p_str_id = $row[1];
	mysqli_close($con);
	return $p_str_id;
}

/**
 * gets the description for a story
 * 
 * @method get_story_description
 * 
 * @param {int} story ID
 * @return {string} story id
 */
function get_story_description($p_str_id) {
	$con = open_connection();
	$result = mysqli_query($con,"SELECT str_description FROM story WHERE str_id = '" . $p_str_id . "'");
	$row = mysqli_fetch_array($result);
	$p_str_id = $row[1];
	mysqli_close($con);
	return $p_str_id;
}

/**
 * gets date the story was last modified
 * 
 * @method get_story_last_modified
 * 
 * @param {int} story ID
 * @return {varchar(1024)} last modification
 */
function get_story_last_modified($p_str_id) {
	$con = open_connection();
	$result = mysqli_query($con,"SELECT date_modified FROM story WHERE str_id = '" . $p_str_id . "'");
	$row = mysqli_fetch_array($result);
	$p_str_id = $row[1];
	mysqli_close($con);
	return $p_str_id;
}

/**
 * gets last time story was favorited
 * 
 * @method get_story_last_favorited
 * 
 * @param {int} story ID
 * @return {varchar(1024)} last modification
 */
function get_story_last_favorited($p_str_id) {
	$con = open_connection();
	$result = mysqli_query($con,"SELECT date_favorited FROM story WHERE str_id = '" . $p_str_id . "'");
	$row = mysqli_fetch_array($result);
	$p_str_id = $row[1];
	mysqli_close($con);
	return $p_str_id;
}

/**
 * gets the path for a thumbnail
 * 
 * @method get_story_thumbnail_path
 * 
 * @param {int} story ID
 * @return {varchar(1024)} last modification
 */
function get_story_thumbnail_path($p_str_id) {
	$con = open_connection();
	$result = mysqli_query($con,"SELECT thumbnail_file_path FROM story WHERE str_id = '" . $p_str_id . "'");
	$row = mysqli_fetch_array($result);
	$p_str_id = $row[1];
	mysqli_close($con);
	return $p_str_id;
}

/**
 * gets the share setting for the story
 * @method get_story_share
 * @param {int} story ID
 * @return {int} int corresponds to share setting 
 */
function get_story_share($p_str_id) {
	$con = open_connection();
	$result = mysqli_query($con,"SELECT share_setting FROM story WHERE str_id = '" . $p_str_id . "'");
	$row = mysqli_fetch_array($result);
	$p_str_id = $row[1];
	mysqli_close($con);
	return $p_str_id;
}
/**
 * gets the draft ID for the story
 * @method get_story_draft
 * @param {int} story ID
 * @return {int} draft ID
 */
function get_story_draft($p_str_id) {
	$con = open_connection();
	$result = mysqli_query($con,"SELECT draft_id FROM story WHERE str_id = '" . $p_str_id . "'");
	$row = mysqli_fetch_array($result);
	$p_str_id = $row[1];
	mysqli_close($con);
	return $p_str_id;
}

/**
 * gets number of favorites for the story
 * 
 * @method get_story_favorites
 * @param {int} story ID
 * @return {int} number of favorites
 */
function get_story_favorites($p_str_id) {
	$con = open_connection();
	$result = mysqli_query($con,"SELECT no_favorites FROM story WHERE str_id = '" . $p_str_id . "'");
	$row = mysqli_fetch_array($result);
	$p_str_id = $row[1];
	mysqli_close($con);
	return $p_str_id;
}

/**
 * gets number of slides in a story
 * @method get_story_slides
 * @param {int} story ID
 * @return {int} number of slides
 */
function get_story_slides($p_str_id) {
	$con = open_connection();
	$result = mysqli_query($con,"SELECT no_slides FROM story WHERE str_id = '" . $p_str_id . "'");
	$row = mysqli_fetch_array($result);
	$p_str_id = $row[1];
	mysqli_close($con);
	return $p_str_id;
}

/**
 * get number of times story was flagged
 * @method get_story_flags
 * @param {int} story ID
 * @return {int} number of flags
 */
function get_story_flags($p_str_id) {
	$con = open_connection();
	$result = mysqli_query($con,"SELECT no_of_flags FROM story WHERE str_id = '" . $p_str_id . "'");
	$row = mysqli_fetch_array($result);
	$p_str_id = $row[1];
	mysqli_close($con);
	return $p_str_id;
}

/**
 * gets ID of user that created this story
 * @param {int} story ID
 * @return {int} user ID
 */
function get_story_creator($p_str_id) {
	$con = open_connection();
	$result = mysqli_query($con,"SELECT creator_id FROM story WHERE str_id = '" . $p_str_id . "'");
	$row = mysqli_fetch_array($result);
	$p_str_id = $row[1];
	mysqli_close($con);
	return $p_str_id;
}
?>