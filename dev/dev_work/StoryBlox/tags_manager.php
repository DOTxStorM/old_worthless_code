<?php

//adds a tag to a story
function add_tag($p_str_id, $p_tag) {
	$con = open_connection();
	mysqli_query($con,"INSERT INTO tags (story_ref_id, tag) 
	VALUES ('". $p_str_id ."' , '" . $p_tag ."')");
	mysqli_close($con);
}

//takes in an array of tags and retrieves story ids that go with those tags
function get_stories_with_tag($p_pg_no, $p_array) {
	$stories_with_tags = array();
	$i = 0;
	while ($i < count($p_array)) {
		$stories_with_tags = array_merge($stories_with_tags, get_stories_with_tag_helper($p_array[$i]));
		$i++;
	}
	$start_index = ($p_pg_no-1)*10;
	$end_index = sizeof($stories_with_tags)- ($start_index+10);
	
	return array_slice($stories_with_tags, $start_index, -$end_index);
}

//returns story ids associated with a single tag
function get_stories_with_tag_helper($p_search_querry) {
	$con = open_connection();
	$result = mysqli_query($con,"SELECT * FROM tags Where tag LIKE '%{$p_search_querry}%'");
	$story_ids = array();
	while($row = mysqli_fetch_array($result)) {
		array_push($story_ids, $row['story_ref_id']);
	}
	return $story_ids;
}
 

?>