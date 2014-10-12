<?php

//insert admin media
function insertAdminWidget($p_type, $p_admin_id, $p_file_path)
{
	$con = open_connection();
    mysqli_query($con,"INSERT INTO widget_admin(type, admin_ref_id, file_path)
    VALUES ('" . $p_type . "','" . $p_admin_id . "', '" . $p_file_path ."')");
	$admin_widget_id = mysqli_insert_id($con);
	mysqli_close($con);
	return $admin_widget_id;
}
                 
//delete admin widget
function deleteAdminWidget($p_id)
{
    $con = open_connection();
    $result = mysqli_query($con, "DELETE FROM widget_admin WHERE widget_id = '" . $p_id . "'");
    mysqli_close($con);
}
                 
//get all the admins widget files
function getAllAdminWidgets($p_id){
    $con = open_connection();
    $result = mysqli_query($con, "SELECT * FROM widget_admin WHERE admin_ref_id = '" . $p_id . "'");
    $all_admin_media = array();
    while($row = mysqli_fetch_array($result)) {
        array_push($all_admin_media, $row['file_path']);
    }
    mysqli_close($con);
    return $all_admin_media;
}
                 
//get the admin media widget files
function getAdminMedia($p_id){
    $con = open_connection();
    $result = mysqli_query($con, "SELECT * FROM widget_admin WHERE admin_ref_id = '" . $p_id . "' AND type = 1");
    $all_admin_media = array();
    while($row = mysqli_fetch_array($result)) {
        array_push($all_admin_media, $row['file_path']);
    }
    mysqli_close($con);
    return $all_admin_media;
}
                 
//get the admin audio widget files
function getAdminAudio($p_id){
    $con = open_connection();
    $result = mysqli_query($con, "SELECT * FROM widget_admin WHERE admin_ref_id = '" . $p_id . "' AND type = 3");
    $all_admin_media = array();
    while($row = mysqli_fetch_array($result)) {
        array_push($all_admin_media, $row['file_path']);
    }
    mysqli_close($con);
    return $all_admin_media;
}
                 
//get the admin image widget files
function getAdminImages($p_id){
    $con = open_connection();
    $result = mysqli_query($con, "SELECT * FROM widget_admin WHERE admin_ref_id = '" . $p_id . "' AND type = 0");
    $all_admin_media = array();
    while($row = mysqli_fetch_array($result)) {
        array_push($all_admin_media, $row['file_path']);
    }
    mysqli_close($con);
    return $all_admin_media;
}

?>
