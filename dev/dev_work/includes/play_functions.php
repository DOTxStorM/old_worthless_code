<?php
    function displayStoryDetails(){
        $story_id = getStoryId();
        $story_title = get_story_attribute($story_id, 'str_title');
        $story_user_id = get_story_attribute($story_id, 'creator_id');
        $story_tag_array = getTagsArray($story_title);

        echo '<div id= "main_content">
                <h3 id= "story_title">'.$story_title.'</h3>
                <div id= "story_info">
                    '.createStoryInfo($story_user_id, $story_id).'
                </div>  
                <div id= "story_options">
                    <div id= "favorite">
                        '.createFavoriteButton($story_id).'
                    </div>
                    <div id= "flag">
                        '.createFlagButton($story_id).'
                    </div>
                    <div id= "tag_content" style="white-space:nowrap">Tagged: 
                     '.createStoryTagButtons($story_tag_array).'
                    </div>
                </div>
        </div>';
    }
    
    function createStoryInfo($story_user_id, $story_id){
        $story_user_name = get_user_info($story_user_id, 'user_name');
        $story_description = get_story_attribute($story_id, 'str_description');
        $user_info_string = '<h5>by '.$story_user_name.'</h5>
        <img id= "profile_pic" src= "images/profile.png">
        <p id= "story_description">'.$story_description.'</p>';
        return $user_info_string;                                            
    }
    
    function getStoryId(){
        if(isset($_GET['id'])){
            $story_id= filter_input(INPUT_GET, 'id');
            return $story_id;
        }else{
            return "";
        }   
    }
    
    function displayStorySlides(){ 
        try{
            $story_id = getStoryId();
            //parse with JSON to produce a story array   this is sent to doc_ready
           $load_story_array = loadStory($story_id);
           echo '<script type="text/javascript"> displaySlides('.$load_story_array.'); </script>';
        }catch(Exception $e){
           echo 'Error loading story array from Database';
        }    
    }

?>
