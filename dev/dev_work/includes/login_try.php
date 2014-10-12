<?php

include_once 'open_connection.php';
include_once 'functions.php';
$mysqli = open_connection();

sec_session_start();

if (isset($_POST['email'], $_POST['p'])) {
    $email = $_POST['email'];
    $password = $_POST['p']; // The hashed password.
    
    if (login($email, $password, $mysqli) == true) {
        // Login success 
        header('Location: ../home.php');
    } else {
        // Login failed -- return to login page
        header('Location: ../index.php?login_error=' . $_GET['login_error'] . '&eTried='.$email);
    }
} else {
    // The correct POST variables were not sent to this page. 
    header('Location: ../error.php');
}
