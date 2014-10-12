<?php

include_once 'open_connection.php';
include_once 'DB-config.php';
include_once 'user_manager.php';

if (isset($_POST['code'])){
    $code = $_POST['code'];
	$post_arr = explode(';', $code);

	$u_name = $post_arr[0];
	$validation_code = $post_arr[1];
	
	$data_arr = array();
	
    if (validate_user($u_name, $validation_code)){
		array_push($data_arr, 'Your email account has been validated'); 
		array_push($data_arr, 'You can now <a href="http://dev.storyblox.org/">Log In</a> to Storyblox!');
		echo json_encode($data_arr);
	}
    else{
		array_push($data_arr, 'There was a problem'); 
		array_push($data_arr, 'Oops! An unknown error happened');
		echo json_encode($data_arr);
    }
}
else {
		array_push($data_arr, 'There was a problem'); 
		array_push($data_arr, 'Oops! An unknown error happened');
		echo json_encode($data_arr);
}

?>