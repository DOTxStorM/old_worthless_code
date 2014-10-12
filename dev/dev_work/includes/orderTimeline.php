<?php

/* this file handles the post each time a user re-orders a slide
 * in the timeline and updates the server of its new postiion
 */
 
 include_once 'open_connection.php';
 include_once 'slide_manager.php';
//connect to the DB
$mysqli = open_connection();
 
echo ($_POST['data']);



//need to parse from JSON back into array from post 
 $slideOrderArray = JSON.parse($_POST['data']);
 echo ($slideOrderArray);
/*
foreach ($slideOrderArray as $value)
{
	slideUpdatePosition($str_id, $slidePosition); //each new iteration through the array extracts the position and stores it in $value
	$slidePosition+=1; //this is going to need slide ID as well which will be referenced by $value
}
*/

//This array concept can be found at http://stackoverflow.com/questions/15633341/jquery-ui-sortable-then-write-order-into-a-database

?>