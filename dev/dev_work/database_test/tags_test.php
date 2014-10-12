<?php 
include_once('includes/table_maker.php');

echo '<h1>All Tags</h1>';
make_table( 'SELECT * FROM tags' );

?>