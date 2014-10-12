<?php

include_once 'open_connection.php';
include_once 'user_manager.php';
include_once 'story_manager.php';
include_once 'slide_manager.php';
include_once 'image_widget_manager.php';
include_once 'media_widget_manager.php';
include_once 'text_widget_manager.php';
include_once 'tags_manager.php';
include_once 'favorites_manager.php';

function add(){

//insert_user('Mirabel', 'fruit1', 'apple@gmail.com', 0,0);
//insert_user('Matt', 'fruit2', 'banana@gmail.com', 0,0);

insert_story('Going to School', 'a story about going to school', '04/09/2014', '04/09/2014','', 0,0,0,0,0,1);
insert_story('Lets go to school', 'a story about going to the park', '04/08/2014', '04/09/2014','', 0,0,0,0,0,1);
insert_story('On the school bus', 'a story about getting a haircut', '04/07/2014', '04/09/2014','', 0,0,0,0,0,2);
insert_story('Running in the hallway', 'a story about running in the hallway ', '04/09/2014', '04/06/2014', '', 0,0,0,0,0,2);
 
addTag(1, 'school');
addTag(2, 'school');
addTag(3, 'school');
addTag(3, 'bus');
addTag(4, 'school');

add_favorite(5, 1, " ");
add_favorite(21, 1, " ");


}
?>