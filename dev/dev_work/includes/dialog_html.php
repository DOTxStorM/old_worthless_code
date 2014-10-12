<?php

include_once 'user_media_manager.php';
include_once 'open_connection.php';

if(isset($_POST['data']) && isset($_POST['type'])){
    try{
        if(json_decode($_POST['type']) == "picture"){
            $usr = json_decode($_POST['data'], false);
            $my_media = getAllUserMedia($usr);
            if($my_media == false){
                echo "<div class='media_item'>".
                    "<br><p class='none_text'>No media</p>".
                    "</div>";
            }
            foreach($my_media as $x){ 
                echo "<div class='media_item'>".
                    "<img src='//data-storyblox.omixorp.com/". $x ."'>".
                    "</div>";
            }
        }else{
            echo ("Not a picture");
        }
    }
    catch(Exception $e){
        echo ("ERROR: ". $e->getMessage());
        return;
    }
}else{
    echo ("ERROR: Post data not set.");
}
?>
