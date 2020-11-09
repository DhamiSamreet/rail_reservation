<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'Admin');
define('DB_PASSWORD', 'admin@123');
define('DB_NAME', 'ticket_booking');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
//echo 'database connected';
?>