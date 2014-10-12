<?php 
include_once 'includes/confirm_login.php'; 
include_once 'includes/story_manager.php';
include_once 'includes/user_manager.php';
?>
<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<?php include_once 'includes/header.php'; ?>
    <link rel="stylesheet" href="css/storyDisplay.css">
    <link rel="stylesheet" href="css/home.css">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet"> 
    <script language="javascript" type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <link href="css/bootstrap.css" rel="stylesheet" media="screen">
    <script language="javascript" type="text/javascript" src="https://raw.githubusercontent.com/botmonster/jquery-bootpag/master/lib/jquery.bootpag.min.js"></script>
    <meta name="description" content="">
    <meta name="author" content="">
    <script language="javascript" type="text/javascript" src="js/display_functions.js"></script>
</head>
<body>
  <?php include_once 'includes/nav_logged_in.php'; 
        include_once 'includes/home_functions.php';
        include_once 'includes/display_functions.php';
        include_once 'includes/favorites_manager.php';
        include_once 'includes/flags_manager.php';
        include_once 'includes/tags_manager.php';
  ?>
    <div class="container_home">
    <div class="col-md-4">
        <div class="window jumbotron">
            <h2>Your Recent Stories</h2>
            <?php
                displayRecentVideos();
            ?> 
        </div>
    </div>
    <div class="col-md-4">
        <div class="window jumbotron">
            <h2>Recently Favorited Stories</h2>
            <?php
                displayLastFavStories();
            ?>  
        </div>
    </div>
    <div class="col-md-4">
        <div class="window jumbotron">
            <h2>Suggested Stories</h2>
            <?php
                displaySuggestedStories();
            ?>             
        </div>
    </div>
    </div>

<?php include_once 'includes/footer.php'; ?>
