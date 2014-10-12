<?php 
function get_user_name($p_id){
	$con = open_connection();
	$result = mysqli_query($con,"SELECT user_name FROM user WHERE user_id = '" . $p_id . "'");
	$row = mysqli_fetch_array($result);
	$info = $row[1];
	mysqli_close($con);
	return $info;
}

function get_user_email($p_id){
	$con = open_connection();
	$result = mysqli_query($con,"SELECT user_email FROM user WHERE user_id = '" . $p_id . "'");
	$row = mysqli_fetch_array($result);
	$info = $row[1];
	mysqli_close($con);
	return $info;
}

function get_user_upload_size($p_id){
	$con = open_connection();
	$result = mysqli_query($con,"SELECT upload_size FROM user WHERE user_id = '" . $p_id . "'");
	$row = mysqli_fetch_array($result);
	$info = $row[1];
	mysqli_close($con);
	return $info;
}

function get_user_validation_code($p_id){
	$con = open_connection();
	$result = mysqli_query($con,"SELECT validation_code FROM user WHERE user_id = '" . $p_id . "'");
	$row = mysqli_fetch_array($result);
	$info = $row[1];
	mysqli_close($con);
	return $info;
}

function get_user_role_type($p_id){
	$con = open_connection();
	$result = mysqli_query($con,"SELECT role_type FROM user WHERE user_id = '" . $p_id . "'");
	$row = mysqli_fetch_array($result);
	$info = $row[1];
	mysqli_close($con);
	return $info;
}
?>