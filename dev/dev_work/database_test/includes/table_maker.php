<?php
include_once('open_connection.php');

$connection = open_connection();
 

function make_table($query) {
  // Perform the query
  $result = mysql_query($query) or die('<h3 class="error">Error: Query is not good, love James</h3>');
  if(mysql_num_rows($result)) {
    echo '<table cellpadding="0" cellspacing="0" class="db-table">';
    
    // Get the column names
    echo '<tr class="header">';
    $i = 0;
    while( $i < mysql_num_fields($result)) {
      $field = mysql_fetch_field($result, $i);
      echo '<th>' . $field->name . '</th>';
      $i++; 
    }
    echo '</tr>';
    
    // Show the data
    $row_id = 1;
    while($row = mysql_fetch_row($result)) {
      echo '<tr id="'.$row_id.'" class="data">';
      foreach($row as $key=>$value) {
        $field = mysql_fetch_field($result, $key)->name;
        echo '<td class=', $field ,'>' , $value, '</td>';
      }
      echo '</tr>';
      $row_id++;
    }
    echo '</table><br />';
  }  
}

?>

<style>
  table.db-table    { border-right:1px solid #ccc; border-bottom:1px solid #ccc; width: 100%;}
  table.db-table th { background:#eee; padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc; }
  table.db-table td { padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc; word-break: break-word;}
</style>