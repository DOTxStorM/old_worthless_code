<?php
    /*
     * if search has been submitted set result table for current page, otherwise leave div empty
     */
    function createTable(){
     if(isset($_GET['searchInput'])){
           $search_string = filter_input(INPUT_GET, 'searchInput');
           $tag_array = getTagsArray($search_string);
           $page_num = getPageNum();
           $id_array = getStoryIds($page_num, $tag_array);
           setTable($id_array);  
       } 
       else{
           $search_string = "";
           return $search_string;
       }
    }
    /*
        sets the table to display search results for current page
    */   
    function setTable($p_story_ids){
        //get arrays containing titles, thumbnail file path, and story description for all story ids in results 
        $title_array = getAllTitles($p_story_ids);
        $thumbnail_array = getAllImages($p_story_ids);
        $description_array = getAllDescriptions($p_story_ids);
        $tags_array = getAllTagsForStories($p_story_ids);
        $user_name_array = getAllUserNames($p_story_ids);
        $num_results = count($p_story_ids);


        for($i = 0; $i < $num_results; $i++){//max results per table is 10
             //for each story: first row contains storytitle, 2nd row fist column is thumbnail, second row second column is story description
            //thumnail and title eventually link to view the story
            echo'<div class = "story_wrapper">
                '.createStoryThumbnail($p_story_ids[$i], $thumbnail_array[$i]).'
                    <div class = "main_content">
                        '.createStoryTitleLink($title_array[$i], $p_story_ids[$i]).'
                        '.createUserNameLink($user_name_array[$i]).'
                            <p class= story_description>'.$description_array[$i].'</p>
                            <div class= "story_tags">
                                '.createStoryTagButtons($tags_array[$i]).'
                            </div>
                            <div class= "favorite">
                                '.createFavoriteButton($p_story_ids[$i]).'       
                            </div>
                            <div class= "flag">
                                '.createFlagButton($p_story_ids[$i]).'
                            </div>         
                    </div>     
                </div>';
        }
    }
    
    /*
         sets pagelinks and next/previous links
      */ 
    function setPageLinks(){
        $current_page_num = getPageNum();
        $search_string = getSearchString();
        if($search_string == ""){
            return;
        }

        $tag_array = getTagsArray($search_string);
        $num_results = getNumResults($tag_array);
        
        if($num_results > 0){
            $num_pages = getNumPages($num_results);
        }else{
            $num_pages = 1;
        }
        echo '<script type = "text/javascript"> setPages('.$current_page_num.','.$num_pages.', "'.$search_string.'"); </script>';
        echo '<script type = "text/javascript"> setNext('.$current_page_num.', '.$num_pages.',"'.$search_string.'"); </script>';//set page number
        echo '<script type = "text/javascript"> setPrevious('.$current_page_num.',"'.$search_string.'"); </script>';//set page number
      
    }

    /*
        gets array of story titles from story ids to put into table title column
     */
    function getAllTitles($p_id_array){
        $num_results = count($p_id_array);
        $title_array = array($num_results);
        for($i = 0; $i < $num_results; $i++){
            $title_array[$i] = get_story_attribute($p_id_array[$i], 'str_title');
        }
        return $title_array;
    }
    
    /*
        gets array of thumbnail file paths from story ids to put into table image column
     */
    function getAllImages($p_id_array){
        $num_results = count($p_id_array);
        $thumbnail_array = array($num_results);
        for($i = 0; $i < $num_results; $i++){
            $thumbnail_array[$i] = get_story_attribute($p_id_array[$i], 'thumbnail_file_path');
        }
        return $thumbnail_array;
    } 
    
    /*
        gets array of story descriptions from story ids to put into table description column
     */
    function getAllDescriptions($p_id_array){
        $num_results = count($p_id_array);
        $description_array = array($num_results);
        for($i = 0; $i < $num_results; $i++){
            $description_array[$i] = get_story_attribute($p_id_array[$i], 'str_description');
        }
        return $description_array;
    }

    function getAllUserNames($p_id_array){
        $num_results = count($p_id_array);
        
        $user_name_array = array($num_results);
        
        for($i = 0; $i < $num_results; $i++){
            $user_id = get_story_attribute($p_id_array[$i], 'creator_id');
            $user_name_array[$i] = get_user_info($user_id, 'user_name' );
           // $user_name_array[$i] = decrypt($encrypted_user_name);
        }
        return  $user_name_array;
    }

    
    /*
        get array of each stories tag array to add to table
     */
    function getAllTagsForStories($p_id_array){
        $user_id = $_SESSION['user_id'];
        $num_results = count($p_id_array);
        $story_tags_array = array($num_results);
        for($i = 0; $i < $num_results; $i++){
            $story_tags_array[$i] = getTagsForStory($p_id_array[$i]);
        }
        return $story_tags_array;
    }

     /*
        gets an array of number of times each story has been favorited
     */
    function getAllNumFavorites($p_id_array){
        $num_results = count($p_id_array);
        $story_fav_array = array($num_results);
        for($i = 0; $i < $num_results; $i++){
            $story_fav_array[$i] = get_story_attribute($p_id_array[$i], 'no_favorites');
        }
        return $story_fav_array;
    }

    /*
      sets search bar text to search string or default text
     */
    function setSearchbarText(){
       if(isset($_GET['searchInput'])){
           echo htmlspecialchars($_GET['searchInput']);
        } else{//no search query entered, set text to default
           echo "Search by story name or tags";
       }
    }
    
    /*
      gets current page number to determine where database should start getting results for that page
     */
    function getPageNum(){
        if(isset($_GET['page'])){
            $page_number = filter_input(INPUT_GET, 'page');
            return $page_number;
        }else{
            return 1;
        }
    }
    
    /*
      get total number of results to display and determine how many page numbers to display 
     */
    function getNumResults($p_tags_array){
        $user_id = $_SESSION['user_id'];
        $num_results = tagQuerySize($p_tags_array,$user_id);
        return $num_results;          
    }
    
    /*
        
     */ 
    function getNumPages($p_num_results){
        $num_pages = ceil(($p_num_results/10));
        return $num_pages;
    }

    /*
      gets search input string
     */
    function getSearchString(){
        if(isset($_GET['searchInput'])){
            $search_string = filter_input(INPUT_GET, 'searchInput');
        }else{
            $search_string = "";
        }
        return $search_string;
    }

    
    /*
      get story ids(maximum 10 at a time) of stories that match search tag
     */
    function getStoryIds($p_page_num, $p_tags_array){
        $user_id = $_SESSION['user_id'];
        $id_array = getStoriesWithTag($user_id, $p_page_num, $p_tags_array);
        return $id_array;
    }
    
    /*
      display number of results above results table
     */
    function displayNumResults(){
        if(isset($_GET['searchInput'])){
            $search_string = filter_input(INPUT_GET, 'searchInput');
            $tags_array = getTagsArray($search_string);
            $num_results = getNumResults($tags_array);

            if($num_results > 0){
                echo ''.$num_results.' results found for '.$search_string.'';
                echo '<script type = "text/javascript"> displayNumResults(); </script>';
               
            }else{
                echo ' no results found for '.$search_string.'';
            }  
        }
    }
    ?>