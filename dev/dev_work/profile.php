<?php
include_once 'includes/confirm_login.php';
include_once 'includes/open_connection.php';
include_once 'includes/user_manager.php';
?>

<?php include_once 'includes/header.php'; ?>
  <meta name="description" content="">
	<meta name="author" content="">
	
	<?php include_once 'includes/nav_logged_in.php';?>

<title>Storyblox -- Edit Profile</title>
<!-- these support the header/footer formatting -->
<link type="text/css" rel="stylesheet" href="css/profile.css">

<script src="js/sha512.js"></script>
<script src="js/header.js"></script>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script src="js/profile.js"></script>

<script>
var user_id = "<?php echo $_SESSION['user_id']; ?>";
</script>

</head>

<body>
	<div id="wrapper_main">
		<div id="wrapper_content">

			<?php include_once 'includes/header.php'; ?>
			
			<div class="container" style="text-align:center">
				<h1>Edit Your Profile</h1>
				<div id="collapse_box">
					<h3>Edit Password</h3>
					<div class="form">
						<form id="pForm" action="includes/update_profile.php" method="post">
							<p class="error" id="password_error"> </p>
							<input class="form-control" type="password" name="new_password" placeholder="New Password"/><br>
							<input class="form-control" type="password" name="confirm_password" placeholder="Confirm New Password"/><br>
							<br><input class="form-control" type="password" name="old_password" placeholder="Old Password"/> <br>
							<br>
							<button class="btn btn-default" type="button" onclick="change_password(pForm, pForm.new_password, pForm.confirm_password, pForm.old_password);">Submit</button>
						</form>
					</div>
					<h3>Edit Email Address</h3>
					<div class="form">
						<form id="eForm" action="includes/update_profile.php" method="post">
							<p class="error" id="email_error"> </p>
							<br><input class="form-control" type="text" name="new_email" placeholder="New Email Address"/><br>
							<input class="form-control" type="text" name="confirm_email" placeholder="Confirm New Email"/><br>
							<br><input class="form-control" type="password" name="old_password" placeholder="Password"/><br> <br>
							<button class="btn btn-default" type="button" onclick="change_email(eForm, eForm.new_email, eForm.confirm_email, eForm.old_password);">Submit</button>
						</form>	
					</div>
					<h3>Edit Username</h3>
					<div class="form">
						<form id="uForm" action="includes/update_profile.php" method="post">
							<p class="error" id="username_error"> </p>
							<br><input class="form-control" type="text" name="new_username" placeholder="New Username"/><br />
							<br><input class="form-control" type="password" name="password" placeholder="Password"/> <br> <br>
							<button class="btn btn-default" type="button" onClick="change_username(uForm, uForm.new_username, uForm.password);">Submit</button>
						</form>
					</div>
					<h3>Delete Account</h3>
					<div class="form">
						<form id="dForm" action="includes/update_profile.php" method="post">
						<br><input class="form-control" type="password" name="password" placeholder="Password"/> <br> <br>
						<button class="btn btn-danger" type="button" onClick="delete_user(dForm, dForm.password)">Delete</button>
						</form>
					</div>
				</div>
				<br><br>
			</div>
		</div>
	</div>
	<?php include_once 'includes/footer.php'; ?>
</body>