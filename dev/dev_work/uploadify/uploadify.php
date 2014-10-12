<?php
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/

include_once '../includes/open_connection.php';
include_once '../includes/user_media_manager.php';
include_once '../includes/admin_media_manager.php';

//gets user id
$u_id = $_POST['userid'];

//gets table file is inserted into
$table = $_POST['table'];

// Define a destination
$targetFolder = '/bmi/www/storyblox.org_data/'; // Relative to /

if (!empty($_FILES)) {
	
	// Validate the file type
	$fileTypes = array('jpg','jpeg','gif','png','mp4','avi','mov','mp3','aac'); // File extensions
	$fileName = $_FILES['Filedata']['name'];
	$fileParts = pathinfo($fileName); 
	$fileExt = $fileParts['extension'];
	
	// Make fileName unique
	$fileName = uniqid() . $fileName;
	
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetFile = $targetFolder . $fileName;
	
	if (in_array($fileExt,$fileTypes)) {
		move_uploaded_file($tempFile,$targetFile);
		$filePath = $fileName;
		
		//gets type of media: image/video/audio
		$type = getMediaType($fileExt);
		
		//insert into DB
		//if admin upload
		if ($table == 'admin') {
			insertAdminWidget($type, $u_id, $filePath);
		} else {
			insertUserMedia($type, $u_id, $filePath);
		}
		
		echo $filePath;
	} else {
		echo 'Invalid file type.';
	}
}

//return media type given extension
function getMediaType($p_file_ext) {
	//image
	if(($p_file_ext== 'jpg') || ($p_file_ext== 'jpeg') || ($p_file_ext== 'png') || ($p_file_ext== 'gif')) {
		return 0;
	}
	//video
	else if (($p_file_ext== 'mp4') || ($p_file_ext== 'avi') || ($p_file_ext== 'mov')) {
		return 1;
	}
	//audio
	else {
		return 3;
	}
}
