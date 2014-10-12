<?php
        
    /*
      seperates search tags into array 
     */
    function getTagsArray($p_search_string){
        $tags_array = explode(" ", $p_search_string);
        return $tags_array; 
    }
    
    function createStoryThumbnail($p_story_id, $p_thumbnail){
        if($p_thumbnail == ""){
            $p_thumbnail = "images/thumbnail.png";
        }
        $story_link = "play.php?id=$p_story_id";
        $thumbnail_string= '<a class= "thumbnail_link" href= "'.$story_link.'"><img class= "story_image" src= "'.$p_thumbnail.'"></a>';
        return $thumbnail_string;
    }
    function createStoryTitleLink($p_story_title, $p_story_id){
        $story_link = "play.php?id=$p_story_id";
        $story_title_string = '<h4 class= "story_title_header"><a class= "story_title_link" href= "'.$story_link.'">'.$p_story_title.'</a></h4>';
        return $story_title_string;
    }
    
    function createUserNameLink($p_user_name){
        $user_name_string = '<h5 class= "user_name"><a>by '.$p_user_name.'</a></h5>';
        return $user_name_string;
    }
    
        /*
        creates button for each story tag and inserts into tag row in results table
     */
    function createStoryTagButtons($p_story_tag_array){
        $num_tags = count($p_story_tag_array);
        $story_tag_string = "";
        $tag_overflow = FALSE;//true if story has more than 4 tags
       
        if($num_tags >= 5){
            $num_tags = 4;
            $tag_overflow = TRUE;
        }
         $story_tag_string .= '<ul class="nav nav-pills">';
        for($i = 0; $i < $num_tags; $i++){
                $tag_string = $p_story_tag_array[$i];
                $story_tag_string .= '<li><a name= "searchInput" href= "searchResults.php?searchInput='.$tag_string.'">'.$tag_string.'</li></a>';
        }
        $story_tag_string .= '</ul>';
        //onclick= "displayMoreTags('.$p_story_tag_array.')"
        //if there is a tag over flow, insert 'more icon' linkto display the rest of tags when pressed
        /*
        if($tag_overflow){
           $story_tag_string .= '<a class= "show_more_tags">';
           $story_tag_string .= '<span class= "Icon Icon--dots" title= "Show all tags" rel="tooltip" ></span></a>';
        }
        */
        return $story_tag_string;
    }
    
        /*
      creates favorite button for story result
     */
    function createFavoriteButton($p_story_id){
        $user_id = $_SESSION['user_id'];
        $is_favorite = isStoryFavorite($user_id, $p_story_id);//see if story is favorited by user
        $button_id = "favorite_button";
        $button_id .= $p_story_id;
        $num_favorited = get_story_attribute($p_story_id, "no_favorites");//number of times story has been favorited

        if($is_favorite){//story is users favorite, button displays option to unfavorite story
            $on_click_action = "unfavorite";
            $html_string = '<a class = "is_favorite" id = "'.$button_id.'" data-action = "unfavorite"  data-storyid = "'.$p_story_id.'" data-userid = "'.$user_id.'" onclick = "changeFavorite(\''.$button_id.'\')">';
            $html_string .= '<span class="fav_star_icon glyphicon glyphicon-star" title= "unFavorite" rel="tooltip" ></span>';
            $html_string .= '<span class= "num_favorited" title= "Favorited '.$num_favorited.' times" rel= "tooltip">'.$num_favorited.'</span></a>';
            return $html_string;
      
        }else{//story is not users favorite, button displays option to favorite story
            $on_click_action = "favorite";
            $html_string = '<a class = "not_favorite" id = "'.$button_id.'" data-action = "favorite" data-storyid = "'.$p_story_id.'" data-userid = "'.$user_id.'" onclick = "changeFavorite(\''.$button_id.'\')">';
            $html_string .= '<span class="fav_star_icon glyphicon glyphicon-star-empty" title= "Favorite" rel="tooltip"></span>';
            $html_string .= '<span class= "num_favorited" title= "Favorited '.$num_favorited.' times" rel= "tooltip">'.$num_favorited.'</span></a>';
            return $html_string;
        }      
    }
    
    /*
     * creates flag story option/icon
    */
    function createFlagButton($p_story_id){
        $user_id = $_SESSION['user_id'];
        $flag_id = "flag";//id of flag element
        $flag_id .= $p_story_id;
        $create_flag_string = '<a class= "flag_story not_flagged_state" id = "'.$flag_id.'" onclick= "setFlag('.$p_story_id.', '.$user_id.',\''.$flag_id.'\')" title= "Flag story as inappropriate" rel="tooltip">';
        $create_flag_string .= '<span class= "flag_icon glyphicon glyphicon-flag"></span></a>';
        return $create_flag_string;
    }
?>

