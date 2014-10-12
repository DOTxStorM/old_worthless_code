<?php

include_once 'slide_manager.php';

//insert media
function insertMedia ($p_type, $p_slide_ref_id, $p_width, $p_extra_attr, $p_x_coordinate, $p_y_coordinate, $p_layer, $p_file_path, $p_auto_play){
		$con = open_connection();
		mysqli_query($con,"INSERT INTO media_files(type, slide_ref_id, width, extra_attr, x_coordinate, y_coordinate, layer, file_path, autoplay) 
		VALUES ('". $p_type ."', '". $p_slide_ref_id ."', '". $p_width ."', '". $p_extra_attr ."', '". $p_x_coordinate ."', '". $p_y_coordinate ."', 
				'". $p_layer ."', '". $p_file_path ."','". $p_auto_play ."')");
		$media_id = mysqli_insert_id($con);
                     
        //increment the number of widgets
        $result = mysqli_query($con, "SELECT * FROM slide WHERE slide_id = '" . $p_slide_ref_id . "'");
        $row = mysqli_fetch_array($result);
        $no_widgets = $row['no_widgets'] + 1;
        slideUpdateNoWidgets($p_slide_ref_id, $no_widgets);
                     
		mysqli_close($con);
		return $media_id;
	}

//update autoplay boolean
function updateMediaAutoPlay ($p_id, $p_auto_play){
	$con = open_connection();
	mysqli_query($con,"UPDATE media_files SET autoplay = $p_auto_play WHERE media_id = $p_id");
	mysqli_close($con);
}

//update thumbnail varchar
function updateMediaThumbnailFilePath ($p_id, $p_thumbnail_file_path){
	$con = open_connection();
	mysqli_query($con,"UPDATE media_files SET thumbnail_file_path = $p_thumbnail_file_path WHERE media_id = $p_id");
	mysqli_close($con);
}

//update media source
function updateMediaFilePath ($p_id, $p_file_path){
	$con = open_connection();
	mysqli_query($con,"UPDATE media_files SET file_path = '". $p_file_path ."' WHERE media_id = $p_id");
	mysqli_close($con);
}

//update size: width as 2nd arg, lenght as 3rd
function updateMediaSize($p_id, $p_width, $p_extra_attr) {
	$con = open_connection();
	mysqli_query($con,"UPDATE media_files SET width = '". $p_width ."', extra_attr = '". $p_extra_attr ."' WHERE media_id = '". $p_id ."'");
	mysqli_close($con);
}


//update location in parent: X as 2nd arg, Y as 3rd
function updateMediaPosition($p_id, $p_x, $p_y) {
	$con = open_connection();
	mysqli_query($con,"UPDATE media_files SET x_coordinate = '". $p_x ."', y_coordinate = '". $p_y ."' WHERE media_id = '". $p_id ."'");
	mysqli_close($con);
}


//update widget layer (id, layer)
function updateMediaLayer($p_id, $p_lay) {
	$con = open_connection();
	mysqli_query($con,"UPDATE media_files SET layer = '". $p_lay ."' WHERE media_id = '". $p_id ."'");
	mysqli_close($con);
}


//get media info (id, column name)
function getMediaInfo ($p_id, $p_column_name) {
	$con = open_connection();
	$query = mysqli_query($con, "SELECT $p_column_name FROM media_files WHERE media_id  = $p_id");
	$result = mysqli_result($query, 0);
	mysqli_close($con);
	return $result;
}

//delete media
function deleteMedia ($p_id){
	$con = open_connection();
	mysqli_query($con, "DELETE FROM media_files WHERE media_id = $p_id");
	mysqli_close($con);
}

//widget id, width, length, x, y, layer, widget reference id, autoplay, thumbnail file path, file path 
function updateAllMediaFields($p_id, $p_width, $p_length, $p_x, $p_y, $p_lay, $p_ref_id, $p_file_path,  $p_auto_play)
{
	$con = open_connection();
	updateMediaSize($p_id, $p_width, $p_length);
	updateMediaPosition($p_id, $p_x, $p_y);
	updateMediaLayer($p_id, $p_lay);
	
	updateMediaAutoPlay($p_id, $p_auto_play);
	updateMediaFilePath($p_id, $p_file_path);
	mysqli_close($con);
}

	//return an array of widgets(all the attributes) which are media type inside a slide
	function getMediaWidgetArray ($p_id) {
		$con = open_connection();
		$media_wid_array = array();
		$result = mysqli_query($con, "SELECT * FROM media_files WHERE slide_ref_id = '" . $p_id . "'");
		mysqli_close($con);
		while($row = mysqli_fetch_array($result)) {
			$wid_array = array($row['type'], $row['slide_ref_id'], $row['width'], $row['extra_attr'], $row['x_coordinate'], $row['y_coordinate'], $row['layer'], $row['file_path'], $row['media_id'], $row['autoplay']);
			array_push($media_wid_array, $wid_array);
		}		
		return $media_wid_array;	
	}

?>
