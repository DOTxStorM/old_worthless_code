<?php

include_once 'open_connection.php';
include_once 'DB-config.php';

$mysqli = open_connection(); 
$error_msg = "?";
 
if (isset($_POST['username'], $_POST['email'], $_POST['p'])) {
    // Sanitize and validate the data passed in
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 200) {
        // Not a valid email
        $_GET['email_error'] = 0;
        $error_msg .= 'email_error=0&eTried='.$email."&";
    }

 
    $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
    if (strlen($password) != 128) {
        // The hashed pwd should be 128 characters long
        $error_msg .= 'password_error=-1&';
    }

    
    // Username validity and password validity
    // confirm that username is 20 char or less
    if (!preg_match('/^[a-zA-Z0-9_-]{3,20}$/', $username)){
        $error_msg .= 'username_error=1&';
    }
    
    
 
    $prep_stmt = "SELECT user_id FROM user WHERE user_email = ? LIMIT 1";
    $stmt = $mysqli->prepare($prep_stmt);
 
    if ($stmt) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
 
        if ($stmt->num_rows == 1) {
            // A user with this email address already exists
            $_GET['email_error'] = 1;
            $error_msg .= 'email_error=1&';
        }
        
        //if ()
        
    } else {
        // Unknown error
        $error_msg .= 'email_error=-1&';
    }
 
    // If there aren't any errors
    if ($error_msg == '?') {

        // Create a random salt
        $random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));
 
        // Create salted password 
        $password = hash('sha512', $password . $random_salt);
 
        // generate validation code
        // TEMP Set to 0 until email system is working
        $validation = hash('sha512', $password.time());
		$link = 'http://dev.storyblox.org/email_validation.php?q='.$username.';'.$validation;

        
        $message = '<html>
<body>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
 <tr>
  <td align="left" bgcolor="#5555ff" style="padding: 5px 0 5px 5px;">
   <!-- put the icon url in src -->
   <img src="images/StoryBlox.jpg" alt="StoryBlox Icon" width="200" height="100" style="display: block;" />
  </td>
 </tr>
 <tr>
  <td align="left" bgcolor="#ffffff" style="padding: 20px;">
   <p>Hello ' .$username. ',</p>
   <p>Thank you for becoming a member of <a href="http://storyblox.org/">StoryBlox.org</a> community.
      In order to activate your account, please click on the link below:</p>
   <p><a href='.$link.'>Activate Account</a> </p>
   <p>Thank you,</p>
   <p>StoryBlox</p>
  </td>
 </tr>
 <tr>
  <td bgcolor="#5555ff">&nbsp;</td>
 </tr>
</table>
</body>
</html>';
        
		
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= "From: noone@storyblox.org\r\n";
		
		//mail validation link to user
		mail($email, $username, $message, $headers);
		        
        // Insert the new user into the database 
        if ($insert_stmt = $mysqli->prepare("INSERT INTO user (user_name, user_email, user_password, salt, validation_code) VALUES (?, ?, ?, ?, ?)")) {
            $insert_stmt->bind_param('sssss', $username, $email, $password, $random_salt, $validation);
            // Execute the prepared query.
            if (! $insert_stmt->execute()) {
                header('Location: ../index.php?email_error=-1');
            }
        }
        header('Location: ../email_validation.php');
    }
    else{

        header('Location: ../index.php'.$error_msg);
    }
}
