<?php 
include_once 'includes/confirm_login.php';
include_once 'includes/story_manager.php';
include_once 'includes/user_manager.php';
include_once 'includes/media_widget_manager.php';
include_once 'includes/image_widget_manager.php';
include_once 'includes/text_widget_manager.php';
include_once 'includes/favorites_manager.php';
include_once 'includes/user_media_manager.php';
?>

<?php include_once 'includes/header.php'; ?>
  <meta name="description" content="">
	<meta name="author" content="">


<title>StoryBlox -- My Stories</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link type="text/css" rel="stylesheet" href="css/my_stories.css">
<link type="text/css" rel="stylesheet" href="css/story_search_display.css">
<link rel="stylesheet" type="text/css" href="uploadify/uploadify.css" />
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet"> 
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="uploadify/jquery.uploadify.min.js" type="text/javascript" language="javascript"></script>
<script src="js/my_stories.js"></script>

</head>

<body>

<script>
var userid = "<?php echo $_SESSION['user_id']; ?>";
</script>

	

			<?php include_once 'includes/nav_logged_in.php'; ?>

			<div id="page_content">


						<div class="holder_wrapper" id="my_stories_holder_wrapper">
							<p class="header_text">My Stories</p>
							<div class="story_holder" id="my_stories_holder">
								<?php // Load all my stories

								// Call DB. Get array of media links
								$my_stories = get_user_stories($_SESSION['user_id']);

								// No stories are found
								if ($my_stories == false){
									echo "<div class='story_item'>".
											"<br><p class='none_text'>No Stories</p>".
											"</div>";
								}
								else{
								// Display stories
									echo '<script>numStories = '. mysqli_num_rows($my_stories) .';</script>';
									
									while($row = mysqli_fetch_array($my_stories)){

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
										$shared = get_story_attribute($story_id,'share_setting');
										
										
										echo "<div class='story_item_container' id='mine".$story_id."'>".
											
											// IMAGE (thumbnail)
											"<div class='story_image_container'>".
											// LINK
											"<a class='link_item' href='play.php?id=".$row['str_id']."'>".
											"<img class=story_thumbnail src='". $thm_nl ."'/>".
											"</a>".	  // END LINK
											//BUTTONS
											"<a class='story_button' onclick='editStory(". $story_id .")'><span class='glyphicon glyphicon-pencil' title='Edit Story' rel='tooltip'></span></a>".
											"<a class='story_button' onclick='deleteStory(". $story_id .")'><span class='glyphicon glyphicon-trash' title='Delete Story' rel='tooltip'></span></a>".
											"<a onclick='publisher(". $story_id .", ". $shared .")'>".
											"<span id='pub_button".$story_id."' title=";
											
											// Tooltip displays:
											if ($shared == 0){
												echo '"Publish Story"';
											}
											else{
												echo '"Unpublish Story"';
											}
											
											if ($shared == 0){
												echo ' class="story_button publish_button glyphicon glyphicon-share"';
											}
											else{
												echo ' class="story_button unpublish_button glyphicon glyphicon-unchecked"';
											}
											
											echo " rel='tooltip'";
											echo "</span></a>".
											// END BUTTONS
											
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

							?>
							</div>
						</div>


						<div class="holder_wrapper" id="my_fav_stories_holder_wrapper">
							<p class="header_text">Favorite Stories</p>
							<div class="story_holder" id="my_favorites_holder">
								<?php // Load all my favorite stories

							// Call DB. Get array of media links
							$fav_stories = getFavorites($_SESSION['user_id']);
							$i = 0;
							$num_res = count($fav_stories);
							echo '<script>numStories = '. $num_res .';</script>';
								// No stories are found
								if ($num_res == 0){
									echo "<div class='story_item'>".
											"<br><p class='none_text'>No Favorites</p>".
											"</div>";
								}
								else{

								// Display stories
									while($i < $num_res){
										$row = mysqli_fetch_array($fav_stories[$i]);
										++$i;
										
										$s_id = $row['str_id'];

										// Dumb function. Get DB team to make writing DB functions this less of my job.

										$thm_nl = get_story_attribute($s_id, 'thumbnail_file_path');
										$title = get_story_attribute($s_id,'str_title');
										$desc = get_story_attribute($s_id,'str_description');
										
										// Check thumbnail
										if ($thm_nl == ""){
											$thm_nl = "images/default_thumbnail.jpg";
										}
										// Check Title
										$title_options="";
										if ($title == ""){
											$title = "Untitled";
											$title_options = "style='color:#999999'";
										}		
										
										$story_id = $row['str_id'];
										
										echo "<div class='story_item_container' id='fav".$story_id."'>".
											
											// IMAGE (thumbnail)
											"<div class='story_image_container'>".
											// LINK
											"<a class='link_item' href='play.php?id=".$story_id."'>".
											"<img class=story_thumbnail src='". $thm_nl ."'/>".
											"</a>".	  // END LINK
											//BUTTONS
											"<a onclick='unfavoriteStory(". $story_id .")'>".
											"<span id='fav_button".$story_id."' title='Unfavorite'";
											echo ' class="story_button publish_button glyphicon glyphicon-star"';
											echo " rel='tooltip' >";
											echo "</span></a>".
											// END BUTTONS
											
											"</div>".
											
											//TEXT
											"<a class='link_item' href='play.php?id=".$row['str_id']."'>".
											"<div class='story_text_container'>".
											//Title
											"<p ".$title_options." class='story_title'>".$title."</p>".
											//Description
											"<p class='story_description'>".$row['str_description']."</p>".
											"</div>". // END TEXT
											"</a>".	  // END LINK
											
											"</div>"; // END CONTAINER
									}
								}

							?>
							</div>
						</div>

						<div class="holder_wrapper" id="media_holder_wrapper">
							<p class="header_text">My Media</p>
							<div id="media_holder">
								<?php  // Load all my media

							// Call DB. Get array of media links
							$my_media = getAllUserMedia($_SESSION['user_id']);

							// No media is found
							if ($my_media == false){
								echo "<div class='media_item'>".
										"<br><p class='none_text'>No media</p>".
										"</div>";
							}
							
							foreach ($my_media as $x){
								// Display media
								echo	"<div class='media_item'>".
											"<img src='//data-storyblox.omixorp.com/". $x ."'>".
											"</div>";
							}
							?>
							</div>
								<div id="add_media_button_holder">
									<input id="file_upload" name="file_upload" type="file" multiple="true">
								</div>
						</div>


			</div>
	
