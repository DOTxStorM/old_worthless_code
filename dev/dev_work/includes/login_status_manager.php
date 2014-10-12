<?php 

/**
 * functions to modify table that ensures no multiple logins
 * 
 * @class login_status_manager
 */
/**
 * updates user time stamp to last use
 * @method updateUserTimeStamp
 * @param unknown $p_str_id
 */
function updateUserTimeStamp($p_str_id) {
	$con = open_connection();
	$timeStamp = time();
	mysqli_query($con,"UPDATE login_status SET time = '". $timeStamp ."' WHERE str_id = '". $p_str_id ."'");
	mysqli_close($con);
}

/**
 * inserts user into the table
 * @method insertUserLog
 * @param unknown $p_user_id
 */
function insertUserLog($p_user_id) {
	$con = open_connection();
	$timeStamp = time();
	mysqli_query($con,"INSERT INTO login_status (user_id, time)
	VALUES ('". $p_user_id ."' , '" .$timeStamp ."' )");
	mysqli_close($con);
}

/**
 * checks to see if the user is logged in
 * @method isLoggedIn
 * @param unknown $_user_id
 * @return boolean
 */
function isLoggedIn($_user_id) {
	$con = open_connection();
	$result = mysqli_query($con,"SELECT * FROM login_status WHERE user_id = '". $_user_id ."'");
	mysqli_close($con);
	if(mysqli_num_rows($result) != 0) {
		return true;
	} else {
		return false;
	}
}

/**
 * deletes user from table
 * @method deleteUserLog
 * @param unknown $_user_id
 */
function deleteUserLog($_user_id) {
	$con = open_connection();
	mysqli_query($con,"DELETE user FROM  login_status WHERE user_id = '". $_user_id ."'");
	mysqli_close($con);
}

/**
 * gets latest time stamp for a specified user
 * @method getTimeStamp
 * @param unknown $_user_id
 * @return unknown
 */
function getTimeStamp($_user_id) {
	$con = open_connection();
	$result = mysqli_query($con,"SELECT time FROM login_status WHERE user_id = '" . $_user_id . "'");
	$row = mysqli_fetch_array($result);
	$info = $row[time];
	mysqli_close($con);
	return $info;
}


/**
 * CREATE TABLE login_status(
 * user_id int(11) NOT NULL,
 * time varchar(30) NOT NULL,
 * FOREIGN KEY (user_id) REFERENCES user(user_id) ON DELETE CASCADE
 * );
 */
?>