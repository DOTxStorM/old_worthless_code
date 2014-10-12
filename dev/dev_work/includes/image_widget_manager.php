<?php
	include_once 'slide_manager.php';
	
	function insertImage($p_type, $p_slide_ref_id, $p_width, $p_height, $p_x_coordinate, $p_y_coordinate, $p_layer, $p_file_path, $p_border){
		$con = open_connection();
		mysqli_query($con,"INSERT INTO image_files(type, slide_ref_id, width, height, x_coordinate, y_coordinate, layer, file_path, border) 
		VALUES ('". $p_type ."', '". $p_slide_ref_id ."', '". $p_width ."', '". $p_height ."', '". $p_x_coordinate ."', '". $p_y_coordinate ."', 
				'". $p_layer ."', '". $p_file_path ."','". $p_border ."')");

	$image_id = mysqli_insert_id($con);             
        //increment the number of widgets
        $result = mysqli_query($con, "SELECT * FROM slide WHERE slide_id = '" . $p_slide_ref_id . "'");
        $row = mysqli_fetch_array($result);
        $no_widgets = $row['no_widgets'] + 1;
        slideUpdateNoWidgets($p_slide_ref_id, $no_widgets);
	mysqli_close($con);
	return $image_id;
	}
	
	//update image source
	function updateImageFilePath ($p_id, $p_file_path){
		$con = open_connection();
		mysqli_query($con,"UPDATE image_files SET file_path = '". $p_file_path ."' WHERE image_id = $p_id");
		mysqli_close($con);
	}
	
	//update size: width as 2nd arg, lenght as 3rd
function updateImageSize($p_id, $p_width, $p_height) {
	$con = open_connection();
	mysqli_query($con,"UPDATE image_files SET width = '". $p_width ."', height = '". $p_height ."' WHERE image_id = '". $p_id ."'");
	mysqli_close($con);
}


//update location in parent: X as 2nd arg, Y as 3rd
function updateImagePosition($p_id, $p_x, $p_y) {
	$con = open_connection();
	mysqli_query($con,"UPDATE image_files SET x_coordinate = '". $p_x ."', y_coordinate = '". $p_y ."' WHERE image_id = '". $p_id ."'");
	mysqli_close($con);
}


//update widget layer (id, layer)
function updateImageLayer($p_id, $p_lay) {
	$con = open_connection();
	mysqli_query($con,"UPDATE image_files SET layer = '". $p_lay ."' WHERE image_id = '". $p_id ."'");
	mysqli_close($con);
}
	
	
	//delete image
	function deleteImage ($p_id){
		$con = open_connection();
		mysqli_query($con, "DELETE FROM image_files WHERE image_id = $p_id");
		mysqli_close($con);
	}
	
	//get image info (id, column name)
	function getImageInfo ($p_id, $p_column_name) {
		$con = open_connection();
		$query = mysqli_query($con, "SELECT $p_column_name FROM image_files WHERE image_id  = $p_id");
		$result = mysqli_result($query, 0);
		mysqli_close($con);
		return $result;
	}
	
	
	//widget id, width, length, x, y, layer, widget reference id, file path
	function updateAllImageFields($p_id, $p_width, $p_length, $p_x, $p_y, $p_lay, $p_ref_id, $p_file_path, $p_border)
	{
		$con = open_connection();
		//need modified update size due to dll changes
		updateImageSize($p_id, $p_width, $p_length);
		updateImagePosition($p_id, $p_x, $p_y);
		updateImageLayer($p_id, $p_lay);
		
		updateImageFilePath($p_id, $p_file_path);
		//need function for border update
		mysqli_close($con);
	}
	
		
	//return an array of widgets(all the attributes) which are image type inside a slide
	function getImageWidgetArray ($p_id) {
		$con = open_connection();
		$image_wid_array = array();
		$result = mysqli_query($con, "SELECT * FROM image_files WHERE slide_ref_id = '" . $p_id . "'");
		mysqli_close($con);
		while($row = mysqli_fetch_array($result)) {
			$wid_array = array($row['type'], $row['slide_ref_id'], $row['width'], $row['height'], $row['x_coordinate'], $row['y_coordinate'], $row['layer'], $row['file_path'], $row['image_id'], $row['border']);
			array_push($image_wid_array, $wid_array);
		}
	    return $image_wid_array;
	}
	
?>
