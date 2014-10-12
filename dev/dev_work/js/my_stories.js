/**
 * show view of all stories
 * 
 * @class my_stories.js
 * 
 */


var numStories = 0;
var numFavs = 0;
var numMedia = 0;

$(document).ready(function(){
	// set up upload
	try{

    $('#file_upload').uploadify({
			'buttonText' : 'Add Media',
            'swf'      : '../uploadify/uploadify.swf',
            'uploader' : '../uploadify/uploadify.php',
			'formData': { 'userid': userid, 'table': 'user'},
            'auto'      : true,
			'onUploadSuccess' : function(file, data, response) {
				$('#media_holder').append('<div class="media_item"><img src=//data-storyblox.omixorp.com/'+data+'></div>');
			}
        });

		initializeDialog();

		// setup tooltip
		$("[rel='tooltip']").tooltip({placement: 'top'});
	}
	catch(e){
		//log("my_stories.js", e.lineNumber, e);
	}
});


/**
 * sends user to another window to create or edit story
 *
 * @method editStory
 *
 * @param {int} user ID
 *
 */


function editStory(id){
	try{
		window.location.href = "createStory.php?id=" + id;
	}
	catch(e){
		log("my_stories.js", e.lineNumber, e);
	}
}


/**
 * Deletes a story
 *
 * @method deleteStory
 *
 * @param {int} user ID
 *
 */
function deleteStory(id){
	try{
		// setup dialog
		confirmDelete(id);
	}
	catch(e){
		log("my_stories.js", e.lineNumber, e);
	}
}

/**
 * lets you view a story
 *
 * @method viewStory
 *
 * @param {int} user ID
 *
 */

function viewStory(id){
	try{

	}
	catch(e){

	}
}

/**
 * sets story to published or unpublished
 *
 * @method publisher
 *
 * @param {int} user ID
 * 
 * @param {int} 1 to unpublish. anything else to publish
 *
 */
function publisher(id, shared){
	try{
		if (shared == 1){
			pubber(id, "unpublish");
		}
		else{
			pubber(id, "publish");
		}

	}
	catch(e){
		log("my_stories.js", e.lineNumber, e);
	}
}


/**
 * lets you action a story
 *
 * @method pubber
 *
 * @param {int} user ID
 * 
 * @param {type} action
 *
 */
function pubber(id, action){
	try{
		$.post("includes/my_stories_lander.php",{
			type : action,
			story_id : id,
		}, function(result){
			if (result != "ERROR"){
				changePublishDisplay(id);
				setTimeout(function(){
					closeDialog();
				}, 2000);
			}
			else{
				openDialog("ERROR", "Your story couldn't be "+action+"d.");
				setTimeout(function(){
					closeDialog();
				}, 5000);
			}
		});
	}
	catch(e){
		log("my_stories.js", e.lineNumber, e);
	}
}


/**
 * changes the publish display
 * @method changePublishDisplay
 * @param {int} id
 */
function changePublishDisplay(id){
	try{

		// Pressed Published
		if ($('#pub_button'+id).hasClass("publish_button")){
			$('#pub_button'+id).removeClass("publish_button");
			$('#pub_button'+id).addClass("unpublish_button");
			// Icon
			$('#pub_button'+id).removeClass("glyphicon-share");
			$('#pub_button'+id).addClass("glyphicon-unchecked");
			// Title == tooltip
			$('#pub_button'+id).attr("data-original-title", 'Unpublish');
		}
		// Pressed Unpublish
		else if ($('#pub_button'+id).hasClass("unpublish_button")){
			$('#pub_button'+id).removeClass("unpublish_button");
			$('#pub_button'+id).addClass("publish_button");
			// Icon
			$('#pub_button'+id).removeClass("glyphicon-unchecked");
			$('#pub_button'+id).addClass("glyphicon-share");
			// Title == tooltip
			$('#pub_button'+id).attr("data-original-title", 'Publish');

		}
	}
	catch(e){
		log("my_stories.js", e.lineNumber, e);
	}
}

/**
 * confirms deletion of story
 * @method confirmDelete
 * @param {int} id
 */
function confirmDelete(id){
	try{
	/*	$dialog.dialog({
			resizable: false,
			height:140,
			modal: true,
			buttons: {
				"Delete": function() {
					sendDelete(id);
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			}
		});

		openDialog("Confirm","Are you sure you want to delete this story?");*/
		sendDelete(id);

	}
	catch(e){
		log("my_stories.js", e.lineNumber, e);
	}
}

/**
 * tells you if story has been deleted or not
 * @method send Delete
 * @param {int} id
 */
function sendDelete(id){
	try{
		// Show loading gif while deleting
		//changeDialogContent('Deleting Story...', '<br><img height=50 src="images/loading.gif"/>');

		$.post("includes/my_stories_lander.php",{
			type : 'delete',
			story_id : id,
		}, function(result){
			if (result != "ERROR"){
				//changeDialogContent("Success!", "Story Deleted.");
				localDelete(id);
				setTimeout(function(){
					closeDialog();
				}, 2000);
			}
			else{
				//changeDialogContent("ERROR", "Your story couldn't be deleted.");
				setTimeout(function(){
					closeDialog();
				}, 5000);
			}
		});
	}
	catch(e){
		log("my_stories.js", e.lineNumber, e);
	}
}

/**
 * deletes a story locally 
 * @method localDelete
 * @param {int} id
 */
function localDelete(id){
	try{
		$('#mine'+id).remove();
		--numStories;

		if (numStories < 1){
			$noStories = ("<div class='story_item'>"+
					"<br><p class='none_text'>No Stories</p>"+
			"</div>");
			$noStories.appendTo("#my_stories_holder");
		}
	}
	catch(e){
		log("my_stories.js", e.lineNumber, e);
	}
}

function unfavoriteStory(id){
	try{
		sendUnfav(id);
	}
	catch(e){
		log("my_stories.js", e.lineNumber, e);
	}
}

function sendUnfav(id){
	try{
		$.post("includes/my_stories_lander.php",{
			type : 'unfavorite',
			userid : userid,
			story_id : id,
		}, function(result){
			if (result != "ERROR"){
				localUnfav(id);
			}
			else{
				/*openDialog("ERROR", "Your story couldn't be "+action+"d.");
				setTimeout(function(){
					closeDialog();
				}, 5000);*/
			}
		});
	}
	catch(e){
		log("my_stories.js", e.lineNumber, e);
	}
}

function localUnfav(id){
	try{
		$('#fav'+id).remove();
		--numFavs;

		if (numFavs < 1){
			$noStories = ("<div class='story_item'>"+
					"<br><p class='none_text'>No Stories</p>"+
			"</div>");
			$noStories.appendTo("#my_favorites_holder");
		}
	}
	catch(e){
		log("my_stories.js", e.lineNumber, e);
	}
}

