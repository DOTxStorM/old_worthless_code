<?php
	include_once('../includes/table_maker.php');
	
	$query = "SELECT * FROM story WHERE draft_id IS NOT -1";
	make_table($query)
?>
