<?php
	include_once('../includes/table_maker.php');
	
	$query = "SHOW COLUMNS FROM story LIKE 'creator_id'";
	make_table($query)
?>
