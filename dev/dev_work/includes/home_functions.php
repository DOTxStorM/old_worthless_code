<?php

    function displayLastFavStories(){
        $user_id = $_SESSION['user_id'];
        $last_fav_stories= get_stories_last_date_fav($user_id);
        
        while($row = mysqli_fetch_array($last_fav_stories)){
            $story_id = $row['story_ref_id'];
            $thumbnail = get_story_attribute($story_id, 'thumbnail_file_path');
            $story_title = get_story_attribute($story_id, 'str_title');
            $story_user_id = get_story_attribute($story_id, 'creator_id');
            $story_description = get_story_attribute($story_id, 'str_description');
            $story_user_name = get_user_info($story_user_id, 'user_name');
            echo '<div class= "story_wrapper">
                '.createStoryThumbnail($story_id, $thumbnail).'
                <div class= "main_content">
                    '.createStoryTitleLink($story_title, $story_id).'
                    '.createUserNameLink($story_user_name).'
                    <div class= "story_description_home">'.$story_description.'</div>
                    <div class= "favorite_home">
                        '.createFavoriteButton($story_id).'       
                    </div>
                </div>
            </div>';      
        }
    }
	
	   function displaySuggestedStories(){
        $user_id = $_SESSION['user_id'];
        $last_fav_stories= getSuggestedStories();
        
        while($row = mysqli_fetch_array($last_fav_stories)){
            $story_id = $row['str_id'];
            $thumbnail = get_story_attribute($story_id, 'thumbnail_file_path');
            $story_title = get_story_attribute($story_id, 'str_title');
            $story_user_id = get_story_attribute($story_id, 'creator_id');
            $story_description = get_story_attribute($story_id, 'str_description');
            $story_user_name = get_user_info($story_user_id, 'user_name');
            echo '<div class= "story_wrapper">
                '.createStoryThumbnail($story_id, $thumbnail).'
                <div class= "main_content">
                    '.createStoryTitleLink($story_title, $story_id).'
                    '.createUserNameLink($story_user_name).'
                    <div class= "story_description_home">'.$story_description.'</div>
                    <div class= "favorite_home">
                        '.createFavoriteButton($story_id).'       
                    </div>
                </div>
            </div>';      
        }
    }
    
    function displayRecentVideos(){
        $user_id = $_SESSION['user_id'];
        $list = get_stories_last_date_mod($user_id);

        while($row = mysqli_fetch_array($list)){
            $story_id = $row['str_id'];
            $thumbnail = get_story_attribute($story_id, 'thumbnail_file_path');
            $story_title = get_story_attribute($story_id, 'str_title');
            $story_user_id = get_story_attribute($story_id, 'creator_id');
            $story_description = get_story_attribute($story_id, 'str_description');
            $story_user_name = get_user_info($story_user_id, 'user_name');
            
            echo '<div class= "story_wrapper">
                '.createStoryThumbnail($story_id, $thumbnail).'
                <div class= "main_content">
                    '.createStoryTitleLink($story_title, $story_id).'
                    '.createUserNameLink($story_user_name).'
                    <div class= "story_description_home">'.$story_description.'</div>
                </div>
            </div>';
        }
    }
?>
