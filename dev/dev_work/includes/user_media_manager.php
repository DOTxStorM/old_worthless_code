<?php
	
	function insertUserMedia($p_type, $p_user_id, $p_file_path) {
		$con = open_connection();
		mysqli_query($con,"INSERT INTO user_media (type, user_ref_id, file_path)
		VALUES ('" . $p_type . "','" . $p_user_id . "', '" . $p_file_path ."')");
		$user_media_id = mysqli_insert_id($con);
		mysqli_close($con);
		return $user_media_id;
	}
	
	function getAllUserMedia($p_user_id) {
		$con = open_connection();
		$result = mysqli_query($con,"SELECT * FROM user_media WHERE user_ref_id = '". $p_user_id . "'");
		$all_user_media = array();
		while($row = mysqli_fetch_array($result)) {
			array_push($all_user_media, $row['file_path']);
		}
		mysqli_close($con);
		return $all_user_media;
	}
	
	function getUserMedia($p_user_id) {
		$con = open_connection();
		$result = mysqli_query($con,"SELECT * FROM user_media WHERE user_ref_id = '". $p_user_id . "' AND type = 1");
		$user_media = array();
		while($row = mysqli_fetch_array($result)) {
			array_push($user_media, $row['file_path']);
		}
		mysqli_close($con);
		return $user_media;
	}
	
	function getUserAudio($p_user_id) {
		$con = open_connection();
		$result = mysqli_query($con,"SELECT * FROM user_media WHERE user_ref_id = '". $p_user_id . "' AND type = 3");
		$user_audio = array();
		while($row = mysqli_fetch_array($result)) {
			array_push($user_audio, $row['file_path']);
		}
		mysqli_close($con);
		return $user_audio;
	}
	
	function getUserImages($p_user_id) {
		$con = open_connection();
		$result = mysqli_query($con,"SELECT * FROM user_media WHERE user_ref_id = '". $p_user_id . "' AND type = 0");
		$user_images = array();
		while($row = mysqli_fetch_array($result)) {
			array_push($user_images, $row['file_path']);
		}
		mysqli_close($con);
		return $user_images;
	}
	
	//delete the respective entry in the database
	function deleteUserMedia($p_id) {
		$con = open_connection();
		$result = mysqli_query($con, "DELETE FROM user_media WHERE u_media_id = '" . $p_id . "'");
		mysqli_close($con);
	}
?>
