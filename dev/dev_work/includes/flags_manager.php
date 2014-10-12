<?php

    //add flag
    function addFlag($p_str_id, $p_user_id) {
        $con = open_connection();
        
        //increments no_of_flags in corresponding story
        $result = mysqli_query($con,"SELECT * FROM story WHERE str_id = '" . $p_str_id . "'");
        $row = mysqli_fetch_array($result);
        $no_of_flags = $row['no_of_flags'] + 1;
        update_story_no_of_flags($p_str_id, $no_of_flags);
        
        //inserts story into flags table
        mysqli_query($con, "INSERT INTO flags (story_ref_id, user_ref_id) 
        VALUES ('" . $p_str_id . "' , '" . $p_user_id . "')");
                     
        mysqli_close($con);
    }
    
    //remove a flag from the corresponding story
    function removeFlag($p_flag_id) {
        $con = open_connection();
        
        $result = mysqli_query($con,"SELECT * FROM flags WHERE flag_id = '" . $p_flag_id . "'");
        while($row = mysqli_fetch_array($result)) {
            $str_id = $row['story_ref_id'];
            decrementFlags($str_id);
            mysqli_query($con,"DELETE FROM flags WHERE flag_id = '" . $p_flag_id . "'");
        }
        
        mysqli_close($con);
    }
    
    //decrement the number of flags for a given story
    function decrementFlags($p_str_id){
        $con = open_connection();
        
        $result = mysqli_query($con,"SELECT * FROM story WHERE str_id = '" . $p_str_id . "'");
        $row = mysqli_fetch_array($result);
        $no_of_flags = $row['no_of_flags'] - 1;
        update_story_no_of_flags($p_str_id, $no_of_flags);
        
        mysqli_close($con);
    }
   //checks if a story is flagged by a user
    function isFlagged($p_str_id, $p_user_id) {
        $exists = false;
        $con = open_connection();
                     
        $result = mysqli_query($con,"SELECT * FROM flags WHERE story_ref_id = '". $p_str_id . "' AND user_ref_id = '" . $p_user_id . "'");
        $num_results = mysqli_num_rows($result);
        //checks if the story exists in the flags table
        if($num_results > 0){
            $exists = true;
        }
        return $exists;
    }

?>