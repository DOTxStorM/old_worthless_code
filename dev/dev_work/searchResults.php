<!DOCTYPE html>
<?php
include_once 'includes/confirm_login.php'; 
?>
<html>
<head>
 
    <title id = "page_title">Story Search</title>
    <link rel = "stylesheet" type = "text/css" href = "css/SearchResultStyles.css" /> 
     <link rel = "stylesheet" type = "text/css" href = "css/storyDisplay.css" /> 
    <script language="javascript" type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <link href="css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet"> 
    <link rel="stylesheet" href="css/jumbotron.css">
    <link rel="stylesheet" href="css/navbar.css">
    <script language="javascript" type="text/javascript" src="js/bootstrap.js"></script>
    <script language="javascript" type="text/javascript" src="js/bootstrap.min.js"></script>
    <script language="javascript" type="text/javascript" src="https://raw.githubusercontent.com/botmonster/jquery-bootpag/master/lib/jquery.bootpag.min.js"></script>
    <!--<script language= "javascript" type ="text/javascript" src= "js/searchResults.js"></script> -->
    <script language="javascript" type="text/javascript"></script>
    <script language="javascript" type="text/javascript" src="js/display_functions.js"></script>
    </script>
</head>
<body>
    <?php  
        include_once 'includes/header.php';  
        include_once 'includes/search_functions.php';
        include_once 'includes/tags_manager.php';
        include_once 'includes/story_manager.php';
        include_once 'includes/open_connection.php';
        include_once 'includes/user_manager.php';
        include_once 'includes/favorites_manager.php';
        include_once 'includes/test.php';
        include_once 'includes/flags_manager.php';
        include_once 'includes/nav_logged_in.php'; 
        include_once 'includes/display_functions.php';
        echo '<script language= "javascript" type ="text/javascript" src= "js/searchResults.js"></script>';
    ?>
    
    <div id = "bodyWrapper">
        <div id = "search_bar">
            <form class="search_button" method="get" action="searchResults.php">
                <input type="text" name="searchInput" id= "search_input" placeholder=" Search by story name or tags" 
                    value = "<?php setSearchbarText();?>" onclick= "this.select();"/>
                <button type="button" id="alt_search_button" onclick="this.form.submit()">Search</button>      
            </form> 
        </div>
        <div id ="num_results_div">
            <p id = "num_results"><?php displayNumResults();?> </p>
        </div>
        <div id ="story_results">
            <?php createTable()?>
        </div>
    </div>   

    <div id = "pagination">
        <ul id ="pageNumberLinks" class= "pagination pagination-sm">
            <li class = "previous" id = "previous" style = "display:none;"><a id = "prev_link"href="?page=1">Previous</a></li>
            <li class = "next" id ="next" style = "display:none;"><a id = next_link href="?page=2">Next</a></li>
        </ul> 
        <?php setPageLinks(); ?>
    </div>
    
    <?php include_once 'includes/footer.php';?>
</body>
</html>

<?php 
   
    if(isset($_POST['action']) && isset($_POST['userId']) && isset($_POST['storyId'])){   
        $action = filter_input(INPUT_POST, 'action');
        
        if(!(($action == "favorite") || ($action == "unfavorite"))){
            return;
        }
        $user_id = filter_input(INPUT_POST, 'userId');
        $story_id = filter_input(INPUT_POST, 'storyId');

        if($action == "favorite"){
            add_favorite($story_id, $user_id, "");//add story as users favorite 
        }else{
           remove_favorite($user_id, $story_id);//remove story as users favorite in 
        }
    } 
    
    /*
     * receive storyid,userid, and flagaction from POST when user flags or unflags a story
     */   
    if(isset($_POST['storyId'])&& isset($_POST['userId']) && isset($_POST['flagAction'])){
        $flag_action = filter_input(INPUT_POST, 'flagAction');

        if(!(($flag_action == "flag") || ($flag_action == "unflag"))){
            return;
        }

        $user_id = filter_input(INPUT_POST, 'userId');
        $story_id = filter_input(INPUT_POST, 'storyId');
        
        //user flagged story, add story/user id to flag table in database
        if($flag_action == "flag"){
            addFlag($story_id, $user_id);
        }else{//remove flagged story for user in flag table
            //removeFlag($p_flag_id)
        }
    }
?>     
  

