<?php

include_once 'open_connection.php';
include_once 'DB-config.php';
include_once 'user_manager.php';

	// Gather the post data
	$q = $_POST['q'];
	$q_arr = explode(';', $q);
	$email = $q_arr[0];
	$code = $q_arr[1];

	//gets user info for key match
	$u_id = get_user_with_email($email);
	$username = get_user_info($u_id, 'user_name');
	$user_salt = get_user_info($u_id, 'salt');
	
	// Use the same salt from the forgot_password.php file
	$salt_code = "PiuwrO1#O0rl@+luH1!froe*l?8oEb!iu)_1Xaspi*(sw(^&.laBr~u3i!c?es-l651";

	// Generate the reset key
	$resetkey = md5($salt_code .$username);

	// Does the new reset key match the old one?
	if ($resetkey == $code)
	{
		$error_msg = '?';
		$new_password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
		if (strlen($new_password) != 128) {
			// The hashed pwd should be 128 characters long
			$error_msg .= 'password_error=-1&';
		}

		if ($error_msg == '?') {
			// Insert the new user into the database
			$password = hash('sha512', $new_password . $user_salt);
			user_update_user_password($u_id, $password);
			header('Location: ../home.php');
		}
		else{
			header('Location: ../error.php'.$error_msg);
		}
	}
	else {
		header('Location: ../error.php');
	}


?>