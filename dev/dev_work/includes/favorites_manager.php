<?php

//add favorite
function add_favorite($p_str_id, $p_user_id, $p_date_fav) {
	$con = open_connection();
		
	//inserts story into favorite table
	 mysqli_query($con, "INSERT INTO favorites (user_ref_id, story_ref_id, date_favorited)
     VALUES ('" . $p_user_id ."' , '" . $p_str_id . "', '" . $p_date_fav . "')");
	
	//increments no_favorites in corresponding story
	$result = mysqli_query($con,"SELECT * FROM story WHERE str_id = '". $p_str_id . "'");
	$row = mysqli_fetch_array($result);
	$no_favorites = $row['no_favorites'] +1;
	update_story_no_favorites($p_str_id, $no_favorites);
	 
	 mysqli_close($con);
}

//remove favorite
function remove_favorite($p_user_id, $p_str_id){
	//decrements no of favorites in corresponding story
	decrement_no_favorites($p_str_id);
	
    $con = open_connection();
	mysqli_query($con,"DELETE FROM favorites WHERE user_ref_id = '". $p_user_id . "' AND story_ref_id = '". $p_str_id . "'");
    mysqli_close($con);
}

//decrements no of favorites of given story
function decrement_no_favorites($p_str_id) {
	$con = open_connection();
	
	$result = mysqli_query($con,"SELECT * FROM story WHERE str_id = '". $p_str_id . "'");
	$row = mysqli_fetch_array($result);
	$no_favorites = $row['no_favorites'] - 1;
	update_story_no_favorites($p_str_id, $no_favorites);
	
    mysqli_close($con);
}

//get all favorite stories with user id
function getFavorites($p_id) {
	$str_array = array();

	$con = open_connection();
	$result = mysqli_query($con,"SELECT * FROM favorites WHERE user_ref_id = '" . $p_id . "'");
	
	while ($row = mysqli_fetch_array($result)) {
		array_push($str_array, getStory($row['story_ref_id']));
	}
	
	mysqli_close($con);
	return $str_array;
}


function getFavoritesArray($p_id) {
	$favStrIdArr = array();
	
	$result = getFavorites($p_id);
	while($row = mysqli_fetch_array($result)) {
		array_push($favStrIdArr, $row['story_ref_id']);
	}
	
	return $favStrIdArr;
}

//looks at the favorites table and returns true if a row exists with both the user and story id and false otherwise
function isStoryFavorite($p_user_id, $p_story_id) {
	$con = open_connection();
	$result = mysqli_query($con, "SELECT fav_id FROM favorites WHERE user_ref_id  = $p_user_id AND story_ref_id = $p_story_id");
	$row_cnt = mysqli_num_rows($result);
	mysqli_close($con);
	if ($row_cnt == 0) {
		return false;
	}
	else {
		return true;
	}
}

?>