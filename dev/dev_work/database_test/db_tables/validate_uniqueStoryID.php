<?php
	include_once('..includes/table_maker.php')
	
	$query = "SELECT str_id, COUNT(*) AS Count
			  FROM story
			  GROUP BY str_id
			  HAVING COUNT(*) > 1";
	
	make_table($query)
?>