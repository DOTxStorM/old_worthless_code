<?php

include_once 'DB-config.php';
include_once 'user_manager.php';

function sec_session_start() { //call whenever you want secure php session
    $session_name = 'initiateSession';
    $secure = SECURE;
    $httponly = true;

    if (ini_set('session.use_only_cookies', 1) == false) {
        //cannot connect;
        //exit();
    }
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params(
            $cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly
    );

    session_name($session_name);
    session_start();   //start php session
    session_regenerate_id(); //regerneate session, delete old session
}

function login($username_email, $UserPassword, $mysqli) {
    //trys to get UID,User_Password from table Users where email matches
    if ($stmt = $mysqli->prepare("SELECT user_id, user_name, user_password, salt, validation_code FROM user WHERE user_email = ? LIMIT 1")) {
        $stmt->bind_param('s', $username_email);
        $stmt->execute();
        $stmt->store_result();

        $stmt->bind_result($userID, $userName, $password, $salt, $validation);
        $stmt->fetch();
    } else {
        // unknown error
        $_GET['login_error'] = 0;

        return false;
    }

    // set error catcher
    $bad_login = true;

    if ($stmt->num_rows == 1) {
        // We found the user
        $bad_login = false;
    } else {
        //if couldn't find user, search by username

        if ($stmt = $mysqli->prepare("SELECT user_id, user_name, user_password, salt, validation_code FROM user WHERE user_name = ? LIMIT 1")) {
            $stmt->bind_param('s', $username_email);
            $stmt->execute();
            $stmt->store_result();

            $stmt->bind_result($userID, $userName, $password, $salt, $validation);
            $stmt->fetch();

            if ($stmt->num_rows == 1) {
                // We found the user
                $bad_login = false;
            }
        } else {
            // unknown error
            $_GET['login_error'] = 0;

            return false;
        }
    }

    if ($bad_login) {
        //no user exists
        $_GET['login_error'] = 0;
        return false;
    }

    $UserPassword = hash('sha512', $UserPassword . $salt);

    if ($validation == !0) {
        // User not validated
        $_GET['login_error'] = 1;
        return false;
    }
    
    if ((is_brute_force($userID, $mysqli))) { 
    	// 3 failed login attempts have occured, the user must wait 2 hours
    	$_GET['login_error'] = 2;
    	return false;
    }
    
    if ($password == $UserPassword) {
        //password matches
        //do something for login success
        $user_browser = $_SERVER['HTTP_USER_AGENT'];

        $user_id = $userID;
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $userName;
        $_SESSION['login_string'] = hash('sha512', $password . $user_browser);

        return true;
    } else {
        //login fail
        // bad login info

		//updates failed login attempts
		update_login_attempt($userID,$mysqli);
		
        $_GET['login_error'] = 0;

        return false;
    }
}

function is_brute_force($user_id,$mysqli){

	$timeStamp = time();

	//value is set in seconds
	$loginAttempts = $timeStamp - (60*60*2); 
	
	//get login attempts from the last 2 hours
	if($stmt = $mysqli->prepare("SELECT time FROM login_attempt WHERE user_id = ? AND time > '$loginAttempts'")) {
		$stmt->bind_param('i',$user_id);
		$stmt->execute();
		$stmt->store_result();
	}
	
	//allowed number of login attempts 
	$permittedLoginAttempts = 3;
	if($stmt->num_rows > $permittedLoginAttempts){
		//reached maximum number of permitted login attempts
		return true;
	} else {
		//they can login
		return false;
	}
}

function update_login_attempt($user_id,$mysqli){ 
	$timeStamp = time();
	$mysqli->query("INSERT INTO login_attempt(user_id, time) VALUES ('$user_id','$timeStamp')");

}

//returns true if there are special characters in string
//checks if any of the following characters are in the string:
//don't use for simple text input ( subtitles, paragraphs)
function check_SQL_injection($text){
	if(preg_match('/[\'^�$%&*()}{@#~?><>,|=_+�-]/', $text)){
		//one of the special characters is in the string
		return true;
		
	} else {
		return false;
	}
}

function login_check($mysqli) {
    if (isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) {
        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
        if ($stmt = $mysqli->prepare("SELECT user_password, user_name FROM user WHERE user_id = ? LIMIT 1")) {
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows == 1) {

                $stmt->bind_result($password, $un);
                $stmt->fetch();
                $login_check = hash('sha512', $password . $user_browser);

                if ($login_check == $login_string) {
                	$_SESSION['username'] = $un;
                    return true;
                    //logged in
                }
                //false = not logged in
                else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function sanitize($url) {

    if ('' == $url) {
        return $url;
    }

    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);

    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;

    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }

    $url = str_replace(';//', '://', $url);

    $url = htmlentities($url);

    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);

    if ($url[0] !== '/') {
        // We're only interested in relative links from $_SERVER['PHP_SELF']
        return '';
    } else {
        return $url;
    }
}
