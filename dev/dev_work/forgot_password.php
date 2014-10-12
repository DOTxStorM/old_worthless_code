	
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<title>Forgot my password</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="shortcut icon" href="images/storyblox_favicon.ico">
		
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/main.css" rel="stylesheet">
		<link href="css/forgot_password.css" rel="stylesheet">
</head>

<body>

	<div class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					  <span class="sr-only">Toggle navigation</span>
					  <span class="icon-bar"></span>
					  <span class="icon-bar"></span>
					  <span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="index.php">StoryBlox</a><!--This link can be changed accordingly-->
				</div>
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav navbar-right">
						<li><a href="about.php">About</a></li>
						<li><a href="">Site Map</a></li>
						<li><a href="">Help</a></li>
						<li><a href="faq.php">FAQ</a></li>
					</ul>
				</div>	
			</div>
		</div>

	<div class="container">
		<div class="jumbotron">
			<h2>Forgot my password</h2>
			<br>
			<p class="text-left">
				Please enter your email in the form below and a link to reset your account will be sent.
			</p>
			<br>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<p class="error" id="reset_error">
				<input type="text input-medium" name="email" id="reset_email" class="form-control" maxlength="200" placeholder="Email Address"><br>
				<!--<button class="btn btn-primary">Submit</button>-->
				<input type="submit" name="ForgotPasswordForm" value="Submit" />
			</form>
		</div>
		
<!--	<div align="center" background-color="red">
		<h1>Storyblox - Build your story</h1>
		<h2>Forgot my password</h2>
		Please enter your email in the form below. A link to reset your account will be sent. <br><br>	
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			E-mail Address: <input type="text" name="email" class="form-control" size="20" /> <input type="submit" name="ForgotPasswordForm" value=" Process " />
		</form>
	</div> -->
<?php

include_once 'includes/open_connection.php';
include_once 'includes/user_manager.php';

// Was the form submitted?
if (isset($_POST["ForgotPasswordForm"]))
{
	// Harvest submitted e-mail address
	$con = open_connection();
	$email = mysqli_real_escape_string($con, $_POST["email"]);
	$u_id = user_email_exists($email);

	// Check to see if a user exists with this e-mail
	if ($u_id != 0)
	{
	
        // Create a random salt
		$salt = "PiuwrO1#O0rl@+luH1!froe*l?8oEb!iu)_1Xaspi*(sw(^&.laBr~u3i!c?es-l651";
		
		//get username
		$username = get_user_info($u_id, 'user_name');
 
        // generate validation code
		$resetkey = md5($salt . $username);
		$link = 'http://dev.storyblox.org/reset_password.php?q='.$email.';'.$resetkey;

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
   <p>You have requested a password reset. Please click on the link below to change your password.</p>
   <p><a href='.$link.'>ResetPassword</a> </p>
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
	
		echo "Your password recovery key has been sent to your e-mail address.";
	}
	else
		echo "No user with that e-mail address exists.";
}

?>

		<script src="./js/jquery.min.js"></script>
		<script src="./js/bootstrap.min.js"></script>
</body>

</html>