<?php

/**
 * save draft_id as completed
 * @method save_draft_id_as_completed
 * @param {int} story ID
 * 
 */
function save_draft_id_as_completed($p_str_id) {
	$con = open_connection();
	
	$result = mysqli_query($con,"SELECT * FROM story WHERE str_id = '". $p_str_id."'");
	$row = mysqli_fetch_array($result);
	$original_str_id = $row['draft_id'];
	
	if($original_str_id != -1) {
		
		//deletes all slides and widgets of original story
		deleteAllSlides($original_str_id);
		
		//updates the reference id for all slides
		for ($i = 0; $i < count(get_story_attribute($p_str_id, 'no_slides')); $i++) {
			slideUpdateAllStrRefIds($p_str_id, $original_str_id);
		}
		replaceStory($original_str_id, $p_str_id);
		delete_story($p_str_id);
	}
		
	update_story_draft_id($original_str_id, 0);
	
	mysqli_close($con);
	
}


/**
 * checks if story exists
 * @method story_exists
 * @param {int} story ID
 * @return {boolean} true if it exists,.
 */
function story_exists($p_str_id) {
	$exists = false;
	$con = open_connection();
	
	$result = mysqli_query($con,"SELECT * FROM story WHERE str_id = '". $p_str_id."'");
	
	if(mysqli_num_rows($result) != 0) {
		$exists = true;
	}
	
	mysqli_close($con);
	return $exists;
}

/**
 * checks if draft_id exists
 * @method draft_id_exists
 * @param {int} story ID
 * @return {boolean} true if it exists
 */
function draft_id_exists($p_str_id) {
	$exists = false;
	$con = open_connection();
	
	$result = mysqli_query($con,"SELECT * FROM story WHERE draft_id = '". $p_str_id."'");
	
	if(mysqli_num_rows($result) != 0) {
		$exists = true;
	}
	
	mysqli_close($con);
	return $exists;
}
	
/**
 * inserts a new story
 * @method insert_story
 * @param {string} title
 * @param {string} description
 * @param {varchar(1024)} date last modified
 * @param {varchar(1024)} date last favorited
 * @param {string} thumbnail path
 * @param {int} share setting
 * @param {int} draft ID
 * @param {int} number of favorites
 * @param {int} number of slides
 * @param {int} number of flags
 * @param {int} creator ID
 * @return {boolean} true if inserted
 */
function insert_story($p_title, $p_descrip, $p_date_mod, $p_date_fav, $p_thumbnail_path, $p_share_setting, $p_draft_id, $p_no_favorites, $p_no_slides, $p_no_of_flags, $p_creator_id) {
	$con = open_connection();
	mysqli_query($con,"INSERT INTO story (str_title, str_description, date_modified, date_favorited, thumbnail_file_path, share_setting, draft_id, no_favorites, no_slides, no_of_flags, creator_id)
	VALUES ('". $p_title ."' , '" . $p_descrip ."' , '" . $p_date_mod . "', '" . $p_date_fav . "', '" . $p_thumbnail_path . "', 
	'" . $p_share_setting ."', '" . $p_draft_id . "', '" . $p_no_favorites . "', '" . $p_no_slides . "' , '" . $p_no_of_flags . "' , '" . $p_creator_id ."')");
	$story_id = mysqli_insert_id($con);
	mysqli_close($con);
	return $story_id;
}

// REED's CHANGE the below function header was commented out
//returns story attribute x
//up for deletion. replacement code is now in place
//updated code is in story_manager_updates.php
function get_story_attribute($p_str_id, $p_attr) {
	$con = open_connection();
	$result = mysqli_query($con,"SELECT * FROM story WHERE str_id = '" . $p_str_id . "'");
	$row = mysqli_fetch_array($result);
	$p_str_id = $row[$p_attr];
	mysqli_close($con);
	return $p_str_id;
}


/**
 * get last five modified stories of a user
 * @methodget_stories_last_date_mod
 * @param {int} user ID
 * @return last five. in unsure format
 */
function get_stories_last_date_mod($p_user_id) {
	$con = open_connection();
	$result = mysqli_query($con,"SELECT * FROM story WHERE creator_id = '" . $p_user_id. "' ORDER BY date_modified DESC LIMIT 0, 5");
	mysqli_close($con);
	return $result;
}

/**
 * get last five favorited stories of a user
 * @methodget_stories_last_date_mod
 * @param {int} user ID
 * @return last five. in unsure format
 */
function get_stories_last_date_fav($p_user_id) {
	$con = open_connection();
	$result = mysqli_query($con,"SELECT * FROM favorites WHERE user_ref_id = '" . $p_user_id."' ORDER BY date_favorited DESC LIMIT 0, 5");
	mysqli_close($con);

	return $result;
}

//get story information given id
// we should delete this
//other functions alrdy in place
function getStory($p_str_id) {
	$con = open_connection();
	$result = mysqli_query($con,"SELECT * FROM story WHERE str_id = '" . $p_str_id. "'");
	mysqli_close($con);
	return $result;
}

/**
 * replaces all information of story 1 with story 2's information (except for creator id)
 * @method replaceStory
 * @param {int} original story ID
 * @param {int} story ID you want to replace first story with
 */
function replaceStory($p_story_1, $p_story_2) {
	update_story_title($p_story_1, get_story_attribute($p_story_2, 'str_title'));
	update_story_description($p_story_1, get_story_attribute($p_story_2, 'str_description')); 
	update_story_date_modified($p_story_1, get_story_attribute($p_story_2, 'date_modified'));
	update_story_date_favorited($p_story_1, get_story_attribute($p_story_2, 'date_favorited'));
	update_story_thumbnail_file_path($p_story_1, get_story_attribute($p_story_2, 'thumbnail_file_path'));
	update_story_share_setting($p_story_1, get_story_attribute($p_story_2, 'share_setting'));
	update_story_draft_id($p_story_1, get_story_attribute($p_story_2, 'draft_id'));
	update_story_no_favorites($p_story_1, get_story_attribute($p_story_2, 'no_favorites'));
	update_story_no_slides($p_story_1, get_story_attribute($p_story_2, 'no_slides'));
	update_story_no_of_flags($p_story_1, get_story_attribute($p_story_2, 'no_of_flags'));
}


	/**
	 * updates story title
	 * @method update_story_title
	 * @param {int} story ID
	 * @param {string} story title
	 * @return {boolean} true if worked
	 */
function update_story_title($p_str_id, $p_title) {
	$con = open_connection();
	$result = mysqli_query($con,"UPDATE story SET str_title = '". $p_title ."' WHERE str_id = '". $p_str_id ."'");
	mysqli_close($con);
	return $result;
}

	/**
	 * updates story description
	 * @method update_story_description
	 * @param {int} story ID
	 * @param {string} story description
	 * @return {boolean} true if worked
	 */
function update_story_description($p_str_id, $p_desc) {
	$worked = true;
	$con = open_connection();
	$result = mysqli_query($con,"UPDATE story SET str_description = '". $p_desc ."' WHERE str_id = '". $p_str_id ."'");
	mysqli_close($con);
	return $result;
}

/**
 * updates last modified date of story
 * @method update_story_date_modified
 * @param {int} story ID
 * @param {varchar(1024)} new date modified
 */
function update_story_date_modified($p_str_id, $p_date) {
	$con = open_connection();
	mysqli_query($con,"UPDATE story SET date_modified = '". $p_date ."' WHERE str_id = '". $p_str_id ."'");
	mysqli_close($con);
}

/**
 * updates last favorite date of story
 * @method update_story_date_favorited
 * @param {int} story ID
 * @param {varchar(1024)} new favorite date
 */
function update_story_date_favorited($p_str_id, $p_date) {
	$con = open_connection();
	mysqli_query($con,"UPDATE story SET date_favorited = '". $p_date ."' WHERE str_id = '". $p_str_id ."'");
	mysqli_close($con);
}

/**
 * updates story thumbnail path
 * @method update_story_thumbnail_file_path
 * @param {int} story ID
 * @param {varchar(1024)} new thumbnail path
 */
function update_story_thumbnail_file_path($p_str_id, $p_tfp) {
	$con = open_connection();
	mysqli_query($con,"UPDATE story SET thumbnail_file_path = '". $p_tfp ."' WHERE str_id = '". $p_str_id ."'");
	mysqli_close($con);
}

/**
 * updates story share setting
 * @method update_story_share_setting
 * @param {int} story ID
 * @param {int} share setting
 */
function update_story_share_setting($p_str_id, $p_share) {
	$con = open_connection();
	mysqli_query($con,"UPDATE story SET share_setting = '". $p_share ."' WHERE str_id = '". $p_str_id ."'");
	mysqli_close($con);
}

/**
 * updates story draft ID
 * @method update_story_draft_id
 * @param {int} story ID
 * @param {int} draft ID
 */
function update_story_draft_id($p_str_id, $p_draft_id) {
	$con = open_connection();
	mysqli_query($con,"UPDATE story SET draft_id = '". $p_draft_id ."' WHERE str_id = '". $p_str_id ."'");
	mysqli_close($con);
}

/**
 * updates amount of slides in story
 * @method update_story_no_slides
 * @param {int} story ID
 * @param {int} number of slides
 */
function update_story_no_slides($p_str_id, $p_no_slides) {
	$con = open_connection();
	mysqli_query($con,"UPDATE story SET no_slides = '". $p_no_slides ."' WHERE str_id = '". $p_str_id ."'");	
	mysqli_close($con);
}


/**
 * updates amount of favorites in story
 * @method update_story_no_favorites
 * @param {int} story ID
 * @param {int} number of favorites
 */
function update_story_no_favorites($p_str_id, $p_favs) {
	$con = open_connection();
	mysqli_query($con,"UPDATE story SET no_favorites = '". $p_favs ."' WHERE str_id = '". $p_str_id ."'");	
	mysqli_close($con);
}
                 
/**
 * updates amount of flags in story
 * @method update_story_no_of_flags
 * @param {int} story ID
 * @param {int} number of flags
 */
function update_story_no_of_flags($p_str_id, $p_no_of_flags) {
    $con = open_connection();
    mysqli_query($con,"UPDATE story SET no_of_flags = '". $p_no_of_flags . "' WHERE str_id = '" . $p_str_id . "'");
    mysqli_close($con);
}

/**
 * deletes a story
 * @method delete_story
 * @param {int} story ID
 */
function delete_story($p_id) {
	$con = open_connection();
	mysqli_query($con,"DELETE FROM story WHERE str_id = '". $p_id ."'");
	mysqli_close($con);
}

/**
 * get all stories with user ID
 * @method getAllStories
 * @param {int} user ID
 * @return {array} array of stories created by user
 */
function getAllStories($p_user_id)	{
		$con = open_connection();
		$result = mysqli_query($con, "SELECT * FROM story WHERE creator_id = '" . $p_user_id . "'");
		$rows = array();
		while($r = mysqli_fetch_assoc($result)) {
			$rows[] = $r;
		}
		mysqli_close($con);

	echo json_encode($rows);

}

//getSuggestedStories

function getSuggestedStories()	{
		$con = open_connection();
		$result = mysqli_query($con, "SELECT * FROM story ORDER BY no_favorites DESC LIMIT 0, 5");
		mysqli_close($con);
		return $result;

}


/**
 * load all things of a story
 * @method loadStory
 * @param {int} story ID
 * @return {array} story info
 */
function loadStory($p_str_id) {

	//array of slide objects
	$slide_arr = array();
	
	//query all slides of story
	$slides = getSlidesForStory($p_str_id);
	
	//gets all widgets for each slide
	while ($slide = mysqli_fetch_assoc($slides)) {
		array_push($slide_arr, array_merge($slide, getAllWidgets($slide['slide_id'])));
	}
	
	return json_encode($slide_arr);
}
		
/**
 * check if the draft exists, if yes, return the str_id of the draft. If not, insert a copy of the original story and return the str_id of the new draft
 *@method getDraftId
 * @param unknown $p_id
 * @return {int} draft ID
 */
function getDraftId ($p_id) {
	$draft_id;
	$con = open_connection();
	$query = mysqli_query($con,"SELECT str_id FROM story WHERE draft_id = '". $p_id."'");
	if (mysqli_num_rows($query) != 0) {
		$draft_id = mysqli_fetch_array($query)['str_id'];
	}
	else {
		$query = mysqli_query($con, "SELECT * FROM story WHERE str_id  = $p_id");
		$row = mysqli_fetch_array($query);
		//make a copy of original story as draft
		$draft_id = insert_story($row['str_title'], $row['str_description'], $row['date_modified'], $row['date_favorited'], $row['thumbnail_file_path'], $row['share_setting'], $p_id, $row['no_favorites'], $row['no_slides'],  $row['no_of_flags'], $row['creator_id']);
		//duplicate all the slides
		$query = mysqli_query($con, "SELECT * FROM slide WHERE story_ref_id = $p_id");
		while($row = mysqli_fetch_array($query)) {
			mysqli_query($con,"INSERT INTO slide (position, story_ref_id, no_widgets, thumbnail_file_path, background_color)
				VALUES ('". $row['position'] ."' , '" . $draft_id ."' , '" . $row['no_widgets'] ."' , '" . $row['thumbnail_file_path'] ."' , '". $row['background_color']."')");
			$slide_ref_id = mysqli_insert_id($con);
			
			//duplicate media
			$media_query = mysqli_query($con, "SELECT * FROM media_files WHERE slide_ref_id = ". $row['slide_id']);
			while($media_row = mysqli_fetch_array($media_query)) {
				mysqli_query($con,"INSERT INTO media_files (type, slide_ref_id, width, extra_attr, x_coordinate, y_coordinate, layer, file_path, autoplay)
					VALUES ('".$media_row['type']."','".$slide_ref_id."','".$media_row['width']."','" .$media_row['extra_attr']."','".$media_row['x_coordinate']."','".$media_row['y_coordinate']."','".$media_row['layer']."','".$media_row['file_path']."','".$media_row['autoplay']."')");
			}
			
			//duplicate image
			$image_query = mysqli_query($con, "SELECT * FROM image_files WHERE slide_ref_id = ". $row['slide_id']);
			while($image_row = mysqli_fetch_array($image_query)) {
				mysqli_query($con,"INSERT INTO image_files (type, slide_ref_id, width, height, x_coordinate, y_coordinate, layer, file_path, border)
					VALUES ('".$image_row['type']."','".$slide_ref_id."','".$image_row['width']."','" .$image_row['height']."','".$image_row['x_coordinate']."','".$image_row['y_coordinate']."','".$image_row['layer']."','".$image_row['file_path']."','".$image_row['border']."')");
			}
			
			//duplicate text
			$text_query = mysqli_query($con, "SELECT * FROM text WHERE slide_ref_id = ". $row['slide_id']);
			while($text_row = mysqli_fetch_array($text_query)) {
				mysqli_query($con,"INSERT INTO text (type, slide_ref_id, width, color, x_coordinate, y_coordinate, layer, font_size, font_style, text)
					VALUES ('".$text_row['type']."','".$slide_ref_id."','".$text_row['width']."','" .$text_row['color']."','".$text_row['x_coordinate']."','".$text_row['y_coordinate']."','".$text_row['layer']."','".$text_row['font_size']."','".$text_row['font_style']."','".$text_row['text']."')");
			}
		}
	}
	mysqli_close($con);
	return $draft_id;
}
?>