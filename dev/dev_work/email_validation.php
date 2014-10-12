
<?php 
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
<link type="text/css" rel="stylesheet" href="css/email_validation.css">
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet"> 
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script src="js/email_validation.js"></script>


</head>

<body>
  <?php include_once 'includes/nav_logged_out.php'; ?>

<script>
var code = "<?php 
			if(isset($_GET['q'])) {
				echo $_GET['q'];
			}
			else {
				echo 'empty';
			} 
			?>";

</script>

<div id ='message'></div>
<div id = 'subtext'></div>

</body>
</html>

