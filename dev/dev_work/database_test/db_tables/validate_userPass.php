<?php
	include_once('../includes/table_maker.php');
	
	$query = "SHOW COLUMNS FROM user LIKE 'user_password'";
	make_table($query)
?>
