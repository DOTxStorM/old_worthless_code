<?php

include_once('includes/table_maker.php');
$query = 'SELECT * FROM user where user_name="testuser"';
make_table($query);



?>
