<!-- <?php
include_once 'includes/register_try.php';
include_once 'includes/functions.php';

// if logged in, redirect to home
sec_session_start();
if (login_check($mysqli) == true) {

    // If user is directed here with exit value, they are logged out
    if (isset($_GET['exit'])) {
        include_once 'includes/logout.php';
        exit();
    }

    // If user is logged in, send them to home page
    header("Location: ./home.php");
}
?> -->

<?php include_once 'includes/header.php'; ?>
<link rel="stylesheet" href="css/jumbotron_narrow.css">
  <meta name="description" content="">
	<meta name="author" content="">
</head>
<body>
  <?php include_once 'includes/nav_logged_out.php'; ?>
  
  <div class="container">	
    <div class="jumbotron">
      <h1>Welcome to StoryBlox!</h1>
      <p class="lead">The online social story builder!</p>
      <!--<div class="control-group">-->
      <div class="row">
        <div class="col-md-5">
        <h2 class="info_header" id="login_header">Log In</h2>
        <!--<label class="control-label" for="textinput"></label>-->
          <div class="text_form">
                          <form id="login_form" action="includes/login_try.php" method="post">
                              <p class="error" id="login_error">
                                  <?php
                                  if (isset($_GET['login_error'])) {
                                      if ($_GET['login_error'] == '0') {
                                          echo "Invalid Log In Information";
                                      } else if ($_GET['login_error'] == '1') {
                                          echo "Email Not Validated";
                                      } else if ($_GET['login_error'] == '2') {
                                          echo "Your Account Has Been Locked. Please return in 2 hours.";
                                      } //else {
                                         // echo "<br>";
                                      //}
                                  } //else {
                                     // echo "<br>";
                                  //}
                                  ?></p>
              <div class="form-group">
                <input type="text" name="email" id="login_email" class="form-control" maxlength="200" placeholder = "Username or Email" 
                              <?php
                              if (isset($_GET['eTried'])) {
                                  echo "value='" . $_GET['eTried'] . "'";
                              }
                              ?>
                                     />
              </div>
              <div class="form-group">
                <input type="password" name="password" id="login_password" class="form-control" maxlength="128" placeholder = "Password" />
              </div>
                              <button class="btn btn-primary" onclick="return formhash(this.form, this.form.email, this.form.password);">Log In</button>
                              <br><a href="forgot_password.php">Forgot your password?</a>
                          </form>
                      </div>
        </div>
        <div class="col-md-2">
          <div id="or_box">
            <p id="or_text"><strong>OR</strong>
            </p>
          </div>
        </div>
                  <!-- New Account -->
        <div class="col-md-5">
          <div class="info_box">
            <h2 class="info_header" id="signup_header">Sign Up</h2>
            <div class="text_form">
              <form id="signup_form" action="includes/register_try.php" method="post">
                <p id="email_error" class="error">
                <?php
                if (isset($_GET['email_error'])) {
                  if ($_GET['email_error'] == 0) {
                    echo "Invalid Email";
                  } elseif ($_GET['email_error'] == 1) {
                    echo "An account is already using that email";
                  } elseif ($_GET['email_error'] == -1) {
                    echo "There was an unknown error. Please try again.";
                  } //else {
                    //echo "<br>";
                  //}
                } //else {
                  //echo "<br>";
                //}
                ?></p>
                <div class="form-group">
                  <input type="text" name="email" placeholder="Email" class="form-control" maxlength="200" />
                </div>
                <p id="username_error" class="error"><?php
                  if (isset($_GET['username_error'])) {
                    if ($_GET['username_error'] == 0) {
                      echo "Username must be 3-20 characters and contain only letters, numbers and underscores.";
                    } elseif ($_GET['username_error'] == 1) {
                      echo "Username Taken";
                    } //else {
                      //echo "<br>";
                    //}
                  } //else {
                    //echo "<br>";
                  //}
                ?></p>
                <div class="form-group">
                  <input type="text" name="username" placeholder="Public username" class="form-control" maxlength="20" />
                </div>
                <p id="password_error" class="error"><?php
                  if (isset($_GET['password_error'])) {
                    if ($_GET['password_error'] == 0) {
                      echo "Passwords must be 8-20 characters.";
                    } elseif ($_GET['password_error'] == 1) {
                      echo "Password must contain at least one letter and one character.";
                    } elseif ($_GET['password_error'] == 2) {
                      echo "Passwords did not match.";
                    } elseif ($_GET['password_error'] == -1) {
                      echo "Error processing your password.";
                    } //else {
                      //echo "<br>";
                    //}
                  } //else {
                    //echo "<br>";
                  //}
                ?></p>
                <div class="form-group">
                  <input type="password" name="password" placeholder="New password" class="form-control" maxlength="128" />
                </div>
                <div class="form-group">
                  <input type="password" name="password2" placeholder="Confirm password" class="form-control" maxlength="128" />
                </div>
                <button id="signup_button" class="btn btn-primary" onclick="return regformhash(this.form,
                        this.form.username,
                        this.form.email,
                        this.form.password,
                        this.form.password2);">Sign Up</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <script src="js/sha512.js"></script>
	<script src="js/log_reg_submit.js"></script>
<?php include_once 'includes/footer.php'; ?>