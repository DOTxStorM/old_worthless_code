<?php

//open connection
function open_connection() {
	$con=mysqli_connect('localhost', 'root', '', 'database');
	return $con;
}

?>