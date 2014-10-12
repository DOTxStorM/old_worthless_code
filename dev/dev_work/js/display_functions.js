        $(document).ready(function() {
             $("[rel='tooltip']").tooltip({placement: 'top'});
        }); 
        /**
         * changes if a story is favorited or not
         * @method changeFavorite
         * @param {int} p_button_id
         */
        function changeFavorite(p_button_id){
            var $fav_button_id = "#" + p_button_id;
            var $action = $($fav_button_id).attr("data-action");
            var $user_id = $($fav_button_id).data("userid");
            var $story_id = $($fav_button_id).data("storyid");
            var data = {action:$action, userId:$user_id, storyId:$story_id};
            
            $.ajax({
                url:"searchResults.php",
                type: 'POST',
                data:data,
                success: function(){
                    var $num_fav = parseInt($($fav_button_id).children(":nth-child(3)").text());
                    $($fav_button_id).children(":first").tooltip('hide'); //temporarily hide tooltip until flag is changed 
           
                    if($action === "favorite"){
                        $($fav_button_id).attr("data-action", "unfavorite");
                        $num_fav++;
                        $($fav_button_id).removeClass("not_favorite").addClass("is_favorite");//change link class from unfavoritedstate to favorited state
                        $($fav_button_id).children(":first").removeClass("glyphicon-star-empty").addClass("glyphicon-star");//change icon from filled star to unfilled star
                        $($fav_button_id).children(":first").attr('data-original-title', 'Unfavorite');
                    }else{
                        $num_fav--;
                        $($fav_button_id).attr("data-action", "favorite");
                        $($fav_button_id).removeClass("is_favorite").addClass("not_favorite");//change link class from unfavoritedstate to favorited state
                        $($fav_button_id).children(":first").removeClass("glyphicon-star").addClass("glyphicon-star-empty");//change icon from filled star to unfilled star
                        $($fav_button_id).children(":first").attr('data-original-title', 'Favorite');
                    }
                    var $num_fav_string= "Favorited " + $num_fav + " times";
                    $($fav_button_id).children(":nth-child(3)").text(String($num_fav));
                    $($fav_button_id).children(":nth-child(3)").attr('data-original-title', $num_fav_string);
                }
            });      
        }
            /**
     * called when story is flagged/unflagged , POSTS storyId, userID and flag action to be taken
     * @method setFlag
     */
    function setFlag(p_story_id, p_user_id, p_flag_id){
    	try {
            //alert("here");
            var flag = document.getElementById(p_flag_id);
            var $id = "#" + p_flag_id;
            var action = "";
            if(flag.className === "flag_story not_flagged_state"){
                action= "flag";
            }else if(flag.className === "flag_story flagged_state"){
                action= "unflag";
            }else{
                return;
            }
            var data = {
                storyId:p_story_id, userId:p_user_id, flagAction:action
            };
            $.ajax
                ({ 
                  cache: false,
                  type: "POST",
                  url: "searchResults.php",
                  data:data,
                  success: function(postData)
                  {
                       if(action === "flag"){
                           //alert("flag");
                          // $($id).children(":first").tooltip('hide');//temporarily hide tooltip until flag is changed
                            $($id).removeClass("flag_story not_flagged_state").addClass("flag_story flagged_state");//change link class from flagged to unflagged state
                            $($id).children((":first")).addClass("red");//remove red color from flag to indicate story is not flagged anymore
                            var $tooltip_text = "Story flagged as inappropriate";
                            $($id).attr('data-original-title', $tooltip_text);//change back tooltip
                       }else{
                             // $($id).children(":first").tooltip('hide');//temporarily hide tooltip until flag is changed
                            $($id).removeClass("flag_story flagged_state").addClass("flag_story not_flagged_state");//change link class from flagged to unflagged state
                            $($id).children((":first")).removeClass("red");//remove red color from flag to indicate story is not flagged anymore
                            var $tooltip_text = "Flag story as inappropriate";
                            $($id).attr('data-original-title', $tooltip_text);//change back tooltip
                       }
                        //alert("success");  
                     
                  }
            });
        
          
         }
    	catch (e) {
            log("searchResults.js", e.lineNumber, e);
    	}
    }
     $(document).ready(function(){   
        jQuery(document).on('click','.flag_story.flagged_state', function(e){
            //alert("here");
           
         }); 
    });
     
        
        
        
