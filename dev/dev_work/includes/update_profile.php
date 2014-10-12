<?php 
// from POST:
// old password = password
// new password = password_new

include_once 'open_connection.php';
include_once 'DB-config.php';
include_once 'user_manager.php';

if (isset($_POST['update'])) {

	$user_id = $_POST['user_id'];

	$psswd = get_user_info($user_id, 'user_password');
	$salt = get_user_info($user_id, 'salt');
	

	$UserPassword = hash('sha512', get_password() . $salt);	
	
	if ($psswd != $UserPassword){
		//login fail
		// bad login info
		$_GET['login_error'] = 0;
		return false;
	}
	
	switch($_POST['update']){
		case 'password':
			update_password($user_id, $salt);
			break;
		case 'email':
			update_email($user_id);
			break;
		case 'username':
			update_username($user_id);
			break;
		case 'delete':
			delete_user($user_id);
			header('Location: ../home.php');
			break;
		default:
			// submission unknown
			header('Location: ../error.php?error=update_profile_unknown');
	}
	echo 'success';
}
else {
	echo 'update not set';
}

function get_password(){
	$error_msg = '?';
	$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
	if (strlen($password) != 128) {
		// The hashed pwd should be 128 characters long
		$error_msg .= 'password_error=-1&';
	}
	return $password;
}

function update_password($user_id, $salt){
	$error_msg = '?';
	$new_password = filter_input(INPUT_POST, 'password_new', FILTER_SANITIZE_STRING);
	if (strlen($new_password) != 128) {
		// The hashed pwd should be 128 characters long
		$error_msg .= 'password_error=-1&';
	}

	if ($error_msg == '?') {
		// Insert the new user into the database
		$password = hash('sha512', $new_password . $salt);
		user_update_user_password($user_id, $password);
		header('Location: ../home.php');
	}
	else{
		header('Location: ../profile.php'.$error_msg);
	}
}

function update_email($user_id){
	$error_msg = '?';
	$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
	if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 200) {
		// Not a valid email
		$_GET['email_error'] = 0;
		$error_msg .= 'email_error=0&eTried='.$email."&";
	}

	if (user_email_exists($email)) {
		// A user with this email address already exists
		$_GET['email_error'] = 1;
		$error_msg .= 'email_error=1&';
	}

	// If there aren't any errors
	if ($error_msg == '?') {
		// Insert the new user into the database
		user_update_user_email($user_id, $email);
		header('Location: ../home.php');
	}
	else{
		header('Location: ../profile.php'.$error_msg);
	}
}

function update_username($user_id){
	$error_msg = '?';
	$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
	$password = get_password();
	// Username validity and password validity
	// confirm that username is 20 char or less
	if (!preg_match('/^[a-zA-Z0-9_-]{3,20}$/', $username)){
		$error_msg .= $username.'username_error=12&';
	}

	if (user_name_exists($username)) {
		// A user with this email address already exists
		$_GET['username_error'] = 1;
		$error_msg .= 'username_error=1&';
	}	
	// If there aren't any errors
	if ($error_msg == '?') {
		// Insert the new user into the database
		user_update_user_name($user_id, $username);
		header('Location: ../home.php');
	}
	else{
		header('Location: ../profile.php'.$error_msg);
	}
	return false;
}
?>