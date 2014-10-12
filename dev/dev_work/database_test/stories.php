<?php

include_once('includes/table_maker.php');
$query = 'SELECT * FROM story ORDER BY date_modified DESC';
make_table($query);

?>
