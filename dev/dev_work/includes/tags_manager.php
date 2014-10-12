<?php

//adds a tag to a story
function addTag($p_str_id, $p_tag) {
	$con = open_connection();
	mysqli_query($con,"INSERT INTO tags (story_ref_id, tag) 
	VALUES ('". $p_str_id ."' , '" . $p_tag ."')");
	mysqli_close($con);
}

//takes in an array of tags and retrieves story ids that go with those tags
function getStoriesWithTag($p_user_id, $p_pg_no, $p_array) {
	$stories_with_tags = array();
	$i = 0;
	while ($i < count($p_array)) {
		$stories_with_tags = array_merge($stories_with_tags, getStoriesWithTagHelper($p_user_id, $p_array[$i]));
		$i++;
	}
	$start_index = ($p_pg_no-1)*10;
	
	return array_slice($stories_with_tags, $start_index, 10);
}

//returns story ids associated with a single tag
function getStoriesWithTagHelper($p_user_id, $p_search_querry) {
	$con = open_connection();
	$result = mysqli_query($con,"SELECT * FROM tags Where tag LIKE '%{$p_search_querry}%'");
		$story_ids = array();
		while($row = mysqli_fetch_array($result)) {
			$story_id = $row['story_ref_id'];
			
			//not flagged or private
			if(!isFlagged($story_id,$p_user_id) && (get_story_attribute($story_id, 'share_setting') == 0)) {
				array_push($story_ids,$story_id);
			}
		}
		return $story_ids;
}
 
//returns an array of tags that correspond to that story id
function getTagsForStory($p_id) {
        $tag_array = array();
    
	$con = open_connection();
	$result = mysqli_query($con, "SELECT * FROM tags WHERE story_ref_id  = $p_id");
	mysqli_close($con);
        
        while ($row = mysqli_fetch_array($result)) {
            array_push($tag_array, $row['tag']);
        }
	return $tag_array;
        
}

//returns size of querry
function tagQuerySize($p_array, $p_user_id) {
	$con = open_connection();
	$stories_with_tags = array();
	$i = 0;
	while ($i < count($p_array)) {
		$stories_with_tags = array_merge($stories_with_tags, getStoriesWithTagHelper($p_user_id, $p_array[$i]));
		$i++;
	}
	
	return sizeof($stories_with_tags);	
}

//take a string of tag and add them into tag table
function addStringTag($p_string, $p_id) {
	$tags = explode(" ", $p_string);
	$arr_length = count($tags);
	for($x = 0; $x < $arr_length; $x++) {
		if($tags[$x] != "the" || $tags[$x] != "an" || $tags[$x] != "at" || $tags[$x] != "on" || $tags[$x] != "a" || $tags[$x] != "during" || $tags[$x] != "in"  || $tags[$x] != "a"  || $tags[$x] != "of" ) {
			addTag($p_id, $tags[$x]);
		}
	}
}

//delete the respective entry in the database
function deleteTag($p_id, $p_tag) {
	$con = open_connection();
	$result = mysqli_query($con, "DELETE FROM tags WHERE story_ref_id  = '$p_id' AND tag = '$p_tag'");
	mysqli_close($con);
}

//returns top 5 tags
function getTopFiveTag() {
    $tag_array = array();
	$con = open_connection();
	$result = mysqli_query($con, "SELECT tag, COUNT(*) AS c FROM tags GROUP BY tag ORDER BY c DESC LIMIT 5");
	mysqli_close($con);
	while ($row = mysqli_fetch_array($result)) {
		array_push($tag_array, $row['tag']);
	}
	return $tag_array; 
}
?>