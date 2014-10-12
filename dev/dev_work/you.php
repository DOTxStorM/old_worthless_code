<?php 
include_once 'includes/confirm_login.php'; 
include_once 'includes/story_manager.php';
include_once 'includes/user_manager.php';
// confirm user exists
$exists = false;
$user_id = 0;
$num_stories = 0;
if (user_name_exists($_GET['username'])){
	$exists = true;
	
	// get user's id
	if ($stmt = $mysqli->prepare("SELECT user_id FROM user WHERE user_name = ? LIMIT 1")) {
		$stmt->bind_param('s', $_GET['username']);
		$stmt->execute();
		$stmt->store_result();
	
		$stmt->bind_result($user_id);
		$stmt->fetch();
	
		if ($stmt->num_rows != 1) {
			// We didn't find the user
			$exists = false;
		}
	}
}

?>
<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<?php include_once 'includes/header.php'; ?>
<link rel="stylesheet" href="css/jumbotron.css">
<link rel="stylesheet" href="css/navbar.css">
<link rel="stylesheet" href="css/you.css">
  <meta name="description" content="">
	<meta name="author" content="">
</head>
<body>
  <?php include_once 'includes/nav_logged_in.php'; ?>
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<div class="jumbotron">
					<?php if ($exists){
        echo "<h3 class='story_header'>".$_GET['username']."'s Stories</h3>";

          $list = get_user_stories($user_id);
      if ($list == false){
									echo "<div class='story_item'>".
											"<br><p class='story_header'><strong>".$_GET['username']."</strong> has no stories</p>".
											"</div>";
								}
								else{
								// Display stories
									echo '<script>numStories = '. mysqli_num_rows($list) .';</script>';
									$num_stories = mysqli_num_rows($list);
									while($row = mysqli_fetch_array($list)){

										$story_id = $row['str_id'];

										// Check thumbnail
										$thm_nl = $row['thumbnail_file_path'];
										if ($thm_nl == ""){
											$thm_nl = "images/default_thumbnail.jpg";
										}
										// Check Title
										$title_options="";
										$title = $row['str_title'];
										if ($title == ""){
											$title = "Untitled";
											$title_options = "style='color:#999999'";
										}
										$desc = get_story_attribute($story_id,'str_description');
										
										
										
										echo "<div class='story_item_container' id='mine".$story_id."'>".
											
											// IMAGE (thumbnail)
											"<div class='story_image_container'>".
											// LINK
											"<a class='link_item' href='play.php?id=".$row['str_id']."'>".
											"<img class=story_thumbnail src='". $thm_nl ."'/>".
											"</a>".	  // END LINK
											
											"</div>".
											
											//TEXT
											"<a class='link_item' href='play.php?id=".$story_id."'>".
											"<div class='story_text_container'>".
											//Title
											"<p ".$title_options." class='story_title'>".$title."</p>".
											//Description
											"<p class='story_description'>".$desc."</p>".
											"</div>". // END TEXT
											"</a>".	  // END LINK
											
											"</div>"; // END CONTAINER
										}
								}
      }
      else{
			echo "<h3>No user named <strong>".$_GET['username']."</strong> exists.</h3>";
		}
        ?>
				</div>
			</div>
<?php if ($exists): ?>
			<div class="col-md-6">
				<div class="jumbotron">
					<div class="profile_info">
						<img class="profile_picture" src="images/profile.png" />
						<div class="profile_info_text">
							<h2>
								<?php echo $_GET['username']; ?>
							</h2>
							<p>
								<?php echo "Has " . $num_stories . " stories"?>
							</p>
						</div>
					</div>
				</div>
			</div>
<?php endif; ?>
		</div>
	</div>

	<?php include_once 'includes/footer.php'; ?>

</body>
</html>