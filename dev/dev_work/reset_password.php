<?php 
include_once 'includes/open_connection.php';
include_once 'includes/user_manager.php';
?>

<?php include_once 'includes/header.php'; ?>
  <meta name="description" content="">
	<meta name="author" content="">
<br><br><br><br>

<title>StoryBlox -- Email Validation</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<link rel="stylesheet" type="text/css" href="css/main.css">
<link type="text/css" rel="stylesheet" href="css/header_footer.css">
<link type="text/css" rel="stylesheet" href="css/story_search_display.css">
<link type="text/css" rel="stylesheet" href="css/reset_password.css">
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet"> 
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

<script src="js/sha512.js"></script>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script src="js/reset_password.js"></script>

</head>

<body>
  <?php include_once 'includes/nav_logged_out.php'; ?>
  
<?php
if (!isset($_GET['q'])) {
	header('Location: error.php');
}
?>

<script>
var q = "<?php echo $_GET['q']; ?>";
</script>

<div class="form">
						<form id="pForm" action="includes/reset.php" method="post">
							<p class="error" id="password_error"> </p>
							<input class="form-control" type="password" name="new_password" placeholder="New Password"/><br>
							<input class="form-control" type="password" name="confirm_password" placeholder="Confirm New Password"/><br>
							<br>
							<button class="btn btn-default" type="button" onclick="change_password(pForm, pForm.new_password, pForm.confirm_password);">Reset Password</button>
						</form>
					</div>
</body>

</html>