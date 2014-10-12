<?php

function open_connection() {
  // These are the credentials for the production database.
  // Modify these as needed when you need to work locally.
  $connection = mysql_connect('localhost','bmi_asb_service','883LJL43Up8aajnqv3wUB786Pnc7n43cNV6x2sT86q22DEJ3Yo');
  mysql_select_db('bmi_asb_ap01',$connection);
  return $connection;
}