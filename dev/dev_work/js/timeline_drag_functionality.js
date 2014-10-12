
/**
 * file to handle jQuery drag and drop in the timeline
 * @class timeline_drag_functionality
 */


$(function() {
	try{
	    $( "#timelineSortable" ).sortable({
	      revert: true
	    });
	    $( "#draggable" ).draggable({
	      connectToSortable: "#sortable",
	      helper: "clone",
	      revert: "invalid"
	    });
	    $( "ul, li" ).disableSelection();
	  }
	  catch(e){
		log("timeline_drag_functionality.js", e.lineNumber, e);
	}});

	
	$(document).ready(function(){
	try{
	    $("#timelineSortable").sortable({
	        stop : function(event, ui){
	          //alert($(this).sortable('serialize')); //this captures the order of slides after mouseUp
	          //use AJAX to post to orderTimeline.php
	          $.post({   //does this need to stay in createStory.php? needs to send returned array over to orderTimeline.php
		            data: data,
		            type: 'POST',
		            url: 'includes/orderTimeline.php'
		        });
	        }
	    });
	  	$("#sortable").disableSelection();
	}
	catch(e){
		log("timeline_drag_functionality.js", e.lineNumber, e);
	}});//ready
