<?php
include_once 'includes/open_connection.php';
include_once 'includes/functions.php';
$mysqli = open_connection();

$logged_in = false;

sec_session_start();
if (login_check($mysqli) == false) {
	// If user is not logged in, send them to login page
	$logged_in = true;
}

$the_error = filter_input(INPUT_GET, 'err', $filter = FILTER_SANITIZE_STRING);



if (!$the_error) {
	$error = 'Oops! An unknown error happened.';
} else{
	$error = error_parser($the_error);
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Secure Login: Error</title>
<link type="text/css" rel="stylesheet" href="css/main.css">
<link type="text/css" rel="stylesheet" href="css/header_footer.css">
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

			<h1>There was a problem</h1>
			<p class="error">
				<?php echo $error; ?>
			</p>

		</div>
	</div>

	<?php include_once 'includes/footer.php'; ?>

</body>
</html>


<?php // error parser

        function error_parser($e){
			$ret = '';

			switch ($e){
        	case 'notyourstory':
				$ret = "You tried to edit someone else's story!";
				break;
        	case 'privatestory':
        		$ret = "That story is private.";
        		break;
        	case 'privatestory':
        		$ret = "That story is private.";
        		break;
        	case 'nostory':
        		$ret = "That story does not exist.";
        		break;
        	case 'update_profile_unknown':
        		$ret = "There was an error\nWe couldn't update your profile.";
        		break;
        	default:
        		$ret = "Oops! An unknown error happened.";
        	}
        	return $ret;
}

?>