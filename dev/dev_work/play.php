<?php
    include_once 'includes/confirm_login.php'; 
    include_once 'includes/header.php';
    
?>
    <script language="javascript" type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <link href="css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
    <link rel = "stylesheet" type = "text/css" href = "css/play.css" />
    <!--<script language="javascript" type="text/javascript" src="js/display_functions.js"></script>-->
    <!--<script language="javascript" type="text/javascript" src="js/play.js"></script>-->
</head>
<body>
    <?php
        include_once 'includes/slide_manager.php';
        include_once 'includes/user_manager.php';
        include_once 'includes/media_widget_manager.php';
        include_once 'includes/text_widget_manager.php';
        include_once 'includes/user_media_manager.php';
        include_once 'includes/tags_manager.php';
        include_once 'includes/story_manager.php';
        include_once 'includes/open_connection.php';
        include_once 'includes/favorites_manager.php'; 
        include_once 'includes/flags_manager.php';
        include_once 'includes/nav_logged_in.php'; 
        include_once 'includes/play_functions.php';
        include_once 'includes/display_functions.php';
    ?>
    
   <?php
	// Confirm user is accessing owned story
	
	// If there is no ID, the story gets created
	
	if (isset($_GET['id'])){	
	
			// Get story
			$story_id = $_GET['id'];
	
			$story_title = get_story_attribute($story_id, "str_title");
			$story_desc = get_story_attribute($story_id, "str_description");
		
	}
	
	
	?>

<?php

include_once 'includes/text_widget_manager.php';
include_once 'includes/media_widget_manager.php';
include_once 'includes/image_widget_manager.php';
$mysqli = open_connection();


//get the post data from doc_ready.js
try{
		
	//parse with JSON to produce a story array
	$encoded_array = loadStory($story_id);

	//uncomment to check if story_array is being called correctly
	//$story_array = json_decode(loadStory($story_id), true);	
	// php used for echoing story array from databaseecho ('story array looks like: '.print_r($story_array, true));
			
	
	}	
catch(Exception $e){
	echo 'Error loading story array from Database';
	}
		
?> 
    <style type="text/css">
    .play_story{
	   border: solid 5px #3B8CF4;
	    border-radius:10px;
	    min-width: 460px;
	    max-width:900px;
	    width:auto;
	    margin-left: auto;
	    margin-right: auto;
	    margin-top:10px;
	    height: 450px;
    }
    
    .slide_content{
	    border: solid 5px #3B8CF4;
	    border-radius:10px;
	    height:150px;
	    min-width: 460px;
	    max-width:900px;
	    width:auto;
	    margin-left: auto;
	    margin-right: auto;
	}
    
	.body_wrapper{
	    width: inherit;
	    height: inherit;
	    position:relative;
	    margin-left:auto;
	    margin-right:auto;
	    margin-bottom: 40px;
	    margin-top:70px;
	}
   
	#story_details{
	    margin-bottom:2%;
	    margin-top:2%;
	    min-width: 460px;
	    max-width:900px;
	    width:auto;
	    margin-left: auto;
	    margin-right: auto;
	}   
 

	#slides {
		height: 118px;
		width: 880px;
		/*margin: 10px 0px 10px 5px;*/
		margin: 10px 0px 0px 0px;
		} 
	 
 
    </style>
    
	<div class="create_cont" style="margin-right: 0;"><!--id="body_wrapper"-->
	
	
		<div class="column secondColumn canvas_timeline">
		
			<div class="canvas play_story" id="storyCanvas"></div>
			
			<div class="timeline slide_content" id="slides" ><!-- id="story_details"-->
			      <!--<h3 style="margin-top:0px;">Timeline</h3>-->
			      <script src="js/View_timeline_functions.js" type="text/javascript"></script>
			      <div id="timelineWrapper">	     
				      <ul id="timelineSortable" class="slideSortParent">
				      <!-- this is where the slides will populate -->
				      </ul>
			      </div>
			</div>
	
		</div>
			<div id="story_details">
				<?php displayStoryDetails(); ?>
			</div>
	
	</div><!--End Create Container-->
	
<?php include_once 'includes/footer.php';?>


<script>
slide_array = new Array();		//javascript array to locally contain all the slides of the story

selected_wigdet = null;			//the widget that the user has clicked on -- start with nothing selected
selected_slide = null;          //the slide the user currently is viewing
current_slide = 1;				//the slide the user is looking at -- start at 1
widget_array = new Array();		//the array of widgets on CURRENT slide
id_counter = 0;
widg_clicked = false;
this_page = "play";

// Slide constructor function
function Slide(p, w, d){
this.position = p; 		// position in the story's order
this.widget_array = w; 	// array containing all the widget data for this new slide
this.data = d;			// other data for slide, such as background color, stored in associative array
}
</script>

<script type="text/javascript">	
	//init associative array from database
	var encodedStoryArray = <?php echo $encoded_array; ?>;
	var storyArrayLength = encodedStoryArray.length;
</script>


  
<script src="js/View_doc_ready.js"></script><!--only needed for createStory page -->

<script src="uploadify/jquery.uploadify.min.js" type="text/javascript" language="javascript"></script>
    <script src="js/create/widget_attr.js"></script>
	<script src="js/create/drag_drop.js"></script>
<script> var user_id="<?php echo $_SESSION['user_id']; ?>";</script>

