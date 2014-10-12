<?php 
include_once('includes/table_maker.php');

echo '<h1>All the Users in the Database</h1>';
make_table('SELECT * FROM user');