<?php
include_once 'includes/open_connection.php';
include_once 'includes/functions.php';
$mysqli = open_connection();
$logged_in = false;
sec_session_start();
if (login_check($mysqli) == true) {
    // If user is logged in, display logged in header
    $logged_in = true;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>404 Page Not Found!</title>

        <link type="text/css" rel="stylesheet" href="css/main.css">
        <link type="text/css" rel="stylesheet" href="css/header_footer.css">
        <link type="text/css" rel="stylesheet" href="css/404.css">
        <script src="js/header.js"></script>

    </head>
    <body>
        <div id="wrapper_main">
            <div id="wrapper_content">

                <?php
                if ($logged_in) {
                    include_once 'includes/header.php';
                } else {
                    include_once 'includes/logged_out_header.php';
                }
                ?>

                <div id="welcome_box">
                    
                    <h2><br><br>404 Error - We couldn't find the page you were looking for.</h2>

                </div>

                <!-- Main Body -->
                <div id="main_box">
                    <!-- Message -->
                    <div class="info_box" id="login_box">
                        <p class="info_header" id="login_header">Press the button to go to the home page.</p>
                        <div>
                            <button id='home_button' onclick="window.location.href = 'index.php';">GO HOME</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once 'includes/footer.php'; ?>
    </body>
</html>
