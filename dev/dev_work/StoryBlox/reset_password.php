<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Reset my password</title>
</head>

<body>

<?php

// Connect to MySQL
//$c = mysql_connect("localhost", "root", "");
//mysql_select_db("main", $c);
$con = open_connection();

// Was the form submitted?
if ($_POST["ResetPasswordForm"])
{
	// Gather the post data
	$email = mysql_real_escape_string($_POST["email"]);
	$password = md5(mysql_real_escape_string($_POST["password"]));
	$confirmpassword = md5(mysql_real_escape_string($_POST["confirmpassword"]));
	$q = $_POST["q"];

	// Use the same salt from the forgot_password.php file
	$salt = "PiuwrO1#O0rl@+luH1!froe*l?8oEb!iu)_1Xaspi*(sw(^&.laBr~u3i!c?es-l651";

	// Generate the reset key
	$resetkey = md5($salt . $email);

	// Does the new reset key match the old one?
	if ($resetkey == $q)
	{
		if ($password == $confirmpassword)
		{
			// Update the user's password
			mysql_query("UPDATE `users` SET `password` = '$password' WHERE `email` = '$email'");
			echo "Your password has been successfully reset.";
		}
		else
			echo "Your password's do not match.";
	}
	else
		echo "Your password reset key is invalid.";
}

mysqli_close($con);

?>

</body>

</html>