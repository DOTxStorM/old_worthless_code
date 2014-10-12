
<?php 
include_once 'includes/confirm_login.php';
include_once 'includes/story_manager.php';
include_once 'includes/user_manager.php';
include_once 'includes/media_widget_manager.php';
include_once 'includes/image_widget_manager.php';
include_once 'includes/text_widget_manager.php';
include_once 'includes/favorites_manager.php';
include_once 'includes/user_media_manager.php';
include_once 'includes/admin_media_manager.php';
?>

<?php include_once 'includes/header.php'; ?>
  <meta name="description" content="">
	<meta name="author" content="">
<br><br><br><br>

<title>StoryBlox -- Admin Images</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<link rel="stylesheet" type="text/css" href="css/main.css">
<link type="text/css" rel="stylesheet" href="css/header_footer.css">
<link type="text/css" rel="stylesheet" href="css/story_search_display.css">
<link rel="stylesheet" type="text/css" href="uploadify/uploadify.css">
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet"> 
<link type="text/css" rel="stylesheet" href="css/admin_media.css">

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js" type="text/javascript"></script>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script src="uploadify/jquery.uploadify.min.js" type="text/javascript"></script>
<script src="js/admin_media.js" type="text/javascript"></script>

</head>

<body>

<?php include_once 'includes/nav_logged_in.php'; ?>

<div id="queue"></div>
<input id="file_upload" name="file_upload" type="file" multiple="true"><br>

<script>
var userid = "<?php echo $_SESSION['user_id']; ?>";
</script>

<div id="accordion">

  <h3 class="adminButton">Admin Images</h3>
  <div class="mediaHolder">
	<?php  // Load all my media

	// Call DB. Get array of media links
	$my_media = getAdminImages($_SESSION['user_id']);
	
	// No media is found
	if ($my_media == false){
		echo "<div class='media_item'>".
			 "<p class='none_text'>No media</p>".
			 "</div>";
	}							
	foreach ($my_media as $x){
		// Display media
		echo	"<div class='media_item'>".
				"<img src='//data-storyblox.omixorp.com/". $x ."' width='100%' height='100%'>".
				"</div>";
	}
	?>
	</div>
	
  <h3 class="adminButton">Admin Video</h3>
  <div class="mediaHolder">
	<?php  // Load all my media

	// Call DB. Get array of media links
	$my_media = getAdminMedia($_SESSION['user_id']);
	
	// No media is found
	if ($my_media == false){
		echo "<div class='media_item'>".
			 "<p class='none_text'>No media</p>".
			 "</div>";
	}							
	foreach ($my_media as $x){
		// Display media
		echo	"<div class='media_item'>".
				"<img src='//data-storyblox.omixorp.com/". $x ."' width='100%' height='100%'>".
				"</div>";
	}
	?>
	</div>
  <h3 class="adminButton">Admin Audio</h3>
   <div class="mediaHolder">
	<?php  // Load all my media

	// Call DB. Get array of media links
	$my_media = getAdminAudio($_SESSION['user_id']);
	
	// No media is found
	if ($my_media == false){
		echo "<div class='media_item'>".
			 "<p class='none_text'>No media</p>".
			 "</div>";
	}							
	foreach ($my_media as $x){
		// Display media
		echo	"<div class='media_item'>".
				"<img src='//data-storyblox.omixorp.com/". $x ."' width='100%' height='100%'>".
				"</div>";
	}
	?>
	</div>
</div>

</body>
</html>

