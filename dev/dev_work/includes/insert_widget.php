<?php
include_once 'open_connection.php';
include_once 'image_widget_manager.php';
include_once 'media_widget_manager.php';
include_once 'text_widget_manager.php';
 
if(isset($_POST['json'])){
        try{
                
        $wid_obj = json_decode($_POST['json'], false);
        $w_id = -1;
        $err = "ERROR:";
        
        //checks type of object and inserts info into respective table
        switch($wid_obj[0]) {
        case 0:
                $w_id = insertImage($wid_obj[0], $wid_obj[1], $wid_obj[2], $wid_obj[3], $wid_obj[4], $wid_obj[5], $wid_obj[6],
                        $wid_obj[7], $wid_obj[9]);
                break;
        case 1:
        case 2:
        case 3:
                $w_id = insertMedia($wid_obj[0], $wid_obj[1], $wid_obj[2], $wid_obj[3], $wid_obj[4], $wid_obj[5], $wid_obj[6],
                        $wid_obj[7], $wid_obj[9]);
                break;
        case 4:
                $w_id = insertText($wid_obj[0],$wid_obj[1], $wid_obj[2], $wid_obj[9], $wid_obj[4], $wid_obj[5], $wid_obj[6],
                        $wid_obj[3], $wid_obj[10], $wid_obj[7]);
                break;
        default:
                echo  json_encode($err + " bad type");
                return;
                break;
        }
        }
        catch(Exception $e){
                echo  json_encode($err + " " + $e);
                return;
        }
        
        // Success
        if ($w_id != -1){
                echo json_encode($w_id);
                return;
        }
        else{
                echo  json_encode($err + " id not set");
                return;
        }
}
else {
        echo  json_encode($err + " post not set");
        return;
}