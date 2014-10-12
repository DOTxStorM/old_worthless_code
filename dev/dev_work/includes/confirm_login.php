<?php

include_once 'open_connection.php';
include_once 'functions.php';
$mysqli = open_connection();

sec_session_start(); 
if(login_check($mysqli) == false) {
    // If user is not logged in, send them to login page
    header("Location: ./index.php");
}
