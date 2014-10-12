<?php

//insert user account information
function insert_user($p_name, $p_pswd, $p_email, $p_valid_code, $p_role_type) {
	$con = open_connection();
	mysqli_query($con,"INSERT INTO user (user_name, user_password, user_email, validation_code, role_type)
	VALUES ('". $p_name ."' , '" .$p_pswd ."' , '" . $p_email . "', '" . $p_valid_code . "', '" . $p_role_type ."')");
	$user_id = mysqli_insert_id($con);
	mysqli_close($con);
	return $user_id;
}

//returns user id, given user name and password
function get_user($p_name, $p_pswd) {
	$con = open_connection();
	$result = mysqli_query($con,"SELECT * FROM user WHERE user_name = '". $p_name ."' AND user_password = '" . $p_pswd . "'");
	$row = mysqli_fetch_array($result);
	$user_id = $row['user_id'];
	mysqli_close($con);
	return $user_id;
}

//get user information
function get_user_info ($p_id, $p_column) {
	$con = open_connection();
	$result = mysqli_query($con,"SELECT * FROM user WHERE user_id = '" . $p_id . "'");
	$row = mysqli_fetch_array($result);
	$info = $row[$p_column];
	mysqli_close($con);
	return $info;
}


//returns user id given user email
function get_user_with_email($p_email) {
	$con = open_connection();
	$result = mysqli_query($con,"SELECT * FROM user WHERE user_email = '". $p_email ."'");
	$row = mysqli_fetch_array($result);
	$user_id = $row['user_id'];
	mysqli_close($con);
	return $user_id;
}

//checks if user name exists
function user_name_exists($p_name) {
	$exists = false;
	$con = open_connection();
	
	$result = mysqli_query($con,"SELECT * FROM user WHERE user_name = '". $p_name ."'");
	
	if(mysqli_num_rows($result) != 0) {
		$exists = true;
	}
	
	mysqli_close($con);
	return $exists;
}

//returns id if  user email exists
function user_email_exists($p_email) {
	$u_id = 0;
	$con = open_connection();
	
	$result = mysqli_query($con,"SELECT * FROM user WHERE user_email = '". $p_email ."'");
	
	if(mysqli_num_rows($result) != 0) {
		$row = mysqli_fetch_array($result);
		$u_id = $row['user_id'];
	}

	return $u_id;
}

//user update for (user_name)
function user_update_user_name($p_id, $p_name) {
	$con = open_connection();
	mysqli_query($con,"UPDATE user SET user_name = '". $p_name ."' WHERE user_id = ". $p_id);
	mysqli_close($con);
}

//user update for (user_password)
function user_update_user_password($p_id, $p_password) {
	$con = open_connection();
	mysqli_query($con,"UPDATE user SET user_password = '".$p_password ."' WHERE user_id = ". $p_id);
	mysqli_close($con);
}

//user update for (user_email)
function user_update_user_email($p_id, $p_email) {
	$con = open_connection();
	mysqli_query($con,"UPDATE user SET user_email = '". $p_email ."' WHERE user_id = ". $p_id);
	mysqli_close($con);
}

//user update for (validation_code)
function update_user_validation_code($p_id, $p_validation_code) {
	$con = open_connection();
	mysqli_query($con,"UPDATE user SET validation_code = ". $p_validation_code ." WHERE user_id = '". $p_id ."'");
	mysqli_close($con);
}

//user update for (role_type)
function update_user_role($p_id, $p_role_type ) {
	$con = open_connection();
	mysqli_query($con,"UPDATE user SET role_type  = ". $p_role_type  ." WHERE user_id = '". $p_id ."'");
	mysqli_close($con);
}

//user update for Changing password given email
function update_user_pass_from_email($p_email, $p_pass) {
	$con = open_connection();
	mysqli_query($con,"UPDATE user SET user_password  = ". $p_pass  ." WHERE user_email = '". $p_email ."'");
	mysqli_close($con);
}

//validates a user
function validate_user($p_name, $p_validation_code) {
	$validated = false;
	
	//get user from DB
	$con = open_connection();
	$result = mysqli_query($con,"SELECT * FROM user WHERE user_name = '" . $p_name . "'");
	mysqli_close($con);
	
	//get user id
	$row = mysqli_fetch_array($result);
	$u_id = $row['user_id'];
	
	//if code checks out, validate user
	if(get_user_info($u_id, 'validation_code') == $p_validation_code) {
		update_user_validation_code($u_id, 0);
		$validated = true;
	}
	return $validated;
}


//Returns all stories matching user
function get_user_stories($p_user_id) {
	$con = open_connection();
	$result = mysqli_query($con,"SELECT * FROM story WHERE creator_id = '" . $p_user_id . "'");
	//$stories = mysqli_fetch_array($result);
	mysqli_close($con);
	return $result;//$stories;
	
	//REED MODIFIED
}

//deletes a user account
function delete_user($p_id) {
	$con = open_connection();
	mysqli_query($con,"DELETE FROM user WHERE user_id = '". $p_id ."'");
	mysqli_close($con);
} 

//encrypt a message with a key
function encrypt ($textToEncrypt) {
	$iv_size = mcrypt_get_iv_size(MCRYPT_CAST_256, MCRYPT_MODE_CBC);
	$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	$encryptionMethod = "AES-256-CBC";
	$secretHash = "25c6c7ff35b9979b151f2136cd13b0ff";
	
	
	$encryptedMsg = openssl_encrypt($textToEncrypt, $encryptionMethod, $secretHash, 0, $iv);
	$data = $iv.$encryptedMsg;
	return $data;
}

//decrypt a message with a key
function decrypt ($textToDecrypt) {
	$iv_size = mcrypt_get_iv_size(MCRYPT_CAST_256 , MCRYPT_MODE_CBC);
	$iv = substr($textToDecrypt, 0, $iv_size);
	$encryptionMethod = "AES-256-CBC";
	$secretHash = "25c6c7ff35b9979b151f2136cd13b0ff";	

	$decryptedMsg = openssl_decrypt(substr($textToDecrypt, $iv_size), $encryptionMethod, $secretHash, 0, $iv);
	return $decryptedMsg;
}


?>
