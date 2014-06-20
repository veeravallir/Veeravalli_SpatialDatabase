<?php

//Establish connection to database.
$db = new mysqli('localhost', 'rveeravalli', 'teo7Pup0', 'rveeravalli');

//If no connection, then kill page
if($db->connect_errno > 0){
    die('Unable to connect to database [' . $db->connect_error . ']');
}

?>
