<?php
include_once 'includes/confirm_login.php';
include_once 'includes/story_manager.php';
include_once 'includes/open_connection.php';
include_once 'includes/slide_manager.php';
include_once 'includes/user_manager.php';
include_once 'includes/media_widget_manager.php';
include_once 'includes/text_widget_manager.php';
include_once 'includes/favorites_manager.php';
include_once 'includes/user_media_manager.php';
// Confirm user is accessing owned story

// If there is no ID, the story gets created

if (isset($_GET['id'])){	
	$creator = get_story_attribute($_GET['id'],'creator_id');
	
	if ($creator == $_SESSION['user_id']){
		// Get story
		$story_id = $_GET['id'];
		
		/*
		// Get draft id so user isn't editing their finished story
		 $story_id = getDraftId($storyId);
		
		 */
		
		$story_title = get_story_attribute($story_id, "str_title");
		$story_desc = get_story_attribute($story_id, "str_description");
	}
	else{
		// User tried to access someone else's story
		header("Location: error.php?err=notyourstory");
	}
	
} else{
	try{
	// No id is set: create new story
	$date_mod = date("Y-m-d H:i:s");
	$story_id = insert_story("", "", $date_mod, "", "", 0, -1, 0, 0, 0, $_SESSION['user_id']);
	
	// Move to location of new story
	header("Location: createStory.php?id=". $story_id);
	}
	catch(Exception $e){
		echo $e;
	}
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


<?php include_once 'includes/header.php'; ?>
  <meta name="description" content="">
	<meta name="author" content="">
	
	<style type="text/css">
	h3 {margin-top:5px;margin-bottom:-11px;}
	</style>
</head>
<body>
  <?php include_once 'includes/nav_logged_in.php'; ?>
  
  
  
  
  
<div class="create_cont">

<div class="column firstColumn widgets_buttons">
<!--Widgets-->
  <div class="widgetses" id="widgets">  <!--left sidebar for widgets -->
	<p style="text-align: center; font-weight:bold; font-size:15px;">Drag To Canvas</p>

	<div class="drag_item" id="_text">Text</div>
	<div class="drag_item" id="_video">Video</div>
	<br>
	<div class="drag_item" id="_embedded">YouTube</div>
	<div class="drag_item" id="_picture">Picture</div>
	<br>
	<div class="drag_item" id="_audio">Audio</div>


  </div>
<!--End Widgets-->

  <div class="buttons" id="buttons">
	<button class="button saveButton" onclick="saveDraft()">Save Draft</button>
	<button class="button publishButton" onclick="finishStory()">Publish Story</button>
	<button class="button discardButton" onclick="discard()">Discard Draft</button>
  </div>

</div>

<div class="column secondColumn canvas_timeline" >

<div class="canvas" id="storyCanvas"></div>

<div class="timeline" id="slides">
      <h3 style="margin-top:0px;">Timeline</h3>
      <script src="js/timeline_functions.js" type="text/javascript"></script>
      <!-- need to add event listener below rather than depricated onclick() -->
      <button class="addButton" id="add_new_slide" onclick="addSlide(); return false;"></button>
      <div id="timelineWrapper">	     
	      <ul id="timelineSortable" class="slideSortParent">
	      <!-- this is where the slides will populate -->
	      </ul>
      </div>
</div>

</div>

<div class="column thirdColumn title_descr_attributes">

<div class="title_descr" id="title_descr">
  <h3>Title & Description<h3>
	<div>
	  <input class="title" type="text" name="storyTitle" id="title_input" placeholder="Title" title="Name your story" <?php if ($story_title != ""){echo "value='".$story_title."'";} ?>/>
	  <textarea class="description" rows="4" cols="" name="storyDesc" id="desc_input" placeholder="Description" title="Tell us what it's about"><?php if ($story_desc != ""){echo $story_desc;} ?></textarea>
	  <input class="tags" type="text" name="storyTags" id="tags_input" placeholder="Tags for search" <?php //if ($story_tags != ""){echo "value=".$story_tags;} ?> title="If you make your story public, users can search for it with these tags"/>
	</div>
</div>

<div class="attributes" id="attributes">
  <!--Attributes-->
	<h3>Widget Attributes</h3>
	<div id="widgetAttributes">
	</div>
  <!--End Attributes-->
</div>


</div>




</div>
<!--End Container-->
  
  
  
  
  
  
<script>
slide_array = new Array();		//javascript array to locally contain all the slides of the story

	//init blank associative array that is slide then append slide to slide_array
//var temp_slide = new Array();	
//temp_slide.push({id: 'id', position: 'slideNo', background_color: 'bkgd', thumbnail_path: 'thumb', widg_array: 'widgetArray'});

selected_wigdet = null;			//the widget that the user has clicked on -- start with nothing selected
selected_slide = null;          //the slide the user currently is viewing
current_slide = 1;				//the slide the user is looking at -- start at 1
widget_array = new Array();		//the array of widgets on CURRENT slide
id_counter = 0;
widg_clicked = false;
this_page = "create";
//num_layers = new Array();

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


  
<?php include_once 'includes/footer.php'; ?>
<script src="js/create/doc_ready.js"></script><!--only needed for createStory page -->

<script src="uploadify/jquery.uploadify.min.js" type="text/javascript" language="javascript"></script>
    <script src="js/create/widget_attr.js"></script>
	<script src="js/create/story_slide_saver.js"></script>
	<script src="js/create/drag_drop.js"></script>
	<script src="js/create/dialogs.js"></script>
	<script src="js/create/timeline.js"></script>
<script> var user_id="<?php echo $_SESSION['user_id']; ?>";</script>
<link rel="stylesheet" type="text/css" href="uploadify/uploadify.css" />

